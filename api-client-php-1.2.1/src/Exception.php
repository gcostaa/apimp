<?php
/**
 * @copyright   2016 - MT4 Tecnologia
 * @author      Diego Matos <diego@mt4.com.br>
 * @author      Vin�cius Campitelli <vsilva@mt4.com.br>
 * @category    MT4
 * @package     MAPI
 * @since       2011-03-16
 */

namespace Mapi;

/**
 * Exception da API do MediaPost
 */
class Exception extends \Exception
{
    /**
     * Resultado da exce��o
     *
     * @var array
     */
    protected $result;
    
    /**
     * Construtor
     *
     * @author Diego Matos <diego@mt4.com.br>
     * @author Vin�cius Campitelli <vsilva@mt4.com.br>
     * @since  2011-03-16
     *
     * @param int   $code    C�digo do erro
     * @param array $request Dados extras da requisi��o (opcional)
     */
    public function __construct($code, array $result = [])
    {
        $this->result = $result;
        $code = (int) $code;
        
        if (!empty($result)) {
            $msg = ((isset($result['code'])) ? $result['code'] : $code) . " - {$result['message']}";
        } else {
            $msg = 'Erro desconhecido encontrado.';
        }

        parent::__construct(\utf8_decode($msg), $code);
    }
    
    /**
     * M�todo que retorna o array de exception
     *
     * @author Diego Matos <diego@mt4.com.br>
     * @since  2011-03-17
     *
     * @return  array
     */
    public function getResult()
    {
         return $this->result;
    }
    
    /**
     * Representa��o do erro como string
     *
     * @author Diego Matos <diego@mt4.com.br>
     * @since  2011-03-17
     *
     * @return string
     */
    public function __toString()
    {
        $str = $this->result['type'] . ' ';
        if ($this->code != 0) {
            $str .= "{$this->code}: ";
        }
        return $str . $this->message;
    }
}
