<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoConvenioBb
 */
class ConfiguracaoConvenioBb
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbConta
     */
    private $fkImaConfiguracaoBbContas;

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
        $this->fkImaConfiguracaoBbContas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ConfiguracaoConvenioBb
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
     * @return ConfiguracaoConvenioBb
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
     * @return ConfiguracaoConvenioBb
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
     * Add ImaConfiguracaoBbConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbConta $fkImaConfiguracaoBbConta
     * @return ConfiguracaoConvenioBb
     */
    public function addFkImaConfiguracaoBbContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbConta $fkImaConfiguracaoBbConta)
    {
        if (false === $this->fkImaConfiguracaoBbContas->contains($fkImaConfiguracaoBbConta)) {
            $fkImaConfiguracaoBbConta->setFkImaConfiguracaoConvenioBb($this);
            $this->fkImaConfiguracaoBbContas->add($fkImaConfiguracaoBbConta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBbConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbConta $fkImaConfiguracaoBbConta
     */
    public function removeFkImaConfiguracaoBbContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbConta $fkImaConfiguracaoBbConta)
    {
        $this->fkImaConfiguracaoBbContas->removeElement($fkImaConfiguracaoBbConta);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBbContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbConta
     */
    public function getFkImaConfiguracaoBbContas()
    {
        return $this->fkImaConfiguracaoBbContas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioBanco
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Banco $fkMonetarioBanco
     * @return ConfiguracaoConvenioBb
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
