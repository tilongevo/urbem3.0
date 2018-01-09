<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * VwBemAtivoView
 */
class VwBemAtivoView
{
    /**
     * PK
     * @var integer
     */
    private $codBem;

    /**
     * @var string
     */
    private $numPlaca;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $detalhamento;

    /**
     * @var \DateTime
     */
    private $dtAquisicao;

    /**
     * @var \DateTime
     */
    private $dtDepreciacao;

    /**
     * @var \DateTime
     */
    private $dtGarantia;

    /**
     * @var integer
     */
    private $vlBem;

    /**
     * @var integer
     */
    private $vlDepreciacao;

    /**
     * @var boolean
     */
    private $identificacao;


    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return VwBemAtivo
     */
    public function setCodBem($codBem)
    {
        $this->codBem = $codBem;
        return $this;
    }

    /**
     * Get codBem
     *
     * @return integer
     */
    public function getCodBem()
    {
        return $this->codBem;
    }

    /**
     * Set numPlaca
     *
     * @param string $numPlaca
     * @return VwBemAtivo
     */
    public function setNumPlaca($numPlaca = null)
    {
        $this->numPlaca = $numPlaca;
        return $this;
    }

    /**
     * Get numPlaca
     *
     * @return string
     */
    public function getNumPlaca()
    {
        return $this->numPlaca;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return VwBemAtivo
     */
    public function setNumcgm($numcgm = null)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return VwBemAtivo
     */
    public function setDescricao($descricao = null)
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
     * Set detalhamento
     *
     * @param string $detalhamento
     * @return VwBemAtivo
     */
    public function setDetalhamento($detalhamento = null)
    {
        $this->detalhamento = $detalhamento;
        return $this;
    }

    /**
     * Get detalhamento
     *
     * @return string
     */
    public function getDetalhamento()
    {
        return $this->detalhamento;
    }

    /**
     * Set dtAquisicao
     *
     * @param \DateTime $dtAquisicao
     * @return VwBemAtivo
     */
    public function setDtAquisicao(\DateTime $dtAquisicao = null)
    {
        $this->dtAquisicao = $dtAquisicao;
        return $this;
    }

    /**
     * Get dtAquisicao
     *
     * @return \DateTime
     */
    public function getDtAquisicao()
    {
        return $this->dtAquisicao;
    }

    /**
     * Set dtDepreciacao
     *
     * @param \DateTime $dtDepreciacao
     * @return VwBemAtivo
     */
    public function setDtDepreciacao(\DateTime $dtDepreciacao = null)
    {
        $this->dtDepreciacao = $dtDepreciacao;
        return $this;
    }

    /**
     * Get dtDepreciacao
     *
     * @return \DateTime
     */
    public function getDtDepreciacao()
    {
        return $this->dtDepreciacao;
    }

    /**
     * Set dtGarantia
     *
     * @param \DateTime $dtGarantia
     * @return VwBemAtivo
     */
    public function setDtGarantia(\DateTime $dtGarantia = null)
    {
        $this->dtGarantia = $dtGarantia;
        return $this;
    }

    /**
     * Get dtGarantia
     *
     * @return \DateTime
     */
    public function getDtGarantia()
    {
        return $this->dtGarantia;
    }

    /**
     * Set vlBem
     *
     * @param integer $vlBem
     * @return VwBemAtivo
     */
    public function setVlBem($vlBem = null)
    {
        $this->vlBem = $vlBem;
        return $this;
    }

    /**
     * Get vlBem
     *
     * @return integer
     */
    public function getVlBem()
    {
        return $this->vlBem;
    }

    /**
     * Set vlDepreciacao
     *
     * @param integer $vlDepreciacao
     * @return VwBemAtivo
     */
    public function setVlDepreciacao($vlDepreciacao = null)
    {
        $this->vlDepreciacao = $vlDepreciacao;
        return $this;
    }

    /**
     * Get vlDepreciacao
     *
     * @return integer
     */
    public function getVlDepreciacao()
    {
        return $this->vlDepreciacao;
    }

    /**
     * Set identificacao
     *
     * @param boolean $identificacao
     * @return VwBemAtivo
     */
    public function setIdentificacao($identificacao = null)
    {
        $this->identificacao = $identificacao;
        return $this;
    }

    /**
     * Get identificacao
     *
     * @return boolean
     */
    public function getIdentificacao()
    {
        return $this->identificacao;
    }
}
