<?php
 
namespace Urbem\CoreBundle\Entity\Tceto;

/**
 * TipoTransferencia
 */
class TipoTransferencia
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoTransferencia
     */
    private $fkTcetoTransferenciaTipoTransferencias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcetoTransferenciaTipoTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoTransferencia
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoTransferencia
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
     * Add TcetoTransferenciaTipoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoTransferencia $fkTcetoTransferenciaTipoTransferencia
     * @return TipoTransferencia
     */
    public function addFkTcetoTransferenciaTipoTransferencias(\Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoTransferencia $fkTcetoTransferenciaTipoTransferencia)
    {
        if (false === $this->fkTcetoTransferenciaTipoTransferencias->contains($fkTcetoTransferenciaTipoTransferencia)) {
            $fkTcetoTransferenciaTipoTransferencia->setFkTcetoTipoTransferencia($this);
            $this->fkTcetoTransferenciaTipoTransferencias->add($fkTcetoTransferenciaTipoTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcetoTransferenciaTipoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoTransferencia $fkTcetoTransferenciaTipoTransferencia
     */
    public function removeFkTcetoTransferenciaTipoTransferencias(\Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoTransferencia $fkTcetoTransferenciaTipoTransferencia)
    {
        $this->fkTcetoTransferenciaTipoTransferencias->removeElement($fkTcetoTransferenciaTipoTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcetoTransferenciaTipoTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoTransferencia
     */
    public function getFkTcetoTransferenciaTipoTransferencias()
    {
        return $this->fkTcetoTransferenciaTipoTransferencias;
    }
}
