<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * ProcessoSociedade
 */
class ProcessoSociedade
{
    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampProc;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Sociedade
     */
    private $fkEconomicoSociedade;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampProc = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ProcessoSociedade
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return ProcessoSociedade
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ProcessoSociedade
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return ProcessoSociedade
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return ProcessoSociedade
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
     * Set timestampProc
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampProc
     * @return ProcessoSociedade
     */
    public function setTimestampProc(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampProc)
    {
        $this->timestampProc = $timestampProc;
        return $this;
    }

    /**
     * Get timestampProc
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampProc()
    {
        return $this->timestampProc;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoSociedade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Sociedade $fkEconomicoSociedade
     * @return ProcessoSociedade
     */
    public function setFkEconomicoSociedade(\Urbem\CoreBundle\Entity\Economico\Sociedade $fkEconomicoSociedade)
    {
        $this->numcgm = $fkEconomicoSociedade->getNumcgm();
        $this->inscricaoEconomica = $fkEconomicoSociedade->getInscricaoEconomica();
        $this->timestamp = $fkEconomicoSociedade->getTimestamp();
        $this->fkEconomicoSociedade = $fkEconomicoSociedade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoSociedade
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Sociedade
     */
    public function getFkEconomicoSociedade()
    {
        return $this->fkEconomicoSociedade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return ProcessoSociedade
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->anoExercicio = $fkSwProcesso->getAnoExercicio();
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
