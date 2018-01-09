<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwLancamento
 */
class SwLancamento
{
    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var string
     */
    private $tipo;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codHistorico;

    /**
     * @var string
     */
    private $complemento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwEmpenhamento
     */
    private $fkSwEmpenhamento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwLancamentoReceita
     */
    private $fkSwLancamentoReceita;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwLancamentoEmpenho
     */
    private $fkSwLancamentoEmpenho;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwLancamentoTransferencia
     */
    private $fkSwLancamentoTransferencia;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwLiquidacao
     */
    private $fkSwLiquidacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwPagamento
     */
    private $fkSwPagamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwValorLancamento
     */
    private $fkSwValorLancamentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwLote
     */
    private $fkSwLote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwHistoricoContabil
     */
    private $fkSwHistoricoContabil;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwValorLancamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set sequencia
     *
     * @param integer $sequencia
     * @return SwLancamento
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
     * Set codLote
     *
     * @param integer $codLote
     * @return SwLancamento
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
     * Set tipo
     *
     * @param string $tipo
     * @return SwLancamento
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwLancamento
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
     * Set codHistorico
     *
     * @param integer $codHistorico
     * @return SwLancamento
     */
    public function setCodHistorico($codHistorico)
    {
        $this->codHistorico = $codHistorico;
        return $this;
    }

    /**
     * Get codHistorico
     *
     * @return integer
     */
    public function getCodHistorico()
    {
        return $this->codHistorico;
    }

    /**
     * Set complemento
     *
     * @param string $complemento
     * @return SwLancamento
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
        return $this;
    }

    /**
     * Get complemento
     *
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * OneToMany (owning side)
     * Add SwValorLancamento
     *
     * @param \Urbem\CoreBundle\Entity\SwValorLancamento $fkSwValorLancamento
     * @return SwLancamento
     */
    public function addFkSwValorLancamentos(\Urbem\CoreBundle\Entity\SwValorLancamento $fkSwValorLancamento)
    {
        if (false === $this->fkSwValorLancamentos->contains($fkSwValorLancamento)) {
            $fkSwValorLancamento->setFkSwLancamento($this);
            $this->fkSwValorLancamentos->add($fkSwValorLancamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwValorLancamento
     *
     * @param \Urbem\CoreBundle\Entity\SwValorLancamento $fkSwValorLancamento
     */
    public function removeFkSwValorLancamentos(\Urbem\CoreBundle\Entity\SwValorLancamento $fkSwValorLancamento)
    {
        $this->fkSwValorLancamentos->removeElement($fkSwValorLancamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwValorLancamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwValorLancamento
     */
    public function getFkSwValorLancamentos()
    {
        return $this->fkSwValorLancamentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwLote
     *
     * @param \Urbem\CoreBundle\Entity\SwLote $fkSwLote
     * @return SwLancamento
     */
    public function setFkSwLote(\Urbem\CoreBundle\Entity\SwLote $fkSwLote)
    {
        $this->codLote = $fkSwLote->getCodLote();
        $this->exercicio = $fkSwLote->getExercicio();
        $this->tipo = $fkSwLote->getTipo();
        $this->fkSwLote = $fkSwLote;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwLote
     *
     * @return \Urbem\CoreBundle\Entity\SwLote
     */
    public function getFkSwLote()
    {
        return $this->fkSwLote;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwHistoricoContabil
     *
     * @param \Urbem\CoreBundle\Entity\SwHistoricoContabil $fkSwHistoricoContabil
     * @return SwLancamento
     */
    public function setFkSwHistoricoContabil(\Urbem\CoreBundle\Entity\SwHistoricoContabil $fkSwHistoricoContabil)
    {
        $this->codHistorico = $fkSwHistoricoContabil->getCodHistorico();
        $this->exercicio = $fkSwHistoricoContabil->getExercicio();
        $this->fkSwHistoricoContabil = $fkSwHistoricoContabil;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwHistoricoContabil
     *
     * @return \Urbem\CoreBundle\Entity\SwHistoricoContabil
     */
    public function getFkSwHistoricoContabil()
    {
        return $this->fkSwHistoricoContabil;
    }

    /**
     * OneToOne (inverse side)
     * Set SwEmpenhamento
     *
     * @param \Urbem\CoreBundle\Entity\SwEmpenhamento $fkSwEmpenhamento
     * @return SwLancamento
     */
    public function setFkSwEmpenhamento(\Urbem\CoreBundle\Entity\SwEmpenhamento $fkSwEmpenhamento)
    {
        $fkSwEmpenhamento->setFkSwLancamento($this);
        $this->fkSwEmpenhamento = $fkSwEmpenhamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwEmpenhamento
     *
     * @return \Urbem\CoreBundle\Entity\SwEmpenhamento
     */
    public function getFkSwEmpenhamento()
    {
        return $this->fkSwEmpenhamento;
    }

    /**
     * OneToOne (inverse side)
     * Set SwLancamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\SwLancamentoReceita $fkSwLancamentoReceita
     * @return SwLancamento
     */
    public function setFkSwLancamentoReceita(\Urbem\CoreBundle\Entity\SwLancamentoReceita $fkSwLancamentoReceita)
    {
        $fkSwLancamentoReceita->setFkSwLancamento($this);
        $this->fkSwLancamentoReceita = $fkSwLancamentoReceita;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwLancamentoReceita
     *
     * @return \Urbem\CoreBundle\Entity\SwLancamentoReceita
     */
    public function getFkSwLancamentoReceita()
    {
        return $this->fkSwLancamentoReceita;
    }

    /**
     * OneToOne (inverse side)
     * Set SwLancamentoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwLancamentoEmpenho $fkSwLancamentoEmpenho
     * @return SwLancamento
     */
    public function setFkSwLancamentoEmpenho(\Urbem\CoreBundle\Entity\SwLancamentoEmpenho $fkSwLancamentoEmpenho)
    {
        $fkSwLancamentoEmpenho->setFkSwLancamento($this);
        $this->fkSwLancamentoEmpenho = $fkSwLancamentoEmpenho;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwLancamentoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\SwLancamentoEmpenho
     */
    public function getFkSwLancamentoEmpenho()
    {
        return $this->fkSwLancamentoEmpenho;
    }

    /**
     * OneToOne (inverse side)
     * Set SwLancamentoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\SwLancamentoTransferencia $fkSwLancamentoTransferencia
     * @return SwLancamento
     */
    public function setFkSwLancamentoTransferencia(\Urbem\CoreBundle\Entity\SwLancamentoTransferencia $fkSwLancamentoTransferencia)
    {
        $fkSwLancamentoTransferencia->setFkSwLancamento($this);
        $this->fkSwLancamentoTransferencia = $fkSwLancamentoTransferencia;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwLancamentoTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\SwLancamentoTransferencia
     */
    public function getFkSwLancamentoTransferencia()
    {
        return $this->fkSwLancamentoTransferencia;
    }

    /**
     * OneToOne (inverse side)
     * Set SwLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\SwLiquidacao $fkSwLiquidacao
     * @return SwLancamento
     */
    public function setFkSwLiquidacao(\Urbem\CoreBundle\Entity\SwLiquidacao $fkSwLiquidacao)
    {
        $fkSwLiquidacao->setFkSwLancamento($this);
        $this->fkSwLiquidacao = $fkSwLiquidacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\SwLiquidacao
     */
    public function getFkSwLiquidacao()
    {
        return $this->fkSwLiquidacao;
    }

    /**
     * OneToOne (inverse side)
     * Set SwPagamento
     *
     * @param \Urbem\CoreBundle\Entity\SwPagamento $fkSwPagamento
     * @return SwLancamento
     */
    public function setFkSwPagamento(\Urbem\CoreBundle\Entity\SwPagamento $fkSwPagamento)
    {
        $fkSwPagamento->setFkSwLancamento($this);
        $this->fkSwPagamento = $fkSwPagamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwPagamento
     *
     * @return \Urbem\CoreBundle\Entity\SwPagamento
     */
    public function getFkSwPagamento()
    {
        return $this->fkSwPagamento;
    }
}
