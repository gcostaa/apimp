<?php
/**
 * Busca as informa��es de envios bloqueados de uma mensagem
 *
 * @copyright  2016 - MT4 Tecnologia
 * @author     Vin�cius Campitelli <vsilva@mt4.com.br>
 * @category   MT4
 * @package    Mapi
 * @subpackage Tests
 * @since      2016-11-01
 */

try {
    $mapi = require 'conf.php';
    
    // A fun��o retorna um objeto do tipo Mapi\Response...
    $result = $mapi->put('contato/bloqueio', [
        'email' => [
            'email1@exemplo.com',
            'email2@exemplo.com'
        ],
        'mensagem' => 1
    ]);
    var_dump($result);
    
    // Mapi\Response pode ser tratado como um array (foreach, $result['indice'], etc...),
    // ou voc� pode retornar realmente um array com o m�todo toArray()
    // var_dump($result->toArray());
} catch (Exception $e) {
    var_dump($e);
}
