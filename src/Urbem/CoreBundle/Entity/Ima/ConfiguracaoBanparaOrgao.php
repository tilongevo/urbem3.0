<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoBanparaOrgao
 */
class ConfiguracaoBanparaOrgao
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
    private $codOrgao;

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
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEmpresa
     *
     * @param integer $codEmpresa
     * @return ConfiguracaoBanparaOrgao
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
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return ConfiguracaoBanparaOrgao
     */
    public function setCodOrgao($codOrgao)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoBanparaOrgao
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
     * @return ConfiguracaoBanparaOrgao
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
     * @return ConfiguracaoBanparaOrgao
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
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return ConfiguracaoBanparaOrgao
     */
    public function setFkOrganogramaOrgao(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        $this->codOrgao = $fkOrganogramaOrgao->getCodOrgao();
        $this->fkOrganogramaOrgao = $fkOrganogramaOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    public function getFkOrganogramaOrgao()
    {
        return $this->fkOrganogramaOrgao;
    }
}
