<?php
 
namespace Urbem\CoreBundle\Entity\Calendario;

/**
 * PontoFacultativo
 */
class PontoFacultativo
{
    /**
     * PK
     * @var integer
     */
    private $codFeriado;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Calendario\Feriado
     */
    private $fkCalendarioFeriado;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Calendario\CalendarioPontoFacultativo
     */
    private $fkCalendarioCalendarioPontoFacultativos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCalendarioCalendarioPontoFacultativos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFeriado
     *
     * @param integer $codFeriado
     * @return PontoFacultativo
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
     * OneToMany (owning side)
     * Add CalendarioCalendarioPontoFacultativo
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\CalendarioPontoFacultativo $fkCalendarioCalendarioPontoFacultativo
     * @return PontoFacultativo
     */
    public function addFkCalendarioCalendarioPontoFacultativos(\Urbem\CoreBundle\Entity\Calendario\CalendarioPontoFacultativo $fkCalendarioCalendarioPontoFacultativo)
    {
        if (false === $this->fkCalendarioCalendarioPontoFacultativos->contains($fkCalendarioCalendarioPontoFacultativo)) {
            $fkCalendarioCalendarioPontoFacultativo->setFkCalendarioPontoFacultativo($this);
            $this->fkCalendarioCalendarioPontoFacultativos->add($fkCalendarioCalendarioPontoFacultativo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CalendarioCalendarioPontoFacultativo
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\CalendarioPontoFacultativo $fkCalendarioCalendarioPontoFacultativo
     */
    public function removeFkCalendarioCalendarioPontoFacultativos(\Urbem\CoreBundle\Entity\Calendario\CalendarioPontoFacultativo $fkCalendarioCalendarioPontoFacultativo)
    {
        $this->fkCalendarioCalendarioPontoFacultativos->removeElement($fkCalendarioCalendarioPontoFacultativo);
    }

    /**
     * OneToMany (owning side)
     * Get fkCalendarioCalendarioPontoFacultativos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Calendario\CalendarioPontoFacultativo
     */
    public function getFkCalendarioCalendarioPontoFacultativos()
    {
        return $this->fkCalendarioCalendarioPontoFacultativos;
    }

    /**
     * OneToOne (owning side)
     * Set CalendarioFeriado
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\Feriado $fkCalendarioFeriado
     * @return PontoFacultativo
     */
    public function setFkCalendarioFeriado(\Urbem\CoreBundle\Entity\Calendario\Feriado $fkCalendarioFeriado)
    {
        $this->codFeriado = $fkCalendarioFeriado->getCodFeriado();
        $this->fkCalendarioFeriado = $fkCalendarioFeriado;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkCalendarioFeriado
     *
     * @return \Urbem\CoreBundle\Entity\Calendario\Feriado
     */
    public function getFkCalendarioFeriado()
    {
        return $this->fkCalendarioFeriado;
    }
}
