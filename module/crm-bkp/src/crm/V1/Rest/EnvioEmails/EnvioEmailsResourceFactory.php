<?php
namespace crm\V1\Rest\EnvioEmails;

class EnvioEmailsResourceFactory
{
    public function __invoke($services)
    {
        return new EnvioEmailsResource($services->get('EmailService'));
    }
}
