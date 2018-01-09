<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoConvenioHsbc
 */
class ConfiguracaoConvenioHsbc
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta
     */
    private $fkImaConfiguracaoHsbcContas;

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
        $this->fkImaConfiguracaoHsbcContas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ConfiguracaoConvenioHsbc
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
     * @return ConfiguracaoConvenioHsbc
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
     * @return ConfiguracaoConvenioHsbc
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
     * Add ImaConfiguracaoHsbcConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta $fkImaConfiguracaoHsbcConta
     * @return ConfiguracaoConvenioHsbc
     */
    public function addFkImaConfiguracaoHsbcContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta $fkImaConfiguracaoHsbcConta)
    {
        if (false === $this->fkImaConfiguracaoHsbcContas->contains($fkImaConfiguracaoHsbcConta)) {
            $fkImaConfiguracaoHsbcConta->setFkImaConfiguracaoConvenioHsbc($this);
            $this->fkImaConfiguracaoHsbcContas->add($fkImaConfiguracaoHsbcConta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoHsbcConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta $fkImaConfiguracaoHsbcConta
     */
    public function removeFkImaConfiguracaoHsbcContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta $fkImaConfiguracaoHsbcConta)
    {
        $this->fkImaConfiguracaoHsbcContas->removeElement($fkImaConfiguracaoHsbcConta);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoHsbcContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta
     */
    public function getFkImaConfiguracaoHsbcContas()
    {
        return $this->fkImaConfiguracaoHsbcContas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioBanco
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Banco $fkMonetarioBanco
     * @return ConfiguracaoConvenioHsbc
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
