<?php


namespace crm\V1\Rest\Usuarios;

use crm\Entity\Usuarios;
use crm\V1\Rest\AbstractService\AbstractService;
use crm\Entity\Perfil as PerfilEntity;
use ZF\ApiProblem\ApiProblem;

class UsuarioService extends AbstractService
{

    protected $repository;
    /**
     * @var \crm\V1\Rest\Filiais\FilialService
     */
    protected $filialService;

    public function __construct($em,$hydrator,Usuarios $usuarioEntity, $filialService)
    {
        $this->em         = $em;
        $this->hydrator   = $hydrator;
        $this->userEntity = $usuarioEntity;
        $this->repository = 'crm\Entity\Usuarios';
        $this->filialService = $filialService;
    }

    public function create($data)
    {
        $data = $this->montaUsuario($data);
        $user = new $this->userEntity();
        $perfil = $this->em->getRepository('crm\Entity\Perfil')->findBy(array('perfil' =>$data['perfil']));

        if(empty($perfil)){
            return new ApiProblem(412, "O perfil: {$data['perfil']}, n�o se encontra cadastrado no CRM");
        }

        $nomeFilailAd = $data['filialAd'];
        $filial   = $this->filialService->getByNome($nomeFilailAd);

        if(!$filial){
            return new ApiProblem(404, "A filial: {$data['filialAd']}, n�o se encontra cadastrado no CRM");
        }

        $this->hydrate($user,$data);
        $this->em->persist($user);

        $user->setPerfil($perfil[0]);
        $user->setFilial($filial);
        $user->setDataCriacao($this->getDataAtual());
        try{
            $this->em->flush();
        } catch(\Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public function getByEmail($email)
    {
        $user = $this->em->getRepository('crm\Entity\Usuarios')->findBy(array('email' =>$email));
        if(!empty($user[0])) {
            return $user;
        }
        return false;
    }

    public function getByUserprincipalname($userPrincipalName)
    {

        $user = $this->em->getRepository('crm\Entity\Usuarios')->findBy(array('userPrincipalName' =>$userPrincipalName));

        if(!empty($user[0])) {
            return $user;
        }
        return false;

    }

    public function update($id, $data)
    {

        $data = $this->montaUsuario($data);


        $user   = $this->em->getRepository($this->repository)->find($id);
        if($user) {
            $perfil = $this->em->getRepository('crm\Entity\Perfil')->findBy(array('perfil' =>$data['perfil']));
            $nomeFilailAd = $data['filialAd'];
            $filial   = $this->filialService->getByNome($nomeFilailAd);
            $user->setFilial($filial);
            $user->setUserPrincipalName($data['userPrincipalName']);
            $this->hydrate($user,$data);
            $this->em->persist($user);
            $user->setDataEdicao($this->getDataAtual());
            $user->setPerfil($perfil[0]);
            try{
                $this->em->flush();
            } catch(\Exception $e) {
                die(var_dump($e->getMessage()));
            }

            return $this->extract($user);
        }
        return false;
    }

    public function montaUsuario($resultLdap)
    {

        $user = array(
            'nome' => $resultLdap->givenname,
            'sobreNome' => $resultLdap->sn,
            'perfil' => strtolower($resultLdap->description),
            'cpf' => '',
            'telefone_1' => '',
            'telefone_2' => '',
            'email' => $resultLdap->mail,
            'status' => '1',
            'filialAd' => $resultLdap->physicaldeliveryofficename,
            'userPrincipalName' => $resultLdap->userprincipalname

        );
        return $user;
    }

    public function getById($id)
    {
        return $this->em->getReference('crm\Entity\Usuarios' , $id);
    }

    public function fetchAll()
    {
        $query = $this->em->createQuery
        ('
          SELECT
            u.id,
            u.nome,
            u.sobreNome,
            u.email,
            u.cpf
          FROM '.$this->repository.' u
          WHERE
           u.status = 1
        ');
        $results = $query->getResult();
        if(!is_null($results)) {
            return  $results;
        }
        return new ApiProblem('404', "Recurso n�o localizado");
    }


}