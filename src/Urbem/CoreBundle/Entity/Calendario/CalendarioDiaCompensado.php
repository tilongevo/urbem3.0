<?php
 
namespace Urbem\CoreBundle\Entity\Calendario;

/**
 * CalendarioDiaCompensado
 */
class CalendarioDiaCompensado
{
    /**
     * PK
     * @var integer
     */
    private $codCalendar;

    /**
     * PK
     * @var integer
     */
    private $codFeriado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro
     */
    private $fkCalendarioCalendarioCadastro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Calendario\DiaCompensado
     */
    private $fkCalendarioDiaCompensado;


    /**
     * Set codCalendar
     *
     * @param integer $codCalendar
     * @return CalendarioDiaCompensado
     */
    public function setCodCalendar($codCalendar)
    {
        $this->codCalendar = $codCalendar;
        return $this;
    }

    /**
     * Get codCalendar
     *
     * @return integer
     */
    public function getCodCalendar()
    {
        return $this->codCalendar;
    }

    /**
     * Set codFeriado
     *
     * @param integer $codFeriado
     * @return CalendarioDiaCompensado
     */
    public function setCodFeriado($codFeriado)
    {
        $this->codFeriado = $codFeriado;
        return $this;
    }

    /**
     * Get codFeriado
     *
     * @return integer
     */
    public function getCodFeriado()
    {
        return $this->codFeriado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCalendarioCalendarioCadastro
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro $fkCalendarioCalendarioCadastro
     * @return CalendarioDiaCompensado
     */
    public function setFkCalendarioCalendarioCadastro(\Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro $fkCalendarioCalendarioCadastro)
    {
        $this->codCalendar = $fkCalendarioCalendarioCadastro->getCodCalendar();
        $this->fkCalendarioCalendarioCadastro = $fkCalendarioCalendarioCadastro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCalendarioCalendarioCadastro
     *
     * @return \Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro
     */
    public function getFkCalendarioCalendarioCadastro()
    {
        return $this->fkCalendarioCalendarioCadastro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCalendarioDiaCompensado
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\DiaCompensado $fkCalendarioDiaCompensado
     * @return CalendarioDiaCompensado
     */
    public function setFkCalendarioDiaCompensado(\Urbem\CoreBundle\Entity\Calendario\DiaCompensado $fkCalendarioDiaCompensado)
    {
        $this->codFeriado = $fkCalendarioDiaCompensado->getCodFeriado();
        $this->fkCalendarioDiaCompensado = $fkCalendarioDiaCompensado;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCalendarioDiaCompensado
     *
     * @return \Urbem\CoreBundle\Entity\Calendario\DiaCompensado
     */
    public function getFkCalendarioDiaCompensado()
    {
        return $this->fkCalendarioDiaCompensado;
    }
}
