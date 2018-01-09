<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwProcesso
 */
class SwProcesso
{
    const RELATORIO_ETIQUETA = 1;
    const RELATORIO_RECIBO_PROCESSO = 4;
    const RELATORIO_DESPACHO = 5;
    const RELATORIO_DESPACHOS = 3;
    const RELATORIO_ARQUIVAMENTO_PROCESSO_TEMPORARIO = 7;
    const RELATORIO_ARQUIVAMENTO_PROCESSO_DEFINITIVO = 8;

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
     * @var integer
     */
    private $codClassificacao;

    /**
     * @var integer
     */
    private $codAssunto;

    /**
     * @var integer
     */
    private $codUsuario;

    /**
     * @var integer
     */
    private $codSituacao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $observacoes;

    /**
     * @var boolean
     */
    private $confidencial = false;

    /**
     * @var string
     */
    private $resumoAssunto;

    /**
     * @var integer
     */
    private $codCentro;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwUltimoAndamento
     */
    private $fkSwUltimoAndamento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwProcessoArquivado
     */
    private $fkSwProcessoArquivado;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwProcessoFuncionario
     */
    private $fkSwProcessoFuncionario;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwProcessoInscricao
     */
    private $fkSwProcessoInscricao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwProcessoMatricula
     */
    private $fkSwProcessoMatricula;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\DoacaoEmprestimo
     */
    private $fkAlmoxarifadoDoacaoEmprestimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoProcesso
     */
    private $fkArrecadacaoLancamentoProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ProcessoSuspensao
     */
    private $fkArrecadacaoProcessoSuspensoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CompraDiretaProcesso
     */
    private $fkComprasCompraDiretaProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ProcessoCancelamento
     */
    private $fkDividaProcessoCancelamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\RemissaoProcesso
     */
    private $fkDividaRemissaoProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ProcessoEstorno
     */
    private $fkDividaProcessoEstornos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoBaixaCadEconomico
     */
    private $fkEconomicoProcessoBaixaCadEconomicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoBaixaLicenca
     */
    private $fkEconomicoProcessoBaixaLicencas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoCadastroEconomico
     */
    private $fkEconomicoProcessoCadastroEconomicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioFiscal
     */
    private $fkEconomicoProcessoDomicilioFiscais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioInformado
     */
    private $fkEconomicoProcessoDomicilioInformados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoEmpDireitoNatJuridica
     */
    private $fkEconomicoProcessoEmpDireitoNatJuridicas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoLicenca
     */
    private $fkEconomicoProcessoLicencas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoModLancInscEcon
     */
    private $fkEconomicoProcessoModLancInscEcons;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixaProcesso
     */
    private $fkFiscalizacaoInfracaoBaixaProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    private $fkFiscalizacaoProcessoFiscais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixaProcesso
     */
    private $fkFiscalizacaoPenalidadeBaixaProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoLocacao
     */
    private $fkFrotaVeiculoLocacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReformaProcesso
     */
    private $fkImobiliarioConstrucaoReformaProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelProcesso
     */
    private $fkImobiliarioImovelProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoProcesso
     */
    private $fkImobiliarioConstrucaoProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso
     */
    private $fkImobiliarioLoteProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ProcessoLoteamento
     */
    private $fkImobiliarioProcessoLoteamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaProcesso
     */
    private $fkImobiliarioLicencaProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaProcesso
     */
    private $fkImobiliarioTransferenciaProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao
     */
    private $fkLicitacaoPenalidadesCertificacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado
     */
    private $fkLicitacaoEditalImpugnados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemProcesso
     */
    private $fkPatrimonioBemProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaProcesso
     */
    private $fkPessoalContratoPensionistaProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Protocolo\ProcessoHistorico
     */
    private $fkProtocoloProcessoHistoricos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAndamento
     */
    private $fkSwAndamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAssuntoAtributoValor
     */
    private $fkSwAssuntoAtributoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwDocumentoProcesso
     */
    private $fkSwDocumentoProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcessoApensado
     */
    private $fkSwProcessoApensados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcessoAtributoValor
     */
    private $fkSwProcessoAtributoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcessoInteressado
     */
    private $fkSwProcessoInteressados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\Convenio
     */
    private $fkTcernConvenios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\Contrato
     */
    private $fkTcernContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ProcessoPagamento
     */
    private $fkArrecadacaoProcessoPagamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaProcesso
     */
    private $fkDividaDividaProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoDiasCadEcon
     */
    private $fkEconomicoProcessoDiasCadEcons;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoSociedade
     */
    private $fkEconomicoProcessoSociedades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoCessao
     */
    private $fkFrotaVeiculoCessoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\CondominioProcesso
     */
    private $fkImobiliarioCondominioProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcessoConfidencial
     */
    private $fkSwProcessoConfidenciais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ContratoAditivo
     */
    private $fkTcernContratoAditivos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwAssunto
     */
    private $fkSwAssunto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwSituacaoProcesso
     */
    private $fkSwSituacaoProcesso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto
     */
    private $fkAlmoxarifadoCentroCusto;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoDoacaoEmprestimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoLancamentoProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoProcessoSuspensoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasCompraDiretaProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaProcessoCancelamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaRemissaoProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaProcessoEstornos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoProcessoBaixaCadEconomicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoProcessoBaixaLicencas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoProcessoCadastroEconomicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoProcessoDomicilioFiscais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoProcessoDomicilioInformados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoProcessoEmpDireitoNatJuridicas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoProcessoLicencas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoProcessoModLancInscEcons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoInfracaoBaixaProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoProcessoFiscais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoPenalidadeBaixaProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaVeiculoLocacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioConstrucaoReformaProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioImovelProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioConstrucaoProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLoteProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioProcessoLoteamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioTransferenciaProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoPenalidadesCertificacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoEditalImpugnados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioBemProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoPensionistaProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkProtocoloProcessoHistoricos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwAndamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwAssuntoAtributoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwDocumentoProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwProcessoApensados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwProcessoAtributoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwProcessoInteressados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoProcessoPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaDividaProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoProcessoDiasCadEcons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoProcessoSociedades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaVeiculoCessoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioCondominioProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwProcessoConfidenciais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernContratoAditivos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return SwProcesso
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
     * @return SwProcesso
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
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return SwProcesso
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set codAssunto
     *
     * @param integer $codAssunto
     * @return SwProcesso
     */
    public function setCodAssunto($codAssunto)
    {
        $this->codAssunto = $codAssunto;
        return $this;
    }

    /**
     * Get codAssunto
     *
     * @return integer
     */
    public function getCodAssunto()
    {
        return $this->codAssunto;
    }

    /**
     * Set codUsuario
     *
     * @param integer $codUsuario
     * @return SwProcesso
     */
    public function setCodUsuario($codUsuario)
    {
        $this->codUsuario = $codUsuario;
        return $this;
    }

    /**
     * Get codUsuario
     *
     * @return integer
     */
    public function getCodUsuario()
    {
        return $this->codUsuario;
    }

    /**
     * Set codSituacao
     *
     * @param integer $codSituacao
     * @return SwProcesso
     */
    public function setCodSituacao($codSituacao)
    {
        $this->codSituacao = $codSituacao;
        return $this;
    }

    /**
     * Get codSituacao
     *
     * @return integer
     */
    public function getCodSituacao()
    {
        return $this->codSituacao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return SwProcesso
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
     * Set observacoes
     *
     * @param string $observacoes
     * @return SwProcesso
     */
    public function setObservacoes($observacoes)
    {
        $this->observacoes = $observacoes;
        return $this;
    }

    /**
     * Get observacoes
     *
     * @return string
     */
    public function getObservacoes()
    {
        return $this->observacoes;
    }

    /**
     * Set confidencial
     *
     * @param boolean $confidencial
     * @return SwProcesso
     */
    public function setConfidencial($confidencial)
    {
        $this->confidencial = $confidencial;
        return $this;
    }

    /**
     * Get confidencial
     *
     * @return boolean
     */
    public function getConfidencial()
    {
        return $this->confidencial;
    }

    /**
     * Set resumoAssunto
     *
     * @param string $resumoAssunto
     * @return SwProcesso
     */
    public function setResumoAssunto($resumoAssunto)
    {
        $this->resumoAssunto = $resumoAssunto;
        return $this;
    }

    /**
     * Get resumoAssunto
     *
     * @return string
     */
    public function getResumoAssunto()
    {
        return $this->resumoAssunto;
    }

    /**
     * Set codCentro
     *
     * @param integer $codCentro
     * @return SwProcesso
     */
    public function setCodCentro($codCentro = null)
    {
        $this->codCentro = $codCentro;
        return $this;
    }

    /**
     * Get codCentro
     *
     * @return integer
     */
    public function getCodCentro()
    {
        return $this->codCentro;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoDoacaoEmprestimo
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\DoacaoEmprestimo $fkAlmoxarifadoDoacaoEmprestimo
     * @return SwProcesso
     */
    public function addFkAlmoxarifadoDoacaoEmprestimos(\Urbem\CoreBundle\Entity\Almoxarifado\DoacaoEmprestimo $fkAlmoxarifadoDoacaoEmprestimo)
    {
        if (false === $this->fkAlmoxarifadoDoacaoEmprestimos->contains($fkAlmoxarifadoDoacaoEmprestimo)) {
            $fkAlmoxarifadoDoacaoEmprestimo->setFkSwProcesso($this);
            $this->fkAlmoxarifadoDoacaoEmprestimos->add($fkAlmoxarifadoDoacaoEmprestimo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoDoacaoEmprestimo
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\DoacaoEmprestimo $fkAlmoxarifadoDoacaoEmprestimo
     */
    public function removeFkAlmoxarifadoDoacaoEmprestimos(\Urbem\CoreBundle\Entity\Almoxarifado\DoacaoEmprestimo $fkAlmoxarifadoDoacaoEmprestimo)
    {
        $this->fkAlmoxarifadoDoacaoEmprestimos->removeElement($fkAlmoxarifadoDoacaoEmprestimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoDoacaoEmprestimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\DoacaoEmprestimo
     */
    public function getFkAlmoxarifadoDoacaoEmprestimos()
    {
        return $this->fkAlmoxarifadoDoacaoEmprestimos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoLancamentoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoProcesso $fkArrecadacaoLancamentoProcesso
     * @return SwProcesso
     */
    public function addFkArrecadacaoLancamentoProcessos(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoProcesso $fkArrecadacaoLancamentoProcesso)
    {
        if (false === $this->fkArrecadacaoLancamentoProcessos->contains($fkArrecadacaoLancamentoProcesso)) {
            $fkArrecadacaoLancamentoProcesso->setFkSwProcesso($this);
            $this->fkArrecadacaoLancamentoProcessos->add($fkArrecadacaoLancamentoProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoLancamentoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoProcesso $fkArrecadacaoLancamentoProcesso
     */
    public function removeFkArrecadacaoLancamentoProcessos(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoProcesso $fkArrecadacaoLancamentoProcesso)
    {
        $this->fkArrecadacaoLancamentoProcessos->removeElement($fkArrecadacaoLancamentoProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoLancamentoProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoProcesso
     */
    public function getFkArrecadacaoLancamentoProcessos()
    {
        return $this->fkArrecadacaoLancamentoProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoProcessoSuspensao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ProcessoSuspensao $fkArrecadacaoProcessoSuspensao
     * @return SwProcesso
     */
    public function addFkArrecadacaoProcessoSuspensoes(\Urbem\CoreBundle\Entity\Arrecadacao\ProcessoSuspensao $fkArrecadacaoProcessoSuspensao)
    {
        if (false === $this->fkArrecadacaoProcessoSuspensoes->contains($fkArrecadacaoProcessoSuspensao)) {
            $fkArrecadacaoProcessoSuspensao->setFkSwProcesso($this);
            $this->fkArrecadacaoProcessoSuspensoes->add($fkArrecadacaoProcessoSuspensao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoProcessoSuspensao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ProcessoSuspensao $fkArrecadacaoProcessoSuspensao
     */
    public function removeFkArrecadacaoProcessoSuspensoes(\Urbem\CoreBundle\Entity\Arrecadacao\ProcessoSuspensao $fkArrecadacaoProcessoSuspensao)
    {
        $this->fkArrecadacaoProcessoSuspensoes->removeElement($fkArrecadacaoProcessoSuspensao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoProcessoSuspensoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ProcessoSuspensao
     */
    public function getFkArrecadacaoProcessoSuspensoes()
    {
        return $this->fkArrecadacaoProcessoSuspensoes;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasCompraDiretaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDiretaProcesso $fkComprasCompraDiretaProcesso
     * @return SwProcesso
     */
    public function addFkComprasCompraDiretaProcessos(\Urbem\CoreBundle\Entity\Compras\CompraDiretaProcesso $fkComprasCompraDiretaProcesso)
    {
        if (false === $this->fkComprasCompraDiretaProcessos->contains($fkComprasCompraDiretaProcesso)) {
            $fkComprasCompraDiretaProcesso->setFkSwProcesso($this);
            $this->fkComprasCompraDiretaProcessos->add($fkComprasCompraDiretaProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasCompraDiretaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDiretaProcesso $fkComprasCompraDiretaProcesso
     */
    public function removeFkComprasCompraDiretaProcessos(\Urbem\CoreBundle\Entity\Compras\CompraDiretaProcesso $fkComprasCompraDiretaProcesso)
    {
        $this->fkComprasCompraDiretaProcessos->removeElement($fkComprasCompraDiretaProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasCompraDiretaProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CompraDiretaProcesso
     */
    public function getFkComprasCompraDiretaProcessos()
    {
        return $this->fkComprasCompraDiretaProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaProcessoCancelamento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ProcessoCancelamento $fkDividaProcessoCancelamento
     * @return SwProcesso
     */
    public function addFkDividaProcessoCancelamentos(\Urbem\CoreBundle\Entity\Divida\ProcessoCancelamento $fkDividaProcessoCancelamento)
    {
        if (false === $this->fkDividaProcessoCancelamentos->contains($fkDividaProcessoCancelamento)) {
            $fkDividaProcessoCancelamento->setFkSwProcesso($this);
            $this->fkDividaProcessoCancelamentos->add($fkDividaProcessoCancelamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaProcessoCancelamento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ProcessoCancelamento $fkDividaProcessoCancelamento
     */
    public function removeFkDividaProcessoCancelamentos(\Urbem\CoreBundle\Entity\Divida\ProcessoCancelamento $fkDividaProcessoCancelamento)
    {
        $this->fkDividaProcessoCancelamentos->removeElement($fkDividaProcessoCancelamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaProcessoCancelamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ProcessoCancelamento
     */
    public function getFkDividaProcessoCancelamentos()
    {
        return $this->fkDividaProcessoCancelamentos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaRemissaoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Divida\RemissaoProcesso $fkDividaRemissaoProcesso
     * @return SwProcesso
     */
    public function addFkDividaRemissaoProcessos(\Urbem\CoreBundle\Entity\Divida\RemissaoProcesso $fkDividaRemissaoProcesso)
    {
        if (false === $this->fkDividaRemissaoProcessos->contains($fkDividaRemissaoProcesso)) {
            $fkDividaRemissaoProcesso->setFkSwProcesso($this);
            $this->fkDividaRemissaoProcessos->add($fkDividaRemissaoProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaRemissaoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Divida\RemissaoProcesso $fkDividaRemissaoProcesso
     */
    public function removeFkDividaRemissaoProcessos(\Urbem\CoreBundle\Entity\Divida\RemissaoProcesso $fkDividaRemissaoProcesso)
    {
        $this->fkDividaRemissaoProcessos->removeElement($fkDividaRemissaoProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaRemissaoProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\RemissaoProcesso
     */
    public function getFkDividaRemissaoProcessos()
    {
        return $this->fkDividaRemissaoProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaProcessoEstorno
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ProcessoEstorno $fkDividaProcessoEstorno
     * @return SwProcesso
     */
    public function addFkDividaProcessoEstornos(\Urbem\CoreBundle\Entity\Divida\ProcessoEstorno $fkDividaProcessoEstorno)
    {
        if (false === $this->fkDividaProcessoEstornos->contains($fkDividaProcessoEstorno)) {
            $fkDividaProcessoEstorno->setFkSwProcesso($this);
            $this->fkDividaProcessoEstornos->add($fkDividaProcessoEstorno);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaProcessoEstorno
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ProcessoEstorno $fkDividaProcessoEstorno
     */
    public function removeFkDividaProcessoEstornos(\Urbem\CoreBundle\Entity\Divida\ProcessoEstorno $fkDividaProcessoEstorno)
    {
        $this->fkDividaProcessoEstornos->removeElement($fkDividaProcessoEstorno);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaProcessoEstornos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ProcessoEstorno
     */
    public function getFkDividaProcessoEstornos()
    {
        return $this->fkDividaProcessoEstornos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoBaixaCadEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoBaixaCadEconomico $fkEconomicoProcessoBaixaCadEconomico
     * @return SwProcesso
     */
    public function addFkEconomicoProcessoBaixaCadEconomicos(\Urbem\CoreBundle\Entity\Economico\ProcessoBaixaCadEconomico $fkEconomicoProcessoBaixaCadEconomico)
    {
        if (false === $this->fkEconomicoProcessoBaixaCadEconomicos->contains($fkEconomicoProcessoBaixaCadEconomico)) {
            $fkEconomicoProcessoBaixaCadEconomico->setFkSwProcesso($this);
            $this->fkEconomicoProcessoBaixaCadEconomicos->add($fkEconomicoProcessoBaixaCadEconomico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoBaixaCadEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoBaixaCadEconomico $fkEconomicoProcessoBaixaCadEconomico
     */
    public function removeFkEconomicoProcessoBaixaCadEconomicos(\Urbem\CoreBundle\Entity\Economico\ProcessoBaixaCadEconomico $fkEconomicoProcessoBaixaCadEconomico)
    {
        $this->fkEconomicoProcessoBaixaCadEconomicos->removeElement($fkEconomicoProcessoBaixaCadEconomico);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoBaixaCadEconomicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoBaixaCadEconomico
     */
    public function getFkEconomicoProcessoBaixaCadEconomicos()
    {
        return $this->fkEconomicoProcessoBaixaCadEconomicos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoBaixaLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoBaixaLicenca $fkEconomicoProcessoBaixaLicenca
     * @return SwProcesso
     */
    public function addFkEconomicoProcessoBaixaLicencas(\Urbem\CoreBundle\Entity\Economico\ProcessoBaixaLicenca $fkEconomicoProcessoBaixaLicenca)
    {
        if (false === $this->fkEconomicoProcessoBaixaLicencas->contains($fkEconomicoProcessoBaixaLicenca)) {
            $fkEconomicoProcessoBaixaLicenca->setFkSwProcesso($this);
            $this->fkEconomicoProcessoBaixaLicencas->add($fkEconomicoProcessoBaixaLicenca);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoBaixaLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoBaixaLicenca $fkEconomicoProcessoBaixaLicenca
     */
    public function removeFkEconomicoProcessoBaixaLicencas(\Urbem\CoreBundle\Entity\Economico\ProcessoBaixaLicenca $fkEconomicoProcessoBaixaLicenca)
    {
        $this->fkEconomicoProcessoBaixaLicencas->removeElement($fkEconomicoProcessoBaixaLicenca);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoBaixaLicencas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoBaixaLicenca
     */
    public function getFkEconomicoProcessoBaixaLicencas()
    {
        return $this->fkEconomicoProcessoBaixaLicencas;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoCadastroEconomico $fkEconomicoProcessoCadastroEconomico
     * @return SwProcesso
     */
    public function addFkEconomicoProcessoCadastroEconomicos(\Urbem\CoreBundle\Entity\Economico\ProcessoCadastroEconomico $fkEconomicoProcessoCadastroEconomico)
    {
        if (false === $this->fkEconomicoProcessoCadastroEconomicos->contains($fkEconomicoProcessoCadastroEconomico)) {
            $fkEconomicoProcessoCadastroEconomico->setFkSwProcesso($this);
            $this->fkEconomicoProcessoCadastroEconomicos->add($fkEconomicoProcessoCadastroEconomico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoCadastroEconomico $fkEconomicoProcessoCadastroEconomico
     */
    public function removeFkEconomicoProcessoCadastroEconomicos(\Urbem\CoreBundle\Entity\Economico\ProcessoCadastroEconomico $fkEconomicoProcessoCadastroEconomico)
    {
        $this->fkEconomicoProcessoCadastroEconomicos->removeElement($fkEconomicoProcessoCadastroEconomico);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoCadastroEconomicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoCadastroEconomico
     */
    public function getFkEconomicoProcessoCadastroEconomicos()
    {
        return $this->fkEconomicoProcessoCadastroEconomicos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoDomicilioFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioFiscal $fkEconomicoProcessoDomicilioFiscal
     * @return SwProcesso
     */
    public function addFkEconomicoProcessoDomicilioFiscais(\Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioFiscal $fkEconomicoProcessoDomicilioFiscal)
    {
        if (false === $this->fkEconomicoProcessoDomicilioFiscais->contains($fkEconomicoProcessoDomicilioFiscal)) {
            $fkEconomicoProcessoDomicilioFiscal->setFkSwProcesso($this);
            $this->fkEconomicoProcessoDomicilioFiscais->add($fkEconomicoProcessoDomicilioFiscal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoDomicilioFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioFiscal $fkEconomicoProcessoDomicilioFiscal
     */
    public function removeFkEconomicoProcessoDomicilioFiscais(\Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioFiscal $fkEconomicoProcessoDomicilioFiscal)
    {
        $this->fkEconomicoProcessoDomicilioFiscais->removeElement($fkEconomicoProcessoDomicilioFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoDomicilioFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioFiscal
     */
    public function getFkEconomicoProcessoDomicilioFiscais()
    {
        return $this->fkEconomicoProcessoDomicilioFiscais;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoDomicilioInformado
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioInformado $fkEconomicoProcessoDomicilioInformado
     * @return SwProcesso
     */
    public function addFkEconomicoProcessoDomicilioInformados(\Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioInformado $fkEconomicoProcessoDomicilioInformado)
    {
        if (false === $this->fkEconomicoProcessoDomicilioInformados->contains($fkEconomicoProcessoDomicilioInformado)) {
            $fkEconomicoProcessoDomicilioInformado->setFkSwProcesso($this);
            $this->fkEconomicoProcessoDomicilioInformados->add($fkEconomicoProcessoDomicilioInformado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoDomicilioInformado
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioInformado $fkEconomicoProcessoDomicilioInformado
     */
    public function removeFkEconomicoProcessoDomicilioInformados(\Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioInformado $fkEconomicoProcessoDomicilioInformado)
    {
        $this->fkEconomicoProcessoDomicilioInformados->removeElement($fkEconomicoProcessoDomicilioInformado);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoDomicilioInformados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioInformado
     */
    public function getFkEconomicoProcessoDomicilioInformados()
    {
        return $this->fkEconomicoProcessoDomicilioInformados;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoEmpDireitoNatJuridica
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoEmpDireitoNatJuridica $fkEconomicoProcessoEmpDireitoNatJuridica
     * @return SwProcesso
     */
    public function addFkEconomicoProcessoEmpDireitoNatJuridicas(\Urbem\CoreBundle\Entity\Economico\ProcessoEmpDireitoNatJuridica $fkEconomicoProcessoEmpDireitoNatJuridica)
    {
        if (false === $this->fkEconomicoProcessoEmpDireitoNatJuridicas->contains($fkEconomicoProcessoEmpDireitoNatJuridica)) {
            $fkEconomicoProcessoEmpDireitoNatJuridica->setFkSwProcesso($this);
            $this->fkEconomicoProcessoEmpDireitoNatJuridicas->add($fkEconomicoProcessoEmpDireitoNatJuridica);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoEmpDireitoNatJuridica
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoEmpDireitoNatJuridica $fkEconomicoProcessoEmpDireitoNatJuridica
     */
    public function removeFkEconomicoProcessoEmpDireitoNatJuridicas(\Urbem\CoreBundle\Entity\Economico\ProcessoEmpDireitoNatJuridica $fkEconomicoProcessoEmpDireitoNatJuridica)
    {
        $this->fkEconomicoProcessoEmpDireitoNatJuridicas->removeElement($fkEconomicoProcessoEmpDireitoNatJuridica);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoEmpDireitoNatJuridicas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoEmpDireitoNatJuridica
     */
    public function getFkEconomicoProcessoEmpDireitoNatJuridicas()
    {
        return $this->fkEconomicoProcessoEmpDireitoNatJuridicas;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoLicenca $fkEconomicoProcessoLicenca
     * @return SwProcesso
     */
    public function addFkEconomicoProcessoLicencas(\Urbem\CoreBundle\Entity\Economico\ProcessoLicenca $fkEconomicoProcessoLicenca)
    {
        if (false === $this->fkEconomicoProcessoLicencas->contains($fkEconomicoProcessoLicenca)) {
            $fkEconomicoProcessoLicenca->setFkSwProcesso($this);
            $this->fkEconomicoProcessoLicencas->add($fkEconomicoProcessoLicenca);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoLicenca $fkEconomicoProcessoLicenca
     */
    public function removeFkEconomicoProcessoLicencas(\Urbem\CoreBundle\Entity\Economico\ProcessoLicenca $fkEconomicoProcessoLicenca)
    {
        $this->fkEconomicoProcessoLicencas->removeElement($fkEconomicoProcessoLicenca);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoLicencas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoLicenca
     */
    public function getFkEconomicoProcessoLicencas()
    {
        return $this->fkEconomicoProcessoLicencas;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoModLancInscEcon
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoModLancInscEcon $fkEconomicoProcessoModLancInscEcon
     * @return SwProcesso
     */
    public function addFkEconomicoProcessoModLancInscEcons(\Urbem\CoreBundle\Entity\Economico\ProcessoModLancInscEcon $fkEconomicoProcessoModLancInscEcon)
    {
        if (false === $this->fkEconomicoProcessoModLancInscEcons->contains($fkEconomicoProcessoModLancInscEcon)) {
            $fkEconomicoProcessoModLancInscEcon->setFkSwProcesso($this);
            $this->fkEconomicoProcessoModLancInscEcons->add($fkEconomicoProcessoModLancInscEcon);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoModLancInscEcon
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoModLancInscEcon $fkEconomicoProcessoModLancInscEcon
     */
    public function removeFkEconomicoProcessoModLancInscEcons(\Urbem\CoreBundle\Entity\Economico\ProcessoModLancInscEcon $fkEconomicoProcessoModLancInscEcon)
    {
        $this->fkEconomicoProcessoModLancInscEcons->removeElement($fkEconomicoProcessoModLancInscEcon);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoModLancInscEcons
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoModLancInscEcon
     */
    public function getFkEconomicoProcessoModLancInscEcons()
    {
        return $this->fkEconomicoProcessoModLancInscEcons;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoInfracaoBaixaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixaProcesso $fkFiscalizacaoInfracaoBaixaProcesso
     * @return SwProcesso
     */
    public function addFkFiscalizacaoInfracaoBaixaProcessos(\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixaProcesso $fkFiscalizacaoInfracaoBaixaProcesso)
    {
        if (false === $this->fkFiscalizacaoInfracaoBaixaProcessos->contains($fkFiscalizacaoInfracaoBaixaProcesso)) {
            $fkFiscalizacaoInfracaoBaixaProcesso->setFkSwProcesso($this);
            $this->fkFiscalizacaoInfracaoBaixaProcessos->add($fkFiscalizacaoInfracaoBaixaProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoInfracaoBaixaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixaProcesso $fkFiscalizacaoInfracaoBaixaProcesso
     */
    public function removeFkFiscalizacaoInfracaoBaixaProcessos(\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixaProcesso $fkFiscalizacaoInfracaoBaixaProcesso)
    {
        $this->fkFiscalizacaoInfracaoBaixaProcessos->removeElement($fkFiscalizacaoInfracaoBaixaProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoInfracaoBaixaProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixaProcesso
     */
    public function getFkFiscalizacaoInfracaoBaixaProcessos()
    {
        return $this->fkFiscalizacaoInfracaoBaixaProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal
     * @return SwProcesso
     */
    public function addFkFiscalizacaoProcessoFiscais(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal)
    {
        if (false === $this->fkFiscalizacaoProcessoFiscais->contains($fkFiscalizacaoProcessoFiscal)) {
            $fkFiscalizacaoProcessoFiscal->setFkSwProcesso($this);
            $this->fkFiscalizacaoProcessoFiscais->add($fkFiscalizacaoProcessoFiscal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal
     */
    public function removeFkFiscalizacaoProcessoFiscais(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal)
    {
        $this->fkFiscalizacaoProcessoFiscais->removeElement($fkFiscalizacaoProcessoFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoProcessoFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    public function getFkFiscalizacaoProcessoFiscais()
    {
        return $this->fkFiscalizacaoProcessoFiscais;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoPenalidadeBaixaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixaProcesso $fkFiscalizacaoPenalidadeBaixaProcesso
     * @return SwProcesso
     */
    public function addFkFiscalizacaoPenalidadeBaixaProcessos(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixaProcesso $fkFiscalizacaoPenalidadeBaixaProcesso)
    {
        if (false === $this->fkFiscalizacaoPenalidadeBaixaProcessos->contains($fkFiscalizacaoPenalidadeBaixaProcesso)) {
            $fkFiscalizacaoPenalidadeBaixaProcesso->setFkSwProcesso($this);
            $this->fkFiscalizacaoPenalidadeBaixaProcessos->add($fkFiscalizacaoPenalidadeBaixaProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoPenalidadeBaixaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixaProcesso $fkFiscalizacaoPenalidadeBaixaProcesso
     */
    public function removeFkFiscalizacaoPenalidadeBaixaProcessos(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixaProcesso $fkFiscalizacaoPenalidadeBaixaProcesso)
    {
        $this->fkFiscalizacaoPenalidadeBaixaProcessos->removeElement($fkFiscalizacaoPenalidadeBaixaProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoPenalidadeBaixaProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixaProcesso
     */
    public function getFkFiscalizacaoPenalidadeBaixaProcessos()
    {
        return $this->fkFiscalizacaoPenalidadeBaixaProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaVeiculoLocacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoLocacao $fkFrotaVeiculoLocacao
     * @return SwProcesso
     */
    public function addFkFrotaVeiculoLocacoes(\Urbem\CoreBundle\Entity\Frota\VeiculoLocacao $fkFrotaVeiculoLocacao)
    {
        if (false === $this->fkFrotaVeiculoLocacoes->contains($fkFrotaVeiculoLocacao)) {
            $fkFrotaVeiculoLocacao->setFkSwProcesso($this);
            $this->fkFrotaVeiculoLocacoes->add($fkFrotaVeiculoLocacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculoLocacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoLocacao $fkFrotaVeiculoLocacao
     */
    public function removeFkFrotaVeiculoLocacoes(\Urbem\CoreBundle\Entity\Frota\VeiculoLocacao $fkFrotaVeiculoLocacao)
    {
        $this->fkFrotaVeiculoLocacoes->removeElement($fkFrotaVeiculoLocacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculoLocacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoLocacao
     */
    public function getFkFrotaVeiculoLocacoes()
    {
        return $this->fkFrotaVeiculoLocacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioConstrucaoReformaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReformaProcesso $fkImobiliarioConstrucaoReformaProcesso
     * @return SwProcesso
     */
    public function addFkImobiliarioConstrucaoReformaProcessos(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReformaProcesso $fkImobiliarioConstrucaoReformaProcesso)
    {
        if (false === $this->fkImobiliarioConstrucaoReformaProcessos->contains($fkImobiliarioConstrucaoReformaProcesso)) {
            $fkImobiliarioConstrucaoReformaProcesso->setFkSwProcesso($this);
            $this->fkImobiliarioConstrucaoReformaProcessos->add($fkImobiliarioConstrucaoReformaProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioConstrucaoReformaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReformaProcesso $fkImobiliarioConstrucaoReformaProcesso
     */
    public function removeFkImobiliarioConstrucaoReformaProcessos(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReformaProcesso $fkImobiliarioConstrucaoReformaProcesso)
    {
        $this->fkImobiliarioConstrucaoReformaProcessos->removeElement($fkImobiliarioConstrucaoReformaProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioConstrucaoReformaProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReformaProcesso
     */
    public function getFkImobiliarioConstrucaoReformaProcessos()
    {
        return $this->fkImobiliarioConstrucaoReformaProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioImovelProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelProcesso $fkImobiliarioImovelProcesso
     * @return SwProcesso
     */
    public function addFkImobiliarioImovelProcessos(\Urbem\CoreBundle\Entity\Imobiliario\ImovelProcesso $fkImobiliarioImovelProcesso)
    {
        if (false === $this->fkImobiliarioImovelProcessos->contains($fkImobiliarioImovelProcesso)) {
            $fkImobiliarioImovelProcesso->setFkSwProcesso($this);
            $this->fkImobiliarioImovelProcessos->add($fkImobiliarioImovelProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioImovelProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelProcesso $fkImobiliarioImovelProcesso
     */
    public function removeFkImobiliarioImovelProcessos(\Urbem\CoreBundle\Entity\Imobiliario\ImovelProcesso $fkImobiliarioImovelProcesso)
    {
        $this->fkImobiliarioImovelProcessos->removeElement($fkImobiliarioImovelProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioImovelProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelProcesso
     */
    public function getFkImobiliarioImovelProcessos()
    {
        return $this->fkImobiliarioImovelProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioConstrucaoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoProcesso $fkImobiliarioConstrucaoProcesso
     * @return SwProcesso
     */
    public function addFkImobiliarioConstrucaoProcessos(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoProcesso $fkImobiliarioConstrucaoProcesso)
    {
        if (false === $this->fkImobiliarioConstrucaoProcessos->contains($fkImobiliarioConstrucaoProcesso)) {
            $fkImobiliarioConstrucaoProcesso->setFkSwProcesso($this);
            $this->fkImobiliarioConstrucaoProcessos->add($fkImobiliarioConstrucaoProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioConstrucaoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoProcesso $fkImobiliarioConstrucaoProcesso
     */
    public function removeFkImobiliarioConstrucaoProcessos(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoProcesso $fkImobiliarioConstrucaoProcesso)
    {
        $this->fkImobiliarioConstrucaoProcessos->removeElement($fkImobiliarioConstrucaoProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioConstrucaoProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoProcesso
     */
    public function getFkImobiliarioConstrucaoProcessos()
    {
        return $this->fkImobiliarioConstrucaoProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLoteProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso $fkImobiliarioLoteProcesso
     * @return SwProcesso
     */
    public function addFkImobiliarioLoteProcessos(\Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso $fkImobiliarioLoteProcesso)
    {
        if (false === $this->fkImobiliarioLoteProcessos->contains($fkImobiliarioLoteProcesso)) {
            $fkImobiliarioLoteProcesso->setFkSwProcesso($this);
            $this->fkImobiliarioLoteProcessos->add($fkImobiliarioLoteProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLoteProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso $fkImobiliarioLoteProcesso
     */
    public function removeFkImobiliarioLoteProcessos(\Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso $fkImobiliarioLoteProcesso)
    {
        $this->fkImobiliarioLoteProcessos->removeElement($fkImobiliarioLoteProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLoteProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso
     */
    public function getFkImobiliarioLoteProcessos()
    {
        return $this->fkImobiliarioLoteProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioProcessoLoteamento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ProcessoLoteamento $fkImobiliarioProcessoLoteamento
     * @return SwProcesso
     */
    public function addFkImobiliarioProcessoLoteamentos(\Urbem\CoreBundle\Entity\Imobiliario\ProcessoLoteamento $fkImobiliarioProcessoLoteamento)
    {
        if (false === $this->fkImobiliarioProcessoLoteamentos->contains($fkImobiliarioProcessoLoteamento)) {
            $fkImobiliarioProcessoLoteamento->setFkSwProcesso($this);
            $this->fkImobiliarioProcessoLoteamentos->add($fkImobiliarioProcessoLoteamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioProcessoLoteamento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ProcessoLoteamento $fkImobiliarioProcessoLoteamento
     */
    public function removeFkImobiliarioProcessoLoteamentos(\Urbem\CoreBundle\Entity\Imobiliario\ProcessoLoteamento $fkImobiliarioProcessoLoteamento)
    {
        $this->fkImobiliarioProcessoLoteamentos->removeElement($fkImobiliarioProcessoLoteamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioProcessoLoteamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ProcessoLoteamento
     */
    public function getFkImobiliarioProcessoLoteamentos()
    {
        return $this->fkImobiliarioProcessoLoteamentos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaProcesso $fkImobiliarioLicencaProcesso
     * @return SwProcesso
     */
    public function addFkImobiliarioLicencaProcessos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaProcesso $fkImobiliarioLicencaProcesso)
    {
        if (false === $this->fkImobiliarioLicencaProcessos->contains($fkImobiliarioLicencaProcesso)) {
            $fkImobiliarioLicencaProcesso->setFkSwProcesso($this);
            $this->fkImobiliarioLicencaProcessos->add($fkImobiliarioLicencaProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaProcesso $fkImobiliarioLicencaProcesso
     */
    public function removeFkImobiliarioLicencaProcessos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaProcesso $fkImobiliarioLicencaProcesso)
    {
        $this->fkImobiliarioLicencaProcessos->removeElement($fkImobiliarioLicencaProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaProcesso
     */
    public function getFkImobiliarioLicencaProcessos()
    {
        return $this->fkImobiliarioLicencaProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTransferenciaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaProcesso $fkImobiliarioTransferenciaProcesso
     * @return SwProcesso
     */
    public function addFkImobiliarioTransferenciaProcessos(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaProcesso $fkImobiliarioTransferenciaProcesso)
    {
        if (false === $this->fkImobiliarioTransferenciaProcessos->contains($fkImobiliarioTransferenciaProcesso)) {
            $fkImobiliarioTransferenciaProcesso->setFkSwProcesso($this);
            $this->fkImobiliarioTransferenciaProcessos->add($fkImobiliarioTransferenciaProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTransferenciaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaProcesso $fkImobiliarioTransferenciaProcesso
     */
    public function removeFkImobiliarioTransferenciaProcessos(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaProcesso $fkImobiliarioTransferenciaProcesso)
    {
        $this->fkImobiliarioTransferenciaProcessos->removeElement($fkImobiliarioTransferenciaProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTransferenciaProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaProcesso
     */
    public function getFkImobiliarioTransferenciaProcessos()
    {
        return $this->fkImobiliarioTransferenciaProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return SwProcesso
     */
    public function addFkLicitacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        if (false === $this->fkLicitacaoLicitacoes->contains($fkLicitacaoLicitacao)) {
            $fkLicitacaoLicitacao->setFkSwProcesso($this);
            $this->fkLicitacaoLicitacoes->add($fkLicitacaoLicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     */
    public function removeFkLicitacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        $this->fkLicitacaoLicitacoes->removeElement($fkLicitacaoLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoLicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    public function getFkLicitacaoLicitacoes()
    {
        return $this->fkLicitacaoLicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoPenalidadesCertificacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao $fkLicitacaoPenalidadesCertificacao
     * @return SwProcesso
     */
    public function addFkLicitacaoPenalidadesCertificacoes(\Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao $fkLicitacaoPenalidadesCertificacao)
    {
        if (false === $this->fkLicitacaoPenalidadesCertificacoes->contains($fkLicitacaoPenalidadesCertificacao)) {
            $fkLicitacaoPenalidadesCertificacao->setFkSwProcesso($this);
            $this->fkLicitacaoPenalidadesCertificacoes->add($fkLicitacaoPenalidadesCertificacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoPenalidadesCertificacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao $fkLicitacaoPenalidadesCertificacao
     */
    public function removeFkLicitacaoPenalidadesCertificacoes(\Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao $fkLicitacaoPenalidadesCertificacao)
    {
        $this->fkLicitacaoPenalidadesCertificacoes->removeElement($fkLicitacaoPenalidadesCertificacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoPenalidadesCertificacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao
     */
    public function getFkLicitacaoPenalidadesCertificacoes()
    {
        return $this->fkLicitacaoPenalidadesCertificacoes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoEditalImpugnado
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado $fkLicitacaoEditalImpugnado
     * @return SwProcesso
     */
    public function addFkLicitacaoEditalImpugnados(\Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado $fkLicitacaoEditalImpugnado)
    {
        if (false === $this->fkLicitacaoEditalImpugnados->contains($fkLicitacaoEditalImpugnado)) {
            $fkLicitacaoEditalImpugnado->setFkSwProcesso($this);
            $this->fkLicitacaoEditalImpugnados->add($fkLicitacaoEditalImpugnado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoEditalImpugnado
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado $fkLicitacaoEditalImpugnado
     */
    public function removeFkLicitacaoEditalImpugnados(\Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado $fkLicitacaoEditalImpugnado)
    {
        $this->fkLicitacaoEditalImpugnados->removeElement($fkLicitacaoEditalImpugnado);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoEditalImpugnados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado
     */
    public function getFkLicitacaoEditalImpugnados()
    {
        return $this->fkLicitacaoEditalImpugnados;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioBemProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemProcesso $fkPatrimonioBemProcesso
     * @return SwProcesso
     */
    public function addFkPatrimonioBemProcessos(\Urbem\CoreBundle\Entity\Patrimonio\BemProcesso $fkPatrimonioBemProcesso)
    {
        if (false === $this->fkPatrimonioBemProcessos->contains($fkPatrimonioBemProcesso)) {
            $fkPatrimonioBemProcesso->setFkSwProcesso($this);
            $this->fkPatrimonioBemProcessos->add($fkPatrimonioBemProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioBemProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemProcesso $fkPatrimonioBemProcesso
     */
    public function removeFkPatrimonioBemProcessos(\Urbem\CoreBundle\Entity\Patrimonio\BemProcesso $fkPatrimonioBemProcesso)
    {
        $this->fkPatrimonioBemProcessos->removeElement($fkPatrimonioBemProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioBemProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemProcesso
     */
    public function getFkPatrimonioBemProcessos()
    {
        return $this->fkPatrimonioBemProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoPensionistaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaProcesso $fkPessoalContratoPensionistaProcesso
     * @return SwProcesso
     */
    public function addFkPessoalContratoPensionistaProcessos(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaProcesso $fkPessoalContratoPensionistaProcesso)
    {
        if (false === $this->fkPessoalContratoPensionistaProcessos->contains($fkPessoalContratoPensionistaProcesso)) {
            $fkPessoalContratoPensionistaProcesso->setFkSwProcesso($this);
            $this->fkPessoalContratoPensionistaProcessos->add($fkPessoalContratoPensionistaProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoPensionistaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaProcesso $fkPessoalContratoPensionistaProcesso
     */
    public function removeFkPessoalContratoPensionistaProcessos(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaProcesso $fkPessoalContratoPensionistaProcesso)
    {
        $this->fkPessoalContratoPensionistaProcessos->removeElement($fkPessoalContratoPensionistaProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoPensionistaProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaProcesso
     */
    public function getFkPessoalContratoPensionistaProcessos()
    {
        return $this->fkPessoalContratoPensionistaProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add ProtocoloProcessoHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Protocolo\ProcessoHistorico $fkProtocoloProcessoHistorico
     * @return SwProcesso
     */
    public function addFkProtocoloProcessoHistoricos(\Urbem\CoreBundle\Entity\Protocolo\ProcessoHistorico $fkProtocoloProcessoHistorico)
    {
        if (false === $this->fkProtocoloProcessoHistoricos->contains($fkProtocoloProcessoHistorico)) {
            $fkProtocoloProcessoHistorico->setFkSwProcesso($this);
            $this->fkProtocoloProcessoHistoricos->add($fkProtocoloProcessoHistorico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ProtocoloProcessoHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Protocolo\ProcessoHistorico $fkProtocoloProcessoHistorico
     */
    public function removeFkProtocoloProcessoHistoricos(\Urbem\CoreBundle\Entity\Protocolo\ProcessoHistorico $fkProtocoloProcessoHistorico)
    {
        $this->fkProtocoloProcessoHistoricos->removeElement($fkProtocoloProcessoHistorico);
    }

    /**
     * OneToMany (owning side)
     * Get fkProtocoloProcessoHistoricos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Protocolo\ProcessoHistorico
     */
    public function getFkProtocoloProcessoHistoricos()
    {
        return $this->fkProtocoloProcessoHistoricos;
    }

    /**
     * OneToMany (owning side)
     * Add SwAndamento
     *
     * @param \Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento
     * @return SwProcesso
     */
    public function addFkSwAndamentos(\Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento)
    {
        if (false === $this->fkSwAndamentos->contains($fkSwAndamento)) {
            $fkSwAndamento->setFkSwProcesso($this);
            $this->fkSwAndamentos->add($fkSwAndamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwAndamento
     *
     * @param \Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento
     */
    public function removeFkSwAndamentos(\Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento)
    {
        $this->fkSwAndamentos->removeElement($fkSwAndamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwAndamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAndamento
     */
    public function getFkSwAndamentos()
    {
        return $this->fkSwAndamentos;
    }

    /**
     * OneToMany (owning side)
     * Add SwAssuntoAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\SwAssuntoAtributoValor $fkSwAssuntoAtributoValor
     * @return SwProcesso
     */
    public function addFkSwAssuntoAtributoValores(\Urbem\CoreBundle\Entity\SwAssuntoAtributoValor $fkSwAssuntoAtributoValor)
    {
        if (false === $this->fkSwAssuntoAtributoValores->contains($fkSwAssuntoAtributoValor)) {
            $fkSwAssuntoAtributoValor->setFkSwProcesso($this);
            $this->fkSwAssuntoAtributoValores->add($fkSwAssuntoAtributoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwAssuntoAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\SwAssuntoAtributoValor $fkSwAssuntoAtributoValor
     */
    public function removeFkSwAssuntoAtributoValores(\Urbem\CoreBundle\Entity\SwAssuntoAtributoValor $fkSwAssuntoAtributoValor)
    {
        $this->fkSwAssuntoAtributoValores->removeElement($fkSwAssuntoAtributoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwAssuntoAtributoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAssuntoAtributoValor
     */
    public function getFkSwAssuntoAtributoValores()
    {
        return $this->fkSwAssuntoAtributoValores;
    }

    /**
     * OneToMany (owning side)
     * Add SwDocumentoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwDocumentoProcesso $fkSwDocumentoProcesso
     * @return SwProcesso
     */
    public function addFkSwDocumentoProcessos(\Urbem\CoreBundle\Entity\SwDocumentoProcesso $fkSwDocumentoProcesso)
    {
        if (false === $this->fkSwDocumentoProcessos->contains($fkSwDocumentoProcesso)) {
            $fkSwDocumentoProcesso->setFkSwProcesso($this);
            $this->fkSwDocumentoProcessos->add($fkSwDocumentoProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwDocumentoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwDocumentoProcesso $fkSwDocumentoProcesso
     */
    public function removeFkSwDocumentoProcessos(\Urbem\CoreBundle\Entity\SwDocumentoProcesso $fkSwDocumentoProcesso)
    {
        $this->fkSwDocumentoProcessos->removeElement($fkSwDocumentoProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwDocumentoProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwDocumentoProcesso
     */
    public function getFkSwDocumentoProcessos()
    {
        return $this->fkSwDocumentoProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add SwProcessoApensado
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoApensado $fkSwProcessoApensado
     * @return SwProcesso
     */
    public function addFkSwProcessoApensados(\Urbem\CoreBundle\Entity\SwProcessoApensado $fkSwProcessoApensado)
    {
        if (false === $this->fkSwProcessoApensados->contains($fkSwProcessoApensado)) {
            $fkSwProcessoApensado->setFkSwProcesso($this);
            $this->fkSwProcessoApensados->add($fkSwProcessoApensado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwProcessoApensado
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoApensado $fkSwProcessoApensado
     */
    public function removeFkSwProcessoApensados(\Urbem\CoreBundle\Entity\SwProcessoApensado $fkSwProcessoApensado)
    {
        $this->fkSwProcessoApensados->removeElement($fkSwProcessoApensado);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwProcessoApensados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcessoApensado
     */
    public function getFkSwProcessoApensados()
    {
        return $this->fkSwProcessoApensados;
    }

    /**
     * OneToMany (owning side)
     * Add SwProcessoAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoAtributoValor $fkSwProcessoAtributoValor
     * @return SwProcesso
     */
    public function addFkSwProcessoAtributoValores(\Urbem\CoreBundle\Entity\SwProcessoAtributoValor $fkSwProcessoAtributoValor)
    {
        if (false === $this->fkSwProcessoAtributoValores->contains($fkSwProcessoAtributoValor)) {
            $fkSwProcessoAtributoValor->setFkSwProcesso($this);
            $this->fkSwProcessoAtributoValores->add($fkSwProcessoAtributoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwProcessoAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoAtributoValor $fkSwProcessoAtributoValor
     */
    public function removeFkSwProcessoAtributoValores(\Urbem\CoreBundle\Entity\SwProcessoAtributoValor $fkSwProcessoAtributoValor)
    {
        $this->fkSwProcessoAtributoValores->removeElement($fkSwProcessoAtributoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwProcessoAtributoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcessoAtributoValor
     */
    public function getFkSwProcessoAtributoValores()
    {
        return $this->fkSwProcessoAtributoValores;
    }

    /**
     * OneToMany (owning side)
     * Add SwProcessoInteressado
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoInteressado $fkSwProcessoInteressado
     * @return SwProcesso
     */
    public function addFkSwProcessoInteressados(\Urbem\CoreBundle\Entity\SwProcessoInteressado $fkSwProcessoInteressado)
    {
        if (false === $this->fkSwProcessoInteressados->contains($fkSwProcessoInteressado)) {
            $fkSwProcessoInteressado->setFkSwProcesso($this);
            $this->fkSwProcessoInteressados->add($fkSwProcessoInteressado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwProcessoInteressado
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoInteressado $fkSwProcessoInteressado
     */
    public function removeFkSwProcessoInteressados(\Urbem\CoreBundle\Entity\SwProcessoInteressado $fkSwProcessoInteressado)
    {
        $this->fkSwProcessoInteressados->removeElement($fkSwProcessoInteressado);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwProcessoInteressados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcessoInteressado
     */
    public function getFkSwProcessoInteressados()
    {
        return $this->fkSwProcessoInteressados;
    }

    /**
     * OneToMany (owning side)
     * Add TcernConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\Convenio $fkTcernConvenio
     * @return SwProcesso
     */
    public function addFkTcernConvenios(\Urbem\CoreBundle\Entity\Tcern\Convenio $fkTcernConvenio)
    {
        if (false === $this->fkTcernConvenios->contains($fkTcernConvenio)) {
            $fkTcernConvenio->setFkSwProcesso($this);
            $this->fkTcernConvenios->add($fkTcernConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\Convenio $fkTcernConvenio
     */
    public function removeFkTcernConvenios(\Urbem\CoreBundle\Entity\Tcern\Convenio $fkTcernConvenio)
    {
        $this->fkTcernConvenios->removeElement($fkTcernConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\Convenio
     */
    public function getFkTcernConvenios()
    {
        return $this->fkTcernConvenios;
    }

    /**
     * OneToMany (owning side)
     * Add TcernContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\Contrato $fkTcernContrato
     * @return SwProcesso
     */
    public function addFkTcernContratos(\Urbem\CoreBundle\Entity\Tcern\Contrato $fkTcernContrato)
    {
        if (false === $this->fkTcernContratos->contains($fkTcernContrato)) {
            $fkTcernContrato->setFkSwProcesso($this);
            $this->fkTcernContratos->add($fkTcernContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\Contrato $fkTcernContrato
     */
    public function removeFkTcernContratos(\Urbem\CoreBundle\Entity\Tcern\Contrato $fkTcernContrato)
    {
        $this->fkTcernContratos->removeElement($fkTcernContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\Contrato
     */
    public function getFkTcernContratos()
    {
        return $this->fkTcernContratos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoProcessoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ProcessoPagamento $fkArrecadacaoProcessoPagamento
     * @return SwProcesso
     */
    public function addFkArrecadacaoProcessoPagamentos(\Urbem\CoreBundle\Entity\Arrecadacao\ProcessoPagamento $fkArrecadacaoProcessoPagamento)
    {
        if (false === $this->fkArrecadacaoProcessoPagamentos->contains($fkArrecadacaoProcessoPagamento)) {
            $fkArrecadacaoProcessoPagamento->setFkSwProcesso($this);
            $this->fkArrecadacaoProcessoPagamentos->add($fkArrecadacaoProcessoPagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoProcessoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ProcessoPagamento $fkArrecadacaoProcessoPagamento
     */
    public function removeFkArrecadacaoProcessoPagamentos(\Urbem\CoreBundle\Entity\Arrecadacao\ProcessoPagamento $fkArrecadacaoProcessoPagamento)
    {
        $this->fkArrecadacaoProcessoPagamentos->removeElement($fkArrecadacaoProcessoPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoProcessoPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ProcessoPagamento
     */
    public function getFkArrecadacaoProcessoPagamentos()
    {
        return $this->fkArrecadacaoProcessoPagamentos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaProcesso $fkDividaDividaProcesso
     * @return SwProcesso
     */
    public function addFkDividaDividaProcessos(\Urbem\CoreBundle\Entity\Divida\DividaProcesso $fkDividaDividaProcesso)
    {
        if (false === $this->fkDividaDividaProcessos->contains($fkDividaDividaProcesso)) {
            $fkDividaDividaProcesso->setFkSwProcesso($this);
            $this->fkDividaDividaProcessos->add($fkDividaDividaProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaProcesso $fkDividaDividaProcesso
     */
    public function removeFkDividaDividaProcessos(\Urbem\CoreBundle\Entity\Divida\DividaProcesso $fkDividaDividaProcesso)
    {
        $this->fkDividaDividaProcessos->removeElement($fkDividaDividaProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaProcesso
     */
    public function getFkDividaDividaProcessos()
    {
        return $this->fkDividaDividaProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoDiasCadEcon
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoDiasCadEcon $fkEconomicoProcessoDiasCadEcon
     * @return SwProcesso
     */
    public function addFkEconomicoProcessoDiasCadEcons(\Urbem\CoreBundle\Entity\Economico\ProcessoDiasCadEcon $fkEconomicoProcessoDiasCadEcon)
    {
        if (false === $this->fkEconomicoProcessoDiasCadEcons->contains($fkEconomicoProcessoDiasCadEcon)) {
            $fkEconomicoProcessoDiasCadEcon->setFkSwProcesso($this);
            $this->fkEconomicoProcessoDiasCadEcons->add($fkEconomicoProcessoDiasCadEcon);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoDiasCadEcon
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoDiasCadEcon $fkEconomicoProcessoDiasCadEcon
     */
    public function removeFkEconomicoProcessoDiasCadEcons(\Urbem\CoreBundle\Entity\Economico\ProcessoDiasCadEcon $fkEconomicoProcessoDiasCadEcon)
    {
        $this->fkEconomicoProcessoDiasCadEcons->removeElement($fkEconomicoProcessoDiasCadEcon);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoDiasCadEcons
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoDiasCadEcon
     */
    public function getFkEconomicoProcessoDiasCadEcons()
    {
        return $this->fkEconomicoProcessoDiasCadEcons;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoSociedade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoSociedade $fkEconomicoProcessoSociedade
     * @return SwProcesso
     */
    public function addFkEconomicoProcessoSociedades(\Urbem\CoreBundle\Entity\Economico\ProcessoSociedade $fkEconomicoProcessoSociedade)
    {
        if (false === $this->fkEconomicoProcessoSociedades->contains($fkEconomicoProcessoSociedade)) {
            $fkEconomicoProcessoSociedade->setFkSwProcesso($this);
            $this->fkEconomicoProcessoSociedades->add($fkEconomicoProcessoSociedade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoSociedade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoSociedade $fkEconomicoProcessoSociedade
     */
    public function removeFkEconomicoProcessoSociedades(\Urbem\CoreBundle\Entity\Economico\ProcessoSociedade $fkEconomicoProcessoSociedade)
    {
        $this->fkEconomicoProcessoSociedades->removeElement($fkEconomicoProcessoSociedade);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoSociedades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoSociedade
     */
    public function getFkEconomicoProcessoSociedades()
    {
        return $this->fkEconomicoProcessoSociedades;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaVeiculoCessao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoCessao $fkFrotaVeiculoCessao
     * @return SwProcesso
     */
    public function addFkFrotaVeiculoCessoes(\Urbem\CoreBundle\Entity\Frota\VeiculoCessao $fkFrotaVeiculoCessao)
    {
        if (false === $this->fkFrotaVeiculoCessoes->contains($fkFrotaVeiculoCessao)) {
            $fkFrotaVeiculoCessao->setFkSwProcesso($this);
            $this->fkFrotaVeiculoCessoes->add($fkFrotaVeiculoCessao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculoCessao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoCessao $fkFrotaVeiculoCessao
     */
    public function removeFkFrotaVeiculoCessoes(\Urbem\CoreBundle\Entity\Frota\VeiculoCessao $fkFrotaVeiculoCessao)
    {
        $this->fkFrotaVeiculoCessoes->removeElement($fkFrotaVeiculoCessao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculoCessoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoCessao
     */
    public function getFkFrotaVeiculoCessoes()
    {
        return $this->fkFrotaVeiculoCessoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioCondominioProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\CondominioProcesso $fkImobiliarioCondominioProcesso
     * @return SwProcesso
     */
    public function addFkImobiliarioCondominioProcessos(\Urbem\CoreBundle\Entity\Imobiliario\CondominioProcesso $fkImobiliarioCondominioProcesso)
    {
        if (false === $this->fkImobiliarioCondominioProcessos->contains($fkImobiliarioCondominioProcesso)) {
            $fkImobiliarioCondominioProcesso->setFkSwProcesso($this);
            $this->fkImobiliarioCondominioProcessos->add($fkImobiliarioCondominioProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioCondominioProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\CondominioProcesso $fkImobiliarioCondominioProcesso
     */
    public function removeFkImobiliarioCondominioProcessos(\Urbem\CoreBundle\Entity\Imobiliario\CondominioProcesso $fkImobiliarioCondominioProcesso)
    {
        $this->fkImobiliarioCondominioProcessos->removeElement($fkImobiliarioCondominioProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioCondominioProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\CondominioProcesso
     */
    public function getFkImobiliarioCondominioProcessos()
    {
        return $this->fkImobiliarioCondominioProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add SwProcessoConfidencial
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoConfidencial $fkSwProcessoConfidencial
     * @return SwProcesso
     */
    public function addFkSwProcessoConfidenciais(\Urbem\CoreBundle\Entity\SwProcessoConfidencial $fkSwProcessoConfidencial)
    {
        if (false === $this->fkSwProcessoConfidenciais->contains($fkSwProcessoConfidencial)) {
            $fkSwProcessoConfidencial->setFkSwProcesso($this);
            $this->fkSwProcessoConfidenciais->add($fkSwProcessoConfidencial);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwProcessoConfidencial
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoConfidencial $fkSwProcessoConfidencial
     */
    public function removeFkSwProcessoConfidenciais(\Urbem\CoreBundle\Entity\SwProcessoConfidencial $fkSwProcessoConfidencial)
    {
        $this->fkSwProcessoConfidenciais->removeElement($fkSwProcessoConfidencial);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwProcessoConfidenciais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcessoConfidencial
     */
    public function getFkSwProcessoConfidenciais()
    {
        return $this->fkSwProcessoConfidenciais;
    }

    /**
     * OneToMany (owning side)
     * Add TcernContratoAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ContratoAditivo $fkTcernContratoAditivo
     * @return SwProcesso
     */
    public function addFkTcernContratoAditivos(\Urbem\CoreBundle\Entity\Tcern\ContratoAditivo $fkTcernContratoAditivo)
    {
        if (false === $this->fkTcernContratoAditivos->contains($fkTcernContratoAditivo)) {
            $fkTcernContratoAditivo->setFkSwProcesso($this);
            $this->fkTcernContratoAditivos->add($fkTcernContratoAditivo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernContratoAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ContratoAditivo $fkTcernContratoAditivo
     */
    public function removeFkTcernContratoAditivos(\Urbem\CoreBundle\Entity\Tcern\ContratoAditivo $fkTcernContratoAditivo)
    {
        $this->fkTcernContratoAditivos->removeElement($fkTcernContratoAditivo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernContratoAditivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ContratoAditivo
     */
    public function getFkTcernContratoAditivos()
    {
        return $this->fkTcernContratoAditivos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwAssunto
     *
     * @param \Urbem\CoreBundle\Entity\SwAssunto $fkSwAssunto
     * @return SwProcesso
     */
    public function setFkSwAssunto(\Urbem\CoreBundle\Entity\SwAssunto $fkSwAssunto)
    {
        $this->codAssunto = $fkSwAssunto->getCodAssunto();
        $this->codClassificacao = $fkSwAssunto->getCodClassificacao();
        $this->fkSwAssunto = $fkSwAssunto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwAssunto
     *
     * @return \Urbem\CoreBundle\Entity\SwAssunto
     */
    public function getFkSwAssunto()
    {
        return $this->fkSwAssunto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return SwProcesso
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->codUsuario = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwSituacaoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwSituacaoProcesso $fkSwSituacaoProcesso
     * @return SwProcesso
     */
    public function setFkSwSituacaoProcesso(\Urbem\CoreBundle\Entity\SwSituacaoProcesso $fkSwSituacaoProcesso)
    {
        $this->codSituacao = $fkSwSituacaoProcesso->getCodSituacao();
        $this->fkSwSituacaoProcesso = $fkSwSituacaoProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwSituacaoProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwSituacaoProcesso
     */
    public function getFkSwSituacaoProcesso()
    {
        return $this->fkSwSituacaoProcesso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCentroCusto
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto $fkAlmoxarifadoCentroCusto
     * @return SwProcesso
     */
    public function setFkAlmoxarifadoCentroCusto(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto $fkAlmoxarifadoCentroCusto)
    {
        $this->codCentro = $fkAlmoxarifadoCentroCusto->getCodCentro();
        $this->fkAlmoxarifadoCentroCusto = $fkAlmoxarifadoCentroCusto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCentroCusto
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto
     */
    public function getFkAlmoxarifadoCentroCusto()
    {
        return $this->fkAlmoxarifadoCentroCusto;
    }

    /**
     * OneToOne (inverse side)
     * Set SwUltimoAndamento
     *
     * @param \Urbem\CoreBundle\Entity\SwUltimoAndamento $fkSwUltimoAndamento
     * @return SwProcesso
     */
    public function setFkSwUltimoAndamento(\Urbem\CoreBundle\Entity\SwUltimoAndamento $fkSwUltimoAndamento)
    {
        $fkSwUltimoAndamento->setFkSwProcesso($this);
        $this->fkSwUltimoAndamento = $fkSwUltimoAndamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwUltimoAndamento
     *
     * @return \Urbem\CoreBundle\Entity\SwUltimoAndamento
     */
    public function getFkSwUltimoAndamento()
    {
        return $this->fkSwUltimoAndamento;
    }

    /**
     * OneToOne (inverse side)
     * Set SwProcessoArquivado
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoArquivado $fkSwProcessoArquivado
     * @return SwProcesso
     */
    public function setFkSwProcessoArquivado(\Urbem\CoreBundle\Entity\SwProcessoArquivado $fkSwProcessoArquivado = null)
    {
        if (is_null($fkSwProcessoArquivado) == false) {
            $fkSwProcessoArquivado->setFkSwProcesso($this);
        }

        $this->fkSwProcessoArquivado = $fkSwProcessoArquivado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwProcessoArquivado
     *
     * @return \Urbem\CoreBundle\Entity\SwProcessoArquivado
     */
    public function getFkSwProcessoArquivado()
    {
        return $this->fkSwProcessoArquivado;
    }

    /**
     * OneToOne (inverse side)
     * Set SwProcessoFuncionario
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoFuncionario $fkSwProcessoFuncionario
     * @return SwProcesso
     */
    public function setFkSwProcessoFuncionario(\Urbem\CoreBundle\Entity\SwProcessoFuncionario $fkSwProcessoFuncionario)
    {
        $fkSwProcessoFuncionario->setFkSwProcesso($this);
        $this->fkSwProcessoFuncionario = $fkSwProcessoFuncionario;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwProcessoFuncionario
     *
     * @return \Urbem\CoreBundle\Entity\SwProcessoFuncionario
     */
    public function getFkSwProcessoFuncionario()
    {
        return $this->fkSwProcessoFuncionario;
    }

    /**
     * OneToOne (inverse side)
     * Set SwProcessoInscricao
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoInscricao $fkSwProcessoInscricao
     * @return SwProcesso
     */
    public function setFkSwProcessoInscricao(\Urbem\CoreBundle\Entity\SwProcessoInscricao $fkSwProcessoInscricao)
    {
        $fkSwProcessoInscricao->setFkSwProcesso($this);
        $this->fkSwProcessoInscricao = $fkSwProcessoInscricao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwProcessoInscricao
     *
     * @return \Urbem\CoreBundle\Entity\SwProcessoInscricao
     */
    public function getFkSwProcessoInscricao()
    {
        return $this->fkSwProcessoInscricao;
    }

    /**
     * OneToOne (inverse side)
     * Set SwProcessoMatricula
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoMatricula $fkSwProcessoMatricula
     * @return SwProcesso
     */
    public function setFkSwProcessoMatricula(\Urbem\CoreBundle\Entity\SwProcessoMatricula $fkSwProcessoMatricula)
    {
        $fkSwProcessoMatricula->setFkSwProcesso($this);
        $this->fkSwProcessoMatricula = $fkSwProcessoMatricula;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwProcessoMatricula
     *
     * @return \Urbem\CoreBundle\Entity\SwProcessoMatricula
     */
    public function getFkSwProcessoMatricula()
    {
        return $this->fkSwProcessoMatricula;
    }

    /**
     * @return string
     */
    public function getCodComposto()
    {
        return sprintf('%s~%s', $this->codProcesso, $this->anoExercicio);
    }

    /**
     * @return array
     */
    public static function getStFormatoEtiqueta()
    {
        return array(
            'Modelo A4 (2x8)' => 'A4',
            'Modelo Impressora Térmica' => 'termica'
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->codProcesso.'/'.$this->anoExercicio.' - '.$this->fkSwAssunto;
    }
}
