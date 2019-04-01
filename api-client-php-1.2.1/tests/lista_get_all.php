<?php
/**
 * Busca todas as listas dispon�veis na conta
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
    
    $arrResult = $mapi->get('lista/all');
    var_dump($arrResult);
} catch (Exception $e) {
    var_dump($e);
}
