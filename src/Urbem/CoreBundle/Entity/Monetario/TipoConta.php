<?php

namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * TipoConta
 */
class TipoConta
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\ContaCorrente
     */
    private $fkMonetarioContaCorrentes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkMonetarioContaCorrentes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoConta
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoConta
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
     * OneToMany (owning side)
     * Add MonetarioContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente
     * @return TipoConta
     */
    public function addFkMonetarioContaCorrentes(\Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente)
    {
        if (false === $this->fkMonetarioContaCorrentes->contains($fkMonetarioContaCorrente)) {
            $fkMonetarioContaCorrente->setFkMonetarioTipoConta($this);
            $this->fkMonetarioContaCorrentes->add($fkMonetarioContaCorrente);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente
     */
    public function removeFkMonetarioContaCorrentes(\Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente)
    {
        $this->fkMonetarioContaCorrentes->removeElement($fkMonetarioContaCorrente);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioContaCorrentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\ContaCorrente
     */
    public function getFkMonetarioContaCorrentes()
    {
        return $this->fkMonetarioContaCorrentes;
    }

    /**
    *
    * @return string
    */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
