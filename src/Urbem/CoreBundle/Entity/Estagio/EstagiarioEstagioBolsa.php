<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * EstagiarioEstagioBolsa
 */
class EstagiarioEstagioBolsa
{
    /**
     * PK
     * @var integer
     */
    private $cgmInstituicaoEnsino;

    /**
     * PK
     * @var integer
     */
    private $cgmEstagiario;

    /**
     * PK
     * @var integer
     */
    private $codCurso;

    /**
     * PK
     * @var integer
     */
    private $codEstagio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $vlBolsa;

    /**
     * @var integer
     */
    private $faltas;

    /**
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * @var boolean
     */
    private $valeRefeicao = false;

    /**
     * @var boolean
     */
    private $valeTransporte = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Estagio\EstagiarioValeTransporte
     */
    private $fkEstagioEstagiarioValeTransporte;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Estagio\EstagiarioValeRefeicao
     */
    private $fkEstagioEstagiarioValeRefeicao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio
     */
    private $fkEstagioEstagiarioEstagio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao
     */
    private $fkFolhapagamentoPeriodoMovimentacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set cgmInstituicaoEnsino
     *
     * @param integer $cgmInstituicaoEnsino
     * @return EstagiarioEstagioBolsa
     */
    public function setCgmInstituicaoEnsino($cgmInstituicaoEnsino)
    {
        $this->cgmInstituicaoEnsino = $cgmInstituicaoEnsino;
        return $this;
    }

    /**
     * Get cgmInstituicaoEnsino
     *
     * @return integer
     */
    public function getCgmInstituicaoEnsino()
    {
        return $this->cgmInstituicaoEnsino;
    }

    /**
     * Set cgmEstagiario
     *
     * @param integer $cgmEstagiario
     * @return EstagiarioEstagioBolsa
     */
    public function setCgmEstagiario($cgmEstagiario)
    {
        $this->cgmEstagiario = $cgmEstagiario;
        return $this;
    }

    /**
     * Get cgmEstagiario
     *
     * @return integer
     */
    public function getCgmEstagiario()
    {
        return $this->cgmEstagiario;
    }

    /**
     * Set codCurso
     *
     * @param integer $codCurso
     * @return EstagiarioEstagioBolsa
     */
    public function setCodCurso($codCurso)
    {
        $this->codCurso = $codCurso;
        return $this;
    }

    /**
     * Get codCurso
     *
     * @return integer
     */
    public function getCodCurso()
    {
        return $this->codCurso;
    }

    /**
     * Set codEstagio
     *
     * @param integer $codEstagio
     * @return EstagiarioEstagioBolsa
     */
    public function setCodEstagio($codEstagio)
    {
        $this->codEstagio = $codEstagio;
        return $this;
    }

    /**
     * Get codEstagio
     *
     * @return integer
     */
    public function getCodEstagio()
    {
        return $this->codEstagio;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return EstagiarioEstagioBolsa
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
     * Set vlBolsa
     *
     * @param integer $vlBolsa
     * @return EstagiarioEstagioBolsa
     */
    public function setVlBolsa($vlBolsa)
    {
        $this->vlBolsa = $vlBolsa;
        return $this;
    }

    /**
     * Get vlBolsa
     *
     * @return integer
     */
    public function getVlBolsa()
    {
        return $this->vlBolsa;
    }

    /**
     * Set faltas
     *
     * @param integer $faltas
     * @return EstagiarioEstagioBolsa
     */
    public function setFaltas($faltas = null)
    {
        $this->faltas = $faltas;
        return $this;
    }

    /**
     * Get faltas
     *
     * @return integer
     */
    public function getFaltas()
    {
        return $this->faltas;
    }

    /**
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return EstagiarioEstagioBolsa
     */
    public function setCodPeriodoMovimentacao($codPeriodoMovimentacao)
    {
        $this->codPeriodoMovimentacao = $codPeriodoMovimentacao;
        return $this;
    }

    /**
     * Get codPeriodoMovimentacao
     *
     * @return integer
     */
    public function getCodPeriodoMovimentacao()
    {
        return $this->codPeriodoMovimentacao;
    }

    /**
     * Set valeRefeicao
     *
     * @param boolean $valeRefeicao
     * @return EstagiarioEstagioBolsa
     */
    public function setValeRefeicao($valeRefeicao)
    {
        $this->valeRefeicao = $valeRefeicao;
        return $this;
    }

    /**
     * Get valeRefeicao
     *
     * @return boolean
     */
    public function getValeRefeicao()
    {
        return $this->valeRefeicao;
    }

    /**
     * Set valeTransporte
     *
     * @param boolean $valeTransporte
     * @return EstagiarioEstagioBolsa
     */
    public function setValeTransporte($valeTransporte)
    {
        $this->valeTransporte = $valeTransporte;
        return $this;
    }

    /**
     * Get valeTransporte
     *
     * @return boolean
     */
    public function getValeTransporte()
    {
        return $this->valeTransporte;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEstagioEstagiarioEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio
     * @return EstagiarioEstagioBolsa
     */
    public function setFkEstagioEstagiarioEstagio(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio)
    {
        $this->codEstagio = $fkEstagioEstagiarioEstagio->getCodEstagio();
        $this->cgmEstagiario = $fkEstagioEstagiarioEstagio->getCgmEstagiario();
        $this->codCurso = $fkEstagioEstagiarioEstagio->getCodCurso();
        $this->cgmInstituicaoEnsino = $fkEstagioEstagiarioEstagio->getCgmInstituicaoEnsino();
        $this->fkEstagioEstagiarioEstagio = $fkEstagioEstagiarioEstagio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEstagioEstagiarioEstagio
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio
     */
    public function getFkEstagioEstagiarioEstagio()
    {
        return $this->fkEstagioEstagiarioEstagio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPeriodoMovimentacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao $fkFolhapagamentoPeriodoMovimentacao
     * @return EstagiarioEstagioBolsa
     */
    public function setFkFolhapagamentoPeriodoMovimentacao(\Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao $fkFolhapagamentoPeriodoMovimentacao)
    {
        $this->codPeriodoMovimentacao = $fkFolhapagamentoPeriodoMovimentacao->getCodPeriodoMovimentacao();
        $this->fkFolhapagamentoPeriodoMovimentacao = $fkFolhapagamentoPeriodoMovimentacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPeriodoMovimentacao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao
     */
    public function getFkFolhapagamentoPeriodoMovimentacao()
    {
        return $this->fkFolhapagamentoPeriodoMovimentacao;
    }

    /**
     * OneToOne (inverse side)
     * Set EstagioEstagiarioValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioValeTransporte $fkEstagioEstagiarioValeTransporte
     * @return EstagiarioEstagioBolsa
     */
    public function setFkEstagioEstagiarioValeTransporte(\Urbem\CoreBundle\Entity\Estagio\EstagiarioValeTransporte $fkEstagioEstagiarioValeTransporte)
    {
        $fkEstagioEstagiarioValeTransporte->setFkEstagioEstagiarioEstagioBolsa($this);
        $this->fkEstagioEstagiarioValeTransporte = $fkEstagioEstagiarioValeTransporte;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEstagioEstagiarioValeTransporte
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\EstagiarioValeTransporte
     */
    public function getFkEstagioEstagiarioValeTransporte()
    {
        return $this->fkEstagioEstagiarioValeTransporte;
    }

    /**
     * OneToOne (inverse side)
     * Set EstagioEstagiarioValeRefeicao
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioValeRefeicao $fkEstagioEstagiarioValeRefeicao
     * @return EstagiarioEstagioBolsa
     */
    public function setFkEstagioEstagiarioValeRefeicao(\Urbem\CoreBundle\Entity\Estagio\EstagiarioValeRefeicao $fkEstagioEstagiarioValeRefeicao)
    {
        $fkEstagioEstagiarioValeRefeicao->setFkEstagioEstagiarioEstagioBolsa($this);
        $this->fkEstagioEstagiarioValeRefeicao = $fkEstagioEstagiarioValeRefeicao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEstagioEstagiarioValeRefeicao
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\EstagiarioValeRefeicao
     */
    public function getFkEstagioEstagiarioValeRefeicao()
    {
        return $this->fkEstagioEstagiarioValeRefeicao;
    }
}
