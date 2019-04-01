<?php
/**
 * Busca as informa��es de envios bloqueados de uma mensagem
 *
 * @copyright  2011 - MT4 Tecnologia
 * @author     Vin�cius Campitelli <vsilva@mt4.com.br>
 * @category   MT4
 * @package    Mapi
 * @subpackage Tests
 * @since      2016-11-10
 */

$mapi = require 'conf.php';

/*
 * C�digo da mensagem no @MediaPost
 */
$idMensagem = (isset($_GET['id'])) ? (int) $_GET['id'] : 0;

try {
    if ($idMensagem < 1) {
        throw new InvalidArgumentException('C�digo de mensagem inv�lido');
    }
    
    // A fun��o retorna um objeto do tipo Mapi\Response...
    $result = $mapi->get("resultado/bloqueado/cod/{$idMensagem}", null, [
        Mapi\Request\Config::RANGE => [0, 9] // buscando do 1� ao 10� itens
    ]);
    
    // Retorna a quantidade de registros que o recurso pode retornar (desconsiderando a pagina��o)
    echo 'Total de registros no recurso:';
    var_dump($result->getTotalCount());
    echo '<hr>';
    
    // ... mas � um objeto que pode ser iterado por foreach()...
    echo 'Iterando...';
    echo <<<HTML
<table>
    <thead>
        <tr>
            <th>Chave</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
HTML;
    foreach ($result as $key => $value) {
        echo <<<HTML
            <tr>
                <td>{$key}</td>
                <td>
HTML;
        var_dump($value);
        echo <<<HTML
                </td>
            </tr>
HTML;
    }
    echo <<<HTML
    </tbody>
</table>
HTML;
    
    // ... e acessado/modificado como array
    echo '<hr>';
    echo 'Acessando como array...';
    var_dump(count($result));
    var_dump($result['bloqueado']);
} catch (Exception $e) {
    var_dump($e);
}
