<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * VeiculoCategoriaVinculo
 */
class VeiculoCategoriaVinculo
{
    /**
     * PK
     * @var integer
     */
    private $codVeiculo;

    /**
     * @var integer
     */
    private $codCategoria;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    private $fkFrotaVeiculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcern\CategoriaVeiculoTce
     */
    private $fkTcernCategoriaVeiculoTce;


    /**
     * Set codVeiculo
     *
     * @param integer $codVeiculo
     * @return VeiculoCategoriaVinculo
     */
    public function setCodVeiculo($codVeiculo)
    {
        $this->codVeiculo = $codVeiculo;
        return $this;
    }

    /**
     * Get codVeiculo
     *
     * @return integer
     */
    public function getCodVeiculo()
    {
        return $this->codVeiculo;
    }

    /**
     * Set codCategoria
     *
     * @param integer $codCategoria
     * @return VeiculoCategoriaVinculo
     */
    public function setCodCategoria($codCategoria)
    {
        $this->codCategoria = $codCategoria;
        return $this;
    }

    /**
     * Get codCategoria
     *
     * @return integer
     */
    public function getCodCategoria()
    {
        return $this->codCategoria;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcernCategoriaVeiculoTce
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\CategoriaVeiculoTce $fkTcernCategoriaVeiculoTce
     * @return VeiculoCategoriaVinculo
     */
    public function setFkTcernCategoriaVeiculoTce(\Urbem\CoreBundle\Entity\Tcern\CategoriaVeiculoTce $fkTcernCategoriaVeiculoTce)
    {
        $this->codCategoria = $fkTcernCategoriaVeiculoTce->getCodCategoria();
        $this->fkTcernCategoriaVeiculoTce = $fkTcernCategoriaVeiculoTce;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcernCategoriaVeiculoTce
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\CategoriaVeiculoTce
     */
    public function getFkTcernCategoriaVeiculoTce()
    {
        return $this->fkTcernCategoriaVeiculoTce;
    }

    /**
     * OneToOne (owning side)
     * Set FrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     * @return VeiculoCategoriaVinculo
     */
    public function setFkFrotaVeiculo(\Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo)
    {
        $this->codVeiculo = $fkFrotaVeiculo->getCodVeiculo();
        $this->fkFrotaVeiculo = $fkFrotaVeiculo;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFrotaVeiculo
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    public function getFkFrotaVeiculo()
    {
        return $this->fkFrotaVeiculo;
    }
}
