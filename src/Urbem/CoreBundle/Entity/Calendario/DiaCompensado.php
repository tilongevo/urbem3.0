<?php
 
namespace Urbem\CoreBundle\Entity\Calendario;

/**
 * DiaCompensado
 */
class DiaCompensado
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Calendario\CalendarioDiaCompensado
     */
    private $fkCalendarioCalendarioDiaCompensados;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCalendarioCalendarioDiaCompensados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFeriado
     *
     * @param integer $codFeriado
     * @return DiaCompensado
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
     * Add CalendarioCalendarioDiaCompensado
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\CalendarioDiaCompensado $fkCalendarioCalendarioDiaCompensado
     * @return DiaCompensado
     */
    public function addFkCalendarioCalendarioDiaCompensados(\Urbem\CoreBundle\Entity\Calendario\CalendarioDiaCompensado $fkCalendarioCalendarioDiaCompensado)
    {
        if (false === $this->fkCalendarioCalendarioDiaCompensados->contains($fkCalendarioCalendarioDiaCompensado)) {
            $fkCalendarioCalendarioDiaCompensado->setFkCalendarioDiaCompensado($this);
            $this->fkCalendarioCalendarioDiaCompensados->add($fkCalendarioCalendarioDiaCompensado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CalendarioCalendarioDiaCompensado
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\CalendarioDiaCompensado $fkCalendarioCalendarioDiaCompensado
     */
    public function removeFkCalendarioCalendarioDiaCompensados(\Urbem\CoreBundle\Entity\Calendario\CalendarioDiaCompensado $fkCalendarioCalendarioDiaCompensado)
    {
        $this->fkCalendarioCalendarioDiaCompensados->removeElement($fkCalendarioCalendarioDiaCompensado);
    }

    /**
     * OneToMany (owning side)
     * Get fkCalendarioCalendarioDiaCompensados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Calendario\CalendarioDiaCompensado
     */
    public function getFkCalendarioCalendarioDiaCompensados()
    {
        return $this->fkCalendarioCalendarioDiaCompensados;
    }

    /**
     * OneToOne (owning side)
     * Set CalendarioFeriado
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\Feriado $fkCalendarioFeriado
     * @return DiaCompensado
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
