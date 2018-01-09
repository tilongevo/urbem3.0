<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    private $fkTesourariaTransferencias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTesourariaTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return TipoTransferencia
     */
    public function addFkTesourariaTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia)
    {
        if (false === $this->fkTesourariaTransferencias->contains($fkTesourariaTransferencia)) {
            $fkTesourariaTransferencia->setFkTesourariaTipoTransferencia($this);
            $this->fkTesourariaTransferencias->add($fkTesourariaTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     */
    public function removeFkTesourariaTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia)
    {
        $this->fkTesourariaTransferencias->removeElement($fkTesourariaTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    public function getFkTesourariaTransferencias()
    {
        return $this->fkTesourariaTransferencias;
    }
}
