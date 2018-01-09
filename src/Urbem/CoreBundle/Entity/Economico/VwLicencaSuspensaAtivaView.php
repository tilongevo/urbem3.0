<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * VwLicencaSuspensaAtivaView
 */
class VwLicencaSuspensaAtivaView
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
     * @var integer
     */
    private $codProcessoBaixa;

    /**
     * @var string
     */
    private $exercicioProcessoBaixa;

    /**
     * @var \DateTime
     */
    private $dtSuspInicio;

    /**
     * @var \DateTime
     */
    private $dtSuspTermino;

    /**
     * @var string
     */
    private $motivo;


    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return VwLicencaSuspensaAtiva
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
     * @return VwLicencaSuspensaAtiva
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
     * @return VwLicencaSuspensaAtiva
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
     * @return VwLicencaSuspensaAtiva
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
     * @return VwLicencaSuspensaAtiva
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
     * Set exercicioProcesso
     *
     * @param string $exercicioProcesso
     * @return VwLicencaSuspensaAtiva
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
     * @return VwLicencaSuspensaAtiva
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
     * @return VwLicencaSuspensaAtiva
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
     * @return VwLicencaSuspensaAtiva
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
     * @return VwLicencaSuspensaAtiva
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
     * @return VwLicencaSuspensaAtiva
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

    /**
     * Set codProcessoBaixa
     *
     * @param integer $codProcessoBaixa
     * @return VwLicencaSuspensaAtiva
     */
    public function setCodProcessoBaixa($codProcessoBaixa = null)
    {
        $this->codProcessoBaixa = $codProcessoBaixa;
        return $this;
    }

    /**
     * Get codProcessoBaixa
     *
     * @return integer
     */
    public function getCodProcessoBaixa()
    {
        return $this->codProcessoBaixa;
    }

    /**
     * Set exercicioProcessoBaixa
     *
     * @param string $exercicioProcessoBaixa
     * @return VwLicencaSuspensaAtiva
     */
    public function setExercicioProcessoBaixa($exercicioProcessoBaixa = null)
    {
        $this->exercicioProcessoBaixa = $exercicioProcessoBaixa;
        return $this;
    }

    /**
     * Get exercicioProcessoBaixa
     *
     * @return string
     */
    public function getExercicioProcessoBaixa()
    {
        return $this->exercicioProcessoBaixa;
    }

    /**
     * Set dtSuspInicio
     *
     * @param \DateTime $dtSuspInicio
     * @return VwLicencaSuspensaAtiva
     */
    public function setDtSuspInicio(\DateTime $dtSuspInicio = null)
    {
        $this->dtSuspInicio = $dtSuspInicio;
        return $this;
    }

    /**
     * Get dtSuspInicio
     *
     * @return \DateTime
     */
    public function getDtSuspInicio()
    {
        return $this->dtSuspInicio;
    }

    /**
     * Set dtSuspTermino
     *
     * @param \DateTime $dtSuspTermino
     * @return VwLicencaSuspensaAtiva
     */
    public function setDtSuspTermino(\DateTime $dtSuspTermino = null)
    {
        $this->dtSuspTermino = $dtSuspTermino;
        return $this;
    }

    /**
     * Get dtSuspTermino
     *
     * @return \DateTime
     */
    public function getDtSuspTermino()
    {
        return $this->dtSuspTermino;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return VwLicencaSuspensaAtiva
     */
    public function setMotivo($motivo = null)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }
}
