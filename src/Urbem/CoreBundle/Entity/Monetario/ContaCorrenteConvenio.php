<?php

namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * ContaCorrenteConvenio
 */
class ContaCorrenteConvenio
{
    /**
     * PK
     * @var integer
     */
    private $codContaCorrente;

    /**
     * PK
     * @var integer
     */
    private $codAgencia;

    /**
     * PK
     * @var integer
     */
    private $codBanco;

    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * @var integer
     */
    private $variacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoContaCorrente
     */
    private $fkMonetarioCreditoContaCorrentes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\ContaCorrente
     */
    private $fkMonetarioContaCorrente;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Convenio
     */
    private $fkMonetarioConvenio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkMonetarioCreditoContaCorrentes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codContaCorrente
     *
     * @param integer $codContaCorrente
     * @return ContaCorrenteConvenio
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
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return ContaCorrenteConvenio
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
     * Set codBanco
     *
     * @param integer $codBanco
     * @return ContaCorrenteConvenio
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
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ContaCorrenteConvenio
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
     * Set variacao
     *
     * @param integer $variacao
     * @return ContaCorrenteConvenio
     */
    public function setVariacao($variacao = null)
    {
        $this->variacao = $variacao;
        return $this;
    }

    /**
     * Get variacao
     *
     * @return integer
     */
    public function getVariacao()
    {
        return $this->variacao;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioCreditoContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoContaCorrente $fkMonetarioCreditoContaCorrente
     * @return ContaCorrenteConvenio
     */
    public function addFkMonetarioCreditoContaCorrentes(\Urbem\CoreBundle\Entity\Monetario\CreditoContaCorrente $fkMonetarioCreditoContaCorrente)
    {
        if (false === $this->fkMonetarioCreditoContaCorrentes->contains($fkMonetarioCreditoContaCorrente)) {
            $fkMonetarioCreditoContaCorrente->setFkMonetarioContaCorrenteConvenio($this);
            $this->fkMonetarioCreditoContaCorrentes->add($fkMonetarioCreditoContaCorrente);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioCreditoContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoContaCorrente $fkMonetarioCreditoContaCorrente
     */
    public function removeFkMonetarioCreditoContaCorrentes(\Urbem\CoreBundle\Entity\Monetario\CreditoContaCorrente $fkMonetarioCreditoContaCorrente)
    {
        $this->fkMonetarioCreditoContaCorrentes->removeElement($fkMonetarioCreditoContaCorrente);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioCreditoContaCorrentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoContaCorrente
     */
    public function getFkMonetarioCreditoContaCorrentes()
    {
        return $this->fkMonetarioCreditoContaCorrentes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente
     * @return ContaCorrenteConvenio
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
     * ManyToOne (inverse side)
     * Set fkMonetarioConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Convenio $fkMonetarioConvenio
     * @return ContaCorrenteConvenio
     */
    public function setFkMonetarioConvenio(\Urbem\CoreBundle\Entity\Monetario\Convenio $fkMonetarioConvenio)
    {
        $this->codConvenio = $fkMonetarioConvenio->getCodConvenio();
        $this->fkMonetarioConvenio = $fkMonetarioConvenio;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Convenio
     */
    public function getFkMonetarioConvenio()
    {
        return $this->fkMonetarioConvenio;
    }
}
