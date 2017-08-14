<?php
/**
 * Created by PhpStorm.
 * User: tiago.alves
 * Date: 07/03/2016
 * Time: 12:06
 */

namespace crm\V1\Rest\Cron;


interface CronInterface
{
    public function execute();

}