<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * ProgramaNorma
 */
class ProgramaNorma
{
    /**
     * PK
     * @var integer
     */
    private $codPrograma;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampProgramaDados;

    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\ProgramaDados
     */
    private $fkPpaProgramaDados;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampProgramaDados = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codPrograma
     *
     * @param integer $codPrograma
     * @return ProgramaNorma
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
     * Set timestampProgramaDados
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampProgramaDados
     * @return ProgramaNorma
     */
    public function setTimestampProgramaDados(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampProgramaDados)
    {
        $this->timestampProgramaDados = $timestampProgramaDados;
        return $this;
    }

    /**
     * Get timestampProgramaDados
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampProgramaDados()
    {
        return $this->timestampProgramaDados;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return ProgramaNorma
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaProgramaDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados
     * @return ProgramaNorma
     */
    public function setFkPpaProgramaDados(\Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados)
    {
        $this->codPrograma = $fkPpaProgramaDados->getCodPrograma();
        $this->timestampProgramaDados = $fkPpaProgramaDados->getTimestampProgramaDados();
        $this->fkPpaProgramaDados = $fkPpaProgramaDados;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaProgramaDados
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\ProgramaDados
     */
    public function getFkPpaProgramaDados()
    {
        return $this->fkPpaProgramaDados;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return ProgramaNorma
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }
}
