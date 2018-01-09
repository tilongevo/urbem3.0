<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * ProcessoBaixaLicenca
 */
class ProcessoBaixaLicenca
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codLicenca;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtInicio;

    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * @var string
     */
    private $exercicioProcesso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\BaixaLicenca
     */
    private $fkEconomicoBaixaLicenca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtInicio = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ProcessoBaixaLicenca
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
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return ProcessoBaixaLicenca
     */
    public function setCodLicenca($codLicenca)
    {
        $this->codLicenca = $codLicenca;
        return $this;
    }

    /**
     * Get codLicenca
     *
     * @return integer
     */
    public function getCodLicenca()
    {
        return $this->codLicenca;
    }

    /**
     * Set dtInicio
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtInicio
     * @return ProcessoBaixaLicenca
     */
    public function setDtInicio(\Urbem\CoreBundle\Helper\DatePK $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return ProcessoBaixaLicenca
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set exercicioProcesso
     *
     * @param string $exercicioProcesso
     * @return ProcessoBaixaLicenca
     */
    public function setExercicioProcesso($exercicioProcesso)
    {
        $this->exercicioProcesso = $exercicioProcesso;
        return $this;
    }

    /**
     * Get exercicioProcesso
     *
     * @return string
     */
    public function getExercicioProcesso()
    {
        return $this->exercicioProcesso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoBaixaLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\BaixaLicenca $fkEconomicoBaixaLicenca
     * @return ProcessoBaixaLicenca
     */
    public function setFkEconomicoBaixaLicenca(\Urbem\CoreBundle\Entity\Economico\BaixaLicenca $fkEconomicoBaixaLicenca)
    {
        $this->codLicenca = $fkEconomicoBaixaLicenca->getCodLicenca();
        $this->exercicio = $fkEconomicoBaixaLicenca->getExercicio();
        $this->dtInicio = $fkEconomicoBaixaLicenca->getDtInicio();
        $this->fkEconomicoBaixaLicenca = $fkEconomicoBaixaLicenca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoBaixaLicenca
     *
     * @return \Urbem\CoreBundle\Entity\Economico\BaixaLicenca
     */
    public function getFkEconomicoBaixaLicenca()
    {
        return $this->fkEconomicoBaixaLicenca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return ProcessoBaixaLicenca
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->exercicioProcesso = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }
}
