<?php
namespace CRM\V1\Rest\AuthDB;

class AuthDBResourceFactory
{
    public function __invoke($services)
    {
        $db = $services->get("allcross_crm");
        return new AuthDBResource($db);
    }
}
