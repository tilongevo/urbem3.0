<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoBanparaLocal
 */
class ConfiguracaoBanparaLocal
{
    /**
     * PK
     * @var integer
     */
    private $codEmpresa;

    /**
     * PK
     * @var integer
     */
    private $codLocal;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $numOrgaoBanpara;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanpara
     */
    private $fkImaConfiguracaoBanpara;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Local
     */
    private $fkOrganogramaLocal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK();
    }

    /**
     * Set codEmpresa
     *
     * @param integer $codEmpresa
     * @return ConfiguracaoBanparaLocal
     */
    public function setCodEmpresa($codEmpresa)
    {
        $this->codEmpresa = $codEmpresa;
        return $this;
    }

    /**
     * Get codEmpresa
     *
     * @return integer
     */
    public function getCodEmpresa()
    {
        return $this->codEmpresa;
    }

    /**
     * Set codLocal
     *
     * @param integer $codLocal
     * @return ConfiguracaoBanparaLocal
     */
    public function setCodLocal($codLocal)
    {
        $this->codLocal = $codLocal;
        return $this;
    }

    /**
     * Get codLocal
     *
     * @return integer
     */
    public function getCodLocal()
    {
        return $this->codLocal;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoBanparaLocal
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
     * Set numOrgaoBanpara
     *
     * @param integer $numOrgaoBanpara
     * @return ConfiguracaoBanparaLocal
     */
    public function setNumOrgaoBanpara($numOrgaoBanpara)
    {
        $this->numOrgaoBanpara = $numOrgaoBanpara;
        return $this;
    }

    /**
     * Get numOrgaoBanpara
     *
     * @return integer
     */
    public function getNumOrgaoBanpara()
    {
        return $this->numOrgaoBanpara;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaConfiguracaoBanpara
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanpara $fkImaConfiguracaoBanpara
     * @return ConfiguracaoBanparaLocal
     */
    public function setFkImaConfiguracaoBanpara(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanpara $fkImaConfiguracaoBanpara)
    {
        $this->codEmpresa = $fkImaConfiguracaoBanpara->getCodEmpresa();
        $this->numOrgaoBanpara = $fkImaConfiguracaoBanpara->getNumOrgaoBanpara();
        $this->timestamp = $fkImaConfiguracaoBanpara->getTimestamp();
        $this->fkImaConfiguracaoBanpara = $fkImaConfiguracaoBanpara;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaConfiguracaoBanpara
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanpara
     */
    public function getFkImaConfiguracaoBanpara()
    {
        return $this->fkImaConfiguracaoBanpara;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal
     * @return ConfiguracaoBanparaLocal
     */
    public function setFkOrganogramaLocal(\Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal)
    {
        $this->codLocal = $fkOrganogramaLocal->getCodLocal();
        $this->fkOrganogramaLocal = $fkOrganogramaLocal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaLocal
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Local
     */
    public function getFkOrganogramaLocal()
    {
        return $this->fkOrganogramaLocal;
    }
}
