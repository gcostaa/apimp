<?php
/**
 * Busca as informa��es de cancelamento de uma mensagem
 *
 * @copyright  2011 - MT4 Tecnologia
 * @author     Diego Matos <diego@mt4.com.br>
 * @author     Vin�cius Campitelli <vsilva@mt4.com.br>
 * @category   MT4
 * @package    Mapi
 * @subpackage Tests
 * @since      2011-06-01
 */

$mapi = require 'conf.php';

try {
    /*
     * C�digo da mensagem no @MediaPost
     */
    $cod = 352;
    
    $arrResult = $mapi->get("resultado/cancelado/cod/{$cod}");
    var_dump($arrResult);
} catch (Exception $e) {
    var_dump($e);
}
