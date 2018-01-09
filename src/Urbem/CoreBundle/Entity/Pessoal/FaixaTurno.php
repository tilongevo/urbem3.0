<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * FaixaTurno
 */
class FaixaTurno
{
    /**
     * PK
     * @var integer
     */
    private $codTurno;

    /**
     * PK
     * @var integer
     */
    private $codGrade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codDia;

    /**
     * @var \DateTime
     */
    private $horaEntrada;

    /**
     * @var \DateTime
     */
    private $horaSaida;

    /**
     * @var \DateTime
     */
    private $horaEntrada2;

    /**
     * @var \DateTime
     */
    private $horaSaida2;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\GradeHorario
     */
    private $fkPessoalGradeHorario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\DiasTurno
     */
    private $fkPessoalDiasTurno;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codTurno
     *
     * @param integer $codTurno
     * @return FaixaTurno
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
     * Set codGrade
     *
     * @param integer $codGrade
     * @return FaixaTurno
     */
    public function setCodGrade($codGrade)
    {
        $this->codGrade = $codGrade;
        return $this;
    }

    /**
     * Get codGrade
     *
     * @return integer
     */
    public function getCodGrade()
    {
        return $this->codGrade;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return FaixaTurno
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
     * Set codDia
     *
     * @param integer $codDia
     * @return FaixaTurno
     */
    public function setCodDia($codDia)
    {
        $this->codDia = $codDia;
        return $this;
    }

    /**
     * Get codDia
     *
     * @return integer
     */
    public function getCodDia()
    {
        return $this->codDia;
    }

    /**
     * Set horaEntrada
     *
     * @param \DateTime $horaEntrada
     * @return FaixaTurno
     */
    public function setHoraEntrada(\DateTime $horaEntrada)
    {
        $this->horaEntrada = $horaEntrada;
        return $this;
    }

    /**
     * Get horaEntrada
     *
     * @return \DateTime
     */
    public function getHoraEntrada()
    {
        return $this->horaEntrada;
    }

    /**
     * Set horaSaida
     *
     * @param \DateTime $horaSaida
     * @return FaixaTurno
     */
    public function setHoraSaida(\DateTime $horaSaida)
    {
        $this->horaSaida = $horaSaida;
        return $this;
    }

    /**
     * Get horaSaida
     *
     * @return \DateTime
     */
    public function getHoraSaida()
    {
        return $this->horaSaida;
    }

    /**
     * Set horaEntrada2
     *
     * @param \DateTime $horaEntrada2
     * @return FaixaTurno
     */
    public function setHoraEntrada2(\DateTime $horaEntrada2 = null)
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
     * @return FaixaTurno
     */
    public function setHoraSaida2(\DateTime $horaSaida2 = null)
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
     * ManyToOne (inverse side)
     * Set fkPessoalGradeHorario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\GradeHorario $fkPessoalGradeHorario
     * @return FaixaTurno
     */
    public function setFkPessoalGradeHorario(\Urbem\CoreBundle\Entity\Pessoal\GradeHorario $fkPessoalGradeHorario)
    {
        $this->codGrade = $fkPessoalGradeHorario->getCodGrade();
        $this->fkPessoalGradeHorario = $fkPessoalGradeHorario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalGradeHorario
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\GradeHorario
     */
    public function getFkPessoalGradeHorario()
    {
        return $this->fkPessoalGradeHorario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalDiasTurno
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DiasTurno $fkPessoalDiasTurno
     * @return FaixaTurno
     */
    public function setFkPessoalDiasTurno(\Urbem\CoreBundle\Entity\Pessoal\DiasTurno $fkPessoalDiasTurno)
    {
        $this->codDia = $fkPessoalDiasTurno->getCodDia();
        $this->fkPessoalDiasTurno = $fkPessoalDiasTurno;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalDiasTurno
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\DiasTurno
     */
    public function getFkPessoalDiasTurno()
    {
        return $this->fkPessoalDiasTurno;
    }
}
