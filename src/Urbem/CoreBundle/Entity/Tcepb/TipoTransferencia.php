<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\PlanoContaTipoTransferencia
     */
    private $fkTcepbPlanoContaTipoTransferencias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepbPlanoContaTipoTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TcepbPlanoContaTipoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\PlanoContaTipoTransferencia $fkTcepbPlanoContaTipoTransferencia
     * @return TipoTransferencia
     */
    public function addFkTcepbPlanoContaTipoTransferencias(\Urbem\CoreBundle\Entity\Tcepb\PlanoContaTipoTransferencia $fkTcepbPlanoContaTipoTransferencia)
    {
        if (false === $this->fkTcepbPlanoContaTipoTransferencias->contains($fkTcepbPlanoContaTipoTransferencia)) {
            $fkTcepbPlanoContaTipoTransferencia->setFkTcepbTipoTransferencia($this);
            $this->fkTcepbPlanoContaTipoTransferencias->add($fkTcepbPlanoContaTipoTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepbPlanoContaTipoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\PlanoContaTipoTransferencia $fkTcepbPlanoContaTipoTransferencia
     */
    public function removeFkTcepbPlanoContaTipoTransferencias(\Urbem\CoreBundle\Entity\Tcepb\PlanoContaTipoTransferencia $fkTcepbPlanoContaTipoTransferencia)
    {
        $this->fkTcepbPlanoContaTipoTransferencias->removeElement($fkTcepbPlanoContaTipoTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepbPlanoContaTipoTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\PlanoContaTipoTransferencia
     */
    public function getFkTcepbPlanoContaTipoTransferencias()
    {
        return $this->fkTcepbPlanoContaTipoTransferencias;
    }
}
