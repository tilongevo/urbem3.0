<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * EscalaTurno
 */
class EscalaTurno
{
    /**
     * PK
     * @var integer
     */
    private $codEscala;

    /**
     * PK
     * @var integer
     */
    private $codTurno;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $dtTurno;

    /**
     * @var \DateTime
     */
    private $horaEntrada1;

    /**
     * @var \DateTime
     */
    private $horaSaida1;

    /**
     * @var \DateTime
     */
    private $horaEntrada2;

    /**
     * @var \DateTime
     */
    private $horaSaida2;

    /**
     * @var string
     */
    private $tipo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\Escala
     */
    private $fkPontoEscala;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codEscala
     *
     * @param integer $codEscala
     * @return EscalaTurno
     */
    public function setCodEscala($codEscala)
    {
        $this->codEscala = $codEscala;
        return $this;
    }

    /**
     * Get codEscala
     *
     * @return integer
     */
    public function getCodEscala()
    {
        return $this->codEscala;
    }

    /**
     * Set codTurno
     *
     * @param integer $codTurno
     * @return EscalaTurno
     */
    public function setCodTurno($codTurno)
    {
        $this->codTurno = $codTurno;
        return $this;
    }

    /**
     * Get codTurno
     *
     * @return integer
     */
    public function getCodTurno()
    {
        return $this->codTurno;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return EscalaTurno
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set dtTurno
     *
     * @param \DateTime $dtTurno
     * @return EscalaTurno
     */
    public function setDtTurno(\DateTime $dtTurno)
    {
        $this->dtTurno = $dtTurno;
        return $this;
    }

    /**
     * Get dtTurno
     *
     * @return \DateTime
     */
    public function getDtTurno()
    {
        return $this->dtTurno;
    }

    /**
     * Set horaEntrada1
     *
     * @param \DateTime $horaEntrada1
     * @return EscalaTurno
     */
    public function setHoraEntrada1(\DateTime $horaEntrada1)
    {
        $this->horaEntrada1 = $horaEntrada1;
        return $this;
    }

    /**
     * Get horaEntrada1
     *
     * @return \DateTime
     */
    public function getHoraEntrada1()
    {
        return $this->horaEntrada1;
    }

    /**
     * Set horaSaida1
     *
     * @param \DateTime $horaSaida1
     * @return EscalaTurno
     */
    public function setHoraSaida1(\DateTime $horaSaida1)
    {
        $this->horaSaida1 = $horaSaida1;
        return $this;
    }

    /**
     * Get horaSaida1
     *
     * @return \DateTime
     */
    public function getHoraSaida1()
    {
        return $this->horaSaida1;
    }

    /**
     * Set horaEntrada2
     *
     * @param \DateTime $horaEntrada2
     * @return EscalaTurno
     */
    public function setHoraEntrada2(\DateTime $horaEntrada2)
    {
        $this->horaEntrada2 = $horaEntrada2;
        return $this;
    }

    /**
     * Get horaEntrada2
     *
     * @return \DateTime
     */
    public function getHoraEntrada2()
    {
        return $this->horaEntrada2;
    }

    /**
     * Set horaSaida2
     *
     * @param \DateTime $horaSaida2
     * @return EscalaTurno
     */
    public function setHoraSaida2(\DateTime $horaSaida2)
    {
        $this->horaSaida2 = $horaSaida2;
        return $this;
    }

    /**
     * Get horaSaida2
     *
     * @return \DateTime
     */
    public function getHoraSaida2()
    {
        return $this->horaSaida2;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return EscalaTurno
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
     * ManyToOne (inverse side)
     * Set fkPontoEscala
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\Escala $fkPontoEscala
     * @return EscalaTurno
     */
    public function setFkPontoEscala(\Urbem\CoreBundle\Entity\Ponto\Escala $fkPontoEscala)
    {
        $this->codEscala = $fkPontoEscala->getCodEscala();
        $this->fkPontoEscala = $fkPontoEscala;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoEscala
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\Escala
     */
    public function getFkPontoEscala()
    {
        return $this->fkPontoEscala;
    }
}
