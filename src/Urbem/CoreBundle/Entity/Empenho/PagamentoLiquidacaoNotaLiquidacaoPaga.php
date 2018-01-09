<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * PagamentoLiquidacaoNotaLiquidacaoPaga
 */
class PagamentoLiquidacaoNotaLiquidacaoPaga
{
    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * PK
     * @var string
     */
    private $exercicioLiquidacao;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codOrdem;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao
     */
    private $fkEmpenhoPagamentoLiquidacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga
     */
    private $fkEmpenhoNotaLiquidacaoPaga;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return PagamentoLiquidacaoNotaLiquidacaoPaga
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
     * Set exercicioLiquidacao
     *
     * @param string $exercicioLiquidacao
     * @return PagamentoLiquidacaoNotaLiquidacaoPaga
     */
    public function setExercicioLiquidacao($exercicioLiquidacao)
    {
        $this->exercicioLiquidacao = $exercicioLiquidacao;
        return $this;
    }

    /**
     * Get exercicioLiquidacao
     *
     * @return string
     */
    public function getExercicioLiquidacao()
    {
        return $this->exercicioLiquidacao;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return PagamentoLiquidacaoNotaLiquidacaoPaga
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PagamentoLiquidacaoNotaLiquidacaoPaga
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return PagamentoLiquidacaoNotaLiquidacaoPaga
     */
    public function setCodOrdem($codOrdem)
    {
        $this->codOrdem = $codOrdem;
        return $this;
    }

    /**
     * Get codOrdem
     *
     * @return integer
     */
    public function getCodOrdem()
    {
        return $this->codOrdem;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return PagamentoLiquidacaoNotaLiquidacaoPaga
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
     * ManyToOne (inverse side)
     * Set fkEmpenhoPagamentoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao $fkEmpenhoPagamentoLiquidacao
     * @return PagamentoLiquidacaoNotaLiquidacaoPaga
     */
    public function setFkEmpenhoPagamentoLiquidacao(\Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao $fkEmpenhoPagamentoLiquidacao)
    {
        $this->codOrdem = $fkEmpenhoPagamentoLiquidacao->getCodOrdem();
        $this->exercicio = $fkEmpenhoPagamentoLiquidacao->getExercicio();
        $this->codEntidade = $fkEmpenhoPagamentoLiquidacao->getCodEntidade();
        $this->exercicioLiquidacao = $fkEmpenhoPagamentoLiquidacao->getExercicioLiquidacao();
        $this->codNota = $fkEmpenhoPagamentoLiquidacao->getCodNota();
        $this->fkEmpenhoPagamentoLiquidacao = $fkEmpenhoPagamentoLiquidacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoPagamentoLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao
     */
    public function getFkEmpenhoPagamentoLiquidacao()
    {
        return $this->fkEmpenhoPagamentoLiquidacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoNotaLiquidacaoPaga
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga $fkEmpenhoNotaLiquidacaoPaga
     * @return PagamentoLiquidacaoNotaLiquidacaoPaga
     */
    public function setFkEmpenhoNotaLiquidacaoPaga(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga $fkEmpenhoNotaLiquidacaoPaga)
    {
        $this->codEntidade = $fkEmpenhoNotaLiquidacaoPaga->getCodEntidade();
        $this->codNota = $fkEmpenhoNotaLiquidacaoPaga->getCodNota();
        $this->exercicioLiquidacao = $fkEmpenhoNotaLiquidacaoPaga->getExercicio();
        $this->timestamp = $fkEmpenhoNotaLiquidacaoPaga->getTimestamp();
        $this->fkEmpenhoNotaLiquidacaoPaga = $fkEmpenhoNotaLiquidacaoPaga;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoNotaLiquidacaoPaga
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga
     */
    public function getFkEmpenhoNotaLiquidacaoPaga()
    {
        return $this->fkEmpenhoNotaLiquidacaoPaga;
    }
}
