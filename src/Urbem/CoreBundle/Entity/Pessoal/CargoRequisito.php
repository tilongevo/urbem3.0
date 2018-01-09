<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * CargoRequisito
 */
class CargoRequisito
{
    /**
     * PK
     * @var integer
     */
    private $codCargo;

    /**
     * PK
     * @var integer
     */
    private $codRequisito;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    private $fkPessoalCargo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Requisito
     */
    private $fkPessoalRequisito;


    /**
     * Set codCargo
     *
     * @param integer $codCargo
     * @return CargoRequisito
     */
    public function setCodCargo($codCargo)
    {
        $this->codCargo = $codCargo;
        return $this;
    }

    /**
     * Get codCargo
     *
     * @return integer
     */
    public function getCodCargo()
    {
        return $this->codCargo;
    }

    /**
     * Set codRequisito
     *
     * @param integer $codRequisito
     * @return CargoRequisito
     */
    public function setCodRequisito($codRequisito)
    {
        $this->codRequisito = $codRequisito;
        return $this;
    }

    /**
     * Get codRequisito
     *
     * @return integer
     */
    public function getCodRequisito()
    {
        return $this->codRequisito;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo
     * @return CargoRequisito
     */
    public function setFkPessoalCargo(\Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo)
    {
        $this->codCargo = $fkPessoalCargo->getCodCargo();
        $this->fkPessoalCargo = $fkPessoalCargo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCargo
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    public function getFkPessoalCargo()
    {
        return $this->fkPessoalCargo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalRequisito
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Requisito $fkPessoalRequisito
     * @return CargoRequisito
     */
    public function setFkPessoalRequisito(\Urbem\CoreBundle\Entity\Pessoal\Requisito $fkPessoalRequisito)
    {
        $this->codRequisito = $fkPessoalRequisito->getCodRequisito();
        $this->fkPessoalRequisito = $fkPessoalRequisito;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalRequisito
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Requisito
     */
    public function getFkPessoalRequisito()
    {
        return $this->fkPessoalRequisito;
    }
}
