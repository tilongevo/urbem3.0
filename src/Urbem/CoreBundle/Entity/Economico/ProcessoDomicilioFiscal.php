<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * ProcessoDomicilioFiscal
 */
class ProcessoDomicilioFiscal
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
     * @var \Urbem\CoreBundle\Entity\Economico\DomicilioFiscal
     */
    private $fkEconomicoDomicilioFiscal;

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
     * @return ProcessoDomicilioFiscal
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
     * @return ProcessoDomicilioFiscal
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
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return ProcessoDomicilioFiscal
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
     * @return ProcessoDomicilioFiscal
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
     * @return ProcessoDomicilioFiscal
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
     * Set fkEconomicoDomicilioFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Economico\DomicilioFiscal $fkEconomicoDomicilioFiscal
     * @return ProcessoDomicilioFiscal
     */
    public function setFkEconomicoDomicilioFiscal(\Urbem\CoreBundle\Entity\Economico\DomicilioFiscal $fkEconomicoDomicilioFiscal)
    {
        $this->inscricaoEconomica = $fkEconomicoDomicilioFiscal->getInscricaoEconomica();
        $this->timestamp = $fkEconomicoDomicilioFiscal->getTimestamp();
        $this->fkEconomicoDomicilioFiscal = $fkEconomicoDomicilioFiscal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoDomicilioFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Economico\DomicilioFiscal
     */
    public function getFkEconomicoDomicilioFiscal()
    {
        return $this->fkEconomicoDomicilioFiscal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return ProcessoDomicilioFiscal
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
