<?php
namespace CRM\V1\Rest\AuthDB;

class AuthDBEntity
{
    private $usuario;
    private $password;
    
    public function getArrayCopy() {
        return Array(
            'usuario' => $this->usuario,
            'password' => $this->password
        );
    }
    
    public function exchangeArray($data) {
        foreach ($data as $key=>$value) {
            if (in_array($key, array('usuario', 'password'))) {
                $this->$key = $value;
            }
        }
    }
}
