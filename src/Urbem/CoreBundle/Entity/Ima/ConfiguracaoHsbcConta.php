<?php
 
namespace Urbem\CoreBundle\Entity\Ima;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * ConfiguracaoHsbcConta
 */
class ConfiguracaoHsbcConta
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcOrgao
     */
    private $fkImaConfiguracaoHsbcOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcBancos
     */
    private $fkImaConfiguracaoHsbcBancos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcLocal
     */
    private $fkImaConfiguracaoHsbcLocais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioHsbc
     */
    private $fkImaConfiguracaoConvenioHsbc;

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
        $this->fkImaConfiguracaoHsbcOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoHsbcBancos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoHsbcLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK();
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ConfiguracaoHsbcConta
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
     * @return ConfiguracaoHsbcConta
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
     * @return ConfiguracaoHsbcConta
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
     * @return ConfiguracaoHsbcConta
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
     * @return ConfiguracaoHsbcConta
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
     * @return ConfiguracaoHsbcConta
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
     * @return ConfiguracaoHsbcConta
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
     * Add ImaConfiguracaoHsbcOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcOrgao $fkImaConfiguracaoHsbcOrgao
     * @return ConfiguracaoHsbcConta
     */
    public function addFkImaConfiguracaoHsbcOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcOrgao $fkImaConfiguracaoHsbcOrgao)
    {
        if (false === $this->fkImaConfiguracaoHsbcOrgoes->contains($fkImaConfiguracaoHsbcOrgao)) {
            $fkImaConfiguracaoHsbcOrgao->setFkImaConfiguracaoHsbcConta($this);
            $this->fkImaConfiguracaoHsbcOrgoes->add($fkImaConfiguracaoHsbcOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoHsbcOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcOrgao $fkImaConfiguracaoHsbcOrgao
     */
    public function removeFkImaConfiguracaoHsbcOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcOrgao $fkImaConfiguracaoHsbcOrgao)
    {
        $this->fkImaConfiguracaoHsbcOrgoes->removeElement($fkImaConfiguracaoHsbcOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoHsbcOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcOrgao
     */
    public function getFkImaConfiguracaoHsbcOrgoes()
    {
        return $this->fkImaConfiguracaoHsbcOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoHsbcBancos
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcBancos $fkImaConfiguracaoHsbcBancos
     * @return ConfiguracaoHsbcConta
     */
    public function addFkImaConfiguracaoHsbcBancos(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcBancos $fkImaConfiguracaoHsbcBancos)
    {
        if (false === $this->fkImaConfiguracaoHsbcBancos->contains($fkImaConfiguracaoHsbcBancos)) {
            $fkImaConfiguracaoHsbcBancos->setFkImaConfiguracaoHsbcConta($this);
            $this->fkImaConfiguracaoHsbcBancos->add($fkImaConfiguracaoHsbcBancos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoHsbcBancos
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcBancos $fkImaConfiguracaoHsbcBancos
     */
    public function removeFkImaConfiguracaoHsbcBancos(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcBancos $fkImaConfiguracaoHsbcBancos)
    {
        $this->fkImaConfiguracaoHsbcBancos->removeElement($fkImaConfiguracaoHsbcBancos);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoHsbcBancos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcBancos
     */
    public function getFkImaConfiguracaoHsbcBancos()
    {
        return $this->fkImaConfiguracaoHsbcBancos;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoHsbcLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcLocal $fkImaConfiguracaoHsbcLocal
     * @return ConfiguracaoHsbcConta
     */
    public function addFkImaConfiguracaoHsbcLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcLocal $fkImaConfiguracaoHsbcLocal)
    {
        if (false === $this->fkImaConfiguracaoHsbcLocais->contains($fkImaConfiguracaoHsbcLocal)) {
            $fkImaConfiguracaoHsbcLocal->setFkImaConfiguracaoHsbcConta($this);
            $this->fkImaConfiguracaoHsbcLocais->add($fkImaConfiguracaoHsbcLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoHsbcLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcLocal $fkImaConfiguracaoHsbcLocal
     */
    public function removeFkImaConfiguracaoHsbcLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcLocal $fkImaConfiguracaoHsbcLocal)
    {
        $this->fkImaConfiguracaoHsbcLocais->removeElement($fkImaConfiguracaoHsbcLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoHsbcLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcLocal
     */
    public function getFkImaConfiguracaoHsbcLocais()
    {
        return $this->fkImaConfiguracaoHsbcLocais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaConfiguracaoConvenioHsbc
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioHsbc $fkImaConfiguracaoConvenioHsbc
     * @return ConfiguracaoHsbcConta
     */
    public function setFkImaConfiguracaoConvenioHsbc(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioHsbc $fkImaConfiguracaoConvenioHsbc)
    {
        $this->codConvenio = $fkImaConfiguracaoConvenioHsbc->getCodConvenio();
        $this->codBanco = $fkImaConfiguracaoConvenioHsbc->getCodBanco();
        $this->fkImaConfiguracaoConvenioHsbc = $fkImaConfiguracaoConvenioHsbc;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaConfiguracaoConvenioHsbc
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioHsbc
     */
    public function getFkImaConfiguracaoConvenioHsbc()
    {
        return $this->fkImaConfiguracaoConvenioHsbc;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente
     * @return ConfiguracaoHsbcConta
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

    /**
     * Converte para string
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getDescricao();
    }
}
