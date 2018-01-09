<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

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
    private $codEspecieTce;

    /**
     * @var integer
     */
    private $codTipoTce;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Frota\TipoVeiculo
     */
    private $fkFrotaTipoVeiculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcern\EspecieVeiculoTce
     */
    private $fkTcernEspecieVeiculoTce;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcern\TipoVeiculoTce
     */
    private $fkTcernTipoVeiculoTce;


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
     * Set codEspecieTce
     *
     * @param integer $codEspecieTce
     * @return TipoVeiculoVinculo
     */
    public function setCodEspecieTce($codEspecieTce)
    {
        $this->codEspecieTce = $codEspecieTce;
        return $this;
    }

    /**
     * Get codEspecieTce
     *
     * @return integer
     */
    public function getCodEspecieTce()
    {
        return $this->codEspecieTce;
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
     * ManyToOne (inverse side)
     * Set fkTcernEspecieVeiculoTce
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\EspecieVeiculoTce $fkTcernEspecieVeiculoTce
     * @return TipoVeiculoVinculo
     */
    public function setFkTcernEspecieVeiculoTce(\Urbem\CoreBundle\Entity\Tcern\EspecieVeiculoTce $fkTcernEspecieVeiculoTce)
    {
        $this->codEspecieTce = $fkTcernEspecieVeiculoTce->getCodEspecieTce();
        $this->fkTcernEspecieVeiculoTce = $fkTcernEspecieVeiculoTce;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcernEspecieVeiculoTce
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\EspecieVeiculoTce
     */
    public function getFkTcernEspecieVeiculoTce()
    {
        return $this->fkTcernEspecieVeiculoTce;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcernTipoVeiculoTce
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\TipoVeiculoTce $fkTcernTipoVeiculoTce
     * @return TipoVeiculoVinculo
     */
    public function setFkTcernTipoVeiculoTce(\Urbem\CoreBundle\Entity\Tcern\TipoVeiculoTce $fkTcernTipoVeiculoTce)
    {
        $this->codTipoTce = $fkTcernTipoVeiculoTce->getCodTipoTce();
        $this->fkTcernTipoVeiculoTce = $fkTcernTipoVeiculoTce;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcernTipoVeiculoTce
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\TipoVeiculoTce
     */
    public function getFkTcernTipoVeiculoTce()
    {
        return $this->fkTcernTipoVeiculoTce;
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
