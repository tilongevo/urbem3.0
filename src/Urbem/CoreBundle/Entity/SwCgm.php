<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwCgm
 */
class SwCgm
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $codMunicipio;

    /**
     * @var integer
     */
    private $codUf;

    /**
     * @var integer
     */
    private $codMunicipioCorresp;

    /**
     * @var integer
     */
    private $codUfCorresp;

    /**
     * @var integer
     */
    private $codResponsavel;

    /**
     * @var string
     */
    private $nomCgm;

    /**
     * @var string
     */
    private $logradouro;

    /**
     * @var string
     */
    private $numero;

    /**
     * @var string
     */
    private $complemento;

    /**
     * @var string
     */
    private $bairro;

    /**
     * @var string
     */
    private $cep;

    /**
     * @var string
     */
    private $logradouroCorresp;

    /**
     * @var string
     */
    private $numeroCorresp;

    /**
     * @var string
     */
    private $complementoCorresp;

    /**
     * @var string
     */
    private $bairroCorresp;

    /**
     * @var string
     */
    private $cepCorresp;

    /**
     * @var string
     */
    private $foneResidencial;

    /**
     * @var string
     */
    private $ramalResidencial;

    /**
     * @var string
     */
    private $foneComercial;

    /**
     * @var string
     */
    private $ramalComercial;

    /**
     * @var string
     */
    private $foneCelular;

    /**
     * @var string
     */
    private $eMail;

    /**
     * @var string
     */
    private $eMailAdcional;

    /**
     * @var \DateTime
     */
    private $dtCadastro;

    /**
     * @var integer
     */
    private $codPais;

    /**
     * @var integer
     */
    private $codPaisCorresp;

    /**
     * @var string
     */
    private $tipoLogradouroCorresp;

    /**
     * @var string
     */
    private $tipoLogradouro;

    /**
     * @var \DateTime
     */
    private $timestampInclusao;

    /**
     * @var \DateTime
     */
    private $timestampAlteracao;

    /**
     * @var string
     */
    private $site;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado
     */
    private $fkAlmoxarifadoAlmoxarifado;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    private $fkComprasFornecedor;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Compras\Solicitante
     */
    private $fkComprasSolicitante;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\Grafica
     */
    private $fkFiscalizacaoGrafica;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Frota\Escola
     */
    private $fkFrotaEscola;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Frota\Motorista
     */
    private $fkFrotaMotorista;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    private $fkLicitacaoVeiculosPublicidade;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\ArquivoPessoa
     */
    private $fkTcemgArquivoPessoa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcepb\Matriculas
     */
    private $fkTcepbMatriculas;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcepb\Servidores
     */
    private $fkTcepbServidores;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho
     */
    private $fkTcmbaSubvencaoEmpenho;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelTecnico
     */
    private $fkTcmgoResponsavelTecnico;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    private $fkSwCgmPessoaJuridica;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\ArquivoFolhaPessoa
     */
    private $fkTcemgArquivoFolhaPessoa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcepe\ResponsavelTecnico
     */
    private $fkTcepeResponsavelTecnico;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Orgao
     */
    private $fkAdministracaoOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoPermissao
     */
    private $fkAlmoxarifadoCentroCustoPermissoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\SaidaDiversa
     */
    private $fkAlmoxarifadoSaidaDiversas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoCgm
     */
    private $fkArrecadacaoDocumentoCgns;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Desonerado
     */
    private $fkArrecadacaoDesonerados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa
     */
    private $fkArrecadacaoNotaAvulsas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PermissaoCancelamento
     */
    private $fkArrecadacaoPermissaoCancelamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao
     */
    private $fkArrecadacaoServicoComRetencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota
     */
    private $fkArrecadacaoRetencaoNotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cgm\ContaCgm
     */
    private $fkCgmContaCgns;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cgm\CgmAlteracaoHistorico
     */
    private $fkCgmCgmAlteracaoHistoricos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Ordem
     */
    private $fkComprasOrdens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoEntrega
     */
    private $fkComprasSolicitacaoEntregas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Solicitacao
     */
    private $fkComprasSolicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Responsavel
     */
    private $fkCseResponsaveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaCgm
     */
    private $fkDividaDividaCgns;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\Sociedade
     */
    private $fkEconomicoSociedades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\Responsavel
     */
    private $fkEconomicoResponsaveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico
     */
    private $fkEconomicoResponsavelTecnicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenhoAssinatura
     */
    private $fkEmpenhoAutorizacaoEmpenhoAssinaturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\DespesasFixas
     */
    private $fkEmpenhoDespesasFixas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoAssinatura
     */
    private $fkEmpenhoEmpenhoAssinaturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoAssinatura
     */
    private $fkEmpenhoNotaLiquidacaoAssinaturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAssinatura
     */
    private $fkEmpenhoOrdemPagamentoAssinaturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnuladaAuditoria
     */
    private $fkEmpenhoNotaLiquidacaoPagaAnuladaAuditorias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    private $fkEmpenhoPreEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento
     */
    private $fkEmpenhoResponsavelAdiantamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAuditoria
     */
    private $fkEmpenhoNotaLiquidacaoPagaAuditorias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas
     */
    private $fkFiscalizacaoAutorizacaoNotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao
     */
    private $fkFiscalizacaoBaixaAutorizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota
     */
    private $fkFiscalizacaoRetencaoNotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao
     */
    private $fkFiscalizacaoServicoComRetencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho
     */
    private $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Terceiros
     */
    private $fkFrotaTerceiros;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\CagedAutorizadoCgm
     */
    private $fkImaCagedAutorizadoCgns;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais
     */
    private $fkImaConfiguracaoRais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf
     */
    private $fkImaConfiguracaoDirfs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf
     */
    private $fkImaConfiguracaoDirfs1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ExProprietario
     */
    private $fkImobiliarioExProprietarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaAdquirente
     */
    private $fkImobiliarioTransferenciaAdquirentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Proprietario
     */
    private $fkImobiliarioProprietarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos
     */
    private $fkLicitacaoContratoAditivos;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosPublicacao
     */
    private $fkLicitacaoConvenioAditivosPublicacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    private $fkLicitacaoContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros
     */
    private $fkLicitacaoComissaoMembros;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Participante
     */
    private $fkLicitacaoParticipantes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\MembroAdicional
     */
    private $fkLicitacaoMembroAdicionais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConsorcio
     */
    private $fkLicitacaoParticipanteConsorcios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Edital
     */
    private $fkLicitacaoEditais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\RescisaoConvenio
     */
    private $fkLicitacaoRescisaoConvenios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\RescisaoContratoResponsavelJuridico
     */
    private $fkLicitacaoRescisaoContratoResponsavelJuridicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoConvenio
     */
    private $fkLicitacaoPublicacaoRescisaoConvenios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Orgao
     */
    private $fkOrcamentoOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\OrgaoCgm
     */
    private $fkOrganogramaOrgaoCgns;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Apolice
     */
    private $fkPatrimonioApolices;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemResponsavel
     */
    private $fkPatrimonioBemResponsaveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Manutencao
     */
    private $fkPatrimonioManutencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AdidoCedido
     */
    private $fkPessoalAdidoCedidos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCga
     */
    private $fkSwCgas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgmLogradouroCorrespondencia
     */
    private $fkSwCgmLogradouroCorrespondencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgmLogradouro
     */
    private $fkSwCgmLogradouros;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgmAtributoValor
     */
    private $fkSwCgmAtributoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcessoArquivado
     */
    private $fkSwProcessoArquivados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPreEmpenho
     */
    private $fkSwPreEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcessoInteressado
     */
    private $fkSwProcessoInteressados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\Credor
     */
    private $fkTcealCredores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoDdc
     */
    private $fkTcemgConfiguracaoDdcs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    private $fkTcemgContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos
     */
    private $fkTcemgItemRegistroPrecos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos
     */
    private $fkTcemgRegistroPrecos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Uniorcam
     */
    private $fkTcemgUniorcans;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\Uniorcam
     */
    private $fkTcepbUniorcans;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\CgmTipoCredor
     */
    private $fkTcepeCgmTipoCredores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel
     */
    private $fkTcernUnidadeGestoraResponsaveis;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ObraContrato
     */
    private $fkTcernObraContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ObraContrato
     */
    private $fkTcernObraContratos1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\Credor
     */
    private $fkTcersCredores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraFiscal
     */
    private $fkTcmbaObraFiscais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde
     */
    private $fkTcmgoConfiguracaoIdes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde
     */
    private $fkTcmgoConfiguracaoIdes1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde
     */
    private $fkTcmgoConfiguracaoIdes2;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\DividaConsolidada
     */
    private $fkTcmgoDividaConsolidadas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\Orgao
     */
    private $fkTcmgoOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\OrgaoGestor
     */
    private $fkTcmgoOrgaoGestores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\OrgaoRepresentante
     */
    private $fkTcmgoOrgaoRepresentantes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    private $fkTcmgoUnidadeResponsaveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    private $fkTcmgoUnidadeResponsaveis1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    private $fkTcmgoUnidadeResponsaveis2;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    private $fkTcmgoUnidadeResponsaveis3;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\OrgaoControleInterno
     */
    private $fkTcmgoOrgaoControleInternos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Assinatura
     */
    private $fkTesourariaAssinaturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia
     */
    private $fkTesourariaTransacoesTransferencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAssinatura
     */
    private $fkTesourariaReciboExtraAssinaturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraCredor
     */
    private $fkTesourariaReciboExtraCredores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal
     */
    private $fkTesourariaUsuarioTerminais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Autorizacao
     */
    private $fkFrotaAutorizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Autorizacao
     */
    private $fkFrotaAutorizacoes1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Autorizacao
     */
    private $fkFrotaAutorizacoes2;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Beneficiario
     */
    private $fkBeneficioBeneficiarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Abastecimento
     */
    private $fkFrotaAbastecimentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\Requisicao
     */
    private $fkAlmoxarifadoRequisicoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CalculoCgm
     */
    private $fkArrecadacaoCalculoCgns;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorSocio
     */
    private $fkComprasFornecedorSocios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaDiversa
     */
    private $fkEconomicoLicencaDiversas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoTerceirosResponsavel
     */
    private $fkFrotaVeiculoTerceirosResponsaveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao
     */
    private $fkLicitacaoParticipanteCertificacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\Credor
     */
    private $fkManadCredores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    private $fkPatrimonioBens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcessoConfidencial
     */
    private $fkSwProcessoConfidenciais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor
     */
    private $fkTcemgContratoFornecedores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOutraOperacaoCredito
     */
    private $fkTcepeDividaFundadaOutraOperacaoCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento
     */
    private $fkTcernObraAcompanhamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel
     */
    private $fkTcernUnidadeOrcamentariaResponsaveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\Credor
     */
    private $fkTcetoCredores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaCredor
     */
    private $fkTesourariaTransferenciaCredores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwMunicipio
     */
    private $fkSwMunicipio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwPais
     */
    private $fkSwPais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwMunicipio
     */
    private $fkSwMunicipio1;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwPais
     */
    private $fkSwPais1;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoCentroCustoPermissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoSaidaDiversas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoDocumentoCgns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoDesonerados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoNotaAvulsas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPermissaoCancelamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoServicoComRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoRetencaoNotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkCgmContaCgns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkCgmCgmAlteracaoHistoricos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasOrdens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacaoEntregas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkCseResponsaveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaDividaCgns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoSociedades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoResponsaveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoResponsavelTecnicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoAutorizacaoEmpenhoAssinaturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoDespesasFixas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoEmpenhoAssinaturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoNotaLiquidacaoAssinaturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoOrdemPagamentoAssinaturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoNotaLiquidacaoPagaAnuladaAuditorias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoPreEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoResponsavelAdiantamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoNotaLiquidacaoPagaAuditorias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoAutorizacaoNotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoBaixaAutorizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoRetencaoNotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoServicoComRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaTerceiros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaCagedAutorizadoCgns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoRais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoDirfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoDirfs1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioExProprietarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioTransferenciaAdquirentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioProprietarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoContratoAditivos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoConvenioAditivos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoConvenioAditivosPublicacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoComissaoMembros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoParticipantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoMembroAdicionais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoParticipanteConsorcios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoEditais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoRescisaoConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoRescisaoContratoResponsavelJuridicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoPublicacaoRescisaoConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoUnidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaOrgaoCgns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioApolices = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioBemResponsaveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioManutencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAdidoCedidos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgmLogradouroCorrespondencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgmLogradouros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgmAtributoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwProcessoArquivados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwPreEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwProcessoInteressados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcealCredores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgConfiguracaoDdcs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgItemRegistroPrecos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgRegistroPrecos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgUniorcans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepbUniorcans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeCgmTipoCredores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernUnidadeGestoraResponsaveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernUnidadeGestoras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernUnidadeOrcamentarias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernObraContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernObraContratos1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcersCredores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaObraFiscais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoConfiguracaoIdes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoConfiguracaoIdes1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoConfiguracaoIdes2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoDividaConsolidadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoOrgaoGestores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoOrgaoRepresentantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoUnidadeResponsaveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoUnidadeResponsaveis1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoUnidadeResponsaveis2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoUnidadeResponsaveis3 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoOrgaoControleInternos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaAssinaturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransacoesTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaReciboExtraAssinaturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaReciboExtraCredores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaUsuarioTerminais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaAutorizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaAutorizacoes1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaAutorizacoes2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkBeneficioBeneficiarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaAbastecimentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoEntidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoRequisicoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoCalculoCgns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasFornecedorSocios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoLicencaDiversas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaVeiculoTerceirosResponsaveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoParticipanteCertificacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkManadCredores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioBens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwProcessoConfidenciais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgContratoFornecedores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeDividaFundadaOutraOperacaoCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernObraAcompanhamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernUnidadeOrcamentariaResponsaveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcetoCredores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferenciaCredores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtCadastro = new \DateTime;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return SwCgm
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
     * Set codMunicipio
     *
     * @param integer $codMunicipio
     * @return SwCgm
     */
    public function setCodMunicipio($codMunicipio)
    {
        $this->codMunicipio = $codMunicipio;
        return $this;
    }

    /**
     * Get codMunicipio
     *
     * @return integer
     */
    public function getCodMunicipio()
    {
        return $this->codMunicipio;
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return SwCgm
     */
    public function setCodUf($codUf)
    {
        $this->codUf = $codUf;
        return $this;
    }

    /**
     * Get codUf
     *
     * @return integer
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * Set codMunicipioCorresp
     *
     * @param integer $codMunicipioCorresp
     * @return SwCgm
     */
    public function setCodMunicipioCorresp($codMunicipioCorresp)
    {
        $this->codMunicipioCorresp = $codMunicipioCorresp;
        return $this;
    }

    /**
     * Get codMunicipioCorresp
     *
     * @return integer
     */
    public function getCodMunicipioCorresp()
    {
        return $this->codMunicipioCorresp;
    }

    /**
     * Set codUfCorresp
     *
     * @param integer $codUfCorresp
     * @return SwCgm
     */
    public function setCodUfCorresp($codUfCorresp)
    {
        $this->codUfCorresp = $codUfCorresp;
        return $this;
    }

    /**
     * Get codUfCorresp
     *
     * @return integer
     */
    public function getCodUfCorresp()
    {
        return $this->codUfCorresp;
    }

    /**
     * Set codResponsavel
     *
     * @param integer $codResponsavel
     * @return SwCgm
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
     * Set nomCgm
     *
     * @param string $nomCgm
     * @return SwCgm
     */
    public function setNomCgm($nomCgm)
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
     * Set logradouro
     *
     * @param string $logradouro
     * @return SwCgm
     */
    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;
        return $this;
    }

    /**
     * Get logradouro
     *
     * @return string
     */
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return SwCgm
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set complemento
     *
     * @param string $complemento
     * @return SwCgm
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
        return $this;
    }

    /**
     * Get complemento
     *
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Set bairro
     *
     * @param string $bairro
     * @return SwCgm
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
        return $this;
    }

    /**
     * Get bairro
     *
     * @return string
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * Set cep
     *
     * @param string $cep
     * @return SwCgm
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
        return $this;
    }

    /**
     * Get cep
     *
     * @return string
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set logradouroCorresp
     *
     * @param string $logradouroCorresp
     * @return SwCgm
     */
    public function setLogradouroCorresp($logradouroCorresp)
    {
        $this->logradouroCorresp = $logradouroCorresp;
        return $this;
    }

    /**
     * Get logradouroCorresp
     *
     * @return string
     */
    public function getLogradouroCorresp()
    {
        return $this->logradouroCorresp;
    }

    /**
     * Set numeroCorresp
     *
     * @param string $numeroCorresp
     * @return SwCgm
     */
    public function setNumeroCorresp($numeroCorresp)
    {
        $this->numeroCorresp = $numeroCorresp;
        return $this;
    }

    /**
     * Get numeroCorresp
     *
     * @return string
     */
    public function getNumeroCorresp()
    {
        return $this->numeroCorresp;
    }

    /**
     * Set complementoCorresp
     *
     * @param string $complementoCorresp
     * @return SwCgm
     */
    public function setComplementoCorresp($complementoCorresp)
    {
        $this->complementoCorresp = $complementoCorresp;
        return $this;
    }

    /**
     * Get complementoCorresp
     *
     * @return string
     */
    public function getComplementoCorresp()
    {
        return $this->complementoCorresp;
    }

    /**
     * Set bairroCorresp
     *
     * @param string $bairroCorresp
     * @return SwCgm
     */
    public function setBairroCorresp($bairroCorresp)
    {
        $this->bairroCorresp = $bairroCorresp;
        return $this;
    }

    /**
     * Get bairroCorresp
     *
     * @return string
     */
    public function getBairroCorresp()
    {
        return $this->bairroCorresp;
    }

    /**
     * Set cepCorresp
     *
     * @param string $cepCorresp
     * @return SwCgm
     */
    public function setCepCorresp($cepCorresp)
    {
        $this->cepCorresp = $cepCorresp;
        return $this;
    }

    /**
     * Get cepCorresp
     *
     * @return string
     */
    public function getCepCorresp()
    {
        return $this->cepCorresp;
    }

    /**
     * Set foneResidencial
     *
     * @param string $foneResidencial
     * @return SwCgm
     */
    public function setFoneResidencial($foneResidencial)
    {
        $this->foneResidencial = $foneResidencial;
        return $this;
    }

    /**
     * Get foneResidencial
     *
     * @return string
     */
    public function getFoneResidencial()
    {
        return $this->foneResidencial;
    }

    /**
     * Set ramalResidencial
     *
     * @param string $ramalResidencial
     * @return SwCgm
     */
    public function setRamalResidencial($ramalResidencial)
    {
        $this->ramalResidencial = $ramalResidencial;
        return $this;
    }

    /**
     * Get ramalResidencial
     *
     * @return string
     */
    public function getRamalResidencial()
    {
        return $this->ramalResidencial;
    }

    /**
     * Set foneComercial
     *
     * @param string $foneComercial
     * @return SwCgm
     */
    public function setFoneComercial($foneComercial)
    {
        $this->foneComercial = $foneComercial;
        return $this;
    }

    /**
     * Get foneComercial
     *
     * @return string
     */
    public function getFoneComercial()
    {
        return $this->foneComercial;
    }

    /**
     * Set ramalComercial
     *
     * @param string $ramalComercial
     * @return SwCgm
     */
    public function setRamalComercial($ramalComercial)
    {
        $this->ramalComercial = $ramalComercial;
        return $this;
    }

    /**
     * Get ramalComercial
     *
     * @return string
     */
    public function getRamalComercial()
    {
        return $this->ramalComercial;
    }

    /**
     * Set foneCelular
     *
     * @param string $foneCelular
     * @return SwCgm
     */
    public function setFoneCelular($foneCelular)
    {
        $this->foneCelular = $foneCelular;
        return $this;
    }

    /**
     * Get foneCelular
     *
     * @return string
     */
    public function getFoneCelular()
    {
        return $this->foneCelular;
    }

    /**
     * Set eMail
     *
     * @param string $eMail
     * @return SwCgm
     */
    public function setEMail($eMail)
    {
        $this->eMail = $eMail;
        return $this;
    }

    /**
     * Get eMail
     *
     * @return string
     */
    public function getEMail()
    {
        return $this->eMail;
    }

    /**
     * Set eMailAdcional
     *
     * @param string $eMailAdcional
     * @return SwCgm
     */
    public function setEMailAdcional($eMailAdcional)
    {
        $this->eMailAdcional = $eMailAdcional;
        return $this;
    }

    /**
     * Get eMailAdcional
     *
     * @return string
     */
    public function getEMailAdcional()
    {
        return $this->eMailAdcional;
    }

    /**
     * Set dtCadastro
     *
     * @param \DateTime $dtCadastro
     * @return SwCgm
     */
    public function setDtCadastro(\DateTime $dtCadastro)
    {
        $this->dtCadastro = $dtCadastro;
        return $this;
    }

    /**
     * Get dtCadastro
     *
     * @return \DateTime
     */
    public function getDtCadastro()
    {
        return $this->dtCadastro;
    }

    /**
     * Set codPais
     *
     * @param integer $codPais
     * @return SwCgm
     */
    public function setCodPais($codPais)
    {
        $this->codPais = $codPais;
        return $this;
    }

    /**
     * Get codPais
     *
     * @return integer
     */
    public function getCodPais()
    {
        return $this->codPais;
    }

    /**
     * Set codPaisCorresp
     *
     * @param integer $codPaisCorresp
     * @return SwCgm
     */
    public function setCodPaisCorresp($codPaisCorresp)
    {
        $this->codPaisCorresp = $codPaisCorresp;
        return $this;
    }

    /**
     * Get codPaisCorresp
     *
     * @return integer
     */
    public function getCodPaisCorresp()
    {
        return $this->codPaisCorresp;
    }

    /**
     * Set tipoLogradouroCorresp
     *
     * @param string $tipoLogradouroCorresp
     * @return SwCgm
     */
    public function setTipoLogradouroCorresp($tipoLogradouroCorresp = null)
    {
        $this->tipoLogradouroCorresp = $tipoLogradouroCorresp;
        return $this;
    }

    /**
     * Get tipoLogradouroCorresp
     *
     * @return string
     */
    public function getTipoLogradouroCorresp()
    {
        return $this->tipoLogradouroCorresp;
    }

    /**
     * Set tipoLogradouro
     *
     * @param string $tipoLogradouro
     * @return SwCgm
     */
    public function setTipoLogradouro($tipoLogradouro = null)
    {
        $this->tipoLogradouro = $tipoLogradouro;
        return $this;
    }

    /**
     * Get tipoLogradouro
     *
     * @return string
     */
    public function getTipoLogradouro()
    {
        return $this->tipoLogradouro;
    }

    /**
     * Set timestampInclusao
     *
     * @param \DateTime $timestampInclusao
     * @return SwCgm
     */
    public function setTimestampInclusao(\DateTime $timestampInclusao = null)
    {
        $this->timestampInclusao = $timestampInclusao;
        return $this;
    }

    /**
     * Get timestampInclusao
     *
     * @return \DateTime
     */
    public function getTimestampInclusao()
    {
        return $this->timestampInclusao;
    }

    /**
     * Set timestampAlteracao
     *
     * @param \DateTime $timestampAlteracao
     * @return SwCgm
     */
    public function setTimestampAlteracao(\DateTime $timestampAlteracao = null)
    {
        $this->timestampAlteracao = $timestampAlteracao;
        return $this;
    }

    /**
     * Get timestampAlteracao
     *
     * @return \DateTime
     */
    public function getTimestampAlteracao()
    {
        return $this->timestampAlteracao;
    }

    /**
     * Set site
     *
     * @param string $site
     * @return SwCgm
     */
    public function setSite($site)
    {
        $this->site = $site;
        return $this;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Orgao $fkAdministracaoOrgao
     * @return SwCgm
     */
    public function addFkAdministracaoOrgoes(\Urbem\CoreBundle\Entity\Administracao\Orgao $fkAdministracaoOrgao)
    {
        if (false === $this->fkAdministracaoOrgoes->contains($fkAdministracaoOrgao)) {
            $fkAdministracaoOrgao->setFkSwCgm($this);
            $this->fkAdministracaoOrgoes->add($fkAdministracaoOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Orgao $fkAdministracaoOrgao
     */
    public function removeFkAdministracaoOrgoes(\Urbem\CoreBundle\Entity\Administracao\Orgao $fkAdministracaoOrgao)
    {
        $this->fkAdministracaoOrgoes->removeElement($fkAdministracaoOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Orgao
     */
    public function getFkAdministracaoOrgoes()
    {
        return $this->fkAdministracaoOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoCentroCustoPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoPermissao $fkAlmoxarifadoCentroCustoPermissao
     * @return SwCgm
     */
    public function addFkAlmoxarifadoCentroCustoPermissoes(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoPermissao $fkAlmoxarifadoCentroCustoPermissao)
    {
        if (false === $this->fkAlmoxarifadoCentroCustoPermissoes->contains($fkAlmoxarifadoCentroCustoPermissao)) {
            $fkAlmoxarifadoCentroCustoPermissao->setFkSwCgm($this);
            $this->fkAlmoxarifadoCentroCustoPermissoes->add($fkAlmoxarifadoCentroCustoPermissao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoCentroCustoPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoPermissao $fkAlmoxarifadoCentroCustoPermissao
     */
    public function removeFkAlmoxarifadoCentroCustoPermissoes(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoPermissao $fkAlmoxarifadoCentroCustoPermissao)
    {
        $this->fkAlmoxarifadoCentroCustoPermissoes->removeElement($fkAlmoxarifadoCentroCustoPermissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoCentroCustoPermissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoPermissao
     */
    public function getFkAlmoxarifadoCentroCustoPermissoes()
    {
        return $this->fkAlmoxarifadoCentroCustoPermissoes;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoSaidaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\SaidaDiversa $fkAlmoxarifadoSaidaDiversa
     * @return SwCgm
     */
    public function addFkAlmoxarifadoSaidaDiversas(\Urbem\CoreBundle\Entity\Almoxarifado\SaidaDiversa $fkAlmoxarifadoSaidaDiversa)
    {
        if (false === $this->fkAlmoxarifadoSaidaDiversas->contains($fkAlmoxarifadoSaidaDiversa)) {
            $fkAlmoxarifadoSaidaDiversa->setFkSwCgm($this);
            $this->fkAlmoxarifadoSaidaDiversas->add($fkAlmoxarifadoSaidaDiversa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoSaidaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\SaidaDiversa $fkAlmoxarifadoSaidaDiversa
     */
    public function removeFkAlmoxarifadoSaidaDiversas(\Urbem\CoreBundle\Entity\Almoxarifado\SaidaDiversa $fkAlmoxarifadoSaidaDiversa)
    {
        $this->fkAlmoxarifadoSaidaDiversas->removeElement($fkAlmoxarifadoSaidaDiversa);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoSaidaDiversas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\SaidaDiversa
     */
    public function getFkAlmoxarifadoSaidaDiversas()
    {
        return $this->fkAlmoxarifadoSaidaDiversas;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoDocumentoCgm
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoCgm $fkArrecadacaoDocumentoCgm
     * @return SwCgm
     */
    public function addFkArrecadacaoDocumentoCgns(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoCgm $fkArrecadacaoDocumentoCgm)
    {
        if (false === $this->fkArrecadacaoDocumentoCgns->contains($fkArrecadacaoDocumentoCgm)) {
            $fkArrecadacaoDocumentoCgm->setFkSwCgm($this);
            $this->fkArrecadacaoDocumentoCgns->add($fkArrecadacaoDocumentoCgm);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDocumentoCgm
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoCgm $fkArrecadacaoDocumentoCgm
     */
    public function removeFkArrecadacaoDocumentoCgns(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoCgm $fkArrecadacaoDocumentoCgm)
    {
        $this->fkArrecadacaoDocumentoCgns->removeElement($fkArrecadacaoDocumentoCgm);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDocumentoCgns
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoCgm
     */
    public function getFkArrecadacaoDocumentoCgns()
    {
        return $this->fkArrecadacaoDocumentoCgns;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoDesonerado
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desonerado $fkArrecadacaoDesonerado
     * @return SwCgm
     */
    public function addFkArrecadacaoDesonerados(\Urbem\CoreBundle\Entity\Arrecadacao\Desonerado $fkArrecadacaoDesonerado)
    {
        if (false === $this->fkArrecadacaoDesonerados->contains($fkArrecadacaoDesonerado)) {
            $fkArrecadacaoDesonerado->setFkSwCgm($this);
            $this->fkArrecadacaoDesonerados->add($fkArrecadacaoDesonerado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDesonerado
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desonerado $fkArrecadacaoDesonerado
     */
    public function removeFkArrecadacaoDesonerados(\Urbem\CoreBundle\Entity\Arrecadacao\Desonerado $fkArrecadacaoDesonerado)
    {
        $this->fkArrecadacaoDesonerados->removeElement($fkArrecadacaoDesonerado);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDesonerados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Desonerado
     */
    public function getFkArrecadacaoDesonerados()
    {
        return $this->fkArrecadacaoDesonerados;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoNotaAvulsa
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa $fkArrecadacaoNotaAvulsa
     * @return SwCgm
     */
    public function addFkArrecadacaoNotaAvulsas(\Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa $fkArrecadacaoNotaAvulsa)
    {
        if (false === $this->fkArrecadacaoNotaAvulsas->contains($fkArrecadacaoNotaAvulsa)) {
            $fkArrecadacaoNotaAvulsa->setFkSwCgm($this);
            $this->fkArrecadacaoNotaAvulsas->add($fkArrecadacaoNotaAvulsa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoNotaAvulsa
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa $fkArrecadacaoNotaAvulsa
     */
    public function removeFkArrecadacaoNotaAvulsas(\Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa $fkArrecadacaoNotaAvulsa)
    {
        $this->fkArrecadacaoNotaAvulsas->removeElement($fkArrecadacaoNotaAvulsa);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoNotaAvulsas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa
     */
    public function getFkArrecadacaoNotaAvulsas()
    {
        return $this->fkArrecadacaoNotaAvulsas;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPermissaoCancelamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PermissaoCancelamento $fkArrecadacaoPermissaoCancelamento
     * @return SwCgm
     */
    public function addFkArrecadacaoPermissaoCancelamentos(\Urbem\CoreBundle\Entity\Arrecadacao\PermissaoCancelamento $fkArrecadacaoPermissaoCancelamento)
    {
        if (false === $this->fkArrecadacaoPermissaoCancelamentos->contains($fkArrecadacaoPermissaoCancelamento)) {
            $fkArrecadacaoPermissaoCancelamento->setFkSwCgm($this);
            $this->fkArrecadacaoPermissaoCancelamentos->add($fkArrecadacaoPermissaoCancelamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPermissaoCancelamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PermissaoCancelamento $fkArrecadacaoPermissaoCancelamento
     */
    public function removeFkArrecadacaoPermissaoCancelamentos(\Urbem\CoreBundle\Entity\Arrecadacao\PermissaoCancelamento $fkArrecadacaoPermissaoCancelamento)
    {
        $this->fkArrecadacaoPermissaoCancelamentos->removeElement($fkArrecadacaoPermissaoCancelamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPermissaoCancelamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PermissaoCancelamento
     */
    public function getFkArrecadacaoPermissaoCancelamentos()
    {
        return $this->fkArrecadacaoPermissaoCancelamentos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoServicoComRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao $fkArrecadacaoServicoComRetencao
     * @return SwCgm
     */
    public function addFkArrecadacaoServicoComRetencoes(\Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao $fkArrecadacaoServicoComRetencao)
    {
        if (false === $this->fkArrecadacaoServicoComRetencoes->contains($fkArrecadacaoServicoComRetencao)) {
            $fkArrecadacaoServicoComRetencao->setFkSwCgm($this);
            $this->fkArrecadacaoServicoComRetencoes->add($fkArrecadacaoServicoComRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoServicoComRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao $fkArrecadacaoServicoComRetencao
     */
    public function removeFkArrecadacaoServicoComRetencoes(\Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao $fkArrecadacaoServicoComRetencao)
    {
        $this->fkArrecadacaoServicoComRetencoes->removeElement($fkArrecadacaoServicoComRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoServicoComRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao
     */
    public function getFkArrecadacaoServicoComRetencoes()
    {
        return $this->fkArrecadacaoServicoComRetencoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoRetencaoNota
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota $fkArrecadacaoRetencaoNota
     * @return SwCgm
     */
    public function addFkArrecadacaoRetencaoNotas(\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota $fkArrecadacaoRetencaoNota)
    {
        if (false === $this->fkArrecadacaoRetencaoNotas->contains($fkArrecadacaoRetencaoNota)) {
            $fkArrecadacaoRetencaoNota->setFkSwCgm($this);
            $this->fkArrecadacaoRetencaoNotas->add($fkArrecadacaoRetencaoNota);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoRetencaoNota
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota $fkArrecadacaoRetencaoNota
     */
    public function removeFkArrecadacaoRetencaoNotas(\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota $fkArrecadacaoRetencaoNota)
    {
        $this->fkArrecadacaoRetencaoNotas->removeElement($fkArrecadacaoRetencaoNota);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoRetencaoNotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota
     */
    public function getFkArrecadacaoRetencaoNotas()
    {
        return $this->fkArrecadacaoRetencaoNotas;
    }

    /**
     * OneToMany (owning side)
     * Add CgmContaCgm
     *
     * @param \Urbem\CoreBundle\Entity\Cgm\ContaCgm $fkCgmContaCgm
     * @return SwCgm
     */
    public function addFkCgmContaCgns(\Urbem\CoreBundle\Entity\Cgm\ContaCgm $fkCgmContaCgm)
    {
        if (false === $this->fkCgmContaCgns->contains($fkCgmContaCgm)) {
            $fkCgmContaCgm->setFkSwCgm($this);
            $this->fkCgmContaCgns->add($fkCgmContaCgm);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CgmContaCgm
     *
     * @param \Urbem\CoreBundle\Entity\Cgm\ContaCgm $fkCgmContaCgm
     */
    public function removeFkCgmContaCgns(\Urbem\CoreBundle\Entity\Cgm\ContaCgm $fkCgmContaCgm)
    {
        $this->fkCgmContaCgns->removeElement($fkCgmContaCgm);
    }

    /**
     * OneToMany (owning side)
     * Get fkCgmContaCgns
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cgm\ContaCgm
     */
    public function getFkCgmContaCgns()
    {
        return $this->fkCgmContaCgns;
    }

    /**
     * OneToMany (owning side)
     * Add CgmCgmAlteracaoHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Cgm\CgmAlteracaoHistorico $fkCgmCgmAlteracaoHistorico
     * @return SwCgm
     */
    public function addFkCgmCgmAlteracaoHistoricos(\Urbem\CoreBundle\Entity\Cgm\CgmAlteracaoHistorico $fkCgmCgmAlteracaoHistorico)
    {
        if (false === $this->fkCgmCgmAlteracaoHistoricos->contains($fkCgmCgmAlteracaoHistorico)) {
            $fkCgmCgmAlteracaoHistorico->setFkSwCgm($this);
            $this->fkCgmCgmAlteracaoHistoricos->add($fkCgmCgmAlteracaoHistorico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CgmCgmAlteracaoHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Cgm\CgmAlteracaoHistorico $fkCgmCgmAlteracaoHistorico
     */
    public function removeFkCgmCgmAlteracaoHistoricos(\Urbem\CoreBundle\Entity\Cgm\CgmAlteracaoHistorico $fkCgmCgmAlteracaoHistorico)
    {
        $this->fkCgmCgmAlteracaoHistoricos->removeElement($fkCgmCgmAlteracaoHistorico);
    }

    /**
     * OneToMany (owning side)
     * Get fkCgmCgmAlteracaoHistoricos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cgm\CgmAlteracaoHistorico
     */
    public function getFkCgmCgmAlteracaoHistoricos()
    {
        return $this->fkCgmCgmAlteracaoHistoricos;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasOrdem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Ordem $fkComprasOrdem
     * @return SwCgm
     */
    public function addFkComprasOrdens(\Urbem\CoreBundle\Entity\Compras\Ordem $fkComprasOrdem)
    {
        if (false === $this->fkComprasOrdens->contains($fkComprasOrdem)) {
            $fkComprasOrdem->setFkSwCgm($this);
            $this->fkComprasOrdens->add($fkComprasOrdem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasOrdem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Ordem $fkComprasOrdem
     */
    public function removeFkComprasOrdens(\Urbem\CoreBundle\Entity\Compras\Ordem $fkComprasOrdem)
    {
        $this->fkComprasOrdens->removeElement($fkComprasOrdem);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasOrdens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Ordem
     */
    public function getFkComprasOrdens()
    {
        return $this->fkComprasOrdens;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoEntrega
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoEntrega $fkComprasSolicitacaoEntrega
     * @return SwCgm
     */
    public function addFkComprasSolicitacaoEntregas(\Urbem\CoreBundle\Entity\Compras\SolicitacaoEntrega $fkComprasSolicitacaoEntrega)
    {
        if (false === $this->fkComprasSolicitacaoEntregas->contains($fkComprasSolicitacaoEntrega)) {
            $fkComprasSolicitacaoEntrega->setFkSwCgm($this);
            $this->fkComprasSolicitacaoEntregas->add($fkComprasSolicitacaoEntrega);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacaoEntrega
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoEntrega $fkComprasSolicitacaoEntrega
     */
    public function removeFkComprasSolicitacaoEntregas(\Urbem\CoreBundle\Entity\Compras\SolicitacaoEntrega $fkComprasSolicitacaoEntrega)
    {
        $this->fkComprasSolicitacaoEntregas->removeElement($fkComprasSolicitacaoEntrega);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacaoEntregas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoEntrega
     */
    public function getFkComprasSolicitacaoEntregas()
    {
        return $this->fkComprasSolicitacaoEntregas;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao
     * @return SwCgm
     */
    public function addFkComprasSolicitacoes(\Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao)
    {
        if (false === $this->fkComprasSolicitacoes->contains($fkComprasSolicitacao)) {
            $fkComprasSolicitacao->setFkSwCgm($this);
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
     * Add CseResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Responsavel $fkCseResponsavel
     * @return SwCgm
     */
    public function addFkCseResponsaveis(\Urbem\CoreBundle\Entity\Cse\Responsavel $fkCseResponsavel)
    {
        if (false === $this->fkCseResponsaveis->contains($fkCseResponsavel)) {
            $fkCseResponsavel->setFkSwCgm($this);
            $this->fkCseResponsaveis->add($fkCseResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Responsavel $fkCseResponsavel
     */
    public function removeFkCseResponsaveis(\Urbem\CoreBundle\Entity\Cse\Responsavel $fkCseResponsavel)
    {
        $this->fkCseResponsaveis->removeElement($fkCseResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseResponsaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Responsavel
     */
    public function getFkCseResponsaveis()
    {
        return $this->fkCseResponsaveis;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaCgm
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaCgm $fkDividaDividaCgm
     * @return SwCgm
     */
    public function addFkDividaDividaCgns(\Urbem\CoreBundle\Entity\Divida\DividaCgm $fkDividaDividaCgm)
    {
        if (false === $this->fkDividaDividaCgns->contains($fkDividaDividaCgm)) {
            $fkDividaDividaCgm->setFkSwCgm($this);
            $this->fkDividaDividaCgns->add($fkDividaDividaCgm);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaCgm
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaCgm $fkDividaDividaCgm
     */
    public function removeFkDividaDividaCgns(\Urbem\CoreBundle\Entity\Divida\DividaCgm $fkDividaDividaCgm)
    {
        $this->fkDividaDividaCgns->removeElement($fkDividaDividaCgm);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaCgns
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaCgm
     */
    public function getFkDividaDividaCgns()
    {
        return $this->fkDividaDividaCgns;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoSociedade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Sociedade $fkEconomicoSociedade
     * @return SwCgm
     */
    public function addFkEconomicoSociedades(\Urbem\CoreBundle\Entity\Economico\Sociedade $fkEconomicoSociedade)
    {
        if (false === $this->fkEconomicoSociedades->contains($fkEconomicoSociedade)) {
            $fkEconomicoSociedade->setFkSwCgm($this);
            $this->fkEconomicoSociedades->add($fkEconomicoSociedade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoSociedade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Sociedade $fkEconomicoSociedade
     */
    public function removeFkEconomicoSociedades(\Urbem\CoreBundle\Entity\Economico\Sociedade $fkEconomicoSociedade)
    {
        $this->fkEconomicoSociedades->removeElement($fkEconomicoSociedade);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoSociedades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\Sociedade
     */
    public function getFkEconomicoSociedades()
    {
        return $this->fkEconomicoSociedades;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Responsavel $fkEconomicoResponsavel
     * @return SwCgm
     */
    public function addFkEconomicoResponsaveis(\Urbem\CoreBundle\Entity\Economico\Responsavel $fkEconomicoResponsavel)
    {
        if (false === $this->fkEconomicoResponsaveis->contains($fkEconomicoResponsavel)) {
            $fkEconomicoResponsavel->setFkSwCgm($this);
            $this->fkEconomicoResponsaveis->add($fkEconomicoResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Responsavel $fkEconomicoResponsavel
     */
    public function removeFkEconomicoResponsaveis(\Urbem\CoreBundle\Entity\Economico\Responsavel $fkEconomicoResponsavel)
    {
        $this->fkEconomicoResponsaveis->removeElement($fkEconomicoResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoResponsaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\Responsavel
     */
    public function getFkEconomicoResponsaveis()
    {
        return $this->fkEconomicoResponsaveis;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico $fkEconomicoResponsavelTecnico
     * @return SwCgm
     */
    public function addFkEconomicoResponsavelTecnicos(\Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico $fkEconomicoResponsavelTecnico)
    {
        if (false === $this->fkEconomicoResponsavelTecnicos->contains($fkEconomicoResponsavelTecnico)) {
            $fkEconomicoResponsavelTecnico->setFkSwCgm($this);
            $this->fkEconomicoResponsavelTecnicos->add($fkEconomicoResponsavelTecnico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico $fkEconomicoResponsavelTecnico
     */
    public function removeFkEconomicoResponsavelTecnicos(\Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico $fkEconomicoResponsavelTecnico)
    {
        $this->fkEconomicoResponsavelTecnicos->removeElement($fkEconomicoResponsavelTecnico);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoResponsavelTecnicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico
     */
    public function getFkEconomicoResponsavelTecnicos()
    {
        return $this->fkEconomicoResponsavelTecnicos;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoAutorizacaoEmpenhoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenhoAssinatura $fkEmpenhoAutorizacaoEmpenhoAssinatura
     * @return SwCgm
     */
    public function addFkEmpenhoAutorizacaoEmpenhoAssinaturas(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenhoAssinatura $fkEmpenhoAutorizacaoEmpenhoAssinatura)
    {
        if (false === $this->fkEmpenhoAutorizacaoEmpenhoAssinaturas->contains($fkEmpenhoAutorizacaoEmpenhoAssinatura)) {
            $fkEmpenhoAutorizacaoEmpenhoAssinatura->setFkSwCgm($this);
            $this->fkEmpenhoAutorizacaoEmpenhoAssinaturas->add($fkEmpenhoAutorizacaoEmpenhoAssinatura);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoAutorizacaoEmpenhoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenhoAssinatura $fkEmpenhoAutorizacaoEmpenhoAssinatura
     */
    public function removeFkEmpenhoAutorizacaoEmpenhoAssinaturas(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenhoAssinatura $fkEmpenhoAutorizacaoEmpenhoAssinatura)
    {
        $this->fkEmpenhoAutorizacaoEmpenhoAssinaturas->removeElement($fkEmpenhoAutorizacaoEmpenhoAssinatura);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoAutorizacaoEmpenhoAssinaturas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenhoAssinatura
     */
    public function getFkEmpenhoAutorizacaoEmpenhoAssinaturas()
    {
        return $this->fkEmpenhoAutorizacaoEmpenhoAssinaturas;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoDespesasFixas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas
     * @return SwCgm
     */
    public function addFkEmpenhoDespesasFixas(\Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas)
    {
        if (false === $this->fkEmpenhoDespesasFixas->contains($fkEmpenhoDespesasFixas)) {
            $fkEmpenhoDespesasFixas->setFkSwCgm($this);
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
     * Add EmpenhoEmpenhoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoAssinatura $fkEmpenhoEmpenhoAssinatura
     * @return SwCgm
     */
    public function addFkEmpenhoEmpenhoAssinaturas(\Urbem\CoreBundle\Entity\Empenho\EmpenhoAssinatura $fkEmpenhoEmpenhoAssinatura)
    {
        if (false === $this->fkEmpenhoEmpenhoAssinaturas->contains($fkEmpenhoEmpenhoAssinatura)) {
            $fkEmpenhoEmpenhoAssinatura->setFkSwCgm($this);
            $this->fkEmpenhoEmpenhoAssinaturas->add($fkEmpenhoEmpenhoAssinatura);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoEmpenhoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoAssinatura $fkEmpenhoEmpenhoAssinatura
     */
    public function removeFkEmpenhoEmpenhoAssinaturas(\Urbem\CoreBundle\Entity\Empenho\EmpenhoAssinatura $fkEmpenhoEmpenhoAssinatura)
    {
        $this->fkEmpenhoEmpenhoAssinaturas->removeElement($fkEmpenhoEmpenhoAssinatura);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoEmpenhoAssinaturas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoAssinatura
     */
    public function getFkEmpenhoEmpenhoAssinaturas()
    {
        return $this->fkEmpenhoEmpenhoAssinaturas;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoNotaLiquidacaoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoAssinatura $fkEmpenhoNotaLiquidacaoAssinatura
     * @return SwCgm
     */
    public function addFkEmpenhoNotaLiquidacaoAssinaturas(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoAssinatura $fkEmpenhoNotaLiquidacaoAssinatura)
    {
        if (false === $this->fkEmpenhoNotaLiquidacaoAssinaturas->contains($fkEmpenhoNotaLiquidacaoAssinatura)) {
            $fkEmpenhoNotaLiquidacaoAssinatura->setFkSwCgm($this);
            $this->fkEmpenhoNotaLiquidacaoAssinaturas->add($fkEmpenhoNotaLiquidacaoAssinatura);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoNotaLiquidacaoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoAssinatura $fkEmpenhoNotaLiquidacaoAssinatura
     */
    public function removeFkEmpenhoNotaLiquidacaoAssinaturas(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoAssinatura $fkEmpenhoNotaLiquidacaoAssinatura)
    {
        $this->fkEmpenhoNotaLiquidacaoAssinaturas->removeElement($fkEmpenhoNotaLiquidacaoAssinatura);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoNotaLiquidacaoAssinaturas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoAssinatura
     */
    public function getFkEmpenhoNotaLiquidacaoAssinaturas()
    {
        return $this->fkEmpenhoNotaLiquidacaoAssinaturas;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoOrdemPagamentoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAssinatura $fkEmpenhoOrdemPagamentoAssinatura
     * @return SwCgm
     */
    public function addFkEmpenhoOrdemPagamentoAssinaturas(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAssinatura $fkEmpenhoOrdemPagamentoAssinatura)
    {
        if (false === $this->fkEmpenhoOrdemPagamentoAssinaturas->contains($fkEmpenhoOrdemPagamentoAssinatura)) {
            $fkEmpenhoOrdemPagamentoAssinatura->setFkSwCgm($this);
            $this->fkEmpenhoOrdemPagamentoAssinaturas->add($fkEmpenhoOrdemPagamentoAssinatura);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoOrdemPagamentoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAssinatura $fkEmpenhoOrdemPagamentoAssinatura
     */
    public function removeFkEmpenhoOrdemPagamentoAssinaturas(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAssinatura $fkEmpenhoOrdemPagamentoAssinatura)
    {
        $this->fkEmpenhoOrdemPagamentoAssinaturas->removeElement($fkEmpenhoOrdemPagamentoAssinatura);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoOrdemPagamentoAssinaturas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAssinatura
     */
    public function getFkEmpenhoOrdemPagamentoAssinaturas()
    {
        return $this->fkEmpenhoOrdemPagamentoAssinaturas;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoNotaLiquidacaoPagaAnuladaAuditoria
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnuladaAuditoria $fkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria
     * @return SwCgm
     */
    public function addFkEmpenhoNotaLiquidacaoPagaAnuladaAuditorias(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnuladaAuditoria $fkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria)
    {
        if (false === $this->fkEmpenhoNotaLiquidacaoPagaAnuladaAuditorias->contains($fkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria)) {
            $fkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria->setFkSwCgm($this);
            $this->fkEmpenhoNotaLiquidacaoPagaAnuladaAuditorias->add($fkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoNotaLiquidacaoPagaAnuladaAuditoria
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnuladaAuditoria $fkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria
     */
    public function removeFkEmpenhoNotaLiquidacaoPagaAnuladaAuditorias(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnuladaAuditoria $fkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria)
    {
        $this->fkEmpenhoNotaLiquidacaoPagaAnuladaAuditorias->removeElement($fkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoNotaLiquidacaoPagaAnuladaAuditorias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnuladaAuditoria
     */
    public function getFkEmpenhoNotaLiquidacaoPagaAnuladaAuditorias()
    {
        return $this->fkEmpenhoNotaLiquidacaoPagaAnuladaAuditorias;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho
     * @return SwCgm
     */
    public function addFkEmpenhoPreEmpenhos(\Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho)
    {
        if (false === $this->fkEmpenhoPreEmpenhos->contains($fkEmpenhoPreEmpenho)) {
            $fkEmpenhoPreEmpenho->setFkSwCgm($this);
            $this->fkEmpenhoPreEmpenhos->add($fkEmpenhoPreEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho
     */
    public function removeFkEmpenhoPreEmpenhos(\Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho)
    {
        $this->fkEmpenhoPreEmpenhos->removeElement($fkEmpenhoPreEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoPreEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    public function getFkEmpenhoPreEmpenhos()
    {
        return $this->fkEmpenhoPreEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoResponsavelAdiantamento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento $fkEmpenhoResponsavelAdiantamento
     * @return SwCgm
     */
    public function addFkEmpenhoResponsavelAdiantamentos(\Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento $fkEmpenhoResponsavelAdiantamento)
    {
        if (false === $this->fkEmpenhoResponsavelAdiantamentos->contains($fkEmpenhoResponsavelAdiantamento)) {
            $fkEmpenhoResponsavelAdiantamento->setFkSwCgm($this);
            $this->fkEmpenhoResponsavelAdiantamentos->add($fkEmpenhoResponsavelAdiantamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoResponsavelAdiantamento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento $fkEmpenhoResponsavelAdiantamento
     */
    public function removeFkEmpenhoResponsavelAdiantamentos(\Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento $fkEmpenhoResponsavelAdiantamento)
    {
        $this->fkEmpenhoResponsavelAdiantamentos->removeElement($fkEmpenhoResponsavelAdiantamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoResponsavelAdiantamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento
     */
    public function getFkEmpenhoResponsavelAdiantamentos()
    {
        return $this->fkEmpenhoResponsavelAdiantamentos;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoNotaLiquidacaoPagaAuditoria
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAuditoria $fkEmpenhoNotaLiquidacaoPagaAuditoria
     * @return SwCgm
     */
    public function addFkEmpenhoNotaLiquidacaoPagaAuditorias(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAuditoria $fkEmpenhoNotaLiquidacaoPagaAuditoria)
    {
        if (false === $this->fkEmpenhoNotaLiquidacaoPagaAuditorias->contains($fkEmpenhoNotaLiquidacaoPagaAuditoria)) {
            $fkEmpenhoNotaLiquidacaoPagaAuditoria->setFkSwCgm($this);
            $this->fkEmpenhoNotaLiquidacaoPagaAuditorias->add($fkEmpenhoNotaLiquidacaoPagaAuditoria);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoNotaLiquidacaoPagaAuditoria
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAuditoria $fkEmpenhoNotaLiquidacaoPagaAuditoria
     */
    public function removeFkEmpenhoNotaLiquidacaoPagaAuditorias(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAuditoria $fkEmpenhoNotaLiquidacaoPagaAuditoria)
    {
        $this->fkEmpenhoNotaLiquidacaoPagaAuditorias->removeElement($fkEmpenhoNotaLiquidacaoPagaAuditoria);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoNotaLiquidacaoPagaAuditorias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAuditoria
     */
    public function getFkEmpenhoNotaLiquidacaoPagaAuditorias()
    {
        return $this->fkEmpenhoNotaLiquidacaoPagaAuditorias;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoAutorizacaoNotas
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas $fkFiscalizacaoAutorizacaoNotas
     * @return SwCgm
     */
    public function addFkFiscalizacaoAutorizacaoNotas(\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas $fkFiscalizacaoAutorizacaoNotas)
    {
        if (false === $this->fkFiscalizacaoAutorizacaoNotas->contains($fkFiscalizacaoAutorizacaoNotas)) {
            $fkFiscalizacaoAutorizacaoNotas->setFkSwCgm($this);
            $this->fkFiscalizacaoAutorizacaoNotas->add($fkFiscalizacaoAutorizacaoNotas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoAutorizacaoNotas
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas $fkFiscalizacaoAutorizacaoNotas
     */
    public function removeFkFiscalizacaoAutorizacaoNotas(\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas $fkFiscalizacaoAutorizacaoNotas)
    {
        $this->fkFiscalizacaoAutorizacaoNotas->removeElement($fkFiscalizacaoAutorizacaoNotas);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoAutorizacaoNotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas
     */
    public function getFkFiscalizacaoAutorizacaoNotas()
    {
        return $this->fkFiscalizacaoAutorizacaoNotas;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoBaixaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao $fkFiscalizacaoBaixaAutorizacao
     * @return SwCgm
     */
    public function addFkFiscalizacaoBaixaAutorizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao $fkFiscalizacaoBaixaAutorizacao)
    {
        if (false === $this->fkFiscalizacaoBaixaAutorizacoes->contains($fkFiscalizacaoBaixaAutorizacao)) {
            $fkFiscalizacaoBaixaAutorizacao->setFkSwCgm($this);
            $this->fkFiscalizacaoBaixaAutorizacoes->add($fkFiscalizacaoBaixaAutorizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoBaixaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao $fkFiscalizacaoBaixaAutorizacao
     */
    public function removeFkFiscalizacaoBaixaAutorizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao $fkFiscalizacaoBaixaAutorizacao)
    {
        $this->fkFiscalizacaoBaixaAutorizacoes->removeElement($fkFiscalizacaoBaixaAutorizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoBaixaAutorizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao
     */
    public function getFkFiscalizacaoBaixaAutorizacoes()
    {
        return $this->fkFiscalizacaoBaixaAutorizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoRetencaoNota
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota $fkFiscalizacaoRetencaoNota
     * @return SwCgm
     */
    public function addFkFiscalizacaoRetencaoNotas(\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota $fkFiscalizacaoRetencaoNota)
    {
        if (false === $this->fkFiscalizacaoRetencaoNotas->contains($fkFiscalizacaoRetencaoNota)) {
            $fkFiscalizacaoRetencaoNota->setFkSwCgm($this);
            $this->fkFiscalizacaoRetencaoNotas->add($fkFiscalizacaoRetencaoNota);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoRetencaoNota
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota $fkFiscalizacaoRetencaoNota
     */
    public function removeFkFiscalizacaoRetencaoNotas(\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota $fkFiscalizacaoRetencaoNota)
    {
        $this->fkFiscalizacaoRetencaoNotas->removeElement($fkFiscalizacaoRetencaoNota);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoRetencaoNotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota
     */
    public function getFkFiscalizacaoRetencaoNotas()
    {
        return $this->fkFiscalizacaoRetencaoNotas;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoServicoComRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao $fkFiscalizacaoServicoComRetencao
     * @return SwCgm
     */
    public function addFkFiscalizacaoServicoComRetencoes(\Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao $fkFiscalizacaoServicoComRetencao)
    {
        if (false === $this->fkFiscalizacaoServicoComRetencoes->contains($fkFiscalizacaoServicoComRetencao)) {
            $fkFiscalizacaoServicoComRetencao->setFkSwCgm($this);
            $this->fkFiscalizacaoServicoComRetencoes->add($fkFiscalizacaoServicoComRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoServicoComRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao $fkFiscalizacaoServicoComRetencao
     */
    public function removeFkFiscalizacaoServicoComRetencoes(\Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao $fkFiscalizacaoServicoComRetencao)
    {
        $this->fkFiscalizacaoServicoComRetencoes->removeElement($fkFiscalizacaoServicoComRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoServicoComRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao
     */
    public function getFkFiscalizacaoServicoComRetencoes()
    {
        return $this->fkFiscalizacaoServicoComRetencoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho
     * @return SwCgm
     */
    public function addFkFolhapagamentoConfiguracaoAutorizacaoEmpenhos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhos->contains($fkFolhapagamentoConfiguracaoAutorizacaoEmpenho)) {
            $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho->setFkSwCgm($this);
            $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhos->add($fkFolhapagamentoConfiguracaoAutorizacaoEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho
     */
    public function removeFkFolhapagamentoConfiguracaoAutorizacaoEmpenhos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho)
    {
        $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhos->removeElement($fkFolhapagamentoConfiguracaoAutorizacaoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoAutorizacaoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho
     */
    public function getFkFolhapagamentoConfiguracaoAutorizacaoEmpenhos()
    {
        return $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaTerceiros
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Terceiros $fkFrotaTerceiros
     * @return SwCgm
     */
    public function addFkFrotaTerceiros(\Urbem\CoreBundle\Entity\Frota\Terceiros $fkFrotaTerceiros)
    {
        if (false === $this->fkFrotaTerceiros->contains($fkFrotaTerceiros)) {
            $fkFrotaTerceiros->setFkSwCgm($this);
            $this->fkFrotaTerceiros->add($fkFrotaTerceiros);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaTerceiros
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Terceiros $fkFrotaTerceiros
     */
    public function removeFkFrotaTerceiros(\Urbem\CoreBundle\Entity\Frota\Terceiros $fkFrotaTerceiros)
    {
        $this->fkFrotaTerceiros->removeElement($fkFrotaTerceiros);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaTerceiros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Terceiros
     */
    public function getFkFrotaTerceiros()
    {
        return $this->fkFrotaTerceiros;
    }

    /**
     * OneToMany (owning side)
     * Add ImaCagedAutorizadoCgm
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CagedAutorizadoCgm $fkImaCagedAutorizadoCgm
     * @return SwCgm
     */
    public function addFkImaCagedAutorizadoCgns(\Urbem\CoreBundle\Entity\Ima\CagedAutorizadoCgm $fkImaCagedAutorizadoCgm)
    {
        if (false === $this->fkImaCagedAutorizadoCgns->contains($fkImaCagedAutorizadoCgm)) {
            $fkImaCagedAutorizadoCgm->setFkSwCgm($this);
            $this->fkImaCagedAutorizadoCgns->add($fkImaCagedAutorizadoCgm);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaCagedAutorizadoCgm
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CagedAutorizadoCgm $fkImaCagedAutorizadoCgm
     */
    public function removeFkImaCagedAutorizadoCgns(\Urbem\CoreBundle\Entity\Ima\CagedAutorizadoCgm $fkImaCagedAutorizadoCgm)
    {
        $this->fkImaCagedAutorizadoCgns->removeElement($fkImaCagedAutorizadoCgm);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaCagedAutorizadoCgns
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\CagedAutorizadoCgm
     */
    public function getFkImaCagedAutorizadoCgns()
    {
        return $this->fkImaCagedAutorizadoCgns;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoRais
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais $fkImaConfiguracaoRais
     * @return SwCgm
     */
    public function addFkImaConfiguracaoRais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais $fkImaConfiguracaoRais)
    {
        if (false === $this->fkImaConfiguracaoRais->contains($fkImaConfiguracaoRais)) {
            $fkImaConfiguracaoRais->setFkSwCgm($this);
            $this->fkImaConfiguracaoRais->add($fkImaConfiguracaoRais);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoRais
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais $fkImaConfiguracaoRais
     */
    public function removeFkImaConfiguracaoRais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais $fkImaConfiguracaoRais)
    {
        $this->fkImaConfiguracaoRais->removeElement($fkImaConfiguracaoRais);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoRais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais
     */
    public function getFkImaConfiguracaoRais()
    {
        return $this->fkImaConfiguracaoRais;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoDirf
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf
     * @return SwCgm
     */
    public function addFkImaConfiguracaoDirfs(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf)
    {
        if (false === $this->fkImaConfiguracaoDirfs->contains($fkImaConfiguracaoDirf)) {
            $fkImaConfiguracaoDirf->setFkSwCgm($this);
            $this->fkImaConfiguracaoDirfs->add($fkImaConfiguracaoDirf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoDirf
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf
     */
    public function removeFkImaConfiguracaoDirfs(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf)
    {
        $this->fkImaConfiguracaoDirfs->removeElement($fkImaConfiguracaoDirf);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoDirfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf
     */
    public function getFkImaConfiguracaoDirfs()
    {
        return $this->fkImaConfiguracaoDirfs;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoDirf
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf
     * @return SwCgm
     */
    public function addFkImaConfiguracaoDirfs1(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf)
    {
        if (false === $this->fkImaConfiguracaoDirfs1->contains($fkImaConfiguracaoDirf)) {
            $fkImaConfiguracaoDirf->setFkSwCgm1($this);
            $this->fkImaConfiguracaoDirfs1->add($fkImaConfiguracaoDirf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoDirf
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf
     */
    public function removeFkImaConfiguracaoDirfs1(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf)
    {
        $this->fkImaConfiguracaoDirfs1->removeElement($fkImaConfiguracaoDirf);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoDirfs1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf
     */
    public function getFkImaConfiguracaoDirfs1()
    {
        return $this->fkImaConfiguracaoDirfs1;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioExProprietario
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ExProprietario $fkImobiliarioExProprietario
     * @return SwCgm
     */
    public function addFkImobiliarioExProprietarios(\Urbem\CoreBundle\Entity\Imobiliario\ExProprietario $fkImobiliarioExProprietario)
    {
        if (false === $this->fkImobiliarioExProprietarios->contains($fkImobiliarioExProprietario)) {
            $fkImobiliarioExProprietario->setFkSwCgm($this);
            $this->fkImobiliarioExProprietarios->add($fkImobiliarioExProprietario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioExProprietario
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ExProprietario $fkImobiliarioExProprietario
     */
    public function removeFkImobiliarioExProprietarios(\Urbem\CoreBundle\Entity\Imobiliario\ExProprietario $fkImobiliarioExProprietario)
    {
        $this->fkImobiliarioExProprietarios->removeElement($fkImobiliarioExProprietario);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioExProprietarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ExProprietario
     */
    public function getFkImobiliarioExProprietarios()
    {
        return $this->fkImobiliarioExProprietarios;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTransferenciaAdquirente
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaAdquirente $fkImobiliarioTransferenciaAdquirente
     * @return SwCgm
     */
    public function addFkImobiliarioTransferenciaAdquirentes(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaAdquirente $fkImobiliarioTransferenciaAdquirente)
    {
        if (false === $this->fkImobiliarioTransferenciaAdquirentes->contains($fkImobiliarioTransferenciaAdquirente)) {
            $fkImobiliarioTransferenciaAdquirente->setFkSwCgm($this);
            $this->fkImobiliarioTransferenciaAdquirentes->add($fkImobiliarioTransferenciaAdquirente);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTransferenciaAdquirente
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaAdquirente $fkImobiliarioTransferenciaAdquirente
     */
    public function removeFkImobiliarioTransferenciaAdquirentes(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaAdquirente $fkImobiliarioTransferenciaAdquirente)
    {
        $this->fkImobiliarioTransferenciaAdquirentes->removeElement($fkImobiliarioTransferenciaAdquirente);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTransferenciaAdquirentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaAdquirente
     */
    public function getFkImobiliarioTransferenciaAdquirentes()
    {
        return $this->fkImobiliarioTransferenciaAdquirentes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioProprietario
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Proprietario $fkImobiliarioProprietario
     * @return SwCgm
     */
    public function addFkImobiliarioProprietarios(\Urbem\CoreBundle\Entity\Imobiliario\Proprietario $fkImobiliarioProprietario)
    {
        if (false === $this->fkImobiliarioProprietarios->contains($fkImobiliarioProprietario)) {
            $fkImobiliarioProprietario->setFkSwCgm($this);
            $this->fkImobiliarioProprietarios->add($fkImobiliarioProprietario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioProprietario
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Proprietario $fkImobiliarioProprietario
     */
    public function removeFkImobiliarioProprietarios(\Urbem\CoreBundle\Entity\Imobiliario\Proprietario $fkImobiliarioProprietario)
    {
        $this->fkImobiliarioProprietarios->removeElement($fkImobiliarioProprietario);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioProprietarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Proprietario
     */
    public function getFkImobiliarioProprietarios()
    {
        return $this->fkImobiliarioProprietarios;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoContratoAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos $fkLicitacaoContratoAditivos
     * @return SwCgm
     */
    public function addFkLicitacaoContratoAditivos(\Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos $fkLicitacaoContratoAditivos)
    {
        if (false === $this->fkLicitacaoContratoAditivos->contains($fkLicitacaoContratoAditivos)) {
            $fkLicitacaoContratoAditivos->setFkSwCgm($this);
            $this->fkLicitacaoContratoAditivos->add($fkLicitacaoContratoAditivos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoContratoAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos $fkLicitacaoContratoAditivos
     */
    public function removeFkLicitacaoContratoAditivos(\Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos $fkLicitacaoContratoAditivos)
    {
        $this->fkLicitacaoContratoAditivos->removeElement($fkLicitacaoContratoAditivos);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoContratoAditivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos
     */
    public function getFkLicitacaoContratoAditivos()
    {
        return $this->fkLicitacaoContratoAditivos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoConvenioAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos $fkLicitacaoConvenioAditivos
     * @return SwCgm
     */
    public function addFkLicitacaoConvenioAditivos(\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos $fkLicitacaoConvenioAditivos)
    {
        if (false === $this->fkLicitacaoConvenioAditivos->contains($fkLicitacaoConvenioAditivos)) {
            $fkLicitacaoConvenioAditivos->setFkSwCgm($this);
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
     * @return SwCgm
     */
    public function addFkLicitacaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio)
    {
        if (false === $this->fkLicitacaoConvenios->contains($fkLicitacaoConvenio)) {
            $fkLicitacaoConvenio->setFkSwCgm($this);
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
     * Add LicitacaoConvenioAditivosPublicacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosPublicacao $fkLicitacaoConvenioAditivosPublicacao
     * @return SwCgm
     */
    public function addFkLicitacaoConvenioAditivosPublicacoes(\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosPublicacao $fkLicitacaoConvenioAditivosPublicacao)
    {
        if (false === $this->fkLicitacaoConvenioAditivosPublicacoes->contains($fkLicitacaoConvenioAditivosPublicacao)) {
            $fkLicitacaoConvenioAditivosPublicacao->setFkSwCgm($this);
            $this->fkLicitacaoConvenioAditivosPublicacoes->add($fkLicitacaoConvenioAditivosPublicacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoConvenioAditivosPublicacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosPublicacao $fkLicitacaoConvenioAditivosPublicacao
     */
    public function removeFkLicitacaoConvenioAditivosPublicacoes(\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosPublicacao $fkLicitacaoConvenioAditivosPublicacao)
    {
        $this->fkLicitacaoConvenioAditivosPublicacoes->removeElement($fkLicitacaoConvenioAditivosPublicacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoConvenioAditivosPublicacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosPublicacao
     */
    public function getFkLicitacaoConvenioAditivosPublicacoes()
    {
        return $this->fkLicitacaoConvenioAditivosPublicacoes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     * @return SwCgm
     */
    public function addFkLicitacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        if (false === $this->fkLicitacaoContratos->contains($fkLicitacaoContrato)) {
            $fkLicitacaoContrato->setFkSwCgm($this);
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
     * Add LicitacaoComissaoMembros
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros
     * @return SwCgm
     */
    public function addFkLicitacaoComissaoMembros(\Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros)
    {
        if (false === $this->fkLicitacaoComissaoMembros->contains($fkLicitacaoComissaoMembros)) {
            $fkLicitacaoComissaoMembros->setFkSwCgm($this);
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
     * Add LicitacaoParticipante
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Participante $fkLicitacaoParticipante
     * @return SwCgm
     */
    public function addFkLicitacaoParticipantes(\Urbem\CoreBundle\Entity\Licitacao\Participante $fkLicitacaoParticipante)
    {
        if (false === $this->fkLicitacaoParticipantes->contains($fkLicitacaoParticipante)) {
            $fkLicitacaoParticipante->setFkSwCgm($this);
            $this->fkLicitacaoParticipantes->add($fkLicitacaoParticipante);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoParticipante
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Participante $fkLicitacaoParticipante
     */
    public function removeFkLicitacaoParticipantes(\Urbem\CoreBundle\Entity\Licitacao\Participante $fkLicitacaoParticipante)
    {
        $this->fkLicitacaoParticipantes->removeElement($fkLicitacaoParticipante);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoParticipantes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Participante
     */
    public function getFkLicitacaoParticipantes()
    {
        return $this->fkLicitacaoParticipantes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoMembroAdicional
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\MembroAdicional $fkLicitacaoMembroAdicional
     * @return SwCgm
     */
    public function addFkLicitacaoMembroAdicionais(\Urbem\CoreBundle\Entity\Licitacao\MembroAdicional $fkLicitacaoMembroAdicional)
    {
        if (false === $this->fkLicitacaoMembroAdicionais->contains($fkLicitacaoMembroAdicional)) {
            $fkLicitacaoMembroAdicional->setFkSwCgm($this);
            $this->fkLicitacaoMembroAdicionais->add($fkLicitacaoMembroAdicional);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoMembroAdicional
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\MembroAdicional $fkLicitacaoMembroAdicional
     */
    public function removeFkLicitacaoMembroAdicionais(\Urbem\CoreBundle\Entity\Licitacao\MembroAdicional $fkLicitacaoMembroAdicional)
    {
        $this->fkLicitacaoMembroAdicionais->removeElement($fkLicitacaoMembroAdicional);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoMembroAdicionais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\MembroAdicional
     */
    public function getFkLicitacaoMembroAdicionais()
    {
        return $this->fkLicitacaoMembroAdicionais;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoParticipanteConsorcio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteConsorcio $fkLicitacaoParticipanteConsorcio
     * @return SwCgm
     */
    public function addFkLicitacaoParticipanteConsorcios(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConsorcio $fkLicitacaoParticipanteConsorcio)
    {
        if (false === $this->fkLicitacaoParticipanteConsorcios->contains($fkLicitacaoParticipanteConsorcio)) {
            $fkLicitacaoParticipanteConsorcio->setFkSwCgm($this);
            $this->fkLicitacaoParticipanteConsorcios->add($fkLicitacaoParticipanteConsorcio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoParticipanteConsorcio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteConsorcio $fkLicitacaoParticipanteConsorcio
     */
    public function removeFkLicitacaoParticipanteConsorcios(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConsorcio $fkLicitacaoParticipanteConsorcio)
    {
        $this->fkLicitacaoParticipanteConsorcios->removeElement($fkLicitacaoParticipanteConsorcio);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoParticipanteConsorcios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConsorcio
     */
    public function getFkLicitacaoParticipanteConsorcios()
    {
        return $this->fkLicitacaoParticipanteConsorcios;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital
     * @return SwCgm
     */
    public function addFkLicitacaoEditais(\Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital)
    {
        if (false === $this->fkLicitacaoEditais->contains($fkLicitacaoEdital)) {
            $fkLicitacaoEdital->setFkSwCgm($this);
            $this->fkLicitacaoEditais->add($fkLicitacaoEdital);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital
     */
    public function removeFkLicitacaoEditais(\Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital)
    {
        $this->fkLicitacaoEditais->removeElement($fkLicitacaoEdital);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoEditais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Edital
     */
    public function getFkLicitacaoEditais()
    {
        return $this->fkLicitacaoEditais;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoRescisaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\RescisaoConvenio $fkLicitacaoRescisaoConvenio
     * @return SwCgm
     */
    public function addFkLicitacaoRescisaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\RescisaoConvenio $fkLicitacaoRescisaoConvenio)
    {
        if (false === $this->fkLicitacaoRescisaoConvenios->contains($fkLicitacaoRescisaoConvenio)) {
            $fkLicitacaoRescisaoConvenio->setFkSwCgm($this);
            $this->fkLicitacaoRescisaoConvenios->add($fkLicitacaoRescisaoConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoRescisaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\RescisaoConvenio $fkLicitacaoRescisaoConvenio
     */
    public function removeFkLicitacaoRescisaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\RescisaoConvenio $fkLicitacaoRescisaoConvenio)
    {
        $this->fkLicitacaoRescisaoConvenios->removeElement($fkLicitacaoRescisaoConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoRescisaoConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\RescisaoConvenio
     */
    public function getFkLicitacaoRescisaoConvenios()
    {
        return $this->fkLicitacaoRescisaoConvenios;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoRescisaoContratoResponsavelJuridico
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\RescisaoContratoResponsavelJuridico $fkLicitacaoRescisaoContratoResponsavelJuridico
     * @return SwCgm
     */
    public function addFkLicitacaoRescisaoContratoResponsavelJuridicos(\Urbem\CoreBundle\Entity\Licitacao\RescisaoContratoResponsavelJuridico $fkLicitacaoRescisaoContratoResponsavelJuridico)
    {
        if (false === $this->fkLicitacaoRescisaoContratoResponsavelJuridicos->contains($fkLicitacaoRescisaoContratoResponsavelJuridico)) {
            $fkLicitacaoRescisaoContratoResponsavelJuridico->setFkSwCgm($this);
            $this->fkLicitacaoRescisaoContratoResponsavelJuridicos->add($fkLicitacaoRescisaoContratoResponsavelJuridico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoRescisaoContratoResponsavelJuridico
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\RescisaoContratoResponsavelJuridico $fkLicitacaoRescisaoContratoResponsavelJuridico
     */
    public function removeFkLicitacaoRescisaoContratoResponsavelJuridicos(\Urbem\CoreBundle\Entity\Licitacao\RescisaoContratoResponsavelJuridico $fkLicitacaoRescisaoContratoResponsavelJuridico)
    {
        $this->fkLicitacaoRescisaoContratoResponsavelJuridicos->removeElement($fkLicitacaoRescisaoContratoResponsavelJuridico);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoRescisaoContratoResponsavelJuridicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\RescisaoContratoResponsavelJuridico
     */
    public function getFkLicitacaoRescisaoContratoResponsavelJuridicos()
    {
        return $this->fkLicitacaoRescisaoContratoResponsavelJuridicos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoPublicacaoRescisaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoConvenio $fkLicitacaoPublicacaoRescisaoConvenio
     * @return SwCgm
     */
    public function addFkLicitacaoPublicacaoRescisaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoConvenio $fkLicitacaoPublicacaoRescisaoConvenio)
    {
        if (false === $this->fkLicitacaoPublicacaoRescisaoConvenios->contains($fkLicitacaoPublicacaoRescisaoConvenio)) {
            $fkLicitacaoPublicacaoRescisaoConvenio->setFkSwCgm($this);
            $this->fkLicitacaoPublicacaoRescisaoConvenios->add($fkLicitacaoPublicacaoRescisaoConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoPublicacaoRescisaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoConvenio $fkLicitacaoPublicacaoRescisaoConvenio
     */
    public function removeFkLicitacaoPublicacaoRescisaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoConvenio $fkLicitacaoPublicacaoRescisaoConvenio)
    {
        $this->fkLicitacaoPublicacaoRescisaoConvenios->removeElement($fkLicitacaoPublicacaoRescisaoConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoPublicacaoRescisaoConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoConvenio
     */
    public function getFkLicitacaoPublicacaoRescisaoConvenios()
    {
        return $this->fkLicitacaoPublicacaoRescisaoConvenios;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Orgao $fkOrcamentoOrgao
     * @return SwCgm
     */
    public function addFkOrcamentoOrgoes(\Urbem\CoreBundle\Entity\Orcamento\Orgao $fkOrcamentoOrgao)
    {
        if (false === $this->fkOrcamentoOrgoes->contains($fkOrcamentoOrgao)) {
            $fkOrcamentoOrgao->setFkSwCgm($this);
            $this->fkOrcamentoOrgoes->add($fkOrcamentoOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Orgao $fkOrcamentoOrgao
     */
    public function removeFkOrcamentoOrgoes(\Urbem\CoreBundle\Entity\Orcamento\Orgao $fkOrcamentoOrgao)
    {
        $this->fkOrcamentoOrgoes->removeElement($fkOrcamentoOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Orgao
     */
    public function getFkOrcamentoOrgoes()
    {
        return $this->fkOrcamentoOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return SwCgm
     */
    public function addFkOrcamentoUnidades(\Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade)
    {
        if (false === $this->fkOrcamentoUnidades->contains($fkOrcamentoUnidade)) {
            $fkOrcamentoUnidade->setFkSwCgm($this);
            $this->fkOrcamentoUnidades->add($fkOrcamentoUnidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     */
    public function removeFkOrcamentoUnidades(\Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade)
    {
        $this->fkOrcamentoUnidades->removeElement($fkOrcamentoUnidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoUnidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    public function getFkOrcamentoUnidades()
    {
        return $this->fkOrcamentoUnidades;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaOrgaoCgm
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\OrgaoCgm $fkOrganogramaOrgaoCgm
     * @return SwCgm
     */
    public function addFkOrganogramaOrgaoCgns(\Urbem\CoreBundle\Entity\Organograma\OrgaoCgm $fkOrganogramaOrgaoCgm)
    {
        if (false === $this->fkOrganogramaOrgaoCgns->contains($fkOrganogramaOrgaoCgm)) {
            $fkOrganogramaOrgaoCgm->setFkSwCgm($this);
            $this->fkOrganogramaOrgaoCgns->add($fkOrganogramaOrgaoCgm);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaOrgaoCgm
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\OrgaoCgm $fkOrganogramaOrgaoCgm
     */
    public function removeFkOrganogramaOrgaoCgns(\Urbem\CoreBundle\Entity\Organograma\OrgaoCgm $fkOrganogramaOrgaoCgm)
    {
        $this->fkOrganogramaOrgaoCgns->removeElement($fkOrganogramaOrgaoCgm);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaOrgaoCgns
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\OrgaoCgm
     */
    public function getFkOrganogramaOrgaoCgns()
    {
        return $this->fkOrganogramaOrgaoCgns;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioApolice
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Apolice $fkPatrimonioApolice
     * @return SwCgm
     */
    public function addFkPatrimonioApolices(\Urbem\CoreBundle\Entity\Patrimonio\Apolice $fkPatrimonioApolice)
    {
        if (false === $this->fkPatrimonioApolices->contains($fkPatrimonioApolice)) {
            $fkPatrimonioApolice->setFkSwCgm($this);
            $this->fkPatrimonioApolices->add($fkPatrimonioApolice);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioApolice
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Apolice $fkPatrimonioApolice
     */
    public function removeFkPatrimonioApolices(\Urbem\CoreBundle\Entity\Patrimonio\Apolice $fkPatrimonioApolice)
    {
        $this->fkPatrimonioApolices->removeElement($fkPatrimonioApolice);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioApolices
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Apolice
     */
    public function getFkPatrimonioApolices()
    {
        return $this->fkPatrimonioApolices;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioBemResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemResponsavel $fkPatrimonioBemResponsavel
     * @return SwCgm
     */
    public function addFkPatrimonioBemResponsaveis(\Urbem\CoreBundle\Entity\Patrimonio\BemResponsavel $fkPatrimonioBemResponsavel)
    {
        if (false === $this->fkPatrimonioBemResponsaveis->contains($fkPatrimonioBemResponsavel)) {
            $fkPatrimonioBemResponsavel->setFkSwCgm($this);
            $this->fkPatrimonioBemResponsaveis->add($fkPatrimonioBemResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioBemResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemResponsavel $fkPatrimonioBemResponsavel
     */
    public function removeFkPatrimonioBemResponsaveis(\Urbem\CoreBundle\Entity\Patrimonio\BemResponsavel $fkPatrimonioBemResponsavel)
    {
        $this->fkPatrimonioBemResponsaveis->removeElement($fkPatrimonioBemResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioBemResponsaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemResponsavel
     */
    public function getFkPatrimonioBemResponsaveis()
    {
        return $this->fkPatrimonioBemResponsaveis;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioManutencao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Manutencao $fkPatrimonioManutencao
     * @return SwCgm
     */
    public function addFkPatrimonioManutencoes(\Urbem\CoreBundle\Entity\Patrimonio\Manutencao $fkPatrimonioManutencao)
    {
        if (false === $this->fkPatrimonioManutencoes->contains($fkPatrimonioManutencao)) {
            $fkPatrimonioManutencao->setFkSwCgm($this);
            $this->fkPatrimonioManutencoes->add($fkPatrimonioManutencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioManutencao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Manutencao $fkPatrimonioManutencao
     */
    public function removeFkPatrimonioManutencoes(\Urbem\CoreBundle\Entity\Patrimonio\Manutencao $fkPatrimonioManutencao)
    {
        $this->fkPatrimonioManutencoes->removeElement($fkPatrimonioManutencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioManutencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Manutencao
     */
    public function getFkPatrimonioManutencoes()
    {
        return $this->fkPatrimonioManutencoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAdidoCedido
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AdidoCedido $fkPessoalAdidoCedido
     * @return SwCgm
     */
    public function addFkPessoalAdidoCedidos(\Urbem\CoreBundle\Entity\Pessoal\AdidoCedido $fkPessoalAdidoCedido)
    {
        if (false === $this->fkPessoalAdidoCedidos->contains($fkPessoalAdidoCedido)) {
            $fkPessoalAdidoCedido->setFkSwCgm($this);
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
     * Add SwCga
     *
     * @param \Urbem\CoreBundle\Entity\SwCga $fkSwCga
     * @return SwCgm
     */
    public function addFkSwCgas(\Urbem\CoreBundle\Entity\SwCga $fkSwCga)
    {
        if (false === $this->fkSwCgas->contains($fkSwCga)) {
            $fkSwCga->setFkSwCgm($this);
            $this->fkSwCgas->add($fkSwCga);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCga
     *
     * @param \Urbem\CoreBundle\Entity\SwCga $fkSwCga
     */
    public function removeFkSwCgas(\Urbem\CoreBundle\Entity\SwCga $fkSwCga)
    {
        $this->fkSwCgas->removeElement($fkSwCga);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCga
     */
    public function getFkSwCgas()
    {
        return $this->fkSwCgas;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgmLogradouroCorrespondencia
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmLogradouroCorrespondencia $fkSwCgmLogradouroCorrespondencia
     * @return SwCgm
     */
    public function addFkSwCgmLogradouroCorrespondencias(\Urbem\CoreBundle\Entity\SwCgmLogradouroCorrespondencia $fkSwCgmLogradouroCorrespondencia)
    {
        if (false === $this->fkSwCgmLogradouroCorrespondencias->contains($fkSwCgmLogradouroCorrespondencia)) {
            $fkSwCgmLogradouroCorrespondencia->setFkSwCgm($this);
            $this->fkSwCgmLogradouroCorrespondencias->add($fkSwCgmLogradouroCorrespondencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgmLogradouroCorrespondencia
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmLogradouroCorrespondencia $fkSwCgmLogradouroCorrespondencia
     */
    public function removeFkSwCgmLogradouroCorrespondencias(\Urbem\CoreBundle\Entity\SwCgmLogradouroCorrespondencia $fkSwCgmLogradouroCorrespondencia)
    {
        $this->fkSwCgmLogradouroCorrespondencias->removeElement($fkSwCgmLogradouroCorrespondencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgmLogradouroCorrespondencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgmLogradouroCorrespondencia
     */
    public function getFkSwCgmLogradouroCorrespondencias()
    {
        return $this->fkSwCgmLogradouroCorrespondencias;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgmLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmLogradouro $fkSwCgmLogradouro
     * @return SwCgm
     */
    public function addFkSwCgmLogradouros(\Urbem\CoreBundle\Entity\SwCgmLogradouro $fkSwCgmLogradouro)
    {
        if (false === $this->fkSwCgmLogradouros->contains($fkSwCgmLogradouro)) {
            $fkSwCgmLogradouro->setFkSwCgm($this);
            $this->fkSwCgmLogradouros->add($fkSwCgmLogradouro);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgmLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmLogradouro $fkSwCgmLogradouro
     */
    public function removeFkSwCgmLogradouros(\Urbem\CoreBundle\Entity\SwCgmLogradouro $fkSwCgmLogradouro)
    {
        $this->fkSwCgmLogradouros->removeElement($fkSwCgmLogradouro);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgmLogradouros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgmLogradouro
     */
    public function getFkSwCgmLogradouros()
    {
        return $this->fkSwCgmLogradouros;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgmAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmAtributoValor $fkSwCgmAtributoValor
     * @return SwCgm
     */
    public function addFkSwCgmAtributoValores(\Urbem\CoreBundle\Entity\SwCgmAtributoValor $fkSwCgmAtributoValor)
    {
        if (false === $this->fkSwCgmAtributoValores->contains($fkSwCgmAtributoValor)) {
            $fkSwCgmAtributoValor->setFkSwCgm($this);
            $this->fkSwCgmAtributoValores->add($fkSwCgmAtributoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgmAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmAtributoValor $fkSwCgmAtributoValor
     */
    public function removeFkSwCgmAtributoValores(\Urbem\CoreBundle\Entity\SwCgmAtributoValor $fkSwCgmAtributoValor)
    {
        $this->fkSwCgmAtributoValores->removeElement($fkSwCgmAtributoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgmAtributoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgmAtributoValor
     */
    public function getFkSwCgmAtributoValores()
    {
        return $this->fkSwCgmAtributoValores;
    }

    /**
     * OneToMany (owning side)
     * Add SwProcessoArquivado
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoArquivado $fkSwProcessoArquivado
     * @return SwCgm
     */
    public function addFkSwProcessoArquivados(\Urbem\CoreBundle\Entity\SwProcessoArquivado $fkSwProcessoArquivado)
    {
        if (false === $this->fkSwProcessoArquivados->contains($fkSwProcessoArquivado)) {
            $fkSwProcessoArquivado->setFkSwCgm($this);
            $this->fkSwProcessoArquivados->add($fkSwProcessoArquivado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwProcessoArquivado
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoArquivado $fkSwProcessoArquivado
     */
    public function removeFkSwProcessoArquivados(\Urbem\CoreBundle\Entity\SwProcessoArquivado $fkSwProcessoArquivado)
    {
        $this->fkSwProcessoArquivados->removeElement($fkSwProcessoArquivado);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwProcessoArquivados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcessoArquivado
     */
    public function getFkSwProcessoArquivados()
    {
        return $this->fkSwProcessoArquivados;
    }

    /**
     * OneToMany (owning side)
     * Add SwPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho
     * @return SwCgm
     */
    public function addFkSwPreEmpenhos(\Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho)
    {
        if (false === $this->fkSwPreEmpenhos->contains($fkSwPreEmpenho)) {
            $fkSwPreEmpenho->setFkSwCgm($this);
            $this->fkSwPreEmpenhos->add($fkSwPreEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho
     */
    public function removeFkSwPreEmpenhos(\Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho)
    {
        $this->fkSwPreEmpenhos->removeElement($fkSwPreEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwPreEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPreEmpenho
     */
    public function getFkSwPreEmpenhos()
    {
        return $this->fkSwPreEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add SwProcessoInteressado
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoInteressado $fkSwProcessoInteressado
     * @return SwCgm
     */
    public function addFkSwProcessoInteressados(\Urbem\CoreBundle\Entity\SwProcessoInteressado $fkSwProcessoInteressado)
    {
        if (false === $this->fkSwProcessoInteressados->contains($fkSwProcessoInteressado)) {
            $fkSwProcessoInteressado->setFkSwCgm($this);
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
     * Add TcealCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\Credor $fkTcealCredor
     * @return SwCgm
     */
    public function addFkTcealCredores(\Urbem\CoreBundle\Entity\Tceal\Credor $fkTcealCredor)
    {
        if (false === $this->fkTcealCredores->contains($fkTcealCredor)) {
            $fkTcealCredor->setFkSwCgm($this);
            $this->fkTcealCredores->add($fkTcealCredor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcealCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\Credor $fkTcealCredor
     */
    public function removeFkTcealCredores(\Urbem\CoreBundle\Entity\Tceal\Credor $fkTcealCredor)
    {
        $this->fkTcealCredores->removeElement($fkTcealCredor);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcealCredores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\Credor
     */
    public function getFkTcealCredores()
    {
        return $this->fkTcealCredores;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgConfiguracaoDdc
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoDdc $fkTcemgConfiguracaoDdc
     * @return SwCgm
     */
    public function addFkTcemgConfiguracaoDdcs(\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoDdc $fkTcemgConfiguracaoDdc)
    {
        if (false === $this->fkTcemgConfiguracaoDdcs->contains($fkTcemgConfiguracaoDdc)) {
            $fkTcemgConfiguracaoDdc->setFkSwCgm($this);
            $this->fkTcemgConfiguracaoDdcs->add($fkTcemgConfiguracaoDdc);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgConfiguracaoDdc
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoDdc $fkTcemgConfiguracaoDdc
     */
    public function removeFkTcemgConfiguracaoDdcs(\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoDdc $fkTcemgConfiguracaoDdc)
    {
        $this->fkTcemgConfiguracaoDdcs->removeElement($fkTcemgConfiguracaoDdc);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgConfiguracaoDdcs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoDdc
     */
    public function getFkTcemgConfiguracaoDdcs()
    {
        return $this->fkTcemgConfiguracaoDdcs;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato
     * @return SwCgm
     */
    public function addFkTcemgContratos(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        if (false === $this->fkTcemgContratos->contains($fkTcemgContrato)) {
            $fkTcemgContrato->setFkSwCgm($this);
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
     * Add TcemgItemRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos $fkTcemgItemRegistroPrecos
     * @return SwCgm
     */
    public function addFkTcemgItemRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos $fkTcemgItemRegistroPrecos)
    {
        if (false === $this->fkTcemgItemRegistroPrecos->contains($fkTcemgItemRegistroPrecos)) {
            $fkTcemgItemRegistroPrecos->setFkSwCgm($this);
            $this->fkTcemgItemRegistroPrecos->add($fkTcemgItemRegistroPrecos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgItemRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos $fkTcemgItemRegistroPrecos
     */
    public function removeFkTcemgItemRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos $fkTcemgItemRegistroPrecos)
    {
        $this->fkTcemgItemRegistroPrecos->removeElement($fkTcemgItemRegistroPrecos);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgItemRegistroPrecos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos
     */
    public function getFkTcemgItemRegistroPrecos()
    {
        return $this->fkTcemgItemRegistroPrecos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos $fkTcemgRegistroPrecos
     * @return SwCgm
     */
    public function addFkTcemgRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos $fkTcemgRegistroPrecos)
    {
        if (false === $this->fkTcemgRegistroPrecos->contains($fkTcemgRegistroPrecos)) {
            $fkTcemgRegistroPrecos->setFkSwCgm($this);
            $this->fkTcemgRegistroPrecos->add($fkTcemgRegistroPrecos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos $fkTcemgRegistroPrecos
     */
    public function removeFkTcemgRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos $fkTcemgRegistroPrecos)
    {
        $this->fkTcemgRegistroPrecos->removeElement($fkTcemgRegistroPrecos);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgRegistroPrecos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos
     */
    public function getFkTcemgRegistroPrecos()
    {
        return $this->fkTcemgRegistroPrecos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Uniorcam $fkTcemgUniorcam
     * @return SwCgm
     */
    public function addFkTcemgUniorcans(\Urbem\CoreBundle\Entity\Tcemg\Uniorcam $fkTcemgUniorcam)
    {
        if (false === $this->fkTcemgUniorcans->contains($fkTcemgUniorcam)) {
            $fkTcemgUniorcam->setFkSwCgm($this);
            $this->fkTcemgUniorcans->add($fkTcemgUniorcam);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Uniorcam $fkTcemgUniorcam
     */
    public function removeFkTcemgUniorcans(\Urbem\CoreBundle\Entity\Tcemg\Uniorcam $fkTcemgUniorcam)
    {
        $this->fkTcemgUniorcans->removeElement($fkTcemgUniorcam);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgUniorcans
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Uniorcam
     */
    public function getFkTcemgUniorcans()
    {
        return $this->fkTcemgUniorcans;
    }

    /**
     * OneToMany (owning side)
     * Add TcepbUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\Uniorcam $fkTcepbUniorcam
     * @return SwCgm
     */
    public function addFkTcepbUniorcans(\Urbem\CoreBundle\Entity\Tcepb\Uniorcam $fkTcepbUniorcam)
    {
        if (false === $this->fkTcepbUniorcans->contains($fkTcepbUniorcam)) {
            $fkTcepbUniorcam->setFkSwCgm($this);
            $this->fkTcepbUniorcans->add($fkTcepbUniorcam);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepbUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\Uniorcam $fkTcepbUniorcam
     */
    public function removeFkTcepbUniorcans(\Urbem\CoreBundle\Entity\Tcepb\Uniorcam $fkTcepbUniorcam)
    {
        $this->fkTcepbUniorcans->removeElement($fkTcepbUniorcam);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepbUniorcans
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\Uniorcam
     */
    public function getFkTcepbUniorcans()
    {
        return $this->fkTcepbUniorcans;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeCgmTipoCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\CgmTipoCredor $fkTcepeCgmTipoCredor
     * @return SwCgm
     */
    public function addFkTcepeCgmTipoCredores(\Urbem\CoreBundle\Entity\Tcepe\CgmTipoCredor $fkTcepeCgmTipoCredor)
    {
        if (false === $this->fkTcepeCgmTipoCredores->contains($fkTcepeCgmTipoCredor)) {
            $fkTcepeCgmTipoCredor->setFkSwCgm($this);
            $this->fkTcepeCgmTipoCredores->add($fkTcepeCgmTipoCredor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeCgmTipoCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\CgmTipoCredor $fkTcepeCgmTipoCredor
     */
    public function removeFkTcepeCgmTipoCredores(\Urbem\CoreBundle\Entity\Tcepe\CgmTipoCredor $fkTcepeCgmTipoCredor)
    {
        $this->fkTcepeCgmTipoCredores->removeElement($fkTcepeCgmTipoCredor);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeCgmTipoCredores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\CgmTipoCredor
     */
    public function getFkTcepeCgmTipoCredores()
    {
        return $this->fkTcepeCgmTipoCredores;
    }

    /**
     * OneToMany (owning side)
     * Add TcernUnidadeGestoraResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel $fkTcernUnidadeGestoraResponsavel
     * @return SwCgm
     */
    public function addFkTcernUnidadeGestoraResponsaveis(\Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel $fkTcernUnidadeGestoraResponsavel)
    {
        if (false === $this->fkTcernUnidadeGestoraResponsaveis->contains($fkTcernUnidadeGestoraResponsavel)) {
            $fkTcernUnidadeGestoraResponsavel->setFkSwCgm($this);
            $this->fkTcernUnidadeGestoraResponsaveis->add($fkTcernUnidadeGestoraResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernUnidadeGestoraResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel $fkTcernUnidadeGestoraResponsavel
     */
    public function removeFkTcernUnidadeGestoraResponsaveis(\Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel $fkTcernUnidadeGestoraResponsavel)
    {
        $this->fkTcernUnidadeGestoraResponsaveis->removeElement($fkTcernUnidadeGestoraResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernUnidadeGestoraResponsaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel
     */
    public function getFkTcernUnidadeGestoraResponsaveis()
    {
        return $this->fkTcernUnidadeGestoraResponsaveis;
    }

    /**
     * OneToMany (owning side)
     * Add TcernUnidadeGestora
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeGestora $fkTcernUnidadeGestora
     * @return SwCgm
     */
    public function addFkTcernUnidadeGestoras(\Urbem\CoreBundle\Entity\Tcern\UnidadeGestora $fkTcernUnidadeGestora)
    {
        if (false === $this->fkTcernUnidadeGestoras->contains($fkTcernUnidadeGestora)) {
            $fkTcernUnidadeGestora->setFkSwCgm($this);
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
     * @return SwCgm
     */
    public function addFkTcernUnidadeOrcamentarias(\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria $fkTcernUnidadeOrcamentaria)
    {
        if (false === $this->fkTcernUnidadeOrcamentarias->contains($fkTcernUnidadeOrcamentaria)) {
            $fkTcernUnidadeOrcamentaria->setFkSwCgm($this);
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
     * Add TcernObraContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ObraContrato $fkTcernObraContrato
     * @return SwCgm
     */
    public function addFkTcernObraContratos(\Urbem\CoreBundle\Entity\Tcern\ObraContrato $fkTcernObraContrato)
    {
        if (false === $this->fkTcernObraContratos->contains($fkTcernObraContrato)) {
            $fkTcernObraContrato->setFkSwCgm($this);
            $this->fkTcernObraContratos->add($fkTcernObraContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernObraContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ObraContrato $fkTcernObraContrato
     */
    public function removeFkTcernObraContratos(\Urbem\CoreBundle\Entity\Tcern\ObraContrato $fkTcernObraContrato)
    {
        $this->fkTcernObraContratos->removeElement($fkTcernObraContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernObraContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ObraContrato
     */
    public function getFkTcernObraContratos()
    {
        return $this->fkTcernObraContratos;
    }

    /**
     * OneToMany (owning side)
     * Add TcernObraContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ObraContrato $fkTcernObraContrato
     * @return SwCgm
     */
    public function addFkTcernObraContratos1(\Urbem\CoreBundle\Entity\Tcern\ObraContrato $fkTcernObraContrato)
    {
        if (false === $this->fkTcernObraContratos1->contains($fkTcernObraContrato)) {
            $fkTcernObraContrato->setFkSwCgm1($this);
            $this->fkTcernObraContratos1->add($fkTcernObraContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernObraContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ObraContrato $fkTcernObraContrato
     */
    public function removeFkTcernObraContratos1(\Urbem\CoreBundle\Entity\Tcern\ObraContrato $fkTcernObraContrato)
    {
        $this->fkTcernObraContratos1->removeElement($fkTcernObraContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernObraContratos1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ObraContrato
     */
    public function getFkTcernObraContratos1()
    {
        return $this->fkTcernObraContratos1;
    }

    /**
     * OneToMany (owning side)
     * Add TcersCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\Credor $fkTcersCredor
     * @return SwCgm
     */
    public function addFkTcersCredores(\Urbem\CoreBundle\Entity\Tcers\Credor $fkTcersCredor)
    {
        if (false === $this->fkTcersCredores->contains($fkTcersCredor)) {
            $fkTcersCredor->setFkSwCgm($this);
            $this->fkTcersCredores->add($fkTcersCredor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcersCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\Credor $fkTcersCredor
     */
    public function removeFkTcersCredores(\Urbem\CoreBundle\Entity\Tcers\Credor $fkTcersCredor)
    {
        $this->fkTcersCredores->removeElement($fkTcersCredor);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcersCredores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\Credor
     */
    public function getFkTcersCredores()
    {
        return $this->fkTcersCredores;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaObraFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraFiscal $fkTcmbaObraFiscal
     * @return SwCgm
     */
    public function addFkTcmbaObraFiscais(\Urbem\CoreBundle\Entity\Tcmba\ObraFiscal $fkTcmbaObraFiscal)
    {
        if (false === $this->fkTcmbaObraFiscais->contains($fkTcmbaObraFiscal)) {
            $fkTcmbaObraFiscal->setFkSwCgm($this);
            $this->fkTcmbaObraFiscais->add($fkTcmbaObraFiscal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaObraFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraFiscal $fkTcmbaObraFiscal
     */
    public function removeFkTcmbaObraFiscais(\Urbem\CoreBundle\Entity\Tcmba\ObraFiscal $fkTcmbaObraFiscal)
    {
        $this->fkTcmbaObraFiscais->removeElement($fkTcmbaObraFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaObraFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraFiscal
     */
    public function getFkTcmbaObraFiscais()
    {
        return $this->fkTcmbaObraFiscais;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoConfiguracaoIde
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde
     * @return SwCgm
     */
    public function addFkTcmgoConfiguracaoIdes(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde)
    {
        if (false === $this->fkTcmgoConfiguracaoIdes->contains($fkTcmgoConfiguracaoIde)) {
            $fkTcmgoConfiguracaoIde->setFkSwCgm($this);
            $this->fkTcmgoConfiguracaoIdes->add($fkTcmgoConfiguracaoIde);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoConfiguracaoIde
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde
     */
    public function removeFkTcmgoConfiguracaoIdes(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde)
    {
        $this->fkTcmgoConfiguracaoIdes->removeElement($fkTcmgoConfiguracaoIde);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoConfiguracaoIdes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde
     */
    public function getFkTcmgoConfiguracaoIdes()
    {
        return $this->fkTcmgoConfiguracaoIdes;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoConfiguracaoIde
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde
     * @return SwCgm
     */
    public function addFkTcmgoConfiguracaoIdes1(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde)
    {
        if (false === $this->fkTcmgoConfiguracaoIdes1->contains($fkTcmgoConfiguracaoIde)) {
            $fkTcmgoConfiguracaoIde->setFkSwCgm1($this);
            $this->fkTcmgoConfiguracaoIdes1->add($fkTcmgoConfiguracaoIde);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoConfiguracaoIde
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde
     */
    public function removeFkTcmgoConfiguracaoIdes1(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde)
    {
        $this->fkTcmgoConfiguracaoIdes1->removeElement($fkTcmgoConfiguracaoIde);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoConfiguracaoIdes1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde
     */
    public function getFkTcmgoConfiguracaoIdes1()
    {
        return $this->fkTcmgoConfiguracaoIdes1;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoConfiguracaoIde
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde
     * @return SwCgm
     */
    public function addFkTcmgoConfiguracaoIdes2(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde)
    {
        if (false === $this->fkTcmgoConfiguracaoIdes2->contains($fkTcmgoConfiguracaoIde)) {
            $fkTcmgoConfiguracaoIde->setFkSwCgm2($this);
            $this->fkTcmgoConfiguracaoIdes2->add($fkTcmgoConfiguracaoIde);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoConfiguracaoIde
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde
     */
    public function removeFkTcmgoConfiguracaoIdes2(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde)
    {
        $this->fkTcmgoConfiguracaoIdes2->removeElement($fkTcmgoConfiguracaoIde);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoConfiguracaoIdes2
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde
     */
    public function getFkTcmgoConfiguracaoIdes2()
    {
        return $this->fkTcmgoConfiguracaoIdes2;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoDividaConsolidada
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\DividaConsolidada $fkTcmgoDividaConsolidada
     * @return SwCgm
     */
    public function addFkTcmgoDividaConsolidadas(\Urbem\CoreBundle\Entity\Tcmgo\DividaConsolidada $fkTcmgoDividaConsolidada)
    {
        if (false === $this->fkTcmgoDividaConsolidadas->contains($fkTcmgoDividaConsolidada)) {
            $fkTcmgoDividaConsolidada->setFkSwCgm($this);
            $this->fkTcmgoDividaConsolidadas->add($fkTcmgoDividaConsolidada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoDividaConsolidada
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\DividaConsolidada $fkTcmgoDividaConsolidada
     */
    public function removeFkTcmgoDividaConsolidadas(\Urbem\CoreBundle\Entity\Tcmgo\DividaConsolidada $fkTcmgoDividaConsolidada)
    {
        $this->fkTcmgoDividaConsolidadas->removeElement($fkTcmgoDividaConsolidada);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoDividaConsolidadas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\DividaConsolidada
     */
    public function getFkTcmgoDividaConsolidadas()
    {
        return $this->fkTcmgoDividaConsolidadas;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao
     * @return SwCgm
     */
    public function addFkTcmgoOrgoes(\Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao)
    {
        if (false === $this->fkTcmgoOrgoes->contains($fkTcmgoOrgao)) {
            $fkTcmgoOrgao->setFkSwCgm($this);
            $this->fkTcmgoOrgoes->add($fkTcmgoOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao
     */
    public function removeFkTcmgoOrgoes(\Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao)
    {
        $this->fkTcmgoOrgoes->removeElement($fkTcmgoOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\Orgao
     */
    public function getFkTcmgoOrgoes()
    {
        return $this->fkTcmgoOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoOrgaoGestor
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\OrgaoGestor $fkTcmgoOrgaoGestor
     * @return SwCgm
     */
    public function addFkTcmgoOrgaoGestores(\Urbem\CoreBundle\Entity\Tcmgo\OrgaoGestor $fkTcmgoOrgaoGestor)
    {
        if (false === $this->fkTcmgoOrgaoGestores->contains($fkTcmgoOrgaoGestor)) {
            $fkTcmgoOrgaoGestor->setFkSwCgm($this);
            $this->fkTcmgoOrgaoGestores->add($fkTcmgoOrgaoGestor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoOrgaoGestor
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\OrgaoGestor $fkTcmgoOrgaoGestor
     */
    public function removeFkTcmgoOrgaoGestores(\Urbem\CoreBundle\Entity\Tcmgo\OrgaoGestor $fkTcmgoOrgaoGestor)
    {
        $this->fkTcmgoOrgaoGestores->removeElement($fkTcmgoOrgaoGestor);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoOrgaoGestores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\OrgaoGestor
     */
    public function getFkTcmgoOrgaoGestores()
    {
        return $this->fkTcmgoOrgaoGestores;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoOrgaoRepresentante
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\OrgaoRepresentante $fkTcmgoOrgaoRepresentante
     * @return SwCgm
     */
    public function addFkTcmgoOrgaoRepresentantes(\Urbem\CoreBundle\Entity\Tcmgo\OrgaoRepresentante $fkTcmgoOrgaoRepresentante)
    {
        if (false === $this->fkTcmgoOrgaoRepresentantes->contains($fkTcmgoOrgaoRepresentante)) {
            $fkTcmgoOrgaoRepresentante->setFkSwCgm($this);
            $this->fkTcmgoOrgaoRepresentantes->add($fkTcmgoOrgaoRepresentante);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoOrgaoRepresentante
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\OrgaoRepresentante $fkTcmgoOrgaoRepresentante
     */
    public function removeFkTcmgoOrgaoRepresentantes(\Urbem\CoreBundle\Entity\Tcmgo\OrgaoRepresentante $fkTcmgoOrgaoRepresentante)
    {
        $this->fkTcmgoOrgaoRepresentantes->removeElement($fkTcmgoOrgaoRepresentante);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoOrgaoRepresentantes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\OrgaoRepresentante
     */
    public function getFkTcmgoOrgaoRepresentantes()
    {
        return $this->fkTcmgoOrgaoRepresentantes;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     * @return SwCgm
     */
    public function addFkTcmgoUnidadeResponsaveis(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        if (false === $this->fkTcmgoUnidadeResponsaveis->contains($fkTcmgoUnidadeResponsavel)) {
            $fkTcmgoUnidadeResponsavel->setFkSwCgm($this);
            $this->fkTcmgoUnidadeResponsaveis->add($fkTcmgoUnidadeResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     */
    public function removeFkTcmgoUnidadeResponsaveis(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        $this->fkTcmgoUnidadeResponsaveis->removeElement($fkTcmgoUnidadeResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoUnidadeResponsaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    public function getFkTcmgoUnidadeResponsaveis()
    {
        return $this->fkTcmgoUnidadeResponsaveis;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     * @return SwCgm
     */
    public function addFkTcmgoUnidadeResponsaveis1(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        if (false === $this->fkTcmgoUnidadeResponsaveis1->contains($fkTcmgoUnidadeResponsavel)) {
            $fkTcmgoUnidadeResponsavel->setFkSwCgm1($this);
            $this->fkTcmgoUnidadeResponsaveis1->add($fkTcmgoUnidadeResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     */
    public function removeFkTcmgoUnidadeResponsaveis1(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        $this->fkTcmgoUnidadeResponsaveis1->removeElement($fkTcmgoUnidadeResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoUnidadeResponsaveis1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    public function getFkTcmgoUnidadeResponsaveis1()
    {
        return $this->fkTcmgoUnidadeResponsaveis1;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     * @return SwCgm
     */
    public function addFkTcmgoUnidadeResponsaveis2(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        if (false === $this->fkTcmgoUnidadeResponsaveis2->contains($fkTcmgoUnidadeResponsavel)) {
            $fkTcmgoUnidadeResponsavel->setFkSwCgm2($this);
            $this->fkTcmgoUnidadeResponsaveis2->add($fkTcmgoUnidadeResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     */
    public function removeFkTcmgoUnidadeResponsaveis2(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        $this->fkTcmgoUnidadeResponsaveis2->removeElement($fkTcmgoUnidadeResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoUnidadeResponsaveis2
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    public function getFkTcmgoUnidadeResponsaveis2()
    {
        return $this->fkTcmgoUnidadeResponsaveis2;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     * @return SwCgm
     */
    public function addFkTcmgoUnidadeResponsaveis3(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        if (false === $this->fkTcmgoUnidadeResponsaveis3->contains($fkTcmgoUnidadeResponsavel)) {
            $fkTcmgoUnidadeResponsavel->setFkSwCgm3($this);
            $this->fkTcmgoUnidadeResponsaveis3->add($fkTcmgoUnidadeResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     */
    public function removeFkTcmgoUnidadeResponsaveis3(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        $this->fkTcmgoUnidadeResponsaveis3->removeElement($fkTcmgoUnidadeResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoUnidadeResponsaveis3
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    public function getFkTcmgoUnidadeResponsaveis3()
    {
        return $this->fkTcmgoUnidadeResponsaveis3;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoOrgaoControleInterno
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\OrgaoControleInterno $fkTcmgoOrgaoControleInterno
     * @return SwCgm
     */
    public function addFkTcmgoOrgaoControleInternos(\Urbem\CoreBundle\Entity\Tcmgo\OrgaoControleInterno $fkTcmgoOrgaoControleInterno)
    {
        if (false === $this->fkTcmgoOrgaoControleInternos->contains($fkTcmgoOrgaoControleInterno)) {
            $fkTcmgoOrgaoControleInterno->setFkSwCgm($this);
            $this->fkTcmgoOrgaoControleInternos->add($fkTcmgoOrgaoControleInterno);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoOrgaoControleInterno
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\OrgaoControleInterno $fkTcmgoOrgaoControleInterno
     */
    public function removeFkTcmgoOrgaoControleInternos(\Urbem\CoreBundle\Entity\Tcmgo\OrgaoControleInterno $fkTcmgoOrgaoControleInterno)
    {
        $this->fkTcmgoOrgaoControleInternos->removeElement($fkTcmgoOrgaoControleInterno);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoOrgaoControleInternos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\OrgaoControleInterno
     */
    public function getFkTcmgoOrgaoControleInternos()
    {
        return $this->fkTcmgoOrgaoControleInternos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Assinatura $fkTesourariaAssinatura
     * @return SwCgm
     */
    public function addFkTesourariaAssinaturas(\Urbem\CoreBundle\Entity\Tesouraria\Assinatura $fkTesourariaAssinatura)
    {
        if (false === $this->fkTesourariaAssinaturas->contains($fkTesourariaAssinatura)) {
            $fkTesourariaAssinatura->setFkSwCgm($this);
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
     * Add TesourariaTransacoesTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia $fkTesourariaTransacoesTransferencia
     * @return SwCgm
     */
    public function addFkTesourariaTransacoesTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia $fkTesourariaTransacoesTransferencia)
    {
        if (false === $this->fkTesourariaTransacoesTransferencias->contains($fkTesourariaTransacoesTransferencia)) {
            $fkTesourariaTransacoesTransferencia->setFkSwCgm($this);
            $this->fkTesourariaTransacoesTransferencias->add($fkTesourariaTransacoesTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransacoesTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia $fkTesourariaTransacoesTransferencia
     */
    public function removeFkTesourariaTransacoesTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia $fkTesourariaTransacoesTransferencia)
    {
        $this->fkTesourariaTransacoesTransferencias->removeElement($fkTesourariaTransacoesTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransacoesTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia
     */
    public function getFkTesourariaTransacoesTransferencias()
    {
        return $this->fkTesourariaTransacoesTransferencias;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaReciboExtraAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAssinatura $fkTesourariaReciboExtraAssinatura
     * @return SwCgm
     */
    public function addFkTesourariaReciboExtraAssinaturas(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAssinatura $fkTesourariaReciboExtraAssinatura)
    {
        if (false === $this->fkTesourariaReciboExtraAssinaturas->contains($fkTesourariaReciboExtraAssinatura)) {
            $fkTesourariaReciboExtraAssinatura->setFkSwCgm($this);
            $this->fkTesourariaReciboExtraAssinaturas->add($fkTesourariaReciboExtraAssinatura);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaReciboExtraAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAssinatura $fkTesourariaReciboExtraAssinatura
     */
    public function removeFkTesourariaReciboExtraAssinaturas(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAssinatura $fkTesourariaReciboExtraAssinatura)
    {
        $this->fkTesourariaReciboExtraAssinaturas->removeElement($fkTesourariaReciboExtraAssinatura);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaReciboExtraAssinaturas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAssinatura
     */
    public function getFkTesourariaReciboExtraAssinaturas()
    {
        return $this->fkTesourariaReciboExtraAssinaturas;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaReciboExtraCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraCredor $fkTesourariaReciboExtraCredor
     * @return SwCgm
     */
    public function addFkTesourariaReciboExtraCredores(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraCredor $fkTesourariaReciboExtraCredor)
    {
        if (false === $this->fkTesourariaReciboExtraCredores->contains($fkTesourariaReciboExtraCredor)) {
            $fkTesourariaReciboExtraCredor->setFkSwCgm($this);
            $this->fkTesourariaReciboExtraCredores->add($fkTesourariaReciboExtraCredor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaReciboExtraCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraCredor $fkTesourariaReciboExtraCredor
     */
    public function removeFkTesourariaReciboExtraCredores(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraCredor $fkTesourariaReciboExtraCredor)
    {
        $this->fkTesourariaReciboExtraCredores->removeElement($fkTesourariaReciboExtraCredor);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaReciboExtraCredores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraCredor
     */
    public function getFkTesourariaReciboExtraCredores()
    {
        return $this->fkTesourariaReciboExtraCredores;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaUsuarioTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal
     * @return SwCgm
     */
    public function addFkTesourariaUsuarioTerminais(\Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal)
    {
        if (false === $this->fkTesourariaUsuarioTerminais->contains($fkTesourariaUsuarioTerminal)) {
            $fkTesourariaUsuarioTerminal->setFkSwCgm($this);
            $this->fkTesourariaUsuarioTerminais->add($fkTesourariaUsuarioTerminal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaUsuarioTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal
     */
    public function removeFkTesourariaUsuarioTerminais(\Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal)
    {
        $this->fkTesourariaUsuarioTerminais->removeElement($fkTesourariaUsuarioTerminal);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaUsuarioTerminais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal
     */
    public function getFkTesourariaUsuarioTerminais()
    {
        return $this->fkTesourariaUsuarioTerminais;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao
     * @return SwCgm
     */
    public function addFkFrotaAutorizacoes(\Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao)
    {
        if (false === $this->fkFrotaAutorizacoes->contains($fkFrotaAutorizacao)) {
            $fkFrotaAutorizacao->setFkSwCgm($this);
            $this->fkFrotaAutorizacoes->add($fkFrotaAutorizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao
     */
    public function removeFkFrotaAutorizacoes(\Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao)
    {
        $this->fkFrotaAutorizacoes->removeElement($fkFrotaAutorizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaAutorizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Autorizacao
     */
    public function getFkFrotaAutorizacoes()
    {
        return $this->fkFrotaAutorizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao
     * @return SwCgm
     */
    public function addFkFrotaAutorizacoes1(\Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao)
    {
        if (false === $this->fkFrotaAutorizacoes1->contains($fkFrotaAutorizacao)) {
            $fkFrotaAutorizacao->setFkSwCgm1($this);
            $this->fkFrotaAutorizacoes1->add($fkFrotaAutorizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao
     */
    public function removeFkFrotaAutorizacoes1(\Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao)
    {
        $this->fkFrotaAutorizacoes1->removeElement($fkFrotaAutorizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaAutorizacoes1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Autorizacao
     */
    public function getFkFrotaAutorizacoes1()
    {
        return $this->fkFrotaAutorizacoes1;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao
     * @return SwCgm
     */
    public function addFkFrotaAutorizacoes2(\Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao)
    {
        if (false === $this->fkFrotaAutorizacoes2->contains($fkFrotaAutorizacao)) {
            $fkFrotaAutorizacao->setFkSwCgm2($this);
            $this->fkFrotaAutorizacoes2->add($fkFrotaAutorizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao
     */
    public function removeFkFrotaAutorizacoes2(\Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao)
    {
        $this->fkFrotaAutorizacoes2->removeElement($fkFrotaAutorizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaAutorizacoes2
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Autorizacao
     */
    public function getFkFrotaAutorizacoes2()
    {
        return $this->fkFrotaAutorizacoes2;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioBeneficiario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario
     * @return SwCgm
     */
    public function addFkBeneficioBeneficiarios(\Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario)
    {
        if (false === $this->fkBeneficioBeneficiarios->contains($fkBeneficioBeneficiario)) {
            $fkBeneficioBeneficiario->setFkSwCgm($this);
            $this->fkBeneficioBeneficiarios->add($fkBeneficioBeneficiario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioBeneficiario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario
     */
    public function removeFkBeneficioBeneficiarios(\Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario)
    {
        $this->fkBeneficioBeneficiarios->removeElement($fkBeneficioBeneficiario);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioBeneficiarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Beneficiario
     */
    public function getFkBeneficioBeneficiarios()
    {
        return $this->fkBeneficioBeneficiarios;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaAbastecimento
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Abastecimento $fkFrotaAbastecimento
     * @return SwCgm
     */
    public function addFkFrotaAbastecimentos(\Urbem\CoreBundle\Entity\Frota\Abastecimento $fkFrotaAbastecimento)
    {
        if (false === $this->fkFrotaAbastecimentos->contains($fkFrotaAbastecimento)) {
            $fkFrotaAbastecimento->setFkSwCgm($this);
            $this->fkFrotaAbastecimentos->add($fkFrotaAbastecimento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaAbastecimento
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Abastecimento $fkFrotaAbastecimento
     */
    public function removeFkFrotaAbastecimentos(\Urbem\CoreBundle\Entity\Frota\Abastecimento $fkFrotaAbastecimento)
    {
        $this->fkFrotaAbastecimentos->removeElement($fkFrotaAbastecimento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaAbastecimentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Abastecimento
     */
    public function getFkFrotaAbastecimentos()
    {
        return $this->fkFrotaAbastecimentos;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return SwCgm
     */
    public function addFkOrcamentoEntidades(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        if (false === $this->fkOrcamentoEntidades->contains($fkOrcamentoEntidade)) {
            $fkOrcamentoEntidade->setFkSwCgm($this);
            $this->fkOrcamentoEntidades->add($fkOrcamentoEntidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     */
    public function removeFkOrcamentoEntidades(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->fkOrcamentoEntidades->removeElement($fkOrcamentoEntidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoEntidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidades()
    {
        return $this->fkOrcamentoEntidades;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoRequisicao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao
     * @return SwCgm
     */
    public function addFkAlmoxarifadoRequisicoes(\Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao)
    {
        if (false === $this->fkAlmoxarifadoRequisicoes->contains($fkAlmoxarifadoRequisicao)) {
            $fkAlmoxarifadoRequisicao->setFkSwCgm($this);
            $this->fkAlmoxarifadoRequisicoes->add($fkAlmoxarifadoRequisicao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoRequisicao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao
     */
    public function removeFkAlmoxarifadoRequisicoes(\Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao)
    {
        $this->fkAlmoxarifadoRequisicoes->removeElement($fkAlmoxarifadoRequisicao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoRequisicoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\Requisicao
     */
    public function getFkAlmoxarifadoRequisicoes()
    {
        return $this->fkAlmoxarifadoRequisicoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoCalculoCgm
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CalculoCgm $fkArrecadacaoCalculoCgm
     * @return SwCgm
     */
    public function addFkArrecadacaoCalculoCgns(\Urbem\CoreBundle\Entity\Arrecadacao\CalculoCgm $fkArrecadacaoCalculoCgm)
    {
        if (false === $this->fkArrecadacaoCalculoCgns->contains($fkArrecadacaoCalculoCgm)) {
            $fkArrecadacaoCalculoCgm->setFkSwCgm($this);
            $this->fkArrecadacaoCalculoCgns->add($fkArrecadacaoCalculoCgm);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCalculoCgm
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CalculoCgm $fkArrecadacaoCalculoCgm
     */
    public function removeFkArrecadacaoCalculoCgns(\Urbem\CoreBundle\Entity\Arrecadacao\CalculoCgm $fkArrecadacaoCalculoCgm)
    {
        $this->fkArrecadacaoCalculoCgns->removeElement($fkArrecadacaoCalculoCgm);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCalculoCgns
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CalculoCgm
     */
    public function getFkArrecadacaoCalculoCgns()
    {
        return $this->fkArrecadacaoCalculoCgns;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasFornecedorSocio
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorSocio $fkComprasFornecedorSocio
     * @return SwCgm
     */
    public function addFkComprasFornecedorSocios(\Urbem\CoreBundle\Entity\Compras\FornecedorSocio $fkComprasFornecedorSocio)
    {
        if (false === $this->fkComprasFornecedorSocios->contains($fkComprasFornecedorSocio)) {
            $fkComprasFornecedorSocio->setFkSwCgm($this);
            $this->fkComprasFornecedorSocios->add($fkComprasFornecedorSocio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasFornecedorSocio
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorSocio $fkComprasFornecedorSocio
     */
    public function removeFkComprasFornecedorSocios(\Urbem\CoreBundle\Entity\Compras\FornecedorSocio $fkComprasFornecedorSocio)
    {
        $this->fkComprasFornecedorSocios->removeElement($fkComprasFornecedorSocio);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasFornecedorSocios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorSocio
     */
    public function getFkComprasFornecedorSocios()
    {
        return $this->fkComprasFornecedorSocios;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaDiversa $fkEconomicoLicencaDiversa
     * @return SwCgm
     */
    public function addFkEconomicoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\LicencaDiversa $fkEconomicoLicencaDiversa)
    {
        if (false === $this->fkEconomicoLicencaDiversas->contains($fkEconomicoLicencaDiversa)) {
            $fkEconomicoLicencaDiversa->setFkSwCgm($this);
            $this->fkEconomicoLicencaDiversas->add($fkEconomicoLicencaDiversa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaDiversa $fkEconomicoLicencaDiversa
     */
    public function removeFkEconomicoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\LicencaDiversa $fkEconomicoLicencaDiversa)
    {
        $this->fkEconomicoLicencaDiversas->removeElement($fkEconomicoLicencaDiversa);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoLicencaDiversas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaDiversa
     */
    public function getFkEconomicoLicencaDiversas()
    {
        return $this->fkEconomicoLicencaDiversas;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaVeiculoTerceirosResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoTerceirosResponsavel $fkFrotaVeiculoTerceirosResponsavel
     * @return SwCgm
     */
    public function addFkFrotaVeiculoTerceirosResponsaveis(\Urbem\CoreBundle\Entity\Frota\VeiculoTerceirosResponsavel $fkFrotaVeiculoTerceirosResponsavel)
    {
        if (false === $this->fkFrotaVeiculoTerceirosResponsaveis->contains($fkFrotaVeiculoTerceirosResponsavel)) {
            $fkFrotaVeiculoTerceirosResponsavel->setFkSwCgm($this);
            $this->fkFrotaVeiculoTerceirosResponsaveis->add($fkFrotaVeiculoTerceirosResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculoTerceirosResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoTerceirosResponsavel $fkFrotaVeiculoTerceirosResponsavel
     */
    public function removeFkFrotaVeiculoTerceirosResponsaveis(\Urbem\CoreBundle\Entity\Frota\VeiculoTerceirosResponsavel $fkFrotaVeiculoTerceirosResponsavel)
    {
        $this->fkFrotaVeiculoTerceirosResponsaveis->removeElement($fkFrotaVeiculoTerceirosResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculoTerceirosResponsaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoTerceirosResponsavel
     */
    public function getFkFrotaVeiculoTerceirosResponsaveis()
    {
        return $this->fkFrotaVeiculoTerceirosResponsaveis;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoParticipanteCertificacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao $fkLicitacaoParticipanteCertificacao
     * @return SwCgm
     */
    public function addFkLicitacaoParticipanteCertificacoes(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao $fkLicitacaoParticipanteCertificacao)
    {
        if (false === $this->fkLicitacaoParticipanteCertificacoes->contains($fkLicitacaoParticipanteCertificacao)) {
            $fkLicitacaoParticipanteCertificacao->setFkSwCgm($this);
            $this->fkLicitacaoParticipanteCertificacoes->add($fkLicitacaoParticipanteCertificacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoParticipanteCertificacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao $fkLicitacaoParticipanteCertificacao
     */
    public function removeFkLicitacaoParticipanteCertificacoes(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao $fkLicitacaoParticipanteCertificacao)
    {
        $this->fkLicitacaoParticipanteCertificacoes->removeElement($fkLicitacaoParticipanteCertificacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoParticipanteCertificacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao
     */
    public function getFkLicitacaoParticipanteCertificacoes()
    {
        return $this->fkLicitacaoParticipanteCertificacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ManadCredor
     *
     * @param \Urbem\CoreBundle\Entity\Manad\Credor $fkManadCredor
     * @return SwCgm
     */
    public function addFkManadCredores(\Urbem\CoreBundle\Entity\Manad\Credor $fkManadCredor)
    {
        if (false === $this->fkManadCredores->contains($fkManadCredor)) {
            $fkManadCredor->setFkSwCgm($this);
            $this->fkManadCredores->add($fkManadCredor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ManadCredor
     *
     * @param \Urbem\CoreBundle\Entity\Manad\Credor $fkManadCredor
     */
    public function removeFkManadCredores(\Urbem\CoreBundle\Entity\Manad\Credor $fkManadCredor)
    {
        $this->fkManadCredores->removeElement($fkManadCredor);
    }

    /**
     * OneToMany (owning side)
     * Get fkManadCredores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\Credor
     */
    public function getFkManadCredores()
    {
        return $this->fkManadCredores;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem
     * @return SwCgm
     */
    public function addFkPatrimonioBens(\Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem)
    {
        if (false === $this->fkPatrimonioBens->contains($fkPatrimonioBem)) {
            $fkPatrimonioBem->setFkSwCgm($this);
            $this->fkPatrimonioBens->add($fkPatrimonioBem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem
     */
    public function removeFkPatrimonioBens(\Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem)
    {
        $this->fkPatrimonioBens->removeElement($fkPatrimonioBem);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioBens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    public function getFkPatrimonioBens()
    {
        return $this->fkPatrimonioBens;
    }

    /**
     * OneToMany (owning side)
     * Add SwProcessoConfidencial
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoConfidencial $fkSwProcessoConfidencial
     * @return SwCgm
     */
    public function addFkSwProcessoConfidenciais(\Urbem\CoreBundle\Entity\SwProcessoConfidencial $fkSwProcessoConfidencial)
    {
        if (false === $this->fkSwProcessoConfidenciais->contains($fkSwProcessoConfidencial)) {
            $fkSwProcessoConfidencial->setFkSwCgm($this);
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
     * Add TcemgContratoFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor $fkTcemgContratoFornecedor
     * @return SwCgm
     */
    public function addFkTcemgContratoFornecedores(\Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor $fkTcemgContratoFornecedor)
    {
        if (false === $this->fkTcemgContratoFornecedores->contains($fkTcemgContratoFornecedor)) {
            $fkTcemgContratoFornecedor->setFkSwCgm($this);
            $this->fkTcemgContratoFornecedores->add($fkTcemgContratoFornecedor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContratoFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor $fkTcemgContratoFornecedor
     */
    public function removeFkTcemgContratoFornecedores(\Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor $fkTcemgContratoFornecedor)
    {
        $this->fkTcemgContratoFornecedores->removeElement($fkTcemgContratoFornecedor);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratoFornecedores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor
     */
    public function getFkTcemgContratoFornecedores()
    {
        return $this->fkTcemgContratoFornecedores;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeDividaFundadaOutraOperacaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOutraOperacaoCredito $fkTcepeDividaFundadaOutraOperacaoCredito
     * @return SwCgm
     */
    public function addFkTcepeDividaFundadaOutraOperacaoCreditos(\Urbem\CoreBundle\Entity\Tcepe\DividaFundadaOutraOperacaoCredito $fkTcepeDividaFundadaOutraOperacaoCredito)
    {
        if (false === $this->fkTcepeDividaFundadaOutraOperacaoCreditos->contains($fkTcepeDividaFundadaOutraOperacaoCredito)) {
            $fkTcepeDividaFundadaOutraOperacaoCredito->setFkSwCgm($this);
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
     * Add TcernObraAcompanhamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento $fkTcernObraAcompanhamento
     * @return SwCgm
     */
    public function addFkTcernObraAcompanhamentos(\Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento $fkTcernObraAcompanhamento)
    {
        if (false === $this->fkTcernObraAcompanhamentos->contains($fkTcernObraAcompanhamento)) {
            $fkTcernObraAcompanhamento->setFkSwCgm($this);
            $this->fkTcernObraAcompanhamentos->add($fkTcernObraAcompanhamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernObraAcompanhamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento $fkTcernObraAcompanhamento
     */
    public function removeFkTcernObraAcompanhamentos(\Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento $fkTcernObraAcompanhamento)
    {
        $this->fkTcernObraAcompanhamentos->removeElement($fkTcernObraAcompanhamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernObraAcompanhamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento
     */
    public function getFkTcernObraAcompanhamentos()
    {
        return $this->fkTcernObraAcompanhamentos;
    }

    /**
     * OneToMany (owning side)
     * Add TcernUnidadeOrcamentariaResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel $fkTcernUnidadeOrcamentariaResponsavel
     * @return SwCgm
     */
    public function addFkTcernUnidadeOrcamentariaResponsaveis(\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel $fkTcernUnidadeOrcamentariaResponsavel)
    {
        if (false === $this->fkTcernUnidadeOrcamentariaResponsaveis->contains($fkTcernUnidadeOrcamentariaResponsavel)) {
            $fkTcernUnidadeOrcamentariaResponsavel->setFkSwCgm($this);
            $this->fkTcernUnidadeOrcamentariaResponsaveis->add($fkTcernUnidadeOrcamentariaResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernUnidadeOrcamentariaResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel $fkTcernUnidadeOrcamentariaResponsavel
     */
    public function removeFkTcernUnidadeOrcamentariaResponsaveis(\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel $fkTcernUnidadeOrcamentariaResponsavel)
    {
        $this->fkTcernUnidadeOrcamentariaResponsaveis->removeElement($fkTcernUnidadeOrcamentariaResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernUnidadeOrcamentariaResponsaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentariaResponsavel
     */
    public function getFkTcernUnidadeOrcamentariaResponsaveis()
    {
        return $this->fkTcernUnidadeOrcamentariaResponsaveis;
    }

    /**
     * OneToMany (owning side)
     * Add TcetoCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\Credor $fkTcetoCredor
     * @return SwCgm
     */
    public function addFkTcetoCredores(\Urbem\CoreBundle\Entity\Tceto\Credor $fkTcetoCredor)
    {
        if (false === $this->fkTcetoCredores->contains($fkTcetoCredor)) {
            $fkTcetoCredor->setFkSwCgm($this);
            $this->fkTcetoCredores->add($fkTcetoCredor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcetoCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\Credor $fkTcetoCredor
     */
    public function removeFkTcetoCredores(\Urbem\CoreBundle\Entity\Tceto\Credor $fkTcetoCredor)
    {
        $this->fkTcetoCredores->removeElement($fkTcetoCredor);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcetoCredores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\Credor
     */
    public function getFkTcetoCredores()
    {
        return $this->fkTcetoCredores;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransferenciaCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaCredor $fkTesourariaTransferenciaCredor
     * @return SwCgm
     */
    public function addFkTesourariaTransferenciaCredores(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaCredor $fkTesourariaTransferenciaCredor)
    {
        if (false === $this->fkTesourariaTransferenciaCredores->contains($fkTesourariaTransferenciaCredor)) {
            $fkTesourariaTransferenciaCredor->setFkSwCgm($this);
            $this->fkTesourariaTransferenciaCredores->add($fkTesourariaTransferenciaCredor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransferenciaCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaCredor $fkTesourariaTransferenciaCredor
     */
    public function removeFkTesourariaTransferenciaCredores(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaCredor $fkTesourariaTransferenciaCredor)
    {
        $this->fkTesourariaTransferenciaCredores->removeElement($fkTesourariaTransferenciaCredor);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransferenciaCredores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaCredor
     */
    public function getFkTesourariaTransferenciaCredores()
    {
        return $this->fkTesourariaTransferenciaCredores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwMunicipio
     *
     * @param \Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio
     * @return SwCgm
     */
    public function setFkSwMunicipio(\Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio)
    {
        $this->codMunicipio = $fkSwMunicipio->getCodMunicipio();
        $this->codUf = $fkSwMunicipio->getCodUf();
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

    /**
     * ManyToOne (inverse side)
     * Set fkSwPais
     *
     * @param \Urbem\CoreBundle\Entity\SwPais $fkSwPais
     * @return SwCgm
     */
    public function setFkSwPais(\Urbem\CoreBundle\Entity\SwPais $fkSwPais)
    {
        $this->codPais = $fkSwPais->getCodPais();
        $this->fkSwPais = $fkSwPais;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwPais
     *
     * @return \Urbem\CoreBundle\Entity\SwPais
     */
    public function getFkSwPais()
    {
        return $this->fkSwPais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwMunicipio1
     *
     * @param \Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio1
     * @return SwCgm
     */
    public function setFkSwMunicipio1(\Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio1)
    {
        $this->codMunicipioCorresp = $fkSwMunicipio1->getCodMunicipio();
        $this->codUfCorresp = $fkSwMunicipio1->getCodUf();
        $this->fkSwMunicipio1 = $fkSwMunicipio1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwMunicipio1
     *
     * @return \Urbem\CoreBundle\Entity\SwMunicipio
     */
    public function getFkSwMunicipio1()
    {
        return $this->fkSwMunicipio1;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwPais1
     *
     * @param \Urbem\CoreBundle\Entity\SwPais $fkSwPais1
     * @return SwCgm
     */
    public function setFkSwPais1(\Urbem\CoreBundle\Entity\SwPais $fkSwPais1)
    {
        $this->codPaisCorresp = $fkSwPais1->getCodPais();
        $this->fkSwPais1 = $fkSwPais1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwPais1
     *
     * @return \Urbem\CoreBundle\Entity\SwPais
     */
    public function getFkSwPais1()
    {
        return $this->fkSwPais1;
    }

    /**
     * OneToOne (inverse side)
     * Set AlmoxarifadoAlmoxarifado
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado
     * @return SwCgm
     */
    public function setFkAlmoxarifadoAlmoxarifado(\Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado)
    {
        $fkAlmoxarifadoAlmoxarifado->setFkSwCgm($this);
        $this->fkAlmoxarifadoAlmoxarifado = $fkAlmoxarifadoAlmoxarifado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkAlmoxarifadoAlmoxarifado
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado
     */
    public function getFkAlmoxarifadoAlmoxarifado()
    {
        return $this->fkAlmoxarifadoAlmoxarifado;
    }

    /**
     * OneToOne (inverse side)
     * Set ComprasFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor
     * @return SwCgm
     */
    public function setFkComprasFornecedor(\Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor)
    {
        $fkComprasFornecedor->setFkSwCgm($this);
        $this->fkComprasFornecedor = $fkComprasFornecedor;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkComprasFornecedor
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    public function getFkComprasFornecedor()
    {
        return $this->fkComprasFornecedor;
    }

    /**
     * OneToOne (inverse side)
     * Set ComprasSolicitante
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Solicitante $fkComprasSolicitante
     * @return SwCgm
     */
    public function setFkComprasSolicitante(\Urbem\CoreBundle\Entity\Compras\Solicitante $fkComprasSolicitante)
    {
        $fkComprasSolicitante->setFkSwCgm($this);
        $this->fkComprasSolicitante = $fkComprasSolicitante;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkComprasSolicitante
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Solicitante
     */
    public function getFkComprasSolicitante()
    {
        return $this->fkComprasSolicitante;
    }

    /**
     * OneToOne (inverse side)
     * Set FiscalizacaoGrafica
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Grafica $fkFiscalizacaoGrafica
     * @return SwCgm
     */
    public function setFkFiscalizacaoGrafica(\Urbem\CoreBundle\Entity\Fiscalizacao\Grafica $fkFiscalizacaoGrafica)
    {
        $fkFiscalizacaoGrafica->setFkSwCgm($this);
        $this->fkFiscalizacaoGrafica = $fkFiscalizacaoGrafica;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFiscalizacaoGrafica
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\Grafica
     */
    public function getFkFiscalizacaoGrafica()
    {
        return $this->fkFiscalizacaoGrafica;
    }

    /**
     * OneToOne (inverse side)
     * Set FrotaEscola
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Escola $fkFrotaEscola
     * @return SwCgm
     */
    public function setFkFrotaEscola(\Urbem\CoreBundle\Entity\Frota\Escola $fkFrotaEscola)
    {
        $fkFrotaEscola->setFkSwCgm($this);
        $this->fkFrotaEscola = $fkFrotaEscola;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFrotaEscola
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Escola
     */
    public function getFkFrotaEscola()
    {
        return $this->fkFrotaEscola;
    }

    /**
     * OneToOne (inverse side)
     * Set FrotaMotorista
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Motorista $fkFrotaMotorista
     * @return SwCgm
     */
    public function setFkFrotaMotorista(\Urbem\CoreBundle\Entity\Frota\Motorista $fkFrotaMotorista)
    {
        $fkFrotaMotorista->setFkSwCgm($this);
        $this->fkFrotaMotorista = $fkFrotaMotorista;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFrotaMotorista
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Motorista
     */
    public function getFkFrotaMotorista()
    {
        return $this->fkFrotaMotorista;
    }

    /**
     * OneToOne (inverse side)
     * Set LicitacaoVeiculosPublicidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade
     * @return SwCgm
     */
    public function setFkLicitacaoVeiculosPublicidade(\Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade)
    {
        $fkLicitacaoVeiculosPublicidade->setFkSwCgm($this);
        $this->fkLicitacaoVeiculosPublicidade = $fkLicitacaoVeiculosPublicidade;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoVeiculosPublicidade
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    public function getFkLicitacaoVeiculosPublicidade()
    {
        return $this->fkLicitacaoVeiculosPublicidade;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgArquivoPessoa
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoPessoa $fkTcemgArquivoPessoa
     * @return SwCgm
     */
    public function setFkTcemgArquivoPessoa(\Urbem\CoreBundle\Entity\Tcemg\ArquivoPessoa $fkTcemgArquivoPessoa)
    {
        $fkTcemgArquivoPessoa->setFkSwCgm($this);
        $this->fkTcemgArquivoPessoa = $fkTcemgArquivoPessoa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgArquivoPessoa
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ArquivoPessoa
     */
    public function getFkTcemgArquivoPessoa()
    {
        return $this->fkTcemgArquivoPessoa;
    }

    /**
     * OneToOne (inverse side)
     * Set TcepbMatriculas
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\Matriculas $fkTcepbMatriculas
     * @return SwCgm
     */
    public function setFkTcepbMatriculas(\Urbem\CoreBundle\Entity\Tcepb\Matriculas $fkTcepbMatriculas)
    {
        $fkTcepbMatriculas->setFkSwCgm($this);
        $this->fkTcepbMatriculas = $fkTcepbMatriculas;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcepbMatriculas
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\Matriculas
     */
    public function getFkTcepbMatriculas()
    {
        return $this->fkTcepbMatriculas;
    }

    /**
     * OneToOne (inverse side)
     * Set TcepbServidores
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\Servidores $fkTcepbServidores
     * @return SwCgm
     */
    public function setFkTcepbServidores(\Urbem\CoreBundle\Entity\Tcepb\Servidores $fkTcepbServidores)
    {
        $fkTcepbServidores->setFkSwCgm($this);
        $this->fkTcepbServidores = $fkTcepbServidores;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcepbServidores
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\Servidores
     */
    public function getFkTcepbServidores()
    {
        return $this->fkTcepbServidores;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmbaSubvencaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho $fkTcmbaSubvencaoEmpenho
     * @return SwCgm
     */
    public function setFkTcmbaSubvencaoEmpenho(\Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho $fkTcmbaSubvencaoEmpenho)
    {
        $fkTcmbaSubvencaoEmpenho->setFkSwCgm($this);
        $this->fkTcmbaSubvencaoEmpenho = $fkTcmbaSubvencaoEmpenho;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmbaSubvencaoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho
     */
    public function getFkTcmbaSubvencaoEmpenho()
    {
        return $this->fkTcmbaSubvencaoEmpenho;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelTecnico $fkTcmgoResponsavelTecnico
     * @return SwCgm
     */
    public function setFkTcmgoResponsavelTecnico(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelTecnico $fkTcmgoResponsavelTecnico)
    {
        $fkTcmgoResponsavelTecnico->setFkSwCgm($this);
        $this->fkTcmgoResponsavelTecnico = $fkTcmgoResponsavelTecnico;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoResponsavelTecnico
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelTecnico
     */
    public function getFkTcmgoResponsavelTecnico()
    {
        return $this->fkTcmgoResponsavelTecnico;
    }

    /**
     * OneToOne (inverse side)
     * Set SwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return SwCgm
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $fkSwCgmPessoaFisica->setFkSwCgm($this);
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }

    /**
     * OneToOne (inverse side)
     * Set SwCgmPessoaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica
     * @return SwCgm
     */
    public function setFkSwCgmPessoaJuridica(\Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica)
    {
        $fkSwCgmPessoaJuridica->setFkSwCgm($this);
        $this->fkSwCgmPessoaJuridica = $fkSwCgmPessoaJuridica;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwCgmPessoaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    public function getFkSwCgmPessoaJuridica()
    {
        return $this->fkSwCgmPessoaJuridica;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgArquivoFolhaPessoa
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoFolhaPessoa $fkTcemgArquivoFolhaPessoa
     * @return SwCgm
     */
    public function setFkTcemgArquivoFolhaPessoa(\Urbem\CoreBundle\Entity\Tcemg\ArquivoFolhaPessoa $fkTcemgArquivoFolhaPessoa)
    {
        $fkTcemgArquivoFolhaPessoa->setFkSwCgm($this);
        $this->fkTcemgArquivoFolhaPessoa = $fkTcemgArquivoFolhaPessoa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgArquivoFolhaPessoa
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ArquivoFolhaPessoa
     */
    public function getFkTcemgArquivoFolhaPessoa()
    {
        return $this->fkTcemgArquivoFolhaPessoa;
    }

    /**
     * OneToOne (inverse side)
     * Set TcepeResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ResponsavelTecnico $fkTcepeResponsavelTecnico
     * @return SwCgm
     */
    public function setFkTcepeResponsavelTecnico(\Urbem\CoreBundle\Entity\Tcepe\ResponsavelTecnico $fkTcepeResponsavelTecnico)
    {
        $fkTcepeResponsavelTecnico->setFkSwCgm($this);
        $this->fkTcepeResponsavelTecnico = $fkTcepeResponsavelTecnico;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcepeResponsavelTecnico
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\ResponsavelTecnico
     */
    public function getFkTcepeResponsavelTecnico()
    {
        return $this->fkTcepeResponsavelTecnico;
    }

    /**
     * OneToOne (inverse side)
     * Set AdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return SwCgm
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $fkAdministracaoUsuario->setFkSwCgm($this);
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * @return string
     */
    public function getLogradouroCompleto()
    {
        return sprintf('%s %s, %s %s - %s', $this->tipoLogradouro, $this->logradouro, $this->getFkSwMunicipio()->getNomMunicipio(), $this->numero, $this->cep);
    }

    /**
     * @return string
     */
    public function getTipoLogradouroAndNumero()
    {
        return sprintf('%s %s  N.º %s', $this->tipoLogradouro, $this->logradouro, $this->numero);
    }

    /**
     * @return string
     */
    public function getTipoLogradouroAndNumeroCorresp()
    {
        return sprintf('%s %s  N.º %s', $this->tipoLogradouroCorresp, $this->logradouroCorresp, $this->numeroCorresp);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->numcgm, strtoupper($this->nomCgm));
    }
}
