<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

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
    private $codTipoTcm;

    /**
     * @var integer
     */
    private $codSubtipoTcm;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Frota\TipoVeiculo
     */
    private $fkFrotaTipoVeiculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoTcm
     */
    private $fkTcmgoTipoVeiculoTcm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\SubtipoVeiculoTcm
     */
    private $fkTcmgoSubtipoVeiculoTcm;


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
     * Set codTipoTcm
     *
     * @param integer $codTipoTcm
     * @return TipoVeiculoVinculo
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
     * Set codSubtipoTcm
     *
     * @param integer $codSubtipoTcm
     * @return TipoVeiculoVinculo
     */
    public function setCodSubtipoTcm($codSubtipoTcm)
    {
        $this->codSubtipoTcm = $codSubtipoTcm;
        return $this;
    }

    /**
     * Get codSubtipoTcm
     *
     * @return integer
     */
    public function getCodSubtipoTcm()
    {
        return $this->codSubtipoTcm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoTipoVeiculoTcm
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoTcm $fkTcmgoTipoVeiculoTcm
     * @return TipoVeiculoVinculo
     */
    public function setFkTcmgoTipoVeiculoTcm(\Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoTcm $fkTcmgoTipoVeiculoTcm)
    {
        $this->codTipoTcm = $fkTcmgoTipoVeiculoTcm->getCodTipoTcm();
        $this->fkTcmgoTipoVeiculoTcm = $fkTcmgoTipoVeiculoTcm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoTipoVeiculoTcm
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoTcm
     */
    public function getFkTcmgoTipoVeiculoTcm()
    {
        return $this->fkTcmgoTipoVeiculoTcm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoSubtipoVeiculoTcm
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\SubtipoVeiculoTcm $fkTcmgoSubtipoVeiculoTcm
     * @return TipoVeiculoVinculo
     */
    public function setFkTcmgoSubtipoVeiculoTcm(\Urbem\CoreBundle\Entity\Tcmgo\SubtipoVeiculoTcm $fkTcmgoSubtipoVeiculoTcm)
    {
        $this->codTipoTcm = $fkTcmgoSubtipoVeiculoTcm->getCodTipoTcm();
        $this->codSubtipoTcm = $fkTcmgoSubtipoVeiculoTcm->getCodSubtipoTcm();
        $this->fkTcmgoSubtipoVeiculoTcm = $fkTcmgoSubtipoVeiculoTcm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoSubtipoVeiculoTcm
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\SubtipoVeiculoTcm
     */
    public function getFkTcmgoSubtipoVeiculoTcm()
    {
        return $this->fkTcmgoSubtipoVeiculoTcm;
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
