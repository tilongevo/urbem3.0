<?php

namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * Entidade
 */
class Entidade
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $codResponsavel;

    /**
     * @var integer
     */
    private $codRespTecnico;

    /**
     * @var integer
     */
    private $codProfissao;

    /**
     * @var integer
     */
    private $sequencia;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\EntidadeLogotipo
     */
    private $fkOrcamentoEntidadeLogotipo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoReglic
     */
    private $fkTcemgConfiguracaoReglic;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\OperacaoCreditoAro
     */
    private $fkTcemgOperacaoCreditoAro;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde
     */
    private $fkTcmgoConfiguracaoIde;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Assinatura
     */
    private $fkAdministracaoAssinaturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade
     */
    private $fkAdministracaoConfiguracaoEntidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\EntidadeRh
     */
    private $fkAdministracaoEntidadeRhs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade
     */
    private $fkAlmoxarifadoCentroCustoEntidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CompraDireta
     */
    private $fkComprasCompraDiretas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Solicitacao
     */
    private $fkComprasSolicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ContaContabilRpNp
     */
    private $fkContabilidadeContaContabilRpNps;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp
     */
    private $fkContabilidadeContaLancamentoRps;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\Lote
     */
    private $fkContabilidadeLotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\DespesasFixas
     */
    private $fkEmpenhoDespesasFixas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamento
     */
    private $fkEmpenhoOrdemPagamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario
     */
    private $fkFolhapagamentoTcmbaCargoServidorTemporarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado
     */
    private $fkFolhapagamentoTcmbaEmprestimoConsignados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaGratificacaoFuncao
     */
    private $fkFolhapagamentoTcmbaGratificacaoFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaPlanoSaude
     */
    private $fkFolhapagamentoTcmbaPlanoSaudes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioDescontos
     */
    private $fkFolhapagamentoTcmbaSalarioDescontos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioFamilia
     */
    private $fkFolhapagamentoTcmbaSalarioFamilias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioHorasExtras
     */
    private $fkFolhapagamentoTcmbaSalarioHorasExtras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaVantagensSalariais
     */
    private $fkFolhapagamentoTcmbaVantagensSalariais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    private $fkLicitacaoContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\AjusteRecursoModeloLrf
     */
    private $fkManadAjusteRecursoModeloLrfs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\AjustePlanoContaModeloLrf
     */
    private $fkManadAjustePlanoContaModeloLrfs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\PlanoContaEntidade
     */
    private $fkManadPlanoContaEntidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceitas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade
     */
    private $fkOrcamentoUsuarioEntidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemComprado
     */
    private $fkPatrimonioBemComprados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\VeiculoUniorcam
     */
    private $fkPatrimonioVeiculoUniorcans;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoFundeb
     */
    private $fkStnVinculoFundebs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\RiscosFiscais
     */
    private $fkStnRiscosFiscais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoRecurso
     */
    private $fkStnVinculoRecursos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\DespesaPessoal
     */
    private $fkStnDespesaPessoais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\RreoAnexo13
     */
    private $fkStnRreoAnexo13s;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\ReceitaCorrenteLiquida
     */
    private $fkStnReceitaCorrenteLiquidas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo
     */
    private $fkTcealDeParaTipoCargos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento
     */
    private $fkTcealOcorrenciaFuncionalAssentamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\PublicacaoRreo
     */
    private $fkTcealPublicacaoRreos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\PublicacaoRgf
     */
    private $fkTcealPublicacaoRgfs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    private $fkTcemgContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContaBancaria
     */
    private $fkTcemgContaBancarias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ProjecaoAtuarial
     */
    private $fkTcemgProjecaoAtuariais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorio
     */
    private $fkTcemgTetoRemuneratorios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\AgenteEletivo
     */
    private $fkTcepeAgenteEletivos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\CgmAgentePolitico
     */
    private $fkTcepeCgmAgentePoliticos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador
     */
    private $fkTcepeConfiguracaoOrdenadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor
     */
    private $fkTcepeConfiguracaoGestores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOperacaoCredito
     */
    private $fkTcepeDividaFundadaOperacaoCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal
     */
    private $fkTcepeFonteRecursoLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao
     */
    private $fkTcepeFonteRecursoLotacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa
     */
    private $fkTcepeOrcamentoModalidadeDespesas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai
     */
    private $fkTcernSubDivisaoDescricaoSiais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\PlanoContaEntidade
     */
    private $fkTcersPlanoContaEntidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador
     */
    private $fkTcmbaConfiguracaoRatificadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\LimiteAlteracaoCredito
     */
    private $fkTcmbaLimiteAlteracaoCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\Obra
     */
    private $fkTcmbaObras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\TermoParceria
     */
    private $fkTcmbaTermoParcerias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade
     */
    private $fkTcmgoConfiguracaoOrgaoUnidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelTecnico
     */
    private $fkTcmgoResponsavelTecnicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    private $fkTesourariaArrecadacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Boletim
     */
    private $fkTesourariaBoletins;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Bordero
     */
    private $fkTesourariaBorderos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Assinatura
     */
    private $fkTesourariaAssinaturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimReaberto
     */
    private $fkTesourariaBoletimReabertos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado
     */
    private $fkTesourariaBoletimFechados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\PermissaoTerminal
     */
    private $fkTesourariaPermissaoTerminais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\BibliotecaEntidade
     */
    private $fkAdministracaoBibliotecaEntidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho
     */
    private $fkEmpenhoAutorizacaoEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra
     */
    private $fkTesourariaReciboExtras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    private $fkOrcamentoDespesas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\AjustePlanoContaModeloLrf
     */
    private $fkTcersAjustePlanoContaModeloLrfs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConvenioPlanoBanco
     */
    private $fkTcemgConvenioPlanoBancos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida
     */
    private $fkTcepeTipoTransferenciaRecebidas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal
     */
    private $fkTcmbaFonteRecursoLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao
     */
    private $fkTcmbaFonteRecursoLotacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\Contrato
     */
    private $fkTcmgoContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Dote
     */
    private $fkTesourariaDotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor
     */
    private $fkFolhapagamentoTcmbaCargoServidores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioBase
     */
    private $fkFolhapagamentoTcmbaSalarioBases;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\NotaFiscal
     */
    private $fkTcemgNotaFiscais;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\ResponsavelTecnico
     */
    private $fkTcepeResponsavelTecnicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida
     */
    private $fkTcepeTipoTransferenciaConcedidas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador
     */
    private $fkTcmbaConfiguracaoOrdenadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\AjusteRecursoModeloLrf
     */
    private $fkTcersAjusteRecursoModeloLrfs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado
     */
    private $fkTesourariaBoletimLiberadoCancelados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio
     */
    private $fkEmpenhoEmpenhoConvenios;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico
     */
    private $fkEconomicoResponsavelTecnico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoAssinaturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoConfiguracaoEntidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoEntidadeRhs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoCentroCustoEntidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasCompraDiretas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeContaContabilRpNps = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeContaLancamentoRps = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeLotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoDespesasFixas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoOrdemPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaCargoServidorTemporarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaEmprestimoConsignados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaGratificacaoFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaPlanoSaudes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaSalarioDescontos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaSalarioFamilias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaSalarioHorasExtras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaVantagensSalariais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkManadAjusteRecursoModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkManadAjustePlanoContaModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkManadPlanoContaEntidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoReceitas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoUsuarioEntidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioBemComprados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioVeiculoUniorcans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkStnVinculoFundebs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkStnRiscosFiscais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkStnVinculoRecursos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkStnDespesaPessoais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkStnRreoAnexo13s = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkStnReceitaCorrenteLiquidas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcealDeParaTipoCargos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcealOcorrenciaFuncionalAssentamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcealPublicacaoRreos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcealPublicacaoRgfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgContaBancarias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgProjecaoAtuariais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgTetoRemuneratorios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeAgenteEletivos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeCgmAgentePoliticos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeConfiguracaoOrdenadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeConfiguracaoGestores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeDividaFundadaOperacaoCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeFonteRecursoLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeFonteRecursoLotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeOrcamentoModalidadeDespesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernSubDivisaoDescricaoSiais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcersPlanoContaEntidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaConfiguracaoRatificadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaLimiteAlteracaoCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaObras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaTermoParcerias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoConfiguracaoOrgaoUnidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoResponsavelTecnicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaArrecadacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletins = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBorderos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaAssinaturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimReabertos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimFechados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaPermissaoTerminais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoBibliotecaEntidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoAutorizacaoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaReciboExtras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoDespesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcersAjustePlanoContaModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgConvenioPlanoBancos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeTipoTransferenciaRecebidas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaFonteRecursoLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaFonteRecursoLotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaDotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaCargoServidores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaSalarioBases = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgNotaFiscais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgTipoRegistroPrecos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeDividaFundadaOutraOperacaoCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeResponsavelTecnicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeTipoTransferenciaConcedidas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaConfiguracaoOrdenadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcersAjusteRecursoModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimLiberadoCancelados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoEmpenhoConvenios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Entidade
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Entidade
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Entidade
     */
    public function setNumcgm($numcgm)
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
     * Set codResponsavel
     *
     * @param integer $codResponsavel
     * @return Entidade
     */
    public function setCodResponsavel($codResponsavel)
    {
        $this->codResponsavel = $codResponsavel;
        return $this;
    }

    /**
     * Get codResponsavel
     *
     * @return integer
     */
    public function getCodResponsavel()
    {
        return $this->codResponsavel;
    }

    /**
     * Set codRespTecnico
     *
     * @param integer $codRespTecnico
     * @return Entidade
     */
    public function setCodRespTecnico($codRespTecnico)
    {
        $this->codRespTecnico = $codRespTecnico;
        return $this;
    }

    /**
     * Get codRespTecnico
     *
     * @return integer
     */
    public function getCodRespTecnico()
    {
        return $this->codRespTecnico;
    }

    /**
     * Set codProfissao
     *
     * @param integer $codProfissao
     * @return Entidade
     */
    public function setCodProfissao($codProfissao)
    {
        $this->codProfissao = $codProfissao;
        return $this;
    }

    /**
     * Get codProfissao
     *
     * @return integer
     */
    public function getCodProfissao()
    {
        return $this->codProfissao;
    }

    /**
     * Set sequencia
     *
     * @param integer $sequencia
     * @return Entidade
     */
    public function setSequencia($sequencia = null)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Assinatura $fkAdministracaoAssinatura
     * @return Entidade
     */
    public function addFkAdministracaoAssinaturas(\Urbem\CoreBundle\Entity\Administracao\Assinatura $fkAdministracaoAssinatura)
    {
        if (false === $this->fkAdministracaoAssinaturas->contains($fkAdministracaoAssinatura)) {
            $fkAdministracaoAssinatura->setFkOrcamentoEntidade($this);
            $this->fkAdministracaoAssinaturas->add($fkAdministracaoAssinatura);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Assinatura $fkAdministracaoAssinatura
     */
    public function removeFkAdministracaoAssinaturas(\Urbem\CoreBundle\Entity\Administracao\Assinatura $fkAdministracaoAssinatura)
    {
        $this->fkAdministracaoAssinaturas->removeElement($fkAdministracaoAssinatura);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoAssinaturas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Assinatura
     */
    public function getFkAdministracaoAssinaturas()
    {
        return $this->fkAdministracaoAssinaturas;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoConfiguracaoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade $fkAdministracaoConfiguracaoEntidade
     * @return Entidade
     */
    public function addFkAdministracaoConfiguracaoEntidades(\Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade $fkAdministracaoConfiguracaoEntidade)
    {
        if (false === $this->fkAdministracaoConfiguracaoEntidades->contains($fkAdministracaoConfiguracaoEntidade)) {
            $fkAdministracaoConfiguracaoEntidade->setFkOrcamentoEntidade($this);
            $this->fkAdministracaoConfiguracaoEntidades->add($fkAdministracaoConfiguracaoEntidade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoConfiguracaoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade $fkAdministracaoConfiguracaoEntidade
     */
    public function removeFkAdministracaoConfiguracaoEntidades(\Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade $fkAdministracaoConfiguracaoEntidade)
    {
        $this->fkAdministracaoConfiguracaoEntidades->removeElement($fkAdministracaoConfiguracaoEntidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoConfiguracaoEntidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade
     */
    public function getFkAdministracaoConfiguracaoEntidades()
    {
        return $this->fkAdministracaoConfiguracaoEntidades;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoEntidadeRh
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\EntidadeRh $fkAdministracaoEntidadeRh
     * @return Entidade
     */
    public function addFkAdministracaoEntidadeRhs(\Urbem\CoreBundle\Entity\Administracao\EntidadeRh $fkAdministracaoEntidadeRh)
    {
        if (false === $this->fkAdministracaoEntidadeRhs->contains($fkAdministracaoEntidadeRh)) {
            $fkAdministracaoEntidadeRh->setFkOrcamentoEntidade($this);
            $this->fkAdministracaoEntidadeRhs->add($fkAdministracaoEntidadeRh);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoEntidadeRh
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\EntidadeRh $fkAdministracaoEntidadeRh
     */
    public function removeFkAdministracaoEntidadeRhs(\Urbem\CoreBundle\Entity\Administracao\EntidadeRh $fkAdministracaoEntidadeRh)
    {
        $this->fkAdministracaoEntidadeRhs->removeElement($fkAdministracaoEntidadeRh);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoEntidadeRhs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\EntidadeRh
     */
    public function getFkAdministracaoEntidadeRhs()
    {
        return $this->fkAdministracaoEntidadeRhs;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoCentroCustoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade $fkAlmoxarifadoCentroCustoEntidade
     * @return Entidade
     */
    public function addFkAlmoxarifadoCentroCustoEntidades(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade $fkAlmoxarifadoCentroCustoEntidade)
    {
        if (false === $this->fkAlmoxarifadoCentroCustoEntidades->contains($fkAlmoxarifadoCentroCustoEntidade)) {
            $fkAlmoxarifadoCentroCustoEntidade->setFkOrcamentoEntidade($this);
            $this->fkAlmoxarifadoCentroCustoEntidades->add($fkAlmoxarifadoCentroCustoEntidade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoCentroCustoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade $fkAlmoxarifadoCentroCustoEntidade
     */
    public function removeFkAlmoxarifadoCentroCustoEntidades(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade $fkAlmoxarifadoCentroCustoEntidade)
    {
        $this->fkAlmoxarifadoCentroCustoEntidades->removeElement($fkAlmoxarifadoCentroCustoEntidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoCentroCustoEntidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade
     */
    public function getFkAlmoxarifadoCentroCustoEntidades()
    {
        return $this->fkAlmoxarifadoCentroCustoEntidades;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta
     * @return Entidade
     */
    public function addFkComprasCompraDiretas(\Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta)
    {
        if (false === $this->fkComprasCompraDiretas->contains($fkComprasCompraDireta)) {
            $fkComprasCompraDireta->setFkOrcamentoEntidade($this);
            $this->fkComprasCompraDiretas->add($fkComprasCompraDireta);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta
     */
    public function removeFkComprasCompraDiretas(\Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta)
    {
        $this->fkComprasCompraDiretas->removeElement($fkComprasCompraDireta);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasCompraDiretas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CompraDireta
     */
    public function getFkComprasCompraDiretas()
    {
        return $this->fkComprasCompraDiretas;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao
     * @return Entidade
     */
    public function addFkComprasSolicitacoes(\Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao)
    {
        if (false === $this->fkComprasSolicitacoes->contains($fkComprasSolicitacao)) {
            $fkComprasSolicitacao->setFkOrcamentoEntidade($this);
            $this->fkComprasSolicitacoes->add($fkComprasSolicitacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao
     */
    public function removeFkComprasSolicitacoes(\Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao)
    {
        $this->fkComprasSolicitacoes->removeElement($fkComprasSolicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Solicitacao
     */
    public function getFkComprasSolicitacoes()
    {
        return $this->fkComprasSolicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeContaContabilRpNp
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ContaContabilRpNp $fkContabilidadeContaContabilRpNp
     * @return Entidade
     */
    public function addFkContabilidadeContaContabilRpNps(\Urbem\CoreBundle\Entity\Contabilidade\ContaContabilRpNp $fkContabilidadeContaContabilRpNp)
    {
        if (false === $this->fkContabilidadeContaContabilRpNps->contains($fkContabilidadeContaContabilRpNp)) {
            $fkContabilidadeContaContabilRpNp->setFkOrcamentoEntidade($this);
            $this->fkContabilidadeContaContabilRpNps->add($fkContabilidadeContaContabilRpNp);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeContaContabilRpNp
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ContaContabilRpNp $fkContabilidadeContaContabilRpNp
     */
    public function removeFkContabilidadeContaContabilRpNps(\Urbem\CoreBundle\Entity\Contabilidade\ContaContabilRpNp $fkContabilidadeContaContabilRpNp)
    {
        $this->fkContabilidadeContaContabilRpNps->removeElement($fkContabilidadeContaContabilRpNp);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeContaContabilRpNps
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ContaContabilRpNp
     */
    public function getFkContabilidadeContaContabilRpNps()
    {
        return $this->fkContabilidadeContaContabilRpNps;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeContaLancamentoRp
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp $fkContabilidadeContaLancamentoRp
     * @return Entidade
     */
    public function addFkContabilidadeContaLancamentoRps(\Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp $fkContabilidadeContaLancamentoRp)
    {
        if (false === $this->fkContabilidadeContaLancamentoRps->contains($fkContabilidadeContaLancamentoRp)) {
            $fkContabilidadeContaLancamentoRp->setFkOrcamentoEntidade($this);
            $this->fkContabilidadeContaLancamentoRps->add($fkContabilidadeContaLancamentoRp);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeContaLancamentoRp
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp $fkContabilidadeContaLancamentoRp
     */
    public function removeFkContabilidadeContaLancamentoRps(\Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp $fkContabilidadeContaLancamentoRp)
    {
        $this->fkContabilidadeContaLancamentoRps->removeElement($fkContabilidadeContaLancamentoRp);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeContaLancamentoRps
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp
     */
    public function getFkContabilidadeContaLancamentoRps()
    {
        return $this->fkContabilidadeContaLancamentoRps;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLote
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Lote $fkContabilidadeLote
     * @return Entidade
     */
    public function addFkContabilidadeLotes(\Urbem\CoreBundle\Entity\Contabilidade\Lote $fkContabilidadeLote)
    {
        if (false === $this->fkContabilidadeLotes->contains($fkContabilidadeLote)) {
            $fkContabilidadeLote->setFkOrcamentoEntidade($this);
            $this->fkContabilidadeLotes->add($fkContabilidadeLote);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLote
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Lote $fkContabilidadeLote
     */
    public function removeFkContabilidadeLotes(\Urbem\CoreBundle\Entity\Contabilidade\Lote $fkContabilidadeLote)
    {
        $this->fkContabilidadeLotes->removeElement($fkContabilidadeLote);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\Lote
     */
    public function getFkContabilidadeLotes()
    {
        return $this->fkContabilidadeLotes;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return Entidade
     */
    public function addFkEmpenhoEmpenhos(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        if (false === $this->fkEmpenhoEmpenhos->contains($fkEmpenhoEmpenho)) {
            $fkEmpenhoEmpenho->setFkOrcamentoEntidade($this);
            $this->fkEmpenhoEmpenhos->add($fkEmpenhoEmpenho);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     */
    public function removeFkEmpenhoEmpenhos(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        $this->fkEmpenhoEmpenhos->removeElement($fkEmpenhoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenhos()
    {
        return $this->fkEmpenhoEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoDespesasFixas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas
     * @return Entidade
     */
    public function addFkEmpenhoDespesasFixas(\Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas)
    {
        if (false === $this->fkEmpenhoDespesasFixas->contains($fkEmpenhoDespesasFixas)) {
            $fkEmpenhoDespesasFixas->setFkOrcamentoEntidade($this);
            $this->fkEmpenhoDespesasFixas->add($fkEmpenhoDespesasFixas);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoDespesasFixas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas
     */
    public function removeFkEmpenhoDespesasFixas(\Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas)
    {
        $this->fkEmpenhoDespesasFixas->removeElement($fkEmpenhoDespesasFixas);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoDespesasFixas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\DespesasFixas
     */
    public function getFkEmpenhoDespesasFixas()
    {
        return $this->fkEmpenhoDespesasFixas;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoOrdemPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento $fkEmpenhoOrdemPagamento
     * @return Entidade
     */
    public function addFkEmpenhoOrdemPagamentos(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamento $fkEmpenhoOrdemPagamento)
    {
        if (false === $this->fkEmpenhoOrdemPagamentos->contains($fkEmpenhoOrdemPagamento)) {
            $fkEmpenhoOrdemPagamento->setFkOrcamentoEntidade($this);
            $this->fkEmpenhoOrdemPagamentos->add($fkEmpenhoOrdemPagamento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoOrdemPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento $fkEmpenhoOrdemPagamento
     */
    public function removeFkEmpenhoOrdemPagamentos(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamento $fkEmpenhoOrdemPagamento)
    {
        $this->fkEmpenhoOrdemPagamentos->removeElement($fkEmpenhoOrdemPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoOrdemPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamento
     */
    public function getFkEmpenhoOrdemPagamentos()
    {
        return $this->fkEmpenhoOrdemPagamentos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaCargoServidorTemporario
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario $fkFolhapagamentoTcmbaCargoServidorTemporario
     * @return Entidade
     */
    public function addFkFolhapagamentoTcmbaCargoServidorTemporarios(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario $fkFolhapagamentoTcmbaCargoServidorTemporario)
    {
        if (false === $this->fkFolhapagamentoTcmbaCargoServidorTemporarios->contains($fkFolhapagamentoTcmbaCargoServidorTemporario)) {
            $fkFolhapagamentoTcmbaCargoServidorTemporario->setFkOrcamentoEntidade($this);
            $this->fkFolhapagamentoTcmbaCargoServidorTemporarios->add($fkFolhapagamentoTcmbaCargoServidorTemporario);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaCargoServidorTemporario
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario $fkFolhapagamentoTcmbaCargoServidorTemporario
     */
    public function removeFkFolhapagamentoTcmbaCargoServidorTemporarios(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario $fkFolhapagamentoTcmbaCargoServidorTemporario)
    {
        $this->fkFolhapagamentoTcmbaCargoServidorTemporarios->removeElement($fkFolhapagamentoTcmbaCargoServidorTemporario);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaCargoServidorTemporarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario
     */
    public function getFkFolhapagamentoTcmbaCargoServidorTemporarios()
    {
        return $this->fkFolhapagamentoTcmbaCargoServidorTemporarios;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaEmprestimoConsignado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado $fkFolhapagamentoTcmbaEmprestimoConsignado
     * @return Entidade
     */
    public function addFkFolhapagamentoTcmbaEmprestimoConsignados(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado $fkFolhapagamentoTcmbaEmprestimoConsignado)
    {
        if (false === $this->fkFolhapagamentoTcmbaEmprestimoConsignados->contains($fkFolhapagamentoTcmbaEmprestimoConsignado)) {
            $fkFolhapagamentoTcmbaEmprestimoConsignado->setFkOrcamentoEntidade($this);
            $this->fkFolhapagamentoTcmbaEmprestimoConsignados->add($fkFolhapagamentoTcmbaEmprestimoConsignado);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaEmprestimoConsignado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado $fkFolhapagamentoTcmbaEmprestimoConsignado
     */
    public function removeFkFolhapagamentoTcmbaEmprestimoConsignados(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado $fkFolhapagamentoTcmbaEmprestimoConsignado)
    {
        $this->fkFolhapagamentoTcmbaEmprestimoConsignados->removeElement($fkFolhapagamentoTcmbaEmprestimoConsignado);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaEmprestimoConsignados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado
     */
    public function getFkFolhapagamentoTcmbaEmprestimoConsignados()
    {
        return $this->fkFolhapagamentoTcmbaEmprestimoConsignados;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaGratificacaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaGratificacaoFuncao $fkFolhapagamentoTcmbaGratificacaoFuncao
     * @return Entidade
     */
    public function addFkFolhapagamentoTcmbaGratificacaoFuncoes(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaGratificacaoFuncao $fkFolhapagamentoTcmbaGratificacaoFuncao)
    {
        if (false === $this->fkFolhapagamentoTcmbaGratificacaoFuncoes->contains($fkFolhapagamentoTcmbaGratificacaoFuncao)) {
            $fkFolhapagamentoTcmbaGratificacaoFuncao->setFkOrcamentoEntidade($this);
            $this->fkFolhapagamentoTcmbaGratificacaoFuncoes->add($fkFolhapagamentoTcmbaGratificacaoFuncao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaGratificacaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaGratificacaoFuncao $fkFolhapagamentoTcmbaGratificacaoFuncao
     */
    public function removeFkFolhapagamentoTcmbaGratificacaoFuncoes(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaGratificacaoFuncao $fkFolhapagamentoTcmbaGratificacaoFuncao)
    {
        $this->fkFolhapagamentoTcmbaGratificacaoFuncoes->removeElement($fkFolhapagamentoTcmbaGratificacaoFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaGratificacaoFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaGratificacaoFuncao
     */
    public function getFkFolhapagamentoTcmbaGratificacaoFuncoes()
    {
        return $this->fkFolhapagamentoTcmbaGratificacaoFuncoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaPlanoSaude
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaPlanoSaude $fkFolhapagamentoTcmbaPlanoSaude
     * @return Entidade
     */
    public function addFkFolhapagamentoTcmbaPlanoSaudes(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaPlanoSaude $fkFolhapagamentoTcmbaPlanoSaude)
    {
        if (false === $this->fkFolhapagamentoTcmbaPlanoSaudes->contains($fkFolhapagamentoTcmbaPlanoSaude)) {
            $fkFolhapagamentoTcmbaPlanoSaude->setFkOrcamentoEntidade($this);
            $this->fkFolhapagamentoTcmbaPlanoSaudes->add($fkFolhapagamentoTcmbaPlanoSaude);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaPlanoSaude
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaPlanoSaude $fkFolhapagamentoTcmbaPlanoSaude
     */
    public function removeFkFolhapagamentoTcmbaPlanoSaudes(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaPlanoSaude $fkFolhapagamentoTcmbaPlanoSaude)
    {
        $this->fkFolhapagamentoTcmbaPlanoSaudes->removeElement($fkFolhapagamentoTcmbaPlanoSaude);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaPlanoSaudes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaPlanoSaude
     */
    public function getFkFolhapagamentoTcmbaPlanoSaudes()
    {
        return $this->fkFolhapagamentoTcmbaPlanoSaudes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaSalarioDescontos
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioDescontos $fkFolhapagamentoTcmbaSalarioDescontos
     * @return Entidade
     */
    public function addFkFolhapagamentoTcmbaSalarioDescontos(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioDescontos $fkFolhapagamentoTcmbaSalarioDescontos)
    {
        if (false === $this->fkFolhapagamentoTcmbaSalarioDescontos->contains($fkFolhapagamentoTcmbaSalarioDescontos)) {
            $fkFolhapagamentoTcmbaSalarioDescontos->setFkOrcamentoEntidade($this);
            $this->fkFolhapagamentoTcmbaSalarioDescontos->add($fkFolhapagamentoTcmbaSalarioDescontos);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaSalarioDescontos
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioDescontos $fkFolhapagamentoTcmbaSalarioDescontos
     */
    public function removeFkFolhapagamentoTcmbaSalarioDescontos(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioDescontos $fkFolhapagamentoTcmbaSalarioDescontos)
    {
        $this->fkFolhapagamentoTcmbaSalarioDescontos->removeElement($fkFolhapagamentoTcmbaSalarioDescontos);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaSalarioDescontos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioDescontos
     */
    public function getFkFolhapagamentoTcmbaSalarioDescontos()
    {
        return $this->fkFolhapagamentoTcmbaSalarioDescontos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaSalarioFamilia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioFamilia $fkFolhapagamentoTcmbaSalarioFamilia
     * @return Entidade
     */
    public function addFkFolhapagamentoTcmbaSalarioFamilias(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioFamilia $fkFolhapagamentoTcmbaSalarioFamilia)
    {
        if (false === $this->fkFolhapagamentoTcmbaSalarioFamilias->contains($fkFolhapagamentoTcmbaSalarioFamilia)) {
            $fkFolhapagamentoTcmbaSalarioFamilia->setFkOrcamentoEntidade($this);
            $this->fkFolhapagamentoTcmbaSalarioFamilias->add($fkFolhapagamentoTcmbaSalarioFamilia);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaSalarioFamilia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioFamilia $fkFolhapagamentoTcmbaSalarioFamilia
     */
    public function removeFkFolhapagamentoTcmbaSalarioFamilias(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioFamilia $fkFolhapagamentoTcmbaSalarioFamilia)
    {
        $this->fkFolhapagamentoTcmbaSalarioFamilias->removeElement($fkFolhapagamentoTcmbaSalarioFamilia);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaSalarioFamilias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioFamilia
     */
    public function getFkFolhapagamentoTcmbaSalarioFamilias()
    {
        return $this->fkFolhapagamentoTcmbaSalarioFamilias;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaSalarioHorasExtras
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioHorasExtras $fkFolhapagamentoTcmbaSalarioHorasExtras
     * @return Entidade
     */
    public function addFkFolhapagamentoTcmbaSalarioHorasExtras(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioHorasExtras $fkFolhapagamentoTcmbaSalarioHorasExtras)
    {
        if (false === $this->fkFolhapagamentoTcmbaSalarioHorasExtras->contains($fkFolhapagamentoTcmbaSalarioHorasExtras)) {
            $fkFolhapagamentoTcmbaSalarioHorasExtras->setFkOrcamentoEntidade($this);
            $this->fkFolhapagamentoTcmbaSalarioHorasExtras->add($fkFolhapagamentoTcmbaSalarioHorasExtras);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaSalarioHorasExtras
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioHorasExtras $fkFolhapagamentoTcmbaSalarioHorasExtras
     */
    public function removeFkFolhapagamentoTcmbaSalarioHorasExtras(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioHorasExtras $fkFolhapagamentoTcmbaSalarioHorasExtras)
    {
        $this->fkFolhapagamentoTcmbaSalarioHorasExtras->removeElement($fkFolhapagamentoTcmbaSalarioHorasExtras);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaSalarioHorasExtras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioHorasExtras
     */
    public function getFkFolhapagamentoTcmbaSalarioHorasExtras()
    {
        return $this->fkFolhapagamentoTcmbaSalarioHorasExtras;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaVantagensSalariais
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaVantagensSalariais $fkFolhapagamentoTcmbaVantagensSalariais
     * @return Entidade
     */
    public function addFkFolhapagamentoTcmbaVantagensSalariais(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaVantagensSalariais $fkFolhapagamentoTcmbaVantagensSalariais)
    {
        if (false === $this->fkFolhapagamentoTcmbaVantagensSalariais->contains($fkFolhapagamentoTcmbaVantagensSalariais)) {
            $fkFolhapagamentoTcmbaVantagensSalariais->setFkOrcamentoEntidade($this);
            $this->fkFolhapagamentoTcmbaVantagensSalariais->add($fkFolhapagamentoTcmbaVantagensSalariais);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaVantagensSalariais
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaVantagensSalariais $fkFolhapagamentoTcmbaVantagensSalariais
     */
    public function removeFkFolhapagamentoTcmbaVantagensSalariais(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaVantagensSalariais $fkFolhapagamentoTcmbaVantagensSalariais)
    {
        $this->fkFolhapagamentoTcmbaVantagensSalariais->removeElement($fkFolhapagamentoTcmbaVantagensSalariais);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaVantagensSalariais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaVantagensSalariais
     */
    public function getFkFolhapagamentoTcmbaVantagensSalariais()
    {
        return $this->fkFolhapagamentoTcmbaVantagensSalariais;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     * @return Entidade
     */
    public function addFkLicitacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        if (false === $this->fkLicitacaoContratos->contains($fkLicitacaoContrato)) {
            $fkLicitacaoContrato->setFkOrcamentoEntidade($this);
            $this->fkLicitacaoContratos->add($fkLicitacaoContrato);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     */
    public function removeFkLicitacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        $this->fkLicitacaoContratos->removeElement($fkLicitacaoContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    public function getFkLicitacaoContratos()
    {
        return $this->fkLicitacaoContratos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return Entidade
     */
    public function addFkLicitacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        if (false === $this->fkLicitacaoLicitacoes->contains($fkLicitacaoLicitacao)) {
            $fkLicitacaoLicitacao->setFkOrcamentoEntidade($this);
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
     * Add ManadAjusteRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\AjusteRecursoModeloLrf $fkManadAjusteRecursoModeloLrf
     * @return Entidade
     */
    public function addFkManadAjusteRecursoModeloLrfs(\Urbem\CoreBundle\Entity\Manad\AjusteRecursoModeloLrf $fkManadAjusteRecursoModeloLrf)
    {
        if (false === $this->fkManadAjusteRecursoModeloLrfs->contains($fkManadAjusteRecursoModeloLrf)) {
            $fkManadAjusteRecursoModeloLrf->setFkOrcamentoEntidade($this);
            $this->fkManadAjusteRecursoModeloLrfs->add($fkManadAjusteRecursoModeloLrf);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ManadAjusteRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\AjusteRecursoModeloLrf $fkManadAjusteRecursoModeloLrf
     */
    public function removeFkManadAjusteRecursoModeloLrfs(\Urbem\CoreBundle\Entity\Manad\AjusteRecursoModeloLrf $fkManadAjusteRecursoModeloLrf)
    {
        $this->fkManadAjusteRecursoModeloLrfs->removeElement($fkManadAjusteRecursoModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkManadAjusteRecursoModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\AjusteRecursoModeloLrf
     */
    public function getFkManadAjusteRecursoModeloLrfs()
    {
        return $this->fkManadAjusteRecursoModeloLrfs;
    }

    /**
     * OneToMany (owning side)
     * Add ManadAjustePlanoContaModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\AjustePlanoContaModeloLrf $fkManadAjustePlanoContaModeloLrf
     * @return Entidade
     */
    public function addFkManadAjustePlanoContaModeloLrfs(\Urbem\CoreBundle\Entity\Manad\AjustePlanoContaModeloLrf $fkManadAjustePlanoContaModeloLrf)
    {
        if (false === $this->fkManadAjustePlanoContaModeloLrfs->contains($fkManadAjustePlanoContaModeloLrf)) {
            $fkManadAjustePlanoContaModeloLrf->setFkOrcamentoEntidade($this);
            $this->fkManadAjustePlanoContaModeloLrfs->add($fkManadAjustePlanoContaModeloLrf);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ManadAjustePlanoContaModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\AjustePlanoContaModeloLrf $fkManadAjustePlanoContaModeloLrf
     */
    public function removeFkManadAjustePlanoContaModeloLrfs(\Urbem\CoreBundle\Entity\Manad\AjustePlanoContaModeloLrf $fkManadAjustePlanoContaModeloLrf)
    {
        $this->fkManadAjustePlanoContaModeloLrfs->removeElement($fkManadAjustePlanoContaModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkManadAjustePlanoContaModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\AjustePlanoContaModeloLrf
     */
    public function getFkManadAjustePlanoContaModeloLrfs()
    {
        return $this->fkManadAjustePlanoContaModeloLrfs;
    }

    /**
     * OneToMany (owning side)
     * Add ManadPlanoContaEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Manad\PlanoContaEntidade $fkManadPlanoContaEntidade
     * @return Entidade
     */
    public function addFkManadPlanoContaEntidades(\Urbem\CoreBundle\Entity\Manad\PlanoContaEntidade $fkManadPlanoContaEntidade)
    {
        if (false === $this->fkManadPlanoContaEntidades->contains($fkManadPlanoContaEntidade)) {
            $fkManadPlanoContaEntidade->setFkOrcamentoEntidade($this);
            $this->fkManadPlanoContaEntidades->add($fkManadPlanoContaEntidade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ManadPlanoContaEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Manad\PlanoContaEntidade $fkManadPlanoContaEntidade
     */
    public function removeFkManadPlanoContaEntidades(\Urbem\CoreBundle\Entity\Manad\PlanoContaEntidade $fkManadPlanoContaEntidade)
    {
        $this->fkManadPlanoContaEntidades->removeElement($fkManadPlanoContaEntidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkManadPlanoContaEntidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\PlanoContaEntidade
     */
    public function getFkManadPlanoContaEntidades()
    {
        return $this->fkManadPlanoContaEntidades;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return Entidade
     */
    public function addFkOrcamentoReceitas(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        if (false === $this->fkOrcamentoReceitas->contains($fkOrcamentoReceita)) {
            $fkOrcamentoReceita->setFkOrcamentoEntidade($this);
            $this->fkOrcamentoReceitas->add($fkOrcamentoReceita);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     */
    public function removeFkOrcamentoReceitas(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        $this->fkOrcamentoReceitas->removeElement($fkOrcamentoReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    public function getFkOrcamentoReceitas()
    {
        return $this->fkOrcamentoReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoUsuarioEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade $fkOrcamentoUsuarioEntidade
     * @return Entidade
     */
    public function addFkOrcamentoUsuarioEntidades(\Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade $fkOrcamentoUsuarioEntidade)
    {
        if (false === $this->fkOrcamentoUsuarioEntidades->contains($fkOrcamentoUsuarioEntidade)) {
            $fkOrcamentoUsuarioEntidade->setFkOrcamentoEntidade($this);
            $this->fkOrcamentoUsuarioEntidades->add($fkOrcamentoUsuarioEntidade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoUsuarioEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade $fkOrcamentoUsuarioEntidade
     */
    public function removeFkOrcamentoUsuarioEntidades(\Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade $fkOrcamentoUsuarioEntidade)
    {
        $this->fkOrcamentoUsuarioEntidades->removeElement($fkOrcamentoUsuarioEntidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoUsuarioEntidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade
     */
    public function getFkOrcamentoUsuarioEntidades()
    {
        return $this->fkOrcamentoUsuarioEntidades;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioBemComprado
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemComprado $fkPatrimonioBemComprado
     * @return Entidade
     */
    public function addFkPatrimonioBemComprados(\Urbem\CoreBundle\Entity\Patrimonio\BemComprado $fkPatrimonioBemComprado)
    {
        if (false === $this->fkPatrimonioBemComprados->contains($fkPatrimonioBemComprado)) {
            $fkPatrimonioBemComprado->setFkOrcamentoEntidade($this);
            $this->fkPatrimonioBemComprados->add($fkPatrimonioBemComprado);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioBemComprado
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemComprado $fkPatrimonioBemComprado
     */
    public function removeFkPatrimonioBemComprados(\Urbem\CoreBundle\Entity\Patrimonio\BemComprado $fkPatrimonioBemComprado)
    {
        $this->fkPatrimonioBemComprados->removeElement($fkPatrimonioBemComprado);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioBemComprados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemComprado
     */
    public function getFkPatrimonioBemComprados()
    {
        return $this->fkPatrimonioBemComprados;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioVeiculoUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\VeiculoUniorcam $fkPatrimonioVeiculoUniorcam
     * @return Entidade
     */
    public function addFkPatrimonioVeiculoUniorcans(\Urbem\CoreBundle\Entity\Patrimonio\VeiculoUniorcam $fkPatrimonioVeiculoUniorcam)
    {
        if (false === $this->fkPatrimonioVeiculoUniorcans->contains($fkPatrimonioVeiculoUniorcam)) {
            $fkPatrimonioVeiculoUniorcam->setFkOrcamentoEntidade($this);
            $this->fkPatrimonioVeiculoUniorcans->add($fkPatrimonioVeiculoUniorcam);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioVeiculoUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\VeiculoUniorcam $fkPatrimonioVeiculoUniorcam
     */
    public function removeFkPatrimonioVeiculoUniorcans(\Urbem\CoreBundle\Entity\Patrimonio\VeiculoUniorcam $fkPatrimonioVeiculoUniorcam)
    {
        $this->fkPatrimonioVeiculoUniorcans->removeElement($fkPatrimonioVeiculoUniorcam);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioVeiculoUniorcans
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\VeiculoUniorcam
     */
    public function getFkPatrimonioVeiculoUniorcans()
    {
        return $this->fkPatrimonioVeiculoUniorcans;
    }

    /**
     * OneToMany (owning side)
     * Add StnVinculoFundeb
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoFundeb $fkStnVinculoFundeb
     * @return Entidade
     */
    public function addFkStnVinculoFundebs(\Urbem\CoreBundle\Entity\Stn\VinculoFundeb $fkStnVinculoFundeb)
    {
        if (false === $this->fkStnVinculoFundebs->contains($fkStnVinculoFundeb)) {
            $fkStnVinculoFundeb->setFkOrcamentoEntidade($this);
            $this->fkStnVinculoFundebs->add($fkStnVinculoFundeb);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnVinculoFundeb
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoFundeb $fkStnVinculoFundeb
     */
    public function removeFkStnVinculoFundebs(\Urbem\CoreBundle\Entity\Stn\VinculoFundeb $fkStnVinculoFundeb)
    {
        $this->fkStnVinculoFundebs->removeElement($fkStnVinculoFundeb);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnVinculoFundebs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoFundeb
     */
    public function getFkStnVinculoFundebs()
    {
        return $this->fkStnVinculoFundebs;
    }

    /**
     * OneToMany (owning side)
     * Add StnRiscosFiscais
     *
     * @param \Urbem\CoreBundle\Entity\Stn\RiscosFiscais $fkStnRiscosFiscais
     * @return Entidade
     */
    public function addFkStnRiscosFiscais(\Urbem\CoreBundle\Entity\Stn\RiscosFiscais $fkStnRiscosFiscais)
    {
        if (false === $this->fkStnRiscosFiscais->contains($fkStnRiscosFiscais)) {
            $fkStnRiscosFiscais->setFkOrcamentoEntidade($this);
            $this->fkStnRiscosFiscais->add($fkStnRiscosFiscais);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnRiscosFiscais
     *
     * @param \Urbem\CoreBundle\Entity\Stn\RiscosFiscais $fkStnRiscosFiscais
     */
    public function removeFkStnRiscosFiscais(\Urbem\CoreBundle\Entity\Stn\RiscosFiscais $fkStnRiscosFiscais)
    {
        $this->fkStnRiscosFiscais->removeElement($fkStnRiscosFiscais);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnRiscosFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\RiscosFiscais
     */
    public function getFkStnRiscosFiscais()
    {
        return $this->fkStnRiscosFiscais;
    }

    /**
     * OneToMany (owning side)
     * Add StnVinculoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso
     * @return Entidade
     */
    public function addFkStnVinculoRecursos(\Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso)
    {
        if (false === $this->fkStnVinculoRecursos->contains($fkStnVinculoRecurso)) {
            $fkStnVinculoRecurso->setFkOrcamentoEntidade($this);
            $this->fkStnVinculoRecursos->add($fkStnVinculoRecurso);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnVinculoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso
     */
    public function removeFkStnVinculoRecursos(\Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso)
    {
        $this->fkStnVinculoRecursos->removeElement($fkStnVinculoRecurso);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnVinculoRecursos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoRecurso
     */
    public function getFkStnVinculoRecursos()
    {
        return $this->fkStnVinculoRecursos;
    }

    /**
     * OneToMany (owning side)
     * Add StnDespesaPessoal
     *
     * @param \Urbem\CoreBundle\Entity\Stn\DespesaPessoal $fkStnDespesaPessoal
     * @return Entidade
     */
    public function addFkStnDespesaPessoais(\Urbem\CoreBundle\Entity\Stn\DespesaPessoal $fkStnDespesaPessoal)
    {
        if (false === $this->fkStnDespesaPessoais->contains($fkStnDespesaPessoal)) {
            $fkStnDespesaPessoal->setFkOrcamentoEntidade($this);
            $this->fkStnDespesaPessoais->add($fkStnDespesaPessoal);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnDespesaPessoal
     *
     * @param \Urbem\CoreBundle\Entity\Stn\DespesaPessoal $fkStnDespesaPessoal
     */
    public function removeFkStnDespesaPessoais(\Urbem\CoreBundle\Entity\Stn\DespesaPessoal $fkStnDespesaPessoal)
    {
        $this->fkStnDespesaPessoais->removeElement($fkStnDespesaPessoal);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnDespesaPessoais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\DespesaPessoal
     */
    public function getFkStnDespesaPessoais()
    {
        return $this->fkStnDespesaPessoais;
    }

    /**
     * OneToMany (owning side)
     * Add StnRreoAnexo13
     *
     * @param \Urbem\CoreBundle\Entity\Stn\RreoAnexo13 $fkStnRreoAnexo13
     * @return Entidade
     */
    public function addFkStnRreoAnexo13s(\Urbem\CoreBundle\Entity\Stn\RreoAnexo13 $fkStnRreoAnexo13)
    {
        if (false === $this->fkStnRreoAnexo13s->contains($fkStnRreoAnexo13)) {
            $fkStnRreoAnexo13->setFkOrcamentoEntidade($this);
            $this->fkStnRreoAnexo13s->add($fkStnRreoAnexo13);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnRreoAnexo13
     *
     * @param \Urbem\CoreBundle\Entity\Stn\RreoAnexo13 $fkStnRreoAnexo13
     */
    public function removeFkStnRreoAnexo13s(\Urbem\CoreBundle\Entity\Stn\RreoAnexo13 $fkStnRreoAnexo13)
    {
        $this->fkStnRreoAnexo13s->removeElement($fkStnRreoAnexo13);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnRreoAnexo13s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\RreoAnexo13
     */
    public function getFkStnRreoAnexo13s()
    {
        return $this->fkStnRreoAnexo13s;
    }

    /**
     * OneToMany (owning side)
     * Add StnReceitaCorrenteLiquida
     *
     * @param \Urbem\CoreBundle\Entity\Stn\ReceitaCorrenteLiquida $fkStnReceitaCorrenteLiquida
     * @return Entidade
     */
    public function addFkStnReceitaCorrenteLiquidas(\Urbem\CoreBundle\Entity\Stn\ReceitaCorrenteLiquida $fkStnReceitaCorrenteLiquida)
    {
        if (false === $this->fkStnReceitaCorrenteLiquidas->contains($fkStnReceitaCorrenteLiquida)) {
            $fkStnReceitaCorrenteLiquida->setFkOrcamentoEntidade($this);
            $this->fkStnReceitaCorrenteLiquidas->add($fkStnReceitaCorrenteLiquida);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnReceitaCorrenteLiquida
     *
     * @param \Urbem\CoreBundle\Entity\Stn\ReceitaCorrenteLiquida $fkStnReceitaCorrenteLiquida
     */
    public function removeFkStnReceitaCorrenteLiquidas(\Urbem\CoreBundle\Entity\Stn\ReceitaCorrenteLiquida $fkStnReceitaCorrenteLiquida)
    {
        $this->fkStnReceitaCorrenteLiquidas->removeElement($fkStnReceitaCorrenteLiquida);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnReceitaCorrenteLiquidas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\ReceitaCorrenteLiquida
     */
    public function getFkStnReceitaCorrenteLiquidas()
    {
        return $this->fkStnReceitaCorrenteLiquidas;
    }

    /**
     * OneToMany (owning side)
     * Add TcealDeParaTipoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo $fkTcealDeParaTipoCargo
     * @return Entidade
     */
    public function addFkTcealDeParaTipoCargos(\Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo $fkTcealDeParaTipoCargo)
    {
        if (false === $this->fkTcealDeParaTipoCargos->contains($fkTcealDeParaTipoCargo)) {
            $fkTcealDeParaTipoCargo->setFkOrcamentoEntidade($this);
            $this->fkTcealDeParaTipoCargos->add($fkTcealDeParaTipoCargo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcealDeParaTipoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo $fkTcealDeParaTipoCargo
     */
    public function removeFkTcealDeParaTipoCargos(\Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo $fkTcealDeParaTipoCargo)
    {
        $this->fkTcealDeParaTipoCargos->removeElement($fkTcealDeParaTipoCargo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcealDeParaTipoCargos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo
     */
    public function getFkTcealDeParaTipoCargos()
    {
        return $this->fkTcealDeParaTipoCargos;
    }

    /**
     * OneToMany (owning side)
     * Add TcealOcorrenciaFuncionalAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento $fkTcealOcorrenciaFuncionalAssentamento
     * @return Entidade
     */
    public function addFkTcealOcorrenciaFuncionalAssentamentos(\Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento $fkTcealOcorrenciaFuncionalAssentamento)
    {
        if (false === $this->fkTcealOcorrenciaFuncionalAssentamentos->contains($fkTcealOcorrenciaFuncionalAssentamento)) {
            $fkTcealOcorrenciaFuncionalAssentamento->setFkOrcamentoEntidade($this);
            $this->fkTcealOcorrenciaFuncionalAssentamentos->add($fkTcealOcorrenciaFuncionalAssentamento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcealOcorrenciaFuncionalAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento $fkTcealOcorrenciaFuncionalAssentamento
     */
    public function removeFkTcealOcorrenciaFuncionalAssentamentos(\Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento $fkTcealOcorrenciaFuncionalAssentamento)
    {
        $this->fkTcealOcorrenciaFuncionalAssentamentos->removeElement($fkTcealOcorrenciaFuncionalAssentamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcealOcorrenciaFuncionalAssentamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento
     */
    public function getFkTcealOcorrenciaFuncionalAssentamentos()
    {
        return $this->fkTcealOcorrenciaFuncionalAssentamentos;
    }

    /**
     * OneToMany (owning side)
     * Add TcealPublicacaoRreo
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\PublicacaoRreo $fkTcealPublicacaoRreo
     * @return Entidade
     */
    public function addFkTcealPublicacaoRreos(\Urbem\CoreBundle\Entity\Tceal\PublicacaoRreo $fkTcealPublicacaoRreo)
    {
        if (false === $this->fkTcealPublicacaoRreos->contains($fkTcealPublicacaoRreo)) {
            $fkTcealPublicacaoRreo->setFkOrcamentoEntidade($this);
            $this->fkTcealPublicacaoRreos->add($fkTcealPublicacaoRreo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcealPublicacaoRreo
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\PublicacaoRreo $fkTcealPublicacaoRreo
     */
    public function removeFkTcealPublicacaoRreos(\Urbem\CoreBundle\Entity\Tceal\PublicacaoRreo $fkTcealPublicacaoRreo)
    {
        $this->fkTcealPublicacaoRreos->removeElement($fkTcealPublicacaoRreo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcealPublicacaoRreos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\PublicacaoRreo
     */
    public function getFkTcealPublicacaoRreos()
    {
        return $this->fkTcealPublicacaoRreos;
    }

    /**
     * OneToMany (owning side)
     * Add TcealPublicacaoRgf
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\PublicacaoRgf $fkTcealPublicacaoRgf
     * @return Entidade
     */
    public function addFkTcealPublicacaoRgfs(\Urbem\CoreBundle\Entity\Tceal\PublicacaoRgf $fkTcealPublicacaoRgf)
    {
        if (false === $this->fkTcealPublicacaoRgfs->contains($fkTcealPublicacaoRgf)) {
            $fkTcealPublicacaoRgf->setFkOrcamentoEntidade($this);
            $this->fkTcealPublicacaoRgfs->add($fkTcealPublicacaoRgf);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcealPublicacaoRgf
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\PublicacaoRgf $fkTcealPublicacaoRgf
     */
    public function removeFkTcealPublicacaoRgfs(\Urbem\CoreBundle\Entity\Tceal\PublicacaoRgf $fkTcealPublicacaoRgf)
    {
        $this->fkTcealPublicacaoRgfs->removeElement($fkTcealPublicacaoRgf);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcealPublicacaoRgfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\PublicacaoRgf
     */
    public function getFkTcealPublicacaoRgfs()
    {
        return $this->fkTcealPublicacaoRgfs;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato
     * @return Entidade
     */
    public function addFkTcemgContratos(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        if (false === $this->fkTcemgContratos->contains($fkTcemgContrato)) {
            $fkTcemgContrato->setFkOrcamentoEntidade($this);
            $this->fkTcemgContratos->add($fkTcemgContrato);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato
     */
    public function removeFkTcemgContratos(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        $this->fkTcemgContratos->removeElement($fkTcemgContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    public function getFkTcemgContratos()
    {
        return $this->fkTcemgContratos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgContaBancaria
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContaBancaria $fkTcemgContaBancaria
     * @return Entidade
     */
    public function addFkTcemgContaBancarias(\Urbem\CoreBundle\Entity\Tcemg\ContaBancaria $fkTcemgContaBancaria)
    {
        if (false === $this->fkTcemgContaBancarias->contains($fkTcemgContaBancaria)) {
            $fkTcemgContaBancaria->setFkOrcamentoEntidade($this);
            $this->fkTcemgContaBancarias->add($fkTcemgContaBancaria);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContaBancaria
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContaBancaria $fkTcemgContaBancaria
     */
    public function removeFkTcemgContaBancarias(\Urbem\CoreBundle\Entity\Tcemg\ContaBancaria $fkTcemgContaBancaria)
    {
        $this->fkTcemgContaBancarias->removeElement($fkTcemgContaBancaria);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContaBancarias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContaBancaria
     */
    public function getFkTcemgContaBancarias()
    {
        return $this->fkTcemgContaBancarias;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgProjecaoAtuarial
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ProjecaoAtuarial $fkTcemgProjecaoAtuarial
     * @return Entidade
     */
    public function addFkTcemgProjecaoAtuariais(\Urbem\CoreBundle\Entity\Tcemg\ProjecaoAtuarial $fkTcemgProjecaoAtuarial)
    {
        if (false === $this->fkTcemgProjecaoAtuariais->contains($fkTcemgProjecaoAtuarial)) {
            $fkTcemgProjecaoAtuarial->setFkOrcamentoEntidade($this);
            $this->fkTcemgProjecaoAtuariais->add($fkTcemgProjecaoAtuarial);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgProjecaoAtuarial
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ProjecaoAtuarial $fkTcemgProjecaoAtuarial
     */
    public function removeFkTcemgProjecaoAtuariais(\Urbem\CoreBundle\Entity\Tcemg\ProjecaoAtuarial $fkTcemgProjecaoAtuarial)
    {
        $this->fkTcemgProjecaoAtuariais->removeElement($fkTcemgProjecaoAtuarial);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgProjecaoAtuariais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ProjecaoAtuarial
     */
    public function getFkTcemgProjecaoAtuariais()
    {
        return $this->fkTcemgProjecaoAtuariais;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgTetoRemuneratorio
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorio $fkTcemgTetoRemuneratorio
     * @return Entidade
     */
    public function addFkTcemgTetoRemuneratorios(\Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorio $fkTcemgTetoRemuneratorio)
    {
        if (false === $this->fkTcemgTetoRemuneratorios->contains($fkTcemgTetoRemuneratorio)) {
            $fkTcemgTetoRemuneratorio->setFkOrcamentoEntidade($this);
            $this->fkTcemgTetoRemuneratorios->add($fkTcemgTetoRemuneratorio);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgTetoRemuneratorio
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorio $fkTcemgTetoRemuneratorio
     */
    public function removeFkTcemgTetoRemuneratorios(\Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorio $fkTcemgTetoRemuneratorio)
    {
        $this->fkTcemgTetoRemuneratorios->removeElement($fkTcemgTetoRemuneratorio);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgTetoRemuneratorios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorio
     */
    public function getFkTcemgTetoRemuneratorios()
    {
        return $this->fkTcemgTetoRemuneratorios;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeAgenteEletivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\AgenteEletivo $fkTcepeAgenteEletivo
     * @return Entidade
     */
    public function addFkTcepeAgenteEletivos(\Urbem\CoreBundle\Entity\Tcepe\AgenteEletivo $fkTcepeAgenteEletivo)
    {
        if (false === $this->fkTcepeAgenteEletivos->contains($fkTcepeAgenteEletivo)) {
            $fkTcepeAgenteEletivo->setFkOrcamentoEntidade($this);
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
     * Add TcepeCgmAgentePolitico
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\CgmAgentePolitico $fkTcepeCgmAgentePolitico
     * @return Entidade
     */
    public function addFkTcepeCgmAgentePoliticos(\Urbem\CoreBundle\Entity\Tcepe\CgmAgentePolitico $fkTcepeCgmAgentePolitico)
    {
        if (false === $this->fkTcepeCgmAgentePoliticos->contains($fkTcepeCgmAgentePolitico)) {
            $fkTcepeCgmAgentePolitico->setFkOrcamentoEntidade($this);
            $this->fkTcepeCgmAgentePoliticos->add($fkTcepeCgmAgentePolitico);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeCgmAgentePolitico
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\CgmAgentePolitico $fkTcepeCgmAgentePolitico
     */
    public function removeFkTcepeCgmAgentePoliticos(\Urbem\CoreBundle\Entity\Tcepe\CgmAgentePolitico $fkTcepeCgmAgentePolitico)
    {
        $this->fkTcepeCgmAgentePoliticos->removeElement($fkTcepeCgmAgentePolitico);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeCgmAgentePoliticos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\CgmAgentePolitico
     */
    public function getFkTcepeCgmAgentePoliticos()
    {
        return $this->fkTcepeCgmAgentePoliticos;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeConfiguracaoOrdenador
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador $fkTcepeConfiguracaoOrdenador
     * @return Entidade
     */
    public function addFkTcepeConfiguracaoOrdenadores(\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador $fkTcepeConfiguracaoOrdenador)
    {
        if (false === $this->fkTcepeConfiguracaoOrdenadores->contains($fkTcepeConfiguracaoOrdenador)) {
            $fkTcepeConfiguracaoOrdenador->setFkOrcamentoEntidade($this);
            $this->fkTcepeConfiguracaoOrdenadores->add($fkTcepeConfiguracaoOrdenador);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeConfiguracaoOrdenador
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador $fkTcepeConfiguracaoOrdenador
     */
    public function removeFkTcepeConfiguracaoOrdenadores(\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador $fkTcepeConfiguracaoOrdenador)
    {
        $this->fkTcepeConfiguracaoOrdenadores->removeElement($fkTcepeConfiguracaoOrdenador);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeConfiguracaoOrdenadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador
     */
    public function getFkTcepeConfiguracaoOrdenadores()
    {
        return $this->fkTcepeConfiguracaoOrdenadores;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeConfiguracaoGestor
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor $fkTcepeConfiguracaoGestor
     * @return Entidade
     */
    public function addFkTcepeConfiguracaoGestores(\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor $fkTcepeConfiguracaoGestor)
    {
        if (false === $this->fkTcepeConfiguracaoGestores->contains($fkTcepeConfiguracaoGestor)) {
            $fkTcepeConfiguracaoGestor->setFkOrcamentoEntidade($this);
            $this->fkTcepeConfiguracaoGestores->add($fkTcepeConfiguracaoGestor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeConfiguracaoGestor
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor $fkTcepeConfiguracaoGestor
     */
    public function removeFkTcepeConfiguracaoGestores(\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor $fkTcepeConfiguracaoGestor)
    {
        $this->fkTcepeConfiguracaoGestores->removeElement($fkTcepeConfiguracaoGestor);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeConfiguracaoGestores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor
     */
    public function getFkTcepeConfiguracaoGestores()
    {
        return $this->fkTcepeConfiguracaoGestores;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeDividaFundadaOperacaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOperacaoCredito $fkTcepeDividaFundadaOperacaoCredito
     * @return Entidade
     */
    public function addFkTcepeDividaFundadaOperacaoCreditos(\Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOperacaoCredito $fkTcepeDividaFundadaOperacaoCredito)
    {
        if (false === $this->fkTcepeDividaFundadaOperacaoCreditos->contains($fkTcepeDividaFundadaOperacaoCredito)) {
            $fkTcepeDividaFundadaOperacaoCredito->setFkOrcamentoEntidade($this);
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
     * Add TcepeFonteRecursoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal $fkTcepeFonteRecursoLocal
     * @return Entidade
     */
    public function addFkTcepeFonteRecursoLocais(\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal $fkTcepeFonteRecursoLocal)
    {
        if (false === $this->fkTcepeFonteRecursoLocais->contains($fkTcepeFonteRecursoLocal)) {
            $fkTcepeFonteRecursoLocal->setFkOrcamentoEntidade($this);
            $this->fkTcepeFonteRecursoLocais->add($fkTcepeFonteRecursoLocal);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeFonteRecursoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal $fkTcepeFonteRecursoLocal
     */
    public function removeFkTcepeFonteRecursoLocais(\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal $fkTcepeFonteRecursoLocal)
    {
        $this->fkTcepeFonteRecursoLocais->removeElement($fkTcepeFonteRecursoLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeFonteRecursoLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal
     */
    public function getFkTcepeFonteRecursoLocais()
    {
        return $this->fkTcepeFonteRecursoLocais;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeFonteRecursoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao $fkTcepeFonteRecursoLotacao
     * @return Entidade
     */
    public function addFkTcepeFonteRecursoLotacoes(\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao $fkTcepeFonteRecursoLotacao)
    {
        if (false === $this->fkTcepeFonteRecursoLotacoes->contains($fkTcepeFonteRecursoLotacao)) {
            $fkTcepeFonteRecursoLotacao->setFkOrcamentoEntidade($this);
            $this->fkTcepeFonteRecursoLotacoes->add($fkTcepeFonteRecursoLotacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeFonteRecursoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao $fkTcepeFonteRecursoLotacao
     */
    public function removeFkTcepeFonteRecursoLotacoes(\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao $fkTcepeFonteRecursoLotacao)
    {
        $this->fkTcepeFonteRecursoLotacoes->removeElement($fkTcepeFonteRecursoLotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeFonteRecursoLotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao
     */
    public function getFkTcepeFonteRecursoLotacoes()
    {
        return $this->fkTcepeFonteRecursoLotacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeOrcamentoModalidadeDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa $fkTcepeOrcamentoModalidadeDespesa
     * @return Entidade
     */
    public function addFkTcepeOrcamentoModalidadeDespesas(\Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa $fkTcepeOrcamentoModalidadeDespesa)
    {
        if (false === $this->fkTcepeOrcamentoModalidadeDespesas->contains($fkTcepeOrcamentoModalidadeDespesa)) {
            $fkTcepeOrcamentoModalidadeDespesa->setFkOrcamentoEntidade($this);
            $this->fkTcepeOrcamentoModalidadeDespesas->add($fkTcepeOrcamentoModalidadeDespesa);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeOrcamentoModalidadeDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa $fkTcepeOrcamentoModalidadeDespesa
     */
    public function removeFkTcepeOrcamentoModalidadeDespesas(\Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa $fkTcepeOrcamentoModalidadeDespesa)
    {
        $this->fkTcepeOrcamentoModalidadeDespesas->removeElement($fkTcepeOrcamentoModalidadeDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeOrcamentoModalidadeDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa
     */
    public function getFkTcepeOrcamentoModalidadeDespesas()
    {
        return $this->fkTcepeOrcamentoModalidadeDespesas;
    }

    /**
     * OneToMany (owning side)
     * Add TcernSubDivisaoDescricaoSiai
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai $fkTcernSubDivisaoDescricaoSiai
     * @return Entidade
     */
    public function addFkTcernSubDivisaoDescricaoSiais(\Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai $fkTcernSubDivisaoDescricaoSiai)
    {
        if (false === $this->fkTcernSubDivisaoDescricaoSiais->contains($fkTcernSubDivisaoDescricaoSiai)) {
            $fkTcernSubDivisaoDescricaoSiai->setFkOrcamentoEntidade($this);
            $this->fkTcernSubDivisaoDescricaoSiais->add($fkTcernSubDivisaoDescricaoSiai);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernSubDivisaoDescricaoSiai
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai $fkTcernSubDivisaoDescricaoSiai
     */
    public function removeFkTcernSubDivisaoDescricaoSiais(\Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai $fkTcernSubDivisaoDescricaoSiai)
    {
        $this->fkTcernSubDivisaoDescricaoSiais->removeElement($fkTcernSubDivisaoDescricaoSiai);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernSubDivisaoDescricaoSiais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai
     */
    public function getFkTcernSubDivisaoDescricaoSiais()
    {
        return $this->fkTcernSubDivisaoDescricaoSiais;
    }

    /**
     * OneToMany (owning side)
     * Add TcersPlanoContaEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\PlanoContaEntidade $fkTcersPlanoContaEntidade
     * @return Entidade
     */
    public function addFkTcersPlanoContaEntidades(\Urbem\CoreBundle\Entity\Tcers\PlanoContaEntidade $fkTcersPlanoContaEntidade)
    {
        if (false === $this->fkTcersPlanoContaEntidades->contains($fkTcersPlanoContaEntidade)) {
            $fkTcersPlanoContaEntidade->setFkOrcamentoEntidade($this);
            $this->fkTcersPlanoContaEntidades->add($fkTcersPlanoContaEntidade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcersPlanoContaEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\PlanoContaEntidade $fkTcersPlanoContaEntidade
     */
    public function removeFkTcersPlanoContaEntidades(\Urbem\CoreBundle\Entity\Tcers\PlanoContaEntidade $fkTcersPlanoContaEntidade)
    {
        $this->fkTcersPlanoContaEntidades->removeElement($fkTcersPlanoContaEntidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcersPlanoContaEntidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\PlanoContaEntidade
     */
    public function getFkTcersPlanoContaEntidades()
    {
        return $this->fkTcersPlanoContaEntidades;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaConfiguracaoRatificador
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador $fkTcmbaConfiguracaoRatificador
     * @return Entidade
     */
    public function addFkTcmbaConfiguracaoRatificadores(\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador $fkTcmbaConfiguracaoRatificador)
    {
        if (false === $this->fkTcmbaConfiguracaoRatificadores->contains($fkTcmbaConfiguracaoRatificador)) {
            $fkTcmbaConfiguracaoRatificador->setFkOrcamentoEntidade($this);
            $this->fkTcmbaConfiguracaoRatificadores->add($fkTcmbaConfiguracaoRatificador);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaConfiguracaoRatificador
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador $fkTcmbaConfiguracaoRatificador
     */
    public function removeFkTcmbaConfiguracaoRatificadores(\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador $fkTcmbaConfiguracaoRatificador)
    {
        $this->fkTcmbaConfiguracaoRatificadores->removeElement($fkTcmbaConfiguracaoRatificador);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaConfiguracaoRatificadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador
     */
    public function getFkTcmbaConfiguracaoRatificadores()
    {
        return $this->fkTcmbaConfiguracaoRatificadores;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaLimiteAlteracaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\LimiteAlteracaoCredito $fkTcmbaLimiteAlteracaoCredito
     * @return Entidade
     */
    public function addFkTcmbaLimiteAlteracaoCreditos(\Urbem\CoreBundle\Entity\Tcmba\LimiteAlteracaoCredito $fkTcmbaLimiteAlteracaoCredito)
    {
        if (false === $this->fkTcmbaLimiteAlteracaoCreditos->contains($fkTcmbaLimiteAlteracaoCredito)) {
            $fkTcmbaLimiteAlteracaoCredito->setFkOrcamentoEntidade($this);
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
     * Add TcmbaObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra
     * @return Entidade
     */
    public function addFkTcmbaObras(\Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra)
    {
        if (false === $this->fkTcmbaObras->contains($fkTcmbaObra)) {
            $fkTcmbaObra->setFkOrcamentoEntidade($this);
            $this->fkTcmbaObras->add($fkTcmbaObra);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra
     */
    public function removeFkTcmbaObras(\Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra)
    {
        $this->fkTcmbaObras->removeElement($fkTcmbaObra);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaObras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\Obra
     */
    public function getFkTcmbaObras()
    {
        return $this->fkTcmbaObras;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaTermoParceria
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TermoParceria $fkTcmbaTermoParceria
     * @return Entidade
     */
    public function addFkTcmbaTermoParcerias(\Urbem\CoreBundle\Entity\Tcmba\TermoParceria $fkTcmbaTermoParceria)
    {
        if (false === $this->fkTcmbaTermoParcerias->contains($fkTcmbaTermoParceria)) {
            $fkTcmbaTermoParceria->setFkOrcamentoEntidade($this);
            $this->fkTcmbaTermoParcerias->add($fkTcmbaTermoParceria);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaTermoParceria
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TermoParceria $fkTcmbaTermoParceria
     */
    public function removeFkTcmbaTermoParcerias(\Urbem\CoreBundle\Entity\Tcmba\TermoParceria $fkTcmbaTermoParceria)
    {
        $this->fkTcmbaTermoParcerias->removeElement($fkTcmbaTermoParceria);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaTermoParcerias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\TermoParceria
     */
    public function getFkTcmbaTermoParcerias()
    {
        return $this->fkTcmbaTermoParcerias;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoConfiguracaoOrgaoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade $fkTcmgoConfiguracaoOrgaoUnidade
     * @return Entidade
     */
    public function addFkTcmgoConfiguracaoOrgaoUnidades(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade $fkTcmgoConfiguracaoOrgaoUnidade)
    {
        if (false === $this->fkTcmgoConfiguracaoOrgaoUnidades->contains($fkTcmgoConfiguracaoOrgaoUnidade)) {
            $fkTcmgoConfiguracaoOrgaoUnidade->setFkOrcamentoEntidade($this);
            $this->fkTcmgoConfiguracaoOrgaoUnidades->add($fkTcmgoConfiguracaoOrgaoUnidade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoConfiguracaoOrgaoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade $fkTcmgoConfiguracaoOrgaoUnidade
     */
    public function removeFkTcmgoConfiguracaoOrgaoUnidades(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade $fkTcmgoConfiguracaoOrgaoUnidade)
    {
        $this->fkTcmgoConfiguracaoOrgaoUnidades->removeElement($fkTcmgoConfiguracaoOrgaoUnidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoConfiguracaoOrgaoUnidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade
     */
    public function getFkTcmgoConfiguracaoOrgaoUnidades()
    {
        return $this->fkTcmgoConfiguracaoOrgaoUnidades;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelTecnico $fkTcmgoResponsavelTecnico
     * @return Entidade
     */
    public function addFkTcmgoResponsavelTecnicos(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelTecnico $fkTcmgoResponsavelTecnico)
    {
        if (false === $this->fkTcmgoResponsavelTecnicos->contains($fkTcmgoResponsavelTecnico)) {
            $fkTcmgoResponsavelTecnico->setFkOrcamentoEntidade($this);
            $this->fkTcmgoResponsavelTecnicos->add($fkTcmgoResponsavelTecnico);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelTecnico $fkTcmgoResponsavelTecnico
     */
    public function removeFkTcmgoResponsavelTecnicos(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelTecnico $fkTcmgoResponsavelTecnico)
    {
        $this->fkTcmgoResponsavelTecnicos->removeElement($fkTcmgoResponsavelTecnico);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoResponsavelTecnicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelTecnico
     */
    public function getFkTcmgoResponsavelTecnicos()
    {
        return $this->fkTcmgoResponsavelTecnicos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao
     * @return Entidade
     */
    public function addFkTesourariaArrecadacoes(\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao)
    {
        if (false === $this->fkTesourariaArrecadacoes->contains($fkTesourariaArrecadacao)) {
            $fkTesourariaArrecadacao->setFkOrcamentoEntidade($this);
            $this->fkTesourariaArrecadacoes->add($fkTesourariaArrecadacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao
     */
    public function removeFkTesourariaArrecadacoes(\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao)
    {
        $this->fkTesourariaArrecadacoes->removeElement($fkTesourariaArrecadacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaArrecadacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    public function getFkTesourariaArrecadacoes()
    {
        return $this->fkTesourariaArrecadacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletim
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim
     * @return Entidade
     */
    public function addFkTesourariaBoletins(\Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim)
    {
        if (false === $this->fkTesourariaBoletins->contains($fkTesourariaBoletim)) {
            $fkTesourariaBoletim->setFkOrcamentoEntidade($this);
            $this->fkTesourariaBoletins->add($fkTesourariaBoletim);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletim
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim
     */
    public function removeFkTesourariaBoletins(\Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim)
    {
        $this->fkTesourariaBoletins->removeElement($fkTesourariaBoletim);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletins
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Boletim
     */
    public function getFkTesourariaBoletins()
    {
        return $this->fkTesourariaBoletins;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBordero
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero
     * @return Entidade
     */
    public function addFkTesourariaBorderos(\Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero)
    {
        if (false === $this->fkTesourariaBorderos->contains($fkTesourariaBordero)) {
            $fkTesourariaBordero->setFkOrcamentoEntidade($this);
            $this->fkTesourariaBorderos->add($fkTesourariaBordero);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBordero
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero
     */
    public function removeFkTesourariaBorderos(\Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero)
    {
        $this->fkTesourariaBorderos->removeElement($fkTesourariaBordero);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBorderos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Bordero
     */
    public function getFkTesourariaBorderos()
    {
        return $this->fkTesourariaBorderos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Assinatura $fkTesourariaAssinatura
     * @return Entidade
     */
    public function addFkTesourariaAssinaturas(\Urbem\CoreBundle\Entity\Tesouraria\Assinatura $fkTesourariaAssinatura)
    {
        if (false === $this->fkTesourariaAssinaturas->contains($fkTesourariaAssinatura)) {
            $fkTesourariaAssinatura->setFkOrcamentoEntidade($this);
            $this->fkTesourariaAssinaturas->add($fkTesourariaAssinatura);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Assinatura $fkTesourariaAssinatura
     */
    public function removeFkTesourariaAssinaturas(\Urbem\CoreBundle\Entity\Tesouraria\Assinatura $fkTesourariaAssinatura)
    {
        $this->fkTesourariaAssinaturas->removeElement($fkTesourariaAssinatura);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaAssinaturas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Assinatura
     */
    public function getFkTesourariaAssinaturas()
    {
        return $this->fkTesourariaAssinaturas;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletimReaberto
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimReaberto $fkTesourariaBoletimReaberto
     * @return Entidade
     */
    public function addFkTesourariaBoletimReabertos(\Urbem\CoreBundle\Entity\Tesouraria\BoletimReaberto $fkTesourariaBoletimReaberto)
    {
        if (false === $this->fkTesourariaBoletimReabertos->contains($fkTesourariaBoletimReaberto)) {
            $fkTesourariaBoletimReaberto->setFkOrcamentoEntidade($this);
            $this->fkTesourariaBoletimReabertos->add($fkTesourariaBoletimReaberto);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimReaberto
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimReaberto $fkTesourariaBoletimReaberto
     */
    public function removeFkTesourariaBoletimReabertos(\Urbem\CoreBundle\Entity\Tesouraria\BoletimReaberto $fkTesourariaBoletimReaberto)
    {
        $this->fkTesourariaBoletimReabertos->removeElement($fkTesourariaBoletimReaberto);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimReabertos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimReaberto
     */
    public function getFkTesourariaBoletimReabertos()
    {
        return $this->fkTesourariaBoletimReabertos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletimFechado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado $fkTesourariaBoletimFechado
     * @return Entidade
     */
    public function addFkTesourariaBoletimFechados(\Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado $fkTesourariaBoletimFechado)
    {
        if (false === $this->fkTesourariaBoletimFechados->contains($fkTesourariaBoletimFechado)) {
            $fkTesourariaBoletimFechado->setFkOrcamentoEntidade($this);
            $this->fkTesourariaBoletimFechados->add($fkTesourariaBoletimFechado);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimFechado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado $fkTesourariaBoletimFechado
     */
    public function removeFkTesourariaBoletimFechados(\Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado $fkTesourariaBoletimFechado)
    {
        $this->fkTesourariaBoletimFechados->removeElement($fkTesourariaBoletimFechado);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimFechados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado
     */
    public function getFkTesourariaBoletimFechados()
    {
        return $this->fkTesourariaBoletimFechados;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaPermissaoTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\PermissaoTerminal $fkTesourariaPermissaoTerminal
     * @return Entidade
     */
    public function addFkTesourariaPermissaoTerminais(\Urbem\CoreBundle\Entity\Tesouraria\PermissaoTerminal $fkTesourariaPermissaoTerminal)
    {
        if (false === $this->fkTesourariaPermissaoTerminais->contains($fkTesourariaPermissaoTerminal)) {
            $fkTesourariaPermissaoTerminal->setFkOrcamentoEntidade($this);
            $this->fkTesourariaPermissaoTerminais->add($fkTesourariaPermissaoTerminal);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaPermissaoTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\PermissaoTerminal $fkTesourariaPermissaoTerminal
     */
    public function removeFkTesourariaPermissaoTerminais(\Urbem\CoreBundle\Entity\Tesouraria\PermissaoTerminal $fkTesourariaPermissaoTerminal)
    {
        $this->fkTesourariaPermissaoTerminais->removeElement($fkTesourariaPermissaoTerminal);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaPermissaoTerminais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\PermissaoTerminal
     */
    public function getFkTesourariaPermissaoTerminais()
    {
        return $this->fkTesourariaPermissaoTerminais;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoBibliotecaEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\BibliotecaEntidade $fkAdministracaoBibliotecaEntidade
     * @return Entidade
     */
    public function addFkAdministracaoBibliotecaEntidades(\Urbem\CoreBundle\Entity\Administracao\BibliotecaEntidade $fkAdministracaoBibliotecaEntidade)
    {
        if (false === $this->fkAdministracaoBibliotecaEntidades->contains($fkAdministracaoBibliotecaEntidade)) {
            $fkAdministracaoBibliotecaEntidade->setFkOrcamentoEntidade($this);
            $this->fkAdministracaoBibliotecaEntidades->add($fkAdministracaoBibliotecaEntidade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoBibliotecaEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\BibliotecaEntidade $fkAdministracaoBibliotecaEntidade
     */
    public function removeFkAdministracaoBibliotecaEntidades(\Urbem\CoreBundle\Entity\Administracao\BibliotecaEntidade $fkAdministracaoBibliotecaEntidade)
    {
        $this->fkAdministracaoBibliotecaEntidades->removeElement($fkAdministracaoBibliotecaEntidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoBibliotecaEntidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\BibliotecaEntidade
     */
    public function getFkAdministracaoBibliotecaEntidades()
    {
        return $this->fkAdministracaoBibliotecaEntidades;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho
     * @return Entidade
     */
    public function addFkEmpenhoAutorizacaoEmpenhos(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho)
    {
        if (false === $this->fkEmpenhoAutorizacaoEmpenhos->contains($fkEmpenhoAutorizacaoEmpenho)) {
            $fkEmpenhoAutorizacaoEmpenho->setFkOrcamentoEntidade($this);
            $this->fkEmpenhoAutorizacaoEmpenhos->add($fkEmpenhoAutorizacaoEmpenho);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho
     */
    public function removeFkEmpenhoAutorizacaoEmpenhos(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho)
    {
        $this->fkEmpenhoAutorizacaoEmpenhos->removeElement($fkEmpenhoAutorizacaoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoAutorizacaoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho
     */
    public function getFkEmpenhoAutorizacaoEmpenhos()
    {
        return $this->fkEmpenhoAutorizacaoEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra
     * @return Entidade
     */
    public function addFkTesourariaReciboExtras(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra)
    {
        if (false === $this->fkTesourariaReciboExtras->contains($fkTesourariaReciboExtra)) {
            $fkTesourariaReciboExtra->setFkOrcamentoEntidade($this);
            $this->fkTesourariaReciboExtras->add($fkTesourariaReciboExtra);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra
     */
    public function removeFkTesourariaReciboExtras(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra)
    {
        $this->fkTesourariaReciboExtras->removeElement($fkTesourariaReciboExtra);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaReciboExtras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra
     */
    public function getFkTesourariaReciboExtras()
    {
        return $this->fkTesourariaReciboExtras;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     * @return Entidade
     */
    public function addFkOrcamentoDespesas(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        if (false === $this->fkOrcamentoDespesas->contains($fkOrcamentoDespesa)) {
            $fkOrcamentoDespesa->setFkOrcamentoEntidade($this);
            $this->fkOrcamentoDespesas->add($fkOrcamentoDespesa);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     */
    public function removeFkOrcamentoDespesas(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        $this->fkOrcamentoDespesas->removeElement($fkOrcamentoDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    public function getFkOrcamentoDespesas()
    {
        return $this->fkOrcamentoDespesas;
    }

    /**
     * OneToMany (owning side)
     * Add TcersAjustePlanoContaModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\AjustePlanoContaModeloLrf $fkTcersAjustePlanoContaModeloLrf
     * @return Entidade
     */
    public function addFkTcersAjustePlanoContaModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\AjustePlanoContaModeloLrf $fkTcersAjustePlanoContaModeloLrf)
    {
        if (false === $this->fkTcersAjustePlanoContaModeloLrfs->contains($fkTcersAjustePlanoContaModeloLrf)) {
            $fkTcersAjustePlanoContaModeloLrf->setFkOrcamentoEntidade($this);
            $this->fkTcersAjustePlanoContaModeloLrfs->add($fkTcersAjustePlanoContaModeloLrf);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcersAjustePlanoContaModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\AjustePlanoContaModeloLrf $fkTcersAjustePlanoContaModeloLrf
     */
    public function removeFkTcersAjustePlanoContaModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\AjustePlanoContaModeloLrf $fkTcersAjustePlanoContaModeloLrf)
    {
        $this->fkTcersAjustePlanoContaModeloLrfs->removeElement($fkTcersAjustePlanoContaModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcersAjustePlanoContaModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\AjustePlanoContaModeloLrf
     */
    public function getFkTcersAjustePlanoContaModeloLrfs()
    {
        return $this->fkTcersAjustePlanoContaModeloLrfs;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgConvenioPlanoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConvenioPlanoBanco $fkTcemgConvenioPlanoBanco
     * @return Entidade
     */
    public function addFkTcemgConvenioPlanoBancos(\Urbem\CoreBundle\Entity\Tcemg\ConvenioPlanoBanco $fkTcemgConvenioPlanoBanco)
    {
        if (false === $this->fkTcemgConvenioPlanoBancos->contains($fkTcemgConvenioPlanoBanco)) {
            $fkTcemgConvenioPlanoBanco->setFkOrcamentoEntidade($this);
            $this->fkTcemgConvenioPlanoBancos->add($fkTcemgConvenioPlanoBanco);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgConvenioPlanoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConvenioPlanoBanco $fkTcemgConvenioPlanoBanco
     */
    public function removeFkTcemgConvenioPlanoBancos(\Urbem\CoreBundle\Entity\Tcemg\ConvenioPlanoBanco $fkTcemgConvenioPlanoBanco)
    {
        $this->fkTcemgConvenioPlanoBancos->removeElement($fkTcemgConvenioPlanoBanco);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgConvenioPlanoBancos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConvenioPlanoBanco
     */
    public function getFkTcemgConvenioPlanoBancos()
    {
        return $this->fkTcemgConvenioPlanoBancos;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeTipoTransferenciaRecebida
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida $fkTcepeTipoTransferenciaRecebida
     * @return Entidade
     */
    public function addFkTcepeTipoTransferenciaRecebidas(\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida $fkTcepeTipoTransferenciaRecebida)
    {
        if (false === $this->fkTcepeTipoTransferenciaRecebidas->contains($fkTcepeTipoTransferenciaRecebida)) {
            $fkTcepeTipoTransferenciaRecebida->setFkOrcamentoEntidade($this);
            $this->fkTcepeTipoTransferenciaRecebidas->add($fkTcepeTipoTransferenciaRecebida);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeTipoTransferenciaRecebida
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida $fkTcepeTipoTransferenciaRecebida
     */
    public function removeFkTcepeTipoTransferenciaRecebidas(\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida $fkTcepeTipoTransferenciaRecebida)
    {
        $this->fkTcepeTipoTransferenciaRecebidas->removeElement($fkTcepeTipoTransferenciaRecebida);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeTipoTransferenciaRecebidas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida
     */
    public function getFkTcepeTipoTransferenciaRecebidas()
    {
        return $this->fkTcepeTipoTransferenciaRecebidas;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaFonteRecursoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal $fkTcmbaFonteRecursoLocal
     * @return Entidade
     */
    public function addFkTcmbaFonteRecursoLocais(\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal $fkTcmbaFonteRecursoLocal)
    {
        if (false === $this->fkTcmbaFonteRecursoLocais->contains($fkTcmbaFonteRecursoLocal)) {
            $fkTcmbaFonteRecursoLocal->setFkOrcamentoEntidade($this);
            $this->fkTcmbaFonteRecursoLocais->add($fkTcmbaFonteRecursoLocal);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaFonteRecursoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal $fkTcmbaFonteRecursoLocal
     */
    public function removeFkTcmbaFonteRecursoLocais(\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal $fkTcmbaFonteRecursoLocal)
    {
        $this->fkTcmbaFonteRecursoLocais->removeElement($fkTcmbaFonteRecursoLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaFonteRecursoLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal
     */
    public function getFkTcmbaFonteRecursoLocais()
    {
        return $this->fkTcmbaFonteRecursoLocais;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaFonteRecursoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao $fkTcmbaFonteRecursoLotacao
     * @return Entidade
     */
    public function addFkTcmbaFonteRecursoLotacoes(\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao $fkTcmbaFonteRecursoLotacao)
    {
        if (false === $this->fkTcmbaFonteRecursoLotacoes->contains($fkTcmbaFonteRecursoLotacao)) {
            $fkTcmbaFonteRecursoLotacao->setFkOrcamentoEntidade($this);
            $this->fkTcmbaFonteRecursoLotacoes->add($fkTcmbaFonteRecursoLotacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaFonteRecursoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao $fkTcmbaFonteRecursoLotacao
     */
    public function removeFkTcmbaFonteRecursoLotacoes(\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao $fkTcmbaFonteRecursoLotacao)
    {
        $this->fkTcmbaFonteRecursoLotacoes->removeElement($fkTcmbaFonteRecursoLotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaFonteRecursoLotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao
     */
    public function getFkTcmbaFonteRecursoLotacoes()
    {
        return $this->fkTcmbaFonteRecursoLotacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Contrato $fkTcmgoContrato
     * @return Entidade
     */
    public function addFkTcmgoContratos(\Urbem\CoreBundle\Entity\Tcmgo\Contrato $fkTcmgoContrato)
    {
        if (false === $this->fkTcmgoContratos->contains($fkTcmgoContrato)) {
            $fkTcmgoContrato->setFkOrcamentoEntidade($this);
            $this->fkTcmgoContratos->add($fkTcmgoContrato);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Contrato $fkTcmgoContrato
     */
    public function removeFkTcmgoContratos(\Urbem\CoreBundle\Entity\Tcmgo\Contrato $fkTcmgoContrato)
    {
        $this->fkTcmgoContratos->removeElement($fkTcmgoContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\Contrato
     */
    public function getFkTcmgoContratos()
    {
        return $this->fkTcmgoContratos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaDote
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Dote $fkTesourariaDote
     * @return Entidade
     */
    public function addFkTesourariaDotes(\Urbem\CoreBundle\Entity\Tesouraria\Dote $fkTesourariaDote)
    {
        if (false === $this->fkTesourariaDotes->contains($fkTesourariaDote)) {
            $fkTesourariaDote->setFkOrcamentoEntidade($this);
            $this->fkTesourariaDotes->add($fkTesourariaDote);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaDote
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Dote $fkTesourariaDote
     */
    public function removeFkTesourariaDotes(\Urbem\CoreBundle\Entity\Tesouraria\Dote $fkTesourariaDote)
    {
        $this->fkTesourariaDotes->removeElement($fkTesourariaDote);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaDotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Dote
     */
    public function getFkTesourariaDotes()
    {
        return $this->fkTesourariaDotes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaCargoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor $fkFolhapagamentoTcmbaCargoServidor
     * @return Entidade
     */
    public function addFkFolhapagamentoTcmbaCargoServidores(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor $fkFolhapagamentoTcmbaCargoServidor)
    {
        if (false === $this->fkFolhapagamentoTcmbaCargoServidores->contains($fkFolhapagamentoTcmbaCargoServidor)) {
            $fkFolhapagamentoTcmbaCargoServidor->setFkOrcamentoEntidade($this);
            $this->fkFolhapagamentoTcmbaCargoServidores->add($fkFolhapagamentoTcmbaCargoServidor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaCargoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor $fkFolhapagamentoTcmbaCargoServidor
     */
    public function removeFkFolhapagamentoTcmbaCargoServidores(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor $fkFolhapagamentoTcmbaCargoServidor)
    {
        $this->fkFolhapagamentoTcmbaCargoServidores->removeElement($fkFolhapagamentoTcmbaCargoServidor);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaCargoServidores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor
     */
    public function getFkFolhapagamentoTcmbaCargoServidores()
    {
        return $this->fkFolhapagamentoTcmbaCargoServidores;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaSalarioBase
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioBase $fkFolhapagamentoTcmbaSalarioBase
     * @return Entidade
     */
    public function addFkFolhapagamentoTcmbaSalarioBases(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioBase $fkFolhapagamentoTcmbaSalarioBase)
    {
        if (false === $this->fkFolhapagamentoTcmbaSalarioBases->contains($fkFolhapagamentoTcmbaSalarioBase)) {
            $fkFolhapagamentoTcmbaSalarioBase->setFkOrcamentoEntidade($this);
            $this->fkFolhapagamentoTcmbaSalarioBases->add($fkFolhapagamentoTcmbaSalarioBase);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaSalarioBase
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioBase $fkFolhapagamentoTcmbaSalarioBase
     */
    public function removeFkFolhapagamentoTcmbaSalarioBases(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioBase $fkFolhapagamentoTcmbaSalarioBase)
    {
        $this->fkFolhapagamentoTcmbaSalarioBases->removeElement($fkFolhapagamentoTcmbaSalarioBase);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaSalarioBases
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioBase
     */
    public function getFkFolhapagamentoTcmbaSalarioBases()
    {
        return $this->fkFolhapagamentoTcmbaSalarioBases;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgNotaFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NotaFiscal $fkTcemgNotaFiscal
     * @return Entidade
     */
    public function addFkTcemgNotaFiscais(\Urbem\CoreBundle\Entity\Tcemg\NotaFiscal $fkTcemgNotaFiscal)
    {
        if (false === $this->fkTcemgNotaFiscais->contains($fkTcemgNotaFiscal)) {
            $fkTcemgNotaFiscal->setFkOrcamentoEntidade($this);
            $this->fkTcemgNotaFiscais->add($fkTcemgNotaFiscal);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgNotaFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NotaFiscal $fkTcemgNotaFiscal
     */
    public function removeFkTcemgNotaFiscais(\Urbem\CoreBundle\Entity\Tcemg\NotaFiscal $fkTcemgNotaFiscal)
    {
        $this->fkTcemgNotaFiscais->removeElement($fkTcemgNotaFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgNotaFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\NotaFiscal
     */
    public function getFkTcemgNotaFiscais()
    {
        return $this->fkTcemgNotaFiscais;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgTipoRegistroPreco
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoRegistroPreco $fkTcemgTipoRegistroPreco
     * @return Entidade
     */
    public function addFkTcemgTipoRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\TipoRegistroPreco $fkTcemgTipoRegistroPreco)
    {
        if (false === $this->fkTcemgTipoRegistroPrecos->contains($fkTcemgTipoRegistroPreco)) {
            $fkTcemgTipoRegistroPreco->setFkOrcamentoEntidade($this);
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
     * @return Entidade
     */
    public function addFkTcepeDividaFundadaOutraOperacaoCreditos(\Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOutraOperacaoCredito $fkTcepeDividaFundadaOutraOperacaoCredito)
    {
        if (false === $this->fkTcepeDividaFundadaOutraOperacaoCreditos->contains($fkTcepeDividaFundadaOutraOperacaoCredito)) {
            $fkTcepeDividaFundadaOutraOperacaoCredito->setFkOrcamentoEntidade($this);
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
     * Add TcepeResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ResponsavelTecnico $fkTcepeResponsavelTecnico
     * @return Entidade
     */
    public function addFkTcepeResponsavelTecnicos(\Urbem\CoreBundle\Entity\Tcepe\ResponsavelTecnico $fkTcepeResponsavelTecnico)
    {
        if (false === $this->fkTcepeResponsavelTecnicos->contains($fkTcepeResponsavelTecnico)) {
            $fkTcepeResponsavelTecnico->setFkOrcamentoEntidade($this);
            $this->fkTcepeResponsavelTecnicos->add($fkTcepeResponsavelTecnico);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ResponsavelTecnico $fkTcepeResponsavelTecnico
     */
    public function removeFkTcepeResponsavelTecnicos(\Urbem\CoreBundle\Entity\Tcepe\ResponsavelTecnico $fkTcepeResponsavelTecnico)
    {
        $this->fkTcepeResponsavelTecnicos->removeElement($fkTcepeResponsavelTecnico);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeResponsavelTecnicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\ResponsavelTecnico
     */
    public function getFkTcepeResponsavelTecnicos()
    {
        return $this->fkTcepeResponsavelTecnicos;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeTipoTransferenciaConcedida
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida $fkTcepeTipoTransferenciaConcedida
     * @return Entidade
     */
    public function addFkTcepeTipoTransferenciaConcedidas(\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida $fkTcepeTipoTransferenciaConcedida)
    {
        if (false === $this->fkTcepeTipoTransferenciaConcedidas->contains($fkTcepeTipoTransferenciaConcedida)) {
            $fkTcepeTipoTransferenciaConcedida->setFkOrcamentoEntidade($this);
            $this->fkTcepeTipoTransferenciaConcedidas->add($fkTcepeTipoTransferenciaConcedida);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeTipoTransferenciaConcedida
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida $fkTcepeTipoTransferenciaConcedida
     */
    public function removeFkTcepeTipoTransferenciaConcedidas(\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida $fkTcepeTipoTransferenciaConcedida)
    {
        $this->fkTcepeTipoTransferenciaConcedidas->removeElement($fkTcepeTipoTransferenciaConcedida);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeTipoTransferenciaConcedidas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida
     */
    public function getFkTcepeTipoTransferenciaConcedidas()
    {
        return $this->fkTcepeTipoTransferenciaConcedidas;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaConfiguracaoOrdenador
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador $fkTcmbaConfiguracaoOrdenador
     * @return Entidade
     */
    public function addFkTcmbaConfiguracaoOrdenadores(\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador $fkTcmbaConfiguracaoOrdenador)
    {
        if (false === $this->fkTcmbaConfiguracaoOrdenadores->contains($fkTcmbaConfiguracaoOrdenador)) {
            $fkTcmbaConfiguracaoOrdenador->setFkOrcamentoEntidade($this);
            $this->fkTcmbaConfiguracaoOrdenadores->add($fkTcmbaConfiguracaoOrdenador);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaConfiguracaoOrdenador
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador $fkTcmbaConfiguracaoOrdenador
     */
    public function removeFkTcmbaConfiguracaoOrdenadores(\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador $fkTcmbaConfiguracaoOrdenador)
    {
        $this->fkTcmbaConfiguracaoOrdenadores->removeElement($fkTcmbaConfiguracaoOrdenador);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaConfiguracaoOrdenadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador
     */
    public function getFkTcmbaConfiguracaoOrdenadores()
    {
        return $this->fkTcmbaConfiguracaoOrdenadores;
    }

    /**
     * OneToMany (owning side)
     * Add TcersAjusteRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\AjusteRecursoModeloLrf $fkTcersAjusteRecursoModeloLrf
     * @return Entidade
     */
    public function addFkTcersAjusteRecursoModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\AjusteRecursoModeloLrf $fkTcersAjusteRecursoModeloLrf)
    {
        if (false === $this->fkTcersAjusteRecursoModeloLrfs->contains($fkTcersAjusteRecursoModeloLrf)) {
            $fkTcersAjusteRecursoModeloLrf->setFkOrcamentoEntidade($this);
            $this->fkTcersAjusteRecursoModeloLrfs->add($fkTcersAjusteRecursoModeloLrf);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcersAjusteRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\AjusteRecursoModeloLrf $fkTcersAjusteRecursoModeloLrf
     */
    public function removeFkTcersAjusteRecursoModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\AjusteRecursoModeloLrf $fkTcersAjusteRecursoModeloLrf)
    {
        $this->fkTcersAjusteRecursoModeloLrfs->removeElement($fkTcersAjusteRecursoModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcersAjusteRecursoModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\AjusteRecursoModeloLrf
     */
    public function getFkTcersAjusteRecursoModeloLrfs()
    {
        return $this->fkTcersAjusteRecursoModeloLrfs;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletimLiberadoCancelado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado $fkTesourariaBoletimLiberadoCancelado
     * @return Entidade
     */
    public function addFkTesourariaBoletimLiberadoCancelados(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado $fkTesourariaBoletimLiberadoCancelado)
    {
        if (false === $this->fkTesourariaBoletimLiberadoCancelados->contains($fkTesourariaBoletimLiberadoCancelado)) {
            $fkTesourariaBoletimLiberadoCancelado->setFkOrcamentoEntidade($this);
            $this->fkTesourariaBoletimLiberadoCancelados->add($fkTesourariaBoletimLiberadoCancelado);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimLiberadoCancelado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado $fkTesourariaBoletimLiberadoCancelado
     */
    public function removeFkTesourariaBoletimLiberadoCancelados(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado $fkTesourariaBoletimLiberadoCancelado)
    {
        $this->fkTesourariaBoletimLiberadoCancelados->removeElement($fkTesourariaBoletimLiberadoCancelado);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimLiberadoCancelados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado
     */
    public function getFkTesourariaBoletimLiberadoCancelados()
    {
        return $this->fkTesourariaBoletimLiberadoCancelados;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoEmpenhoConvenios
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio $fkEmpenhoEmpenhoConvenios
     * @return Entidade
     */
    public function addFkEmpenhoEmpenhoConvenios(\Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio $fkEmpenhoEmpenhoConvenios)
    {
        if (false === $this->fkEmpenhoEmpenhoConvenios->contains($fkEmpenhoEmpenhoConvenios)) {
            $fkEmpenhoEmpenhoConvenios->setFkOrcamentoEntidade($this);
            $this->fkEmpenhoEmpenhoConvenios->add($fkEmpenhoEmpenhoConvenios);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoEmpenhoConvenios
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio $fkEmpenhoEmpenhoConvenios
     */
    public function removeFkEmpenhoEmpenhoConvenios(\Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio $fkEmpenhoEmpenhoConvenios)
    {
        $this->fkEmpenhoEmpenhoConvenios->removeElement($fkEmpenhoEmpenhoConvenios);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoEmpenhoConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio
     */
    public function getFkEmpenhoEmpenhoConvenios()
    {
        return $this->fkEmpenhoEmpenhoConvenios;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Entidade
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return Entidade
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->codResponsavel = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico $fkEconomicoResponsavelTecnico
     * @return Entidade
     */
    public function setFkEconomicoResponsavelTecnico(\Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico $fkEconomicoResponsavelTecnico)
    {
        $this->codRespTecnico = $fkEconomicoResponsavelTecnico->getNumcgm();
        $this->sequencia = $fkEconomicoResponsavelTecnico->getSequencia();
        $this->fkEconomicoResponsavelTecnico = $fkEconomicoResponsavelTecnico;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoResponsavelTecnico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico
     */
    public function getFkEconomicoResponsavelTecnico()
    {
        return $this->fkEconomicoResponsavelTecnico;
    }

    /**
     * OneToOne (inverse side)
     * Set OrcamentoEntidadeLogotipo
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\EntidadeLogotipo $fkOrcamentoEntidadeLogotipo
     * @return Entidade
     */
    public function setFkOrcamentoEntidadeLogotipo(\Urbem\CoreBundle\Entity\Orcamento\EntidadeLogotipo $fkOrcamentoEntidadeLogotipo)
    {
        $fkOrcamentoEntidadeLogotipo->setFkOrcamentoEntidade($this);
        $this->fkOrcamentoEntidadeLogotipo = $fkOrcamentoEntidadeLogotipo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkOrcamentoEntidadeLogotipo
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\EntidadeLogotipo
     */
    public function getFkOrcamentoEntidadeLogotipo()
    {
        return $this->fkOrcamentoEntidadeLogotipo;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgConfiguracaoReglic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoReglic $fkTcemgConfiguracaoReglic
     * @return Entidade
     */
    public function setFkTcemgConfiguracaoReglic(\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoReglic $fkTcemgConfiguracaoReglic)
    {
        $fkTcemgConfiguracaoReglic->setFkOrcamentoEntidade($this);
        $this->fkTcemgConfiguracaoReglic = $fkTcemgConfiguracaoReglic;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgConfiguracaoReglic
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoReglic
     */
    public function getFkTcemgConfiguracaoReglic()
    {
        return $this->fkTcemgConfiguracaoReglic;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgOperacaoCreditoAro
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\OperacaoCreditoAro $fkTcemgOperacaoCreditoAro
     * @return Entidade
     */
    public function setFkTcemgOperacaoCreditoAro(\Urbem\CoreBundle\Entity\Tcemg\OperacaoCreditoAro $fkTcemgOperacaoCreditoAro)
    {
        $fkTcemgOperacaoCreditoAro->setFkOrcamentoEntidade($this);
        $this->fkTcemgOperacaoCreditoAro = $fkTcemgOperacaoCreditoAro;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgOperacaoCreditoAro
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\OperacaoCreditoAro
     */
    public function getFkTcemgOperacaoCreditoAro()
    {
        return $this->fkTcemgOperacaoCreditoAro;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoConfiguracaoIde
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde
     * @return Entidade
     */
    public function setFkTcmgoConfiguracaoIde(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde)
    {
        $fkTcmgoConfiguracaoIde->setFkOrcamentoEntidade($this);
        $this->fkTcmgoConfiguracaoIde = $fkTcmgoConfiguracaoIde;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoConfiguracaoIde
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde
     */
    public function getFkTcmgoConfiguracaoIde()
    {
        return $this->fkTcmgoConfiguracaoIde;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codEntidade, strtoupper((!empty($this->fkSwCgm) ? $this->fkSwCgm->getNomCgm() : '')));
    }

    /**
     * @return string
     */
    public function getCustomEntidadeNomeToString()
    {
        return sprintf('%s', strtoupper((!empty($this->fkSwCgm) ? $this->fkSwCgm->getNomCgm() : '')));
    }
}
