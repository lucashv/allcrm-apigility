<?php
namespace crm\V1\Rest\Operadoras;

class OperadorasResourceFactory
{
    public function __invoke($services)
    {
        return new OperadorasResource($services->get('OperadorasService'));
    }
}
