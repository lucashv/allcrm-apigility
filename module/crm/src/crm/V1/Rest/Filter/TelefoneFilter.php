<?php
/**
 * Created by PhpStorm.
 * User: tiago.alves
 * Date: 14/10/2015
 * Time: 10:03
 */

namespace crm\V1\Rest\Filter;


class TelefoneFilter
{

    static function formataTelefone($mascara = false,$string)
    {
        $string = trim($string);
        $mascara = '(##) ####-####';
        //9� digito - SP- Fortaleza
        if(11 == strlen($string) ) {
            $mascara = '(##) #####-####';
        }

        $string = str_replace(" ","",$string);
        for($i=0;$i<strlen($string);$i++)
        {

            $mascara[strpos($mascara,"#")] = $string[$i];
        }
        return $mascara;
    }


}
