<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * LevantamentoAcrescimo
 */
class LevantamentoAcrescimo
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $competencia;

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
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\Levantamento
     */
    private $fkFiscalizacaoLevantamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Acrescimo
     */
    private $fkMonetarioAcrescimo;


    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return LevantamentoAcrescimo
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set competencia
     *
     * @param string $competencia
     * @return LevantamentoAcrescimo
     */
    public function setCompetencia($competencia)
    {
        $this->competencia = $competencia;
        return $this;
    }

    /**
     * Get competencia
     *
     * @return string
     */
    public function getCompetencia()
    {
        return $this->competencia;
    }

    /**
     * Set codAcrescimo
     *
     * @param integer $codAcrescimo
     * @return LevantamentoAcrescimo
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
     * @return LevantamentoAcrescimo
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
     * @return LevantamentoAcrescimo
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
     * Set fkFiscalizacaoLevantamento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Levantamento $fkFiscalizacaoLevantamento
     * @return LevantamentoAcrescimo
     */
    public function setFkFiscalizacaoLevantamento(\Urbem\CoreBundle\Entity\Fiscalizacao\Levantamento $fkFiscalizacaoLevantamento)
    {
        $this->codProcesso = $fkFiscalizacaoLevantamento->getCodProcesso();
        $this->competencia = $fkFiscalizacaoLevantamento->getCompetencia();
        $this->fkFiscalizacaoLevantamento = $fkFiscalizacaoLevantamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoLevantamento
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\Levantamento
     */
    public function getFkFiscalizacaoLevantamento()
    {
        return $this->fkFiscalizacaoLevantamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Acrescimo $fkMonetarioAcrescimo
     * @return LevantamentoAcrescimo
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
