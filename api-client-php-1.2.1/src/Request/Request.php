<?php
/**
 * @copyright   2016 - MT4 Tecnologia
 * @author      Diego Matos <diego@mt4.com.br>
 * @author      Vin�cius Campitelli <vsilva@mt4.com.br>
 * @category    MT4
 * @package     MAPI
 * @since       2016-11-04
 */

namespace Mapi\Request;

use Mapi\Client;
use Mapi\Response;

/**
 * Classe que executa uma requisi��o � API
 */
class Request
{
    /**
     * M�todo GET
     *
     * @var string
     */
    const METHOD_GET    = 'GET';

    /**
     * M�todo POST
     *
     * @var string
     */
    const METHOD_POST   = 'POST';

    /**
     * M�todo PUT
     *
     * @var string
     */
    const METHOD_PUT    = 'PUT';

    /**
     * M�todo DELETE
     *
     * @var string
     */
    const METHOD_DELETE = 'DELETE';

    /**
     * Cliente da API
     *
     * @var Client
     */
    protected $client = null;

    /**
     * Construtor
     *
     * @author Vin�cius Campitelli <vsilva@mt4.com.br>
     * @since  2016-11-04
     *
     * @param Client $client Cliente da API
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * M�todo que executa uma requisi��o HTTP GET
     *
     * @author Diego Matos <diego@mt4.com.br>
     * @author Vin�cius Campitelli <vsilva@mt4.com.br>
     * @since  2011-03-16
     *
     * @param  string       $path   URL do recurso
     * @param  array        $params Dados da requisi��o (opcional)
     * @param  array|Config $config Configura��es extras (opcional)
     *
     * @return Response
     */
    public function get($path, array $params = null, $config = null)
    {
        // Permitindo valores null para facilitar a escrita do c�digo
        if ($params === null) {
            $params = [];
        }

        return $this->build($path, self::METHOD_GET, [
            CURLOPT_HTTPGET => true
        ], $params, $config);
    }

    /**
     * M�todo que executa uma requisi��o HTTP POST
     *
     * @author Diego Matos <diego@mt4.com.br>
     * @author Vin�cius Campitelli <vsilva@mt4.com.br>
     * @since  2011-03-16
     *
     * @param  string       $path   URL do recurso
     * @param  array        $params Dados da requisi��o (opcional)
     * @param  array|Config $config Configura��es extras (opcional)
     *
     * @return Response
     */
    public function post($path, array $params = null, $config = null)
    {
        // Permitindo valores null para facilitar a escrita do c�digo
        if ($params === null) {
            $params = [];
        }

        return $this->build($path, self::METHOD_POST, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $params
        ], $params, $config);
    }

    /**
     * M�todo que executa uma requisi��o HTTP PUT
     *
     * @author Diego Matos <diego@mt4.com.br>
     * @author Vin�cius Campitelli <vsilva@mt4.com.br>
     * @since  2011-03-16
     *
     * @param  string       $path   URL do recurso
     * @param  array        $params Dados da requisi��o (opcional)
     * @param  array|Config $config Configura��es extras (opcional)
     *
     * @return Response
     */
    public function put($path, array $arrData = [], $config = null)
    {
        // Transforma em JSON
        $arrData = self::setUtf8($arrData);
        $txt = \json_encode($arrData);

        // Cria um arquivo para ser submetido no PUT
        $putString = 'str=' . \urlencode($txt);
        $putFile = \tmpfile();
        \fwrite($putFile, $putString);
        \fseek($putFile, 0);

        $response = $this->build($path, self::METHOD_PUT, [
            CURLOPT_PUT        => true,
            CURLOPT_INFILE     => $putFile,
            CURLOPT_INFILESIZE => \strlen($putString)
        ], $config);

        \fclose($putFile);

        return $response;
    }

    /**
     * M�todo que excuta uma requisi��o HTTP DELETE
     *
     * @author Diego Matos <diego@mt4.com.br>
     * @author Vin�cius Campitelli <vsilva@mt4.com.br>
     * @since  2011-03-16
     *
     * @param  string       $path   URL do recurso
     * @param  array|Config $config Configura��es extras (opcional)
     *
     * @return Response
     */
    public function delete($path, $config = null)
    {
        return $this->build($path, self::METHOD_DELETE, [
            CURLOPT_CUSTOMREQUEST => 'DELETE'
        ], [], $config);
    }

    /**
     * M�todo que encoda recursivamente um array para utf8
     *
     * @author Diego Matos <diego@mt4.com.br>
     * @author Vin�cius Campitelli <vsilva@mt4.com.br>
     * @since  2011-06-06
     *
     * @param  array $arrData Dado a ser encodado
     *
     * @return array
     */
    protected static function setUtf8(array $arrData)
    {
        foreach ($arrData as $key => $v) {
            if (\is_array($v)) {
                $arrData[$key] = self::setUtf8($v);
            } elseif ($v) {
                $arrData[$key] = \utf8_encode($v);
            }
        }
        return $arrData;
    }

    /**
     * M�todo que faz o request de uma url
     *
     * @author Diego Matos <diego@mt4.com.br>
     * @author Vin�cius Campitelli <vsilva@mt4.com.br>
     * @since  2011-03-16
     *
     * @throws \InvalidArgumentException Se algum par�metro informado n�o for v�lido
     *
     * @param  string       $path    URL do recurso
     * @param  string       $method  M�todo da requisi��o
     * @param  array        $arrCurl Argumentos da requisi��o (opcional)
     * @param  array        $params  Dados da requisi��o (opcional)
     * @param  array|Config $config  Configura��es do usu�rio (opcional)
     *
     * @return Response
     */
    private function build($path, $method, array $arrCurl = [], array $params = null, $config = null)
    {
        // Monta a URL
        $url = $this->client->getUrlBase() . "/{$path}";

        if ($params === null) {
            $params = [];
        } elseif (!empty($params)) {
            $arrCurl[CURLOPT_POSTFIELDS] = \http_build_query($arrCurl[CURLOPT_POSTFIELDS]);
        }

        // Cabe�alhos padr�es
        $headers = [
            'Accept: application/json',
            'Expect:',
            $this->buildOauthRequestHeaders($this->client, $method, $url, $params)
        ];

        // Configura��s extras
        if ($config !== null) {
            if (\is_array($config)) {
                $config = new Config($config);
            } elseif (!$config instanceof Config) {
                throw new \InvalidArgumentException('Configura��es inv�lidas.');
            }
            $headers = \array_merge($headers, $config->toArray());
        }

        // Par�metros
        $arrCurl[CURLOPT_URL]            = $url;
        $arrCurl[CURLOPT_HTTPHEADER]     = $headers;
        $arrCurl[CURLOPT_RETURNTRANSFER] = true;
        $arrCurl[CURLOPT_HEADER]         = true;
        $arrCurl[CURLOPT_SSL_VERIFYPEER] = false;

        // Inicializa o cURL
        $ch = \curl_init();
        \curl_setopt_array($ch, $arrCurl);

        return Response::fromCurlResource($ch);
    }

    /**
     * Gera o cabe�alho de autentica��o do oAuth
     *
     * @param  Client $client Cliente da API
     * @param  string $method M�todo HTTP
     * @param  string $url    URL do recurso
     * @param  array  $params Par�metros da requisi��o (opcional)
     *
     * @return string
     */
    protected function buildOauthRequestHeaders(Client $client, $method, $url, array $params = [])
    {
        if (!\class_exists('\Mapi\OAuthConsumer')) {
            require __DIR__ . '/../oauth/OAuth.php';
        }

        $consumer = new \Mapi\OAuthConsumer($client->getConsumerKey(), $client->getConsumerSecret());
        $token = new \Mapi\OAuthToken($client->getToken(), $client->getTokenSecret());

        $request = \Mapi\OAuthRequest::from_consumer_and_token($consumer, $token, $method, $url);

        // Seta os par�metros da requisi��o
        foreach ($params as $name => $value) {
            $request->set_parameter($name, $value);
        }

        $request->sign_request(new \Mapi\OAuthSignatureMethod_HMAC_SHA1(), $consumer, $token);

        return $request->to_header();
    }
}
