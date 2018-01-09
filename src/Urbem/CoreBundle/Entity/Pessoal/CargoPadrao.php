<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * CargoPadrao
 */
class CargoPadrao
{
    /**
     * PK
     * @var integer
     */
    private $codCargo;

    /**
     * PK
     * @var integer
     */
    private $codPadrao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    private $fkPessoalCargo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Padrao
     */
    private $fkFolhapagamentoPadrao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codCargo
     *
     * @param integer $codCargo
     * @return CargoPadrao
     */
    public function setCodCargo($codCargo)
    {
        $this->codCargo = $codCargo;
        return $this;
    }

    /**
     * Get codCargo
     *
     * @return integer
     */
    public function getCodCargo()
    {
        return $this->codCargo;
    }

    /**
     * Set codPadrao
     *
     * @param integer $codPadrao
     * @return CargoPadrao
     */
    public function setCodPadrao($codPadrao)
    {
        $this->codPadrao = $codPadrao;
        return $this;
    }

    /**
     * Get codPadrao
     *
     * @return integer
     */
    public function getCodPadrao()
    {
        return $this->codPadrao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return CargoPadrao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo
     * @return CargoPadrao
     */
    public function setFkPessoalCargo(\Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo)
    {
        $this->codCargo = $fkPessoalCargo->getCodCargo();
        $this->fkPessoalCargo = $fkPessoalCargo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCargo
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    public function getFkPessoalCargo()
    {
        return $this->fkPessoalCargo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Padrao $fkFolhapagamentoPadrao
     * @return CargoPadrao
     */
    public function setFkFolhapagamentoPadrao(\Urbem\CoreBundle\Entity\Folhapagamento\Padrao $fkFolhapagamentoPadrao)
    {
        $this->codPadrao = $fkFolhapagamentoPadrao->getCodPadrao();
        $this->fkFolhapagamentoPadrao = $fkFolhapagamentoPadrao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPadrao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Padrao
     */
    public function getFkFolhapagamentoPadrao()
    {
        return $this->fkFolhapagamentoPadrao;
    }

    public function __toString()
    {
        return (string) $this->getFkFolhapagamentoPadrao();
    }
}
