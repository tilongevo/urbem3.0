<?php

namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * Carteira
 */
class Carteira
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
    private $codCarteira;

    /**
     * @var integer
     */
    private $numCarteira;

    /**
     * @var integer
     */
    private $variacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Carne
     */
    private $fkArrecadacaoCarnes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoCarteira
     */
    private $fkMonetarioCreditoCarteiras;

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
        $this->fkArrecadacaoCarnes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioCreditoCarteiras = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return Carteira
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
     * Set codCarteira
     *
     * @param integer $codCarteira
     * @return Carteira
     */
    public function setCodCarteira($codCarteira)
    {
        $this->codCarteira = $codCarteira;
        return $this;
    }

    /**
     * Get codCarteira
     *
     * @return integer
     */
    public function getCodCarteira()
    {
        return $this->codCarteira;
    }

    /**
     * Set numCarteira
     *
     * @param integer $numCarteira
     * @return Carteira
     */
    public function setNumCarteira($numCarteira)
    {
        $this->numCarteira = $numCarteira;
        return $this;
    }

    /**
     * Get numCarteira
     *
     * @return integer
     */
    public function getNumCarteira()
    {
        return $this->numCarteira;
    }

    /**
     * Set variacao
     *
     * @param integer $variacao
     * @return Carteira
     */
    public function setVariacao($variacao)
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
     * Add ArrecadacaoCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne
     * @return Carteira
     */
    public function addFkArrecadacaoCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne)
    {
        if (false === $this->fkArrecadacaoCarnes->contains($fkArrecadacaoCarne)) {
            $fkArrecadacaoCarne->setFkMonetarioCarteira($this);
            $this->fkArrecadacaoCarnes->add($fkArrecadacaoCarne);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne
     */
    public function removeFkArrecadacaoCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne)
    {
        $this->fkArrecadacaoCarnes->removeElement($fkArrecadacaoCarne);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCarnes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Carne
     */
    public function getFkArrecadacaoCarnes()
    {
        return $this->fkArrecadacaoCarnes;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioCreditoCarteira
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoCarteira $fkMonetarioCreditoCarteira
     * @return Carteira
     */
    public function addFkMonetarioCreditoCarteiras(\Urbem\CoreBundle\Entity\Monetario\CreditoCarteira $fkMonetarioCreditoCarteira)
    {
        if (false === $this->fkMonetarioCreditoCarteiras->contains($fkMonetarioCreditoCarteira)) {
            $fkMonetarioCreditoCarteira->setFkMonetarioCarteira($this);
            $this->fkMonetarioCreditoCarteiras->add($fkMonetarioCreditoCarteira);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioCreditoCarteira
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoCarteira $fkMonetarioCreditoCarteira
     */
    public function removeFkMonetarioCreditoCarteiras(\Urbem\CoreBundle\Entity\Monetario\CreditoCarteira $fkMonetarioCreditoCarteira)
    {
        $this->fkMonetarioCreditoCarteiras->removeElement($fkMonetarioCreditoCarteira);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioCreditoCarteiras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoCarteira
     */
    public function getFkMonetarioCreditoCarteiras()
    {
        return $this->fkMonetarioCreditoCarteiras;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Convenio $fkMonetarioConvenio
     * @return Carteira
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

    /**
    *
    * @return string
    */
    public function __toString()
    {
        return (string) $this->numCarteira;
    }
}
