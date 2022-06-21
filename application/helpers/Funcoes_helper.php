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

if ( ! function_exists('converte_resenha_base64')){
  function converte_resenha_base64($data, $nome_imagem){
      if (preg_match('/^data:image\/octet-stream;base64,/', $data, $type)) {
          $data = substr($data, strpos($data, ',') + 1);
          $type = 'png'; // jpg, png, gif

          if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
              throw new \Exception('invalid image type');
          }
          $data = str_replace( ' ', '+', $data );
          $data = base64_decode($data);

          if ($data === false) {
              throw new \Exception('base64_decode failed');
          }
      } else {
          throw new \Exception('did not match data URI with image data');
      }

      if(!is_dir('assets/resenhas/')){
          mkdir('assets/resenhas/');
      }

      file_put_contents('assets/resenhas/'.$nome_imagem.'_' .  time() . '.'.$type, $data);
      return 'assets/resenhas/'.$nome_imagem.'_' .  time() . '.'.$type;
  }
}

if(!function_exists('formata_string')){
    function formata_string($value, $tipo)
    {
        $CI =& get_instance();
        $CI->load->library('sanitizer');

        switch ($tipo){
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