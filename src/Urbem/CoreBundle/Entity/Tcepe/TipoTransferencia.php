<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida
     */
    private $fkTcepeTipoTransferenciaRecebidas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida
     */
    private $fkTcepeTipoTransferenciaConcedidas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepeTipoTransferenciaRecebidas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeTipoTransferenciaConcedidas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TcepeTipoTransferenciaRecebida
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida $fkTcepeTipoTransferenciaRecebida
     * @return TipoTransferencia
     */
    public function addFkTcepeTipoTransferenciaRecebidas(\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida $fkTcepeTipoTransferenciaRecebida)
    {
        if (false === $this->fkTcepeTipoTransferenciaRecebidas->contains($fkTcepeTipoTransferenciaRecebida)) {
            $fkTcepeTipoTransferenciaRecebida->setFkTcepeTipoTransferencia($this);
            $this->fkTcepeTipoTransferenciaRecebidas->add($fkTcepeTipoTransferenciaRecebida);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeTipoTransferenciaRecebida
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida $fkTcepeTipoTransferenciaRecebida
     */
    public function removeFkTcepeTipoTransferenciaRecebidas(\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida $fkTcepeTipoTransferenciaRecebida)
    {
        $this->fkTcepeTipoTransferenciaRecebidas->removeElement($fkTcepeTipoTransferenciaRecebida);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeTipoTransferenciaRecebidas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida
     */
    public function getFkTcepeTipoTransferenciaRecebidas()
    {
        return $this->fkTcepeTipoTransferenciaRecebidas;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeTipoTransferenciaConcedida
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida $fkTcepeTipoTransferenciaConcedida
     * @return TipoTransferencia
     */
    public function addFkTcepeTipoTransferenciaConcedidas(\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida $fkTcepeTipoTransferenciaConcedida)
    {
        if (false === $this->fkTcepeTipoTransferenciaConcedidas->contains($fkTcepeTipoTransferenciaConcedida)) {
            $fkTcepeTipoTransferenciaConcedida->setFkTcepeTipoTransferencia($this);
            $this->fkTcepeTipoTransferenciaConcedidas->add($fkTcepeTipoTransferenciaConcedida);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeTipoTransferenciaConcedida
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida $fkTcepeTipoTransferenciaConcedida
     */
    public function removeFkTcepeTipoTransferenciaConcedidas(\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida $fkTcepeTipoTransferenciaConcedida)
    {
        $this->fkTcepeTipoTransferenciaConcedidas->removeElement($fkTcepeTipoTransferenciaConcedida);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeTipoTransferenciaConcedidas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida
     */
    public function getFkTcepeTipoTransferenciaConcedidas()
    {
        return $this->fkTcepeTipoTransferenciaConcedidas;
    }
}
