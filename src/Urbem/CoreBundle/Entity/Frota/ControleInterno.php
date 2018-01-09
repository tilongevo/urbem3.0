<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * ControleInterno
 */
class ControleInterno
{
    /**
     * PK
     * @var integer
     */
    private $codVeiculo;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var boolean
     */
    private $verificado = false;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    private $fkFrotaVeiculo;


    /**
     * Set codVeiculo
     *
     * @param integer $codVeiculo
     * @return ControleInterno
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ControleInterno
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set verificado
     *
     * @param boolean $verificado
     * @return ControleInterno
     */
    public function setVerificado($verificado)
    {
        $this->verificado = $verificado;
        return $this;
    }

    /**
     * Get verificado
     *
     * @return boolean
     */
    public function getVerificado()
    {
        return $this->verificado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     * @return ControleInterno
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
}
