<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * BancoChequeLayout
 */
class BancoChequeLayout
{
    /**
     * PK
     * @var integer
     */
    private $codBanco;

    /**
     * @var integer
     */
    private $colValorNumerico;

    /**
     * @var integer
     */
    private $colExtenso1;

    /**
     * @var integer
     */
    private $colExtenso2;

    /**
     * @var integer
     */
    private $colFavorecido;

    /**
     * @var integer
     */
    private $colCidade;

    /**
     * @var integer
     */
    private $colDia;

    /**
     * @var integer
     */
    private $colMes;

    /**
     * @var integer
     */
    private $colAno;

    /**
     * @var integer
     */
    private $linValorNumerico;

    /**
     * @var integer
     */
    private $linExtenso1;

    /**
     * @var integer
     */
    private $linExtenso2;

    /**
     * @var integer
     */
    private $linFavorecido;

    /**
     * @var integer
     */
    private $linCidadeData;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Monetario\Banco
     */
    private $fkMonetarioBanco;


    /**
     * Set codBanco
     *
     * @param integer $codBanco
     * @return BancoChequeLayout
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
     * Set colValorNumerico
     *
     * @param integer $colValorNumerico
     * @return BancoChequeLayout
     */
    public function setColValorNumerico($colValorNumerico)
    {
        $this->colValorNumerico = $colValorNumerico;
        return $this;
    }

    /**
     * Get colValorNumerico
     *
     * @return integer
     */
    public function getColValorNumerico()
    {
        return $this->colValorNumerico;
    }

    /**
     * Set colExtenso1
     *
     * @param integer $colExtenso1
     * @return BancoChequeLayout
     */
    public function setColExtenso1($colExtenso1)
    {
        $this->colExtenso1 = $colExtenso1;
        return $this;
    }

    /**
     * Get colExtenso1
     *
     * @return integer
     */
    public function getColExtenso1()
    {
        return $this->colExtenso1;
    }

    /**
     * Set colExtenso2
     *
     * @param integer $colExtenso2
     * @return BancoChequeLayout
     */
    public function setColExtenso2($colExtenso2)
    {
        $this->colExtenso2 = $colExtenso2;
        return $this;
    }

    /**
     * Get colExtenso2
     *
     * @return integer
     */
    public function getColExtenso2()
    {
        return $this->colExtenso2;
    }

    /**
     * Set colFavorecido
     *
     * @param integer $colFavorecido
     * @return BancoChequeLayout
     */
    public function setColFavorecido($colFavorecido)
    {
        $this->colFavorecido = $colFavorecido;
        return $this;
    }

    /**
     * Get colFavorecido
     *
     * @return integer
     */
    public function getColFavorecido()
    {
        return $this->colFavorecido;
    }

    /**
     * Set colCidade
     *
     * @param integer $colCidade
     * @return BancoChequeLayout
     */
    public function setColCidade($colCidade)
    {
        $this->colCidade = $colCidade;
        return $this;
    }

    /**
     * Get colCidade
     *
     * @return integer
     */
    public function getColCidade()
    {
        return $this->colCidade;
    }

    /**
     * Set colDia
     *
     * @param integer $colDia
     * @return BancoChequeLayout
     */
    public function setColDia($colDia)
    {
        $this->colDia = $colDia;
        return $this;
    }

    /**
     * Get colDia
     *
     * @return integer
     */
    public function getColDia()
    {
        return $this->colDia;
    }

    /**
     * Set colMes
     *
     * @param integer $colMes
     * @return BancoChequeLayout
     */
    public function setColMes($colMes)
    {
        $this->colMes = $colMes;
        return $this;
    }

    /**
     * Get colMes
     *
     * @return integer
     */
    public function getColMes()
    {
        return $this->colMes;
    }

    /**
     * Set colAno
     *
     * @param integer $colAno
     * @return BancoChequeLayout
     */
    public function setColAno($colAno)
    {
        $this->colAno = $colAno;
        return $this;
    }

    /**
     * Get colAno
     *
     * @return integer
     */
    public function getColAno()
    {
        return $this->colAno;
    }

    /**
     * Set linValorNumerico
     *
     * @param integer $linValorNumerico
     * @return BancoChequeLayout
     */
    public function setLinValorNumerico($linValorNumerico)
    {
        $this->linValorNumerico = $linValorNumerico;
        return $this;
    }

    /**
     * Get linValorNumerico
     *
     * @return integer
     */
    public function getLinValorNumerico()
    {
        return $this->linValorNumerico;
    }

    /**
     * Set linExtenso1
     *
     * @param integer $linExtenso1
     * @return BancoChequeLayout
     */
    public function setLinExtenso1($linExtenso1)
    {
        $this->linExtenso1 = $linExtenso1;
        return $this;
    }

    /**
     * Get linExtenso1
     *
     * @return integer
     */
    public function getLinExtenso1()
    {
        return $this->linExtenso1;
    }

    /**
     * Set linExtenso2
     *
     * @param integer $linExtenso2
     * @return BancoChequeLayout
     */
    public function setLinExtenso2($linExtenso2)
    {
        $this->linExtenso2 = $linExtenso2;
        return $this;
    }

    /**
     * Get linExtenso2
     *
     * @return integer
     */
    public function getLinExtenso2()
    {
        return $this->linExtenso2;
    }

    /**
     * Set linFavorecido
     *
     * @param integer $linFavorecido
     * @return BancoChequeLayout
     */
    public function setLinFavorecido($linFavorecido)
    {
        $this->linFavorecido = $linFavorecido;
        return $this;
    }

    /**
     * Get linFavorecido
     *
     * @return integer
     */
    public function getLinFavorecido()
    {
        return $this->linFavorecido;
    }

    /**
     * Set linCidadeData
     *
     * @param integer $linCidadeData
     * @return BancoChequeLayout
     */
    public function setLinCidadeData($linCidadeData)
    {
        $this->linCidadeData = $linCidadeData;
        return $this;
    }

    /**
     * Get linCidadeData
     *
     * @return integer
     */
    public function getLinCidadeData()
    {
        return $this->linCidadeData;
    }

    /**
     * OneToOne (owning side)
     * Set MonetarioBanco
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Banco $fkMonetarioBanco
     * @return BancoChequeLayout
     */
    public function setFkMonetarioBanco(\Urbem\CoreBundle\Entity\Monetario\Banco $fkMonetarioBanco)
    {
        $this->codBanco = $fkMonetarioBanco->getCodBanco();
        $this->fkMonetarioBanco = $fkMonetarioBanco;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkMonetarioBanco
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Banco
     */
    public function getFkMonetarioBanco()
    {
        return $this->fkMonetarioBanco;
    }
}
