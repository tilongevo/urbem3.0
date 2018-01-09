<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * ReservaSaldos
 */
class ReservaSaldos
{
    /**
     * PK
     * @var integer
     */
    private $codReserva;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codDespesa;

    /**
     * @var \DateTime
     */
    private $dtValidadeInicial;

    /**
     * @var \DateTime
     */
    private $dtValidadeFinal;

    /**
     * @var \DateTime
     */
    private $dtInclusao;

    /**
     * @var integer
     */
    private $vlReserva = 0;

    /**
     * @var string
     */
    private $tipo = 'A';

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\AutorizacaoReserva
     */
    private $fkEmpenhoAutorizacaoReserva;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\ReservaSaldosAnulada
     */
    private $fkOrcamentoReservaSaldosAnulada;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva
     */
    private $fkComprasSolicitacaoHomologadaReservas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaItemReserva
     */
    private $fkComprasMapaItemReservas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    private $fkOrcamentoDespesa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasSolicitacaoHomologadaReservas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasMapaItemReservas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtInclusao = new \DateTime();
    }

    /**
     * Set codReserva
     *
     * @param integer $codReserva
     * @return ReservaSaldos
     */
    public function setCodReserva($codReserva)
    {
        $this->codReserva = $codReserva;
        return $this;
    }

    /**
     * Get codReserva
     *
     * @return integer
     */
    public function getCodReserva()
    {
        return $this->codReserva;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ReservaSaldos
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
     * Set codDespesa
     *
     * @param integer $codDespesa
     * @return ReservaSaldos
     */
    public function setCodDespesa($codDespesa)
    {
        $this->codDespesa = $codDespesa;
        return $this;
    }

    /**
     * Get codDespesa
     *
     * @return integer
     */
    public function getCodDespesa()
    {
        return $this->codDespesa;
    }

    /**
     * Set dtValidadeInicial
     *
     * @param \DateTime $dtValidadeInicial
     * @return ReservaSaldos
     */
    public function setDtValidadeInicial(\DateTime $dtValidadeInicial)
    {
        $this->dtValidadeInicial = $dtValidadeInicial;
        return $this;
    }

    /**
     * Get dtValidadeInicial
     *
     * @return \DateTime
     */
    public function getDtValidadeInicial()
    {
        return $this->dtValidadeInicial;
    }

    /**
     * Set dtValidadeFinal
     *
     * @param \DateTime $dtValidadeFinal
     * @return ReservaSaldos
     */
    public function setDtValidadeFinal(\DateTime $dtValidadeFinal)
    {
        $this->dtValidadeFinal = $dtValidadeFinal;
        return $this;
    }

    /**
     * Get dtValidadeFinal
     *
     * @return \DateTime
     */
    public function getDtValidadeFinal()
    {
        return $this->dtValidadeFinal;
    }

    /**
     * Set dtInclusao
     *
     * @param \DateTime $dtInclusao
     * @return ReservaSaldos
     */
    public function setDtInclusao(\DateTime $dtInclusao)
    {
        $this->dtInclusao = $dtInclusao;
        return $this;
    }

    /**
     * Get dtInclusao
     *
     * @return \DateTime
     */
    public function getDtInclusao()
    {
        return $this->dtInclusao;
    }

    /**
     * Set vlReserva
     *
     * @param integer $vlReserva
     * @return ReservaSaldos
     */
    public function setVlReserva($vlReserva)
    {
        $this->vlReserva = $vlReserva;
        return $this;
    }

    /**
     * Get vlReserva
     *
     * @return integer
     */
    public function getVlReserva()
    {
        return $this->vlReserva;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return ReservaSaldos
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
     * Set motivo
     *
     * @param string $motivo
     * @return ReservaSaldos
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoHomologadaReserva
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva $fkComprasSolicitacaoHomologadaReserva
     * @return ReservaSaldos
     */
    public function addFkComprasSolicitacaoHomologadaReservas(\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva $fkComprasSolicitacaoHomologadaReserva)
    {
        if (false === $this->fkComprasSolicitacaoHomologadaReservas->contains($fkComprasSolicitacaoHomologadaReserva)) {
            $fkComprasSolicitacaoHomologadaReserva->setFkOrcamentoReservaSaldos($this);
            $this->fkComprasSolicitacaoHomologadaReservas->add($fkComprasSolicitacaoHomologadaReserva);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacaoHomologadaReserva
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva $fkComprasSolicitacaoHomologadaReserva
     */
    public function removeFkComprasSolicitacaoHomologadaReservas(\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva $fkComprasSolicitacaoHomologadaReserva)
    {
        $this->fkComprasSolicitacaoHomologadaReservas->removeElement($fkComprasSolicitacaoHomologadaReserva);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacaoHomologadaReservas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva
     */
    public function getFkComprasSolicitacaoHomologadaReservas()
    {
        return $this->fkComprasSolicitacaoHomologadaReservas;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasMapaItemReserva
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItemReserva $fkComprasMapaItemReserva
     * @return ReservaSaldos
     */
    public function addFkComprasMapaItemReservas(\Urbem\CoreBundle\Entity\Compras\MapaItemReserva $fkComprasMapaItemReserva)
    {
        if (false === $this->fkComprasMapaItemReservas->contains($fkComprasMapaItemReserva)) {
            $fkComprasMapaItemReserva->setFkOrcamentoReservaSaldos($this);
            $this->fkComprasMapaItemReservas->add($fkComprasMapaItemReserva);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasMapaItemReserva
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItemReserva $fkComprasMapaItemReserva
     */
    public function removeFkComprasMapaItemReservas(\Urbem\CoreBundle\Entity\Compras\MapaItemReserva $fkComprasMapaItemReserva)
    {
        $this->fkComprasMapaItemReservas->removeElement($fkComprasMapaItemReserva);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasMapaItemReservas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaItemReserva
     */
    public function getFkComprasMapaItemReservas()
    {
        return $this->fkComprasMapaItemReservas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     * @return ReservaSaldos
     */
    public function setFkOrcamentoDespesa(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        $this->exercicio = $fkOrcamentoDespesa->getExercicio();
        $this->codDespesa = $fkOrcamentoDespesa->getCodDespesa();
        $this->fkOrcamentoDespesa = $fkOrcamentoDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    public function getFkOrcamentoDespesa()
    {
        return $this->fkOrcamentoDespesa;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoAutorizacaoReserva
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoReserva $fkEmpenhoAutorizacaoReserva
     * @return ReservaSaldos
     */
    public function setFkEmpenhoAutorizacaoReserva(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoReserva $fkEmpenhoAutorizacaoReserva)
    {
        $fkEmpenhoAutorizacaoReserva->setFkOrcamentoReservaSaldos($this);
        $this->fkEmpenhoAutorizacaoReserva = $fkEmpenhoAutorizacaoReserva;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoAutorizacaoReserva
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\AutorizacaoReserva
     */
    public function getFkEmpenhoAutorizacaoReserva()
    {
        return $this->fkEmpenhoAutorizacaoReserva;
    }

    /**
     * OneToOne (inverse side)
     * Set OrcamentoReservaSaldosAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReservaSaldosAnulada $fkOrcamentoReservaSaldosAnulada
     * @return ReservaSaldos
     */
    public function setFkOrcamentoReservaSaldosAnulada(\Urbem\CoreBundle\Entity\Orcamento\ReservaSaldosAnulada $fkOrcamentoReservaSaldosAnulada)
    {
        $fkOrcamentoReservaSaldosAnulada->setFkOrcamentoReservaSaldos($this);
        $this->fkOrcamentoReservaSaldosAnulada = $fkOrcamentoReservaSaldosAnulada;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkOrcamentoReservaSaldosAnulada
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ReservaSaldosAnulada
     */
    public function getFkOrcamentoReservaSaldosAnulada()
    {
        return $this->fkOrcamentoReservaSaldosAnulada;
    }

    /**
     * @return string
     */
    public function getSituacao()
    {
        $now = new \DateTime();

        if ($this->getFkOrcamentoReservaSaldosAnulada() != null) {
            return 'label.reservaSaldos.anulada';
        } elseif ($this->dtValidadeFinal < $now) {
            return 'label.reservaSaldos.inativa';
        } else {
            return 'label.reservaSaldos.ativa';
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->codReserva, $this->exercicio);
    }
}
