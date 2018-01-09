<?php

namespace Urbem\CoreBundle\Entity\Economico;

/**
 * ProcessoDiasCadEcon
 */
class ProcessoDiasCadEcon
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
    private $codDia;

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
     * @var \Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico
     */
    private $fkEconomicoDiasCadastroEconomico;

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
     * @return ProcessoDiasCadEcon
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
     * @return ProcessoDiasCadEcon
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
     * Set codDia
     *
     * @param integer $codDia
     * @return ProcessoDiasCadEcon
     */
    public function setCodDia($codDia)
    {
        $this->codDia = $codDia;
        return $this;
    }

    /**
     * Get codDia
     *
     * @return integer
     */
    public function getCodDia()
    {
        return $this->codDia;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return ProcessoDiasCadEcon
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
     * @return ProcessoDiasCadEcon
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
     * @return ProcessoDiasCadEcon
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
     * Set fkEconomicoDiasCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico $fkEconomicoDiasCadastroEconomico
     * @return ProcessoDiasCadEcon
     */
    public function setFkEconomicoDiasCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico $fkEconomicoDiasCadastroEconomico)
    {
        $this->codDia = $fkEconomicoDiasCadastroEconomico->getCodDia();
        $this->inscricaoEconomica = $fkEconomicoDiasCadastroEconomico->getInscricaoEconomica();
        $this->timestamp = $fkEconomicoDiasCadastroEconomico->getTimestamp();
        $this->fkEconomicoDiasCadastroEconomico = $fkEconomicoDiasCadastroEconomico;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoDiasCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico
     */
    public function getFkEconomicoDiasCadastroEconomico()
    {
        return $this->fkEconomicoDiasCadastroEconomico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return ProcessoDiasCadEcon
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
