<?php
/**
 * Busca um contato pelo c�digo
 *
 * @copyright  2011 - MT4 Tecnologia
 * @author     Diego Matos <diego@mt4.com.br>
 * @author     Vin�cius Campitelli <vsilva@mt4.com.br>
 * @category   MT4
 * @package    Mapi
 * @subpackage Tests
 * @since      2011-06-01
 */

try {
    $mapi = require 'conf.php';
    
    /*
     * C�digo do contato
     */
    $cod = 4;
    
    $arrResult = $mapi->get("contato/cod/{$cod}");
    var_dump($arrResult);
} catch (Exception $e) {
    var_dump($e);
}
