<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * ProcessoModLancInscEcon
 */
class ProcessoModLancInscEcon
{
    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * PK
     * @var integer
     */
    private $ocorrenciaAtividade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtInicio;

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
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento
     */
    private $fkEconomicoCadastroEconomicoModalidadeLancamento;

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
        $this->dtInicio = new \Urbem\CoreBundle\Helper\DatePK;
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ProcessoModLancInscEcon
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return ProcessoModLancInscEcon
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
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return ProcessoModLancInscEcon
     */
    public function setCodAtividade($codAtividade)
    {
        $this->codAtividade = $codAtividade;
        return $this;
    }

    /**
     * Get codAtividade
     *
     * @return integer
     */
    public function getCodAtividade()
    {
        return $this->codAtividade;
    }

    /**
     * Set ocorrenciaAtividade
     *
     * @param integer $ocorrenciaAtividade
     * @return ProcessoModLancInscEcon
     */
    public function setOcorrenciaAtividade($ocorrenciaAtividade)
    {
        $this->ocorrenciaAtividade = $ocorrenciaAtividade;
        return $this;
    }

    /**
     * Get ocorrenciaAtividade
     *
     * @return integer
     */
    public function getOcorrenciaAtividade()
    {
        return $this->ocorrenciaAtividade;
    }

    /**
     * Set dtInicio
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtInicio
     * @return ProcessoModLancInscEcon
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
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return ProcessoModLancInscEcon
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
     * @return ProcessoModLancInscEcon
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return ProcessoModLancInscEcon
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCadastroEconomicoModalidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento $fkEconomicoCadastroEconomicoModalidadeLancamento
     * @return ProcessoModLancInscEcon
     */
    public function setFkEconomicoCadastroEconomicoModalidadeLancamento(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento $fkEconomicoCadastroEconomicoModalidadeLancamento)
    {
        $this->codModalidade = $fkEconomicoCadastroEconomicoModalidadeLancamento->getCodModalidade();
        $this->codAtividade = $fkEconomicoCadastroEconomicoModalidadeLancamento->getCodAtividade();
        $this->inscricaoEconomica = $fkEconomicoCadastroEconomicoModalidadeLancamento->getInscricaoEconomica();
        $this->ocorrenciaAtividade = $fkEconomicoCadastroEconomicoModalidadeLancamento->getOcorrenciaAtividade();
        $this->dtInicio = $fkEconomicoCadastroEconomicoModalidadeLancamento->getDtInicio();
        $this->fkEconomicoCadastroEconomicoModalidadeLancamento = $fkEconomicoCadastroEconomicoModalidadeLancamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCadastroEconomicoModalidadeLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento
     */
    public function getFkEconomicoCadastroEconomicoModalidadeLancamento()
    {
        return $this->fkEconomicoCadastroEconomicoModalidadeLancamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return ProcessoModLancInscEcon
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
