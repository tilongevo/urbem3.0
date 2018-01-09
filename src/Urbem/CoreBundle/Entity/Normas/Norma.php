<?php
 
namespace Urbem\CoreBundle\Entity\Normas;

/**
 * Norma
 */
class Norma
{
    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $codTipoNorma;

    /**
     * @var \DateTime
     */
    private $dtPublicacao;

    /**
     * @var string
     */
    private $nomNorma;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $numNorma;

    /**
     * @var \DateTime
     */
    private $dtAssinatura;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Concurso\Edital
     */
    private $fkConcursoEdital;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Normas\NormaDataTermino
     */
    private $fkNormasNormaDataTermino;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Normas\NormaDetalheAl
     */
    private $fkNormasNormaDetalheAl;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\NormaDetalhe
     */
    private $fkTcemgNormaDetalhe;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tceto\NormaDetalhe
     */
    private $fkTcetoNormaDetalhe;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Normas\NormaCopiaDigital
     */
    private $fkNormasNormaCopiaDigital;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao
     */
    private $fkArrecadacaoDesoneracoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoProrrogacao
     */
    private $fkArrecadacaoFundamentacaoProrrogacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoRevogacao
     */
    private $fkArrecadacaoFundamentacaoRevogacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Vigencia
     */
    private $fkBeneficioVigencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\Homologacao
     */
    private $fkConcursoHomologacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\Edital
     */
    private $fkConcursoEditais1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Diarias\TipoDiaria
     */
    private $fkDiariasTipoDiarias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\Autoridade
     */
    private $fkDividaAutoridades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaRemissao
     */
    private $fkDividaDividaRemissoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia
     */
    private $fkDividaModalidadeVigencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\Infracao
     */
    private $fkFiscalizacaoInfracoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade
     */
    private $fkFiscalizacaoPenalidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao
     */
    private $fkFolhapagamentoPadraoPadroes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BairroAliquota
     */
    private $fkImobiliarioBairroAliquotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BairroValorM2
     */
    private $fkImobiliarioBairroValorM2s;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraAliquota
     */
    private $fkImobiliarioFaceQuadraAliquotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraValorM2
     */
    private $fkImobiliarioFaceQuadraValorM2s;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoAliquota
     */
    private $fkImobiliarioLocalizacaoAliquotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoValorM2
     */
    private $fkImobiliarioLocalizacaoValorM2s;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoValorM2
     */
    private $fkImobiliarioTipoEdificacaoValorM2s;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoAliquota
     */
    private $fkImobiliarioTipoEdificacaoAliquotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TrechoValorM2
     */
    private $fkImobiliarioTrechoValorM2s;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TrechoAliquota
     */
    private $fkImobiliarioTrechoAliquotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\Homologacao
     */
    private $fkLdoHomologacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Comissao
     */
    private $fkLicitacaoComissoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos
     */
    private $fkLicitacaoConvenioAditivos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    private $fkLicitacaoConvenios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros
     */
    private $fkLicitacaoComissaoMembros;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\AcrescimoNorma
     */
    private $fkMonetarioAcrescimoNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ContaReceita
     */
    private $fkOrcamentoContaReceitas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoNorma
     */
    private $fkMonetarioCreditoNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\NormaDetalheAl
     */
    private $fkNormasNormaDetalheAis1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\NormaTipoNorma
     */
    private $fkNormasNormaTipoNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Suplementacao
     */
    private $fkOrcamentoSuplementacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\Organograma
     */
    private $fkOrganogramaOrganogramas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AdidoCedido
     */
    private $fkPessoalAdidoCedidos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    private $fkPessoalAssentamentoAssentamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoNorma
     */
    private $fkPessoalAssentamentoGeradoNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausaNorma
     */
    private $fkPessoalContratoPensionistaCasoCausaNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausaNorma
     */
    private $fkPessoalContratoServidorCasoCausaNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao
     */
    private $fkPessoalEspecialidadeSubDivisoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\PpaPublicacao
     */
    private $fkPpaPpaPublicacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoNorma
     */
    private $fkPpaAcaoNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaNorma
     */
    private $fkPpaProgramaNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLoa
     */
    private $fkTcemgConfiguracaoLoas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoReglic
     */
    private $fkTcemgConfiguracaoReglics;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLeisPpa
     */
    private $fkTcemgConfiguracaoLeisPpas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLeisLdo
     */
    private $fkTcemgConfiguracaoLeisLdos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\NormaArtigo
     */
    private $fkTcemgNormaArtigos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\AgenteEletivo
     */
    private $fkTcepeAgenteEletivos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOperacaoCredito
     */
    private $fkTcepeDividaFundadaOperacaoCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeGestora
     */
    private $fkTcernUnidadeGestoras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria
     */
    private $fkTcernUnidadeOrcamentarias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\AlteracaoLeiPpa
     */
    private $fkTcetoAlteracaoLeiPpas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\NormaDetalhe
     */
    private $fkTcetoNormaDetalhes1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\LimiteAlteracaoCredito
     */
    private $fkTcmbaLimiteAlteracaoCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho
     */
    private $fkTcmbaSubvencaoEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho
     */
    private $fkTcmbaSubvencaoEmpenhos1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoArquivoDmr
     */
    private $fkTcmgoConfiguracaoArquivoDmres;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLeisLdo
     */
    private $fkTcmgoConfiguracaoLeisLdos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLeisPpa
     */
    private $fkTcmgoConfiguracaoLeisPpas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LoteNorma
     */
    private $fkContabilidadeLoteNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Diarias\Diaria
     */
    private $fkDiariasDiarias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\AtributoNormaValor
     */
    private $fkNormasAtributoNormaValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CargoSubDivisao
     */
    private $fkPessoalCargoSubDivisoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwNomeLogradouro
     */
    private $fkSwNomeLogradouros;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\TipoRegistroPreco
     */
    private $fkTcemgTipoRegistroPrecos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOutraOperacaoCredito
     */
    private $fkTcepeDividaFundadaOutraOperacaoCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLoa
     */
    private $fkTcmgoConfiguracaoLoas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\TipoNorma
     */
    private $fkNormasTipoNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoDesoneracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoFundamentacaoProrrogacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoFundamentacaoRevogacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkBeneficioVigencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkConcursoHomologacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkConcursoEditais1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDiariasTipoDiarias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaAutoridades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaDividaRemissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaModalidadeVigencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoInfracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoPenalidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoPadraoPadroes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioBairroAliquotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioBairroValorM2s = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioFaceQuadraAliquotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioFaceQuadraValorM2s = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLocalizacaoAliquotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLocalizacaoValorM2s = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioTipoEdificacaoValorM2s = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioTipoEdificacaoAliquotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioTrechoValorM2s = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioTrechoAliquotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLdoHomologacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoComissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoConvenioAditivos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoComissaoMembros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioAcrescimoNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoContaReceitas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioCreditoNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkNormasNormaDetalheAis1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkNormasNormaTipoNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoSuplementacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaOrganogramas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAdidoCedidos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAssentamentoAssentamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAssentamentoGeradoNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoPensionistaCasoCausaNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorCasoCausaNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalEspecialidadeSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaPpaPublicacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaAcaoNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaProgramaNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgConfiguracaoLoas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgConfiguracaoReglics = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgConfiguracaoLeisPpas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgConfiguracaoLeisLdos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgNormaArtigos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeAgenteEletivos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeDividaFundadaOperacaoCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernUnidadeGestoras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernUnidadeOrcamentarias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcetoAlteracaoLeiPpas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcetoNormaDetalhes1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaLimiteAlteracaoCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaSubvencaoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaSubvencaoEmpenhos1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoConfiguracaoArquivoDmres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoConfiguracaoLeisLdos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoConfiguracaoLeisPpas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeLoteNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDiariasDiarias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkNormasAtributoNormaValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalCargoSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwNomeLogradouros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgTipoRegistroPrecos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeDividaFundadaOutraOperacaoCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoConfiguracaoLoas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return Norma
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set codTipoNorma
     *
     * @param integer $codTipoNorma
     * @return Norma
     */
    public function setCodTipoNorma($codTipoNorma)
    {
        $this->codTipoNorma = $codTipoNorma;
        return $this;
    }

    /**
     * Get codTipoNorma
     *
     * @return integer
     */
    public function getCodTipoNorma()
    {
        return $this->codTipoNorma;
    }

    /**
     * Set dtPublicacao
     *
     * @param \DateTime $dtPublicacao
     * @return Norma
     */
    public function setDtPublicacao(\DateTime $dtPublicacao)
    {
        $this->dtPublicacao = $dtPublicacao;
        return $this;
    }

    /**
     * Get dtPublicacao
     *
     * @return \DateTime
     */
    public function getDtPublicacao()
    {
        return $this->dtPublicacao;
    }

    /**
     * Set nomNorma
     *
     * @param string $nomNorma
     * @return Norma
     */
    public function setNomNorma($nomNorma)
    {
        $this->nomNorma = $nomNorma;
        return $this;
    }

    /**
     * Get nomNorma
     *
     * @return string
     */
    public function getNomNorma()
    {
        return $this->nomNorma;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Norma
     */
    public function setDescricao($descricao = null)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Norma
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Norma
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
     * Set numNorma
     *
     * @param string $numNorma
     * @return Norma
     */
    public function setNumNorma($numNorma)
    {
        $this->numNorma = $numNorma;
        return $this;
    }

    /**
     * Get numNorma
     *
     * @return string
     */
    public function getNumNorma()
    {
        return $this->numNorma;
    }

    /**
     * Set dtAssinatura
     *
     * @param \DateTime $dtAssinatura
     * @return Norma
     */
    public function setDtAssinatura(\DateTime $dtAssinatura)
    {
        $this->dtAssinatura = $dtAssinatura;
        return $this;
    }

    /**
     * Get dtAssinatura
     *
     * @return \DateTime
     */
    public function getDtAssinatura()
    {
        return $this->dtAssinatura;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao
     * @return Norma
     */
    public function addFkArrecadacaoDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao)
    {
        if (false === $this->fkArrecadacaoDesoneracoes->contains($fkArrecadacaoDesoneracao)) {
            $fkArrecadacaoDesoneracao->setFkNormasNorma($this);
            $this->fkArrecadacaoDesoneracoes->add($fkArrecadacaoDesoneracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao
     */
    public function removeFkArrecadacaoDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao)
    {
        $this->fkArrecadacaoDesoneracoes->removeElement($fkArrecadacaoDesoneracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDesoneracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao
     */
    public function getFkArrecadacaoDesoneracoes()
    {
        return $this->fkArrecadacaoDesoneracoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoFundamentacaoProrrogacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoProrrogacao $fkArrecadacaoFundamentacaoProrrogacao
     * @return Norma
     */
    public function addFkArrecadacaoFundamentacaoProrrogacoes(\Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoProrrogacao $fkArrecadacaoFundamentacaoProrrogacao)
    {
        if (false === $this->fkArrecadacaoFundamentacaoProrrogacoes->contains($fkArrecadacaoFundamentacaoProrrogacao)) {
            $fkArrecadacaoFundamentacaoProrrogacao->setFkNormasNorma($this);
            $this->fkArrecadacaoFundamentacaoProrrogacoes->add($fkArrecadacaoFundamentacaoProrrogacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoFundamentacaoProrrogacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoProrrogacao $fkArrecadacaoFundamentacaoProrrogacao
     */
    public function removeFkArrecadacaoFundamentacaoProrrogacoes(\Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoProrrogacao $fkArrecadacaoFundamentacaoProrrogacao)
    {
        $this->fkArrecadacaoFundamentacaoProrrogacoes->removeElement($fkArrecadacaoFundamentacaoProrrogacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoFundamentacaoProrrogacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoProrrogacao
     */
    public function getFkArrecadacaoFundamentacaoProrrogacoes()
    {
        return $this->fkArrecadacaoFundamentacaoProrrogacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoFundamentacaoRevogacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoRevogacao $fkArrecadacaoFundamentacaoRevogacao
     * @return Norma
     */
    public function addFkArrecadacaoFundamentacaoRevogacoes(\Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoRevogacao $fkArrecadacaoFundamentacaoRevogacao)
    {
        if (false === $this->fkArrecadacaoFundamentacaoRevogacoes->contains($fkArrecadacaoFundamentacaoRevogacao)) {
            $fkArrecadacaoFundamentacaoRevogacao->setFkNormasNorma($this);
            $this->fkArrecadacaoFundamentacaoRevogacoes->add($fkArrecadacaoFundamentacaoRevogacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoFundamentacaoRevogacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoRevogacao $fkArrecadacaoFundamentacaoRevogacao
     */
    public function removeFkArrecadacaoFundamentacaoRevogacoes(\Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoRevogacao $fkArrecadacaoFundamentacaoRevogacao)
    {
        $this->fkArrecadacaoFundamentacaoRevogacoes->removeElement($fkArrecadacaoFundamentacaoRevogacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoFundamentacaoRevogacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoRevogacao
     */
    public function getFkArrecadacaoFundamentacaoRevogacoes()
    {
        return $this->fkArrecadacaoFundamentacaoRevogacoes;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Vigencia $fkBeneficioVigencia
     * @return Norma
     */
    public function addFkBeneficioVigencias(\Urbem\CoreBundle\Entity\Beneficio\Vigencia $fkBeneficioVigencia)
    {
        if (false === $this->fkBeneficioVigencias->contains($fkBeneficioVigencia)) {
            $fkBeneficioVigencia->setFkNormasNorma($this);
            $this->fkBeneficioVigencias->add($fkBeneficioVigencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Vigencia $fkBeneficioVigencia
     */
    public function removeFkBeneficioVigencias(\Urbem\CoreBundle\Entity\Beneficio\Vigencia $fkBeneficioVigencia)
    {
        $this->fkBeneficioVigencias->removeElement($fkBeneficioVigencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioVigencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Vigencia
     */
    public function getFkBeneficioVigencias()
    {
        return $this->fkBeneficioVigencias;
    }

    /**
     * OneToMany (owning side)
     * Add ConcursoHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\Homologacao $fkConcursoHomologacao
     * @return Norma
     */
    public function addFkConcursoHomologacoes(\Urbem\CoreBundle\Entity\Concurso\Homologacao $fkConcursoHomologacao)
    {
        if (false === $this->fkConcursoHomologacoes->contains($fkConcursoHomologacao)) {
            $fkConcursoHomologacao->setFkNormasNorma($this);
            $this->fkConcursoHomologacoes->add($fkConcursoHomologacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ConcursoHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\Homologacao $fkConcursoHomologacao
     */
    public function removeFkConcursoHomologacoes(\Urbem\CoreBundle\Entity\Concurso\Homologacao $fkConcursoHomologacao)
    {
        $this->fkConcursoHomologacoes->removeElement($fkConcursoHomologacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkConcursoHomologacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\Homologacao
     */
    public function getFkConcursoHomologacoes()
    {
        return $this->fkConcursoHomologacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ConcursoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\Edital $fkConcursoEdital
     * @return Norma
     */
    public function addFkConcursoEditais1(\Urbem\CoreBundle\Entity\Concurso\Edital $fkConcursoEdital)
    {
        if (false === $this->fkConcursoEditais1->contains($fkConcursoEdital)) {
            $fkConcursoEdital->setFkNormasNorma1($this);
            $this->fkConcursoEditais1->add($fkConcursoEdital);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ConcursoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\Edital $fkConcursoEdital
     */
    public function removeFkConcursoEditais1(\Urbem\CoreBundle\Entity\Concurso\Edital $fkConcursoEdital)
    {
        $this->fkConcursoEditais1->removeElement($fkConcursoEdital);
    }

    /**
     * OneToMany (owning side)
     * Get fkConcursoEditais1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\Edital
     */
    public function getFkConcursoEditais1()
    {
        return $this->fkConcursoEditais1;
    }

    /**
     * OneToMany (owning side)
     * Add DiariasTipoDiaria
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\TipoDiaria $fkDiariasTipoDiaria
     * @return Norma
     */
    public function addFkDiariasTipoDiarias(\Urbem\CoreBundle\Entity\Diarias\TipoDiaria $fkDiariasTipoDiaria)
    {
        if (false === $this->fkDiariasTipoDiarias->contains($fkDiariasTipoDiaria)) {
            $fkDiariasTipoDiaria->setFkNormasNorma($this);
            $this->fkDiariasTipoDiarias->add($fkDiariasTipoDiaria);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DiariasTipoDiaria
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\TipoDiaria $fkDiariasTipoDiaria
     */
    public function removeFkDiariasTipoDiarias(\Urbem\CoreBundle\Entity\Diarias\TipoDiaria $fkDiariasTipoDiaria)
    {
        $this->fkDiariasTipoDiarias->removeElement($fkDiariasTipoDiaria);
    }

    /**
     * OneToMany (owning side)
     * Get fkDiariasTipoDiarias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Diarias\TipoDiaria
     */
    public function getFkDiariasTipoDiarias()
    {
        return $this->fkDiariasTipoDiarias;
    }

    /**
     * OneToMany (owning side)
     * Add DividaAutoridade
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Autoridade $fkDividaAutoridade
     * @return Norma
     */
    public function addFkDividaAutoridades(\Urbem\CoreBundle\Entity\Divida\Autoridade $fkDividaAutoridade)
    {
        if (false === $this->fkDividaAutoridades->contains($fkDividaAutoridade)) {
            $fkDividaAutoridade->setFkNormasNorma($this);
            $this->fkDividaAutoridades->add($fkDividaAutoridade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaAutoridade
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Autoridade $fkDividaAutoridade
     */
    public function removeFkDividaAutoridades(\Urbem\CoreBundle\Entity\Divida\Autoridade $fkDividaAutoridade)
    {
        $this->fkDividaAutoridades->removeElement($fkDividaAutoridade);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaAutoridades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\Autoridade
     */
    public function getFkDividaAutoridades()
    {
        return $this->fkDividaAutoridades;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaRemissao
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaRemissao $fkDividaDividaRemissao
     * @return Norma
     */
    public function addFkDividaDividaRemissoes(\Urbem\CoreBundle\Entity\Divida\DividaRemissao $fkDividaDividaRemissao)
    {
        if (false === $this->fkDividaDividaRemissoes->contains($fkDividaDividaRemissao)) {
            $fkDividaDividaRemissao->setFkNormasNorma($this);
            $this->fkDividaDividaRemissoes->add($fkDividaDividaRemissao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaRemissao
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaRemissao $fkDividaDividaRemissao
     */
    public function removeFkDividaDividaRemissoes(\Urbem\CoreBundle\Entity\Divida\DividaRemissao $fkDividaDividaRemissao)
    {
        $this->fkDividaDividaRemissoes->removeElement($fkDividaDividaRemissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaRemissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaRemissao
     */
    public function getFkDividaDividaRemissoes()
    {
        return $this->fkDividaDividaRemissoes;
    }

    /**
     * OneToMany (owning side)
     * Add DividaModalidadeVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia
     * @return Norma
     */
    public function addFkDividaModalidadeVigencias(\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia)
    {
        if (false === $this->fkDividaModalidadeVigencias->contains($fkDividaModalidadeVigencia)) {
            $fkDividaModalidadeVigencia->setFkNormasNorma($this);
            $this->fkDividaModalidadeVigencias->add($fkDividaModalidadeVigencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaModalidadeVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia
     */
    public function removeFkDividaModalidadeVigencias(\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia)
    {
        $this->fkDividaModalidadeVigencias->removeElement($fkDividaModalidadeVigencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaModalidadeVigencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia
     */
    public function getFkDividaModalidadeVigencias()
    {
        return $this->fkDividaModalidadeVigencias;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Infracao $fkFiscalizacaoInfracao
     * @return Norma
     */
    public function addFkFiscalizacaoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\Infracao $fkFiscalizacaoInfracao)
    {
        if (false === $this->fkFiscalizacaoInfracoes->contains($fkFiscalizacaoInfracao)) {
            $fkFiscalizacaoInfracao->setFkNormasNorma($this);
            $this->fkFiscalizacaoInfracoes->add($fkFiscalizacaoInfracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Infracao $fkFiscalizacaoInfracao
     */
    public function removeFkFiscalizacaoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\Infracao $fkFiscalizacaoInfracao)
    {
        $this->fkFiscalizacaoInfracoes->removeElement($fkFiscalizacaoInfracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoInfracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\Infracao
     */
    public function getFkFiscalizacaoInfracoes()
    {
        return $this->fkFiscalizacaoInfracoes;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade
     * @return Norma
     */
    public function addFkFiscalizacaoPenalidades(\Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade)
    {
        if (false === $this->fkFiscalizacaoPenalidades->contains($fkFiscalizacaoPenalidade)) {
            $fkFiscalizacaoPenalidade->setFkNormasNorma($this);
            $this->fkFiscalizacaoPenalidades->add($fkFiscalizacaoPenalidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade
     */
    public function removeFkFiscalizacaoPenalidades(\Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade)
    {
        $this->fkFiscalizacaoPenalidades->removeElement($fkFiscalizacaoPenalidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoPenalidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade
     */
    public function getFkFiscalizacaoPenalidades()
    {
        return $this->fkFiscalizacaoPenalidades;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoPadraoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao $fkFolhapagamentoPadraoPadrao
     * @return Norma
     */
    public function addFkFolhapagamentoPadraoPadroes(\Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao $fkFolhapagamentoPadraoPadrao)
    {
        if (false === $this->fkFolhapagamentoPadraoPadroes->contains($fkFolhapagamentoPadraoPadrao)) {
            $fkFolhapagamentoPadraoPadrao->setFkNormasNorma($this);
            $this->fkFolhapagamentoPadraoPadroes->add($fkFolhapagamentoPadraoPadrao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoPadraoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao $fkFolhapagamentoPadraoPadrao
     */
    public function removeFkFolhapagamentoPadraoPadroes(\Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao $fkFolhapagamentoPadraoPadrao)
    {
        $this->fkFolhapagamentoPadraoPadroes->removeElement($fkFolhapagamentoPadraoPadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoPadraoPadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao
     */
    public function getFkFolhapagamentoPadraoPadroes()
    {
        return $this->fkFolhapagamentoPadraoPadroes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioBairroAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BairroAliquota $fkImobiliarioBairroAliquota
     * @return Norma
     */
    public function addFkImobiliarioBairroAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\BairroAliquota $fkImobiliarioBairroAliquota)
    {
        if (false === $this->fkImobiliarioBairroAliquotas->contains($fkImobiliarioBairroAliquota)) {
            $fkImobiliarioBairroAliquota->setFkNormasNorma($this);
            $this->fkImobiliarioBairroAliquotas->add($fkImobiliarioBairroAliquota);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioBairroAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BairroAliquota $fkImobiliarioBairroAliquota
     */
    public function removeFkImobiliarioBairroAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\BairroAliquota $fkImobiliarioBairroAliquota)
    {
        $this->fkImobiliarioBairroAliquotas->removeElement($fkImobiliarioBairroAliquota);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioBairroAliquotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BairroAliquota
     */
    public function getFkImobiliarioBairroAliquotas()
    {
        return $this->fkImobiliarioBairroAliquotas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioBairroValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BairroValorM2 $fkImobiliarioBairroValorM2
     * @return Norma
     */
    public function addFkImobiliarioBairroValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\BairroValorM2 $fkImobiliarioBairroValorM2)
    {
        if (false === $this->fkImobiliarioBairroValorM2s->contains($fkImobiliarioBairroValorM2)) {
            $fkImobiliarioBairroValorM2->setFkNormasNorma($this);
            $this->fkImobiliarioBairroValorM2s->add($fkImobiliarioBairroValorM2);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioBairroValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BairroValorM2 $fkImobiliarioBairroValorM2
     */
    public function removeFkImobiliarioBairroValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\BairroValorM2 $fkImobiliarioBairroValorM2)
    {
        $this->fkImobiliarioBairroValorM2s->removeElement($fkImobiliarioBairroValorM2);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioBairroValorM2s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BairroValorM2
     */
    public function getFkImobiliarioBairroValorM2s()
    {
        return $this->fkImobiliarioBairroValorM2s;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioFaceQuadraAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraAliquota $fkImobiliarioFaceQuadraAliquota
     * @return Norma
     */
    public function addFkImobiliarioFaceQuadraAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraAliquota $fkImobiliarioFaceQuadraAliquota)
    {
        if (false === $this->fkImobiliarioFaceQuadraAliquotas->contains($fkImobiliarioFaceQuadraAliquota)) {
            $fkImobiliarioFaceQuadraAliquota->setFkNormasNorma($this);
            $this->fkImobiliarioFaceQuadraAliquotas->add($fkImobiliarioFaceQuadraAliquota);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioFaceQuadraAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraAliquota $fkImobiliarioFaceQuadraAliquota
     */
    public function removeFkImobiliarioFaceQuadraAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraAliquota $fkImobiliarioFaceQuadraAliquota)
    {
        $this->fkImobiliarioFaceQuadraAliquotas->removeElement($fkImobiliarioFaceQuadraAliquota);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioFaceQuadraAliquotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraAliquota
     */
    public function getFkImobiliarioFaceQuadraAliquotas()
    {
        return $this->fkImobiliarioFaceQuadraAliquotas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioFaceQuadraValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraValorM2 $fkImobiliarioFaceQuadraValorM2
     * @return Norma
     */
    public function addFkImobiliarioFaceQuadraValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraValorM2 $fkImobiliarioFaceQuadraValorM2)
    {
        if (false === $this->fkImobiliarioFaceQuadraValorM2s->contains($fkImobiliarioFaceQuadraValorM2)) {
            $fkImobiliarioFaceQuadraValorM2->setFkNormasNorma($this);
            $this->fkImobiliarioFaceQuadraValorM2s->add($fkImobiliarioFaceQuadraValorM2);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioFaceQuadraValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraValorM2 $fkImobiliarioFaceQuadraValorM2
     */
    public function removeFkImobiliarioFaceQuadraValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraValorM2 $fkImobiliarioFaceQuadraValorM2)
    {
        $this->fkImobiliarioFaceQuadraValorM2s->removeElement($fkImobiliarioFaceQuadraValorM2);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioFaceQuadraValorM2s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraValorM2
     */
    public function getFkImobiliarioFaceQuadraValorM2s()
    {
        return $this->fkImobiliarioFaceQuadraValorM2s;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLocalizacaoAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoAliquota $fkImobiliarioLocalizacaoAliquota
     * @return Norma
     */
    public function addFkImobiliarioLocalizacaoAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoAliquota $fkImobiliarioLocalizacaoAliquota)
    {
        if (false === $this->fkImobiliarioLocalizacaoAliquotas->contains($fkImobiliarioLocalizacaoAliquota)) {
            $fkImobiliarioLocalizacaoAliquota->setFkNormasNorma($this);
            $this->fkImobiliarioLocalizacaoAliquotas->add($fkImobiliarioLocalizacaoAliquota);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLocalizacaoAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoAliquota $fkImobiliarioLocalizacaoAliquota
     */
    public function removeFkImobiliarioLocalizacaoAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoAliquota $fkImobiliarioLocalizacaoAliquota)
    {
        $this->fkImobiliarioLocalizacaoAliquotas->removeElement($fkImobiliarioLocalizacaoAliquota);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLocalizacaoAliquotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoAliquota
     */
    public function getFkImobiliarioLocalizacaoAliquotas()
    {
        return $this->fkImobiliarioLocalizacaoAliquotas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLocalizacaoValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoValorM2 $fkImobiliarioLocalizacaoValorM2
     * @return Norma
     */
    public function addFkImobiliarioLocalizacaoValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoValorM2 $fkImobiliarioLocalizacaoValorM2)
    {
        if (false === $this->fkImobiliarioLocalizacaoValorM2s->contains($fkImobiliarioLocalizacaoValorM2)) {
            $fkImobiliarioLocalizacaoValorM2->setFkNormasNorma($this);
            $this->fkImobiliarioLocalizacaoValorM2s->add($fkImobiliarioLocalizacaoValorM2);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLocalizacaoValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoValorM2 $fkImobiliarioLocalizacaoValorM2
     */
    public function removeFkImobiliarioLocalizacaoValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoValorM2 $fkImobiliarioLocalizacaoValorM2)
    {
        $this->fkImobiliarioLocalizacaoValorM2s->removeElement($fkImobiliarioLocalizacaoValorM2);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLocalizacaoValorM2s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoValorM2
     */
    public function getFkImobiliarioLocalizacaoValorM2s()
    {
        return $this->fkImobiliarioLocalizacaoValorM2s;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTipoEdificacaoValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoValorM2 $fkImobiliarioTipoEdificacaoValorM2
     * @return Norma
     */
    public function addFkImobiliarioTipoEdificacaoValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoValorM2 $fkImobiliarioTipoEdificacaoValorM2)
    {
        if (false === $this->fkImobiliarioTipoEdificacaoValorM2s->contains($fkImobiliarioTipoEdificacaoValorM2)) {
            $fkImobiliarioTipoEdificacaoValorM2->setFkNormasNorma($this);
            $this->fkImobiliarioTipoEdificacaoValorM2s->add($fkImobiliarioTipoEdificacaoValorM2);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTipoEdificacaoValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoValorM2 $fkImobiliarioTipoEdificacaoValorM2
     */
    public function removeFkImobiliarioTipoEdificacaoValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoValorM2 $fkImobiliarioTipoEdificacaoValorM2)
    {
        $this->fkImobiliarioTipoEdificacaoValorM2s->removeElement($fkImobiliarioTipoEdificacaoValorM2);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTipoEdificacaoValorM2s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoValorM2
     */
    public function getFkImobiliarioTipoEdificacaoValorM2s()
    {
        return $this->fkImobiliarioTipoEdificacaoValorM2s;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTipoEdificacaoAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoAliquota $fkImobiliarioTipoEdificacaoAliquota
     * @return Norma
     */
    public function addFkImobiliarioTipoEdificacaoAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoAliquota $fkImobiliarioTipoEdificacaoAliquota)
    {
        if (false === $this->fkImobiliarioTipoEdificacaoAliquotas->contains($fkImobiliarioTipoEdificacaoAliquota)) {
            $fkImobiliarioTipoEdificacaoAliquota->setFkNormasNorma($this);
            $this->fkImobiliarioTipoEdificacaoAliquotas->add($fkImobiliarioTipoEdificacaoAliquota);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTipoEdificacaoAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoAliquota $fkImobiliarioTipoEdificacaoAliquota
     */
    public function removeFkImobiliarioTipoEdificacaoAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoAliquota $fkImobiliarioTipoEdificacaoAliquota)
    {
        $this->fkImobiliarioTipoEdificacaoAliquotas->removeElement($fkImobiliarioTipoEdificacaoAliquota);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTipoEdificacaoAliquotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoAliquota
     */
    public function getFkImobiliarioTipoEdificacaoAliquotas()
    {
        return $this->fkImobiliarioTipoEdificacaoAliquotas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTrechoValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TrechoValorM2 $fkImobiliarioTrechoValorM2
     * @return Norma
     */
    public function addFkImobiliarioTrechoValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\TrechoValorM2 $fkImobiliarioTrechoValorM2)
    {
        if (false === $this->fkImobiliarioTrechoValorM2s->contains($fkImobiliarioTrechoValorM2)) {
            $fkImobiliarioTrechoValorM2->setFkNormasNorma($this);
            $this->fkImobiliarioTrechoValorM2s->add($fkImobiliarioTrechoValorM2);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTrechoValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TrechoValorM2 $fkImobiliarioTrechoValorM2
     */
    public function removeFkImobiliarioTrechoValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\TrechoValorM2 $fkImobiliarioTrechoValorM2)
    {
        $this->fkImobiliarioTrechoValorM2s->removeElement($fkImobiliarioTrechoValorM2);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTrechoValorM2s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TrechoValorM2
     */
    public function getFkImobiliarioTrechoValorM2s()
    {
        return $this->fkImobiliarioTrechoValorM2s;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTrechoAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TrechoAliquota $fkImobiliarioTrechoAliquota
     * @return Norma
     */
    public function addFkImobiliarioTrechoAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\TrechoAliquota $fkImobiliarioTrechoAliquota)
    {
        if (false === $this->fkImobiliarioTrechoAliquotas->contains($fkImobiliarioTrechoAliquota)) {
            $fkImobiliarioTrechoAliquota->setFkNormasNorma($this);
            $this->fkImobiliarioTrechoAliquotas->add($fkImobiliarioTrechoAliquota);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTrechoAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TrechoAliquota $fkImobiliarioTrechoAliquota
     */
    public function removeFkImobiliarioTrechoAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\TrechoAliquota $fkImobiliarioTrechoAliquota)
    {
        $this->fkImobiliarioTrechoAliquotas->removeElement($fkImobiliarioTrechoAliquota);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTrechoAliquotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TrechoAliquota
     */
    public function getFkImobiliarioTrechoAliquotas()
    {
        return $this->fkImobiliarioTrechoAliquotas;
    }

    /**
     * OneToMany (owning side)
     * Add LdoHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\Homologacao $fkLdoHomologacao
     * @return Norma
     */
    public function addFkLdoHomologacoes(\Urbem\CoreBundle\Entity\Ldo\Homologacao $fkLdoHomologacao)
    {
        if (false === $this->fkLdoHomologacoes->contains($fkLdoHomologacao)) {
            $fkLdoHomologacao->setFkNormasNorma($this);
            $this->fkLdoHomologacoes->add($fkLdoHomologacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LdoHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\Homologacao $fkLdoHomologacao
     */
    public function removeFkLdoHomologacoes(\Urbem\CoreBundle\Entity\Ldo\Homologacao $fkLdoHomologacao)
    {
        $this->fkLdoHomologacoes->removeElement($fkLdoHomologacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLdoHomologacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\Homologacao
     */
    public function getFkLdoHomologacoes()
    {
        return $this->fkLdoHomologacoes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoComissao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Comissao $fkLicitacaoComissao
     * @return Norma
     */
    public function addFkLicitacaoComissoes(\Urbem\CoreBundle\Entity\Licitacao\Comissao $fkLicitacaoComissao)
    {
        if (false === $this->fkLicitacaoComissoes->contains($fkLicitacaoComissao)) {
            $fkLicitacaoComissao->setFkNormasNorma($this);
            $this->fkLicitacaoComissoes->add($fkLicitacaoComissao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoComissao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Comissao $fkLicitacaoComissao
     */
    public function removeFkLicitacaoComissoes(\Urbem\CoreBundle\Entity\Licitacao\Comissao $fkLicitacaoComissao)
    {
        $this->fkLicitacaoComissoes->removeElement($fkLicitacaoComissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoComissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Comissao
     */
    public function getFkLicitacaoComissoes()
    {
        return $this->fkLicitacaoComissoes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoConvenioAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos $fkLicitacaoConvenioAditivos
     * @return Norma
     */
    public function addFkLicitacaoConvenioAditivos(\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos $fkLicitacaoConvenioAditivos)
    {
        if (false === $this->fkLicitacaoConvenioAditivos->contains($fkLicitacaoConvenioAditivos)) {
            $fkLicitacaoConvenioAditivos->setFkNormasNorma($this);
            $this->fkLicitacaoConvenioAditivos->add($fkLicitacaoConvenioAditivos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoConvenioAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos $fkLicitacaoConvenioAditivos
     */
    public function removeFkLicitacaoConvenioAditivos(\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos $fkLicitacaoConvenioAditivos)
    {
        $this->fkLicitacaoConvenioAditivos->removeElement($fkLicitacaoConvenioAditivos);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoConvenioAditivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos
     */
    public function getFkLicitacaoConvenioAditivos()
    {
        return $this->fkLicitacaoConvenioAditivos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio
     * @return Norma
     */
    public function addFkLicitacaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio)
    {
        if (false === $this->fkLicitacaoConvenios->contains($fkLicitacaoConvenio)) {
            $fkLicitacaoConvenio->setFkNormasNorma($this);
            $this->fkLicitacaoConvenios->add($fkLicitacaoConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio
     */
    public function removeFkLicitacaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio)
    {
        $this->fkLicitacaoConvenios->removeElement($fkLicitacaoConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    public function getFkLicitacaoConvenios()
    {
        return $this->fkLicitacaoConvenios;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoComissaoMembros
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros
     * @return Norma
     */
    public function addFkLicitacaoComissaoMembros(\Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros)
    {
        if (false === $this->fkLicitacaoComissaoMembros->contains($fkLicitacaoComissaoMembros)) {
            $fkLicitacaoComissaoMembros->setFkNormasNorma($this);
            $this->fkLicitacaoComissaoMembros->add($fkLicitacaoComissaoMembros);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoComissaoMembros
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros
     */
    public function removeFkLicitacaoComissaoMembros(\Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros)
    {
        $this->fkLicitacaoComissaoMembros->removeElement($fkLicitacaoComissaoMembros);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoComissaoMembros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros
     */
    public function getFkLicitacaoComissaoMembros()
    {
        return $this->fkLicitacaoComissaoMembros;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioAcrescimoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\AcrescimoNorma $fkMonetarioAcrescimoNorma
     * @return Norma
     */
    public function addFkMonetarioAcrescimoNormas(\Urbem\CoreBundle\Entity\Monetario\AcrescimoNorma $fkMonetarioAcrescimoNorma)
    {
        if (false === $this->fkMonetarioAcrescimoNormas->contains($fkMonetarioAcrescimoNorma)) {
            $fkMonetarioAcrescimoNorma->setFkNormasNorma($this);
            $this->fkMonetarioAcrescimoNormas->add($fkMonetarioAcrescimoNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioAcrescimoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\AcrescimoNorma $fkMonetarioAcrescimoNorma
     */
    public function removeFkMonetarioAcrescimoNormas(\Urbem\CoreBundle\Entity\Monetario\AcrescimoNorma $fkMonetarioAcrescimoNorma)
    {
        $this->fkMonetarioAcrescimoNormas->removeElement($fkMonetarioAcrescimoNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioAcrescimoNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\AcrescimoNorma
     */
    public function getFkMonetarioAcrescimoNormas()
    {
        return $this->fkMonetarioAcrescimoNormas;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoContaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaReceita $fkOrcamentoContaReceita
     * @return Norma
     */
    public function addFkOrcamentoContaReceitas(\Urbem\CoreBundle\Entity\Orcamento\ContaReceita $fkOrcamentoContaReceita)
    {
        if (false === $this->fkOrcamentoContaReceitas->contains($fkOrcamentoContaReceita)) {
            $fkOrcamentoContaReceita->setFkNormasNorma($this);
            $this->fkOrcamentoContaReceitas->add($fkOrcamentoContaReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoContaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaReceita $fkOrcamentoContaReceita
     */
    public function removeFkOrcamentoContaReceitas(\Urbem\CoreBundle\Entity\Orcamento\ContaReceita $fkOrcamentoContaReceita)
    {
        $this->fkOrcamentoContaReceitas->removeElement($fkOrcamentoContaReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoContaReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ContaReceita
     */
    public function getFkOrcamentoContaReceitas()
    {
        return $this->fkOrcamentoContaReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioCreditoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoNorma $fkMonetarioCreditoNorma
     * @return Norma
     */
    public function addFkMonetarioCreditoNormas(\Urbem\CoreBundle\Entity\Monetario\CreditoNorma $fkMonetarioCreditoNorma)
    {
        if (false === $this->fkMonetarioCreditoNormas->contains($fkMonetarioCreditoNorma)) {
            $fkMonetarioCreditoNorma->setFkNormasNorma($this);
            $this->fkMonetarioCreditoNormas->add($fkMonetarioCreditoNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioCreditoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoNorma $fkMonetarioCreditoNorma
     */
    public function removeFkMonetarioCreditoNormas(\Urbem\CoreBundle\Entity\Monetario\CreditoNorma $fkMonetarioCreditoNorma)
    {
        $this->fkMonetarioCreditoNormas->removeElement($fkMonetarioCreditoNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioCreditoNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoNorma
     */
    public function getFkMonetarioCreditoNormas()
    {
        return $this->fkMonetarioCreditoNormas;
    }

    /**
     * OneToMany (owning side)
     * Add NormasNormaDetalheAl
     *
     * @param \Urbem\CoreBundle\Entity\Normas\NormaDetalheAl $fkNormasNormaDetalheAl
     * @return Norma
     */
    public function addFkNormasNormaDetalheAis1(\Urbem\CoreBundle\Entity\Normas\NormaDetalheAl $fkNormasNormaDetalheAl)
    {
        if (false === $this->fkNormasNormaDetalheAis1->contains($fkNormasNormaDetalheAl)) {
            $fkNormasNormaDetalheAl->setFkNormasNorma1($this);
            $this->fkNormasNormaDetalheAis1->add($fkNormasNormaDetalheAl);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove NormasNormaDetalheAl
     *
     * @param \Urbem\CoreBundle\Entity\Normas\NormaDetalheAl $fkNormasNormaDetalheAl
     */
    public function removeFkNormasNormaDetalheAis1(\Urbem\CoreBundle\Entity\Normas\NormaDetalheAl $fkNormasNormaDetalheAl)
    {
        $this->fkNormasNormaDetalheAis1->removeElement($fkNormasNormaDetalheAl);
    }

    /**
     * OneToMany (owning side)
     * Get fkNormasNormaDetalheAis1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\NormaDetalheAl
     */
    public function getFkNormasNormaDetalheAis1()
    {
        return $this->fkNormasNormaDetalheAis1;
    }

    /**
     * OneToMany (owning side)
     * Add NormasNormaTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\NormaTipoNorma $fkNormasNormaTipoNorma
     * @return Norma
     */
    public function addFkNormasNormaTipoNormas(\Urbem\CoreBundle\Entity\Normas\NormaTipoNorma $fkNormasNormaTipoNorma)
    {
        if (false === $this->fkNormasNormaTipoNormas->contains($fkNormasNormaTipoNorma)) {
            $fkNormasNormaTipoNorma->setFkNormasNorma($this);
            $this->fkNormasNormaTipoNormas->add($fkNormasNormaTipoNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove NormasNormaTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\NormaTipoNorma $fkNormasNormaTipoNorma
     */
    public function removeFkNormasNormaTipoNormas(\Urbem\CoreBundle\Entity\Normas\NormaTipoNorma $fkNormasNormaTipoNorma)
    {
        $this->fkNormasNormaTipoNormas->removeElement($fkNormasNormaTipoNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkNormasNormaTipoNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\NormaTipoNorma
     */
    public function getFkNormasNormaTipoNormas()
    {
        return $this->fkNormasNormaTipoNormas;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoSuplementacao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Suplementacao $fkOrcamentoSuplementacao
     * @return Norma
     */
    public function addFkOrcamentoSuplementacoes(\Urbem\CoreBundle\Entity\Orcamento\Suplementacao $fkOrcamentoSuplementacao)
    {
        if (false === $this->fkOrcamentoSuplementacoes->contains($fkOrcamentoSuplementacao)) {
            $fkOrcamentoSuplementacao->setFkNormasNorma($this);
            $this->fkOrcamentoSuplementacoes->add($fkOrcamentoSuplementacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoSuplementacao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Suplementacao $fkOrcamentoSuplementacao
     */
    public function removeFkOrcamentoSuplementacoes(\Urbem\CoreBundle\Entity\Orcamento\Suplementacao $fkOrcamentoSuplementacao)
    {
        $this->fkOrcamentoSuplementacoes->removeElement($fkOrcamentoSuplementacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoSuplementacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Suplementacao
     */
    public function getFkOrcamentoSuplementacoes()
    {
        return $this->fkOrcamentoSuplementacoes;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaOrganograma
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Organograma $fkOrganogramaOrganograma
     * @return Norma
     */
    public function addFkOrganogramaOrganogramas(\Urbem\CoreBundle\Entity\Organograma\Organograma $fkOrganogramaOrganograma)
    {
        if (false === $this->fkOrganogramaOrganogramas->contains($fkOrganogramaOrganograma)) {
            $fkOrganogramaOrganograma->setFkNormasNorma($this);
            $this->fkOrganogramaOrganogramas->add($fkOrganogramaOrganograma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaOrganograma
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Organograma $fkOrganogramaOrganograma
     */
    public function removeFkOrganogramaOrganogramas(\Urbem\CoreBundle\Entity\Organograma\Organograma $fkOrganogramaOrganograma)
    {
        $this->fkOrganogramaOrganogramas->removeElement($fkOrganogramaOrganograma);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaOrganogramas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\Organograma
     */
    public function getFkOrganogramaOrganogramas()
    {
        return $this->fkOrganogramaOrganogramas;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAdidoCedido
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AdidoCedido $fkPessoalAdidoCedido
     * @return Norma
     */
    public function addFkPessoalAdidoCedidos(\Urbem\CoreBundle\Entity\Pessoal\AdidoCedido $fkPessoalAdidoCedido)
    {
        if (false === $this->fkPessoalAdidoCedidos->contains($fkPessoalAdidoCedido)) {
            $fkPessoalAdidoCedido->setFkNormasNorma($this);
            $this->fkPessoalAdidoCedidos->add($fkPessoalAdidoCedido);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAdidoCedido
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AdidoCedido $fkPessoalAdidoCedido
     */
    public function removeFkPessoalAdidoCedidos(\Urbem\CoreBundle\Entity\Pessoal\AdidoCedido $fkPessoalAdidoCedido)
    {
        $this->fkPessoalAdidoCedidos->removeElement($fkPessoalAdidoCedido);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAdidoCedidos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AdidoCedido
     */
    public function getFkPessoalAdidoCedidos()
    {
        return $this->fkPessoalAdidoCedidos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento
     * @return Norma
     */
    public function addFkPessoalAssentamentoAssentamentos(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento)
    {
        if (false === $this->fkPessoalAssentamentoAssentamentos->contains($fkPessoalAssentamentoAssentamento)) {
            $fkPessoalAssentamentoAssentamento->setFkNormasNorma($this);
            $this->fkPessoalAssentamentoAssentamentos->add($fkPessoalAssentamentoAssentamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento
     */
    public function removeFkPessoalAssentamentoAssentamentos(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento)
    {
        $this->fkPessoalAssentamentoAssentamentos->removeElement($fkPessoalAssentamentoAssentamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoAssentamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    public function getFkPessoalAssentamentoAssentamentos()
    {
        return $this->fkPessoalAssentamentoAssentamentos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoGeradoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoNorma $fkPessoalAssentamentoGeradoNorma
     * @return Norma
     */
    public function addFkPessoalAssentamentoGeradoNormas(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoNorma $fkPessoalAssentamentoGeradoNorma)
    {
        if (false === $this->fkPessoalAssentamentoGeradoNormas->contains($fkPessoalAssentamentoGeradoNorma)) {
            $fkPessoalAssentamentoGeradoNorma->setFkNormasNorma($this);
            $this->fkPessoalAssentamentoGeradoNormas->add($fkPessoalAssentamentoGeradoNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoGeradoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoNorma $fkPessoalAssentamentoGeradoNorma
     */
    public function removeFkPessoalAssentamentoGeradoNormas(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoNorma $fkPessoalAssentamentoGeradoNorma)
    {
        $this->fkPessoalAssentamentoGeradoNormas->removeElement($fkPessoalAssentamentoGeradoNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoGeradoNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoNorma
     */
    public function getFkPessoalAssentamentoGeradoNormas()
    {
        return $this->fkPessoalAssentamentoGeradoNormas;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoPensionistaCasoCausaNorma
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausaNorma $fkPessoalContratoPensionistaCasoCausaNorma
     * @return Norma
     */
    public function addFkPessoalContratoPensionistaCasoCausaNormas(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausaNorma $fkPessoalContratoPensionistaCasoCausaNorma)
    {
        if (false === $this->fkPessoalContratoPensionistaCasoCausaNormas->contains($fkPessoalContratoPensionistaCasoCausaNorma)) {
            $fkPessoalContratoPensionistaCasoCausaNorma->setFkNormasNorma($this);
            $this->fkPessoalContratoPensionistaCasoCausaNormas->add($fkPessoalContratoPensionistaCasoCausaNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoPensionistaCasoCausaNorma
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausaNorma $fkPessoalContratoPensionistaCasoCausaNorma
     */
    public function removeFkPessoalContratoPensionistaCasoCausaNormas(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausaNorma $fkPessoalContratoPensionistaCasoCausaNorma)
    {
        $this->fkPessoalContratoPensionistaCasoCausaNormas->removeElement($fkPessoalContratoPensionistaCasoCausaNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoPensionistaCasoCausaNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausaNorma
     */
    public function getFkPessoalContratoPensionistaCasoCausaNormas()
    {
        return $this->fkPessoalContratoPensionistaCasoCausaNormas;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorCasoCausaNorma
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausaNorma $fkPessoalContratoServidorCasoCausaNorma
     * @return Norma
     */
    public function addFkPessoalContratoServidorCasoCausaNormas(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausaNorma $fkPessoalContratoServidorCasoCausaNorma)
    {
        if (false === $this->fkPessoalContratoServidorCasoCausaNormas->contains($fkPessoalContratoServidorCasoCausaNorma)) {
            $fkPessoalContratoServidorCasoCausaNorma->setFkNormasNorma($this);
            $this->fkPessoalContratoServidorCasoCausaNormas->add($fkPessoalContratoServidorCasoCausaNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorCasoCausaNorma
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausaNorma $fkPessoalContratoServidorCasoCausaNorma
     */
    public function removeFkPessoalContratoServidorCasoCausaNormas(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausaNorma $fkPessoalContratoServidorCasoCausaNorma)
    {
        $this->fkPessoalContratoServidorCasoCausaNormas->removeElement($fkPessoalContratoServidorCasoCausaNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorCasoCausaNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausaNorma
     */
    public function getFkPessoalContratoServidorCasoCausaNormas()
    {
        return $this->fkPessoalContratoServidorCasoCausaNormas;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalEspecialidadeSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao $fkPessoalEspecialidadeSubDivisao
     * @return Norma
     */
    public function addFkPessoalEspecialidadeSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao $fkPessoalEspecialidadeSubDivisao)
    {
        if (false === $this->fkPessoalEspecialidadeSubDivisoes->contains($fkPessoalEspecialidadeSubDivisao)) {
            $fkPessoalEspecialidadeSubDivisao->setFkNormasNorma($this);
            $this->fkPessoalEspecialidadeSubDivisoes->add($fkPessoalEspecialidadeSubDivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalEspecialidadeSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao $fkPessoalEspecialidadeSubDivisao
     */
    public function removeFkPessoalEspecialidadeSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao $fkPessoalEspecialidadeSubDivisao)
    {
        $this->fkPessoalEspecialidadeSubDivisoes->removeElement($fkPessoalEspecialidadeSubDivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalEspecialidadeSubDivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao
     */
    public function getFkPessoalEspecialidadeSubDivisoes()
    {
        return $this->fkPessoalEspecialidadeSubDivisoes;
    }

    /**
     * OneToMany (owning side)
     * Add PpaPpaPublicacao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\PpaPublicacao $fkPpaPpaPublicacao
     * @return Norma
     */
    public function addFkPpaPpaPublicacoes(\Urbem\CoreBundle\Entity\Ppa\PpaPublicacao $fkPpaPpaPublicacao)
    {
        if (false === $this->fkPpaPpaPublicacoes->contains($fkPpaPpaPublicacao)) {
            $fkPpaPpaPublicacao->setFkNormasNorma($this);
            $this->fkPpaPpaPublicacoes->add($fkPpaPpaPublicacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaPpaPublicacao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\PpaPublicacao $fkPpaPpaPublicacao
     */
    public function removeFkPpaPpaPublicacoes(\Urbem\CoreBundle\Entity\Ppa\PpaPublicacao $fkPpaPpaPublicacao)
    {
        $this->fkPpaPpaPublicacoes->removeElement($fkPpaPpaPublicacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaPpaPublicacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\PpaPublicacao
     */
    public function getFkPpaPpaPublicacoes()
    {
        return $this->fkPpaPpaPublicacoes;
    }

    /**
     * OneToMany (owning side)
     * Add PpaAcaoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoNorma $fkPpaAcaoNorma
     * @return Norma
     */
    public function addFkPpaAcaoNormas(\Urbem\CoreBundle\Entity\Ppa\AcaoNorma $fkPpaAcaoNorma)
    {
        if (false === $this->fkPpaAcaoNormas->contains($fkPpaAcaoNorma)) {
            $fkPpaAcaoNorma->setFkNormasNorma($this);
            $this->fkPpaAcaoNormas->add($fkPpaAcaoNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaAcaoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoNorma $fkPpaAcaoNorma
     */
    public function removeFkPpaAcaoNormas(\Urbem\CoreBundle\Entity\Ppa\AcaoNorma $fkPpaAcaoNorma)
    {
        $this->fkPpaAcaoNormas->removeElement($fkPpaAcaoNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaAcaoNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoNorma
     */
    public function getFkPpaAcaoNormas()
    {
        return $this->fkPpaAcaoNormas;
    }

    /**
     * OneToMany (owning side)
     * Add PpaProgramaNorma
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaNorma $fkPpaProgramaNorma
     * @return Norma
     */
    public function addFkPpaProgramaNormas(\Urbem\CoreBundle\Entity\Ppa\ProgramaNorma $fkPpaProgramaNorma)
    {
        if (false === $this->fkPpaProgramaNormas->contains($fkPpaProgramaNorma)) {
            $fkPpaProgramaNorma->setFkNormasNorma($this);
            $this->fkPpaProgramaNormas->add($fkPpaProgramaNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaProgramaNorma
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaNorma $fkPpaProgramaNorma
     */
    public function removeFkPpaProgramaNormas(\Urbem\CoreBundle\Entity\Ppa\ProgramaNorma $fkPpaProgramaNorma)
    {
        $this->fkPpaProgramaNormas->removeElement($fkPpaProgramaNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaProgramaNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaNorma
     */
    public function getFkPpaProgramaNormas()
    {
        return $this->fkPpaProgramaNormas;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgConfiguracaoLoa
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLoa $fkTcemgConfiguracaoLoa
     * @return Norma
     */
    public function addFkTcemgConfiguracaoLoas(\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLoa $fkTcemgConfiguracaoLoa)
    {
        if (false === $this->fkTcemgConfiguracaoLoas->contains($fkTcemgConfiguracaoLoa)) {
            $fkTcemgConfiguracaoLoa->setFkNormasNorma($this);
            $this->fkTcemgConfiguracaoLoas->add($fkTcemgConfiguracaoLoa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgConfiguracaoLoa
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLoa $fkTcemgConfiguracaoLoa
     */
    public function removeFkTcemgConfiguracaoLoas(\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLoa $fkTcemgConfiguracaoLoa)
    {
        $this->fkTcemgConfiguracaoLoas->removeElement($fkTcemgConfiguracaoLoa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgConfiguracaoLoas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLoa
     */
    public function getFkTcemgConfiguracaoLoas()
    {
        return $this->fkTcemgConfiguracaoLoas;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgConfiguracaoReglic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoReglic $fkTcemgConfiguracaoReglic
     * @return Norma
     */
    public function addFkTcemgConfiguracaoReglics(\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoReglic $fkTcemgConfiguracaoReglic)
    {
        if (false === $this->fkTcemgConfiguracaoReglics->contains($fkTcemgConfiguracaoReglic)) {
            $fkTcemgConfiguracaoReglic->setFkNormasNorma($this);
            $this->fkTcemgConfiguracaoReglics->add($fkTcemgConfiguracaoReglic);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgConfiguracaoReglic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoReglic $fkTcemgConfiguracaoReglic
     */
    public function removeFkTcemgConfiguracaoReglics(\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoReglic $fkTcemgConfiguracaoReglic)
    {
        $this->fkTcemgConfiguracaoReglics->removeElement($fkTcemgConfiguracaoReglic);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgConfiguracaoReglics
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoReglic
     */
    public function getFkTcemgConfiguracaoReglics()
    {
        return $this->fkTcemgConfiguracaoReglics;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgConfiguracaoLeisPpa
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLeisPpa $fkTcemgConfiguracaoLeisPpa
     * @return Norma
     */
    public function addFkTcemgConfiguracaoLeisPpas(\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLeisPpa $fkTcemgConfiguracaoLeisPpa)
    {
        if (false === $this->fkTcemgConfiguracaoLeisPpas->contains($fkTcemgConfiguracaoLeisPpa)) {
            $fkTcemgConfiguracaoLeisPpa->setFkNormasNorma($this);
            $this->fkTcemgConfiguracaoLeisPpas->add($fkTcemgConfiguracaoLeisPpa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgConfiguracaoLeisPpa
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLeisPpa $fkTcemgConfiguracaoLeisPpa
     */
    public function removeFkTcemgConfiguracaoLeisPpas(\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLeisPpa $fkTcemgConfiguracaoLeisPpa)
    {
        $this->fkTcemgConfiguracaoLeisPpas->removeElement($fkTcemgConfiguracaoLeisPpa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgConfiguracaoLeisPpas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLeisPpa
     */
    public function getFkTcemgConfiguracaoLeisPpas()
    {
        return $this->fkTcemgConfiguracaoLeisPpas;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgConfiguracaoLeisLdo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLeisLdo $fkTcemgConfiguracaoLeisLdo
     * @return Norma
     */
    public function addFkTcemgConfiguracaoLeisLdos(\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLeisLdo $fkTcemgConfiguracaoLeisLdo)
    {
        if (false === $this->fkTcemgConfiguracaoLeisLdos->contains($fkTcemgConfiguracaoLeisLdo)) {
            $fkTcemgConfiguracaoLeisLdo->setFkNormasNorma($this);
            $this->fkTcemgConfiguracaoLeisLdos->add($fkTcemgConfiguracaoLeisLdo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgConfiguracaoLeisLdo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLeisLdo $fkTcemgConfiguracaoLeisLdo
     */
    public function removeFkTcemgConfiguracaoLeisLdos(\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLeisLdo $fkTcemgConfiguracaoLeisLdo)
    {
        $this->fkTcemgConfiguracaoLeisLdos->removeElement($fkTcemgConfiguracaoLeisLdo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgConfiguracaoLeisLdos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLeisLdo
     */
    public function getFkTcemgConfiguracaoLeisLdos()
    {
        return $this->fkTcemgConfiguracaoLeisLdos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgNormaArtigo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NormaArtigo $fkTcemgNormaArtigo
     * @return Norma
     */
    public function addFkTcemgNormaArtigos(\Urbem\CoreBundle\Entity\Tcemg\NormaArtigo $fkTcemgNormaArtigo)
    {
        if (false === $this->fkTcemgNormaArtigos->contains($fkTcemgNormaArtigo)) {
            $fkTcemgNormaArtigo->setFkNormasNorma($this);
            $this->fkTcemgNormaArtigos->add($fkTcemgNormaArtigo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgNormaArtigo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NormaArtigo $fkTcemgNormaArtigo
     */
    public function removeFkTcemgNormaArtigos(\Urbem\CoreBundle\Entity\Tcemg\NormaArtigo $fkTcemgNormaArtigo)
    {
        $this->fkTcemgNormaArtigos->removeElement($fkTcemgNormaArtigo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgNormaArtigos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\NormaArtigo
     */
    public function getFkTcemgNormaArtigos()
    {
        return $this->fkTcemgNormaArtigos;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeAgenteEletivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\AgenteEletivo $fkTcepeAgenteEletivo
     * @return Norma
     */
    public function addFkTcepeAgenteEletivos(\Urbem\CoreBundle\Entity\Tcepe\AgenteEletivo $fkTcepeAgenteEletivo)
    {
        if (false === $this->fkTcepeAgenteEletivos->contains($fkTcepeAgenteEletivo)) {
            $fkTcepeAgenteEletivo->setFkNormasNorma($this);
            $this->fkTcepeAgenteEletivos->add($fkTcepeAgenteEletivo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeAgenteEletivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\AgenteEletivo $fkTcepeAgenteEletivo
     */
    public function removeFkTcepeAgenteEletivos(\Urbem\CoreBundle\Entity\Tcepe\AgenteEletivo $fkTcepeAgenteEletivo)
    {
        $this->fkTcepeAgenteEletivos->removeElement($fkTcepeAgenteEletivo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeAgenteEletivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\AgenteEletivo
     */
    public function getFkTcepeAgenteEletivos()
    {
        return $this->fkTcepeAgenteEletivos;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeDividaFundadaOperacaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOperacaoCredito $fkTcepeDividaFundadaOperacaoCredito
     * @return Norma
     */
    public function addFkTcepeDividaFundadaOperacaoCreditos(\Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOperacaoCredito $fkTcepeDividaFundadaOperacaoCredito)
    {
        if (false === $this->fkTcepeDividaFundadaOperacaoCreditos->contains($fkTcepeDividaFundadaOperacaoCredito)) {
            $fkTcepeDividaFundadaOperacaoCredito->setFkNormasNorma($this);
            $this->fkTcepeDividaFundadaOperacaoCreditos->add($fkTcepeDividaFundadaOperacaoCredito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeDividaFundadaOperacaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOperacaoCredito $fkTcepeDividaFundadaOperacaoCredito
     */
    public function removeFkTcepeDividaFundadaOperacaoCreditos(\Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOperacaoCredito $fkTcepeDividaFundadaOperacaoCredito)
    {
        $this->fkTcepeDividaFundadaOperacaoCreditos->removeElement($fkTcepeDividaFundadaOperacaoCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeDividaFundadaOperacaoCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOperacaoCredito
     */
    public function getFkTcepeDividaFundadaOperacaoCreditos()
    {
        return $this->fkTcepeDividaFundadaOperacaoCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add TcernUnidadeGestora
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeGestora $fkTcernUnidadeGestora
     * @return Norma
     */
    public function addFkTcernUnidadeGestoras(\Urbem\CoreBundle\Entity\Tcern\UnidadeGestora $fkTcernUnidadeGestora)
    {
        if (false === $this->fkTcernUnidadeGestoras->contains($fkTcernUnidadeGestora)) {
            $fkTcernUnidadeGestora->setFkNormasNorma($this);
            $this->fkTcernUnidadeGestoras->add($fkTcernUnidadeGestora);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernUnidadeGestora
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeGestora $fkTcernUnidadeGestora
     */
    public function removeFkTcernUnidadeGestoras(\Urbem\CoreBundle\Entity\Tcern\UnidadeGestora $fkTcernUnidadeGestora)
    {
        $this->fkTcernUnidadeGestoras->removeElement($fkTcernUnidadeGestora);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernUnidadeGestoras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeGestora
     */
    public function getFkTcernUnidadeGestoras()
    {
        return $this->fkTcernUnidadeGestoras;
    }

    /**
     * OneToMany (owning side)
     * Add TcernUnidadeOrcamentaria
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria $fkTcernUnidadeOrcamentaria
     * @return Norma
     */
    public function addFkTcernUnidadeOrcamentarias(\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria $fkTcernUnidadeOrcamentaria)
    {
        if (false === $this->fkTcernUnidadeOrcamentarias->contains($fkTcernUnidadeOrcamentaria)) {
            $fkTcernUnidadeOrcamentaria->setFkNormasNorma($this);
            $this->fkTcernUnidadeOrcamentarias->add($fkTcernUnidadeOrcamentaria);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernUnidadeOrcamentaria
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria $fkTcernUnidadeOrcamentaria
     */
    public function removeFkTcernUnidadeOrcamentarias(\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria $fkTcernUnidadeOrcamentaria)
    {
        $this->fkTcernUnidadeOrcamentarias->removeElement($fkTcernUnidadeOrcamentaria);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernUnidadeOrcamentarias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria
     */
    public function getFkTcernUnidadeOrcamentarias()
    {
        return $this->fkTcernUnidadeOrcamentarias;
    }

    /**
     * OneToMany (owning side)
     * Add TcetoAlteracaoLeiPpa
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\AlteracaoLeiPpa $fkTcetoAlteracaoLeiPpa
     * @return Norma
     */
    public function addFkTcetoAlteracaoLeiPpas(\Urbem\CoreBundle\Entity\Tceto\AlteracaoLeiPpa $fkTcetoAlteracaoLeiPpa)
    {
        if (false === $this->fkTcetoAlteracaoLeiPpas->contains($fkTcetoAlteracaoLeiPpa)) {
            $fkTcetoAlteracaoLeiPpa->setFkNormasNorma($this);
            $this->fkTcetoAlteracaoLeiPpas->add($fkTcetoAlteracaoLeiPpa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcetoAlteracaoLeiPpa
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\AlteracaoLeiPpa $fkTcetoAlteracaoLeiPpa
     */
    public function removeFkTcetoAlteracaoLeiPpas(\Urbem\CoreBundle\Entity\Tceto\AlteracaoLeiPpa $fkTcetoAlteracaoLeiPpa)
    {
        $this->fkTcetoAlteracaoLeiPpas->removeElement($fkTcetoAlteracaoLeiPpa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcetoAlteracaoLeiPpas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\AlteracaoLeiPpa
     */
    public function getFkTcetoAlteracaoLeiPpas()
    {
        return $this->fkTcetoAlteracaoLeiPpas;
    }

    /**
     * OneToMany (owning side)
     * Add TcetoNormaDetalhe
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\NormaDetalhe $fkTcetoNormaDetalhe
     * @return Norma
     */
    public function addFkTcetoNormaDetalhes1(\Urbem\CoreBundle\Entity\Tceto\NormaDetalhe $fkTcetoNormaDetalhe)
    {
        if (false === $this->fkTcetoNormaDetalhes1->contains($fkTcetoNormaDetalhe)) {
            $fkTcetoNormaDetalhe->setFkNormasNorma1($this);
            $this->fkTcetoNormaDetalhes1->add($fkTcetoNormaDetalhe);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcetoNormaDetalhe
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\NormaDetalhe $fkTcetoNormaDetalhe
     */
    public function removeFkTcetoNormaDetalhes1(\Urbem\CoreBundle\Entity\Tceto\NormaDetalhe $fkTcetoNormaDetalhe)
    {
        $this->fkTcetoNormaDetalhes1->removeElement($fkTcetoNormaDetalhe);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcetoNormaDetalhes1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\NormaDetalhe
     */
    public function getFkTcetoNormaDetalhes1()
    {
        return $this->fkTcetoNormaDetalhes1;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaLimiteAlteracaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\LimiteAlteracaoCredito $fkTcmbaLimiteAlteracaoCredito
     * @return Norma
     */
    public function addFkTcmbaLimiteAlteracaoCreditos(\Urbem\CoreBundle\Entity\Tcmba\LimiteAlteracaoCredito $fkTcmbaLimiteAlteracaoCredito)
    {
        if (false === $this->fkTcmbaLimiteAlteracaoCreditos->contains($fkTcmbaLimiteAlteracaoCredito)) {
            $fkTcmbaLimiteAlteracaoCredito->setFkNormasNorma($this);
            $this->fkTcmbaLimiteAlteracaoCreditos->add($fkTcmbaLimiteAlteracaoCredito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaLimiteAlteracaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\LimiteAlteracaoCredito $fkTcmbaLimiteAlteracaoCredito
     */
    public function removeFkTcmbaLimiteAlteracaoCreditos(\Urbem\CoreBundle\Entity\Tcmba\LimiteAlteracaoCredito $fkTcmbaLimiteAlteracaoCredito)
    {
        $this->fkTcmbaLimiteAlteracaoCreditos->removeElement($fkTcmbaLimiteAlteracaoCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaLimiteAlteracaoCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\LimiteAlteracaoCredito
     */
    public function getFkTcmbaLimiteAlteracaoCreditos()
    {
        return $this->fkTcmbaLimiteAlteracaoCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaSubvencaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho $fkTcmbaSubvencaoEmpenho
     * @return Norma
     */
    public function addFkTcmbaSubvencaoEmpenhos(\Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho $fkTcmbaSubvencaoEmpenho)
    {
        if (false === $this->fkTcmbaSubvencaoEmpenhos->contains($fkTcmbaSubvencaoEmpenho)) {
            $fkTcmbaSubvencaoEmpenho->setFkNormasNorma($this);
            $this->fkTcmbaSubvencaoEmpenhos->add($fkTcmbaSubvencaoEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaSubvencaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho $fkTcmbaSubvencaoEmpenho
     */
    public function removeFkTcmbaSubvencaoEmpenhos(\Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho $fkTcmbaSubvencaoEmpenho)
    {
        $this->fkTcmbaSubvencaoEmpenhos->removeElement($fkTcmbaSubvencaoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaSubvencaoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho
     */
    public function getFkTcmbaSubvencaoEmpenhos()
    {
        return $this->fkTcmbaSubvencaoEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaSubvencaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho $fkTcmbaSubvencaoEmpenho
     * @return Norma
     */
    public function addFkTcmbaSubvencaoEmpenhos1(\Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho $fkTcmbaSubvencaoEmpenho)
    {
        if (false === $this->fkTcmbaSubvencaoEmpenhos1->contains($fkTcmbaSubvencaoEmpenho)) {
            $fkTcmbaSubvencaoEmpenho->setFkNormasNorma1($this);
            $this->fkTcmbaSubvencaoEmpenhos1->add($fkTcmbaSubvencaoEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaSubvencaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho $fkTcmbaSubvencaoEmpenho
     */
    public function removeFkTcmbaSubvencaoEmpenhos1(\Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho $fkTcmbaSubvencaoEmpenho)
    {
        $this->fkTcmbaSubvencaoEmpenhos1->removeElement($fkTcmbaSubvencaoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaSubvencaoEmpenhos1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho
     */
    public function getFkTcmbaSubvencaoEmpenhos1()
    {
        return $this->fkTcmbaSubvencaoEmpenhos1;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoConfiguracaoArquivoDmr
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoArquivoDmr $fkTcmgoConfiguracaoArquivoDmr
     * @return Norma
     */
    public function addFkTcmgoConfiguracaoArquivoDmres(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoArquivoDmr $fkTcmgoConfiguracaoArquivoDmr)
    {
        if (false === $this->fkTcmgoConfiguracaoArquivoDmres->contains($fkTcmgoConfiguracaoArquivoDmr)) {
            $fkTcmgoConfiguracaoArquivoDmr->setFkNormasNorma($this);
            $this->fkTcmgoConfiguracaoArquivoDmres->add($fkTcmgoConfiguracaoArquivoDmr);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoConfiguracaoArquivoDmr
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoArquivoDmr $fkTcmgoConfiguracaoArquivoDmr
     */
    public function removeFkTcmgoConfiguracaoArquivoDmres(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoArquivoDmr $fkTcmgoConfiguracaoArquivoDmr)
    {
        $this->fkTcmgoConfiguracaoArquivoDmres->removeElement($fkTcmgoConfiguracaoArquivoDmr);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoConfiguracaoArquivoDmres
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoArquivoDmr
     */
    public function getFkTcmgoConfiguracaoArquivoDmres()
    {
        return $this->fkTcmgoConfiguracaoArquivoDmres;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoConfiguracaoLeisLdo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLeisLdo $fkTcmgoConfiguracaoLeisLdo
     * @return Norma
     */
    public function addFkTcmgoConfiguracaoLeisLdos(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLeisLdo $fkTcmgoConfiguracaoLeisLdo)
    {
        if (false === $this->fkTcmgoConfiguracaoLeisLdos->contains($fkTcmgoConfiguracaoLeisLdo)) {
            $fkTcmgoConfiguracaoLeisLdo->setFkNormasNorma($this);
            $this->fkTcmgoConfiguracaoLeisLdos->add($fkTcmgoConfiguracaoLeisLdo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoConfiguracaoLeisLdo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLeisLdo $fkTcmgoConfiguracaoLeisLdo
     */
    public function removeFkTcmgoConfiguracaoLeisLdos(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLeisLdo $fkTcmgoConfiguracaoLeisLdo)
    {
        $this->fkTcmgoConfiguracaoLeisLdos->removeElement($fkTcmgoConfiguracaoLeisLdo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoConfiguracaoLeisLdos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLeisLdo
     */
    public function getFkTcmgoConfiguracaoLeisLdos()
    {
        return $this->fkTcmgoConfiguracaoLeisLdos;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoConfiguracaoLeisPpa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLeisPpa $fkTcmgoConfiguracaoLeisPpa
     * @return Norma
     */
    public function addFkTcmgoConfiguracaoLeisPpas(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLeisPpa $fkTcmgoConfiguracaoLeisPpa)
    {
        if (false === $this->fkTcmgoConfiguracaoLeisPpas->contains($fkTcmgoConfiguracaoLeisPpa)) {
            $fkTcmgoConfiguracaoLeisPpa->setFkNormasNorma($this);
            $this->fkTcmgoConfiguracaoLeisPpas->add($fkTcmgoConfiguracaoLeisPpa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoConfiguracaoLeisPpa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLeisPpa $fkTcmgoConfiguracaoLeisPpa
     */
    public function removeFkTcmgoConfiguracaoLeisPpas(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLeisPpa $fkTcmgoConfiguracaoLeisPpa)
    {
        $this->fkTcmgoConfiguracaoLeisPpas->removeElement($fkTcmgoConfiguracaoLeisPpa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoConfiguracaoLeisPpas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLeisPpa
     */
    public function getFkTcmgoConfiguracaoLeisPpas()
    {
        return $this->fkTcmgoConfiguracaoLeisPpas;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLoteNorma
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LoteNorma $fkContabilidadeLoteNorma
     * @return Norma
     */
    public function addFkContabilidadeLoteNormas(\Urbem\CoreBundle\Entity\Contabilidade\LoteNorma $fkContabilidadeLoteNorma)
    {
        if (false === $this->fkContabilidadeLoteNormas->contains($fkContabilidadeLoteNorma)) {
            $fkContabilidadeLoteNorma->setFkNormasNorma($this);
            $this->fkContabilidadeLoteNormas->add($fkContabilidadeLoteNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLoteNorma
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LoteNorma $fkContabilidadeLoteNorma
     */
    public function removeFkContabilidadeLoteNormas(\Urbem\CoreBundle\Entity\Contabilidade\LoteNorma $fkContabilidadeLoteNorma)
    {
        $this->fkContabilidadeLoteNormas->removeElement($fkContabilidadeLoteNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLoteNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LoteNorma
     */
    public function getFkContabilidadeLoteNormas()
    {
        return $this->fkContabilidadeLoteNormas;
    }

    /**
     * OneToMany (owning side)
     * Add DiariasDiaria
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria
     * @return Norma
     */
    public function addFkDiariasDiarias(\Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria)
    {
        if (false === $this->fkDiariasDiarias->contains($fkDiariasDiaria)) {
            $fkDiariasDiaria->setFkNormasNorma($this);
            $this->fkDiariasDiarias->add($fkDiariasDiaria);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DiariasDiaria
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria
     */
    public function removeFkDiariasDiarias(\Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria)
    {
        $this->fkDiariasDiarias->removeElement($fkDiariasDiaria);
    }

    /**
     * OneToMany (owning side)
     * Get fkDiariasDiarias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Diarias\Diaria
     */
    public function getFkDiariasDiarias()
    {
        return $this->fkDiariasDiarias;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return Norma
     */
    public function addFkOrganogramaOrgoes(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        if (false === $this->fkOrganogramaOrgoes->contains($fkOrganogramaOrgao)) {
            $fkOrganogramaOrgao->setFkNormasNorma($this);
            $this->fkOrganogramaOrgoes->add($fkOrganogramaOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     */
    public function removeFkOrganogramaOrgoes(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        $this->fkOrganogramaOrgoes->removeElement($fkOrganogramaOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    public function getFkOrganogramaOrgoes()
    {
        return $this->fkOrganogramaOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add NormasAtributoNormaValor
     *
     * @param \Urbem\CoreBundle\Entity\Normas\AtributoNormaValor $fkNormasAtributoNormaValor
     * @return Norma
     */
    public function addFkNormasAtributoNormaValores(\Urbem\CoreBundle\Entity\Normas\AtributoNormaValor $fkNormasAtributoNormaValor)
    {
        if (false === $this->fkNormasAtributoNormaValores->contains($fkNormasAtributoNormaValor)) {
            $fkNormasAtributoNormaValor->setFkNormasNorma($this);
            $this->fkNormasAtributoNormaValores->add($fkNormasAtributoNormaValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove NormasAtributoNormaValor
     *
     * @param \Urbem\CoreBundle\Entity\Normas\AtributoNormaValor $fkNormasAtributoNormaValor
     */
    public function removeFkNormasAtributoNormaValores(\Urbem\CoreBundle\Entity\Normas\AtributoNormaValor $fkNormasAtributoNormaValor)
    {
        $this->fkNormasAtributoNormaValores->removeElement($fkNormasAtributoNormaValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkNormasAtributoNormaValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\AtributoNormaValor
     */
    public function getFkNormasAtributoNormaValores()
    {
        return $this->fkNormasAtributoNormaValores;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalCargoSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CargoSubDivisao $fkPessoalCargoSubDivisao
     * @return Norma
     */
    public function addFkPessoalCargoSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\CargoSubDivisao $fkPessoalCargoSubDivisao)
    {
        if (false === $this->fkPessoalCargoSubDivisoes->contains($fkPessoalCargoSubDivisao)) {
            $fkPessoalCargoSubDivisao->setFkNormasNorma($this);
            $this->fkPessoalCargoSubDivisoes->add($fkPessoalCargoSubDivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCargoSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CargoSubDivisao $fkPessoalCargoSubDivisao
     */
    public function removeFkPessoalCargoSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\CargoSubDivisao $fkPessoalCargoSubDivisao)
    {
        $this->fkPessoalCargoSubDivisoes->removeElement($fkPessoalCargoSubDivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCargoSubDivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CargoSubDivisao
     */
    public function getFkPessoalCargoSubDivisoes()
    {
        return $this->fkPessoalCargoSubDivisoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return Norma
     */
    public function addFkPessoalContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        if (false === $this->fkPessoalContratoServidores->contains($fkPessoalContratoServidor)) {
            $fkPessoalContratoServidor->setFkNormasNorma($this);
            $this->fkPessoalContratoServidores->add($fkPessoalContratoServidor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     */
    public function removeFkPessoalContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->fkPessoalContratoServidores->removeElement($fkPessoalContratoServidor);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidores()
    {
        return $this->fkPessoalContratoServidores;
    }

    /**
     * OneToMany (owning side)
     * Add SwNomeLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwNomeLogradouro $fkSwNomeLogradouro
     * @return Norma
     */
    public function addFkSwNomeLogradouros(\Urbem\CoreBundle\Entity\SwNomeLogradouro $fkSwNomeLogradouro)
    {
        if (false === $this->fkSwNomeLogradouros->contains($fkSwNomeLogradouro)) {
            $fkSwNomeLogradouro->setFkNormasNorma($this);
            $this->fkSwNomeLogradouros->add($fkSwNomeLogradouro);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwNomeLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwNomeLogradouro $fkSwNomeLogradouro
     */
    public function removeFkSwNomeLogradouros(\Urbem\CoreBundle\Entity\SwNomeLogradouro $fkSwNomeLogradouro)
    {
        $this->fkSwNomeLogradouros->removeElement($fkSwNomeLogradouro);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwNomeLogradouros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwNomeLogradouro
     */
    public function getFkSwNomeLogradouros()
    {
        return $this->fkSwNomeLogradouros;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgTipoRegistroPreco
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoRegistroPreco $fkTcemgTipoRegistroPreco
     * @return Norma
     */
    public function addFkTcemgTipoRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\TipoRegistroPreco $fkTcemgTipoRegistroPreco)
    {
        if (false === $this->fkTcemgTipoRegistroPrecos->contains($fkTcemgTipoRegistroPreco)) {
            $fkTcemgTipoRegistroPreco->setFkNormasNorma($this);
            $this->fkTcemgTipoRegistroPrecos->add($fkTcemgTipoRegistroPreco);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgTipoRegistroPreco
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoRegistroPreco $fkTcemgTipoRegistroPreco
     */
    public function removeFkTcemgTipoRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\TipoRegistroPreco $fkTcemgTipoRegistroPreco)
    {
        $this->fkTcemgTipoRegistroPrecos->removeElement($fkTcemgTipoRegistroPreco);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgTipoRegistroPrecos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\TipoRegistroPreco
     */
    public function getFkTcemgTipoRegistroPrecos()
    {
        return $this->fkTcemgTipoRegistroPrecos;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeDividaFundadaOutraOperacaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOutraOperacaoCredito $fkTcepeDividaFundadaOutraOperacaoCredito
     * @return Norma
     */
    public function addFkTcepeDividaFundadaOutraOperacaoCreditos(\Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOutraOperacaoCredito $fkTcepeDividaFundadaOutraOperacaoCredito)
    {
        if (false === $this->fkTcepeDividaFundadaOutraOperacaoCreditos->contains($fkTcepeDividaFundadaOutraOperacaoCredito)) {
            $fkTcepeDividaFundadaOutraOperacaoCredito->setFkNormasNorma($this);
            $this->fkTcepeDividaFundadaOutraOperacaoCreditos->add($fkTcepeDividaFundadaOutraOperacaoCredito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeDividaFundadaOutraOperacaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOutraOperacaoCredito $fkTcepeDividaFundadaOutraOperacaoCredito
     */
    public function removeFkTcepeDividaFundadaOutraOperacaoCreditos(\Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOutraOperacaoCredito $fkTcepeDividaFundadaOutraOperacaoCredito)
    {
        $this->fkTcepeDividaFundadaOutraOperacaoCreditos->removeElement($fkTcepeDividaFundadaOutraOperacaoCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeDividaFundadaOutraOperacaoCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOutraOperacaoCredito
     */
    public function getFkTcepeDividaFundadaOutraOperacaoCreditos()
    {
        return $this->fkTcepeDividaFundadaOutraOperacaoCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoConfiguracaoLoa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLoa $fkTcmgoConfiguracaoLoa
     * @return Norma
     */
    public function addFkTcmgoConfiguracaoLoas(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLoa $fkTcmgoConfiguracaoLoa)
    {
        if (false === $this->fkTcmgoConfiguracaoLoas->contains($fkTcmgoConfiguracaoLoa)) {
            $fkTcmgoConfiguracaoLoa->setFkNormasNorma($this);
            $this->fkTcmgoConfiguracaoLoas->add($fkTcmgoConfiguracaoLoa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoConfiguracaoLoa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLoa $fkTcmgoConfiguracaoLoa
     */
    public function removeFkTcmgoConfiguracaoLoas(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLoa $fkTcmgoConfiguracaoLoa)
    {
        $this->fkTcmgoConfiguracaoLoas->removeElement($fkTcmgoConfiguracaoLoa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoConfiguracaoLoas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoLoa
     */
    public function getFkTcmgoConfiguracaoLoas()
    {
        return $this->fkTcmgoConfiguracaoLoas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\TipoNorma $fkNormasTipoNorma
     * @return Norma
     */
    public function setFkNormasTipoNorma(\Urbem\CoreBundle\Entity\Normas\TipoNorma $fkNormasTipoNorma)
    {
        $this->codTipoNorma = $fkNormasTipoNorma->getCodTipoNorma();
        $this->fkNormasTipoNorma = $fkNormasTipoNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasTipoNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\TipoNorma
     */
    public function getFkNormasTipoNorma()
    {
        return $this->fkNormasTipoNorma;
    }

    /**
     * OneToOne (inverse side)
     * Set ConcursoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\Edital $fkConcursoEdital
     * @return Norma
     */
    public function setFkConcursoEdital(\Urbem\CoreBundle\Entity\Concurso\Edital $fkConcursoEdital)
    {
        $fkConcursoEdital->setFkNormasNorma($this);
        $this->fkConcursoEdital = $fkConcursoEdital;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkConcursoEdital
     *
     * @return \Urbem\CoreBundle\Entity\Concurso\Edital
     */
    public function getFkConcursoEdital()
    {
        return $this->fkConcursoEdital;
    }

    /**
     * OneToOne (inverse side)
     * Set NormasNormaDataTermino
     *
     * @param \Urbem\CoreBundle\Entity\Normas\NormaDataTermino $fkNormasNormaDataTermino
     * @return Norma
     */
    public function setFkNormasNormaDataTermino(\Urbem\CoreBundle\Entity\Normas\NormaDataTermino $fkNormasNormaDataTermino)
    {
        $fkNormasNormaDataTermino->setFkNormasNorma($this);
        $this->fkNormasNormaDataTermino = $fkNormasNormaDataTermino;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkNormasNormaDataTermino
     *
     * @return \Urbem\CoreBundle\Entity\Normas\NormaDataTermino
     */
    public function getFkNormasNormaDataTermino()
    {
        return $this->fkNormasNormaDataTermino;
    }

    /**
     * OneToOne (inverse side)
     * Set NormasNormaDetalheAl
     *
     * @param \Urbem\CoreBundle\Entity\Normas\NormaDetalheAl $fkNormasNormaDetalheAl
     * @return Norma
     */
    public function setFkNormasNormaDetalheAl(\Urbem\CoreBundle\Entity\Normas\NormaDetalheAl $fkNormasNormaDetalheAl)
    {
        $fkNormasNormaDetalheAl->setFkNormasNorma($this);
        $this->fkNormasNormaDetalheAl = $fkNormasNormaDetalheAl;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkNormasNormaDetalheAl
     *
     * @return \Urbem\CoreBundle\Entity\Normas\NormaDetalheAl
     */
    public function getFkNormasNormaDetalheAl()
    {
        return $this->fkNormasNormaDetalheAl;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgNormaDetalhe
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NormaDetalhe $fkTcemgNormaDetalhe
     * @return Norma
     */
    public function setFkTcemgNormaDetalhe(\Urbem\CoreBundle\Entity\Tcemg\NormaDetalhe $fkTcemgNormaDetalhe)
    {
        $fkTcemgNormaDetalhe->setFkNormasNorma($this);
        $this->fkTcemgNormaDetalhe = $fkTcemgNormaDetalhe;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgNormaDetalhe
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\NormaDetalhe
     */
    public function getFkTcemgNormaDetalhe()
    {
        return $this->fkTcemgNormaDetalhe;
    }

    /**
     * OneToOne (inverse side)
     * Set TcetoNormaDetalhe
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\NormaDetalhe $fkTcetoNormaDetalhe
     * @return Norma
     */
    public function setFkTcetoNormaDetalhe(\Urbem\CoreBundle\Entity\Tceto\NormaDetalhe $fkTcetoNormaDetalhe)
    {
        $fkTcetoNormaDetalhe->setFkNormasNorma($this);
        $this->fkTcetoNormaDetalhe = $fkTcetoNormaDetalhe;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcetoNormaDetalhe
     *
     * @return \Urbem\CoreBundle\Entity\Tceto\NormaDetalhe
     */
    public function getFkTcetoNormaDetalhe()
    {
        return $this->fkTcetoNormaDetalhe;
    }

    /**
     * OneToOne (inverse side)
     * Set NormasNormaCopiaDigital
     *
     * @param \Urbem\CoreBundle\Entity\Normas\NormaCopiaDigital $fkNormasNormaCopiaDigital
     * @return Norma
     */
    public function setFkNormasNormaCopiaDigital(\Urbem\CoreBundle\Entity\Normas\NormaCopiaDigital $fkNormasNormaCopiaDigital)
    {
        $fkNormasNormaCopiaDigital->setFkNormasNorma($this);
        $this->fkNormasNormaCopiaDigital = $fkNormasNormaCopiaDigital;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkNormasNormaCopiaDigital
     *
     * @return \Urbem\CoreBundle\Entity\Normas\NormaCopiaDigital
     */
    public function getFkNormasNormaCopiaDigital()
    {
        return $this->fkNormasNormaCopiaDigital;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s/%s - %s',
            str_pad($this->numNorma, 6, '0', STR_PAD_LEFT),
            $this->exercicio,
            $this->nomNorma
        );
    }
}
