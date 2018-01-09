<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoFeriasModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorModel;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin;

class ContratoServidorPeriodoFeriasAdmin extends GeneralFilterAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_ferias';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/contrato-servidor-periodo-ferias';
    protected $exibirMensagemFiltro = true;
    protected $exibirBotaoIncluir = false;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureGridFilters($datagridMapper, GeneralFilterAdmin::RECURSOSHUMANOS_FOLHA_REGISTRAREVENTO);
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $filter = $this->getDataGrid()->getValues();

        if (!$value['value']) {
            return;
        }

        // FILTRO POR MATRICULA
        if ($filter['codContrato']['value']) {
            $contratos = $filter['codContrato']['value'];

            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('o.codContrato', $contratos)
            );
        }

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $queryBuilder->andWhere("fc.codPeriodoMovimentacao = {$periodoFinal->getCodPeriodoMovimentacao()}");

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add(
                'fkPessoalContrato',
                'customField',
                [
                    'label' => 'Servidor',
                    'mapped' => false,
                    'template' => 'RecursosHumanosBundle:Pessoal\Contrato:contratoServidor.html.twig',
                    'admin_code' => 'recursos_humanos.admin.contrato_servidor'
                ]
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                )
            ));
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $query = parent::createQuery($context);

        /** @var RegistroEventoFeriasModel $registroEventoFeriasModel */
        $registroEventoFeriasModel = new RegistroEventoFeriasModel($entityManager);

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $exercicio = $this->getExercicio();

        $anoMesCompetencia = $periodoFinal->getDtFinal()->format('Ym');

        $contratoList = $registroEventoFeriasModel->recuperaContratosDoFiltro($exercicio, '', $anoMesCompetencia);

        $contratos = array();

        foreach ($contratoList as $contrato) {
            array_push(
                $contratos,
                $contrato['cod_contrato']
            );
        }

        $query->innerJoin('o.fkFolhapagamentoPeriodoMovimentacao', 'fc');
        $query->andWhere("fc.codPeriodoMovimentacao = {$periodoFinal->getCodPeriodoMovimentacao()}");

        $query->andWhere($query->expr()->in('o.codContrato', $contratos));

        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere("{$query->getRootAliases()[0]}.codContrato = :codContrato")->setParameters(['codContrato' => 0]);
        }
        return $query;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $eventoModel = new EventoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();

        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);
        $dtInicial = $periodoFinal->getDtInicial();
        $dtFinal = $periodoFinal->getDtFinal();
        $arMes = explode("/", $dtInicial->format('d/m/Y'));
        $arDescMes = ["Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

        /** @var ContratoServidorPeriodo $contratoServidorPeriodoFerias */
        $contratoServidorPeriodoFerias = $this->getSubject();
        $contratoServidorPeriodoFerias->periodo = $dtInicial->format('d/m/Y') . ' à ' . $dtFinal->format('d/m/Y');
        $contratoServidorPeriodoFerias->competencia = $arDescMes[($arMes[1] - 1)] . '/' . $arMes[2];
        $contratoServidorPeriodoFerias->matricula = $contratoServidorPeriodoFerias->getFkPessoalContrato()->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
            ->getFkPessoalServidor()
            ->getFkSwCgmPessoaFisica()
            ->getFkSwCgm();

        /** @var RegistroEventoFeriasModel $registroEventoFerias */
        $registroEventoFerias = new RegistroEventoFeriasModel($em);
        $filtro = " AND cod_contrato = ".$contratoServidorPeriodoFerias->getFkPessoalContrato()->getCodContrato();
        $filtro .= " AND cod_periodo_movimentacao = ".$periodoFinal->getCodPeriodoMovimentacao();
        $filtro .= " AND evento.natureza != 'B' ";

        $eventosCadastrados = $registroEventoFerias->montaRecuperaRelacionamento($filtro);
        $arEventosBase = [];

        $arEventosFixos = $arEventosBases = [];
        foreach ($eventosCadastrados as $key => $eventos) {
            if ($eventos['evento_sistema'] == false) {
                $arEventosFixos[] = $eventos;
            }

            $rsEvento = $eventoModel->listarEvento($eventos['cod_evento']);
            $rsEventoBase = $eventoModel->listarEventosBase($eventos['cod_evento'], $rsEvento[0]['timestamp']);

            if (is_array($rsEventoBase)) {
                foreach ($rsEventoBase as $bases) {
                    $rsEventosBasePai = $eventoModel->listarEvento($bases['cod_evento']);
                    $rsEvento = $eventoModel->listarEvento($bases['cod_evento_base']);

                    $arElementos = [];
                    $arElementos['codigo'] = $rsEventosBasePai[0]['codigo'];
                    $arElementos['descricao'] = $rsEvento[0]['descricao'];
                    $arElementos['valor'] = $rsEvento[0]['valor_quantidade'];
                    $arElementos['quantidade'] = $rsEvento[0]['unidade_quantitativa'];
                    $arElementos['inCodRegistro'] = $eventos['cod_registro'];
                    $arElementos['inCodigo'] = $rsEventosBasePai[0]['codigo'];
                    if (!in_array($bases['cod_evento_base'], $arEventosBases)) {
                        $arTemp['codigo'] = $rsEvento[0]['codigo'];
                        $arTemp['descricao'] = $rsEvento[0]['descricao'];
                        $arEventosBase[] = $arTemp;
                    }
                    $arEventosBases[] = $bases['cod_evento_base'];
                }
            }
        }

        $configuracaoModel = new ConfiguracaoModel($em);
        $boBase = $configuracaoModel->getConfiguracao('apresenta_aba_base', ConfiguracaoModel::MODULO_RH_FOLHAPAGAMENTO, true);
        $apresentaAbaBase = ($boBase == 'true') ? true : false;

        $contratoServidorPeriodoFerias->apresentaAbaBase = $apresentaAbaBase;
        $contratoServidorPeriodoFerias->eventosFixos = $arEventosFixos;
        $contratoServidorPeriodoFerias->eventosBases = $arEventosBase;

        $showMapper
            ->add('codContrato');
    }

    /**
     * @param ContratoServidorPeriodo $contratoServidorPeriodo
     *
     * @return string
     */
    public function getServidor($contratoServidorPeriodo)
    {
        if (is_null($contratoServidorPeriodo)) {
            return '';
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $contratoServidor = (new ContratoServidorModel($entityManager))->findOneByCodContrato($contratoServidorPeriodo->getCodContrato());

        if (is_null($contratoServidorPeriodo->getFkPessoalContrato()->getFkPessoalContratoServidor())) {
            return '';
        }
        return $contratoServidorPeriodo->getFkPessoalContrato()->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
                ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNumcgm()
            . " - "
            . $contratoServidorPeriodo->getFkPessoalContrato()->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
                ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomcgm();
    }
}
