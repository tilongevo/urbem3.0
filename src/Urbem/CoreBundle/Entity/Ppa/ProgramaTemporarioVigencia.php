<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * ProgramaTemporarioVigencia
 */
class ProgramaTemporarioVigencia
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
     * @var \DateTime
     */
    private $dtInicial;

    /**
     * @var \DateTime
     */
    private $dtFinal;

    /**
     * @var integer
     */
    private $valorGlobal;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ppa\ProgramaDados
     */
    private $fkPpaProgramaDados;

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
     * @return ProgramaTemporarioVigencia
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
     * @return ProgramaTemporarioVigencia
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
     * Set dtInicial
     *
     * @param \DateTime $dtInicial
     * @return ProgramaTemporarioVigencia
     */
    public function setDtInicial(\DateTime $dtInicial)
    {
        $this->dtInicial = $dtInicial;
        return $this;
    }

    /**
     * Get dtInicial
     *
     * @return \DateTime
     */
    public function getDtInicial()
    {
        return $this->dtInicial;
    }

    /**
     * Set dtFinal
     *
     * @param \DateTime $dtFinal
     * @return ProgramaTemporarioVigencia
     */
    public function setDtFinal(\DateTime $dtFinal)
    {
        $this->dtFinal = $dtFinal;
        return $this;
    }

    /**
     * Get dtFinal
     *
     * @return \DateTime
     */
    public function getDtFinal()
    {
        return $this->dtFinal;
    }

    /**
     * Set valorGlobal
     *
     * @param integer $valorGlobal
     * @return ProgramaTemporarioVigencia
     */
    public function setValorGlobal($valorGlobal)
    {
        $this->valorGlobal = $valorGlobal;
        return $this;
    }

    /**
     * Get valorGlobal
     *
     * @return integer
     */
    public function getValorGlobal()
    {
        return $this->valorGlobal;
    }

    /**
     * OneToOne (owning side)
     * Set PpaProgramaDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados
     * @return ProgramaTemporarioVigencia
     */
    public function setFkPpaProgramaDados(\Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados)
    {
        $this->codPrograma = $fkPpaProgramaDados->getCodPrograma();
        $this->timestampProgramaDados = $fkPpaProgramaDados->getTimestampProgramaDados();
        $this->fkPpaProgramaDados = $fkPpaProgramaDados;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPpaProgramaDados
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\ProgramaDados
     */
    public function getFkPpaProgramaDados()
    {
        return $this->fkPpaProgramaDados;
    }
}
