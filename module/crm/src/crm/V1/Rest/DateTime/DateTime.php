<?php

namespace crm\V1\Rest\DateTime;

abstract class DateTime
{

    static $hoje;

    static function getDataAtualMySql($hora = false)
    {
        if($hora) {
            self::setHoje(date("Y-m-d H:i:s")) ;
            $data =  self::getHoje();
            return $data->format('Y-m-d H:i:s');
        }
        self::setHoje(date("Y-m-d")) ;
        $data =  self::getHoje();
        return $data->format('Y-m-d');
    }

    /**
     * @return mixed
     */
    static function getHoje()
    {
        return self::$hoje;
    }

    /**
     * @param mixed $hoje
     * @return DateTime
     */
    static function setHoje($hoje)
    {
        self::$hoje = new \DateTime($hoje);
        return self::$hoje;
    }





}