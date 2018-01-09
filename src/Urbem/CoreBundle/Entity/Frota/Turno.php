<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * Turno
 */
class Turno
{
    const NAO_INFORMADO = 0;

    /**
     * PK
     * @var integer
     */
    private $codTurno;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\TransporteEscolar
     */
    private $fkFrotaTransporteEscolares;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFrotaTransporteEscolares = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTurno
     *
     * @param integer $codTurno
     * @return Turno
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
     * Set descricao
     *
     * @param string $descricao
     * @return Turno
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaTransporteEscolar
     *
     * @param \Urbem\CoreBundle\Entity\Frota\TransporteEscolar $fkFrotaTransporteEscolar
     * @return Turno
     */
    public function addFkFrotaTransporteEscolares(\Urbem\CoreBundle\Entity\Frota\TransporteEscolar $fkFrotaTransporteEscolar)
    {
        if (false === $this->fkFrotaTransporteEscolares->contains($fkFrotaTransporteEscolar)) {
            $fkFrotaTransporteEscolar->setFkFrotaTurno($this);
            $this->fkFrotaTransporteEscolares->add($fkFrotaTransporteEscolar);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaTransporteEscolar
     *
     * @param \Urbem\CoreBundle\Entity\Frota\TransporteEscolar $fkFrotaTransporteEscolar
     */
    public function removeFkFrotaTransporteEscolares(\Urbem\CoreBundle\Entity\Frota\TransporteEscolar $fkFrotaTransporteEscolar)
    {
        $this->fkFrotaTransporteEscolares->removeElement($fkFrotaTransporteEscolar);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaTransporteEscolares
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\TransporteEscolar
     */
    public function getFkFrotaTransporteEscolares()
    {
        return $this->fkFrotaTransporteEscolares;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            "%s - %s",
            $this->codTurno,
            $this->descricao
        );
    }
}
