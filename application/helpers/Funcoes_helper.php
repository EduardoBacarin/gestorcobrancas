<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Helpers Funcoes_helper
 *
 * This Helpers for Funções Básicas
 * 
 * @package   CodeIgniter
 * @category  Helpers
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 *
 */

// ------------------------------------------------------------------------

if (!function_exists('mask')) {
    function mask($val, $mascara)
    {
        $mask = '';
        switch ($mascara){
            case 'documento': strlen($val) == 14 ? $mask = '##.###.###/####-##' : $mask = '###.###.###-##'; break;
            case 'telefone': strlen($val) == 10 ? $mask = '(##) ####-####' : $mask = '(##) #####-####'; break;
            case 'cep': $mask = '#####-###';break;
            case 'data': $mask = '##/##/####';break;
        };
        
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k]))
                    $maskared .= $val[$k++];
            } else {
                if (isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }
}


if (!function_exists('limitaTexto')) {
    function limitaTexto($str, $tamanho)
    {
        if (strlen($str) > $tamanho){
            $str = substr($str, 0, $tamanho) . '...';
        }
        return $str;
    }
}

if (!function_exists('meses')) {
    function meses($mes)
    {
        switch ($mes){
            case 1: return ['Janeiro', '01']; break;
            case 2: return ['Fevereiro', '02']; break;
            case 3: return ['Março', '03']; break;
            case 4: return ['Abril', '04']; break;
            case 5: return ['Maio', '05']; break;
            case 6: return ['Junho', '06']; break;
            case 7: return ['Julho', '07']; break;
            case 8: return ['Agosto', '08']; break;
            case 9: return ['Setembro', '09']; break;
            case 10: return ['Outubro', '10']; break;
            case 11: return ['Novembro', '11']; break;
            case 12: return ['Dezembro', '12']; break;
        }
    }
}

if (!function_exists('formata_string')) {
    function formata_string($value, $tipo)
    {
        $CI = &get_instance();
        $CI->load->library('sanitizer');

        switch ($tipo) {
            case 'email':
                $retorno = $CI->sanitizer->email($value);
                $retorno = mb_strtolower($retorno);
                break;
            case 'nome':
                $retorno = $CI->sanitizer->alfabetico($value, true, true);
                $retorno = mb_strtolower($retorno);
                $retorno = ucwords($retorno);
                break;
            case 'string':
                $retorno = $CI->sanitizer->alfanumerico($value, true, true);
                $retorno = mb_strtolower($retorno);
                $retorno = ucwords($retorno);
                break;
            case 'sanitize':
                $retorno = $CI->sanitizer->alfanumerico($value, true, true);
                break;
            case 'string_semacento':
                $retorno = $CI->sanitizer->alfanumerico($value, false, true);
                break;
            case 'integer':
                $retorno = $CI->sanitizer->integer($value);
                break;
            case 'numeric':
                $retorno = $CI->sanitizer->numerico($value);
                break;
            case 'float':
                $retorno = $CI->sanitizer->float($value);
                break;
            case 'money':
                $retorno = $CI->sanitizer->money($value);
                break;
            case 'url':
                $retorno = $CI->sanitizer->url($value);
                break;
            case 'protect':
                $retorno = $CI->sanitizer->protect($value);
                break;
        }

        return $retorno;
    }
}

// ------------------------------------------------------------------------

/* End of file Funcoes_helper.php */
/* Location: ./application/helpers/Funcoes_helper.php */