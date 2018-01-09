<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * BuffersInteiro
 */
class BuffersInteiro
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
     * @return BuffersInteiro
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
     * @return BuffersInteiro
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
