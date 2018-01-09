<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * NaturezaJuridica
 */
class NaturezaJuridica
{
    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeGestora
     */
    private $fkTcernUnidadeGestoras;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcernUnidadeGestoras = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return NaturezaJuridica
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return NaturezaJuridica
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
     * Add TcernUnidadeGestora
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeGestora $fkTcernUnidadeGestora
     * @return NaturezaJuridica
     */
    public function addFkTcernUnidadeGestoras(\Urbem\CoreBundle\Entity\Tcern\UnidadeGestora $fkTcernUnidadeGestora)
    {
        if (false === $this->fkTcernUnidadeGestoras->contains($fkTcernUnidadeGestora)) {
            $fkTcernUnidadeGestora->setFkTcernNaturezaJuridica($this);
            $this->fkTcernUnidadeGestoras->add($fkTcernUnidadeGestora);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernUnidadeGestora
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeGestora $fkTcernUnidadeGestora
     */
    public function removeFkTcernUnidadeGestoras(\Urbem\CoreBundle\Entity\Tcern\UnidadeGestora $fkTcernUnidadeGestora)
    {
        $this->fkTcernUnidadeGestoras->removeElement($fkTcernUnidadeGestora);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernUnidadeGestoras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeGestora
     */
    public function getFkTcernUnidadeGestoras()
    {
        return $this->fkTcernUnidadeGestoras;
    }
}
