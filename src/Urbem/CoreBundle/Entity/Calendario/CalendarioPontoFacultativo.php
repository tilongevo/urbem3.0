<?php
 
namespace Urbem\CoreBundle\Entity\Calendario;

/**
 * CalendarioPontoFacultativo
 */
class CalendarioPontoFacultativo
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
     * @var \Urbem\CoreBundle\Entity\Calendario\PontoFacultativo
     */
    private $fkCalendarioPontoFacultativo;


    /**
     * Set codCalendar
     *
     * @param integer $codCalendar
     * @return CalendarioPontoFacultativo
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
     * @return CalendarioPontoFacultativo
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
     * @return CalendarioPontoFacultativo
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
     * Set fkCalendarioPontoFacultativo
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\PontoFacultativo $fkCalendarioPontoFacultativo
     * @return CalendarioPontoFacultativo
     */
    public function setFkCalendarioPontoFacultativo(\Urbem\CoreBundle\Entity\Calendario\PontoFacultativo $fkCalendarioPontoFacultativo)
    {
        $this->codFeriado = $fkCalendarioPontoFacultativo->getCodFeriado();
        $this->fkCalendarioPontoFacultativo = $fkCalendarioPontoFacultativo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCalendarioPontoFacultativo
     *
     * @return \Urbem\CoreBundle\Entity\Calendario\PontoFacultativo
     */
    public function getFkCalendarioPontoFacultativo()
    {
        return $this->fkCalendarioPontoFacultativo;
    }
}
