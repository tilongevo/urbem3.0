<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * NivelPadraoNivel
 */
class NivelPadraoNivel
{
    /**
     * PK
     * @var integer
     */
    private $codNivelPadrao;

    /**
     * PK
     * @var integer
     */
    private $codPadrao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $percentual;

    /**
     * @var integer
     */
    private $qtdmeses;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\NivelPadrao
     */
    private $fkFolhapagamentoNivelPadrao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Padrao
     */
    private $fkFolhapagamentoPadrao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codNivelPadrao
     *
     * @param integer $codNivelPadrao
     * @return NivelPadraoNivel
     */
    public function setCodNivelPadrao($codNivelPadrao)
    {
        $this->codNivelPadrao = $codNivelPadrao;
        return $this;
    }

    /**
     * Get codNivelPadrao
     *
     * @return integer
     */
    public function getCodNivelPadrao()
    {
        return $this->codNivelPadrao;
    }

    /**
     * Set codPadrao
     *
     * @param integer $codPadrao
     * @return NivelPadraoNivel
     */
    public function setCodPadrao($codPadrao)
    {
        $this->codPadrao = $codPadrao;
        return $this;
    }

    /**
     * Get codPadrao
     *
     * @return integer
     */
    public function getCodPadrao()
    {
        return $this->codPadrao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return NivelPadraoNivel
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return NivelPadraoNivel
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
     * Set valor
     *
     * @param integer $valor
     * @return NivelPadraoNivel
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
     * Set percentual
     *
     * @param integer $percentual
     * @return NivelPadraoNivel
     */
    public function setPercentual($percentual)
    {
        $this->percentual = $percentual;
        return $this;
    }

    /**
     * Get percentual
     *
     * @return integer
     */
    public function getPercentual()
    {
        return $this->percentual;
    }

    /**
     * Set qtdmeses
     *
     * @param integer $qtdmeses
     * @return NivelPadraoNivel
     */
    public function setQtdmeses($qtdmeses)
    {
        $this->qtdmeses = $qtdmeses;
        return $this;
    }

    /**
     * Get qtdmeses
     *
     * @return integer
     */
    public function getQtdmeses()
    {
        return $this->qtdmeses;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoNivelPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\NivelPadrao $fkFolhapagamentoNivelPadrao
     * @return NivelPadraoNivel
     */
    public function setFkFolhapagamentoNivelPadrao(\Urbem\CoreBundle\Entity\Folhapagamento\NivelPadrao $fkFolhapagamentoNivelPadrao)
    {
        $this->codNivelPadrao = $fkFolhapagamentoNivelPadrao->getCodNivelPadrao();
        $this->fkFolhapagamentoNivelPadrao = $fkFolhapagamentoNivelPadrao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoNivelPadrao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\NivelPadrao
     */
    public function getFkFolhapagamentoNivelPadrao()
    {
        return $this->fkFolhapagamentoNivelPadrao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Padrao $fkFolhapagamentoPadrao
     * @return NivelPadraoNivel
     */
    public function setFkFolhapagamentoPadrao(\Urbem\CoreBundle\Entity\Folhapagamento\Padrao $fkFolhapagamentoPadrao)
    {
        $this->codPadrao = $fkFolhapagamentoPadrao->getCodPadrao();
        $this->fkFolhapagamentoPadrao = $fkFolhapagamentoPadrao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPadrao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Padrao
     */
    public function getFkFolhapagamentoPadrao()
    {
        return $this->fkFolhapagamentoPadrao;
    }
}
