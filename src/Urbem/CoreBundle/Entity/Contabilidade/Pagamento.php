<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * Pagamento
 */
class Pagamento
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * PK
     * @var string
     */
    private $tipo;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codNota;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $exercicioLiquidacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PagamentoEstorno
     */
    private $fkContabilidadePagamentoEstorno;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho
     */
    private $fkContabilidadeLancamentoEmpenho;

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
     * Set exercicio
     *
     * @param string $exercicio
     * @return Pagamento
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return Pagamento
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Pagamento
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return Pagamento
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Pagamento
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
     * Set codNota
     *
     * @param integer $codNota
     * @return Pagamento
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Pagamento
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
     * Set exercicioLiquidacao
     *
     * @param string $exercicioLiquidacao
     * @return Pagamento
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
     * ManyToOne (inverse side)
     * Set fkEmpenhoNotaLiquidacaoPaga
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga $fkEmpenhoNotaLiquidacaoPaga
     * @return Pagamento
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

    /**
     * OneToOne (inverse side)
     * Set ContabilidadePagamentoEstorno
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PagamentoEstorno $fkContabilidadePagamentoEstorno
     * @return Pagamento
     */
    public function setFkContabilidadePagamentoEstorno(\Urbem\CoreBundle\Entity\Contabilidade\PagamentoEstorno $fkContabilidadePagamentoEstorno)
    {
        $fkContabilidadePagamentoEstorno->setFkContabilidadePagamento($this);
        $this->fkContabilidadePagamentoEstorno = $fkContabilidadePagamentoEstorno;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkContabilidadePagamentoEstorno
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PagamentoEstorno
     */
    public function getFkContabilidadePagamentoEstorno()
    {
        return $this->fkContabilidadePagamentoEstorno;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadeLancamentoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho $fkContabilidadeLancamentoEmpenho
     * @return Pagamento
     */
    public function setFkContabilidadeLancamentoEmpenho(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho $fkContabilidadeLancamentoEmpenho)
    {
        $this->codLote = $fkContabilidadeLancamentoEmpenho->getCodLote();
        $this->tipo = $fkContabilidadeLancamentoEmpenho->getTipo();
        $this->sequencia = $fkContabilidadeLancamentoEmpenho->getSequencia();
        $this->exercicio = $fkContabilidadeLancamentoEmpenho->getExercicio();
        $this->codEntidade = $fkContabilidadeLancamentoEmpenho->getCodEntidade();
        $this->fkContabilidadeLancamentoEmpenho = $fkContabilidadeLancamentoEmpenho;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkContabilidadeLancamentoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho
     */
    public function getFkContabilidadeLancamentoEmpenho()
    {
        return $this->fkContabilidadeLancamentoEmpenho;
    }
}
