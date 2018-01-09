<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use DateTime;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoCalculo;
use Urbem\CoreBundle\Entity\Arrecadacao\Calculo;
use Urbem\CoreBundle\Entity\Arrecadacao\CalculoCgm;
use Urbem\CoreBundle\Entity\Arrecadacao\CalculoGrupoCredito;
use Urbem\CoreBundle\Entity\Arrecadacao\Carne;
use Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao;
use Urbem\CoreBundle\Entity\Arrecadacao\Compensacao;
use Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoResto;
use Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoUtilizaResto;
use Urbem\CoreBundle\Entity\Arrecadacao\ImovelCalculo;
use Urbem\CoreBundle\Entity\Arrecadacao\Lancamento;
use Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo;
use Urbem\CoreBundle\Entity\Arrecadacao\Pagamento;
use Urbem\CoreBundle\Entity\Arrecadacao\PagamentoAcrescimo;
use Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCalculo;
use Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacao;
use Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacaoPagas;
use Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferencaCompensacao;
use Urbem\CoreBundle\Entity\Arrecadacao\Parcela;
use Urbem\CoreBundle\Entity\Divida\Parcela as DividaParcela;
use Urbem\CoreBundle\Entity\Divida\ParcelaCalculo;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Doctrine\ORM\Query\ResultSetMapping;

class CompensarPagamentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_baixa_debitos_compensar_pagamento';
    protected $baseRoutePattern = 'tributario/arrecadacao/baixa-debitos/compensar-pagamento';
    protected $includeJs = [
        '/tributario/javascripts/arrecadacao/compensar-pagamento.js'
    ];
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoExcluir = false;
    protected $maxPerPage = 1;
    protected $numcgm;

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add('emitir_relatorio', 'emitir-relatorio', array(), array(), array(), '', array(), array('GET'));
        $routes->clearExcept(['edit', 'list', 'emitir_relatorio']);
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);

        $filter = $this->getRequest()->query->get('filter');


        if (!$filter) {
            $qb->andWhere('1 = 0');
            return $qb;
        }

        $em = $this->modelManager->getEntityManager($this->getClass());

        $repository = $em->getRepository('CoreBundle:Arrecadacao\Calculo');

        $filtered = false;

        $contribuinte = $filter['contribuinte']['value'] ?: false;
        $exercicioIni = $filter['exercicioIni']['value'] ?: false;
        $exercicioEnd = $filter['exercicioEnd']['value'] ?: false;
        $inscricaoEconomica = $filter['inscricaoEconomica']['value'] ?: false;
        $inscricaoImobiliaria = $filter['inscricaoImobiliaria']['value'] ?: false;

        if ($filter['origemCompensacao']['value'] == 'duplicado') {
            $parcelasPagasEmDuplicidade = $repository->getParcelasPagasEmDuplicidade($contribuinte, $exercicioIni, $exercicioEnd, $inscricaoEconomica, $inscricaoImobiliaria);
        } else {
            $parcelasPagasEmDuplicidade = $repository->getParcelasComDiferencaPagas($contribuinte, $exercicioIni, $exercicioEnd, $inscricaoEconomica, $inscricaoImobiliaria);
        }

        $parcelasAVencer = $repository->getParcelasAVencer($contribuinte, $inscricaoEconomica, $inscricaoImobiliaria);

        if (!$parcelasPagasEmDuplicidade && !$parcelasAVencer) {
            $qb->andWhere('1 = 0');
            return $qb;
        }

        $qb->join(CalculoCgm::class, "cg", "WITH", "o.codCalculo = cg.codCalculo");

        $parcelasPagas = ['0'];
        if ($parcelasPagasEmDuplicidade) {
            $qb->orWhere($qb->expr()->eq('cg.numcgm', $parcelasPagasEmDuplicidade[0]['numcgm']));
        }

        $parcelasVencer = ['0'];
        if (!$parcelasPagasEmDuplicidade && $parcelasAVencer) {
            $qb->orWhere($qb->expr()->eq('cg.numcgm', $parcelasAVencer[0]['numcgm']));
        }

        return $qb;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'contribuinte',
                'doctrine_orm_choice',
                [
                    'label' => 'label.arrecadacaoImovelVVenal.contribuinte',
                ],
                'autocomplete',
                array(
                    'route' => array(
                        'name' => 'api-search-swcgm-pessoa-fisica-numcgm-nomecgm'
                    ),
                    'class' => SwCgm::class,
                    'mapped' => false
                )
            )
            ->add(
                'inscricaoEconomica',
                'doctrine_orm_choice',
                [
                    'label' => 'label.configuracaoEconomico.inscricaoEconomica',
                ],
                'entity',
                [
                    'class' => CadastroEconomico::class,
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('ce');

                        return $qb;
                    },
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'mapped' => false
                ],
                [
                    'admin_code' => 'tributario.admin.economico_cadastro_economico_autonomo'
                ]
            )
            ->add(
                'inscricaoImobiliaria',
                'doctrine_orm_choice',
                [
                    'label' => 'label.arrecadacaoCompensarPagamento.inscricaoImobiliaria',
                ],
                'autocomplete',
                [
                    'class' => Imovel::class,
                    'route' => [
                        'name' => 'urbem_tributario_arrecadacao_baixa_manual_debito_carrega_inscricoes_municipais'
                    ],
                    'mapped' => false,
                ]
            )
            ->add(
                'exercicioIni',
                'doctrine_orm_number',
                [
                    'label' => 'label.arrecadacaoCompensarPagamento.exercicioIni'
                ],
                null,
                [
                    'mapped' => false,
                    'attr' => [
                        'required' => 'required',
                        'value' => $this->getExercicio()
                    ],
                ]
            )
            ->add(
                'exercicioEnd',
                'doctrine_orm_number',
                [
                    'label' => 'label.arrecadacaoCompensarPagamento.exercicioEnd'
                ],
                null,
                [
                    'mapped' => false,
                ]
            )
            ->add(
                'origemCompensacao',
                'doctrine_orm_choice',
                [
                    'label' => 'label.arrecadacaoCompensarPagamento.origemCompensacao',
                ],
                'choice',
                [
                    'mapped' => false,
                    'attr' => [
                        'class' => 'js-origem-compensacao '
                    ],
                    'multiple' => false,
                    'expanded' => false,
                    'choices' => [
                        'label.arrecadacaoCompensarPagamento.pagamentosDuplicados' => 'duplicado',
                        'label.arrecadacaoCompensarPagamento.pagamentoMaior' => 'maior'
                    ]
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add(
                'contribuinte',
                'customField',
                [
                    'label' => 'label.arrecadacaoCompensarPagamento.contribuinte',
                    'template' => 'TributarioBundle::Arrecadacao/CompensarPagamento/contribuinte.html.twig',
                ]
            )
            ->add(
                'saldos',
                'customField',
                [
                    'label' => 'label.arrecadacaoCompensarPagamento.saldoDisponivel',
                    'template' => 'TributarioBundle::Arrecadacao/CompensarPagamento/saldos.html.twig',
                ]
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'TributarioBundle:Sonata\Arrecadacao\CompensarPagamento\CRUD:list__action_edit.html.twig'),
                ),
                'header_style' => 'width: 20%'
            ))
        ;
    }

    /**
     * @return string
     */
    public function getFilter()
    {
        return http_build_query($this->getRequest()->query->get('filter'));
    }

    /**
     * @param int
     * @return void
     */
    public function setNumCgm($numcgm)
    {
        $this->numcgm = $numcgm;
    }

    /**
     * @return int
     */
    public function getSaldoDisponivel()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $calculo = $em->getRepository(Calculo::class)->getSaldoDisponivel($this->numcgm);

        if (!$calculo) {
            return false;
        }

        return $calculo[0]['saldo_disponivel'];
    }

    /**
     * @param int
     * @param int
     * @return string
     */
    public function getOrigem($codConvenio, $codLancamento)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        if ($codConvenio == -1) {
            $lancamentoOrigem = $em->getRepository(Lancamento::class)->getBuscaOrigemLancamento($codLancamento);

            return $lancamentoOrigem[0]['origem'];
        }

        $lancamento = $em->getRepository(Lancamento::class)->findOneByCodLancamento($codLancamento);
        $lancamentoOrigem = $em->getRepository(Lancamento::class)->getOrigemCobranca($lancamento, true);

        return $lancamentoOrigem[0]['fn_busca_origem_lancamento_sem_exercicio'];
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $labelOrigemCompensacao = 'label.arrecadacaoCompensarPagamento.parcelasPagasMaior';
        if ($this->getOrigemCompensacao() == 'duplicado') {
            $labelOrigemCompensacao = 'label.arrecadacaoCompensarPagamento.parcelasPagasEmDuplicidade';
        }

        $formMapper
            ->with('')
                ->add(
                    'contribuinte',
                    'customField',
                    [
                        'mapped' => false,
                        'template' => 'TributarioBundle::Arrecadacao/CompensarPagamento/contribuinteEdit.html.twig',
                        'data' => [],
                        'label' => false
                    ]
                )
            ->end()
            ->with($labelOrigemCompensacao)
                ->add(
                    'parcelasPagasEmDuplicidade',
                    'customField',
                    [
                        'mapped' => false,
                        'label' => false,
                        'template' => 'TributarioBundle::Arrecadacao/CompensarPagamento/parcelasPagasEmDuplicidade.html.twig',
                        'data' => [
                            'origemCompensacao' => $this->getOrigemCompensacao(),
                            'contribuinte' => $this->getFilterContribuinte(),
                            'exercicioIni' => $this->getExercicioIni(),
                            'exercicioEnd' => $this->getExercicioEnd(),
                            'inscricaoEconomica' => $this->getInscricaoEconomica(),
                            'inscricaoImobiliaria' => $this->getInscricaoImobiliaria()
                        ]
                    ]
                )
            ->end()
            ->with('label.arrecadacaoCompensarPagamento.parcelasAVencer')
                ->add(
                    'parcelasAVencer',
                    'customField',
                    [
                        'mapped' => false,
                        'label' => false,
                        'template' => 'TributarioBundle::Arrecadacao/CompensarPagamento/parcelasAVencer.html.twig',
                        'data' => [
                            'contribuinte' => $this->getFilterContribuinte(),
                            'inscricaoEconomica' => $this->getInscricaoEconomica(),
                            'inscricaoImobiliaria' => $this->getInscricaoImobiliaria()
                        ]
                    ]
                )
            ->end()
            ->add(
                'filter',
                'hidden',
                [
                    'required' => false,
                    'mapped' => false,
                    'data' => http_build_query(
                        [
                            'contribuinte' => $this->getFilterContribuinte(),
                            'exercicioIni' => $this->getExercicioIni(),
                            'exercicioEnd' => $this->getExercicioEnd(),
                            'inscricaoEconomica' => $this->getInscricaoEconomica(),
                            'inscricaoImobiliaria' => $this->getInscricaoImobiliaria()
                        ]
                    )
                ]
            )
            ->add(
                'origemCompensacao',
                'hidden',
                [
                    'required' => false,
                    'mapped' => false,
                    'data' => $this->getOrigemCompensacao()
                ]
            )
        ;
    }

    /**
     * @param int
     * @param int
     * @param int
     * @param int
     * @param int
     * @return array
     */
    public function getParcelasPagasEmDuplicidade($contribuinte, $exercicioIni, $exercicioEnd, $inscricaoEconomica, $inscricaoImobiliaria)
    {
        $contribuinte = $contribuinte ?: false;
        $exercicioIni = $exercicioIni ?: false;
        $exercicioEnd = $exercicioEnd ?: false;
        $inscricaoEconomica = $inscricaoEconomica ?: false;
        $inscricaoImobiliaria = $inscricaoImobiliaria ?: false;

        $em = $this->modelManager->getEntityManager($this->getClass());
        $repository = $em->getRepository('CoreBundle:Arrecadacao\Calculo');
        $parcelasPagasEmDuplicidade = $repository->getParcelasPagasEmDuplicidade($contribuinte, $exercicioIni, $exercicioEnd, $inscricaoEconomica, $inscricaoImobiliaria);

        return $parcelasPagasEmDuplicidade;
    }

    /**
     * @param int
     * @param int
     * @param int
     * @param int
     * @param int
     * @return array
     */
    public function getParcelasComDiferencaPagas($contribuinte, $exercicioIni, $exercicioEnd, $inscricaoEconomica, $inscricaoImobiliaria)
    {
        $contribuinte = $contribuinte ?: false;
        $exercicioIni = $exercicioIni ?: false;
        $exercicioEnd = $exercicioEnd ?: false;
        $inscricaoEconomica = $inscricaoEconomica ?: false;
        $inscricaoImobiliaria = $inscricaoImobiliaria ?: false;

        $em = $this->modelManager->getEntityManager($this->getClass());
        $repository = $em->getRepository('CoreBundle:Arrecadacao\Calculo');
        $parcelasComDiferencaPaga = $repository->getParcelasComDiferencaPagas($contribuinte, $exercicioIni, $exercicioEnd, $inscricaoEconomica, $inscricaoImobiliaria);

        return $parcelasComDiferencaPaga;
    }

    /**
     * @param int
     * @param int
     * @param int
     * @return array
     */
    public function getParcelasAVencer($contribuinte, $inscricaoEconomica, $inscricaoImobiliaria)
    {
        $contribuinte = $contribuinte ?: false;
        $inscricaoEconomica = $inscricaoEconomica ?: false;
        $inscricaoImobiliaria = $inscricaoImobiliaria ?: false;

        $em = $this->modelManager->getEntityManager($this->getClass());
        $repository = $em->getRepository('CoreBundle:Arrecadacao\Calculo');
        $parcelasAVencere = $repository->getParcelasAVencer($contribuinte, $inscricaoEconomica, $inscricaoImobiliaria);
        return $parcelasAVencere;
    }

    /**
     * @param null|bool
     * @return int
     */
    public function getFilterContribuinte($getObject = false)
    {

        $filter = $this->getRequest()->query->get('contribuinte');

        if ($getObject) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $repository = $em->getRepository('CoreBundle:SwCgm');
            $cgm = $repository->findOneByNumcgm($filter['value']);

            return $cgm;
        }

        return $filter['value'];
    }

    /**
     * @param int
     * @return string
     */
    public function getContribuinte($numcgm)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $repository = $em->getRepository('CoreBundle:SwCgm');
        $cgm = $repository->findOneByNumcgm($numcgm);

        return $cgm;
    }

    /**
     * @return string
     */
    public function getOrigemCompensacao()
    {
        $filter = $this->getRequest()->query->get('origemCompensacao');
        return $filter['value'];
    }

    /**
     * @return int
     */
    public function getExercicioIni()
    {
        $filter = $this->getRequest()->query->get('exercicioIni');
        return $filter['value'];
    }

    /**
     * @return int
     */
    public function getExercicioEnd()
    {
        $filter = $this->getRequest()->query->get('exercicioEnd');
        return $filter['value'];
    }

    /**
     * @return int
     */
    public function getInscricaoEconomica()
    {
        $filter = $this->getRequest()->query->get('inscricaoEconomica');
        return $filter['value'];
    }

    /**
     * @return int
     */
    public function getInscricaoImobiliaria()
    {
        $filter = $this->getRequest()->query->get('inscricaoImobiliaria');
        return $filter['value'];
    }

    /**
     * @param Proprietario $object
     */
    public function preUpdate($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();

        $totalCompensacao = $_REQUEST['totalCompensacao'];
        $saldoRestante = $_REQUEST['saldoRestante'];
        $saldoDisponivel = $_REQUEST['saldoDisponivel'];
        $valorParcelasSelecionadas = $_REQUEST['parcelasSelecionadas'];
        $valorCompensar = $_REQUEST['valorCompensar'];
        $contribuinte = $_REQUEST['contribuinte'];

        $emitirRelatorio = isset($_REQUEST['emitirRelatorio']) ?: false;
        $aplicarAcrescimos = isset($_REQUEST['aplicaAcrescimos']) ?: false;
        $origemCompensacao = ($this->getForm()->get('origemCompensacao')->getData()) ?: false;

        $parcelasPagas = $_REQUEST['parcelaPaga'] ?: false;
        $parcelasVencer = $_REQUEST['parcelaVencer'] ?: false;

        $session = $this->getRequest()->getSession();
        $session->set('parcelasPagas', $parcelasPagas);
        $session->set('parcelasVencer', $parcelasVencer);

        $em->getConnection()->beginTransaction();

        try {
            $codCompensacao = $em->getRepository(Compensacao::class)->getNextVal('cod_compensacao');
            $compensacao = new Compensacao();
            $compensacao->setCodCompensacao($codCompensacao);
            $compensacao->setNumcgm($this->getCurrentUser()->getNumcgm());
            $compensacao->setValor($totalCompensacao);
            $aplicaAcrescimos = isset($_REQUEST['aplicarAcrescimos']) ? true : false;
            $compensacao->setAplicarAcrescimos($aplicaAcrescimos);
            $codTipo = ($origemCompensacao == 'duplicado') ? 1 : 2;

            $compensacao->setCodTipo($codTipo);

            if ($saldoRestante > 0) {
                $compensacaoResto = new CompensacaoResto();
                $compensacaoResto->setCodCompensacao($codCompensacao);
                $compensacaoResto->setValor($saldoRestante);
                $compensacao->setFkArrecadacaoCompensacaoResto($compensacaoResto);
            }

            $filtro = $this->getForm()->get('filter')->getData();
            $filtroPieces = explode('&', $filtro);

            $contribuinte = explode('=', $filtroPieces[0]);
            $contribuinte = (count($contribuinte) > 1) ? end($contribuinte) : false;

            $inscricaoEconomica = explode('=', $filtroPieces[3]);
            $inscricaoEconomica = (count($inscricaoEconomica) > 1) ? end($inscricaoEconomica) : false;

            $inscricaoImobiliaria = explode('=', $filtroPieces[4]);
            $inscricaoImobiliaria = (count($inscricaoImobiliaria) > 1) ? end($inscricaoImobiliaria) : false;

            $carnesPagamentoComResto = $em->getRepository(Calculo::class)->getCarnesPagamentoComResto($contribuinte, $inscricaoEconomica, $inscricaoImobiliaria);

            if ($carnesPagamentoComResto) {
                foreach ((array) $carnesPagamentoComResto as $pagamentoComResto) {
                    $compensacaoUtilizaResto = new CompensacaoUtilizaResto();
                    $compensacaoUtilizaResto->setCodCompensacao($codCompensacao);
                    $compensacaoUtilizaResto->setCodCompensacaoResto($pagamentoComResto['cod_compensacao']);
                    $compensacao->setFkArrecadacaoCompensacaoUtilizaResto($compensacaoUtilizaResto);
                }
            }

            if ($parcelasPagas) {
                foreach ((array) $parcelasPagas as $parcelaPaga) {
                    $parcelaParts = explode('~', $parcelaPaga);

                    if ($origemCompensacao == 'duplicado') {
                        $pagamentoCompensacao = new PagamentoCompensacao();
                        $pagamentoCompensacao->setCodCompensacao($codCompensacao);
                        $pagamentoCompensacao->setNumeracao($parcelaParts[0]);
                        $pagamentoCompensacao->setOcorrenciaPagamento($parcelaParts[4]);
                        $pagamentoCompensacao->setCodConvenio($parcelaParts[5]);
                        $compensacao->addFkArrecadacaoPagamentoCompensacoes($pagamentoCompensacao);

                        continue;
                    } else {
                        $tmpCalculos = explode('#', $parcelaParts[9]);
                        for ($tmpCount=0; $tmpCount < count($tmpCalculos); $tmpCount++) {
                            $pagamentoDiferencaCompensacao = new PagamentoDiferencaCompensacao();
                            $pagamentoDiferencaCompensacao->setCodCompensacao($codCompensacao);
                            $pagamentoDiferencaCompensacao->setNumeracao($parcelaParts[0]);
                            $pagamentoDiferencaCompensacao->setOcorrenciaPagamento($parcelaParts[4]);
                            $pagamentoDiferencaCompensacao->setCodConvenio($parcelaParts[5]);
                            $pagamentoDiferencaCompensacao->setCodCalculo($tmpCalculos[$tmpCount]);
                            $compensacao->addFkArrecadacaoPagamentoDiferencaCompensacoes($pagamentoDiferencaCompensacao);
                        }
                    }
                }
            }

            $em->persist($compensacao);

            if ($parcelasVencer) {
                foreach ((array) $parcelasVencer as $parcelaVencer) {
                    $parcelaParts = explode('~', $parcelaVencer);

                    $valorPago = $parcelaParts[2];
                    if ($aplicarAcrescimos) {
                        $valorPago = $parcelaParts[3];
                    }

                    $faltou = 0.00;
                    if (($totalCompensacao - $valorPago) < 0.00) {
                        $faltou = $valorPago - $totalCompensacao;
                        $valorPago = $totalCompensacao;
                    }

                    if ($parcelaParts[5] != -1) {
                        $pagamentosCompensacao = $em->getRepository(Carne::class)->getCalculosParcela($parcelaParts[0]);
                    } else {
                        $pagamentosCompensacao = $em->getRepository(Carne::class)->getCalculosParcelaDA($parcelaParts[0]);
                    }

                    if ($faltou) {
                        $totalJuros = 0.00;
                        $totalMulta = 0.00;
                        $totalCorrecao = 0.00;
                        $totalCalculo = 0.00;
                        $totalCalculo = end($pagamentosCompensacao)->valor_parcela;
                        reset($pagamentosCompensacao);

                        foreach ($pagamentosCompensacao as $pagamento) {
                            if ($aplicarAcrescimos) {
                                $totalCorrecao += $pagamento->correcao;
                                $totalJuros += $pagamento->juro;
                                $totalMulta += $pagamento->multa;
                            }
                        }

                        $totalAcrescimos = ($totalCorrecao + $totalJuros + $totalMulta);
                        $sobraPraAcrescimo = $valorPago;
                        $sobraPraCalculo = $valorPago - $totalAcrescimos;
                    }

                    if ($parcelaParts[5] != -1) {
                        //cancelando parcelas por motivo de pagamento de unica/parcela normal
                        $filtroCarnes = " WHERE p.cod_lancamento = (
                                                SELECT DISTINCT
                                                    parcela.cod_lancamento
                                                FROM
                                                    arrecadacao.parcela
                                                INNER JOIN
                                                    arrecadacao.carne
                                                ON
                                                    carne.cod_parcela = parcela.cod_parcela
                                                WHERE
                                                    carne.numeracao = '".$parcelaParts[0]."' ) ";

                        if ($parcelaParts[7] == 0) { //eh unica
                            $filtroCarnes .= " AND p.nr_parcela > 0 ";
                            $motivo = 100;
                        } else {
                            $filtroCarnes .= " AND p.nr_parcela = 0 ";
                            $motivo = 101;
                        }

                        $carnesCancelar = $em->getRepository(Carne::class)->getParcelasLancamento($filtroCarnes);

                        if ($carnesCancelar) {
                            foreach ($carnesCancelar as $carneCancelar) {
                                $carneDevolucao = new CarneDevolucao();
                                $carneDevolucao->setNumeracao($carneCancelar->numeracao);
                                $carneDevolucao->setCodMotivo($motivo);
                                $carneDevolucao->setDtDevolucao(new DateTime());
                                $carneDevolucao->setCodConvenio($carneCancelar->cod_convenio);

                                $em->persist($carneDevolucao);
                            }
                        }

                        $pagamento = new Pagamento();
                        $pagamento->setNumeracao($parcelaParts[0]);
                        $pagamento->setOcorrenciaPagamento(1);
                        $pagamento->setCodConvenio($parcelaParts[4]);
                        $pagamento->setNumcgm($this->getCurrentUser()->getNumcgm());
                        $pagamento->setDataBaixa(new DateTime());
                        $pagamento->setDataPagamento(new DateTime());
                        $pagamento->setInconsistente(false);
                        $pagamento->setValor($valorPago);
                        $pagamento->setCodTipo(12);

                        $em->persist($pagamento);

                        $pagamentoCompensacaoPagas = new PagamentoCompensacaoPagas();
                        $pagamentoCompensacaoPagas->setCodCompensacao($codCompensacao);
                        $pagamentoCompensacaoPagas->setNumeracao($parcelaParts[0]);
                        $pagamentoCompensacaoPagas->setOcorrenciaPagamento(1);
                        $pagamentoCompensacaoPagas->setCodConvenio($parcelaParts[4]);

                        $em->persist($pagamentoCompensacaoPagas);

                        $parcelasNovas = [];

                        if ($faltou) {
                            foreach ($pagamentosCompensacao as $pagamento) {
                                if ($sobraPraCalculo > 0.00) {
                                    if ($sobraPraCalculo - $pagamento->valor_calculo >= 0.00) {
                                        $valorCalc = $pagamento->valor_calculo;
                                        $sobraPraCalculo -= $pagamento->valor_calculo;
                                    } else {
                                        $valorCalc = $sobraPraCalculo;
                                        $sobraPraCalculo = 0.00;
                                    }

                                    $pagamentoCalculo = new PagamentoCalculo();
                                    $pagamentoCalculo->setNumeracao($parcelaParts[0]);
                                    $pagamentoCalculo->setCodCalculo($pagamento->cod_calculo);
                                    $pagamentoCalculo->setOcorrenciaPagamento(1);
                                    $pagamentoCalculo->setCodConvenio($parcelaParts[4]);
                                    $pagamentoCalculo->setValor($valorCalc);

                                    $em->persist($pagamentoCalculo);
                                }

                                if ($aplicarAcrescimos) {
                                    if ($sobraPraAcrescimo > 0.00) {
                                        if (($sobraPraAcrescimo - $pagamento->correcao) >= 0.00) {
                                            $valorAcr = $pagamento->correcao;
                                            $sobraPraAcrescimo -= $pagamento->correcao;
                                        } else {
                                            $valorAcr = $sobraPraAcrescimo;
                                            $sobraPraAcrescimo = 0.00;
                                        }

                                        $pagamentoAcrescimo = new PagamentoAcrescimo();
                                        $pagamentoAcrescimo->setNumeracao($parcelaParts[0]);
                                        $pagamentoAcrescimo->setOcorrenciaPagamento(1);
                                        $pagamentoAcrescimo->setCodConvenio($parcelaParts[4]);
                                        $pagamentoAcrescimo->setCodCalculo($pagamento->cod_calculo);
                                        $pagamentoAcrescimo->setCodAcrescimo(3);
                                        $pagamentoAcrescimo->setCodTipo(1);
                                        $pagamentoAcrescimo->setValor($valorAcr);

                                        $em->persist($pagamentoAcrescimo);
                                    }

                                    if ($sobraPraAcrescimo > 0.00) {
                                        if (($sobraPraAcrescimo - $pagamento->juro) >= 0.00) {
                                            $valorAcr = $pagamento->juro;
                                            $sobraPraAcrescimo -= $pagamento->juro;
                                        } else {
                                            $valorAcr = $sobraPraAcrescimo;
                                            $sobraPraAcrescimo = 0.00;
                                        }

                                        $pagamentoAcrescimo = new PagamentoAcrescimo();
                                        $pagamentoAcrescimo->setNumeracao($parcelaParts[0]);
                                        $pagamentoAcrescimo->setOcorrenciaPagamento(1);
                                        $pagamentoAcrescimo->setCodConvenio($parcelaParts[4]);
                                        $pagamentoAcrescimo->setCodCalculo($pagamento->cod_calculo);
                                        $pagamentoAcrescimo->setCodAcrescimo(1);
                                        $pagamentoAcrescimo->setCodTipo(2);
                                        $pagamentoAcrescimo->setValor($valorAcr);

                                        $em->persist($pagamentoAcrescimo);
                                    }

                                    if ($sobraPraAcrescimo > 0.00) {
                                        if (($sobraPraAcrescimo - $pagamento->multa) >= 0.00) {
                                            $valorAcr = $pagamento->multa;
                                            $sobraPraAcrescimo -= $pagamento->multa;
                                        } else {
                                            $valorAcr = $sobraPraAcrescimo;
                                            $sobraPraAcrescimo = 0.00;
                                        }

                                        $pagamentoAcrescimo = new PagamentoAcrescimo();
                                        $pagamentoAcrescimo->setNumeracao($parcelaParts[0]);
                                        $pagamentoAcrescimo->setOcorrenciaPagamento(1);
                                        $pagamentoAcrescimo->setCodConvenio($parcelaParts[4]);
                                        $pagamentoAcrescimo->setCodCalculo($pagamento->cod_calculo);
                                        $pagamentoAcrescimo->setCodAcrescimo(2);
                                        $pagamentoAcrescimo->setCodTipo(3);
                                        $pagamentoAcrescimo->setValor($valorAcr);

                                        $em->persist($pagamentoAcrescimo);
                                    }
                                }
                            }

                            //criando novo calculo, lancamento e carne para sobras do carne
                            reset($pagamentosCompensacao);

                            $observacaoSistema = "Novo lancamento referente a compensação da parcela '".$parcelaParts[7]."', carne '".$parcelaParts[0]."' e origem '".$parcelaParts[5]."'.";


                            $codLancamento = $em->getRepository(Lancamento::class)->getNextVal('cod_lancamento');
                            $lancamento = new Lancamento();
                            $lancamento->setCodLancamento($codLancamento);
                            $lancamento->setVencimento(new DateTime());
                            $lancamento->setTotalParcelas(1);
                            $lancamento->setAtivo(true);
                            $lancamento->setValor(($totalCalculo + $totalAcrescimos) - $valorPago); //total a lancar eh o valor total do calculo mais acrescimos menos o total pago
                            $lancamento->setObservacaoSistema($observacaoSistema);
                            $lancamento->setObservacao($observacaoSistema);

                            $em->persist($lancamento);

                            $codParcela = $em->getRepository(Parcela::class)->getCodParcela();
                            $parcela = new Parcela();
                            $parcela->setCodParcela($codParcela);
                            $parcela->setCodLancamento($codLancamento);
                            $parcela->setValor(($totalCalculo + $totalAcrescimos) - $valorPago);
                            $parcela->setVencimento(new DateTime());
                            $parcela->setNrParcela(1);

                            $em->persist($parcela);

                            if ($valorPago - $totalAcrescimos < 0.00) { //nao conseguiu pagar nem os acrescimos, adiciona valor dos acrescimos ao total por credito
                                foreach ($pagamentosCompensacao as $pagamento) {
                                    $porcentoAcrescimo = ($pagamento->valor_calculo * 100) / $totalCalculo;
                                    $porcentoAcrescimo = (($totalAcrescimos - $valorPago) * $porcentoAcrescimo) / 100;
                                    $codCalculo = $em->getRepository(Calculo::class)->getNextVal('cod_calculo');

                                    $calculos = $em->getRepository(Calculo::class)->findOneByCodCalculo($pagamento->cod_calculo);
                                    if ($calculos) {
                                        $calculo = new Calculo();
                                        $calculo->setCodCalculo($codCalculo);
                                        $calculo->setCodCredito($calculos->cod_credito);
                                        $calculo->setCodEspecie($calculos->cod_especie);
                                        $calculo->setCodGenero($calculos->cod_genero);
                                        $calculo->setCodNatureza($calculos->cod_natureza);
                                        $calculo->setExercicio($calculos->exercicio);
                                        $calculo->setValor($pagamento->valor_calculo + $porcentoAcrescimo);
                                        $calculo->setNroParcelas(1);
                                        $calculo->setAtivo(true);
                                        $calculo->setCalculado(true);

                                        $em->persist($calculo);
                                        $em->flush();
                                    }

                                    $lancamentoCalculo = new LancamentoCalculo();
                                    $lancamentoCalculo->setCodCalculo($codCalculo);
                                    $lancamentoCalculo->setCodLancamento($codLancamento);
                                    $lancamentoCalculo->setValor($pagamento->valor_calculo + $porcentoAcrescimo);

                                    $em->persist($lancamentoCalculo);

                                    $calculosCgm = $em->getRepository(CalculoCgm::class)->findOneByCodCalculo($pagamento->cod_calculo);
                                    if ($calculosCgm) {
                                        $calculoCgm = new CalculoCgm();
                                        $calculoCgm->setCodCalculo($codCalculo);
                                        $calculoCgm->setNumcgm($calculosCgm->numcgm);

                                        $em->persist($calculoCgm);
                                    }

                                    $imoveisCalculo = $em->getRepository(ImovelCalculo::class)->findOneByCodCalculo($pagamento->cod_calculo);
                                    if ($imoveisCalculo) {
                                        $imovelCalculo = new ImovelCalculo();
                                        $imovelCalculo->setCodCalculo($codCalculo);
                                        $imovelCalculo->setInscricaoMunicipal($imoveisCalculo->inscricao_municipal);
                                        $imovelCalculo->setTimestamp($imoveisCalculo->timestamp);

                                        $em->persist($imovelCalculo);
                                    }

                                    $cadastrosEconomicoCalculo = $em->getRepository(CadastroEconomicoCalculo::class)->findOneByCodCalculo($pagamento->cod_calculo);
                                    if ($cadastrosEconomicoCalculo) {
                                        $cadastroEconomicoCalculo = new CadastroEconomicoCalculo();
                                        $cadastroEconomicoCalculo->setCodCalculo($codCalculo);
                                        $cadastroEconomicoCalculo->setInscricaoEconomica($cadastrosEconomicoCalculo->inscricao_economica);
                                        $cadastroEconomicoCalculo->setTimestamp($cadastrosEconomicoCalculo->timestamp);

                                        $em->persist($cadastroEconomicoCalculo);
                                    }

                                    $calculosGrupoCredito = $em->getRepository()->findOneByCodCalculo($pagamento->cod_calculo);
                                    if ($calculosGrupoCredito) {
                                        $calculoGrupoCredito = new CalculoGrupoCredito();
                                        $calculoGrupoCredito->setCodCalculo($codCalculo);
                                        $calculoGrupoCredito->setCodGrupo($calculosGrupoCredito->cod_grupo);
                                        $calculoGrupoCredito->setAnoExercicio($calculosGrupoCredito->ano_exercicio);

                                        $em->persist($calculoGrupoCredito);
                                    }
                                }
                            } else { //pagou todos acrescimos, faltou apenas creditos
                                $sobraPraCalculo = $valorPago - $totalAcrescimos;

                                foreach ($pagamentosCompensacao as $pagamento) {
                                    if ($sobraPraCalculo > 0.00) {
                                        if (($sobraPraCalculo - $pagamento->valor_calculo) >= 0.00) {
                                            $valorCalc = 0.00;
                                            $sobraPraCalculo -= $pagamento->valor_calculo;
                                            continue;
                                        } else {
                                            $valorCalc = $pagamento->valor_calculo - $sobraPraCalculo;
                                            $sobraPraCalculo = 0.00;
                                        }
                                    } else {
                                        $valorCalc = $pagamento->valor_calculo;
                                    }

                                    $codCalculo = $em->getRepository(Calculo::class)->nextVal('cod_calculo');

                                    $calculos = $em->getRepository(Calculo::class)->findOneByCodCalculo($pagamento->cod_calculo);

                                    if ($calculos) {
                                        $calculo = new Calculo();
                                        $calculo->setCodCalculo($codCalculo);
                                        $calculo->setCodCredito($calculos->getCodCredito());
                                        $calculo->setCodEspecie($calculos->getCodEspecie());
                                        $calculo->setCodGenero($calculos->getCodGenero());
                                        $calculo->setCodNatureza($calculos->getCodNatureza());
                                        $calculo->setExercicio($calculos->getExercicio());
                                        $calculo->setValor($valorCalc);
                                        $calculo->setNroParcelas(1);
                                        $calculo->setAtivo(true);
                                        $calculo->setCalculado(true);

                                        $em->persist($calculo);
                                        $em->flush();
                                    }

                                    $lancamentoCalculo = new lancamentoCalculo;
                                    $lancamentoCalculo->setCodCalculo($codCalculo);
                                    $lancamentoCalculo->setCodLancamento($codLancamento);
                                    $lancamentoCalculo->setValor($valorCalc);

                                    $em->persist($lancamentoCalculo);

                                    $calculosCgm = $em->getRepository(CalculoCgm::class)->findOneByCodCalculo($pagamento->cod_calculo);

                                    $calculoCgm = new CalculoCgm();
                                    $calculoCgm->setCodCalculo($codCalculo);
                                    $calculoCgm->setNumcgm($calculosCgm->getNumcgm());

                                    $em->persist($calculoCgm);

                                    $imoveisCalculo = $em->getRepository(ImovelCalculo::class)->findOneByCodCalculo($pagamento->cod_calculo);

                                    if ($imoveisCalculo) {
                                        $imovelCalculo = new ImovelCalculo();
                                        $imovelCalculo->setCodCalculo($codCalculo);
                                        $imovelCalculo->setInscricaoMunicipal($imoveisCalculo->getInscricaoMunicipal());
                                        $imovelCalculo->setTimestamp($imoveisCalculo->getTimestamp());

                                        $em->persist($imovelCalculo);
                                    }

                                    $cadastrosEconomicoCalculo = $em->getRepository(CadastroEconomicoCalculo::class)->findOneByCodCalculo($pagamento->cod_calculo);
                                    if ($cadastrosEconomicoCalculo) {
                                        $cadastroEconomicoCalculo = new CadastroEconomicoCalculo();
                                        $cadastroEconomicoCalculo->setCodCalculo($codCalculo);
                                        $cadastroEconomicoCalculo->setInscricaoEconomica($cadastrosEconomicoCalculo->inscricao_economica);
                                        $cadastroEconomicoCalculo->setTimestamp($cadastrosEconomicoCalculo->timestamp);

                                        $em->persist($cadastroEconomicoCalculo);
                                    }


                                    $calculosGrupoCredito = $em->getRepository(CalculoGrupoCredito::class)->findOneByCodCalculo($pagamento->cod_calculo);
                                    if ($calculosGrupoCredito) {
                                        $calculoGrupoCredito = new CalculoGrupoCredito();
                                        $calculoGrupoCredito->setCodCalculo($codCalculo);
                                        $calculoGrupoCredito->setCodGrupo($calculosGrupoCredito->getCodGrupo());
                                        $calculoGrupoCredito->setAnoExercicio($calculosGrupoCredito->getAnoExercicio());

                                        $em->persist($calculoGrupoCredito);
                                    }
                                }
                            }

                            $carne = new Carne();
                            $funcaoNumeracao = $em->getRepository(Calculo::class)->getNumeracaoParaCompensacao($codCalculo);

                            if ($funcaoNumeracao) {
                                if (reset($funcaoNumeracao)->cod_carteira) {
                                    $sql = "SELECT ". strtolower(reset($funcaoNumeracao)->nom_funcao) ."('". reset($funcaoNumeracao)->cod_carteira ."', '". reset($funcaoNumeracao)->cod_convenio ."' ) AS numeracao";
                                    $numeracao = $em->getRepository(Calculo::class)
                                        ->getNumeracaoFromFunction(reset($funcaoNumeracao)->nom_funcao, reset($funcaoNumeracao)->cod_carteira, reset($funcaoNumeracao)->cod_convenio);
                                } else {
                                    $sql = "SELECT ". strtolower(reset($funcaoNumeracao)->nom_funcao) ."('', '". reset($funcaoNumeracao)->cod_convenio ."' ) AS numeracao";
                                    $numeracao = $em->getRepository(Calculo::class)
                                        ->getNumeracaoFromFunction(reset($funcaoNumeracao)->nom_funcao, false, reset($funcaoNumeracao)->cod_convenio);
                                }

                                $numeracao = reset($numeracao)->numeracao;

                                $parcelasNovas[] = [
                                    "numcgm" => $calculosCgm->getNumcgm(),
                                    "cod_lancamento" => $codLancamento,
                                    "cod_parcela" => $codParcela,
                                    "numeracao_sem_exercicio" => $numeracao,
                                    "exercicio" => date("Y"),
                                    "numeracao" => $numeracao ." / ". date("Y"),
                                    "parcela" => "1",
                                    "origem" => $parcelaParts[5],
                                    "vencimento" => date("d/m/Y"),
                                    "valor" => (($totalCalculo + $totalAcrescimos) - $valorPago )
                                ];

                                $carne->setCodParcela($codParcela);
                                $carne->setNumeracao($numeracao);
                                $carne->setCodConvenio(reset($funcaoNumeracao)->cod_convenio);
                                $carne->setCodCarteira(reset($funcaoNumeracao)->cod_carteira);
                                $carne->setExercicio(date("Y"));
                                $carne->setImpresso(false);

                                $em->persist($carne);
                            }
                        } else {
                            reset($pagamentosCompensacao);
                            foreach ($pagamentosCompensacao as $pagamento) {
                                $pagamentoCalculo = new PagamentoCalculo();
                                $pagamentoCalculo->setNumeracao($parcelaParts[0]);
                                $pagamentoCalculo->setCodCalculo($pagamento->cod_calculo);
                                $pagamentoCalculo->setOcorrenciaPagamento(1);
                                $pagamentoCalculo->setCodConvenio($parcelaParts[4]);
                                $pagamentoCalculo->setValor($pagamento->valor_calculo);

                                $em->persist($pagamentoCalculo);

                                if ($aplicaAcrescimos) {
                                    $pagamentoAcrescimo = new PagamentoAcrescimo();
                                    $pagamentoAcrescimo->setNumeracao($parcelaParts[0]);
                                    $pagamentoAcrescimo->setOcorrenciaPagamento(1);
                                    $pagamentoAcrescimo->setCodConvenio($parcelaParts[4]);
                                    $pagamentoAcrescimo->setCodCalculo($pagamento->cod_calculo);
                                    $pagamentoAcrescimo->setCodAcrescimo(3);
                                    $pagamentoAcrescimo->setCodTipo(1);
                                    $pagamentoAcrescimo->setValor($pagamento->correcao);

                                    $em->persist($pagamentoAcrescimo);

                                    $pagamentoAcrescimo = new PagamentoAcrescimo();
                                    $pagamentoAcrescimo->setNumeracao($parcelaParts[0]);
                                    $pagamentoAcrescimo->setOcorrenciaPagamento(1);
                                    $pagamentoAcrescimo->setCodConvenio($parcelaParts[4]);
                                    $pagamentoAcrescimo->setCodCalculo($pagamento->cod_calculo);
                                    $pagamentoAcrescimo->setCodAcrescimo(1);
                                    $pagamentoAcrescimo->setCodTipo(2);
                                    $pagamentoAcrescimo->setValor($pagamento->juro);

                                    $em->persist($pagamentoAcrescimo);

                                    $pagamentoAcrescimo = new PagamentoAcrescimo();
                                    $pagamentoAcrescimo->setNumeracao($parcelaParts[0]);
                                    $pagamentoAcrescimo->setOcorrenciaPagamento(1);
                                    $pagamentoAcrescimo->setCodConvenio($parcelaParts[4]);
                                    $pagamentoAcrescimo->setCodCalculo($pagamento->cod_calculo);
                                    $pagamentoAcrescimo->setCodAcrescimo(2);
                                    $pagamentoAcrescimo->setCodTipo(3);
                                    $pagamentoAcrescimo->setValor($pagamento->multa);

                                    $em->persist($pagamentoAcrescimo);
                                }
                            }
                        }

                        $session->set('parcelasNovas', $parcelasNovas);

                        //CONTROLA SE A PARCELA NA DIVIDA ESTA PAGA OU NAO (caso for parcela de dívida)
                        $carnes = $em->getRepository(Carne::class)->findOneBy(['numeracao' => $parcelaParts[0], 'codConvenio' => $parcelaParts[4]]);

                        if ($carnes) {
                            $parcelas = $em->getRepository(Parcela::class)->findOneByCodParcela($carnes->getCodParcela());
                            if ($parcelas) {
                                $lancamentosCalculo = $em->getRepository(LancamentoCalculo::class)->findOneByCodLancamento($parcelas->getCodLancamento());
                                if ($lancamentosCalculo) {
                                    $parcelasCalculo = $em->getRepository(ParcelaCalculo::class)->findOneBy(
                                        [
                                            'numParcela' => $parcelas->getNrParcela(),
                                            'codCalculo' => $lancamentosCalculo->getCodCalculo()
                                        ]
                                    );

                                    if ($parcelasCalculo) {
                                        $parcelasCalculo->setNumParcelamento($parcelasCalculo->getNumParcelamento());
                                        $parcelasCalculo->setNumParcela($parcelas->getNrParcela());
                                        $parcelasCalculo->setPaga(true);

                                        $em->persist($parcelasCalculo);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $em->flush();
            $em->getConnection()->commit();

            if ($emitirRelatorio) {
                $this->forceRedirect($this->generateUrl(
                    'emitir_relatorio',
                    [
                        'saldoDisponivel' => $saldoDisponivel,
                        'valorParcelasSelecionadas' => $valorParcelasSelecionadas,
                        'totalCompensacao' => $totalCompensacao,
                        'valorCompensar' => $valorCompensar,
                        'saldoRestante' => $saldoRestante,
                        'contribuinte' => $contribuinte
                    ]
                ));
            }
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
        }
    }
}
