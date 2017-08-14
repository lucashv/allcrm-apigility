<?php
namespace crm\V1\Rest\EmailsContato;

class EmailsContatoResourceFactory
{
    public function __invoke($services)
    {
        return new EmailsContatoResource($services->get('EmailContatoService'));
    }
}
