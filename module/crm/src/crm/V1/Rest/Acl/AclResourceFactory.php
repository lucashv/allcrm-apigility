<?php
namespace crm\V1\Rest\Acl;

class AclResourceFactory
{
    public function __invoke($services)
    {
        return new AclResource($services->get('AclService'));
    }
}
