<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoConvenioBanrisul
 */
class ConfiguracaoConvenioBanrisul
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulConta
     */
    private $fkImaConfiguracaoBanrisulContas;

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
        $this->fkImaConfiguracaoBanrisulContas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ConfiguracaoConvenioBanrisul
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
     * @return ConfiguracaoConvenioBanrisul
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
     * @return ConfiguracaoConvenioBanrisul
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
     * Add ImaConfiguracaoBanrisulConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulConta $fkImaConfiguracaoBanrisulConta
     * @return ConfiguracaoConvenioBanrisul
     */
    public function addFkImaConfiguracaoBanrisulContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulConta $fkImaConfiguracaoBanrisulConta)
    {
        if (false === $this->fkImaConfiguracaoBanrisulContas->contains($fkImaConfiguracaoBanrisulConta)) {
            $fkImaConfiguracaoBanrisulConta->setFkImaConfiguracaoConvenioBanrisul($this);
            $this->fkImaConfiguracaoBanrisulContas->add($fkImaConfiguracaoBanrisulConta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBanrisulConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulConta $fkImaConfiguracaoBanrisulConta
     */
    public function removeFkImaConfiguracaoBanrisulContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulConta $fkImaConfiguracaoBanrisulConta)
    {
        $this->fkImaConfiguracaoBanrisulContas->removeElement($fkImaConfiguracaoBanrisulConta);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBanrisulContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulConta
     */
    public function getFkImaConfiguracaoBanrisulContas()
    {
        return $this->fkImaConfiguracaoBanrisulContas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioBanco
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Banco $fkMonetarioBanco
     * @return ConfiguracaoConvenioBanrisul
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
