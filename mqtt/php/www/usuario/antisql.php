<?php

// Função de Eliminação de qalquer comando que possa invadir ou alterar o sistema de forma indevida
function anti_injection($sql){
    $sql = preg_replace(preg_match("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"), "" ,$sql); // remove palavras que contenham sintaxe sql
    $sql = trim($sql); // limpa espaços vazios
    $sql = strip_tags($sql); // tira tags html e php
    $sql = addslashes($sql); //  adiciona barras invertidas a um string
    return $sql;
}



 function soNumero($str) {
        return preg_replace("/[^0-9]/", "", $str);
}


/**
 * Classe que contem os métodos que iram
 * filtrar as entradas enviadas via GET e POST
 *
 * @filesource
 * @author      Pedro Elsner <pedro.elsner@gmail.com>
 * @license     http://creativecommons.org/licenses/by/3.0/br/ Creative Commons 3.0
 * @abstract
 * @version     1.0
 */
abstract class Sanitize {
/**
 * Filter
 * 
 * @param  mixed $value
 * @param  array $modes
 * @return mixed
 * @static
 * @since  1.0
 */
    static public function filter($value, $modes = array('sql', 'html')) {
        if (!is_array($modes)) {
            $modes = array($modes);
        }
        if (is_string($value)) {
            foreach ($modes as $type) {
              $value = self::_doFilter($value, $type);
            }
            return $value;
        }
        foreach ($value as $key => $toSanatize) {
            if (is_array($toSanatize)) {
                $value[$key]= self::filter($toSanatize, $modes);
            } else {
                foreach ($modes as $type) {
                  $value[$key] = self::_doFilter($toSanatize, $type);
                }
            }
        }
        return $value;
    }
/**
 * DoFilter
 * 
 * @param  mixed $value
 * @param  array $modes
 * @return mixed
 * @static
 * @since  1.0
 */
    static protected function _doFilter($value, $mode) {
        switch ($mode) {
            case 'html':
                $value = strip_tags($value);
                $value = addslashes($value);
                $value = htmlspecialchars($value);
                break;
        
            case 'sql':
                $value = preg_replace(preg_match('/(from|select|insert|delete|where|drop table|show tables|#|\*| |\\\\)/'),'',$value);
                $value = trim($value);
                break;
        }
        return $value;
    }
}
?>