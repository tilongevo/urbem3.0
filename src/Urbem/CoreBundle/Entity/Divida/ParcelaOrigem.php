<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * ParcelaOrigem
 */
class ParcelaOrigem
{
    /**
     * PK
     * @var integer
     */
    private $codParcela;

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
     * PK
     * @var integer
     */
    private $numParcelamento;

    /**
     * @var integer
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Parcela
     */
    private $fkArrecadacaoParcela;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Credito
     */
    private $fkMonetarioCredito;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\Parcelamento
     */
    private $fkDividaParcelamento;


    /**
     * Set codParcela
     *
     * @param integer $codParcela
     * @return ParcelaOrigem
     */
    public function setCodParcela($codParcela)
    {
        $this->codParcela = $codParcela;
        return $this;
    }

    /**
     * Get codParcela
     *
     * @return integer
     */
    public function getCodParcela()
    {
        return $this->codParcela;
    }

    /**
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return ParcelaOrigem
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
     * @return ParcelaOrigem
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
     * @return ParcelaOrigem
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
     * @return ParcelaOrigem
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
     * Set numParcelamento
     *
     * @param integer $numParcelamento
     * @return ParcelaOrigem
     */
    public function setNumParcelamento($numParcelamento)
    {
        $this->numParcelamento = $numParcelamento;
        return $this;
    }

    /**
     * Get numParcelamento
     *
     * @return integer
     */
    public function getNumParcelamento()
    {
        return $this->numParcelamento;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return ParcelaOrigem
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoParcela
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Parcela $fkArrecadacaoParcela
     * @return ParcelaOrigem
     */
    public function setFkArrecadacaoParcela(\Urbem\CoreBundle\Entity\Arrecadacao\Parcela $fkArrecadacaoParcela)
    {
        $this->codParcela = $fkArrecadacaoParcela->getCodParcela();
        $this->fkArrecadacaoParcela = $fkArrecadacaoParcela;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoParcela
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Parcela
     */
    public function getFkArrecadacaoParcela()
    {
        return $this->fkArrecadacaoParcela;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito
     * @return ParcelaOrigem
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
     * ManyToOne (inverse side)
     * Get fkMonetarioCredito
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Credito
     */
    public function getFkMonetarioCredito()
    {
        return $this->fkMonetarioCredito;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaParcelamento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Parcelamento $fkDividaParcelamento
     * @return ParcelaOrigem
     */
    public function setFkDividaParcelamento(\Urbem\CoreBundle\Entity\Divida\Parcelamento $fkDividaParcelamento)
    {
        $this->numParcelamento = $fkDividaParcelamento->getNumParcelamento();
        $this->fkDividaParcelamento = $fkDividaParcelamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaParcelamento
     *
     * @return \Urbem\CoreBundle\Entity\Divida\Parcelamento
     */
    public function getFkDividaParcelamento()
    {
        return $this->fkDividaParcelamento;
    }
}
