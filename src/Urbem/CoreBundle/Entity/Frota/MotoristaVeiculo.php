<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * MotoristaVeiculo
 */
class MotoristaVeiculo
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
    private $cgmMotorista;

    /**
     * @var boolean
     */
    private $padrao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    private $fkFrotaVeiculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Motorista
     */
    private $fkFrotaMotorista;


    /**
     * Set codVeiculo
     *
     * @param integer $codVeiculo
     * @return MotoristaVeiculo
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
     * Set cgmMotorista
     *
     * @param integer $cgmMotorista
     * @return MotoristaVeiculo
     */
    public function setCgmMotorista($cgmMotorista)
    {
        $this->cgmMotorista = $cgmMotorista;
        return $this;
    }

    /**
     * Get cgmMotorista
     *
     * @return integer
     */
    public function getCgmMotorista()
    {
        return $this->cgmMotorista;
    }

    /**
     * Set padrao
     *
     * @param boolean $padrao
     * @return MotoristaVeiculo
     */
    public function setPadrao($padrao = null)
    {
        $this->padrao = $padrao;
        return $this;
    }

    /**
     * Get padrao
     *
     * @return boolean
     */
    public function getPadrao()
    {
        return $this->padrao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     * @return MotoristaVeiculo
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
     * Set fkFrotaMotorista
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Motorista $fkFrotaMotorista
     * @return MotoristaVeiculo
     */
    public function setFkFrotaMotorista(\Urbem\CoreBundle\Entity\Frota\Motorista $fkFrotaMotorista)
    {
        $this->cgmMotorista = $fkFrotaMotorista->getCgmMotorista();
        $this->fkFrotaMotorista = $fkFrotaMotorista;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaMotorista
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Motorista
     */
    public function getFkFrotaMotorista()
    {
        return $this->fkFrotaMotorista;
    }
}
