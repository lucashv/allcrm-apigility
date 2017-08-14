<?php
namespace crm\V1\Rest\Sites;

class SitesResourceFactory
{
    public function __invoke($services)
    {
        return new SitesResource($services->get('SitesService'));
    }
}
