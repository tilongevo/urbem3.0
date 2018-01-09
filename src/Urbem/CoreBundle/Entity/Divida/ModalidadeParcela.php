<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * ModalidadeParcela
 */
class ModalidadeParcela
{
    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $numRegra;

    /**
     * @var integer
     */
    private $vlrLimiteInicial;

    /**
     * @var integer
     */
    private $vlrLimiteFinal;

    /**
     * @var integer
     */
    private $qtdParcela;

    /**
     * @var integer
     */
    private $vlrMinimo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia
     */
    private $fkDividaModalidadeVigencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ModalidadeParcela
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ModalidadeParcela
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
     * Set numRegra
     *
     * @param integer $numRegra
     * @return ModalidadeParcela
     */
    public function setNumRegra($numRegra)
    {
        $this->numRegra = $numRegra;
        return $this;
    }

    /**
     * Get numRegra
     *
     * @return integer
     */
    public function getNumRegra()
    {
        return $this->numRegra;
    }

    /**
     * Set vlrLimiteInicial
     *
     * @param integer $vlrLimiteInicial
     * @return ModalidadeParcela
     */
    public function setVlrLimiteInicial($vlrLimiteInicial)
    {
        $this->vlrLimiteInicial = $vlrLimiteInicial;
        return $this;
    }

    /**
     * Get vlrLimiteInicial
     *
     * @return integer
     */
    public function getVlrLimiteInicial()
    {
        return $this->vlrLimiteInicial;
    }

    /**
     * Set vlrLimiteFinal
     *
     * @param integer $vlrLimiteFinal
     * @return ModalidadeParcela
     */
    public function setVlrLimiteFinal($vlrLimiteFinal)
    {
        $this->vlrLimiteFinal = $vlrLimiteFinal;
        return $this;
    }

    /**
     * Get vlrLimiteFinal
     *
     * @return integer
     */
    public function getVlrLimiteFinal()
    {
        return $this->vlrLimiteFinal;
    }

    /**
     * Set qtdParcela
     *
     * @param integer $qtdParcela
     * @return ModalidadeParcela
     */
    public function setQtdParcela($qtdParcela)
    {
        $this->qtdParcela = $qtdParcela;
        return $this;
    }

    /**
     * Get qtdParcela
     *
     * @return integer
     */
    public function getQtdParcela()
    {
        return $this->qtdParcela;
    }

    /**
     * Set vlrMinimo
     *
     * @param integer $vlrMinimo
     * @return ModalidadeParcela
     */
    public function setVlrMinimo($vlrMinimo)
    {
        $this->vlrMinimo = $vlrMinimo;
        return $this;
    }

    /**
     * Get vlrMinimo
     *
     * @return integer
     */
    public function getVlrMinimo()
    {
        return $this->vlrMinimo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaModalidadeVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia
     * @return ModalidadeParcela
     */
    public function setFkDividaModalidadeVigencia(\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia)
    {
        $this->codModalidade = $fkDividaModalidadeVigencia->getCodModalidade();
        $this->timestamp = $fkDividaModalidadeVigencia->getTimestamp();
        $this->fkDividaModalidadeVigencia = $fkDividaModalidadeVigencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaModalidadeVigencia
     *
     * @return \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia
     */
    public function getFkDividaModalidadeVigencia()
    {
        return $this->fkDividaModalidadeVigencia;
    }
}
