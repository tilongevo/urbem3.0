<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * TipoVeiculo
 */
class TipoVeiculo
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * @var boolean
     */
    private $placa = true;

    /**
     * @var boolean
     */
    private $prefixo = true;

    /**
     * @var boolean
     */
    private $controlarHorasTrabalhadas = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoVinculo
     */
    private $fkTcemgTipoVeiculoVinculo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcern\TipoVeiculoVinculo
     */
    private $fkTcernTipoVeiculoVinculo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoVinculo
     */
    private $fkTcmgoTipoVeiculoVinculo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\TipoVeiculoVinculo
     */
    private $fkTcmbaTipoVeiculoVinculos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    private $fkFrotaVeiculos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmbaTipoVeiculoVinculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaVeiculos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoVeiculo
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
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return TipoVeiculo
     */
    public function setNomTipo($nomTipo)
    {
        $this->nomTipo = $nomTipo;
        return $this;
    }

    /**
     * Get nomTipo
     *
     * @return string
     */
    public function getNomTipo()
    {
        return $this->nomTipo;
    }

    /**
     * Set placa
     *
     * @param boolean $placa
     * @return TipoVeiculo
     */
    public function setPlaca($placa)
    {
        $this->placa = $placa;
        return $this;
    }

    /**
     * Get placa
     *
     * @return boolean
     */
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * Set prefixo
     *
     * @param boolean $prefixo
     * @return TipoVeiculo
     */
    public function setPrefixo($prefixo)
    {
        $this->prefixo = $prefixo;
        return $this;
    }

    /**
     * Get prefixo
     *
     * @return boolean
     */
    public function getPrefixo()
    {
        return $this->prefixo;
    }

    /**
     * Set controlarHorasTrabalhadas
     *
     * @param boolean $controlarHorasTrabalhadas
     * @return TipoVeiculo
     */
    public function setControlarHorasTrabalhadas($controlarHorasTrabalhadas)
    {
        $this->controlarHorasTrabalhadas = $controlarHorasTrabalhadas;
        return $this;
    }

    /**
     * Get controlarHorasTrabalhadas
     *
     * @return boolean
     */
    public function getControlarHorasTrabalhadas()
    {
        return $this->controlarHorasTrabalhadas;
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
            $fkTcmbaTipoVeiculoVinculo->setFkFrotaTipoVeiculo($this);
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
     * Add FrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     * @return TipoVeiculo
     */
    public function addFkFrotaVeiculos(\Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo)
    {
        if (false === $this->fkFrotaVeiculos->contains($fkFrotaVeiculo)) {
            $fkFrotaVeiculo->setFkFrotaTipoVeiculo($this);
            $this->fkFrotaVeiculos->add($fkFrotaVeiculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     */
    public function removeFkFrotaVeiculos(\Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo)
    {
        $this->fkFrotaVeiculos->removeElement($fkFrotaVeiculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    public function getFkFrotaVeiculos()
    {
        return $this->fkFrotaVeiculos;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgTipoVeiculoVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoVinculo $fkTcemgTipoVeiculoVinculo
     * @return TipoVeiculo
     */
    public function setFkTcemgTipoVeiculoVinculo(\Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoVinculo $fkTcemgTipoVeiculoVinculo)
    {
        $fkTcemgTipoVeiculoVinculo->setFkFrotaTipoVeiculo($this);
        $this->fkTcemgTipoVeiculoVinculo = $fkTcemgTipoVeiculoVinculo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgTipoVeiculoVinculo
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoVinculo
     */
    public function getFkTcemgTipoVeiculoVinculo()
    {
        return $this->fkTcemgTipoVeiculoVinculo;
    }

    /**
     * OneToOne (inverse side)
     * Set TcernTipoVeiculoVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\TipoVeiculoVinculo $fkTcernTipoVeiculoVinculo
     * @return TipoVeiculo
     */
    public function setFkTcernTipoVeiculoVinculo(\Urbem\CoreBundle\Entity\Tcern\TipoVeiculoVinculo $fkTcernTipoVeiculoVinculo)
    {
        $fkTcernTipoVeiculoVinculo->setFkFrotaTipoVeiculo($this);
        $this->fkTcernTipoVeiculoVinculo = $fkTcernTipoVeiculoVinculo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcernTipoVeiculoVinculo
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\TipoVeiculoVinculo
     */
    public function getFkTcernTipoVeiculoVinculo()
    {
        return $this->fkTcernTipoVeiculoVinculo;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoTipoVeiculoVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoVinculo $fkTcmgoTipoVeiculoVinculo
     * @return TipoVeiculo
     */
    public function setFkTcmgoTipoVeiculoVinculo(\Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoVinculo $fkTcmgoTipoVeiculoVinculo)
    {
        $fkTcmgoTipoVeiculoVinculo->setFkFrotaTipoVeiculo($this);
        $this->fkTcmgoTipoVeiculoVinculo = $fkTcmgoTipoVeiculoVinculo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoTipoVeiculoVinculo
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoVinculo
     */
    public function getFkTcmgoTipoVeiculoVinculo()
    {
        return $this->fkTcmgoTipoVeiculoVinculo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->codTipo.' - '.$this->nomTipo;
    }
}
