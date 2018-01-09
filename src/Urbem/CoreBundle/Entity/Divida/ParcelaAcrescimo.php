<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * ParcelaAcrescimo
 */
class ParcelaAcrescimo
{
    /**
     * PK
     * @var integer
     */
    private $numParcelamento;

    /**
     * PK
     * @var integer
     */
    private $numParcela;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codAcrescimo;

    /**
     * @var integer
     */
    private $vlracrescimo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\Parcela
     */
    private $fkDividaParcela;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Acrescimo
     */
    private $fkMonetarioAcrescimo;


    /**
     * Set numParcelamento
     *
     * @param integer $numParcelamento
     * @return ParcelaAcrescimo
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
     * Set numParcela
     *
     * @param integer $numParcela
     * @return ParcelaAcrescimo
     */
    public function setNumParcela($numParcela)
    {
        $this->numParcela = $numParcela;
        return $this;
    }

    /**
     * Get numParcela
     *
     * @return integer
     */
    public function getNumParcela()
    {
        return $this->numParcela;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ParcelaAcrescimo
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
     * Set codAcrescimo
     *
     * @param integer $codAcrescimo
     * @return ParcelaAcrescimo
     */
    public function setCodAcrescimo($codAcrescimo)
    {
        $this->codAcrescimo = $codAcrescimo;
        return $this;
    }

    /**
     * Get codAcrescimo
     *
     * @return integer
     */
    public function getCodAcrescimo()
    {
        return $this->codAcrescimo;
    }

    /**
     * Set vlracrescimo
     *
     * @param integer $vlracrescimo
     * @return ParcelaAcrescimo
     */
    public function setVlracrescimo($vlracrescimo)
    {
        $this->vlracrescimo = $vlracrescimo;
        return $this;
    }

    /**
     * Get vlracrescimo
     *
     * @return integer
     */
    public function getVlracrescimo()
    {
        return $this->vlracrescimo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaParcela
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Parcela $fkDividaParcela
     * @return ParcelaAcrescimo
     */
    public function setFkDividaParcela(\Urbem\CoreBundle\Entity\Divida\Parcela $fkDividaParcela)
    {
        $this->numParcelamento = $fkDividaParcela->getNumParcelamento();
        $this->numParcela = $fkDividaParcela->getNumParcela();
        $this->fkDividaParcela = $fkDividaParcela;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaParcela
     *
     * @return \Urbem\CoreBundle\Entity\Divida\Parcela
     */
    public function getFkDividaParcela()
    {
        return $this->fkDividaParcela;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Acrescimo $fkMonetarioAcrescimo
     * @return ParcelaAcrescimo
     */
    public function setFkMonetarioAcrescimo(\Urbem\CoreBundle\Entity\Monetario\Acrescimo $fkMonetarioAcrescimo)
    {
        $this->codAcrescimo = $fkMonetarioAcrescimo->getCodAcrescimo();
        $this->codTipo = $fkMonetarioAcrescimo->getCodTipo();
        $this->fkMonetarioAcrescimo = $fkMonetarioAcrescimo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioAcrescimo
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Acrescimo
     */
    public function getFkMonetarioAcrescimo()
    {
        return $this->fkMonetarioAcrescimo;
    }
}
