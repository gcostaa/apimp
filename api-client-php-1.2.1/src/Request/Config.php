<?php
/**
 * @copyright   2016 - MT4 Tecnologia
 * @author      Diego Matos <diego@mt4.com.br>
 * @author      Vin�cius Campitelli <vsilva@mt4.com.br>
 * @category    MT4
 * @package     MAPI
 * @since       2016-11-11
 */

namespace Mapi\Request;

/**
 * Classe de configura��o da requisi��o
 */
class Config
{
    /**
     * Define o range de elementos desejados
     *
     * @var string
     */
    const RANGE = 'range';
    
    /**
     * Dados de configura��o
     *
     * @var array
     */
    private $arr = [];
    
    /**
     * Construtor
     *
     * @param array $arr Dados da configura��o
     */
    public function __construct(array $arr)
    {
        $this->arr = $arr;
    }
    
    /**
     * Constr�i os cabe�alhos de acordo com a configura��o informado
     *
     * @param  array  $arr Dados da configura��o
     *
     * @return array
     */
    protected function build(array $arr)
    {
        $headers = [];
        
        // HTTP Range da requisi��o
        if (isset($arr[self::RANGE])) {
            $range = $arr[self::RANGE];
            if (\is_array($range)) {
                $start = (isset($range[0])) ? \max((int) $range[0], 0) : -1;
                $end   = (isset($range[1])) ? \max((int) $range[1], 0) : -1;
            } else {
                $start = $end = -1;
            }
            if (($start < 0) || ($end < 0)) {
                throw new \InvalidArgumentException('Range inv�lido.');
            }
            
            // Adiciona o cabe�alho
            $headers[] = "Rest-Range: {$start}-{$end}";
        }
        
        return $headers;
    }
    
    /**
     * Retorna os cabe�alhos
     *
     * @return array
     */
    public function toArray()
    {
        return $this->build($this->arr);
    }
}
