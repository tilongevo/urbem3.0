<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * BuffersNumerico
 */
class BuffersNumerico
{
    /**
     * PK
     * @var string
     */
    private $buffer;

    /**
     * @var integer
     */
    private $valor;


    /**
     * Set buffer
     *
     * @param string $buffer
     * @return BuffersNumerico
     */
    public function setBuffer($buffer)
    {
        $this->buffer = $buffer;
        return $this;
    }

    /**
     * Get buffer
     *
     * @return string
     */
    public function getBuffer()
    {
        return $this->buffer;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return BuffersNumerico
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }
}
