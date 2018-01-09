<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * VwLicencaAtivaView
 */
class VwLicencaAtivaView
{
    /**
     * PK
     * @var integer
     */
    private $codLicenca;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * @var integer
     */
    private $codProcesso;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * @var string
     */
    private $exercicioProcesso;

    /**
     * @var string
     */
    private $especieLicenca;

    /**
     * @var integer
     */
    private $codTipoDiversa;

    /**
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $nomCgm;


    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return VwLicencaAtiva
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
     * @return VwLicencaAtiva
     */
    public function setExercicio($exercicio = null)
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
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return VwLicencaAtiva
     */
    public function setDtInicio(\DateTime $dtInicio = null)
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
     * @return VwLicencaAtiva
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
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return VwLicencaAtiva
     */
    public function setCodProcesso($codProcesso = null)
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
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return VwLicencaAtiva
     */
    public function setNomTipo($nomTipo = null)
    {
        $this->nomTipo = $nomTipo;
        return $this;
    }

    /**
     * Get nomTipo
     *
     * @return string
     */
    public function getNomTipo()
    {
        return $this->nomTipo;
    }

    /**
     * Set exercicioProcesso
     *
     * @param string $exercicioProcesso
     * @return VwLicencaAtiva
     */
    public function setExercicioProcesso($exercicioProcesso = null)
    {
        $this->exercicioProcesso = $exercicioProcesso;
        return $this;
    }

    /**
     * Get exercicioProcesso
     *
     * @return string
     */
    public function getExercicioProcesso()
    {
        return $this->exercicioProcesso;
    }

    /**
     * Set especieLicenca
     *
     * @param string $especieLicenca
     * @return VwLicencaAtiva
     */
    public function setEspecieLicenca($especieLicenca = null)
    {
        $this->especieLicenca = $especieLicenca;
        return $this;
    }

    /**
     * Get especieLicenca
     *
     * @return string
     */
    public function getEspecieLicenca()
    {
        return $this->especieLicenca;
    }

    /**
     * Set codTipoDiversa
     *
     * @param integer $codTipoDiversa
     * @return VwLicencaAtiva
     */
    public function setCodTipoDiversa($codTipoDiversa = null)
    {
        $this->codTipoDiversa = $codTipoDiversa;
        return $this;
    }

    /**
     * Get codTipoDiversa
     *
     * @return integer
     */
    public function getCodTipoDiversa()
    {
        return $this->codTipoDiversa;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return VwLicencaAtiva
     */
    public function setInscricaoEconomica($inscricaoEconomica = null)
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
     * @return VwLicencaAtiva
     */
    public function setNumcgm($numcgm = null)
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
     * Set nomCgm
     *
     * @param string $nomCgm
     * @return VwLicencaAtiva
     */
    public function setNomCgm($nomCgm = null)
    {
        $this->nomCgm = $nomCgm;
        return $this;
    }

    /**
     * Get nomCgm
     *
     * @return string
     */
    public function getNomCgm()
    {
        return $this->nomCgm;
    }
}
