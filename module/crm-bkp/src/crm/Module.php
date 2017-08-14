<?php
namespace crm;



use crm\Entity\AgendaUsuario;
use crm\Entity\ContatoCorretorBloqueio;
use crm\Entity\EmailsContato;
use crm\Entity\Filiais;
use crm\Entity\InteracoesContato;
use crm\Entity\ModulosPermissoes;
use crm\Entity\Operadoras;
use crm\Entity\OutrasOrigensInteracoes;
use crm\Entity\Plantoes;
use crm\Entity\SituacoesInteracoes;
use crm\Entity\TelefonesContato;
use crm\Entity\TiposEnvio;
use crm\Entity\TiposLigacao;
use crm\Entity\TiposPlantoes;
use crm\V1\Rest\Acl\AclService;
use crm\V1\Rest\AgendaUsuario\AgendaUsuarioFactory;
use crm\V1\Rest\AgendaUsuario\AgendaUsuarioRelatorio;
use crm\V1\Rest\Contato\ContatoService;
use crm\V1\Rest\ContatoCorretorBloqueio\ContatoBloqueioFactory;
use crm\V1\Rest\ContatoCorretorBloqueio\ContatoCorretorBloqueioService;
use crm\V1\Rest\Contatos\ContatosFactory;
use crm\V1\Rest\Corretores\CorretoresService;
use crm\V1\Rest\Cron\CronBloqueiaCorretor;
use crm\V1\Rest\Cron\CronService;
use crm\V1\Rest\EmailsContato\EmailContatoService;
use crm\V1\Rest\Filiais\FiliaisService;
use crm\V1\Rest\Fornecedores\FornecedoresService;
use crm\V1\Rest\GestoNacionalDashBoard\GestorNacionalDashBoardService;
use crm\V1\Rest\Interacoes\InteracoesFactory;
use crm\V1\Rest\Interacoes\InteracoesService;
use crm\V1\Rest\Logger\Logger;
use crm\V1\Rest\Operadoras\OperadorasService;
use crm\V1\Rest\OrigensInteracoes\OrigensInteracoesService;
use crm\V1\Rest\OutrasOrigensContato\OutrasOrigensContatoService;
use crm\V1\Rest\PermissoesAcesso\PermissoesAcessoService;
use crm\V1\Rest\Plantoes\AbstractPlantaoFactory;
use crm\V1\Rest\Plantoes\PlantoesService;
use crm\V1\Rest\Sites\SitesService;
use crm\V1\Rest\SituacoesContato\SituacoesContatoService;
use crm\V1\Rest\TelefonesContato\TelefonesContatoFactory;
use crm\V1\Rest\TelefonesContato\TelefonesContatoService;
use crm\V1\Rest\TiposLigacao\TiposLigacaoService;
use crm\V1\Rest\TiposPlantoes\TipoPlantoesService;
use Zend\ServiceManager\ServiceManager;
use ZF\Apigility\Provider\ApigilityProviderInterface;
use crm\V1\Rest\AuthLDAP\AuthLDAPService;
use Zend\Authentication\AuthenticationService;
use Zend\Config\Reader\Ini as ConfigReader;
use Zend\Config\Config;
use Zend\Mail;
use Zend\Uri\UriFactory;
use crm\Entity\Usuarios as UsuariosEntity;
use Zend\Stdlib\Hydrator;
use crm\Entity\Contatos as ContatoEntity;
use crm\V1\Rest\Contatos\ContatosService;
use crm\V1\Rest\Usuarios\UsuarioService as UserService;
use crm\Entity\Fornecedores as FornecedoresEntity;
use crm\Entity\Sites as SitesEntity;
use crm\V1\Rest\SituacoesInteracoes\SituacoesInteracoesService;
use Zend\Mail\Message;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;
use Zend\Mail\Transport\Smtp as SmtTransport;
use Zend\Mail\Transport\SmtpOptions;
use crm\V1\Rest\Email\EmailService;
use crm\V1\Rest\TiposEnvios\TiposEnviosService;
use crm\V1\Rest\AgendaUsuario\AgendaUsuarioService;
use Zend\Mvc\MvcEvent;
use crm\V1\Rest\TipoPropostaOperadora\TipoPropostaService;


class Module implements ApigilityProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        ##só habilitar para usar no app.
//        $eventManager        = $e->getApplication()->getEventManager();
//        $headers =           $e->getRequest()->getHeaders();
//
//        if ($headers->has('Origin') )
//        {
//            //convert to array because get method throw an exception
//            $headersArray = $headers->toArray();
//            $origin = $headersArray['Origin'];
//            if ($origin === 'file://') {
//                unset($headersArray['Origin']);
//                $headers->clearHeaders();
//                $headers->addHeaders($headersArray);
//                //this is a valid uri
//                $headers->addHeaderLine('Origin', 'file://mobile');
//            }
//        }
        UriFactory::registerScheme('chrome-extension', 'Zend\Uri\Uri');
    }

    public function getAutoloaderConfig()
    {
        return array(
            'ZF\Apigility\Autoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'AuthLDAPService' => function($sm) {
                    $configReader          = new ConfigReader();
                    $configData            = $configReader->fromFile('./config/ldap-config.ini');
                    $config                = new Config($configData, true);
                    $authenticationService = new AuthenticationService();
                    $usuarioService        = $sm->get('UsuariosService');
                    $authLDAPService       = new AuthLDAPService($config,$authenticationService, $usuarioService);
                    return $authLDAPService;
                },
                'ContatosService' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator = new Hydrator\ClassMethods();
                    $contatoEntity = new ContatoEntity();
                    $contatoFactory = $sm->get('ContatoFactory');
                    $interacoesFactory = $sm->get('InteracoesFactory');
                    return new ContatosService($em, $hydrator,$contatoEntity,$contatoFactory, $interacoesFactory);
                },
                'ContatoBloqueioService' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $contatoBloqueioService = $sm->get('ContatoBloqueioFactory');
                    return  new ContatoCorretorBloqueioService($em,$contatoBloqueioService);
                },
                'ContatoBloqueioFactory' => function($sm) {
                  $em = $sm->get('Doctrine\ORM\EntityManager');
                  return new ContatoBloqueioFactory($em, new ContatoCorretorBloqueio());
                },
                'CronBloqueiaCorretor' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $contatoBloqueioService = $sm->get('ContatoBloqueioService');
                    return new CronBloqueiaCorretor($em,new Logger(),$contatoBloqueioService);
                },
                'cronService' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $contatoCorretorBloqueioService = $sm->get('ContatoBloqueioService');
                    return new CronService($em, new Logger(), $contatoCorretorBloqueioService);
                },
                'FiliaisService' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');

                    return new FiliaisService($em);
                },
                'GestorNacionalDashBoardService' =>  function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    return new GestorNacionalDashBoardService($em);
                },
                'UsuariosService' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator = new Hydrator\ClassMethods();
                    $usuarioEntity = new UsuariosEntity();
                    $filialService         = $sm->get('FiliaisService');
                    $userService   = new UserService($em,$hydrator,$usuarioEntity,$filialService);
                    return $userService;
                },
                'CorretoresService' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator = new Hydrator\ClassMethods();
                    $corretorEntity = new UsuariosEntity();
                    return new CorretoresService($em,$hydrator,$corretorEntity );
                },
                'FornecedoresService' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator = new Hydrator\ClassMethods();
                    $fornecedorEntity = new FornecedoresEntity();
                    return new FornecedoresService($em,$hydrator,$fornecedorEntity);
                },
                'SituacoesInteracoes' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator = new Hydrator\ClassMethods();
                    $situacoesContatoEntity = new SituacoesInteracoes();
                    return new SituacoesInteracoesService($em,$hydrator,$situacoesContatoEntity);
                },
                'OrigensInteracoes' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator = new Hydrator\ClassMethods();
                    return new OrigensInteracoesService($em,$hydrator);
                },
                'SitesService' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator = new Hydrator\ClassMethods();
                    $sitesEntity = new SitesEntity();
                    return new SitesService($em,$hydrator,$sitesEntity);
                },
                'InteracoesService' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator = new Hydrator\ClassMethods();
                    $interacoesEntity = new InteracoesContato();
                    $situacoesInteracoesService = $sm->get('SituacoesInteracoes');
                    $origemInteracoesService = $sm->get('OrigensInteracoes');
                    $contatoService = $sm->get('ContatosService');
                    $usuarioService = $sm->get('UsuariosService');
                    $emailService   = $sm->get('EmailService');
                    return new InteracoesService($em,$hydrator,$interacoesEntity,$situacoesInteracoesService, $origemInteracoesService, $contatoService, $usuarioService,$emailService);
                },
                'EmailService' => function($sm) {
                    $em           = $sm->get('Doctrine\ORM\EntityManager');
                    $message      = new Message('UTF-8');
                    $mimePart     = new MimePart();
                    $mimeMessagem = new MimeMessage();
                    $smtTransport = new SmtTransport();
                    $smtpOptions  = new SmtpOptions();
                    $config       = $sm->get('Config');
                    $telefonesContatoService = $sm->get('TelefonesContatoService');
                    $emailValidator = new  \Zend\Validator\EmailAddress();
                    $logger = new Logger();
                    return new EmailService($em,$message,$mimePart,$mimeMessagem,$smtTransport,$smtpOptions,$config,$telefonesContatoService,$emailValidator, $logger);
                },
                'EmailContatoService' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator = new Hydrator\ClassMethods();
                    $emailContato = new EmailsContato();
                    return new EmailContatoService($em,$hydrator,$emailContato);
                },
                'TelefonesContatoService' => function($sm) {
                    $em =  $sm->get('Doctrine\ORM\EntityManager');
                    return new TelefonesContatoService($em, $sm);
                },
                'OperadorasService' => function($sm) {
                    $em =  $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator = $hydrator = new Hydrator\ClassMethods();
                    $operadoraEntity = new Operadoras();
                    return new OperadorasService($em,$hydrator, $operadoraEntity);
                },
                'PlantoesService' => function($sm) {
                    $em =  $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator = $hydrator = new Hydrator\ClassMethods();
                    $plantoesEntity = new Plantoes();
                    $abstractPlantoesFactory = $sm->get('AbstractPlantoesFactory');
                    return new PlantoesService($em,$hydrator,$plantoesEntity, $abstractPlantoesFactory);
                },
                'TiposPlantoesService' => function($sm) {
                    $em =  $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator = $hydrator = new Hydrator\ClassMethods();
                    $tipoPlantoesEntity = new TiposPlantoes();
                    return new TipoPlantoesService($em,$hydrator,$tipoPlantoesEntity);

                },
                'FiliaisService' => function($sm) {
                    $em =  $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator = $hydrator = new Hydrator\ClassMethods();
                    $filialEntity = new Filiais();
                    return new FiliaisService($em, $hydrator, $filialEntity);
                },
                'ModulosPermissaoAcessoService' => function($sm) {
                    $em                      = $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator                = $hydrator = new Hydrator\ClassMethods();
                    $modolusPermissoesAcesso = new ModulosPermissoes();
                    return new PermissoesAcessoService($em,$hydrator, $modolusPermissoesAcesso);
                },
                'TiposLigacoes' => function($sm) {
                    $em                      = $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator                = $hydrator = new Hydrator\ClassMethods();
                    $tiposLigacoes = new TiposLigacao();
                    return new TiposLigacaoService($em,$hydrator,$tiposLigacoes);
                },
                'AbstractPlantoesFactory' => function ($sm){
                    $em        = $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator  = $hydrator = new Hydrator\ClassMethods();
                    $plantoesEntity = new Plantoes();
                    return new AbstractPlantaoFactory($em,$hydrator, $sm,$plantoesEntity);
                 },
                'ContatoFactory' => function($sm) {
                    $em        = $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator  = $hydrator = new Hydrator\ClassMethods();
                    $contatoEntity = new ContatoEntity();
                    return new ContatosFactory($em,$hydrator,$sm,$contatoEntity);
                },
                'InteracoesFactory' => function($sm) {
                    $em        = $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator  = $hydrator = new Hydrator\ClassMethods();
                    $interacoesEntity = new InteracoesContato();
                    return new InteracoesFactory($em,$hydrator,$sm,$interacoesEntity);
                },
                'TiposEnviosService' => function($sm) {
                    $em        = $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator  = $hydrator = new Hydrator\ClassMethods();
                    $tiposEnviosEntity = new TiposEnvio();
                    return new TiposEnviosService($em,$hydrator,$tiposEnviosEntity);
                },
                'AclService' => function($sm) {
                    $em        = $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator  = $hydrator = new Hydrator\ClassMethods();
                    $modulosPermissoes = new ModulosPermissoes();
                    return new AclService($em,$hydrator,$modulosPermissoes);
                },
                'TelefoneFactory' => function($sm) {
                    $em        = $sm->get('Doctrine\ORM\EntityManager');
                    $hydrator  = new Hydrator\ClassMethods();
                    $telefoneContatoEntity =  new TelefonesContato();
                    return new TelefonesContatoFactory($em,$hydrator,$sm,$telefoneContatoEntity);
                },
                'AgendaUsuarioService' => function($sm) {
                    $em        = $sm->get('Doctrine\ORM\EntityManager');
                    $agendaUsuarioFactory = $sm->get('AgendaUsuarioFactory');
                    $hydratoror = new Hydrator\ClassMethods();
                    $agendaRelatorio = new AgendaUsuarioRelatorio();
                    return new AgendaUsuarioService($em,$hydratoror,$agendaUsuarioFactory, $agendaRelatorio );
                },
                'AgendaUsuarioFactory' => function($sm) {
                    $em  = $sm->get('Doctrine\ORM\EntityManager');
                    $agendaUsuario = new AgendaUsuario();
                    return new AgendaUsuarioFactory($agendaUsuario,$em);
                },
                'TipoPropostaService' => function($sm) {
                    $em  = $sm->get('Doctrine\ORM\EntityManager');
                    return new TipoPropostaService($em);
                }

            )
        );
    }
}
