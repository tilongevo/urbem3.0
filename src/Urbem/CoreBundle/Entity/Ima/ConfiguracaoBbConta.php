<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoBbConta
 */
class ConfiguracaoBbConta
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbLocal
     */
    private $fkImaConfiguracaoBbLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbOrgao
     */
    private $fkImaConfiguracaoBbOrgoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBb
     */
    private $fkImaConfiguracaoConvenioBb;

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
        $this->fkImaConfiguracaoBbLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoBbOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ConfiguracaoBbConta
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
     * @return ConfiguracaoBbConta
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
     * @return ConfiguracaoBbConta
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
     * @return ConfiguracaoBbConta
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
     * @return ConfiguracaoBbConta
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
     * @return ConfiguracaoBbConta
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
     * @return ConfiguracaoBbConta
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
     * Add ImaConfiguracaoBbLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbLocal $fkImaConfiguracaoBbLocal
     * @return ConfiguracaoBbConta
     */
    public function addFkImaConfiguracaoBbLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbLocal $fkImaConfiguracaoBbLocal)
    {
        if (false === $this->fkImaConfiguracaoBbLocais->contains($fkImaConfiguracaoBbLocal)) {
            $fkImaConfiguracaoBbLocal->setFkImaConfiguracaoBbConta($this);
            $this->fkImaConfiguracaoBbLocais->add($fkImaConfiguracaoBbLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBbLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbLocal $fkImaConfiguracaoBbLocal
     */
    public function removeFkImaConfiguracaoBbLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbLocal $fkImaConfiguracaoBbLocal)
    {
        $this->fkImaConfiguracaoBbLocais->removeElement($fkImaConfiguracaoBbLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBbLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbLocal
     */
    public function getFkImaConfiguracaoBbLocais()
    {
        return $this->fkImaConfiguracaoBbLocais;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBbOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbOrgao $fkImaConfiguracaoBbOrgao
     * @return ConfiguracaoBbConta
     */
    public function addFkImaConfiguracaoBbOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbOrgao $fkImaConfiguracaoBbOrgao)
    {
        if (false === $this->fkImaConfiguracaoBbOrgoes->contains($fkImaConfiguracaoBbOrgao)) {
            $fkImaConfiguracaoBbOrgao->setFkImaConfiguracaoBbConta($this);
            $this->fkImaConfiguracaoBbOrgoes->add($fkImaConfiguracaoBbOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBbOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbOrgao $fkImaConfiguracaoBbOrgao
     */
    public function removeFkImaConfiguracaoBbOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbOrgao $fkImaConfiguracaoBbOrgao)
    {
        $this->fkImaConfiguracaoBbOrgoes->removeElement($fkImaConfiguracaoBbOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBbOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbOrgao
     */
    public function getFkImaConfiguracaoBbOrgoes()
    {
        return $this->fkImaConfiguracaoBbOrgoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaConfiguracaoConvenioBb
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBb $fkImaConfiguracaoConvenioBb
     * @return ConfiguracaoBbConta
     */
    public function setFkImaConfiguracaoConvenioBb(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBb $fkImaConfiguracaoConvenioBb)
    {
        $this->codConvenio = $fkImaConfiguracaoConvenioBb->getCodConvenio();
        $this->codBanco = $fkImaConfiguracaoConvenioBb->getCodBanco();
        $this->fkImaConfiguracaoConvenioBb = $fkImaConfiguracaoConvenioBb;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaConfiguracaoConvenioBb
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBb
     */
    public function getFkImaConfiguracaoConvenioBb()
    {
        return $this->fkImaConfiguracaoConvenioBb;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente
     * @return ConfiguracaoBbConta
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
