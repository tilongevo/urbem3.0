<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * ProcessoDomicilioInformado
 */
class ProcessoDomicilioInformado
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampProc;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\DomicilioInformado
     */
    private $fkEconomicoDomicilioInformado;

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
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return ProcessoDomicilioInformado
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ProcessoDomicilioInformado
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
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return ProcessoDomicilioInformado
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
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return ProcessoDomicilioInformado
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
     * Set timestampProc
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampProc
     * @return ProcessoDomicilioInformado
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
     * Set fkEconomicoDomicilioInformado
     *
     * @param \Urbem\CoreBundle\Entity\Economico\DomicilioInformado $fkEconomicoDomicilioInformado
     * @return ProcessoDomicilioInformado
     */
    public function setFkEconomicoDomicilioInformado(\Urbem\CoreBundle\Entity\Economico\DomicilioInformado $fkEconomicoDomicilioInformado)
    {
        $this->inscricaoEconomica = $fkEconomicoDomicilioInformado->getInscricaoEconomica();
        $this->timestamp = $fkEconomicoDomicilioInformado->getTimestamp();
        $this->fkEconomicoDomicilioInformado = $fkEconomicoDomicilioInformado;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoDomicilioInformado
     *
     * @return \Urbem\CoreBundle\Entity\Economico\DomicilioInformado
     */
    public function getFkEconomicoDomicilioInformado()
    {
        return $this->fkEconomicoDomicilioInformado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return ProcessoDomicilioInformado
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
