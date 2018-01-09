<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * DividaAcrescimo
 */
class DividaAcrescimo
{
    /**
     * PK
     * @var integer
     */
    private $codInscricao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codAcrescimo;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\DividaAtiva
     */
    private $fkDividaDividaAtiva;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Acrescimo
     */
    private $fkMonetarioAcrescimo;


    /**
     * Set codInscricao
     *
     * @param integer $codInscricao
     * @return DividaAcrescimo
     */
    public function setCodInscricao($codInscricao)
    {
        $this->codInscricao = $codInscricao;
        return $this;
    }

    /**
     * Get codInscricao
     *
     * @return integer
     */
    public function getCodInscricao()
    {
        return $this->codInscricao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return DividaAcrescimo
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codAcrescimo
     *
     * @param integer $codAcrescimo
     * @return DividaAcrescimo
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return DividaAcrescimo
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
     * Set valor
     *
     * @param integer $valor
     * @return DividaAcrescimo
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
     * Set fkDividaDividaAtiva
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaAtiva $fkDividaDividaAtiva
     * @return DividaAcrescimo
     */
    public function setFkDividaDividaAtiva(\Urbem\CoreBundle\Entity\Divida\DividaAtiva $fkDividaDividaAtiva)
    {
        $this->exercicio = $fkDividaDividaAtiva->getExercicio();
        $this->codInscricao = $fkDividaDividaAtiva->getCodInscricao();
        $this->fkDividaDividaAtiva = $fkDividaDividaAtiva;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaDividaAtiva
     *
     * @return \Urbem\CoreBundle\Entity\Divida\DividaAtiva
     */
    public function getFkDividaDividaAtiva()
    {
        return $this->fkDividaDividaAtiva;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Acrescimo $fkMonetarioAcrescimo
     * @return DividaAcrescimo
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
