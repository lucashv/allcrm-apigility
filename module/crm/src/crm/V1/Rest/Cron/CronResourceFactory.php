<?php
namespace crm\V1\Rest\Cron;

class CronResourceFactory
{
    public function __invoke($services)
    {
        return new CronResource($services->get('cronService'));
    }
}
