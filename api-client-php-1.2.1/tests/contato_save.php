<?php
/**
 * Salva um contato no @MediaPost
 *
 * @copyright  2011 - MT4 Tecnologia
 * @author     Diego Matos <diego@mt4.com.br>
 * @author     Vin�cius Campitelli <vsilva@mt4.com.br>
 * @category   MT4
 * @package    Mapi
 * @subpackage Tests
 * @since      2011-06-01
 */

/*
 * � recomendado que essa opera��o seja feita em lotes de no m�ximo 500 contatos por vez
 */
$arrContato = [
    /*
     * C�digo da lista onde vai ficar o contato
     */
    'lista' => 1,
    'contato' => [
        [
            /*
             * C�digo do contato no sistema do cliente
             */
            'uidcli' => 1,
            
            /*
             * Dados adicionais do contato. usar o m�todo /contato/campos para listar todos os campos dispon�veis
             */
            'email' => 'email@exemplo.com',
            'livre1' => 'campo livre 1 � �',
            'livre2' => 'campo livre 2 � � ��o'
        ]
    ]
];

try {
    $mapi = require 'conf.php';
    
    $arrResult = $mapi->put("contato/salvar", $arrContato);
    var_dump($arrResult);
} catch (Exception $e) {
    var_dump($e);
}
