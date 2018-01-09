<?php

namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * CreditoContaCorrente
 */
class CreditoContaCorrente
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
    private $codConvenio;

    /**
     * @var integer
     */
    private $codBanco;

    /**
     * @var integer
     */
    private $codAgencia;

    /**
     * @var integer
     */
    private $codContaCorrente;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Monetario\Credito
     */
    private $fkMonetarioCredito;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio
     */
    private $fkMonetarioContaCorrenteConvenio;


    /**
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return CreditoContaCorrente
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
     * @return CreditoContaCorrente
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
     * @return CreditoContaCorrente
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
     * @return CreditoContaCorrente
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
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return CreditoContaCorrente
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
     * @return CreditoContaCorrente
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
     * @return CreditoContaCorrente
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
     * @return CreditoContaCorrente
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
     * ManyToOne (inverse side)
     * Set fkMonetarioContaCorrenteConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio $fkMonetarioContaCorrenteConvenio
     * @return CreditoContaCorrente
     */
    public function setFkMonetarioContaCorrenteConvenio(\Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio $fkMonetarioContaCorrenteConvenio)
    {
        $this->codContaCorrente = $fkMonetarioContaCorrenteConvenio->getCodContaCorrente();
        $this->codAgencia = $fkMonetarioContaCorrenteConvenio->getCodAgencia();
        $this->codBanco = $fkMonetarioContaCorrenteConvenio->getCodBanco();
        $this->codConvenio = $fkMonetarioContaCorrenteConvenio->getCodConvenio();
        $this->fkMonetarioContaCorrenteConvenio = $fkMonetarioContaCorrenteConvenio;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioContaCorrenteConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio
     */
    public function getFkMonetarioContaCorrenteConvenio()
    {
        return $this->fkMonetarioContaCorrenteConvenio;
    }

    /**
     * OneToOne (owning side)
     * Set MonetarioCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito
     * @return CreditoContaCorrente
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
        return (string) sprintf('%d - %d', $this->codCredito, $this->codContaCorrente);
    }
}
