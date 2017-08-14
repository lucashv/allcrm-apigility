<?php

namespace crm\V1\Rest\AuthLDAP;
use crm\V1\Rest\Usuarios\UsuarioService;
use Zend\Authentication\Adapter\Ldap as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use ZF\ApiProblem\ApiProblem;


class AuthLDAPService
{

    /**
     * Extrai as options do config/ldap-config.ini
     * @var
     */
    private $config;

    /**
     * Options do LDAP
     * @var
     */
    private $options;

    /**
     * @var AuthenticationService
     */
    private $auth;

    private $usuarioService;

    public function __construct($config, AuthenticationService $auth, UsuarioService $usuarioService)
    {
        $this->config   = $config;
        $this->options  = $config->production->ldap->toArray();
        $this->auth     = $auth;
        $this->usuarioService  = $usuarioService;
    }

    public function auth($data)
    {
        $adapter  = new AuthAdapter($this->options,$data->usuario,$data->password);
        $result = $this->auth->authenticate($adapter);
        $messages = $result->getMessages();


       if($result->getCode() != 1){
            return new ApiProblem(403, 'Não autorizado');
        }

        if($result) {
            $result =  $adapter->getAccountObject();
            return $this->atualizaUser($result);
        }
        return $messages;
    }

    public function atualizaUser($result)
    {

        $usuario = null;

        if($result) {

            $usuario = $this->usuarioService->getByUserprincipalname($result->userprincipalname);
            $usuario = $usuario[0];


            if(!$usuario) {
                $usuario = $this->usuarioService->getByEmail($result->mail);
                $usuario = $usuario[0];
            }

        } else {
            return false;
        }

        if($usuario) {

            return $this->usuarioService->update($usuario->getId(),$result );
        } else {
            return $this->usuarioService->create($result);
        }

    }



}
