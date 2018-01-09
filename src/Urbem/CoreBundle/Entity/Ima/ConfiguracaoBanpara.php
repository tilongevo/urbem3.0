<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoBanpara
 */
class ConfiguracaoBanpara
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
    private $numOrgaoBanpara;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaLocal
     */
    private $fkImaConfiguracaoBanparaLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaOrgao
     */
    private $fkImaConfiguracaoBanparaOrgoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaEmpresa
     */
    private $fkImaConfiguracaoBanparaEmpresa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaConfiguracaoBanparaLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoBanparaOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEmpresa
     *
     * @param integer $codEmpresa
     * @return ConfiguracaoBanpara
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
     * Set numOrgaoBanpara
     *
     * @param integer $numOrgaoBanpara
     * @return ConfiguracaoBanpara
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoBanpara
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
     * Set descricao
     *
     * @param string $descricao
     * @return ConfiguracaoBanpara
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return ConfiguracaoBanpara
     */
    public function setVigencia(\DateTime $vigencia)
    {
        $this->vigencia = $vigencia;
        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \DateTime
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBanparaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaLocal $fkImaConfiguracaoBanparaLocal
     * @return ConfiguracaoBanpara
     */
    public function addFkImaConfiguracaoBanparaLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaLocal $fkImaConfiguracaoBanparaLocal)
    {
        if (false === $this->fkImaConfiguracaoBanparaLocais->contains($fkImaConfiguracaoBanparaLocal)) {
            $fkImaConfiguracaoBanparaLocal->setFkImaConfiguracaoBanpara($this);
            $this->fkImaConfiguracaoBanparaLocais->add($fkImaConfiguracaoBanparaLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBanparaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaLocal $fkImaConfiguracaoBanparaLocal
     */
    public function removeFkImaConfiguracaoBanparaLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaLocal $fkImaConfiguracaoBanparaLocal)
    {
        $this->fkImaConfiguracaoBanparaLocais->removeElement($fkImaConfiguracaoBanparaLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBanparaLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaLocal
     */
    public function getFkImaConfiguracaoBanparaLocais()
    {
        return $this->fkImaConfiguracaoBanparaLocais;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBanparaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaOrgao $fkImaConfiguracaoBanparaOrgao
     * @return ConfiguracaoBanpara
     */
    public function addFkImaConfiguracaoBanparaOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaOrgao $fkImaConfiguracaoBanparaOrgao)
    {
        if (false === $this->fkImaConfiguracaoBanparaOrgoes->contains($fkImaConfiguracaoBanparaOrgao)) {
            $fkImaConfiguracaoBanparaOrgao->setFkImaConfiguracaoBanpara($this);
            $this->fkImaConfiguracaoBanparaOrgoes->add($fkImaConfiguracaoBanparaOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBanparaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaOrgao $fkImaConfiguracaoBanparaOrgao
     */
    public function removeFkImaConfiguracaoBanparaOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaOrgao $fkImaConfiguracaoBanparaOrgao)
    {
        $this->fkImaConfiguracaoBanparaOrgoes->removeElement($fkImaConfiguracaoBanparaOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBanparaOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaOrgao
     */
    public function getFkImaConfiguracaoBanparaOrgoes()
    {
        return $this->fkImaConfiguracaoBanparaOrgoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaConfiguracaoBanparaEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaEmpresa $fkImaConfiguracaoBanparaEmpresa
     * @return ConfiguracaoBanpara
     */
    public function setFkImaConfiguracaoBanparaEmpresa(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaEmpresa $fkImaConfiguracaoBanparaEmpresa)
    {
        $this->codEmpresa = $fkImaConfiguracaoBanparaEmpresa->getCodEmpresa();
        $this->fkImaConfiguracaoBanparaEmpresa = $fkImaConfiguracaoBanparaEmpresa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaConfiguracaoBanparaEmpresa
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaEmpresa
     */
    public function getFkImaConfiguracaoBanparaEmpresa()
    {
        return $this->fkImaConfiguracaoBanparaEmpresa;
    }
}
