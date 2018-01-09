<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * PpaEstimativaOrcamentariaBase
 */
class PpaEstimativaOrcamentariaBase
{
    /**
     * PK
     * @var integer
     */
    private $codPpa;

    /**
     * PK
     * @var integer
     */
    private $codReceita;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $percentualAno1;

    /**
     * @var integer
     */
    private $percentualAno2;

    /**
     * @var integer
     */
    private $percentualAno3;

    /**
     * @var integer
     */
    private $percentualAno4;

    /**
     * @var string
     */
    private $tipoPercentualInformado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\Ppa
     */
    private $fkPpaPpa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\EstimativaOrcamentariaBase
     */
    private $fkPpaEstimativaOrcamentariaBase;


    /**
     * Set codPpa
     *
     * @param integer $codPpa
     * @return PpaEstimativaOrcamentariaBase
     */
    public function setCodPpa($codPpa)
    {
        $this->codPpa = $codPpa;
        return $this;
    }

    /**
     * Get codPpa
     *
     * @return integer
     */
    public function getCodPpa()
    {
        return $this->codPpa;
    }

    /**
     * Set codReceita
     *
     * @param integer $codReceita
     * @return PpaEstimativaOrcamentariaBase
     */
    public function setCodReceita($codReceita)
    {
        $this->codReceita = $codReceita;
        return $this;
    }

    /**
     * Get codReceita
     *
     * @return integer
     */
    public function getCodReceita()
    {
        return $this->codReceita;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return PpaEstimativaOrcamentariaBase
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set percentualAno1
     *
     * @param integer $percentualAno1
     * @return PpaEstimativaOrcamentariaBase
     */
    public function setPercentualAno1($percentualAno1)
    {
        $this->percentualAno1 = $percentualAno1;
        return $this;
    }

    /**
     * Get percentualAno1
     *
     * @return integer
     */
    public function getPercentualAno1()
    {
        return $this->percentualAno1;
    }

    /**
     * Set percentualAno2
     *
     * @param integer $percentualAno2
     * @return PpaEstimativaOrcamentariaBase
     */
    public function setPercentualAno2($percentualAno2)
    {
        $this->percentualAno2 = $percentualAno2;
        return $this;
    }

    /**
     * Get percentualAno2
     *
     * @return integer
     */
    public function getPercentualAno2()
    {
        return $this->percentualAno2;
    }

    /**
     * Set percentualAno3
     *
     * @param integer $percentualAno3
     * @return PpaEstimativaOrcamentariaBase
     */
    public function setPercentualAno3($percentualAno3)
    {
        $this->percentualAno3 = $percentualAno3;
        return $this;
    }

    /**
     * Get percentualAno3
     *
     * @return integer
     */
    public function getPercentualAno3()
    {
        return $this->percentualAno3;
    }

    /**
     * Set percentualAno4
     *
     * @param integer $percentualAno4
     * @return PpaEstimativaOrcamentariaBase
     */
    public function setPercentualAno4($percentualAno4)
    {
        $this->percentualAno4 = $percentualAno4;
        return $this;
    }

    /**
     * Get percentualAno4
     *
     * @return integer
     */
    public function getPercentualAno4()
    {
        return $this->percentualAno4;
    }

    /**
     * Set tipoPercentualInformado
     *
     * @param string $tipoPercentualInformado
     * @return PpaEstimativaOrcamentariaBase
     */
    public function setTipoPercentualInformado($tipoPercentualInformado)
    {
        $this->tipoPercentualInformado = $tipoPercentualInformado;
        return $this;
    }

    /**
     * Get tipoPercentualInformado
     *
     * @return string
     */
    public function getTipoPercentualInformado()
    {
        return $this->tipoPercentualInformado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaPpa
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Ppa $fkPpaPpa
     * @return PpaEstimativaOrcamentariaBase
     */
    public function setFkPpaPpa(\Urbem\CoreBundle\Entity\Ppa\Ppa $fkPpaPpa)
    {
        $this->codPpa = $fkPpaPpa->getCodPpa();
        $this->fkPpaPpa = $fkPpaPpa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaPpa
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Ppa
     */
    public function getFkPpaPpa()
    {
        return $this->fkPpaPpa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaEstimativaOrcamentariaBase
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\EstimativaOrcamentariaBase $fkPpaEstimativaOrcamentariaBase
     * @return PpaEstimativaOrcamentariaBase
     */
    public function setFkPpaEstimativaOrcamentariaBase(\Urbem\CoreBundle\Entity\Ppa\EstimativaOrcamentariaBase $fkPpaEstimativaOrcamentariaBase)
    {
        $this->codReceita = $fkPpaEstimativaOrcamentariaBase->getCodReceita();
        $this->fkPpaEstimativaOrcamentariaBase = $fkPpaEstimativaOrcamentariaBase;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaEstimativaOrcamentariaBase
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\EstimativaOrcamentariaBase
     */
    public function getFkPpaEstimativaOrcamentariaBase()
    {
        return $this->fkPpaEstimativaOrcamentariaBase;
    }
}
