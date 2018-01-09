<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * VeiculoCombustivel
 */
class VeiculoCombustivel
{
    /**
     * PK
     * @var integer
     */
    private $codVeiculo;

    /**
     * PK
     * @var integer
     */
    private $codCombustivel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    private $fkFrotaVeiculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Combustivel
     */
    private $fkFrotaCombustivel;


    /**
     * Set codVeiculo
     *
     * @param integer $codVeiculo
     * @return VeiculoCombustivel
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
     * Set codCombustivel
     *
     * @param integer $codCombustivel
     * @return VeiculoCombustivel
     */
    public function setCodCombustivel($codCombustivel)
    {
        $this->codCombustivel = $codCombustivel;
        return $this;
    }

    /**
     * Get codCombustivel
     *
     * @return integer
     */
    public function getCodCombustivel()
    {
        return $this->codCombustivel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     * @return VeiculoCombustivel
     */
    public function setFkFrotaVeiculo(\Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo)
    {
        $this->codVeiculo = $fkFrotaVeiculo->getCodVeiculo();
        $this->fkFrotaVeiculo = $fkFrotaVeiculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaVeiculo
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    public function getFkFrotaVeiculo()
    {
        return $this->fkFrotaVeiculo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaCombustivel
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Combustivel $fkFrotaCombustivel
     * @return VeiculoCombustivel
     */
    public function setFkFrotaCombustivel(\Urbem\CoreBundle\Entity\Frota\Combustivel $fkFrotaCombustivel)
    {
        $this->codCombustivel = $fkFrotaCombustivel->getCodCombustivel();
        $this->fkFrotaCombustivel = $fkFrotaCombustivel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaCombustivel
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Combustivel
     */
    public function getFkFrotaCombustivel()
    {
        return $this->fkFrotaCombustivel;
    }

    function __toString()
    {
        return (string) $this->fkFrotaCombustivel;
    }
}
