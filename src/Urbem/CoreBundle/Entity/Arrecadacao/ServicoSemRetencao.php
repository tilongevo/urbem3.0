<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * ServicoSemRetencao
 */
class ServicoSemRetencao
{
    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * PK
     * @var integer
     */
    private $codServico;

    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

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
    private $valorLancado;

    /**
     * @var integer
     */
    private $aliquota;

    /**
     * @var integer
     */
    private $valorDeducaoLegal;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico
     */
    private $fkArrecadacaoFaturamentoServico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
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
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return ServicoSemRetencao
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ServicoSemRetencao
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
     * OneToOne (owning side)
     * Set ArrecadacaoFaturamentoServico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico $fkArrecadacaoFaturamentoServico
     * @return ServicoSemRetencao
     */
    public function setFkArrecadacaoFaturamentoServico(\Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico $fkArrecadacaoFaturamentoServico)
    {
        $this->codAtividade = $fkArrecadacaoFaturamentoServico->getCodAtividade();
        $this->codServico = $fkArrecadacaoFaturamentoServico->getCodServico();
        $this->inscricaoEconomica = $fkArrecadacaoFaturamentoServico->getInscricaoEconomica();
        $this->timestamp = $fkArrecadacaoFaturamentoServico->getTimestamp();
        $this->ocorrencia = $fkArrecadacaoFaturamentoServico->getOcorrencia();
        $this->fkArrecadacaoFaturamentoServico = $fkArrecadacaoFaturamentoServico;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkArrecadacaoFaturamentoServico
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico
     */
    public function getFkArrecadacaoFaturamentoServico()
    {
        return $this->fkArrecadacaoFaturamentoServico;
    }
}
