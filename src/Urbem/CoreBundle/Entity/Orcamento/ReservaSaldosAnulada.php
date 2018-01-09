<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * ReservaSaldosAnulada
 */
class ReservaSaldosAnulada
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
     * @var \DateTime
     */
    private $dtAnulacao;

    /**
     * @var string
     */
    private $motivoAnulacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos
     */
    private $fkOrcamentoReservaSaldos;

    public function __construct()
    {
        $this->dtAnulacao = new \DateTime();
    }

    /**
     * Set codReserva
     *
     * @param integer $codReserva
     * @return ReservaSaldosAnulada
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
     * @return ReservaSaldosAnulada
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
     * Set dtAnulacao
     *
     * @param \DateTime $dtAnulacao
     * @return ReservaSaldosAnulada
     */
    public function setDtAnulacao(\DateTime $dtAnulacao)
    {
        $this->dtAnulacao = $dtAnulacao;
        return $this;
    }

    /**
     * Get dtAnulacao
     *
     * @return \DateTime
     */
    public function getDtAnulacao()
    {
        return $this->dtAnulacao;
    }

    /**
     * Set motivoAnulacao
     *
     * @param string $motivoAnulacao
     * @return ReservaSaldosAnulada
     */
    public function setMotivoAnulacao($motivoAnulacao)
    {
        $this->motivoAnulacao = $motivoAnulacao;
        return $this;
    }

    /**
     * Get motivoAnulacao
     *
     * @return string
     */
    public function getMotivoAnulacao()
    {
        return $this->motivoAnulacao;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoReservaSaldos
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos $fkOrcamentoReservaSaldos
     * @return ReservaSaldosAnulada
     */
    public function setFkOrcamentoReservaSaldos(\Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos $fkOrcamentoReservaSaldos)
    {
        $this->codReserva = $fkOrcamentoReservaSaldos->getCodReserva();
        $this->exercicio = $fkOrcamentoReservaSaldos->getExercicio();
        $this->fkOrcamentoReservaSaldos = $fkOrcamentoReservaSaldos;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoReservaSaldos
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos
     */
    public function getFkOrcamentoReservaSaldos()
    {
        return $this->fkOrcamentoReservaSaldos;
    }
}
