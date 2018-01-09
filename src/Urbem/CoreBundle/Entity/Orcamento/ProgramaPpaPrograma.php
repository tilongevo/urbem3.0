<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * ProgramaPpaPrograma
 */
class ProgramaPpaPrograma
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
    private $codPrograma;

    /**
     * PK
     * @var integer
     */
    private $codProgramaPpa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Programa
     */
    private $fkOrcamentoPrograma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\Programa
     */
    private $fkPpaPrograma;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ProgramaPpaPrograma
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
     * Set codPrograma
     *
     * @param integer $codPrograma
     * @return ProgramaPpaPrograma
     */
    public function setCodPrograma($codPrograma)
    {
        $this->codPrograma = $codPrograma;
        return $this;
    }

    /**
     * Get codPrograma
     *
     * @return integer
     */
    public function getCodPrograma()
    {
        return $this->codPrograma;
    }

    /**
     * Set codProgramaPpa
     *
     * @param integer $codProgramaPpa
     * @return ProgramaPpaPrograma
     */
    public function setCodProgramaPpa($codProgramaPpa)
    {
        $this->codProgramaPpa = $codProgramaPpa;
        return $this;
    }

    /**
     * Get codProgramaPpa
     *
     * @return integer
     */
    public function getCodProgramaPpa()
    {
        return $this->codProgramaPpa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Programa $fkOrcamentoPrograma
     * @return ProgramaPpaPrograma
     */
    public function setFkOrcamentoPrograma(\Urbem\CoreBundle\Entity\Orcamento\Programa $fkOrcamentoPrograma)
    {
        $this->exercicio = $fkOrcamentoPrograma->getExercicio();
        $this->codPrograma = $fkOrcamentoPrograma->getCodPrograma();
        $this->fkOrcamentoPrograma = $fkOrcamentoPrograma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoPrograma
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Programa
     */
    public function getFkOrcamentoPrograma()
    {
        return $this->fkOrcamentoPrograma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Programa $fkPpaPrograma
     * @return ProgramaPpaPrograma
     */
    public function setFkPpaPrograma(\Urbem\CoreBundle\Entity\Ppa\Programa $fkPpaPrograma)
    {
        $this->codProgramaPpa = $fkPpaPrograma->getCodPrograma();
        $this->fkPpaPrograma = $fkPpaPrograma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaPrograma
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Programa
     */
    public function getFkPpaPrograma()
    {
        return $this->fkPpaPrograma;
    }
}
