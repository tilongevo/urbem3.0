<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoConvenioBesc
 */
class ConfiguracaoConvenioBesc
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
     * @var string
     */
    private $codConvenioBanco;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescConta
     */
    private $fkImaConfiguracaoBescContas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Banco
     */
    private $fkMonetarioBanco;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaConfiguracaoBescContas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ConfiguracaoConvenioBesc
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
     * @return ConfiguracaoConvenioBesc
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
     * Set codConvenioBanco
     *
     * @param string $codConvenioBanco
     * @return ConfiguracaoConvenioBesc
     */
    public function setCodConvenioBanco($codConvenioBanco)
    {
        $this->codConvenioBanco = $codConvenioBanco;
        return $this;
    }

    /**
     * Get codConvenioBanco
     *
     * @return string
     */
    public function getCodConvenioBanco()
    {
        return $this->codConvenioBanco;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBescConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescConta $fkImaConfiguracaoBescConta
     * @return ConfiguracaoConvenioBesc
     */
    public function addFkImaConfiguracaoBescContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescConta $fkImaConfiguracaoBescConta)
    {
        if (false === $this->fkImaConfiguracaoBescContas->contains($fkImaConfiguracaoBescConta)) {
            $fkImaConfiguracaoBescConta->setFkImaConfiguracaoConvenioBesc($this);
            $this->fkImaConfiguracaoBescContas->add($fkImaConfiguracaoBescConta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBescConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescConta $fkImaConfiguracaoBescConta
     */
    public function removeFkImaConfiguracaoBescContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescConta $fkImaConfiguracaoBescConta)
    {
        $this->fkImaConfiguracaoBescContas->removeElement($fkImaConfiguracaoBescConta);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBescContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescConta
     */
    public function getFkImaConfiguracaoBescContas()
    {
        return $this->fkImaConfiguracaoBescContas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioBanco
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Banco $fkMonetarioBanco
     * @return ConfiguracaoConvenioBesc
     */
    public function setFkMonetarioBanco(\Urbem\CoreBundle\Entity\Monetario\Banco $fkMonetarioBanco)
    {
        $this->codBanco = $fkMonetarioBanco->getCodBanco();
        $this->fkMonetarioBanco = $fkMonetarioBanco;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioBanco
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Banco
     */
    public function getFkMonetarioBanco()
    {
        return $this->fkMonetarioBanco;
    }
}
