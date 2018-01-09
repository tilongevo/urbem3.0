<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ContratoAditivoTipo
 */
class ContratoAditivoTipo
{
    /**
     * PK
     * @var integer
     */
    private $codTipoAditivo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo
     */
    private $fkTcemgContratoAditivos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgContratoAditivos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoAditivo
     *
     * @param integer $codTipoAditivo
     * @return ContratoAditivoTipo
     */
    public function setCodTipoAditivo($codTipoAditivo)
    {
        $this->codTipoAditivo = $codTipoAditivo;
        return $this;
    }

    /**
     * Get codTipoAditivo
     *
     * @return integer
     */
    public function getCodTipoAditivo()
    {
        return $this->codTipoAditivo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ContratoAditivoTipo
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
     * Add TcemgContratoAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo
     * @return ContratoAditivoTipo
     */
    public function addFkTcemgContratoAditivos(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo)
    {
        if (false === $this->fkTcemgContratoAditivos->contains($fkTcemgContratoAditivo)) {
            $fkTcemgContratoAditivo->setFkTcemgContratoAditivoTipo($this);
            $this->fkTcemgContratoAditivos->add($fkTcemgContratoAditivo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContratoAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo
     */
    public function removeFkTcemgContratoAditivos(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo)
    {
        $this->fkTcemgContratoAditivos->removeElement($fkTcemgContratoAditivo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratoAditivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo
     */
    public function getFkTcemgContratoAditivos()
    {
        return $this->fkTcemgContratoAditivos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->descricao;
    }
}
