<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

class VwConsultarCancelarFerias
{
    /**
     * PK
     * @var integer
     */
    private $codFerias;

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
    private $registro;

    /**
     * @var integer
     */
    private $codContrato;

    /**
     * @var string
     */
    private $descLocal;

    /**
     * @var string
     */
    private $descOrgao;

    /**
     * @var string
     */
    private $orgao;

    /**
     * @var \DateTime
     */
    private $dtPosse;

    /**
     * @var \DateTime
     */
    private $dtAdmissao;

    /**
     * @var \DateTime
     */
    private $dtNomeacao;

    /**
     * @var string
     */
    private $descFuncao;

    /**
     * @var string
     */
    private $descRegimeFuncao;

    /**
     * @var integer
     */
    private $codRegimeFuncao;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * @var integer
     */
    private $codLocal;

    /**
     * @var integer
     */
    private $codOrgao;

    /**
     * @var boolean
     */
    private $boCadastradas;

    /**
     * @var string
     */
    private $situacao;

    /**
     * @var \DateTime
     */
    private $dtInicialAquisitivo;

    /**
     * @var \DateTime
     */
    private $dtFinalAquisitivo;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtFim;

    /**
     * @var string
     */
    private $mesCompetencia;

    /**
     * @var string
     */
    private $anoCompetencia;

    /**
     * @var string
     */
    private $competencia;

    /**
     * @var string
     */
    private $dtInicialAquisitivoFormatado;

    /**
     * @var string
     */
    private $dtFinalAquisitivoFormatado;

    /**
     * @var string
     */
    private $dtAdmissaoFormatado;

    /**
     * @var integer
     */
    private $feriasTiradas;


    /**
     * Set codFerias
     *
     * @param integer $codFerias
     * @return VwConcederFerias
     */
    public function setCodFerias($codFerias)
    {
        $this->codFerias = $codFerias;
        return $this;
    }

    /**
     * Get codFerias
     *
     * @return integer
     */
    public function getCodFerias()
    {
        return $this->codFerias;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return VwConcederFerias
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
     * @return VwConcederFerias
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
     * Set registro
     *
     * @param integer $registro
     * @return VwConcederFerias
     */
    public function setRegistro($registro = null)
    {
        $this->registro = $registro;
        return $this;
    }

    /**
     * Get registro
     *
     * @return integer
     */
    public function getRegistro()
    {
        return $this->registro;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return VwConcederFerias
     */
    public function setCodContrato($codContrato = null)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set descLocal
     *
     * @param string $descLocal
     * @return VwConcederFerias
     */
    public function setDescLocal($descLocal = null)
    {
        $this->descLocal = $descLocal;
        return $this;
    }

    /**
     * Get descLocal
     *
     * @return string
     */
    public function getDescLocal()
    {
        return $this->descLocal;
    }

    /**
     * Set descOrgao
     *
     * @param string $descOrgao
     * @return VwConcederFerias
     */
    public function setDescOrgao($descOrgao = null)
    {
        $this->descOrgao = $descOrgao;
        return $this;
    }

    /**
     * Get descOrgao
     *
     * @return string
     */
    public function getDescOrgao()
    {
        return $this->descOrgao;
    }

    /**
     * Set orgao
     *
     * @param string $orgao
     * @return VwConcederFerias
     */
    public function setOrgao($orgao = null)
    {
        $this->orgao = $orgao;
        return $this;
    }

    /**
     * Get orgao
     *
     * @return string
     */
    public function getOrgao()
    {
        return $this->orgao;
    }

    /**
     * Set dtPosse
     *
     * @param \DateTime $dtPosse
     * @return VwConcederFerias
     */
    public function setDtPosse(\DateTime $dtPosse = null)
    {
        $this->dtPosse = $dtPosse;
        return $this;
    }

    /**
     * Get dtPosse
     *
     * @return \DateTime
     */
    public function getDtPosse()
    {
        return $this->dtPosse;
    }

    /**
     * Set dtAdmissao
     *
     * @param \DateTime $dtAdmissao
     * @return VwConcederFerias
     */
    public function setDtAdmissao(\DateTime $dtAdmissao = null)
    {
        $this->dtAdmissao = $dtAdmissao;
        return $this;
    }

    /**
     * Get dtAdmissao
     *
     * @return \DateTime
     */
    public function getDtAdmissao()
    {
        return $this->dtAdmissao;
    }

    /**
     * Set dtNomeacao
     *
     * @param \DateTime $dtNomeacao
     * @return VwConcederFerias
     */
    public function setDtNomeacao(\DateTime $dtNomeacao = null)
    {
        $this->dtNomeacao = $dtNomeacao;
        return $this;
    }

    /**
     * Get dtNomeacao
     *
     * @return \DateTime
     */
    public function getDtNomeacao()
    {
        return $this->dtNomeacao;
    }

    /**
     * Set descFuncao
     *
     * @param string $descFuncao
     * @return VwConcederFerias
     */
    public function setDescFuncao($descFuncao = null)
    {
        $this->descFuncao = $descFuncao;
        return $this;
    }

    /**
     * Get descFuncao
     *
     * @return string
     */
    public function getDescFuncao()
    {
        return $this->descFuncao;
    }

    /**
     * Set descRegimeFuncao
     *
     * @param string $descRegimeFuncao
     * @return VwConcederFerias
     */
    public function setDescRegimeFuncao($descRegimeFuncao = null)
    {
        $this->descRegimeFuncao = $descRegimeFuncao;
        return $this;
    }

    /**
     * Get descRegimeFuncao
     *
     * @return string
     */
    public function getDescRegimeFuncao()
    {
        return $this->descRegimeFuncao;
    }

    /**
     * Set codRegimeFuncao
     *
     * @param integer $codRegimeFuncao
     * @return VwConcederFerias
     */
    public function setCodRegimeFuncao($codRegimeFuncao = null)
    {
        $this->codRegimeFuncao = $codRegimeFuncao;
        return $this;
    }

    /**
     * Get codRegimeFuncao
     *
     * @return integer
     */
    public function getCodRegimeFuncao()
    {
        return $this->codRegimeFuncao;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return VwConcederFerias
     */
    public function setCodFuncao($codFuncao = null)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * Set codLocal
     *
     * @param integer $codLocal
     * @return VwConcederFerias
     */
    public function setCodLocal($codLocal = null)
    {
        $this->codLocal = $codLocal;
        return $this;
    }

    /**
     * Get codLocal
     *
     * @return integer
     */
    public function getCodLocal()
    {
        return $this->codLocal;
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return VwConcederFerias
     */
    public function setCodOrgao($codOrgao = null)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * Set boCadastradas
     *
     * @param boolean $boCadastradas
     * @return VwConcederFerias
     */
    public function setBoCadastradas($boCadastradas = null)
    {
        $this->boCadastradas = $boCadastradas;
        return $this;
    }

    /**
     * Get boCadastradas
     *
     * @return boolean
     */
    public function getBoCadastradas()
    {
        return $this->boCadastradas;
    }

    /**
     * Set situacao
     *
     * @param string $situacao
     * @return VwConcederFerias
     */
    public function setSituacao($situacao = null)
    {
        $this->situacao = $situacao;
        return $this;
    }

    /**
     * Get situacao
     *
     * @return string
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * Set dtInicialAquisitivo
     *
     * @param \DateTime $dtInicialAquisitivo
     * @return VwConcederFerias
     */
    public function setDtInicialAquisitivo(\DateTime $dtInicialAquisitivo = null)
    {
        $this->dtInicialAquisitivo = $dtInicialAquisitivo;
        return $this;
    }

    /**
     * Get dtInicialAquisitivo
     *
     * @return \DateTime
     */
    public function getDtInicialAquisitivo()
    {
        return $this->dtInicialAquisitivo;
    }

    /**
     * Set dtFinalAquisitivo
     *
     * @param \DateTime $dtFinalAquisitivo
     * @return VwConcederFerias
     */
    public function setDtFinalAquisitivo(\DateTime $dtFinalAquisitivo = null)
    {
        $this->dtFinalAquisitivo = $dtFinalAquisitivo;
        return $this;
    }

    /**
     * Get dtFinalAquisitivo
     *
     * @return \DateTime
     */
    public function getDtFinalAquisitivo()
    {
        return $this->dtFinalAquisitivo;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return VwConcederFerias
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
     * Set dtFim
     *
     * @param \DateTime $dtFim
     * @return VwConcederFerias
     */
    public function setDtFim(\DateTime $dtFim = null)
    {
        $this->dtFim = $dtFim;
        return $this;
    }

    /**
     * Get dtFim
     *
     * @return \DateTime
     */
    public function getDtFim()
    {
        return $this->dtFim;
    }

    /**
     * Set mesCompetencia
     *
     * @param string $mesCompetencia
     * @return VwConcederFerias
     */
    public function setMesCompetencia($mesCompetencia = null)
    {
        $this->mesCompetencia = $mesCompetencia;
        return $this;
    }

    /**
     * Get mesCompetencia
     *
     * @return string
     */
    public function getMesCompetencia()
    {
        return $this->mesCompetencia;
    }

    /**
     * Set anoCompetencia
     *
     * @param string $anoCompetencia
     * @return VwConcederFerias
     */
    public function setAnoCompetencia($anoCompetencia = null)
    {
        $this->anoCompetencia = $anoCompetencia;
        return $this;
    }

    /**
     * Get anoCompetencia
     *
     * @return string
     */
    public function getAnoCompetencia()
    {
        return $this->anoCompetencia;
    }

    /**
     * Set competencia
     *
     * @param string $competencia
     * @return VwConcederFerias
     */
    public function setCompetencia($competencia = null)
    {
        $this->competencia = $competencia;
        return $this;
    }

    /**
     * Get competencia
     *
     * @return string
     */
    public function getCompetencia()
    {
        return $this->competencia;
    }

    /**
     * Set dtInicialAquisitivoFormatado
     *
     * @param string $dtInicialAquisitivoFormatado
     * @return VwConcederFerias
     */
    public function setDtInicialAquisitivoFormatado($dtInicialAquisitivoFormatado = null)
    {
        $this->dtInicialAquisitivoFormatado = $dtInicialAquisitivoFormatado;
        return $this;
    }

    /**
     * Get dtInicialAquisitivoFormatado
     *
     * @return string
     */
    public function getDtInicialAquisitivoFormatado()
    {
        return $this->dtInicialAquisitivoFormatado;
    }

    /**
     * Set dtFinalAquisitivoFormatado
     *
     * @param string $dtFinalAquisitivoFormatado
     * @return VwConcederFerias
     */
    public function setDtFinalAquisitivoFormatado($dtFinalAquisitivoFormatado = null)
    {
        $this->dtFinalAquisitivoFormatado = $dtFinalAquisitivoFormatado;
        return $this;
    }

    /**
     * Get dtFinalAquisitivoFormatado
     *
     * @return string
     */
    public function getDtFinalAquisitivoFormatado()
    {
        return $this->dtFinalAquisitivoFormatado;
    }

    /**
     * Set dtAdmissaoFormatado
     *
     * @param string $dtAdmissaoFormatado
     * @return VwConcederFerias
     */
    public function setDtAdmissaoFormatado($dtAdmissaoFormatado = null)
    {
        $this->dtAdmissaoFormatado = $dtAdmissaoFormatado;
        return $this;
    }

    /**
     * Get dtAdmissaoFormatado
     *
     * @return string
     */
    public function getDtAdmissaoFormatado()
    {
        return $this->dtAdmissaoFormatado;
    }

    /**
     * Set feriasTiradas
     *
     * @param integer $feriasTiradas
     * @return VwConcederFerias
     */
    public function setFeriasTiradas($feriasTiradas = null)
    {
        $this->feriasTiradas = $feriasTiradas;
        return $this;
    }

    /**
     * Get feriasTiradas
     *
     * @return integer
     */
    public function getFeriasTiradas()
    {
        return $this->feriasTiradas;
    }

    public function getLotacao()
    {
        return $this->descOrgao . "-" . $this->orgao;
    }

    public function getPeriodoAquisitivo()
    {
        if ($this->dtInicialAquisitivo) {
            return $this->dtInicialAquisitivo->format('d/m/Y')
                . " a " .
                $this->dtFinalAquisitivo->format('d/m/Y')
                ;
        }
        return '';
    }

    public function __toString()
    {
        return $this->numcgm.' - '.$this->getNomCgm();
    }
}
