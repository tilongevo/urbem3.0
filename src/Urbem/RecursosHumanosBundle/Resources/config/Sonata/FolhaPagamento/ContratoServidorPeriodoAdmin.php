<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\Padrao;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;

use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;
use Urbem\CoreBundle\Entity\Pessoal\ServidorContratoServidor;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\UltimoRegistroEventoModel;

use Urbem\CoreBundle\Model\Pessoal\ContratoServidorModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin;

class ContratoServidorPeriodoAdmin extends GeneralFilterAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/contrato-servidor-periodo';
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
        if (isset($filter['codContrato']['value'])) {
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

        $contratoList = $entityManager->getRepository("CoreBundle:Pessoal\Contrato")
            ->getContrato('');

        $contratos = array();

        foreach ($contratoList as $contrato) {
            array_push(
                $contratos,
                $contrato->cod_contrato
            );
        }

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $query->innerJoin('o.fkFolhapagamentoPeriodoMovimentacao', 'fc');
        $query->andWhere("fc.codPeriodoMovimentacao = {$periodoFinal->getCodPeriodoMovimentacao()}");

        $query->andWhere($query->expr()->in('o.codContrato', $contratos));

        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere("{$query->getRootAliases()[0]}.codContrato = :codContrato")->setParameters(['codContrato' => 0]);
        }
        return $query;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        /** @var ContratoServidorPeriodo $contratoServidorPeriodo */
        $contratoServidorPeriodo = $em->getRepository(ContratoServidorPeriodo::class)->findBy(
            [
                'codPeriodoMovimentacao' => $periodoFinal->getCodPeriodoMovimentacao()
            ]
        );

        $contratoArray = [];

        /** @var ContratoServidorPeriodo $contrato */
        foreach ($contratoServidorPeriodo as $contrato) {
            $contratoArray[] = $contrato->getFkPessoalContrato()->getCodContrato();
        }

        $fieldOptions['codContrato'] = array(
            'label' => 'label.gerarAssentamento.inContrato',
            'json_from_admin_code' => $this->code,
            'class' => 'CoreBundle:Pessoal\Contrato',
            'json_choice_label' => function ($contrato) {
                return $contrato->getRegistro()
                    . " - "
                    . $contrato->getCodContrato()
                    . " - "
                    . $contrato->getFkPessoalContratoServidor()
                        ->getFkPessoalServidorContratoServidores()->last()
                        ->getFkPessoalServidor()
                        ->getFkSwCgmPessoaFisica()
                        ->getFkSwCgm()
                        ->getNomcgm();
            },
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) use ($contratoArray) {

                $queryBuilder = $repo->createQueryBuilder('pcs')
                    ->join(Contrato::class, 'pc', 'WITH', "pc.codContrato = pcs.codContrato")
                    ->join(ServidorContratoServidor::class, 'pscs', 'WITH', "pscs.codContrato = pcs.codContrato")
                    ->join(Servidor::class, 'ps', 'WITH', "ps.codServidor = pscs.codServidor")
                    ->join(SwCgm::class, 'cgm', 'WITH', "cgm.numcgm = ps.numcgm")
                    ->andWhere('LOWER(cgm.nomCgm) LIKE :nomCgm')
                    ->setParameter('nomCgm', '%' . strtolower($term) . '%');

                $queryBuilder->andWhere(
                    $queryBuilder->expr()->notIn('pscs.codContrato', $contratoArray)
                );

                return $queryBuilder;
            },
            'attr' => [
                'class' => 'select2-parameters'
            ],
        );

        $formMapper
            ->add('codContrato', 'autocomplete', $fieldOptions['codContrato']);
    }

    /**
     * @param ContratoServidorPeriodo $contratoServidorPeriodo
     */
    public function prePersist($contratoServidorPeriodo)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao');

        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $contratoServidorPeriodo->setFkFolhapagamentoPeriodoMovimentacao($periodoFinal);
    }

    /**
     * @param ContratoServidorPeriodo $contratoServidorPeriodo
     */
    public function postPersist($contratoServidorPeriodo)
    {
        $this->forceRedirect("/recursos-humanos/folha-pagamento/contrato-servidor-periodo/{$this->getObjectKey($contratoServidorPeriodo)}/show");
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $em = $this->modelManager->getEntityManager($this->getClass());

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

        /** @var ContratoServidorPeriodo $contratoServidorPeriodo */
        $contratoServidorPeriodo = $this->getSubject();
        $contratoServidorPeriodo->periodo = $dtInicial->format('d/m/Y') . ' à ' . $dtFinal->format('d/m/Y');
        $contratoServidorPeriodo->competencia = $arDescMes[($arMes[1] - 1)] . '/' . $arMes[2];
        $contratoServidorPeriodo->matricula = $contratoServidorPeriodo->getFkPessoalContrato()->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
            ->getFkPessoalServidor()
            ->getFkSwCgmPessoaFisica()
            ->getFkSwCgm();


        $ultimoRegistroEventoModel = new UltimoRegistroEventoModel($em);
        $eventosCadastrados = $ultimoRegistroEventoModel->montaRecuperaRegistrosEventoDoContrato(
            $contratoServidorPeriodo->getFkPessoalContrato()->getRegistro(),
            $periodoFinal->getCodPeriodoMovimentacao()
        );

        $arEventosProporcionais = $arEventosVariaveis = $arEventosFixos = $arEventosBases = [];
        foreach ($eventosCadastrados as $key => $eventos) {
            if ($eventos['evento_sistema'] == false && $eventos['proporcional'] == true && $eventos['natureza'] != 'B') {
                $arEventosProporcionais[] = $eventos;
            } elseif ($eventos['evento_sistema'] == false && $eventos['tipo'] == "V" && $eventos['natureza'] != 'B') {
                $arEventosVariaveis[] = $eventos;
            } elseif ($eventos['evento_sistema'] == false && $eventos['automatico'] != true && $eventos['natureza'] != 'B') {
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
                    $arEventosBases[] = $arElementos;
                }
            }
        }

        $configuracaoModel = new ConfiguracaoModel($em);
        $boBase = $configuracaoModel->getConfiguracao('apresenta_aba_base', ConfiguracaoModel::MODULO_RH_FOLHAPAGAMENTO, true);
        $apresentaAbaBase = ($boBase == 'true') ? true : false;

        $contratoServidorPeriodo->apresentaAbaBase = $apresentaAbaBase;
        $contratoServidorPeriodo->eventosProporcionais = $arEventosProporcionais;
        $contratoServidorPeriodo->eventosVariaveis = $arEventosVariaveis;
        $contratoServidorPeriodo->eventosFixos = $arEventosFixos;
        $contratoServidorPeriodo->eventosBases = $arEventosBases;

        $showMapper
            ->add('codContrato');
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $contratoServidorPeriodo
     */
    public function validate(ErrorElement $errorElement, $contratoServidorPeriodo)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $folhaSituacao = $periodoMovimentacao->recuperaUltimaFolhaSituacao();

        if (is_null($folhaSituacao) || $folhaSituacao['situacao'] == 'f') {
            $errorElement->addViolation($this->trans('rh.folhas.folhaSalario.errors.folhaSalarioNaoAberta', [
            ], 'validators'));
        }
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
