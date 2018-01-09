<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * BuffersTimestamp
 */
class BuffersTimestamp
{
    /**
     * PK
     * @var string
     */
    private $buffer;

    /**
     * @var \DateTime
     */
    private $valor;


    /**
     * Set buffer
     *
     * @param string $buffer
     * @return BuffersTimestamp
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
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $valor
     * @return BuffersTimestamp
     */
    public function setValor(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getValor()
    {
        return $this->valor;
    }
}
