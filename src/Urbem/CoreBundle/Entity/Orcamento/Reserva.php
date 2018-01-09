<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * Reserva
 */
class Reserva
{
    /**
     * PK
     * @var integer
     */
    private $codReserva;

    /**
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
    private $vlReserva;

    /**
     * @var boolean
     */
    private $anulada;


    /**
     * Set codReserva
     *
     * @param integer $codReserva
     * @return Reserva
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
     * @return Reserva
     */
    public function setExercicio($exercicio = null)
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
     * @return Reserva
     */
    public function setCodDespesa($codDespesa = null)
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
     * @return Reserva
     */
    public function setDtValidadeInicial(\DateTime $dtValidadeInicial = null)
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
     * @return Reserva
     */
    public function setDtValidadeFinal(\DateTime $dtValidadeFinal = null)
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
     * @return Reserva
     */
    public function setDtInclusao(\DateTime $dtInclusao = null)
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
     * @return Reserva
     */
    public function setVlReserva($vlReserva = null)
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
     * Set anulada
     *
     * @param boolean $anulada
     * @return Reserva
     */
    public function setAnulada($anulada = null)
    {
        $this->anulada = $anulada;
        return $this;
    }

    /**
     * Get anulada
     *
     * @return boolean
     */
    public function getAnulada()
    {
        return $this->anulada;
    }
}
