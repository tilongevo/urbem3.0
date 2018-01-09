<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * NotaServico
 */
class NotaServico
{
    /**
     * PK
     * @var integer
     */
    private $codNota;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico
     */
    private $fkFiscalizacaoFaturamentoServico;


    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaServico
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
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return NotaServico
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
     * @return NotaServico
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
     * @return NotaServico
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
     * @return NotaServico
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
     * @return NotaServico
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
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoFaturamentoServico
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico $fkFiscalizacaoFaturamentoServico
     * @return NotaServico
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
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoFaturamentoServico
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico
     */
    public function getFkFiscalizacaoFaturamentoServico()
    {
        return $this->fkFiscalizacaoFaturamentoServico;
    }
}
