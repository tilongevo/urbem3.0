<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * Cidadao
 */
class Cidadao
{
    /**
     * PK
     * @var integer
     */
    private $codCidadao;

    /**
     * @var integer
     */
    private $codUfCtps;

    /**
     * @var integer
     */
    private $codUfRg;

    /**
     * @var integer
     */
    private $codGrandezaMoradia;

    /**
     * @var integer
     */
    private $codUnidadeMoradia;

    /**
     * @var integer
     */
    private $codDeficiencia;

    /**
     * @var integer
     */
    private $codSexo;

    /**
     * @var integer
     */
    private $codRaca;

    /**
     * @var integer
     */
    private $codEstadoCivil;

    /**
     * @var integer
     */
    private $codTipoCertidao;

    /**
     * @var integer
     */
    private $codGrauParentesco;

    /**
     * @var integer
     */
    private $codMunicipioOrigem;

    /**
     * @var integer
     */
    private $codUfOrigem;

    /**
     * @var integer
     */
    private $codUfCertidao;

    /**
     * @var string
     */
    private $nomCidadao;

    /**
     * @var string
     */
    private $telefoneCelular;

    /**
     * @var \DateTime
     */
    private $dtNascimento;

    /**
     * @var string
     */
    private $paisOrigem;

    /**
     * @var \DateTime
     */
    private $dtEntradaPais;

    /**
     * @var string
     */
    private $numIdentificacaoSocial;

    /**
     * @var string
     */
    private $numTermoCertidao;

    /**
     * @var string
     */
    private $numLivroCertidao;

    /**
     * @var string
     */
    private $numFolhaCertidao;

    /**
     * @var \DateTime
     */
    private $dtEmissaoCertidao;

    /**
     * @var string
     */
    private $nomCartorioCertidao;

    /**
     * @var string
     */
    private $numCartaoSaude;

    /**
     * @var string
     */
    private $numRg;

    /**
     * @var string
     */
    private $complementoRg;

    /**
     * @var string
     */
    private $orgaoEmissorRg;

    /**
     * @var \DateTime
     */
    private $dtEmissaoRg;

    /**
     * @var string
     */
    private $numCtps;

    /**
     * @var string
     */
    private $serieCtps;

    /**
     * @var \DateTime
     */
    private $dtEmissaoCtps;

    /**
     * @var string
     */
    private $numCpf;

    /**
     * @var string
     */
    private $numTituloEleitor;

    /**
     * @var string
     */
    private $zonaTituloEleitor;

    /**
     * @var string
     */
    private $secaoTituloEleitor;

    /**
     * @var string
     */
    private $pisPasep;

    /**
     * @var string
     */
    private $cboR;

    /**
     * @var integer
     */
    private $vlSalario = 0;

    /**
     * @var integer
     */
    private $vlAposentadoria = 0;

    /**
     * @var integer
     */
    private $vlSeguroDesemprego = 0;

    /**
     * @var integer
     */
    private $vlPensaoAlimenticia = 0;

    /**
     * @var integer
     */
    private $vlOutrasRendas = 0;

    /**
     * @var integer
     */
    private $tempoMoradia = 0;

    /**
     * @var string
     */
    private $pessoaResponsavel;

    /**
     * @var integer
     */
    private $mesGestacao = 0;

    /**
     * @var boolean
     */
    private $amamentando = false;

    /**
     * @var integer
     */
    private $qtdFilhos = 0;

    /**
     * @var string
     */
    private $nomPai;

    /**
     * @var string
     */
    private $nomMae;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\CidadaoDomicilio
     */
    private $fkCseCidadaoDomicilios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\CidadaoPrograma
     */
    private $fkCseCidadaoProgramas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\QualificacaoEscolar
     */
    private $fkCseQualificacaoEscolares;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\RespostaCenso
     */
    private $fkCseRespostaCensos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\RespostaQuestao
     */
    private $fkCseRespostaQuestoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Prescricao
     */
    private $fkCsePrescricoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\QualificacaoProfissional
     */
    private $fkCseQualificacaoProfissionais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwUf
     */
    private $fkSwUf;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Deficiencia
     */
    private $fkCseDeficiencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Sexo
     */
    private $fkCseSexo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Raca
     */
    private $fkCseRaca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\EstadoCivil
     */
    private $fkCseEstadoCivil;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\TipoCertidao
     */
    private $fkCseTipoCertidao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\GrauParentesco
     */
    private $fkCseGrauParentesco;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwMunicipio
     */
    private $fkSwMunicipio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCseCidadaoDomicilios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkCseCidadaoProgramas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkCseQualificacaoEscolares = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkCseRespostaCensos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkCseRespostaQuestoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkCsePrescricoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkCseQualificacaoProfissionais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCidadao
     *
     * @param integer $codCidadao
     * @return Cidadao
     */
    public function setCodCidadao($codCidadao)
    {
        $this->codCidadao = $codCidadao;
        return $this;
    }

    /**
     * Get codCidadao
     *
     * @return integer
     */
    public function getCodCidadao()
    {
        return $this->codCidadao;
    }

    /**
     * Set codUfCtps
     *
     * @param integer $codUfCtps
     * @return Cidadao
     */
    public function setCodUfCtps($codUfCtps)
    {
        $this->codUfCtps = $codUfCtps;
        return $this;
    }

    /**
     * Get codUfCtps
     *
     * @return integer
     */
    public function getCodUfCtps()
    {
        return $this->codUfCtps;
    }

    /**
     * Set codUfRg
     *
     * @param integer $codUfRg
     * @return Cidadao
     */
    public function setCodUfRg($codUfRg)
    {
        $this->codUfRg = $codUfRg;
        return $this;
    }

    /**
     * Get codUfRg
     *
     * @return integer
     */
    public function getCodUfRg()
    {
        return $this->codUfRg;
    }

    /**
     * Set codGrandezaMoradia
     *
     * @param integer $codGrandezaMoradia
     * @return Cidadao
     */
    public function setCodGrandezaMoradia($codGrandezaMoradia)
    {
        $this->codGrandezaMoradia = $codGrandezaMoradia;
        return $this;
    }

    /**
     * Get codGrandezaMoradia
     *
     * @return integer
     */
    public function getCodGrandezaMoradia()
    {
        return $this->codGrandezaMoradia;
    }

    /**
     * Set codUnidadeMoradia
     *
     * @param integer $codUnidadeMoradia
     * @return Cidadao
     */
    public function setCodUnidadeMoradia($codUnidadeMoradia)
    {
        $this->codUnidadeMoradia = $codUnidadeMoradia;
        return $this;
    }

    /**
     * Get codUnidadeMoradia
     *
     * @return integer
     */
    public function getCodUnidadeMoradia()
    {
        return $this->codUnidadeMoradia;
    }

    /**
     * Set codDeficiencia
     *
     * @param integer $codDeficiencia
     * @return Cidadao
     */
    public function setCodDeficiencia($codDeficiencia)
    {
        $this->codDeficiencia = $codDeficiencia;
        return $this;
    }

    /**
     * Get codDeficiencia
     *
     * @return integer
     */
    public function getCodDeficiencia()
    {
        return $this->codDeficiencia;
    }

    /**
     * Set codSexo
     *
     * @param integer $codSexo
     * @return Cidadao
     */
    public function setCodSexo($codSexo)
    {
        $this->codSexo = $codSexo;
        return $this;
    }

    /**
     * Get codSexo
     *
     * @return integer
     */
    public function getCodSexo()
    {
        return $this->codSexo;
    }

    /**
     * Set codRaca
     *
     * @param integer $codRaca
     * @return Cidadao
     */
    public function setCodRaca($codRaca)
    {
        $this->codRaca = $codRaca;
        return $this;
    }

    /**
     * Get codRaca
     *
     * @return integer
     */
    public function getCodRaca()
    {
        return $this->codRaca;
    }

    /**
     * Set codEstadoCivil
     *
     * @param integer $codEstadoCivil
     * @return Cidadao
     */
    public function setCodEstadoCivil($codEstadoCivil)
    {
        $this->codEstadoCivil = $codEstadoCivil;
        return $this;
    }

    /**
     * Get codEstadoCivil
     *
     * @return integer
     */
    public function getCodEstadoCivil()
    {
        return $this->codEstadoCivil;
    }

    /**
     * Set codTipoCertidao
     *
     * @param integer $codTipoCertidao
     * @return Cidadao
     */
    public function setCodTipoCertidao($codTipoCertidao)
    {
        $this->codTipoCertidao = $codTipoCertidao;
        return $this;
    }

    /**
     * Get codTipoCertidao
     *
     * @return integer
     */
    public function getCodTipoCertidao()
    {
        return $this->codTipoCertidao;
    }

    /**
     * Set codGrauParentesco
     *
     * @param integer $codGrauParentesco
     * @return Cidadao
     */
    public function setCodGrauParentesco($codGrauParentesco)
    {
        $this->codGrauParentesco = $codGrauParentesco;
        return $this;
    }

    /**
     * Get codGrauParentesco
     *
     * @return integer
     */
    public function getCodGrauParentesco()
    {
        return $this->codGrauParentesco;
    }

    /**
     * Set codMunicipioOrigem
     *
     * @param integer $codMunicipioOrigem
     * @return Cidadao
     */
    public function setCodMunicipioOrigem($codMunicipioOrigem)
    {
        $this->codMunicipioOrigem = $codMunicipioOrigem;
        return $this;
    }

    /**
     * Get codMunicipioOrigem
     *
     * @return integer
     */
    public function getCodMunicipioOrigem()
    {
        return $this->codMunicipioOrigem;
    }

    /**
     * Set codUfOrigem
     *
     * @param integer $codUfOrigem
     * @return Cidadao
     */
    public function setCodUfOrigem($codUfOrigem)
    {
        $this->codUfOrigem = $codUfOrigem;
        return $this;
    }

    /**
     * Get codUfOrigem
     *
     * @return integer
     */
    public function getCodUfOrigem()
    {
        return $this->codUfOrigem;
    }

    /**
     * Set codUfCertidao
     *
     * @param integer $codUfCertidao
     * @return Cidadao
     */
    public function setCodUfCertidao($codUfCertidao)
    {
        $this->codUfCertidao = $codUfCertidao;
        return $this;
    }

    /**
     * Get codUfCertidao
     *
     * @return integer
     */
    public function getCodUfCertidao()
    {
        return $this->codUfCertidao;
    }

    /**
     * Set nomCidadao
     *
     * @param string $nomCidadao
     * @return Cidadao
     */
    public function setNomCidadao($nomCidadao)
    {
        $this->nomCidadao = $nomCidadao;
        return $this;
    }

    /**
     * Get nomCidadao
     *
     * @return string
     */
    public function getNomCidadao()
    {
        return $this->nomCidadao;
    }

    /**
     * Set telefoneCelular
     *
     * @param string $telefoneCelular
     * @return Cidadao
     */
    public function setTelefoneCelular($telefoneCelular)
    {
        $this->telefoneCelular = $telefoneCelular;
        return $this;
    }

    /**
     * Get telefoneCelular
     *
     * @return string
     */
    public function getTelefoneCelular()
    {
        return $this->telefoneCelular;
    }

    /**
     * Set dtNascimento
     *
     * @param \DateTime $dtNascimento
     * @return Cidadao
     */
    public function setDtNascimento(\DateTime $dtNascimento)
    {
        $this->dtNascimento = $dtNascimento;
        return $this;
    }

    /**
     * Get dtNascimento
     *
     * @return \DateTime
     */
    public function getDtNascimento()
    {
        return $this->dtNascimento;
    }

    /**
     * Set paisOrigem
     *
     * @param string $paisOrigem
     * @return Cidadao
     */
    public function setPaisOrigem($paisOrigem)
    {
        $this->paisOrigem = $paisOrigem;
        return $this;
    }

    /**
     * Get paisOrigem
     *
     * @return string
     */
    public function getPaisOrigem()
    {
        return $this->paisOrigem;
    }

    /**
     * Set dtEntradaPais
     *
     * @param \DateTime $dtEntradaPais
     * @return Cidadao
     */
    public function setDtEntradaPais(\DateTime $dtEntradaPais = null)
    {
        $this->dtEntradaPais = $dtEntradaPais;
        return $this;
    }

    /**
     * Get dtEntradaPais
     *
     * @return \DateTime
     */
    public function getDtEntradaPais()
    {
        return $this->dtEntradaPais;
    }

    /**
     * Set numIdentificacaoSocial
     *
     * @param string $numIdentificacaoSocial
     * @return Cidadao
     */
    public function setNumIdentificacaoSocial($numIdentificacaoSocial)
    {
        $this->numIdentificacaoSocial = $numIdentificacaoSocial;
        return $this;
    }

    /**
     * Get numIdentificacaoSocial
     *
     * @return string
     */
    public function getNumIdentificacaoSocial()
    {
        return $this->numIdentificacaoSocial;
    }

    /**
     * Set numTermoCertidao
     *
     * @param string $numTermoCertidao
     * @return Cidadao
     */
    public function setNumTermoCertidao($numTermoCertidao)
    {
        $this->numTermoCertidao = $numTermoCertidao;
        return $this;
    }

    /**
     * Get numTermoCertidao
     *
     * @return string
     */
    public function getNumTermoCertidao()
    {
        return $this->numTermoCertidao;
    }

    /**
     * Set numLivroCertidao
     *
     * @param string $numLivroCertidao
     * @return Cidadao
     */
    public function setNumLivroCertidao($numLivroCertidao)
    {
        $this->numLivroCertidao = $numLivroCertidao;
        return $this;
    }

    /**
     * Get numLivroCertidao
     *
     * @return string
     */
    public function getNumLivroCertidao()
    {
        return $this->numLivroCertidao;
    }

    /**
     * Set numFolhaCertidao
     *
     * @param string $numFolhaCertidao
     * @return Cidadao
     */
    public function setNumFolhaCertidao($numFolhaCertidao)
    {
        $this->numFolhaCertidao = $numFolhaCertidao;
        return $this;
    }

    /**
     * Get numFolhaCertidao
     *
     * @return string
     */
    public function getNumFolhaCertidao()
    {
        return $this->numFolhaCertidao;
    }

    /**
     * Set dtEmissaoCertidao
     *
     * @param \DateTime $dtEmissaoCertidao
     * @return Cidadao
     */
    public function setDtEmissaoCertidao(\DateTime $dtEmissaoCertidao = null)
    {
        $this->dtEmissaoCertidao = $dtEmissaoCertidao;
        return $this;
    }

    /**
     * Get dtEmissaoCertidao
     *
     * @return \DateTime
     */
    public function getDtEmissaoCertidao()
    {
        return $this->dtEmissaoCertidao;
    }

    /**
     * Set nomCartorioCertidao
     *
     * @param string $nomCartorioCertidao
     * @return Cidadao
     */
    public function setNomCartorioCertidao($nomCartorioCertidao)
    {
        $this->nomCartorioCertidao = $nomCartorioCertidao;
        return $this;
    }

    /**
     * Get nomCartorioCertidao
     *
     * @return string
     */
    public function getNomCartorioCertidao()
    {
        return $this->nomCartorioCertidao;
    }

    /**
     * Set numCartaoSaude
     *
     * @param string $numCartaoSaude
     * @return Cidadao
     */
    public function setNumCartaoSaude($numCartaoSaude)
    {
        $this->numCartaoSaude = $numCartaoSaude;
        return $this;
    }

    /**
     * Get numCartaoSaude
     *
     * @return string
     */
    public function getNumCartaoSaude()
    {
        return $this->numCartaoSaude;
    }

    /**
     * Set numRg
     *
     * @param string $numRg
     * @return Cidadao
     */
    public function setNumRg($numRg)
    {
        $this->numRg = $numRg;
        return $this;
    }

    /**
     * Get numRg
     *
     * @return string
     */
    public function getNumRg()
    {
        return $this->numRg;
    }

    /**
     * Set complementoRg
     *
     * @param string $complementoRg
     * @return Cidadao
     */
    public function setComplementoRg($complementoRg)
    {
        $this->complementoRg = $complementoRg;
        return $this;
    }

    /**
     * Get complementoRg
     *
     * @return string
     */
    public function getComplementoRg()
    {
        return $this->complementoRg;
    }

    /**
     * Set orgaoEmissorRg
     *
     * @param string $orgaoEmissorRg
     * @return Cidadao
     */
    public function setOrgaoEmissorRg($orgaoEmissorRg)
    {
        $this->orgaoEmissorRg = $orgaoEmissorRg;
        return $this;
    }

    /**
     * Get orgaoEmissorRg
     *
     * @return string
     */
    public function getOrgaoEmissorRg()
    {
        return $this->orgaoEmissorRg;
    }

    /**
     * Set dtEmissaoRg
     *
     * @param \DateTime $dtEmissaoRg
     * @return Cidadao
     */
    public function setDtEmissaoRg(\DateTime $dtEmissaoRg = null)
    {
        $this->dtEmissaoRg = $dtEmissaoRg;
        return $this;
    }

    /**
     * Get dtEmissaoRg
     *
     * @return \DateTime
     */
    public function getDtEmissaoRg()
    {
        return $this->dtEmissaoRg;
    }

    /**
     * Set numCtps
     *
     * @param string $numCtps
     * @return Cidadao
     */
    public function setNumCtps($numCtps)
    {
        $this->numCtps = $numCtps;
        return $this;
    }

    /**
     * Get numCtps
     *
     * @return string
     */
    public function getNumCtps()
    {
        return $this->numCtps;
    }

    /**
     * Set serieCtps
     *
     * @param string $serieCtps
     * @return Cidadao
     */
    public function setSerieCtps($serieCtps)
    {
        $this->serieCtps = $serieCtps;
        return $this;
    }

    /**
     * Get serieCtps
     *
     * @return string
     */
    public function getSerieCtps()
    {
        return $this->serieCtps;
    }

    /**
     * Set dtEmissaoCtps
     *
     * @param \DateTime $dtEmissaoCtps
     * @return Cidadao
     */
    public function setDtEmissaoCtps(\DateTime $dtEmissaoCtps = null)
    {
        $this->dtEmissaoCtps = $dtEmissaoCtps;
        return $this;
    }

    /**
     * Get dtEmissaoCtps
     *
     * @return \DateTime
     */
    public function getDtEmissaoCtps()
    {
        return $this->dtEmissaoCtps;
    }

    /**
     * Set numCpf
     *
     * @param string $numCpf
     * @return Cidadao
     */
    public function setNumCpf($numCpf)
    {
        $this->numCpf = $numCpf;
        return $this;
    }

    /**
     * Get numCpf
     *
     * @return string
     */
    public function getNumCpf()
    {
        return $this->numCpf;
    }

    /**
     * Set numTituloEleitor
     *
     * @param string $numTituloEleitor
     * @return Cidadao
     */
    public function setNumTituloEleitor($numTituloEleitor)
    {
        $this->numTituloEleitor = $numTituloEleitor;
        return $this;
    }

    /**
     * Get numTituloEleitor
     *
     * @return string
     */
    public function getNumTituloEleitor()
    {
        return $this->numTituloEleitor;
    }

    /**
     * Set zonaTituloEleitor
     *
     * @param string $zonaTituloEleitor
     * @return Cidadao
     */
    public function setZonaTituloEleitor($zonaTituloEleitor)
    {
        $this->zonaTituloEleitor = $zonaTituloEleitor;
        return $this;
    }

    /**
     * Get zonaTituloEleitor
     *
     * @return string
     */
    public function getZonaTituloEleitor()
    {
        return $this->zonaTituloEleitor;
    }

    /**
     * Set secaoTituloEleitor
     *
     * @param string $secaoTituloEleitor
     * @return Cidadao
     */
    public function setSecaoTituloEleitor($secaoTituloEleitor)
    {
        $this->secaoTituloEleitor = $secaoTituloEleitor;
        return $this;
    }

    /**
     * Get secaoTituloEleitor
     *
     * @return string
     */
    public function getSecaoTituloEleitor()
    {
        return $this->secaoTituloEleitor;
    }

    /**
     * Set pisPasep
     *
     * @param string $pisPasep
     * @return Cidadao
     */
    public function setPisPasep($pisPasep)
    {
        $this->pisPasep = $pisPasep;
        return $this;
    }

    /**
     * Get pisPasep
     *
     * @return string
     */
    public function getPisPasep()
    {
        return $this->pisPasep;
    }

    /**
     * Set cboR
     *
     * @param string $cboR
     * @return Cidadao
     */
    public function setCboR($cboR)
    {
        $this->cboR = $cboR;
        return $this;
    }

    /**
     * Get cboR
     *
     * @return string
     */
    public function getCboR()
    {
        return $this->cboR;
    }

    /**
     * Set vlSalario
     *
     * @param integer $vlSalario
     * @return Cidadao
     */
    public function setVlSalario($vlSalario)
    {
        $this->vlSalario = $vlSalario;
        return $this;
    }

    /**
     * Get vlSalario
     *
     * @return integer
     */
    public function getVlSalario()
    {
        return $this->vlSalario;
    }

    /**
     * Set vlAposentadoria
     *
     * @param integer $vlAposentadoria
     * @return Cidadao
     */
    public function setVlAposentadoria($vlAposentadoria)
    {
        $this->vlAposentadoria = $vlAposentadoria;
        return $this;
    }

    /**
     * Get vlAposentadoria
     *
     * @return integer
     */
    public function getVlAposentadoria()
    {
        return $this->vlAposentadoria;
    }

    /**
     * Set vlSeguroDesemprego
     *
     * @param integer $vlSeguroDesemprego
     * @return Cidadao
     */
    public function setVlSeguroDesemprego($vlSeguroDesemprego)
    {
        $this->vlSeguroDesemprego = $vlSeguroDesemprego;
        return $this;
    }

    /**
     * Get vlSeguroDesemprego
     *
     * @return integer
     */
    public function getVlSeguroDesemprego()
    {
        return $this->vlSeguroDesemprego;
    }

    /**
     * Set vlPensaoAlimenticia
     *
     * @param integer $vlPensaoAlimenticia
     * @return Cidadao
     */
    public function setVlPensaoAlimenticia($vlPensaoAlimenticia)
    {
        $this->vlPensaoAlimenticia = $vlPensaoAlimenticia;
        return $this;
    }

    /**
     * Get vlPensaoAlimenticia
     *
     * @return integer
     */
    public function getVlPensaoAlimenticia()
    {
        return $this->vlPensaoAlimenticia;
    }

    /**
     * Set vlOutrasRendas
     *
     * @param integer $vlOutrasRendas
     * @return Cidadao
     */
    public function setVlOutrasRendas($vlOutrasRendas)
    {
        $this->vlOutrasRendas = $vlOutrasRendas;
        return $this;
    }

    /**
     * Get vlOutrasRendas
     *
     * @return integer
     */
    public function getVlOutrasRendas()
    {
        return $this->vlOutrasRendas;
    }

    /**
     * Set tempoMoradia
     *
     * @param integer $tempoMoradia
     * @return Cidadao
     */
    public function setTempoMoradia($tempoMoradia)
    {
        $this->tempoMoradia = $tempoMoradia;
        return $this;
    }

    /**
     * Get tempoMoradia
     *
     * @return integer
     */
    public function getTempoMoradia()
    {
        return $this->tempoMoradia;
    }

    /**
     * Set pessoaResponsavel
     *
     * @param string $pessoaResponsavel
     * @return Cidadao
     */
    public function setPessoaResponsavel($pessoaResponsavel)
    {
        $this->pessoaResponsavel = $pessoaResponsavel;
        return $this;
    }

    /**
     * Get pessoaResponsavel
     *
     * @return string
     */
    public function getPessoaResponsavel()
    {
        return $this->pessoaResponsavel;
    }

    /**
     * Set mesGestacao
     *
     * @param integer $mesGestacao
     * @return Cidadao
     */
    public function setMesGestacao($mesGestacao)
    {
        $this->mesGestacao = $mesGestacao;
        return $this;
    }

    /**
     * Get mesGestacao
     *
     * @return integer
     */
    public function getMesGestacao()
    {
        return $this->mesGestacao;
    }

    /**
     * Set amamentando
     *
     * @param boolean $amamentando
     * @return Cidadao
     */
    public function setAmamentando($amamentando)
    {
        $this->amamentando = $amamentando;
        return $this;
    }

    /**
     * Get amamentando
     *
     * @return boolean
     */
    public function getAmamentando()
    {
        return $this->amamentando;
    }

    /**
     * Set qtdFilhos
     *
     * @param integer $qtdFilhos
     * @return Cidadao
     */
    public function setQtdFilhos($qtdFilhos)
    {
        $this->qtdFilhos = $qtdFilhos;
        return $this;
    }

    /**
     * Get qtdFilhos
     *
     * @return integer
     */
    public function getQtdFilhos()
    {
        return $this->qtdFilhos;
    }

    /**
     * Set nomPai
     *
     * @param string $nomPai
     * @return Cidadao
     */
    public function setNomPai($nomPai)
    {
        $this->nomPai = $nomPai;
        return $this;
    }

    /**
     * Get nomPai
     *
     * @return string
     */
    public function getNomPai()
    {
        return $this->nomPai;
    }

    /**
     * Set nomMae
     *
     * @param string $nomMae
     * @return Cidadao
     */
    public function setNomMae($nomMae)
    {
        $this->nomMae = $nomMae;
        return $this;
    }

    /**
     * Get nomMae
     *
     * @return string
     */
    public function getNomMae()
    {
        return $this->nomMae;
    }

    /**
     * OneToMany (owning side)
     * Add CseCidadaoDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\CidadaoDomicilio $fkCseCidadaoDomicilio
     * @return Cidadao
     */
    public function addFkCseCidadaoDomicilios(\Urbem\CoreBundle\Entity\Cse\CidadaoDomicilio $fkCseCidadaoDomicilio)
    {
        if (false === $this->fkCseCidadaoDomicilios->contains($fkCseCidadaoDomicilio)) {
            $fkCseCidadaoDomicilio->setFkCseCidadao($this);
            $this->fkCseCidadaoDomicilios->add($fkCseCidadaoDomicilio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseCidadaoDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\CidadaoDomicilio $fkCseCidadaoDomicilio
     */
    public function removeFkCseCidadaoDomicilios(\Urbem\CoreBundle\Entity\Cse\CidadaoDomicilio $fkCseCidadaoDomicilio)
    {
        $this->fkCseCidadaoDomicilios->removeElement($fkCseCidadaoDomicilio);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseCidadaoDomicilios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\CidadaoDomicilio
     */
    public function getFkCseCidadaoDomicilios()
    {
        return $this->fkCseCidadaoDomicilios;
    }

    /**
     * OneToMany (owning side)
     * Add CseCidadaoPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Cse\CidadaoPrograma $fkCseCidadaoPrograma
     * @return Cidadao
     */
    public function addFkCseCidadaoProgramas(\Urbem\CoreBundle\Entity\Cse\CidadaoPrograma $fkCseCidadaoPrograma)
    {
        if (false === $this->fkCseCidadaoProgramas->contains($fkCseCidadaoPrograma)) {
            $fkCseCidadaoPrograma->setFkCseCidadao($this);
            $this->fkCseCidadaoProgramas->add($fkCseCidadaoPrograma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseCidadaoPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Cse\CidadaoPrograma $fkCseCidadaoPrograma
     */
    public function removeFkCseCidadaoProgramas(\Urbem\CoreBundle\Entity\Cse\CidadaoPrograma $fkCseCidadaoPrograma)
    {
        $this->fkCseCidadaoProgramas->removeElement($fkCseCidadaoPrograma);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseCidadaoProgramas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\CidadaoPrograma
     */
    public function getFkCseCidadaoProgramas()
    {
        return $this->fkCseCidadaoProgramas;
    }

    /**
     * OneToMany (owning side)
     * Add CseQualificacaoEscolar
     *
     * @param \Urbem\CoreBundle\Entity\Cse\QualificacaoEscolar $fkCseQualificacaoEscolar
     * @return Cidadao
     */
    public function addFkCseQualificacaoEscolares(\Urbem\CoreBundle\Entity\Cse\QualificacaoEscolar $fkCseQualificacaoEscolar)
    {
        if (false === $this->fkCseQualificacaoEscolares->contains($fkCseQualificacaoEscolar)) {
            $fkCseQualificacaoEscolar->setFkCseCidadao($this);
            $this->fkCseQualificacaoEscolares->add($fkCseQualificacaoEscolar);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseQualificacaoEscolar
     *
     * @param \Urbem\CoreBundle\Entity\Cse\QualificacaoEscolar $fkCseQualificacaoEscolar
     */
    public function removeFkCseQualificacaoEscolares(\Urbem\CoreBundle\Entity\Cse\QualificacaoEscolar $fkCseQualificacaoEscolar)
    {
        $this->fkCseQualificacaoEscolares->removeElement($fkCseQualificacaoEscolar);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseQualificacaoEscolares
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\QualificacaoEscolar
     */
    public function getFkCseQualificacaoEscolares()
    {
        return $this->fkCseQualificacaoEscolares;
    }

    /**
     * OneToMany (owning side)
     * Add CseRespostaCenso
     *
     * @param \Urbem\CoreBundle\Entity\Cse\RespostaCenso $fkCseRespostaCenso
     * @return Cidadao
     */
    public function addFkCseRespostaCensos(\Urbem\CoreBundle\Entity\Cse\RespostaCenso $fkCseRespostaCenso)
    {
        if (false === $this->fkCseRespostaCensos->contains($fkCseRespostaCenso)) {
            $fkCseRespostaCenso->setFkCseCidadao($this);
            $this->fkCseRespostaCensos->add($fkCseRespostaCenso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseRespostaCenso
     *
     * @param \Urbem\CoreBundle\Entity\Cse\RespostaCenso $fkCseRespostaCenso
     */
    public function removeFkCseRespostaCensos(\Urbem\CoreBundle\Entity\Cse\RespostaCenso $fkCseRespostaCenso)
    {
        $this->fkCseRespostaCensos->removeElement($fkCseRespostaCenso);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseRespostaCensos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\RespostaCenso
     */
    public function getFkCseRespostaCensos()
    {
        return $this->fkCseRespostaCensos;
    }

    /**
     * OneToMany (owning side)
     * Add CseRespostaQuestao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\RespostaQuestao $fkCseRespostaQuestao
     * @return Cidadao
     */
    public function addFkCseRespostaQuestoes(\Urbem\CoreBundle\Entity\Cse\RespostaQuestao $fkCseRespostaQuestao)
    {
        if (false === $this->fkCseRespostaQuestoes->contains($fkCseRespostaQuestao)) {
            $fkCseRespostaQuestao->setFkCseCidadao($this);
            $this->fkCseRespostaQuestoes->add($fkCseRespostaQuestao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseRespostaQuestao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\RespostaQuestao $fkCseRespostaQuestao
     */
    public function removeFkCseRespostaQuestoes(\Urbem\CoreBundle\Entity\Cse\RespostaQuestao $fkCseRespostaQuestao)
    {
        $this->fkCseRespostaQuestoes->removeElement($fkCseRespostaQuestao);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseRespostaQuestoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\RespostaQuestao
     */
    public function getFkCseRespostaQuestoes()
    {
        return $this->fkCseRespostaQuestoes;
    }

    /**
     * OneToMany (owning side)
     * Add CsePrescricao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Prescricao $fkCsePrescricao
     * @return Cidadao
     */
    public function addFkCsePrescricoes(\Urbem\CoreBundle\Entity\Cse\Prescricao $fkCsePrescricao)
    {
        if (false === $this->fkCsePrescricoes->contains($fkCsePrescricao)) {
            $fkCsePrescricao->setFkCseCidadao($this);
            $this->fkCsePrescricoes->add($fkCsePrescricao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CsePrescricao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Prescricao $fkCsePrescricao
     */
    public function removeFkCsePrescricoes(\Urbem\CoreBundle\Entity\Cse\Prescricao $fkCsePrescricao)
    {
        $this->fkCsePrescricoes->removeElement($fkCsePrescricao);
    }

    /**
     * OneToMany (owning side)
     * Get fkCsePrescricoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Prescricao
     */
    public function getFkCsePrescricoes()
    {
        return $this->fkCsePrescricoes;
    }

    /**
     * OneToMany (owning side)
     * Add CseQualificacaoProfissional
     *
     * @param \Urbem\CoreBundle\Entity\Cse\QualificacaoProfissional $fkCseQualificacaoProfissional
     * @return Cidadao
     */
    public function addFkCseQualificacaoProfissionais(\Urbem\CoreBundle\Entity\Cse\QualificacaoProfissional $fkCseQualificacaoProfissional)
    {
        if (false === $this->fkCseQualificacaoProfissionais->contains($fkCseQualificacaoProfissional)) {
            $fkCseQualificacaoProfissional->setFkCseCidadao($this);
            $this->fkCseQualificacaoProfissionais->add($fkCseQualificacaoProfissional);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseQualificacaoProfissional
     *
     * @param \Urbem\CoreBundle\Entity\Cse\QualificacaoProfissional $fkCseQualificacaoProfissional
     */
    public function removeFkCseQualificacaoProfissionais(\Urbem\CoreBundle\Entity\Cse\QualificacaoProfissional $fkCseQualificacaoProfissional)
    {
        $this->fkCseQualificacaoProfissionais->removeElement($fkCseQualificacaoProfissional);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseQualificacaoProfissionais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\QualificacaoProfissional
     */
    public function getFkCseQualificacaoProfissionais()
    {
        return $this->fkCseQualificacaoProfissionais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwUf
     *
     * @param \Urbem\CoreBundle\Entity\SwUf $fkSwUf
     * @return Cidadao
     */
    public function setFkSwUf(\Urbem\CoreBundle\Entity\SwUf $fkSwUf)
    {
        $this->codUfCtps = $fkSwUf->getCodUf();
        $this->fkSwUf = $fkSwUf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwUf
     *
     * @return \Urbem\CoreBundle\Entity\SwUf
     */
    public function getFkSwUf()
    {
        return $this->fkSwUf;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseDeficiencia
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Deficiencia $fkCseDeficiencia
     * @return Cidadao
     */
    public function setFkCseDeficiencia(\Urbem\CoreBundle\Entity\Cse\Deficiencia $fkCseDeficiencia)
    {
        $this->codDeficiencia = $fkCseDeficiencia->getCodDeficiencia();
        $this->fkCseDeficiencia = $fkCseDeficiencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseDeficiencia
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Deficiencia
     */
    public function getFkCseDeficiencia()
    {
        return $this->fkCseDeficiencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseSexo
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Sexo $fkCseSexo
     * @return Cidadao
     */
    public function setFkCseSexo(\Urbem\CoreBundle\Entity\Cse\Sexo $fkCseSexo)
    {
        $this->codSexo = $fkCseSexo->getCodSexo();
        $this->fkCseSexo = $fkCseSexo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseSexo
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Sexo
     */
    public function getFkCseSexo()
    {
        return $this->fkCseSexo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseRaca
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Raca $fkCseRaca
     * @return Cidadao
     */
    public function setFkCseRaca(\Urbem\CoreBundle\Entity\Cse\Raca $fkCseRaca)
    {
        $this->codRaca = $fkCseRaca->getCodRaca();
        $this->fkCseRaca = $fkCseRaca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseRaca
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Raca
     */
    public function getFkCseRaca()
    {
        return $this->fkCseRaca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseEstadoCivil
     *
     * @param \Urbem\CoreBundle\Entity\Cse\EstadoCivil $fkCseEstadoCivil
     * @return Cidadao
     */
    public function setFkCseEstadoCivil(\Urbem\CoreBundle\Entity\Cse\EstadoCivil $fkCseEstadoCivil)
    {
        $this->codEstadoCivil = $fkCseEstadoCivil->getCodEstado();
        $this->fkCseEstadoCivil = $fkCseEstadoCivil;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseEstadoCivil
     *
     * @return \Urbem\CoreBundle\Entity\Cse\EstadoCivil
     */
    public function getFkCseEstadoCivil()
    {
        return $this->fkCseEstadoCivil;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseTipoCertidao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\TipoCertidao $fkCseTipoCertidao
     * @return Cidadao
     */
    public function setFkCseTipoCertidao(\Urbem\CoreBundle\Entity\Cse\TipoCertidao $fkCseTipoCertidao)
    {
        $this->codTipoCertidao = $fkCseTipoCertidao->getCodCertidao();
        $this->fkCseTipoCertidao = $fkCseTipoCertidao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseTipoCertidao
     *
     * @return \Urbem\CoreBundle\Entity\Cse\TipoCertidao
     */
    public function getFkCseTipoCertidao()
    {
        return $this->fkCseTipoCertidao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseGrauParentesco
     *
     * @param \Urbem\CoreBundle\Entity\Cse\GrauParentesco $fkCseGrauParentesco
     * @return Cidadao
     */
    public function setFkCseGrauParentesco(\Urbem\CoreBundle\Entity\Cse\GrauParentesco $fkCseGrauParentesco)
    {
        $this->codGrauParentesco = $fkCseGrauParentesco->getCodGrau();
        $this->fkCseGrauParentesco = $fkCseGrauParentesco;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseGrauParentesco
     *
     * @return \Urbem\CoreBundle\Entity\Cse\GrauParentesco
     */
    public function getFkCseGrauParentesco()
    {
        return $this->fkCseGrauParentesco;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwMunicipio
     *
     * @param \Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio
     * @return Cidadao
     */
    public function setFkSwMunicipio(\Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio)
    {
        $this->codMunicipioOrigem = $fkSwMunicipio->getCodMunicipio();
        $this->codUfOrigem = $fkSwMunicipio->getCodUf();
        $this->fkSwMunicipio = $fkSwMunicipio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwMunicipio
     *
     * @return \Urbem\CoreBundle\Entity\SwMunicipio
     */
    public function getFkSwMunicipio()
    {
        return $this->fkSwMunicipio;
    }
}
