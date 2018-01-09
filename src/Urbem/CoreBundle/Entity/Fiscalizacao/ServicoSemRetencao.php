<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * ServicoSemRetencao
 */
class ServicoSemRetencao
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
    private $codServico;

    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * PK
     * @var integer
     */
    private $ocorrencia;

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
    private $valorDeducaoLegal;

    /**
     * @var integer
     */
    private $valorLancado;

    /**
     * @var integer
     */
    private $aliquota;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico
     */
    private $fkFiscalizacaoFaturamentoServico;


    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return ServicoSemRetencao
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
     * @return ServicoSemRetencao
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
     * Set codServico
     *
     * @param integer $codServico
     * @return ServicoSemRetencao
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
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return ServicoSemRetencao
     */
    public function setCodAtividade($codAtividade)
    {
        $this->codAtividade = $codAtividade;
        return $this;
    }

    /**
     * Get codAtividade
     *
     * @return integer
     */
    public function getCodAtividade()
    {
        return $this->codAtividade;
    }

    /**
     * Set ocorrencia
     *
     * @param integer $ocorrencia
     * @return ServicoSemRetencao
     */
    public function setOcorrencia($ocorrencia)
    {
        $this->ocorrencia = $ocorrencia;
        return $this;
    }

    /**
     * Get ocorrencia
     *
     * @return integer
     */
    public function getOcorrencia()
    {
        return $this->ocorrencia;
    }

    /**
     * Set valorDeclarado
     *
     * @param integer $valorDeclarado
     * @return ServicoSemRetencao
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
     * @return ServicoSemRetencao
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
     * Set valorDeducaoLegal
     *
     * @param integer $valorDeducaoLegal
     * @return ServicoSemRetencao
     */
    public function setValorDeducaoLegal($valorDeducaoLegal)
    {
        $this->valorDeducaoLegal = $valorDeducaoLegal;
        return $this;
    }

    /**
     * Get valorDeducaoLegal
     *
     * @return integer
     */
    public function getValorDeducaoLegal()
    {
        return $this->valorDeducaoLegal;
    }

    /**
     * Set valorLancado
     *
     * @param integer $valorLancado
     * @return ServicoSemRetencao
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
     * @return ServicoSemRetencao
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
     * OneToOne (owning side)
     * Set FiscalizacaoFaturamentoServico
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico $fkFiscalizacaoFaturamentoServico
     * @return ServicoSemRetencao
     */
    public function setFkFiscalizacaoFaturamentoServico(\Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico $fkFiscalizacaoFaturamentoServico)
    {
        $this->codProcesso = $fkFiscalizacaoFaturamentoServico->getCodProcesso();
        $this->competencia = $fkFiscalizacaoFaturamentoServico->getCompetencia();
        $this->codServico = $fkFiscalizacaoFaturamentoServico->getCodServico();
        $this->codAtividade = $fkFiscalizacaoFaturamentoServico->getCodAtividade();
        $this->ocorrencia = $fkFiscalizacaoFaturamentoServico->getOcorrencia();
        $this->fkFiscalizacaoFaturamentoServico = $fkFiscalizacaoFaturamentoServico;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFiscalizacaoFaturamentoServico
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico
     */
    public function getFkFiscalizacaoFaturamentoServico()
    {
        return $this->fkFiscalizacaoFaturamentoServico;
    }
}
