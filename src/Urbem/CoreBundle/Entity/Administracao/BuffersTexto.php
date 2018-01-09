<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * BuffersTexto
 */
class BuffersTexto
{
    /**
     * PK
     * @var string
     */
    private $buffer;

    /**
     * @var string
     */
    private $valor;


    /**
     * Set buffer
     *
     * @param string $buffer
     * @return BuffersTexto
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
     * @param string $valor
     * @return BuffersTexto
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }
}
