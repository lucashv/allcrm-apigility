<?php
namespace crm\V1\Rest\Email;

use crm\V1\Rest\AbstractService\AbstractService;
use Doctrine\ORM\EntityManager;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;
use crm\V1\Rest\TelefonesContato\TelefonesContatoService;
use crm\V1\Rest\Filter\TelefoneFilter as TelefoneFilter;
/**
 * Classe responsav�l pelo envio de emails aos corretores;
 * Class EmailService
 */
class EmailService extends AbstractService
{

    protected $message;
    protected $mimePart;
    protected $mimeMessage;
    protected $smtTransport;
    protected $smtpOptions;
    private   $configMail;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    protected $telefonesContatoService;
    private   $emailValidator;
    private   $logger;
    private   $corretor;
    private   $contato;
    private   $tipoEnvio;
    private   $telefones;
    private   $emails;
    private   $obsEnvio;


    public function __construct($em,Message $message, MimePart $mimePart, MimeMessage $mimeMessage, SmtTransport $smtTransport, SmtpOptions $smtpOptions, $config,TelefonesContatoService  $telefonesContatoService, $emailValidator, $logger)
    {
        $this->em           = $em;
        $this->message      = $message;

        $this->mimePart     = $mimePart;
        $this->mimeMessage  = $mimeMessage;
        $this->smtTransport = $smtTransport;
        $this->smtpOptions  = $smtpOptions;
        $this->configMail   = $config['email'];
        $this->smtpOptions  = new $smtpOptions([
            'name'=> $this->configMail['host'],
            'host' => $this->configMail['host'],
            'connection_class' => $this->configMail['auth'],
            'port'=> $this->configMail['port'],
            'connection_config' => array(
                'username' => $this->configMail['username'],
                'password' => $this->configMail['password']

            )
        ]);
        $this->telefonesContatoService = $telefonesContatoService;
        $this->emailValidator = $emailValidator;
        $this->logger = $logger;
     }

    /**
     * @param bool|false $data
     * @return bool
     */
    public function enviaIndicacao($data = false, $isReenvio = true)
    {


        if($data) {
            $this->setObsEnvio($data->getObservacaoEnvio());
        }

         if(  $isReenvio )
         {
             $this->setContato($data->getContato()->getId());
             $this->setCorretor($data->getCorretor()->getId());
             $this->setTipoEnvio($data->getTipoEnvio()->getId());
             if( !$this->validaEmailValido($data->getCorretor()->getEmail())) {
                 $this->logger->log('email.log', "Erro ao enviar email para : {$this->getCorretor()->getEmail()} Id Usuario : {$this->getCorretor()->getId()} - IdContato :{$this->getContato()->getId()} ");
                 return false;
             }
         }

        try{

            if($this->setCabecalhoEmail()) {
                $htmlEmail = $this->montaEmail();
                $html  = new $this->mimePart($htmlEmail);
                $html->type = "text/html";
                $this->mimeMessage = new $this->mimeMessage;
                $this->mimeMessage->setParts(array($html));
                $this->message->setBody(   $this->mimeMessage);
                $transport = new $this->smtTransport();
                $transport->setOptions($this->smtpOptions);
                $transport->send($this->message);
                return true;
            };
            return true;

        } catch(\Exception $e) {

            $this->logger->log('email.log', "Erro ao enviar email para : {$this->getCorretor()->getEmail()} Id Usuario : {$this->getCorretor()->getId()} - {$e->getMessage()}");
            die(var_dump($e->getMessage()));
            return false;
        }
     }

    private function validaEmailValido($email)
    {

        if($this->emailValidator->isValid($email)) {
            return true;
        }
        return false;
    }

    private function montaEmail()
    {
        $data              = (object) array();
        $emails            = $this->getEmeils();
        $telefones         = $this->getTelefones();
        $data->telefones   = $telefones;
        $data->emails      = $emails;


        $htmlEmail ="<h1 '>Indica&ccedil;&atilde;o:</h1>
                         <p>Nome :<b> {$this->getContato()->getNome()}</b></p>
                         Email : ";


        foreach($emails as $email) {
            $htmlEmail.= "<br><b>{$email->getEmail()}</b>";
        }

        $htmlEmail.= "<br><br>Telefone: ";


        foreach($telefones as $telefone) {
            $telefone =  TelefoneFilter::formataTelefone('(##)####-####',$telefone->getTelefone());
            $htmlEmail.= "<br><b>{$telefone}</b>";
        }

        $htmlEmail.= "<br><br>Favor interagir sobre a Lead no link :<i> <a href='http://crm.allcross.com.br/#/app/contatos/detalhes/{$this->getContato()->getId()}'> Interagir</a> </i>";
        $htmlEmail.= "<br><br>Email recebido em : <b>{$this->getDataAtual()}</b>";
        return $htmlEmail;
    }

    private function setCabecalhoEmail()
    {
        $filial = $this->getCorretor()->getFilial()->getId();

        try{

            $this->message->addTo($this->getCorretor()->getEmail())
                          ->addFrom('indicacoes@allcross.com.br')
                          ->addBcc("tiago.alves@allcross.com.br")
                          ->setSubject( ("Indicação: Nº:") .  "{$this->getContato()->getId()} | Grupo AllCross | Tipo: {$this->getTipoEnvio()->getTipoEnvio()}  | {$this->getObsEnvio()}")  ;
            $this->message->setEncoding("UTF-8");

            if($filial === 16) {
                $this->message->addTo('gerencia@premiercorretora.net');
            }

            $headers = $this->message->getHeaders();
            $headers->removeHeader('Content-Type');
            $headers->addHeaderLine('Content-Type', 'text/html; charset=UTF-8');
            $headers->addHeaderLine("X-Mailer: PHP/" . phpversion ());
            return true;

        }catch (\Exception $e) {

            $this->logger->log('email.log', "Erro ao enviar email para : {$this->getCorretor()->getEmail()} Id Usuario : {$this->getCorretor()->getId()} - {$e->getMessage()}");
            die(var_dump($e->getMessage()));
            return false;
        }
    }

    private function getTelefones()
    {
       $this->telefones = $this->em->getRepository('crm\Entity\TelefonesContato')->findBy(array('contato' => $this->getContato()->getId()));
        return $this->telefones;

    }

    private function getEmeils()
    {
      $this->emails =  $this->em->getRepository('crm\Entity\EmailsContato')->findBy(array('contato' => $this->getContato()->getId()));
      return $this->emails;

    }

    public function reenvioIndicacao($data)
    {
        $this->setContato($data->idContato)
             ->setCorretor($data->idCorretor);


        if( !$this->validaEmailValido($this->getCorretor()->getEmail() )) {
            $this->logger->log('email.log', "Erro ao enviar email para : {$this->getCorretor()->getEmail()} Id Usuario : {$this->getCorretor()->getId()}");
            return false;
        }

        $this->setTipoEnvio($data->idTipoEnvio);


        if($this->enviaIndicacao(false,false)) {
            return true;
        }
        return false;
    }

    private function setContato($idContato)
    {
        $contato = $this->em->getRepository('crm\Entity\Contatos')->findBy(array('id' => $idContato));
        $this->contato = $contato[0];
        return  $this;
    }

    private function setCorretor($idCorretor)
    {
        $corretor = $this->em->getRepository('crm\Entity\Usuarios')->findBy(array('id' => $idCorretor));
        $this->corretor = $corretor[0];

        return $this;
    }

    private function setTipoEnvio($idTipoEnvio)
    {
        //Caso não tenha o tipo do envio setado seta 6 - Reenvio
        $idTipoEnvio =  isset($idTipoEnvio) ?  $idTipoEnvio : 6;
        $tipoEnvio = $this->em->getRepository('crm\Entity\TiposEnvio')->findBy(array('id' => $idTipoEnvio));
        $this->tipoEnvio = $tipoEnvio[0];
        return $this;
    }

    private function getTipoEnvio()
    {
        return $this->tipoEnvio;
    }

    private function getContato()
    {
        return $this->contato;
    }

    private function getCorretor()
    {
        return $this->corretor;
    }

    /**
     * @return mixed
     */
    public function getObsEnvio()
    {
        return $this->obsEnvio;
    }

    /**
     * @param mixed $obsEnvio
     * @return EmailService
     */
    public function setObsEnvio($obsEnvio)
    {
        $this->obsEnvio = $obsEnvio;
        return $this;
    }






}