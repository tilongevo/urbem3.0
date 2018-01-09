<?php
 
namespace Urbem\CoreBundle\Entity\Calendario;

/**
 * CalendarioFeriadoVariavel
 */
class CalendarioFeriadoVariavel
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
     * @var \Urbem\CoreBundle\Entity\Calendario\FeriadoVariavel
     */
    private $fkCalendarioFeriadoVariavel;


    /**
     * Set codCalendar
     *
     * @param integer $codCalendar
     * @return CalendarioFeriadoVariavel
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
     * @return CalendarioFeriadoVariavel
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
     * @return CalendarioFeriadoVariavel
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
     * Set fkCalendarioFeriadoVariavel
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\FeriadoVariavel $fkCalendarioFeriadoVariavel
     * @return CalendarioFeriadoVariavel
     */
    public function setFkCalendarioFeriadoVariavel(\Urbem\CoreBundle\Entity\Calendario\FeriadoVariavel $fkCalendarioFeriadoVariavel)
    {
        $this->codFeriado = $fkCalendarioFeriadoVariavel->getCodFeriado();
        $this->fkCalendarioFeriadoVariavel = $fkCalendarioFeriadoVariavel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCalendarioFeriadoVariavel
     *
     * @return \Urbem\CoreBundle\Entity\Calendario\FeriadoVariavel
     */
    public function getFkCalendarioFeriadoVariavel()
    {
        return $this->fkCalendarioFeriadoVariavel;
    }
}
