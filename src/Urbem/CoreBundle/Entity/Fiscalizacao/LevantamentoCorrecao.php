<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * LevantamentoCorrecao
 */
class LevantamentoCorrecao
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
    private $codIndicador;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $indice;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\Levantamento
     */
    private $fkFiscalizacaoLevantamento;


    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return LevantamentoCorrecao
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
     * @return LevantamentoCorrecao
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
     * Set codIndicador
     *
     * @param integer $codIndicador
     * @return LevantamentoCorrecao
     */
    public function setCodIndicador($codIndicador)
    {
        $this->codIndicador = $codIndicador;
        return $this;
    }

    /**
     * Get codIndicador
     *
     * @return integer
     */
    public function getCodIndicador()
    {
        return $this->codIndicador;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return LevantamentoCorrecao
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
     * Set indice
     *
     * @param integer $indice
     * @return LevantamentoCorrecao
     */
    public function setIndice($indice)
    {
        $this->indice = $indice;
        return $this;
    }

    /**
     * Get indice
     *
     * @return integer
     */
    public function getIndice()
    {
        return $this->indice;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoLevantamento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Levantamento $fkFiscalizacaoLevantamento
     * @return LevantamentoCorrecao
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
}
