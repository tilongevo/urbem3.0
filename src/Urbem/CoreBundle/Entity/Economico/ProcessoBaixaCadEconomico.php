<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * ProcessoBaixaCadEconomico
 */
class ProcessoBaixaCadEconomico
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtInicio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico
     */
    private $fkEconomicoBaixaCadastroEconomico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtInicio = new \Urbem\CoreBundle\Helper\DatePK;
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return ProcessoBaixaCadEconomico
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ProcessoBaixaCadEconomico
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
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return ProcessoBaixaCadEconomico
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
     * Set dtInicio
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtInicio
     * @return ProcessoBaixaCadEconomico
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ProcessoBaixaCadEconomico
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
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return ProcessoBaixaCadEconomico
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->exercicio = $fkSwProcesso->getAnoExercicio();
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
     * ManyToOne (inverse side)
     * Set fkEconomicoBaixaCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico $fkEconomicoBaixaCadastroEconomico
     * @return ProcessoBaixaCadEconomico
     */
    public function setFkEconomicoBaixaCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico $fkEconomicoBaixaCadastroEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoBaixaCadastroEconomico->getInscricaoEconomica();
        $this->dtInicio = $fkEconomicoBaixaCadastroEconomico->getDtInicio();
        $this->timestamp = $fkEconomicoBaixaCadastroEconomico->getTimestamp();
        $this->fkEconomicoBaixaCadastroEconomico = $fkEconomicoBaixaCadastroEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoBaixaCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico
     */
    public function getFkEconomicoBaixaCadastroEconomico()
    {
        return $this->fkEconomicoBaixaCadastroEconomico;
    }
}
