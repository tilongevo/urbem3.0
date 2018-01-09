<?php

namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * CreditoCarteira
 */
class CreditoCarteira
{
    /**
     * PK
     * @var integer
     */
    private $codEspecie;

    /**
     * PK
     * @var integer
     */
    private $codGenero;

    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * PK
     * @var integer
     */
    private $codCredito;

    /**
     * @var integer
     */
    private $codCarteira;

    /**
     * @var integer
     */
    private $codConvenio;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Monetario\Credito
     */
    private $fkMonetarioCredito;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Carteira
     */
    private $fkMonetarioCarteira;


    /**
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return CreditoCarteira
     */
    public function setCodEspecie($codEspecie)
    {
        $this->codEspecie = $codEspecie;
        return $this;
    }

    /**
     * Get codEspecie
     *
     * @return integer
     */
    public function getCodEspecie()
    {
        return $this->codEspecie;
    }

    /**
     * Set codGenero
     *
     * @param integer $codGenero
     * @return CreditoCarteira
     */
    public function setCodGenero($codGenero)
    {
        $this->codGenero = $codGenero;
        return $this;
    }

    /**
     * Get codGenero
     *
     * @return integer
     */
    public function getCodGenero()
    {
        return $this->codGenero;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return CreditoCarteira
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set codCredito
     *
     * @param integer $codCredito
     * @return CreditoCarteira
     */
    public function setCodCredito($codCredito)
    {
        $this->codCredito = $codCredito;
        return $this;
    }

    /**
     * Get codCredito
     *
     * @return integer
     */
    public function getCodCredito()
    {
        return $this->codCredito;
    }

    /**
     * Set codCarteira
     *
     * @param integer $codCarteira
     * @return CreditoCarteira
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
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return CreditoCarteira
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
     * ManyToOne (inverse side)
     * Set fkMonetarioCarteira
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Carteira $fkMonetarioCarteira
     * @return CreditoCarteira
     */
    public function setFkMonetarioCarteira(\Urbem\CoreBundle\Entity\Monetario\Carteira $fkMonetarioCarteira)
    {
        $this->codConvenio = $fkMonetarioCarteira->getCodConvenio();
        $this->codCarteira = $fkMonetarioCarteira->getCodCarteira();
        $this->fkMonetarioCarteira = $fkMonetarioCarteira;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioCarteira
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Carteira
     */
    public function getFkMonetarioCarteira()
    {
        return $this->fkMonetarioCarteira;
    }

    /**
     * OneToOne (owning side)
     * Set MonetarioCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito
     * @return CreditoCarteira
     */
    public function setFkMonetarioCredito(\Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito)
    {
        $this->codCredito = $fkMonetarioCredito->getCodCredito();
        $this->codNatureza = $fkMonetarioCredito->getCodNatureza();
        $this->codGenero = $fkMonetarioCredito->getCodGenero();
        $this->codEspecie = $fkMonetarioCredito->getCodEspecie();
        $this->fkMonetarioCredito = $fkMonetarioCredito;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkMonetarioCredito
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Credito
     */
    public function getFkMonetarioCredito()
    {
        return $this->fkMonetarioCredito;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) sprintf('%d - %d', $this->codCredito, $this->codCarteira);
    }
}
