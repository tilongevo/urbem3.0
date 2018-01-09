<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * TerminalDesativado
 */
class TerminalDesativado
{
    /**
     * PK
     * @var integer
     */
    private $codTerminal;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampTerminal;

    /**
     *  @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampDesativado;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Terminal
     */
    private $fkTesourariaTerminal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampTerminal = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampDesativado = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return TerminalDesativado
     */
    public function setCodTerminal($codTerminal)
    {
        $this->codTerminal = $codTerminal;
        return $this;
    }

    /**
     * Get codTerminal
     *
     * @return integer
     */
    public function getCodTerminal()
    {
        return $this->codTerminal;
    }

    /**
     * Set timestampTerminal
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampTerminal
     * @return TerminalDesativado
     */
    public function setTimestampTerminal(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampTerminal)
    {
        $this->timestampTerminal = $timestampTerminal;
        return $this;
    }

    /**
     * Get timestampTerminal
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampTerminal()
    {
        return $this->timestampTerminal;
    }

    /**
     * Set timestampDesativado
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampDesativado
     * @return TerminalDesativado
     */
    public function setTimestampDesativado(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampDesativado)
    {
        $this->timestampDesativado = $timestampDesativado;
        return $this;
    }

    /**
     * Get timestampDesativado
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampDesativado()
    {
        return $this->timestampDesativado;
    }

    /**
     * OneToOne (owning side)
     * Set TesourariaTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Terminal $fkTesourariaTerminal
     * @return TerminalDesativado
     */
    public function setFkTesourariaTerminal(\Urbem\CoreBundle\Entity\Tesouraria\Terminal $fkTesourariaTerminal)
    {
        $this->codTerminal = $fkTesourariaTerminal->getCodTerminal();
        $this->timestampTerminal = $fkTesourariaTerminal->getTimestampTerminal();
        $this->fkTesourariaTerminal = $fkTesourariaTerminal;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkTesourariaTerminal
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Terminal
     */
    public function getFkTesourariaTerminal()
    {
        return $this->fkTesourariaTerminal;
    }
}
