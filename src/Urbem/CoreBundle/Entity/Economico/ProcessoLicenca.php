<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * ProcessoLicenca
 */
class ProcessoLicenca
{
    /**
     * PK
     * @var integer
     */
    private $codLicenca;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $exercicioProcesso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Licenca
     */
    private $fkEconomicoLicenca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;


    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return ProcessoLicenca
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ProcessoLicenca
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
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return ProcessoLicenca
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
     * @return ProcessoLicenca
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
     * Set fkEconomicoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Licenca $fkEconomicoLicenca
     * @return ProcessoLicenca
     */
    public function setFkEconomicoLicenca(\Urbem\CoreBundle\Entity\Economico\Licenca $fkEconomicoLicenca)
    {
        $this->codLicenca = $fkEconomicoLicenca->getCodLicenca();
        $this->exercicio = $fkEconomicoLicenca->getExercicio();
        $this->fkEconomicoLicenca = $fkEconomicoLicenca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoLicenca
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Licenca
     */
    public function getFkEconomicoLicenca()
    {
        return $this->fkEconomicoLicenca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return ProcessoLicenca
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

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getCodProcesso(), $this->getExercicio());
    }
}
