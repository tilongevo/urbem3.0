<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * RetencaoServico
 */
class RetencaoServico
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
    private $codNota;

    /**
     * PK
     * @var integer
     */
    private $numServico;

    /**
     * @var integer
     */
    private $codServico;

    /**
     * @var integer
     */
    private $valorDeclarado;

    /**
     * @var integer
     */
    private $valorDeducao;

    /**
     * @var integer
     */
    private $valorLancado;

    /**
     * @var integer
     */
    private $aliquota;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota
     */
    private $fkFiscalizacaoRetencaoNota;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Servico
     */
    private $fkEconomicoServico;


    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return RetencaoServico
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
     * @return RetencaoServico
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
     * Set codNota
     *
     * @param integer $codNota
     * @return RetencaoServico
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set numServico
     *
     * @param integer $numServico
     * @return RetencaoServico
     */
    public function setNumServico($numServico)
    {
        $this->numServico = $numServico;
        return $this;
    }

    /**
     * Get numServico
     *
     * @return integer
     */
    public function getNumServico()
    {
        return $this->numServico;
    }

    /**
     * Set codServico
     *
     * @param integer $codServico
     * @return RetencaoServico
     */
    public function setCodServico($codServico)
    {
        $this->codServico = $codServico;
        return $this;
    }

    /**
     * Get codServico
     *
     * @return integer
     */
    public function getCodServico()
    {
        return $this->codServico;
    }

    /**
     * Set valorDeclarado
     *
     * @param integer $valorDeclarado
     * @return RetencaoServico
     */
    public function setValorDeclarado($valorDeclarado)
    {
        $this->valorDeclarado = $valorDeclarado;
        return $this;
    }

    /**
     * Get valorDeclarado
     *
     * @return integer
     */
    public function getValorDeclarado()
    {
        return $this->valorDeclarado;
    }

    /**
     * Set valorDeducao
     *
     * @param integer $valorDeducao
     * @return RetencaoServico
     */
    public function setValorDeducao($valorDeducao)
    {
        $this->valorDeducao = $valorDeducao;
        return $this;
    }

    /**
     * Get valorDeducao
     *
     * @return integer
     */
    public function getValorDeducao()
    {
        return $this->valorDeducao;
    }

    /**
     * Set valorLancado
     *
     * @param integer $valorLancado
     * @return RetencaoServico
     */
    public function setValorLancado($valorLancado)
    {
        $this->valorLancado = $valorLancado;
        return $this;
    }

    /**
     * Get valorLancado
     *
     * @return integer
     */
    public function getValorLancado()
    {
        return $this->valorLancado;
    }

    /**
     * Set aliquota
     *
     * @param integer $aliquota
     * @return RetencaoServico
     */
    public function setAliquota($aliquota)
    {
        $this->aliquota = $aliquota;
        return $this;
    }

    /**
     * Get aliquota
     *
     * @return integer
     */
    public function getAliquota()
    {
        return $this->aliquota;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoRetencaoNota
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota $fkFiscalizacaoRetencaoNota
     * @return RetencaoServico
     */
    public function setFkFiscalizacaoRetencaoNota(\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota $fkFiscalizacaoRetencaoNota)
    {
        $this->codProcesso = $fkFiscalizacaoRetencaoNota->getCodProcesso();
        $this->competencia = $fkFiscalizacaoRetencaoNota->getCompetencia();
        $this->codNota = $fkFiscalizacaoRetencaoNota->getCodNota();
        $this->fkFiscalizacaoRetencaoNota = $fkFiscalizacaoRetencaoNota;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoRetencaoNota
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota
     */
    public function getFkFiscalizacaoRetencaoNota()
    {
        return $this->fkFiscalizacaoRetencaoNota;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoServico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Servico $fkEconomicoServico
     * @return RetencaoServico
     */
    public function setFkEconomicoServico(\Urbem\CoreBundle\Entity\Economico\Servico $fkEconomicoServico)
    {
        $this->codServico = $fkEconomicoServico->getCodServico();
        $this->fkEconomicoServico = $fkEconomicoServico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoServico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Servico
     */
    public function getFkEconomicoServico()
    {
        return $this->fkEconomicoServico;
    }
}
