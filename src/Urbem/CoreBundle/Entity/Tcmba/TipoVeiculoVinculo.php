<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoVeiculoVinculo
 */
class TipoVeiculoVinculo
{
    /**
     * PK
     * @var integer
     */
    private $codTipoTcm;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\TipoVeiculo
     */
    private $fkTcmbaTipoVeiculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\TipoVeiculo
     */
    private $fkFrotaTipoVeiculo;


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
     * ManyToOne (inverse side)
     * Set fkTcmbaTipoVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoVeiculo $fkTcmbaTipoVeiculo
     * @return TipoVeiculoVinculo
     */
    public function setFkTcmbaTipoVeiculo(\Urbem\CoreBundle\Entity\Tcmba\TipoVeiculo $fkTcmbaTipoVeiculo)
    {
        $this->codTipoTcm = $fkTcmbaTipoVeiculo->getCodTipoTcm();
        $this->fkTcmbaTipoVeiculo = $fkTcmbaTipoVeiculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaTipoVeiculo
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TipoVeiculo
     */
    public function getFkTcmbaTipoVeiculo()
    {
        return $this->fkTcmbaTipoVeiculo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaTipoVeiculo
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
     * ManyToOne (inverse side)
     * Get fkFrotaTipoVeiculo
     *
     * @return \Urbem\CoreBundle\Entity\Frota\TipoVeiculo
     */
    public function getFkFrotaTipoVeiculo()
    {
        return $this->fkFrotaTipoVeiculo;
    }
}
