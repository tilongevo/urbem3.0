<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ChequeImpressoraTerminal
 */
class ChequeImpressoraTerminal
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
     * PK
     * @var integer
     */
    private $codImpressora;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Terminal
     */
    private $fkTesourariaTerminal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Impressora
     */
    private $fkAdministracaoImpressora;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampTerminal = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return ChequeImpressoraTerminal
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
     * @return ChequeImpressoraTerminal
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
     * Set codImpressora
     *
     * @param integer $codImpressora
     * @return ChequeImpressoraTerminal
     */
    public function setCodImpressora($codImpressora)
    {
        $this->codImpressora = $codImpressora;
        return $this;
    }

    /**
     * Get codImpressora
     *
     * @return integer
     */
    public function getCodImpressora()
    {
        return $this->codImpressora;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Terminal $fkTesourariaTerminal
     * @return ChequeImpressoraTerminal
     */
    public function setFkTesourariaTerminal(\Urbem\CoreBundle\Entity\Tesouraria\Terminal $fkTesourariaTerminal)
    {
        $this->codTerminal = $fkTesourariaTerminal->getCodTerminal();
        $this->timestampTerminal = $fkTesourariaTerminal->getTimestampTerminal();
        $this->fkTesourariaTerminal = $fkTesourariaTerminal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaTerminal
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Terminal
     */
    public function getFkTesourariaTerminal()
    {
        return $this->fkTesourariaTerminal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoImpressora
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Impressora $fkAdministracaoImpressora
     * @return ChequeImpressoraTerminal
     */
    public function setFkAdministracaoImpressora(\Urbem\CoreBundle\Entity\Administracao\Impressora $fkAdministracaoImpressora)
    {
        $this->codImpressora = $fkAdministracaoImpressora->getCodImpressora();
        $this->fkAdministracaoImpressora = $fkAdministracaoImpressora;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoImpressora
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Impressora
     */
    public function getFkAdministracaoImpressora()
    {
        return $this->fkAdministracaoImpressora;
    }
}
