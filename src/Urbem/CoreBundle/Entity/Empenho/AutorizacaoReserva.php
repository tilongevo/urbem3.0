<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * AutorizacaoReserva
 */
class AutorizacaoReserva
{
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
    private $codAutorizacao;

    /**
     * @var integer
     */
    private $codReserva;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho
     */
    private $fkEmpenhoAutorizacaoEmpenho;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos
     */
    private $fkOrcamentoReservaSaldos;


    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return AutorizacaoReserva
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
     * @return AutorizacaoReserva
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
     * Set codAutorizacao
     *
     * @param integer $codAutorizacao
     * @return AutorizacaoReserva
     */
    public function setCodAutorizacao($codAutorizacao)
    {
        $this->codAutorizacao = $codAutorizacao;
        return $this;
    }

    /**
     * Get codAutorizacao
     *
     * @return integer
     */
    public function getCodAutorizacao()
    {
        return $this->codAutorizacao;
    }

    /**
     * Set codReserva
     *
     * @param integer $codReserva
     * @return AutorizacaoReserva
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
     * OneToOne (owning side)
     * Set EmpenhoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho
     * @return AutorizacaoReserva
     */
    public function setFkEmpenhoAutorizacaoEmpenho(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho)
    {
        $this->codAutorizacao = $fkEmpenhoAutorizacaoEmpenho->getCodAutorizacao();
        $this->exercicio = $fkEmpenhoAutorizacaoEmpenho->getExercicio();
        $this->codEntidade = $fkEmpenhoAutorizacaoEmpenho->getCodEntidade();
        $this->fkEmpenhoAutorizacaoEmpenho = $fkEmpenhoAutorizacaoEmpenho;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoAutorizacaoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho
     */
    public function getFkEmpenhoAutorizacaoEmpenho()
    {
        return $this->fkEmpenhoAutorizacaoEmpenho;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoReservaSaldos
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos $fkOrcamentoReservaSaldos
     * @return AutorizacaoReserva
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
