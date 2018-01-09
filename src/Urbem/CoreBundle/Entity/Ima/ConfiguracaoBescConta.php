<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoBescConta
 */
class ConfiguracaoBescConta
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescLocal
     */
    private $fkImaConfiguracaoBescLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescOrgao
     */
    private $fkImaConfiguracaoBescOrgoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBesc
     */
    private $fkImaConfiguracaoConvenioBesc;

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
        $this->fkImaConfiguracaoBescLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoBescOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ConfiguracaoBescConta
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
     * @return ConfiguracaoBescConta
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
     * @return ConfiguracaoBescConta
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
     * @return ConfiguracaoBescConta
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
     * @return ConfiguracaoBescConta
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
     * @return ConfiguracaoBescConta
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
     * @return ConfiguracaoBescConta
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
     * Add ImaConfiguracaoBescLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescLocal $fkImaConfiguracaoBescLocal
     * @return ConfiguracaoBescConta
     */
    public function addFkImaConfiguracaoBescLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescLocal $fkImaConfiguracaoBescLocal)
    {
        if (false === $this->fkImaConfiguracaoBescLocais->contains($fkImaConfiguracaoBescLocal)) {
            $fkImaConfiguracaoBescLocal->setFkImaConfiguracaoBescConta($this);
            $this->fkImaConfiguracaoBescLocais->add($fkImaConfiguracaoBescLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBescLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescLocal $fkImaConfiguracaoBescLocal
     */
    public function removeFkImaConfiguracaoBescLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescLocal $fkImaConfiguracaoBescLocal)
    {
        $this->fkImaConfiguracaoBescLocais->removeElement($fkImaConfiguracaoBescLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBescLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescLocal
     */
    public function getFkImaConfiguracaoBescLocais()
    {
        return $this->fkImaConfiguracaoBescLocais;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBescOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescOrgao $fkImaConfiguracaoBescOrgao
     * @return ConfiguracaoBescConta
     */
    public function addFkImaConfiguracaoBescOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescOrgao $fkImaConfiguracaoBescOrgao)
    {
        if (false === $this->fkImaConfiguracaoBescOrgoes->contains($fkImaConfiguracaoBescOrgao)) {
            $fkImaConfiguracaoBescOrgao->setFkImaConfiguracaoBescConta($this);
            $this->fkImaConfiguracaoBescOrgoes->add($fkImaConfiguracaoBescOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBescOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescOrgao $fkImaConfiguracaoBescOrgao
     */
    public function removeFkImaConfiguracaoBescOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescOrgao $fkImaConfiguracaoBescOrgao)
    {
        $this->fkImaConfiguracaoBescOrgoes->removeElement($fkImaConfiguracaoBescOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBescOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescOrgao
     */
    public function getFkImaConfiguracaoBescOrgoes()
    {
        return $this->fkImaConfiguracaoBescOrgoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaConfiguracaoConvenioBesc
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBesc $fkImaConfiguracaoConvenioBesc
     * @return ConfiguracaoBescConta
     */
    public function setFkImaConfiguracaoConvenioBesc(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBesc $fkImaConfiguracaoConvenioBesc)
    {
        $this->codConvenio = $fkImaConfiguracaoConvenioBesc->getCodConvenio();
        $this->codBanco = $fkImaConfiguracaoConvenioBesc->getCodBanco();
        $this->fkImaConfiguracaoConvenioBesc = $fkImaConfiguracaoConvenioBesc;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaConfiguracaoConvenioBesc
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBesc
     */
    public function getFkImaConfiguracaoConvenioBesc()
    {
        return $this->fkImaConfiguracaoConvenioBesc;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente
     * @return ConfiguracaoBescConta
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
