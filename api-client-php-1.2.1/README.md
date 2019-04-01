# @MediaPost API - Cliente PHP

## Instala��o
### Via composer
Altere o *require* de seu `composer.json` e baixe a depend�ncia com `composer update mediapost/api-client-php`:
```json
{
  "require": {
    "mediapost/api-client-php": "^1.1.0"
  }
}
```
Ou adicione diretamente a depend�ncia com `composer require mediapost/api-client-php:^1.1.0`.

### Manual
1. Baixe a [�ltima vers�o](https://github.com/MediaPost/api-client-php/releases/latest) desse cliente e descompacte-a no diret�rio de sua aplica��o
2. Crie um sistema de *autoloading* ou utilize algum pronto
3. Inicialize normalmente o cliente

## C�digo
### Inicializa��o
```php
<?php
// Autoloading do composer ou outro � sua escola
require 'vendor/autoload.php';

// Instanciando o client
$mapi = new Mapi\Client(
    '' /* $ConsumerKey */,
    '' /* $ConsumerSecret */,
    '' /* $Token */,
    '' /* $TokenSecret */
);
```

### Requisi��es
```php
<?php
// Inicializa��o do cliente ...

try {
    // Requisi��es GET
    $response = $mapi->get('url/do/recurso');

    // Requisi��es DELETE
    $response = $mapi->delete('url/do/recurso');

    // Requisi��es POST
    $response = $mapi->post('url/do/recurso', [
        'campo' => 'valor',
        'campo2' => 'valor2'
    ]);

    // Requisi��es PUT
    $response = $mapi->put('url/do/recurso', [
        'campo' => 'valor',
        'campo2' => 'valor2'
    ]);
} catch (Mapi\Exception $e) {
    // Erro de requisi��o
    var_dump($e);
} catch (Exception $e) {
    // Erro gen�rico (por exemplo, par�metros inv�lidos)
    var_dump($e);
}
```

### Respostas
Todas as requisi��es retornam um objeto do tipo `Mapi\Response`.
```php
<?php
// Inicializa��o do cliente ...

// Retorna a quantidade de registros que o recurso pode retornar (desconsiderando a pagina��o)
var_dump($response->getTotalCount());

// Essa classe se comporta como um array...

// ... podendo ser iterada...
foreach ($response as $key => $value) {
    var_dump($key, $value);
}

// ... e tamb�m acessada
var_dump(count($response));
var_dump($response['key']);

// Se preferir lidar realmente com um array, basta invocar o m�todo toArray()
$arr = $response->toArray();
```

## Credenciais
Para acessar a API, voc� ir� precisar das quatro credenciais de acesso: _Consumer Key, Consumer Secret, Token_ e _Token Secret_.

Para requisitar esses dados, voc� deve entrar em contato com a equipe de Suporte, criando um chamado atrav�s de sua conta @MediaPost.

## Testes
A pasta _tests_ possui alguns arquivos para exemplificar o consumo dos recursos.

Antes de acessar algum desses testes, voc� precisar� modificar as credenciais encontradas no arquivo _conf.php_ nessa mesma pasta.

Toda a documenta��o est� dispon�vel em https://www.mediapost.com.br/api/.
