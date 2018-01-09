<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * LicencaEspecial
 */
class LicencaEspecial
{
    /**
     * PK
     * @var integer
     */
    private $codLicenca;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var integer
     */
    private $ocorrenciaAtividade;

    /**
     * PK
     * @var integer
     */
    private $ocorrenciaLicenca;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Licenca
     */
    private $fkEconomicoLicenca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico
     */
    private $fkEconomicoAtividadeCadastroEconomico;


    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return LicencaEspecial
     */
    public function setCodLicenca($codLicenca)
    {
        $this->codLicenca = $codLicenca;
        return $this;
    }

    /**
     * Get codLicenca
     *
     * @return integer
     */
    public function getCodLicenca()
    {
        return $this->codLicenca;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return LicencaEspecial
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
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return LicencaEspecial
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
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return LicencaEspecial
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
     * Set ocorrenciaAtividade
     *
     * @param integer $ocorrenciaAtividade
     * @return LicencaEspecial
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
     * Set ocorrenciaLicenca
     *
     * @param integer $ocorrenciaLicenca
     * @return LicencaEspecial
     */
    public function setOcorrenciaLicenca($ocorrenciaLicenca)
    {
        $this->ocorrenciaLicenca = $ocorrenciaLicenca;
        return $this;
    }

    /**
     * Get ocorrenciaLicenca
     *
     * @return integer
     */
    public function getOcorrenciaLicenca()
    {
        return $this->ocorrenciaLicenca;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return LicencaEspecial
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtTermino
     *
     * @param \DateTime $dtTermino
     * @return LicencaEspecial
     */
    public function setDtTermino(\DateTime $dtTermino = null)
    {
        $this->dtTermino = $dtTermino;
        return $this;
    }

    /**
     * Get dtTermino
     *
     * @return \DateTime
     */
    public function getDtTermino()
    {
        return $this->dtTermino;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Licenca $fkEconomicoLicenca
     * @return LicencaEspecial
     */
    public function setFkEconomicoLicenca(\Urbem\CoreBundle\Entity\Economico\Licenca $fkEconomicoLicenca)
    {
        $this->codLicenca = $fkEconomicoLicenca->getCodLicenca();
        $this->exercicio = $fkEconomicoLicenca->getExercicio();
        $this->fkEconomicoLicenca = $fkEconomicoLicenca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoLicenca
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Licenca
     */
    public function getFkEconomicoLicenca()
    {
        return $this->fkEconomicoLicenca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoAtividadeCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico $fkEconomicoAtividadeCadastroEconomico
     * @return LicencaEspecial
     */
    public function setFkEconomicoAtividadeCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico $fkEconomicoAtividadeCadastroEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoAtividadeCadastroEconomico->getInscricaoEconomica();
        $this->codAtividade = $fkEconomicoAtividadeCadastroEconomico->getCodAtividade();
        $this->ocorrenciaAtividade = $fkEconomicoAtividadeCadastroEconomico->getOcorrenciaAtividade();
        $this->fkEconomicoAtividadeCadastroEconomico = $fkEconomicoAtividadeCadastroEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoAtividadeCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico
     */
    public function getFkEconomicoAtividadeCadastroEconomico()
    {
        return $this->fkEconomicoAtividadeCadastroEconomico;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getCodLicenca(), $this->getOcorrenciaLicenca());
    }
}
