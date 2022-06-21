<?php
class Sanitizer {

    public function email($email){
        $retorno = $this->protect($email);
        return filter_var($retorno, FILTER_SANITIZE_EMAIL);
    }

    public function alfabetico($valor, $allow_accents = true, $allow_spaces = false){
        $retorno = $this->protect($valor);
        $valor = str_replace(array('"', "'", '`', '´', '¨'), '', trim($retorno));
        if(!$allow_accents && !$allow_spaces){
            return preg_replace('#[^A-Za-z]#', '', $valor);
        }
        if($allow_accents && !$allow_spaces){
            return preg_replace('#[^A-Za-zà-źÀ-Ź]#', '', $valor);
        }
        if(!$allow_accents && $allow_spaces){
            return preg_replace('#[^A-Za-z ]#', '', $valor);
        }
        if($allow_accents && $allow_spaces){
            return preg_replace('#[^A-Za-zà-źÀ-Ź ]#', '', $valor);
        }
    }

    public function alfanumerico($valor, $allow_accents = true, $allow_spaces = false){
        $retorno = $this->protect($valor);
        $valor = str_replace(array('"', "'", '`', '´', '¨'), '', trim($retorno));
        if(!$allow_accents && !$allow_spaces){
            return preg_replace('#[^A-Za-z0-9]#', '', $valor);
        }
        if($allow_accents && !$allow_spaces){
            return preg_replace('#[^A-Za-zà-źÀ-Ź0-9]#', '', $valor);
        }
        if(!$allow_accents && $allow_spaces){
            return preg_replace('#[^A-Za-z0-9 ]#', '', $valor);
        }
        if($allow_accents && $allow_spaces){
            return preg_replace('#[^A-Za-zà-źÀ-Ź0-9 ]#', '', $valor);
        }
    }

    public function numerico($valor){
        $retorno = $this->protect($valor);
        return preg_replace('/\D/', '', $retorno);
    }

    public function integer($valor){
        return (int)$valor;
    }

    public function float($valor){
        return (float)$valor;
    }

    public function money($valor){
        $retorno = $this->protect($valor);
        $valor = preg_replace('/\D/', '', $retorno);
        if(strlen($valor) < 3){
            $valor = substr($valor, 0, strlen($valor)).'.00';
            return (float)$valor;
        }
        if(strlen($valor) > 2){
            $valor = substr($valor, 0, (strlen($valor)-2)).'.'.substr($valor, (strlen($valor)-2));
            return (float)$valor;
        }
    }

    public function url($valor){
        $retorno = $this->protect($valor);
        $valor = strip_tags(str_replace(array('"', "'", '`', '´', '¨'), '', trim($retorno)));
        return filter_var($valor, FILTER_SANITIZE_URL);
    }

    public function protect( &$str ) {
        /*** Função para retornar uma string/Array protegidos contra SQL/Blind/XSS Injection*/
        if( !is_array( $str ) ) {
            $str = preg_replace( '/(from|select|insert|delete|where|drop|truncate|union|order|update|database)/i', '', $str );
            $str = preg_replace( '/(&lt;|<)?script(\/?(&gt;|>(.*))?)/i', '', $str );
            $tbl = get_html_translation_table( HTML_ENTITIES );
            $tbl = array_flip( $tbl );
            $str = addslashes( $str );
            $str = strip_tags( $str );
            return strtr( $str, $tbl );
        } else {
            return array_filter( $str, "protect" );
        }
    }

}