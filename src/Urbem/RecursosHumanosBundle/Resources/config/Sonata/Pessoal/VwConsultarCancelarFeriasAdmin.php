<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\ChainOfResponsability\Folhapagamento\ValidarFerias\StopChain;
use Urbem\CoreBundle\ChainOfResponsability\Folhapagamento\ValidarFerias\ValidarFolhaComplementar;
use Urbem\CoreBundle\ChainOfResponsability\Folhapagamento\ValidarFerias\ValidarFolhaSalario;
use Urbem\CoreBundle\Entity\Folhapagamento\FolhaSituacao;
use Urbem\CoreBundle\Entity\Folhapagamento\TipoFolha;
use Urbem\CoreBundle\Entity\Pessoal\Ferias;
use Urbem\CoreBundle\Entity\Pessoal\LancamentoFerias;
use Urbem\CoreBundle\Entity\Pessoal\VwConsultarCancelarFerias;
use Urbem\CoreBundle\Model\Folhapagamento\ComplementarSituacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\DeducaoDependenteModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoBaseModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoCalculadoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoComplementarCalculadoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoFeriasCalculadoModel;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaSituacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoFeriasModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\UltimoRegistroEventoComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\UltimoRegistroEventoFeriasModel;
use Urbem\CoreBundle\Model\Folhapagamento\UltimoRegistroEventoModel;
use Urbem\CoreBundle\Model\Pessoal\Assentamento\AssentamentoAssentamentoModel;
use Urbem\CoreBundle\Model\Pessoal\Assentamento\AssentamentoGeradoContratoServidorModel;
use Urbem\CoreBundle\Model\Pessoal\Assentamento\AssentamentoGeradoModel;
use Urbem\CoreBundle\Model\Pessoal\AssentamentoGeradoExcluidoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;
use Urbem\CoreBundle\Model\Pessoal\FeriasModel;
use Urbem\CoreBundle\Model\Pessoal\LancamentoFeriasModel;
use Urbem\CoreBundle\Model\Pessoal\LoteFeriasLoteModel;
use Urbem\CoreBundle\Model\Pessoal\LoteFeriasModel;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin;
use \Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;

class VwConsultarCancelarFeriasAdmin extends GeneralFilterAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_ferias_consultar';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/ferias/consultar';
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureGridFilters($datagridMapper);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codFerias')
            ->add('numcgm')
            ->add('nomCgm')
            ->add('registro', null, [
                'label' => 'matricula'
            ])
            ->add('codContrato')
            ->add('descLocal')
            ->add('descOrgao')
            ->add('orgao')
            ->add('dtPosse')
            ->add('descFuncao')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $em = $this->getEntityManager();

        /** @var VwConsultarCancelarFerias $dadosFerias */
        $dadosFerias = $this->getSubject();

        $cgm = $dadosFerias->getNumcgm().' - '.$dadosFerias->getNomCgm();
        $fieldOptions['cgm']= [
            'label' => 'cgm',
            'mapped' => false,
            'template' => 'RecursosHumanosBundle::Pessoal/Ferias/show_custom_value.html.twig',
            'data' => $cgm
        ];

        $lotacao = $dadosFerias->getDescOrgao().' - '.$dadosFerias->getOrgao();
        $fieldOptions['lotacao'] = [
            'label' => 'lotacao',
            'mapped' => false,
            'data' => $lotacao
        ];

        $regime = $dadosFerias->getDescRegimeFuncao().' - '.$dadosFerias->getDescFuncao();
        $fieldOptions['regime'] = [
            'label' => 'label.ferias.regimeFuncao',
            'mapped' => false,
            'data' => $regime,
            'template' => 'RecursosHumanosBundle::Pessoal/Ferias/show_custom_value.html.twig',
        ];

        $showMapper
            ->with('label.ferias.dadosMatricula')
            ->add('registro', null, [
                'label' => 'matricula'
            ])
            ->add('cgm', null, $fieldOptions['cgm'])
            ->add('lotacao', null, $fieldOptions['lotacao'])
            ->add('regime', null, $fieldOptions['regime'])
            ->end();

        $showMapper
            ->with('label.ferias.periodoAquisitivo')
            ->add('dtInicialAquisitivoFormatado', null, ['label' => 'label.ferias.dtInicial'])
            ->add('dtFinalAquisitivoFormatado', null, ['label' => 'label.ferias.dtFinal'])
            ->end();

        $feriasModel = new FeriasModel($em);

        $faltas = $feriasModel->recuperaFaltasPorCodFerias($dadosFerias->getCodFerias());
        $fieldOptions['faltas'] = [
            'label' => 'label.ferias.faltas',
            'data' => $faltas,
            'template' => 'RecursosHumanosBundle::Pessoal/Ferias/show_custom_value.html.twig'
        ];

        $formaPagamento = $feriasModel->recuperaForma($dadosFerias->getCodFerias());
        $dias = $feriasModel->recuperaDias($dadosFerias->getCodFerias());
        $abono = $feriasModel->recuperaAbono($dadosFerias->getCodFerias());

        $formasPagamento = $formaPagamento.' - '.$dias.' dia(s) de férias / '.$abono.' dia(s) de abono';
        $fieldOptions['formasPagamento'] = [
            'label' => 'label.ferias.codForma',
            'data' => $formasPagamento,
            'template' => 'RecursosHumanosBundle::Pessoal/Ferias/show_custom_value.html.twig',
        ];

        $fieldOptions['diasFerias'] = [
            'label' => 'label.ferias.diasFerias',
            'data' => $dias,
            'template' => 'RecursosHumanosBundle::Pessoal/Ferias/show_custom_value.html.twig',
        ];

        $fieldOptions['abono'] = [
            'label' => 'label.ferias.diasAbono',
            'data' => $abono,
            'template' => 'RecursosHumanosBundle::Pessoal/Ferias/show_custom_value.html.twig',
        ];

        $dtInicioFerias = $feriasModel->recuperaDtInicioFerias($dadosFerias->getCodFerias());
        $fieldOptions['dtInicioFerias'] = [
            'label' => 'label.ferias.dtInicialFerias',
            'data' => $dtInicioFerias,
            'template' => 'RecursosHumanosBundle::Pessoal/Ferias/show_custom_value.html.twig',
        ];

        $dtFimFerias = $feriasModel->recuperaDtFimFerias($dadosFerias->getCodFerias());
        $fieldOptions['dtFimFerias'] = [
            'label' => 'label.ferias.dtTerminoFerias',
            'data' => $dtFimFerias,
            'template' => 'RecursosHumanosBundle::Pessoal/Ferias/show_custom_value.html.twig',
        ];

        $dtRetorno = $feriasModel->recuperaDtRetorno($dadosFerias->getCodFerias());
        $fieldOptions['retorno'] = [
            'label' => 'label.ferias.dtRetornoFerias',
            'data' => $dtRetorno,
            'template' => 'RecursosHumanosBundle::Pessoal/Ferias/show_custom_value.html.twig',
        ];

        $folhaPago = $feriasModel->recuperaTipoFolha($dadosFerias->getCodFerias());
        $fieldOptions['folhaPago'] = [
            'label' => 'label.ferias.codTipo',
            'data' => $folhaPago,
            'template' => 'RecursosHumanosBundle::Pessoal/Ferias/show_custom_value.html.twig',
        ];

        $pagar13 = $feriasModel->recuperaPagar13($dadosFerias->getCodFerias());
        $fieldOptions['pagar13'] = [
            'label' => 'label.ferias.pagar13',
            'data' => $pagar13 ? 'Sim' : 'Não',
            'template' => 'RecursosHumanosBundle::Pessoal/Ferias/show_custom_value.html.twig',
        ];

        $dadosEvento = $this->recuperaEventos();
        $fieldOptions['eventos'] = [
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.dadosEvento',
            'data' => $dadosEvento,
            'template' => 'RecursosHumanosBundle::Pessoal/Ferias/eventos_custom_value.html.twig',
        ];

        $showMapper
            ->with('label.ferias.pagamento')
            ->add('faltas', 'text', $fieldOptions['faltas'])
            ->add('formasPagamento', null, $fieldOptions['formasPagamento'])
            ->add('diasFerias', null, $fieldOptions['diasFerias'])
            ->add('abono', null, $fieldOptions['abono'])
            ->add('dtInicioFerias', null, $fieldOptions['dtInicioFerias'])
            ->add('dtFimFerias', null, $fieldOptions['dtFimFerias'])
            ->add('dtRetorno', null, $fieldOptions['retorno'])
            ->add('competencia', null, ['label' => 'label.ferias.competencia'])
            ->add('folhaPago', null, $fieldOptions['folhaPago'])
            ->add('pagar13', null, $fieldOptions['pagar13'])
            ->add('eventos', null, $fieldOptions['eventos'])
            ->end();
    }

    public function recuperaEventos()
    {
        $em = $this->getEntityManager();
        $eventos = [];

        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($em);
        $dtCompetencia = $this->getSubject()->getCompetencia();
        $periodoMovimentacao = $periodoMovimentacaoModel->recuperaPeriodoMovimentacao(null, $dtCompetencia);

        $contratoModel = new ContratoModel($em);
        $codContrato = $contratoModel->recuperaCodContratoPorRegistro($this->getSubject()->getRegistro());

        $registroEventoFeriasModel = new RegistroEventoFeriasModel($em);
        $eventos = $registroEventoFeriasModel->montaRecuperaRelacionamento($codContrato, $periodoMovimentacao['cod_periodo_movimentacao']);

        $eventoBaseModel = new EventoBaseModel($em);
        $baseDesdobramento = $eventoBaseModel->recuperaEventoBaseDesdobramento($eventos, $codContrato, $periodoMovimentacao['cod_periodo_movimentacao']);

        foreach ($baseDesdobramento as $base) {
            $base['descricao']  = trim($base['descricao']);
            $base['desdobramento_texto'] = trim($base['desdobramento_texto']);
            $base['valor']      = '0,00';
            $base['quantidade'] = '0,00';
            $base['automatico'] = 'Sim';
        }

        return ['eventos' => $eventos, 'baseDesdobramento' => $baseDesdobramento];
    }

    /**
     * @param VwConsultarCancelarFerias $ferias
     */
    public function preRemove($ferias)
    {
        $registro = $ferias->getRegistro();
        $mesCompetencia = $ferias->getMesCompetencia();
        $anoCompetencia = $ferias->getAnoCompetencia();

        $em = $this->getEntityManager();
        $lote = $this->getRequest()->get('lote');
        $codFerias = $ferias->getCodFerias();

        if ($lote) {
            $filtro = " AND lote_ferias_lote.cod_lote = ".$lote->getData();
        } else {
            $loteFeriasloteModel = new LoteFeriasLoteModel($em);
            $loteFeriasLote = $loteFeriasloteModel->recuperaLotePorCodFerias($codFerias);
            $filtro = " AND lancamento_ferias.cod_ferias = ".$codFerias;
        }

        $lancamentoFeriasModel = new LancamentoFeriasModel($em);
        /** @var LancamentoFerias $lancamentoFerias */
        $lancamentoFerias = $lancamentoFeriasModel->recuperaLancamentoFerias($codFerias, $filtro);

        $feriasModel = new FeriasModel($em);
        /** @var Ferias $ferias */
        $ferias = $feriasModel->recuperaFeriasPorCodFerias($codFerias);

        $codContrato = $lancamentoFerias->cod_contrato;

        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($em);
        $dtCompetencia = $ferias->getDtFinalAquisitivo()->format('m/Y');
        $periodoMovimentacao = $periodoMovimentacaoModel->recuperaPeriodoMovimentacao(null, $dtCompetencia);

        $validaFolhaSalario = new ValidarFolhaSalario();
        $validaFolhaComplementar = new ValidarFolhaComplementar();
        $stopchain = new StopChain();

        $validaFolhaSalario->setProximo($validaFolhaComplementar);
        $validaFolhaComplementar->setProximo($stopchain);

        $codPeriodoMovimentacao = $periodoMovimentacao['cod_periodo_movimentacao'];
        $message = $validaFolhaSalario->validar($lancamentoFerias->cod_tipo, $codPeriodoMovimentacao, $em);

        if ($message) {
            $container = $this->getContainer();
            $container->get('session')->getFlashBag()->clear();
            $message =  $this->trans($message, [], 'flashes');
            $container->get('session')->getFlashBag()->add('error', $message);

            $this->redirectByRoute('urbem_recursos_humanos_pessoal_ferias_consultar_list');
        }

        $assentamentoModel = new AssentamentoAssentamentoModel($em);
        $assentamentos = $assentamentoModel->recuperaRelacionamento($codContrato, $periodoMovimentacao['dt_inicial'], $periodoMovimentacao['dt_final']);

        foreach ($assentamentos as $assentamento) {
            $assentamentoGeradoContratoServidorModel = new AssentamentoGeradoContratoServidorModel($em);
            $assentamentoGeradoContratoServidor = $assentamentoGeradoContratoServidorModel->registrarEventoPorAssentamento($lancamentoFerias->cod_contrato, $assentamento->cod_assentamento);
            $codLote = $lancamentoFerias->cod_lote;
            if ($codLote) {
                $loteFeriasModel = new LoteFeriasModel($em);
                $lote = $loteFeriasModel->recuperaLoteFeriasPorCodigoLote($codLote);
                $observacao = "Férias do lote ".$lote->getNome();
            } else {
                $observacao = "Férias de ".$ferias->getDtInicialAquisitivo()->format('d/m/Y');
                $observacao .= " a ".$ferias->getDtFinalAquisitivo()->format('d/m/Y');
                $observacao .= ",pagas em ".$lancamentoFerias->mes_competencia;
                $observacao .= "/".$lancamentoFerias->ano_competencia;
            }

            $filtro  = " AND cod_contrato = ".$ferias->getCodContrato();
            $filtro .= " AND assentamento_gerado.cod_assentamento = ".$assentamento->cod_assentamento;
            $filtro .= " AND trim(assentamento_gerado.observacao) = trim('".$observacao."')";

            $assentamentoGeradoModel = new AssentamentoGeradoModel($em);
            $dadosAssentamentoGerado = $assentamentoGeradoModel->recuperaAssentamentoGerado($filtro, "");

            if (!empty($dadosAssentamentoGerado)) {
                $assentamentoGerado = $assentamentoGeradoModel->recuperaAssentamentoGeradoPorCod(
                    $dadosAssentamentoGerado->timestamp,
                    $dadosAssentamentoGerado->cod_assentamento_gerado
                );

                /** @var AssentamentoGeradoExcluidoModel $assentamentoGeradoExcluidoModel */
                $assentamentoGeradoExcluidoModel = new AssentamentoGeradoExcluidoModel($em);
                $assentamentoGeradoExcluidoModel->excluirAssentamentoGerado($assentamentoGerado, $this->getTranslator());
            }
        }

        $arExclui = $this->validaExclusaoConcessao($codContrato, $codPeriodoMovimentacao);
        $mensagem = "Competência ".$mesCompetencia."/".$anoCompetencia;
        $mensagem .= " - Matrícula ".$registro." cancelado com sucesso";

        // Exclusão de lote

        $lancamentoFerias = $lancamentoFeriasModel->recuperaLancamentoPorCodFerias($codFerias);
        $lancamentoFeriasModel->remove($lancamentoFerias);
        $feriasModel->remove($ferias);

        $filtro = " AND contrato.cod_contrato = ".$codContrato;
        $contratoModel = new ContratoModel($em);
        $cgm = $contratoModel->recuperaCgmDoRegistro($filtro);

        $deducaoDependenteModel = new DeducaoDependenteModel($em);
        $deducaoDependente = $deducaoDependenteModel->recuperaDecucaoDependente(
            $cgm[0]['numcgm'],
            $codPeriodoMovimentacao,
            TipoFolha::TIPO_FERIAS
        );

        if ($deducaoDependente) {
            $deducaoDependenteModel->remove($deducaoDependente);
        }

        if ($arExclui['ferias']) {
            if ($periodoMovimentacao) {
                $filtro  = "   AND cod_contrato =".$codContrato;
                $filtro .= "   AND cod_periodo_movimentacao = ".$codPeriodoMovimentacao;

                $registroEventoFeriasModel = new RegistroEventoFeriasModel($em);
                $registroFerias = $registroEventoFeriasModel->montaRecuperaRelacionamento($filtro);

                foreach ($registroFerias as $registro) {
                    if ($registro["parcela"]) {
                        $filtro  = " AND registro_evento_periodo.cod_contrato =".$codContrato;
                        $filtro .= " AND registro_evento_periodo.cod_periodo_movimentacao = ".$codPeriodoMovimentacao;
                        $filtro .= " AND registro_evento.cod_evento = ".$registro["cod_evento"];
                        $filtro .= " AND registro_evento.valor = 0";
                        $filtro .= " AND registro_evento.quantidade = 0";
                        $filtro .= " AND registro_evento.proporcional is true";

                        $registroEventoModel = new RegistroEventoModel($em);
                        $registrosEventos = $registroEventoModel->recuperaRegistrosEventos($filtro);
                        foreach ($registrosEventos as $evento) {
                            $registroEventoModel->remove($evento);
                        }
                    }

                    $ultimoRegistroEventosFeriasModel = new UltimoRegistroEventoFeriasModel($em);
                    $ultimoRegistroEventosFerias = $ultimoRegistroEventosFeriasModel->getRegistrosEventoFeriasDoContrato(
                        $registro['cod_evento'],
                        $registro['timestamp'],
                        $registro['cod_registro'],
                        $registro['desdobramento']
                    );

                    if ($ultimoRegistroEventosFerias) {
                        $ultimoRegistroEventosFeriasModel->remove($ultimoRegistroEventosFerias);
                    }

                }

                if ($lancamentoFerias->getCodTipo() == TipoFolha::TIPO_SALARIO) {
                    $filtro  = "   AND cod_contrato =".$codContrato;
                    $filtro .= "   AND cod_periodo_movimentacao = ".$codPeriodoMovimentacao;
                    $filtro .= "   AND desdobramento IN ('F','A','D')";

                    $eventoCalculadoModel = new EventoCalculadoModel($em);
                    $eventosCalculados = $eventoCalculadoModel->montaRecuperaEventosCalculados($filtro);

                    foreach ($eventosCalculados as $evento) {
                        $eventoCalculadoModel->remove($evento);
                    }
                }

                if ($lancamentoFerias->getCodTipo() == TipoFolha::TIPO_COMPLEMENTAR) {
                    $filtro  = " AND complementar_situacao.cod_periodo_movimentacao = ".$codPeriodoMovimentacao;
                    $filtro .= " AND complementar_situacao.situacao = 'a'";

                    $complementarModel = new FolhaComplementarModel($em);
                    $complementarLista = $complementarModel->recuperaRelacionamento($filtro);

                    foreach ($complementarLista as $complementar) {
                        $filtro  = "   AND cod_contrato =".$codContrato;
                        $filtro .= "   AND cod_periodo_movimentacao = ".$codPeriodoMovimentacao;
                        $filtro .= "   AND cod_complementar = ".$complementar["cod_complementar"];
                        $filtro .= "   AND registro_evento_complementar.cod_configuracao = 2";

                        $ultimoRegistroEventoComplementarModel = new UltimoRegistroEventoComplementarModel($em);
                        $ultimoRegistroEventoComplementar = $ultimoRegistroEventoComplementarModel->montaRecuperaRelacionamento($filtro);
                        $filtro .= "   AND desdobramento != ''";
                        $eventoComplementarCalculadoModel = new EventoComplementarCalculadoModel($em);
                        $eventosCalculados = $eventoComplementarCalculadoModel->recuperaEventoCalculdado($filtro);
                        foreach ($eventosCalculados as $evento) {
                            $eventoComplementarCalculadoModel->remove($evento);
                        }

                        foreach ($ultimoRegistroEventoComplementar as $ultimoEvento) {
                            $eventoComplementarCalculadoModel->remove($ultimoEvento);
                        }
                    }
                }
            }
        }

        if ($arExclui['salario']) {
            $filtro  = " AND cod_contrato = ".$codContrato;
            $filtro .= " AND registro_evento_periodo.cod_periodo_movimentacao = ".$codPeriodoMovimentacao;

            $eventoCalculadoModel = new EventoCalculadoModel($em);
            $eventosSalarioCalculado = $eventoCalculadoModel->montaRecuperaEventosCalculados($filtro);

            foreach ($eventosSalarioCalculado as $evento) {
                $eventoCalculado = $eventoCalculadoModel->recuperaEventoPorCodEventoCodRegistro($evento['cod_evento'],
                                                                                                $evento['cod_registro']);

                $eventoCalculadoModel->remove($eventoCalculado);
            }
        }

        if ($arExclui['complementar']) {
            $filtro  = " AND cod_contrato = ".$codContrato;
            $filtro .= " AND cod_periodo_movimentacao = ".$codPeriodoMovimentacao;
            $filtro .= " AND cod_complementar = ".$arExclui["cod_complementar"];

            $eventosComplementarCalculado = $eventoComplementarCalculadoModel->recuperaEventoCalculdado($filtro);
            foreach ($eventosComplementarCalculado as $evento) {
                $eventosComplementarCalculado->remove($evento);
            }
        }

        $message = $this->trans('rh.pessoal.ferias.cancelar', [], 'flashes');

        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add('success', $message);

        $this->redirectByRoute('urbem_recursos_humanos_pessoal_ferias_consultar_list');
    }

    /**
     * @param [type] $codContrato
     * @param [type] $codPeriodoMovimentacao
     * @return void
     */
    private function validaExclusaoConcessao($codContrato, $codPeriodoMovimentacao)
    {
        $arExclui = [
            'ferias' => false,
            'salario' => false,
            'complementar' => false
        ];

        $em = $this->getEntityManager();

        if ($codPeriodoMovimentacao) {
            $folhaSituacaoModel = new FolhaSituacaoModel($em);
            $folhaSituacao = $folhaSituacaoModel->recuperaUltimaFolhaSituacao();

            $complementarSituacaoModel = new ComplementarSituacaoModel($em);
            $complementarSituacao = $complementarSituacaoModel->recuperaUltimaFolhaComplementarSituacao();

            $eventoFeriasCalculadoModel = new EventoFeriasCalculadoModel($em);
            $filtro  = " AND cod_contrato = ".$codContrato;
            $filtro .= " AND cod_periodo_movimentacao = ".$codPeriodoMovimentacao;
            $eventosFeriasCalculados = $eventoFeriasCalculadoModel->montaRecuperaEventosCalculados($filtro);

            if (empty($eventosFeriasCalculados)) {
                $ultimoRegistroEventoFeriasModel = new UltimoRegistroEventoFeriasModel($em);
                $ultimoRegistroEventoFerias = $ultimoRegistroEventoFeriasModel->recuperaRegistrosEventoFeriasDoContrato($filtro, null);
                $timestampFerias = $ultimoRegistroEventoFerias ? $ultimoRegistroEventoFerias->timestamp : null;
            } else {
                $timestampFerias = $eventosFeriasCalculados[0] ? $eventosFeriasCalculados[0]['timestamp'] : null;
            }

            if ($folhaSituacao->situacao == FolhaSituacao::FECHADO and (!is_object($complementarSituacao) or $complementarSituacao->situacao == FolhaSituacao::FECHADO)) {
                if ($complementarSituacao->timestamp) {
                    if ($folhaSituacao->timestamp < $timestampFerias and $complementarSituacao->timestamp < $timestampFerias) {
                        $arExclui['ferias'] = true;
                    }
                } else {
                    if ($folhaSituacao->timestamp < $timestampFerias) {
                        $arExclui['ferias'] = true;
                    }
                }
            }

            if ($folhaSituacao->situacao == FolhaSituacao::ABERTO and $complementarSituacao->situacao == FolhaSituacao::ABERTO) {
                $filtro  = " AND cod_contrato = ".$codContrato;
                $filtro .= " AND registro_evento_periodo.cod_periodo_movimentacao = ".$codPeriodoMovimentacao;

                $eventoCalculadoModel = new EventoCalculadoModel($em);
                $eventosSalarioCalculado = $eventoCalculadoModel->montaRecuperaEventosCalculados($filtro);

                if (isset($eventosSalarioCalculado[0]['timestamp'])) {
                    $timestampSalario = $eventosSalarioCalculado[0]['timestamp'];
                } else {
                    $ultimoRegistroEventoModel = new UltimoRegistroEventoModel($em);
                    $ultimoRegistroEvento = $ultimoRegistroEventoModel->montaRecuperaRelacionamento($filtro);
                    $timestampSalario = isset($ultimoRegistroEvento[0]->timestamp) ? $ultimoRegistroEvento[0]->timestamp : '';
                }

                $filtro  = " AND cod_contrato = ".$codContrato;
                $filtro .= " AND cod_periodo_movimentacao = ".$codPeriodoMovimentacao;
                $filtro .= " AND registro_evento_complementar.cod_configuracao = 2";
                $filtro .= " AND cod_complementar = ".$complementarSituacao->cod_complementar;

                $eventoComplementarCalculado = new EventoComplementarCalculadoModel($em);
                $eventosComplementaresCalculados = $eventoComplementarCalculado->recuperaEventoCalculdado($filtro);

                $timestampComplementar = '';
                if (is_object($eventosComplementaresCalculados) and $eventosComplementaresCalculados->timestamp) {
                    $timestampComplementar = $eventosComplementaresCalculados->timestamp;
                } else {
                    $ultimoRegistroEventoComplementarModel = new UltimoRegistroEventoComplementarModel($em);
                    $ultimoRegistroEventoComplementar = $ultimoRegistroEventoComplementarModel->montaRecuperaRelacionamento($filtro);
                    if (isset($ultimoRegistroEventoComplementar[0]['timestamp'])) {
                        $timestampComplementar = $ultimoRegistroEventoComplementar[0]['timestamp'];
                    }
                }

                if ($eventosComplementaresCalculados or !empty($ultimoRegistroEventoComplementar)) {
                    if ($timestampSalario < $timestampFerias and $timestampComplementar < $timestampFerias) {
                        $arExclui['ferias'] = true;
                    }

                    if ($timestampSalario > $timestampFerias and $timestampComplementar > $timestampFerias) {
                        $arExclui['ferias']       = true;
                        $arExclui['salario']      = true;
                        $arExclui['complementar'] = true;
                        $arExclui['cod_complementar'] = $complementarSituacao->cod_complementar;
                    }

                    if ($timestampSalario < $timestampFerias and $timestampComplementar > $timestampFerias) {
                        $arExclui['ferias']       = true;
                        $arExclui['salario']      = true;
                        $arExclui['complementar'] = true;
                        $arExclui['cod_complementar'] = $complementarSituacao->cod_complementar;
                    }

                    if ($timestampSalario > $timestampFerias and $timestampComplementar < $timestampFerias) {
                        $arExclui['ferias']       = true;
                        $arExclui['complementar'] = true;
                        $arExclui['cod_complementar'] = $complementarSituacao->cod_complementar;
                    }
                } else {
                    if ($timestampSalario < $timestampFerias) {
                        $arExclui['ferias'] = true;
                    }

                    if ($timestampSalario > $timestampFerias) {
                        $arExclui['ferias']       = true;
                        $arExclui['salario']      = true;
                    }
                }
            }

            if ($folhaSituacao->situacao == FolhaSituacao::ABERTO and (!is_object($complementarSituacao) or $complementarSituacao->situacao == FolhaSituacao::FECHADO)) {
                $eventoCalculadoModel = new EventoCalculadoModel($em);
                $filtro = " AND cod_contrato = ".$codContrato;
                $filtro .= " AND registro_evento_periodo.cod_periodo_movimentacao = ".$codPeriodoMovimentacao;
                $eventosSalarioCalculado = $eventoCalculadoModel->montaRecuperaEventosCalculados($filtro);
                $timestampSalario = '';
                if (isset($eventosSalarioCalculado[0]['timestamp'])) {
                    $timestampSalario = $eventosSalarioCalculado[0]['timestamp'];
                }

                if ($timestampSalario < $timestampFerias) {
                    $arExclui['ferias'] = true;
                }

                if ($timestampSalario > $timestampFerias) {
                    $arExclui['ferias']       = true;
                    $arExclui['salario']      = true;
                }
            }

            if ($folhaSituacao->situacao == FolhaSituacao::FECHADO and $complementarSituacao->situacao == FolhaSituacao::ABERTO) {
                $eventoComplementarCalculadoModel = new EventoComplementarCalculadoModel($em);
                $filtro  = " AND cod_contrato = ".$codContrato;
                $filtro .= " AND cod_periodo_movimentacao = ".$codPeriodoMovimentacao;
                $filtro .= " AND cod_complementar = ".$complementarSituacao->cod_complementar;
                $eventosComplementaresCalculados = $eventoComplementarCalculadoModel->recuperaEventosCalculados($filtro);

                $timestampComplementar = '';
                if (isset($eventosComplementaresCalculados[0]['timestamp'])) {
                    $timestampComplementar = $eventosComplementaresCalculados[0]['timestamp'];
                }

                if ($timestampComplementar < $timestampFerias) {
                    $arExclui['ferias'] = true;
                }

                if ($timestampComplementar > $timestampFerias) {
                    $arExclui['ferias']       = true;
                    $arExclui['complementar'] = true;
                    $arExclui['cod_complementar'] = $complementarSituacao->cod_complementar;
                }
            }
        } else {
            $arExclui['ferias'] = true;
        }

        return $arExclui;
    }
}
