<?php
/**
 * Teste de cria��o de uma mensagem
 *
 * @copyright  2011 - MT4 Tecnologia
 * @author     Diego Matos <diego@mt4.com.br>
 * @author     Vin�cius Campitelli <vsilva@mt4.com.br>
 * @category   MT4
 * @package    Mapi
 * @subpackage Tests
 * @since      2011-06-01
 */

$arrMensagem = [
    /*
     * C�digo da mensagem no sistema do cliente. Esse c�digo ser� retornado junto com o c�digo da mensagem
     * para facilitar a identifica��o da mensagem no sistema do cliente
     */
    'uidcli' => 897,
    
    /*
     * C�digo da mensagem no @MediaPost. Utilizado para alterar a mensagem ao inv�s de criar uma nova
     */
    'cod' => 0,
    
    /*
     * Remetente da mensagem.
     */
    'remetente' => [
        'nome' => 'Meu remetente',
        'email' => 'marketing@meusite.com.br'
    ],
    
    /*
     * Pasta onde deve ficar a mensagem
     */
    'pasta' => 'Pasta padr�o',

    /*
     * Informa��es da mensagem.
     */
    'mensagem' => [
        'ganalytics' => 'CampanhaAPI',
        'assunto'    => 'TESTE API Acentos � � � � ' . time(),
        'html'       => 'Corpo da mensagem',
        'texto'      => 'Mensagem em TXT'
    ]
];

try {
    $mapi = require 'conf.php';
    
    $arrResult = $mapi->put('mensagem/salvar', $arrMensagem);
    var_dump($arrResult);
} catch (Exception $e) {
    var_dump($e);
}
