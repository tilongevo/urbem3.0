<?php
 
namespace Urbem\CoreBundle\Entity\Calendario;

/**
 * FeriadoVariavel
 */
class FeriadoVariavel
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Calendario\CalendarioFeriadoVariavel
     */
    private $fkCalendarioCalendarioFeriadoVariaveis;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCalendarioCalendarioFeriadoVariaveis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFeriado
     *
     * @param integer $codFeriado
     * @return FeriadoVariavel
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
     * Add CalendarioCalendarioFeriadoVariavel
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\CalendarioFeriadoVariavel $fkCalendarioCalendarioFeriadoVariavel
     * @return FeriadoVariavel
     */
    public function addFkCalendarioCalendarioFeriadoVariaveis(\Urbem\CoreBundle\Entity\Calendario\CalendarioFeriadoVariavel $fkCalendarioCalendarioFeriadoVariavel)
    {
        if (false === $this->fkCalendarioCalendarioFeriadoVariaveis->contains($fkCalendarioCalendarioFeriadoVariavel)) {
            $fkCalendarioCalendarioFeriadoVariavel->setFkCalendarioFeriadoVariavel($this);
            $this->fkCalendarioCalendarioFeriadoVariaveis->add($fkCalendarioCalendarioFeriadoVariavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CalendarioCalendarioFeriadoVariavel
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\CalendarioFeriadoVariavel $fkCalendarioCalendarioFeriadoVariavel
     */
    public function removeFkCalendarioCalendarioFeriadoVariaveis(\Urbem\CoreBundle\Entity\Calendario\CalendarioFeriadoVariavel $fkCalendarioCalendarioFeriadoVariavel)
    {
        $this->fkCalendarioCalendarioFeriadoVariaveis->removeElement($fkCalendarioCalendarioFeriadoVariavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkCalendarioCalendarioFeriadoVariaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Calendario\CalendarioFeriadoVariavel
     */
    public function getFkCalendarioCalendarioFeriadoVariaveis()
    {
        return $this->fkCalendarioCalendarioFeriadoVariaveis;
    }

    /**
     * OneToOne (owning side)
     * Set CalendarioFeriado
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\Feriado $fkCalendarioFeriado
     * @return FeriadoVariavel
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
