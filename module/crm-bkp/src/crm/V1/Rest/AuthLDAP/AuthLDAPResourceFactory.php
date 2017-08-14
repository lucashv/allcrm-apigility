<?php
namespace crm\V1\Rest\AuthLDAP;

class AuthLDAPResourceFactory
{
    public function __invoke($services)
    {
        $AuthLDAPService = $services->get('AuthLDAPService');
        return new AuthLDAPResource($AuthLDAPService);
    }
}
