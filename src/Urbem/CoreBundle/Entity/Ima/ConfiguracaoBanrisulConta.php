<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoBanrisulConta
 */
class ConfiguracaoBanrisulConta
{
    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * PK
     * @var integer
     */
    private $codBanco;

    /**
     * PK
     * @var integer
     */
    private $codAgencia;

    /**
     * PK
     * @var integer
     */
    private $codContaCorrente;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulLocal
     */
    private $fkImaConfiguracaoBanrisulLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulOrgao
     */
    private $fkImaConfiguracaoBanrisulOrgoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBanrisul
     */
    private $fkImaConfiguracaoConvenioBanrisul;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\ContaCorrente
     */
    private $fkMonetarioContaCorrente;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaConfiguracaoBanrisulLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoBanrisulOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ConfiguracaoBanrisulConta
     */
    public function setCodConvenio($codConvenio)
    {
        $this->codConvenio = $codConvenio;
        return $this;
    }

    /**
     * Get codConvenio
     *
     * @return integer
     */
    public function getCodConvenio()
    {
        return $this->codConvenio;
    }

    /**
     * Set codBanco
     *
     * @param integer $codBanco
     * @return ConfiguracaoBanrisulConta
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;
        return $this;
    }

    /**
     * Get codBanco
     *
     * @return integer
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return ConfiguracaoBanrisulConta
     */
    public function setCodAgencia($codAgencia)
    {
        $this->codAgencia = $codAgencia;
        return $this;
    }

    /**
     * Get codAgencia
     *
     * @return integer
     */
    public function getCodAgencia()
    {
        return $this->codAgencia;
    }

    /**
     * Set codContaCorrente
     *
     * @param integer $codContaCorrente
     * @return ConfiguracaoBanrisulConta
     */
    public function setCodContaCorrente($codContaCorrente)
    {
        $this->codContaCorrente = $codContaCorrente;
        return $this;
    }

    /**
     * Get codContaCorrente
     *
     * @return integer
     */
    public function getCodContaCorrente()
    {
        return $this->codContaCorrente;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoBanrisulConta
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
     * @return ConfiguracaoBanrisulConta
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
     * @return ConfiguracaoBanrisulConta
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
     * Add ImaConfiguracaoBanrisulLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulLocal $fkImaConfiguracaoBanrisulLocal
     * @return ConfiguracaoBanrisulConta
     */
    public function addFkImaConfiguracaoBanrisulLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulLocal $fkImaConfiguracaoBanrisulLocal)
    {
        if (false === $this->fkImaConfiguracaoBanrisulLocais->contains($fkImaConfiguracaoBanrisulLocal)) {
            $fkImaConfiguracaoBanrisulLocal->setFkImaConfiguracaoBanrisulConta($this);
            $this->fkImaConfiguracaoBanrisulLocais->add($fkImaConfiguracaoBanrisulLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBanrisulLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulLocal $fkImaConfiguracaoBanrisulLocal
     */
    public function removeFkImaConfiguracaoBanrisulLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulLocal $fkImaConfiguracaoBanrisulLocal)
    {
        $this->fkImaConfiguracaoBanrisulLocais->removeElement($fkImaConfiguracaoBanrisulLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBanrisulLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulLocal
     */
    public function getFkImaConfiguracaoBanrisulLocais()
    {
        return $this->fkImaConfiguracaoBanrisulLocais;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBanrisulOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulOrgao $fkImaConfiguracaoBanrisulOrgao
     * @return ConfiguracaoBanrisulConta
     */
    public function addFkImaConfiguracaoBanrisulOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulOrgao $fkImaConfiguracaoBanrisulOrgao)
    {
        if (false === $this->fkImaConfiguracaoBanrisulOrgoes->contains($fkImaConfiguracaoBanrisulOrgao)) {
            $fkImaConfiguracaoBanrisulOrgao->setFkImaConfiguracaoBanrisulConta($this);
            $this->fkImaConfiguracaoBanrisulOrgoes->add($fkImaConfiguracaoBanrisulOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBanrisulOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulOrgao $fkImaConfiguracaoBanrisulOrgao
     */
    public function removeFkImaConfiguracaoBanrisulOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulOrgao $fkImaConfiguracaoBanrisulOrgao)
    {
        $this->fkImaConfiguracaoBanrisulOrgoes->removeElement($fkImaConfiguracaoBanrisulOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBanrisulOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulOrgao
     */
    public function getFkImaConfiguracaoBanrisulOrgoes()
    {
        return $this->fkImaConfiguracaoBanrisulOrgoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaConfiguracaoConvenioBanrisul
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBanrisul $fkImaConfiguracaoConvenioBanrisul
     * @return ConfiguracaoBanrisulConta
     */
    public function setFkImaConfiguracaoConvenioBanrisul(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBanrisul $fkImaConfiguracaoConvenioBanrisul)
    {
        $this->codConvenio = $fkImaConfiguracaoConvenioBanrisul->getCodConvenio();
        $this->codBanco = $fkImaConfiguracaoConvenioBanrisul->getCodBanco();
        $this->fkImaConfiguracaoConvenioBanrisul = $fkImaConfiguracaoConvenioBanrisul;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaConfiguracaoConvenioBanrisul
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBanrisul
     */
    public function getFkImaConfiguracaoConvenioBanrisul()
    {
        return $this->fkImaConfiguracaoConvenioBanrisul;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente
     * @return ConfiguracaoBanrisulConta
     */
    public function setFkMonetarioContaCorrente(\Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente)
    {
        $this->codBanco = $fkMonetarioContaCorrente->getCodBanco();
        $this->codAgencia = $fkMonetarioContaCorrente->getCodAgencia();
        $this->codContaCorrente = $fkMonetarioContaCorrente->getCodContaCorrente();
        $this->fkMonetarioContaCorrente = $fkMonetarioContaCorrente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioContaCorrente
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\ContaCorrente
     */
    public function getFkMonetarioContaCorrente()
    {
        return $this->fkMonetarioContaCorrente;
    }
}
