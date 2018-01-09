<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoVeiculo
 */
class TipoVeiculo
{
    /**
     * PK
     * @var integer
     */
    private $codTipoTcm;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\TipoVeiculoVinculo
     */
    private $fkTcmbaTipoVeiculoVinculos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\Marca
     */
    private $fkTcmbaMarcas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmbaTipoVeiculoVinculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaMarcas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoTcm
     *
     * @param integer $codTipoTcm
     * @return TipoVeiculo
     */
    public function setCodTipoTcm($codTipoTcm)
    {
        $this->codTipoTcm = $codTipoTcm;
        return $this;
    }

    /**
     * Get codTipoTcm
     *
     * @return integer
     */
    public function getCodTipoTcm()
    {
        return $this->codTipoTcm;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoVeiculo
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
     * Add TcmbaTipoVeiculoVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoVeiculoVinculo $fkTcmbaTipoVeiculoVinculo
     * @return TipoVeiculo
     */
    public function addFkTcmbaTipoVeiculoVinculos(\Urbem\CoreBundle\Entity\Tcmba\TipoVeiculoVinculo $fkTcmbaTipoVeiculoVinculo)
    {
        if (false === $this->fkTcmbaTipoVeiculoVinculos->contains($fkTcmbaTipoVeiculoVinculo)) {
            $fkTcmbaTipoVeiculoVinculo->setFkTcmbaTipoVeiculo($this);
            $this->fkTcmbaTipoVeiculoVinculos->add($fkTcmbaTipoVeiculoVinculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaTipoVeiculoVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoVeiculoVinculo $fkTcmbaTipoVeiculoVinculo
     */
    public function removeFkTcmbaTipoVeiculoVinculos(\Urbem\CoreBundle\Entity\Tcmba\TipoVeiculoVinculo $fkTcmbaTipoVeiculoVinculo)
    {
        $this->fkTcmbaTipoVeiculoVinculos->removeElement($fkTcmbaTipoVeiculoVinculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaTipoVeiculoVinculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\TipoVeiculoVinculo
     */
    public function getFkTcmbaTipoVeiculoVinculos()
    {
        return $this->fkTcmbaTipoVeiculoVinculos;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaMarca
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\Marca $fkTcmbaMarca
     * @return TipoVeiculo
     */
    public function addFkTcmbaMarcas(\Urbem\CoreBundle\Entity\Tcmba\Marca $fkTcmbaMarca)
    {
        if (false === $this->fkTcmbaMarcas->contains($fkTcmbaMarca)) {
            $fkTcmbaMarca->setFkTcmbaTipoVeiculo($this);
            $this->fkTcmbaMarcas->add($fkTcmbaMarca);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaMarca
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\Marca $fkTcmbaMarca
     */
    public function removeFkTcmbaMarcas(\Urbem\CoreBundle\Entity\Tcmba\Marca $fkTcmbaMarca)
    {
        $this->fkTcmbaMarcas->removeElement($fkTcmbaMarca);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaMarcas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\Marca
     */
    public function getFkTcmbaMarcas()
    {
        return $this->fkTcmbaMarcas;
    }
}
