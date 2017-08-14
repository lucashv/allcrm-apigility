<?php
/**
 * Created by PhpStorm.
 * User: tiago.alves
 * Date: 07/03/2016
 * Time: 14:16
 */

namespace crm\V1\Rest\Cron;


class Cron
{
    private $tarefa;


    public function __construct(string $tarefa)
    {
        $this->tarefa = $tarefa;
    }

    /**
     * @return string
     */
    public function getTarefa()
    {
        return $this->tarefa;
    }

    /**
     * @param string $tarefa
     */
    public function setTarefa($tarefa)
    {
        $this->tarefa = $tarefa;
        return $this;
    }


}