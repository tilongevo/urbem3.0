<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * TipoVeiculoVinculo
 */
class TipoVeiculoVinculo
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codTipoTce;

    /**
     * @var integer
     */
    private $codSubtipoTce;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Frota\TipoVeiculo
     */
    private $fkFrotaTipoVeiculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\SubtipoVeiculoTce
     */
    private $fkTcemgSubtipoVeiculoTce;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoTce
     */
    private $fkTcemgTipoVeiculoTce;


    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoVeiculoVinculo
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
     * Set codTipoTce
     *
     * @param integer $codTipoTce
     * @return TipoVeiculoVinculo
     */
    public function setCodTipoTce($codTipoTce)
    {
        $this->codTipoTce = $codTipoTce;
        return $this;
    }

    /**
     * Get codTipoTce
     *
     * @return integer
     */
    public function getCodTipoTce()
    {
        return $this->codTipoTce;
    }

    /**
     * Set codSubtipoTce
     *
     * @param integer $codSubtipoTce
     * @return TipoVeiculoVinculo
     */
    public function setCodSubtipoTce($codSubtipoTce)
    {
        $this->codSubtipoTce = $codSubtipoTce;
        return $this;
    }

    /**
     * Get codSubtipoTce
     *
     * @return integer
     */
    public function getCodSubtipoTce()
    {
        return $this->codSubtipoTce;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgSubtipoVeiculoTce
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\SubtipoVeiculoTce $fkTcemgSubtipoVeiculoTce
     * @return TipoVeiculoVinculo
     */
    public function setFkTcemgSubtipoVeiculoTce(\Urbem\CoreBundle\Entity\Tcemg\SubtipoVeiculoTce $fkTcemgSubtipoVeiculoTce)
    {
        $this->codTipoTce = $fkTcemgSubtipoVeiculoTce->getCodTipoTce();
        $this->codSubtipoTce = $fkTcemgSubtipoVeiculoTce->getCodSubtipoTce();
        $this->fkTcemgSubtipoVeiculoTce = $fkTcemgSubtipoVeiculoTce;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgSubtipoVeiculoTce
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\SubtipoVeiculoTce
     */
    public function getFkTcemgSubtipoVeiculoTce()
    {
        return $this->fkTcemgSubtipoVeiculoTce;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgTipoVeiculoTce
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoTce $fkTcemgTipoVeiculoTce
     * @return TipoVeiculoVinculo
     */
    public function setFkTcemgTipoVeiculoTce(\Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoTce $fkTcemgTipoVeiculoTce)
    {
        $this->codTipoTce = $fkTcemgTipoVeiculoTce->getCodTipoTce();
        $this->fkTcemgTipoVeiculoTce = $fkTcemgTipoVeiculoTce;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgTipoVeiculoTce
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoTce
     */
    public function getFkTcemgTipoVeiculoTce()
    {
        return $this->fkTcemgTipoVeiculoTce;
    }

    /**
     * OneToOne (owning side)
     * Set FrotaTipoVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\TipoVeiculo $fkFrotaTipoVeiculo
     * @return TipoVeiculoVinculo
     */
    public function setFkFrotaTipoVeiculo(\Urbem\CoreBundle\Entity\Frota\TipoVeiculo $fkFrotaTipoVeiculo)
    {
        $this->codTipo = $fkFrotaTipoVeiculo->getCodTipo();
        $this->fkFrotaTipoVeiculo = $fkFrotaTipoVeiculo;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFrotaTipoVeiculo
     *
     * @return \Urbem\CoreBundle\Entity\Frota\TipoVeiculo
     */
    public function getFkFrotaTipoVeiculo()
    {
        return $this->fkFrotaTipoVeiculo;
    }
}
