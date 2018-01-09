<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * Municipal
 */
class Municipal
{
    /**
     * PK
     * @var integer
     */
    private $codPrograma;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Cse\ProgramaSocial
     */
    private $fkCseProgramaSocial;


    /**
     * Set codPrograma
     *
     * @param integer $codPrograma
     * @return Municipal
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return Municipal
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
     * OneToOne (owning side)
     * Set CseProgramaSocial
     *
     * @param \Urbem\CoreBundle\Entity\Cse\ProgramaSocial $fkCseProgramaSocial
     * @return Municipal
     */
    public function setFkCseProgramaSocial(\Urbem\CoreBundle\Entity\Cse\ProgramaSocial $fkCseProgramaSocial)
    {
        $this->codPrograma = $fkCseProgramaSocial->getCodPrograma();
        $this->exercicio = $fkCseProgramaSocial->getExercicio();
        $this->fkCseProgramaSocial = $fkCseProgramaSocial;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkCseProgramaSocial
     *
     * @return \Urbem\CoreBundle\Entity\Cse\ProgramaSocial
     */
    public function getFkCseProgramaSocial()
    {
        return $this->fkCseProgramaSocial;
    }
}
