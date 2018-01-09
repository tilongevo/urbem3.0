<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\DividaAtiva\CobrancaAdministrativa;

use DateInterval;
use DateTime;
use Doctrine\Common\Collections\Criteria;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Session\Session;
use Urbem\CoreBundle\Entity\Arrecadacao\Calculo;
use Urbem\CoreBundle\Entity\Arrecadacao\CalculoCgm;
use Urbem\CoreBundle\Entity\Arrecadacao\Carne;
use Urbem\CoreBundle\Entity\Arrecadacao\ImovelCalculo;
use Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal;
use Urbem\CoreBundle\Entity\Arrecadacao\Lancamento;
use Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo;
use Urbem\CoreBundle\Entity\Arrecadacao\Parcela as ArrecadacaoParcela;
use Urbem\CoreBundle\Entity\Divida\DividaAtiva;
use Urbem\CoreBundle\Entity\Divida\DividaImovel;
use Urbem\CoreBundle\Entity\Divida\DividaParcelamento;
use Urbem\CoreBundle\Entity\Divida\Documento;
use Urbem\CoreBundle\Entity\Divida\DocumentoParcela;
use Urbem\CoreBundle\Entity\Divida\EmissaoDocumento;
use Urbem\CoreBundle\Entity\Divida\Modalidade;
use Urbem\CoreBundle\Entity\Divida\Parcela as Parcela;
use Urbem\CoreBundle\Entity\Divida\ParcelaCalculo;
use Urbem\CoreBundle\Entity\Divida\ParcelaOrigem;
use Urbem\CoreBundle\Entity\Divida\ParcelaReducao;
use Urbem\CoreBundle\Entity\Divida\Parcelamento;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\TributarioBundle\Controller\DividaAtiva\CobrancaAdministrativa\CobrarDividaAtivaAdminController;
use Urbem\CoreBundle\Model\Administracao\AcaoModel;
use Sonata\CoreBundle\Validator\ErrorElement;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;

class CobrarDividaAtivaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_divida_ativa_cobranca_administrativa_cobrar_divida';
    protected $baseRoutePattern = 'tributario/divida-ativa/cobranca-administrativa/cobrar-divida-ativa';
    protected $includeJs = [
        '/tributario/javascripts/dividaAtiva/cobrancaAdministrativa/cobrar-divida-ativa.js'
    ];
    protected $maxPerPage = 20;
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoIncluir = false;
    protected $registroParcelas = [];
    protected $currentRegistro = [];
    protected $valorTotal = null;

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $filter = $this->getRequest()->query->get('filter');

        if (!$filter || (!$filter['fkSwCgm']['value'] &&
            !$filter['inscricaoMunicipalIni']['value'] && !$filter['inscricaoMunicipalEnd']['value'] &&
            !$filter['inscricaoEconomicaIni']['value'] && !$filter['inscricaoEconomicaEnd']['value'] &&
            !$filter['inscricaoAno']['value'])) {
            $query->andWhere('1 = 0');
            return $query;
        };

        $numcgm = ($filter['fkSwCgm']['value']) ?: false;
        $inscricaoImobiliariaIni = ($filter['inscricaoMunicipalIni']['value']) ?: false;
        $inscricaoImobiliariaEnd = ($filter['inscricaoMunicipalEnd']['value']) ?: false;
        $inscricaoEconomicaIni = ($filter['inscricaoEconomicaIni']['value']) ?: false;
        $inscricaoEconomicaEnd = ($filter['inscricaoEconomicaEnd']['value']) ?: false;
        $inscricaoAno = ($filter['inscricaoAno']['value']) ?: false;

        $inscricao = false;
        $exercicio = false;
        if ($inscricaoAno) {
            $inscricaoAno = explode('/', $inscricaoAno);
            $inscricao = $inscricaoAno[0];
            $exercicio = $inscricaoAno[1];
        }

        $cobrarDividaList = $em->getRepository('CoreBundle:Divida\DividaAtiva')
            ->getCobrarDividaList(
                $numcgm,
                $inscricaoImobiliariaIni,
                $inscricaoImobiliariaEnd,
                $inscricaoEconomicaIni,
                $inscricaoEconomicaEnd,
                $inscricao,
                $exercicio
            );

        $dividaAtiva = ['0'];
        foreach ((array) $cobrarDividaList as $item) {
            $dividaAtiva[] = sprintf('%d~%d', $item->cod_inscricao, $item->exercicio);
        }

        $query->Where($query->expr()->in('concat(o.codInscricao, \'~\', o.exercicio)', $dividaAtiva));
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->setBreadCrumb();

        $datagridMapper
            ->add(
                'fkSwCgm',
                'doctrine_orm_callback',
                [
                    'label' => 'label.tributarioCobrarDividaAtiva.cgm',
                    'callback' => [$this, 'getSearchFilter'],
                ],
                'autocomplete',
                [
                    'class' => SwCgm::class,
                    'route' => array(
                        'name' => 'api-search-swcgm-pessoa-fisica-numcgm-nomecgm'
                    ),
                    'mapped' => false,
                ]
            )
            ->add(
                'inscricaoMunicipalIni',
                'doctrine_orm_choice',
                [
                    'label' => 'label.tributarioCobrarDividaAtiva.inscricaoImobiliariaIni',
                ],
                null,
                [
                    'attr' => array(
                        'class' => 'js-inscricao-municipal-ini '
                    ),
                    'mapped' => false,
                ]
            )
            ->add(
                'inscricaoMunicipalEnd',
                'doctrine_orm_choice',
                [
                    'label' => 'label.tributarioCobrarDividaAtiva.inscricaoImobiliariaEnd',
                ],
                null,
                [
                    'attr' => array(
                        'class' => 'js-inscricao-municipal-end '
                    ),
                    'mapped' => false,
                ]
            )
            ->add(
                'inscricaoEconomicaIni',
                'doctrine_orm_choice',
                [
                    'label' => 'label.tributarioCobrarDividaAtiva.inscricaoEconomicaIni',
                ],
                null,
                [
                    'attr' => array(
                        'class' => 'js-inscricao-economica-ini '
                    ),
                    'mapped' => false,
                ]
            )
            ->add(
                'inscricaoEconomicaEnd',
                'doctrine_orm_choice',
                [
                    'label' => 'label.tributarioCobrarDividaAtiva.inscricaoEconomicaEnd',
                ],
                null,
                [
                    'attr' => array(
                        'class' => 'js-inscricao-economica-end '
                    ),
                    'mapped' => false,
                ]
            )
            ->add(
                'inscricaoAno',
                'doctrine_orm_callback',
                [
                    'callback' => array($this, 'getSearchFilter'),
                    'mapped' => false,
                    'label' => 'label.tributarioCobrarDividaAtiva.inscricaoAno'
                ]
            )
        ;
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
        if (empty($value['value'])) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        if (!$this->registroParcelas) {
            $this->setRegistroParcelas();
        }

        $listMapper
            ->add(
                'codInscricaoAno',
                'customField',
                [
                    'label' => 'label.tributarioCobrarDividaAtiva.inscricaoAno',
                    'template' => 'TributarioBundle::DividaAtiva/CobrancaAdministrativa/CobrarDividaAtiva/inscricaoAno.html.twig'
                ]
            )
            ->add(
                'creditoGrupoCredito',
                'customField',
                [
                    'label' => 'label.tributarioCobrarDividaAtiva.creditoGrupoCredito',
                    'template' => 'TributarioBundle::DividaAtiva/CobrancaAdministrativa/CobrarDividaAtiva/creditoGrupoCredito.html.twig'
                ]
            )
            ->add(
                'parcelas',
                'customField',
                [
                    'label' => 'label.tributarioCobrarDividaAtiva.parcelas',
                    'template' => 'TributarioBundle::DividaAtiva/CobrancaAdministrativa/CobrarDividaAtiva/parcelas.html.twig'
                ]
            )
            ->add(
                'valor',
                'customField',
                [
                    'label' => 'label.tributarioCobrarDividaAtiva.valor',
                    'template' => 'TributarioBundle::DividaAtiva/CobrancaAdministrativa/CobrarDividaAtiva/valor.html.twig'
                ]
            )
            ->add(
                'vencimento',
                'customField',
                [
                    'label' => 'label.tributarioCobrarDividaAtiva.vencimento',
                    'template' => 'TributarioBundle::DividaAtiva/CobrancaAdministrativa/CobrarDividaAtiva/vencimento.html.twig'
                ]
            )
        ;
    }

    /**
     * @return void
     */
    protected function setRegistroParcelas()
    {
        $filter = $this->getRequest()->query->get('filter');
        $em = $this->modelManager->getEntityManager($this->getClass());
        $repository = $em->getRepository('CoreBundle:Divida\DividaAtiva');
        $registroParcelas = $repository->getRegistroParcelas(
            $filter['fkSwCgm']['value'],
            $filter['inscricaoMunicipalIni']['value'],
            $filter['inscricaoMunicipalEnd']['value'],
            $filter['inscricaoEconomicaIni']['value'],
            $filter['inscricaoEconomicaEnd']['value'],
            $filter['inscricaoAno']['value']
        );

        $this->registroParcelas = $registroParcelas;
    }

    /**
     * @param $object
     * @return array | false
     */
    public function findRegistroParcelas($object)
    {
        $registroArray = [];
        foreach ($this->registroParcelas as $registro) {
            $registroArray = (array) $registro;

            if ($object->getCodInscricao() == $registroArray['cod_inscricao'] && $object->getExercicio() == $registroArray['exercicio']) {
                $this->currentRegistro = $registro;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function getCurrentRegistro()
    {
        return $this->currentRegistro;
    }

    /**
     * @return array
     */
    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        $actions['cobrar_divida'] = [
            'label'            => $this->trans('label.tributarioCobrarDividaAtiva.cobrarDivida', [], 'CoreBundle'),
            'ask_confirmation' => true
        ];

        return $actions;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());
        $session = $this->getRequest()->getSession();

        $modalidade = $this->request->get('modalidade');
        $parcelas = $this->request->get('parcelas');
        $dtVencimento = $this->request->get('dtVencimento');

        $pk = explode('~', $id);
        $dividaAtiva = $em->getRepository(DividaAtiva::class)->findOneBy(['exercicio' => $pk[0], 'codInscricao' => $pk[1]]);

        $cgm = null;
        if ($dividaAtiva->getFkDividaDividaCgns()) {
            $cgm = (string) $dividaAtiva->getFkDividaDividaCgns()->last()->getFkSwCgm();
        }

        $modalidadeDescription = null;
        if ($modalidade) {
            $modalidadeData = $em->getRepository(Modalidade::class)->findOneBycodModalidade($modalidade);
            $modalidadeDescription = sprintf('%d - %s', $modalidadeData->getCodModalidade(), $modalidadeData->getDescricao());
        }

        $inscricoesVinculadas = [];
        if ($session->get('dividasBatch')) {
            $dividasBatch = $session->get('dividasBatch');

            foreach ($dividasBatch as $key => $value) {
                $inscricoesVinculadas[] = $this->getInscricoesVinculadas($value);
            }
        }

        $formMapper
            ->with('label.tributarioCobrarDividaAtiva.dadosContribuinte')
                ->add(
                    'cgm',
                    'text',
                    [
                        'label' => 'label.tributarioEstornarCobranca.cgm',
                        'mapped' => false,
                        'data' => $cgm,
                        'attr' => [
                            'readonly' => true
                        ]
                    ],
                    [
                        'admin_code' => 'tributario.admin.cobrar_divida_ativa'
                    ]
                )
                ->add(
                    'modalidade',
                    'text',
                    [
                        'label' => 'label.tributarioEstornarCobranca.modalidade',
                        'mapped' => false,
                        'data' => $modalidadeDescription,
                        'attr' => [
                            'readonly' => true
                        ]
                    ]
                )
            ->end()
            ->with('label.tributarioCobrarDividaAtiva.inscricoesVinculadas')
                ->add(
                    'inscricoesVinculadas',
                    'customField',
                    [
                        'template' => 'TributarioBundle::DividaAtiva/CobrancaAdministrativa/CobrarDividaAtiva/inscricoesVinculadas.html.twig',
                        'mapped' => false,
                        'data' => [
                            'inscricoesVinculadas' => $inscricoesVinculadas
                        ],
                        'label' => false
                    ]
                )
            ->end()
            ->with('label.tributarioCobrarDividaAtiva.relatorioCobrancaDetalhado')
                ->add(
                    'cobrancas',
                    'customField',
                    [
                        'template' => 'TributarioBundle::DividaAtiva/CobrancaAdministrativa/CobrarDividaAtiva/relatorioCobrancaDetalhado.html.twig',
                        'mapped' => false,
                        'data' => [
                            'inscricoesVinculadas' => $inscricoesVinculadas
                        ],
                        'label' => false
                    ]
                )
            ->end()
            ->with('label.tributarioCobrarDividaAtiva.relatorioCobranca')
                ->add(
                    'parcelasPagamento',
                    'customField',
                    [
                        'template' => 'TributarioBundle::DividaAtiva/CobrancaAdministrativa/CobrarDividaAtiva/parcelasPagamento.html.twig',
                        'mapped' => false,
                        'data' => [
                            'inscricoesVinculadas' => $inscricoesVinculadas
                        ],
                        'label' => false
                    ]
                )
            ->end()
                ->with('')
                    ->add(
                        'emissao',
                        'customField',
                        [
                            'template' => 'TributarioBundle::DividaAtiva/CobrancaAdministrativa/CobrarDividaAtiva/emissao.html.twig',
                            'mapped' => false,
                            'data' => [],
                            'label' => false
                        ]
                    )
                    ->add(
                        'codModalidade',
                        'hidden',
                        [
                            'data' => $this->request->get('modalidade'),
                            'mapped' => false,
                        ]
                    )
                    ->add(
                        'dtVencimento',
                        'hidden',
                        [
                            'data' => $dtVencimento,
                            'mapped' => false,
                        ]
                    )
                    ->add(
                        'nrParcelas',
                        'hidden',
                        [
                            'data' => $parcelas,
                            'mapped' => false,
                        ]
                    )
                ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicio')
            ->add('codInscricao')
            ->add('codAutoridade')
            ->add('numcgmUsuario')
            ->add('dtInscricao')
            ->add('numLivro')
            ->add('numFolha')
            ->add('dtVencimentoOrigem')
            ->add('exercicioOriginal')
            ->add('exercicioLivro')
        ;
    }

    /**
     * @param mixed $object
     * @return Response | Exception
     */
    public function preUpdate($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();
        $dividaAtivaRepository = $em->getRepository(DividaAtiva::class);
        $form = $this->getForm();
        $session = $this->getRequest()->getSession();

        $emissao = $_REQUEST['emissao'];
        $modelo = $_REQUEST['modelo'];
        $checkEmitirDocumentos = isset($_REQUEST['emitir']);
        $codModalidade = $form->get('codModalidade')->getData();

        if ($emissao == 'impressaoLocal' && (!$modelo || $modelo == 'Selecione')) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.tributarioCobrarDividaAtiva.erroModeloVazio'));
            $this->forceRedirect($this->request->server->get('HTTP_REFERER'));
        }

        $dividasAtivas = $session->get('dividasBatch');

        $valorTotal = [];
        foreach ($dividasAtivas as $dividaAtiva) {
            $dividaParts = explode('~', $dividaAtiva);
            $creditoDescricao = $this->getCreditoDescricao($dividaParts[1], $dividaParts[0]);
            if ($creditoDescricao) {
                $creditoDescricao = array_shift($creditoDescricao);
                $valorTotal[] = $creditoDescricao->valor;
            }
        }

        $numParcelamento = $em->getRepository(Parcelamento::class)->getNextVal('num_parcelamento');
        $numeroParcelamento = $em->getRepository(Parcelamento::class)->getNextVal('num_parcelamento', ['exercicio' => $this->getExercicio()]);

        $codModalidade = $form->get('codModalidade')->getData();
        $dtVencimento = $form->get('dtVencimento')->getData();
        $dtVencimentoToDatetime = $this->convertToDateTime($dtVencimento);
        $numeroParcelas = $form->get('nrParcelas')->getData();
        $modalidade = $em->getRepository(Modalidade::class)->findOneByCodModalidade($codModalidade);

        $timestampModalidade = $modalidade->getUltimoTimestamp();
        $numcgm = $this->getCurrentUser();

        $em->getConnection()->beginTransaction();
        $em->getConnection()->setAutoCommit(false);

        try {
            $parcelamento = new Parcelamento();
            $parcelamento->setNumParcelamento($numParcelamento);
            $parcelamento->setNumcgmUsuario($numcgm->getNumcgm());
            $parcelamento->setTimestampModalidade($timestampModalidade);
            $parcelamento->setCodModalidade($codModalidade);
            $parcelamento->setNumeroParcelamento($numeroParcelamento);
            $parcelamento->setExercicio($this->getExercicio());
            $cobrancaJudicial = false;
            $parcelamento->setJudicial($cobrancaJudicial);
            $em->persist($parcelamento);
            $em->flush();

            $parcelas = [];
            $parcelasLast = [];

            $dividasBatch = $session->get('dividasBatch');
            foreach ($dividasBatch as $dividaBatch) {
                $divida = explode('~', $dividaBatch);
                $divida['exercicio'] = (string) $divida[0];
                $divida['cod_inscricao'] = $divida[1];
                $dividaParcelamento = new DividaParcelamento();
                $dividaParcelamento->setExercicio($divida['exercicio']);
                $dividaParcelamento->setCodInscricao($divida['cod_inscricao']);
                $dividaParcelamento->setNumParcelamento($numParcelamento);
                $em->persist($dividaParcelamento);
                $em->flush();

                $parcelas = $dividaAtivaRepository->getParcelasByInscricao($divida['cod_inscricao'], $divida['exercicio']);
                $parcelasLast[] = end($parcelas);
                foreach ((array) $parcelas as $parcela) {
                    $parcelaOrigem = new ParcelaOrigem();
                    $parcelaOrigem->setCodParcela($parcela->cod_parcela);
                    $parcelaOrigem->setCodEspecie($parcela->cod_especie);
                    $parcelaOrigem->setCodGenero($parcela->cod_genero);
                    $parcelaOrigem->setCodNatureza($parcela->cod_natureza);
                    $parcelaOrigem->setCodCredito($parcela->cod_credito);
                    $parcelaOrigem->setNumParcelamento($numParcelamento);
                    $parcelaOrigem->setValor($parcela->valor);
                    $em->persist($parcelaOrigem);
                    $em->flush();
                }
            }

            $lastLancamento = $em->getRepository(Lancamento::class)->getNextVal();

            $lancamento = new Lancamento();
            $lancamento->setCodLancamento($lastLancamento);
            $lancamento->setVencimento($dtVencimentoToDatetime);
            $lancamento->setTotalParcelas($numeroParcelas);
            $lancamento->setAtivo(true);
            $lancamento->setObservacao('');
            $lancamento->setObservacaoSistema('');
            $lancamento->setValor(array_sum($valorTotal));
            $lancamento->setDivida(true);
            $em->persist($lancamento);
            $em->flush();

            $lastCodCalculoList = [];
            $count = 0;
            foreach ($valorTotal as $total) {
                $parcela = $dividaAtivaRepository->getParcelasByInscricao($divida['cod_inscricao'], $divida['exercicio']);

                $lastCalculo = $em->getRepository(Calculo::class)->getCodCalculo();
                $lastCodCalculoList[] = $lastCalculo;

                $calculo = new Calculo();
                $calculo->setCodCalculo($lastCalculo);
                $calculo->setCodCredito($parcelasLast[$count]->cod_credito);
                $calculo->setCodNatureza($parcelasLast[$count]->cod_natureza);
                $calculo->setCodGenero($parcelasLast[$count]->cod_genero);
                $calculo->setCodEspecie($parcelasLast[$count]->cod_especie);
                $calculo->setExercicio($this->getExercicio());
                $calculo->setValor($total);
                $calculo->setNroParcelas($numeroParcelas);
                $calculo->setAtivo(true);
                $calculo->setCalculado(false);
                $em->persist($calculo);
                $em->flush();

                $numCgm = $object->getFkDividaDividaCgns()->last()->getNumcgm();

                $calculoCgm = new CalculoCgm();
                $calculoCgm->setCodCalculo($lastCalculo);
                $calculoCgm->setNumcgm($numCgm);
                $em->persist($calculoCgm);
                $em->flush();

                $lancamentoCalculo = new LancamentoCalculo();
                $lancamentoCalculo->setCodCalculo($lastCalculo);
                $lancamentoCalculo->setCodLancamento($lastLancamento);
                $lancamentoCalculo->setValor($total);
                $em->persist($lancamentoCalculo);
                $em->flush();

                $inscricaoMunicipal = $object->getFkDividaDividaImoveis()->last()->getInscricaoMunicipal();
                $imovelVVenal = $em->getRepository(ImovelVVenal::class)->findOneByInscricaoMunicipal($inscricaoMunicipal, ['timestamp' => 'DESC']);
                $imovelCalculo = new ImovelCalculo();
                $imovelCalculo->setCodCalculo($lastCalculo);
                $imovelCalculo->setInscricaoMunicipal($inscricaoMunicipal);
                $imovelCalculo->setTimestamp($imovelVVenal->getTimestamp());
                $em->persist($imovelCalculo);
                $em->flush();

                $count++;
            }

            $documentosModalidade = $dividaAtivaRepository->getDocumentos($codModalidade);
            foreach ((array) $documentosModalidade as $documentoModalidade) {
                $documento = new Documento();
                $documento->setNumParcelamento($numParcelamento);
                $documento->setCodTipoDocumento($documentoModalidade->cod_tipo_documento);
                $documento->setCodDocumento($documentoModalidade->cod_documento);
                $em->persist($documento);
            }
            $em->flush();

            $pagamentos = $this->getPagamentos($numeroParcelas, $dtVencimento, array_sum($valorTotal));
            $monetarioConvenio = $dividaAtivaRepository->getMonetarioConvenio();
            for ($i=0; $i < $numeroParcelas; $i++) {
                $numParcela = ($i+1);
                $codParcela = $em->getRepository(ArrecadacaoParcela::class)->getCodParcela();

                $arrecadacaoParcela = new ArrecadacaoParcela();
                $arrecadacaoParcela->setCodParcela($codParcela);
                $arrecadacaoParcela->setCodLancamento($lastLancamento);
                $arrecadacaoParcela->setNrParcela($numParcela);
                $arrecadacaoParcela->setVencimento($this->convertToDateTime($pagamentos[$i]['dtPagamento']));
                $arrecadacaoParcela->setValor($pagamentos[$i]['valor']);
                $em->persist($arrecadacaoParcela);

                $numeracaoDivida = $dividaAtivaRepository->getNumeracaoDivida();
                $carne = new Carne();
                $carne->setNumeracao($numeracaoDivida[0]->valor);
                $carne->setExercicio($this->getExercicio());
                $carne->setCodParcela($codParcela);
                $carne->setCodConvenio($monetarioConvenio[0]->cod_convenio);
                $impresso = ($this->request->get('emissao')!='naoEmitir') ? true : false;
                $carne->setImpresso($impresso);
                $em->persist($carne);

                $dividaParcela = new Parcela();
                $dividaParcela->setNumParcelamento($numParcelamento);
                $dividaParcela->setNumParcela($numParcela);
                $dividaParcela->setVlrParcela($pagamentos[$i]['valor']);
                $dividaParcela->setDtVencimentoParcela($this->convertToDateTime($pagamentos[$i]['dtPagamento']));
                $dividaParcela->setPaga(false);
                $dividaParcela->setCancelada(false);
                $em->persist($dividaParcela);

                $em->flush();

                foreach ((array) $documentosModalidade as $documentoModalidade) {
                    $documentoParcela = new DocumentoParcela();
                    $documentoParcela->setNumParcelamento($numParcelamento);
                    $documentoParcela->setCodTipoDocumento($documentoModalidade->cod_tipo_documento);
                    $documentoParcela->setCodDocumento($documentoModalidade->cod_documento);
                    $documentoParcela->setNumParcela($numParcela);
                    $em->persist($documentoParcela);
                }
                $em->flush();

                foreach ($lastCodCalculoList as $lastCalculo) {
                    $parcelaCalculo = new ParcelaCalculo();
                    $parcelaCalculo->setNumParcelamento($numParcelamento);
                    $parcelaCalculo->setNumParcela($numParcela);
                    $parcelaCalculo->setCodCalculo($lastCalculo);
                    $parcelaCalculo->setVlCredito($pagamentos[$i]['valor']);
                    $em->persist($parcelaCalculo);
                }
                $em->flush();
            }

            $emitirCarne = false;
            if ($emissao == 'impressaoLocal' && $this->isModeloInModelos($modelo)) {
                $emitirCarne = true;
            }

            if ($checkEmitirDocumentos || $emitirCarne) {
                $firstDividaAtiva = reset($dividasBatch);
                $dividaAtivaPart = explode('~', $firstDividaAtiva);
                $exercicio = $dividaAtivaPart[0];

                foreach ((array) $documentosModalidade as $documentoModalidade) {
                    $lastEmissaoDocumento = $dividaAtivaRepository
                        ->getEmissaoDocumento($documentoModalidade->cod_documento, $documentoModalidade->cod_tipo_documento, $exercicio);

                    $numDocumento = 1;
                    $numEmissao = 1;

                    if ($lastEmissaoDocumento) {
                        $numDocumento = ($lastEmissaoDocumento[0]->num_documento + 1);
                    }

                    $emissaoDocumento = new EmissaoDocumento();
                    $emissaoDocumento->setNumParcelamento($numParcelamento);
                    $emissaoDocumento->setNumEmissao($numEmissao);
                    $emissaoDocumento->setCodTipoDocumento($documentoModalidade->cod_tipo_documento);
                    $emissaoDocumento->setCodDocumento($documentoModalidade->cod_documento);
                    $emissaoDocumento->setNumDocumento($numDocumento);
                    $emissaoDocumento->setExercicio($exercicio);
                    $emissaoDocumento->setNumcgmUsuario($numcgm->getNumcgm());

                    $em->persist($emissaoDocumento);
                }

                $em->flush();
                $em->getConnection()->commit();

                $this->redirectByRoute(
                    'urbem_tributario_divida_ativa_cobranca_administrativa_cobrar_divida_emitir_documento',
                    [
                        'codModalidade' => $codModalidade,
                        'emitirDocumentos' => $checkEmitirDocumentos,
                        'emitirCarne' => $emitirCarne,
                        'lancamento' => $lastLancamento,
                        'modelo' => $modelo
                    ]
                );
            }

            $em->getConnection()->commit();

            $this->redirectByRoute(
                'urbem_tributario_divida_ativa_cobranca_administrativa_cobrar_divida_list'
            );
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            $this->forceRedirect($this->generateUrl('list'));
        }
    }

    /**
     * @param $codModalidade
     * @return int | false
     */
    public function getNumParcelas($codModalidade)
    {

        $em = $this->modelManager->getEntityManager($this->getClass());
        $modalidade = $em->getRepository(Modalidade::class)
            ->findOneByCodModalidade($codModalidade);

        if (!$modalidade) {
            return false;
        }

        $modalidadeVigencia = $modalidade->getFkDividaModalidadeVigencias();

        $criteria = Criteria::create()
            ->where(Criteria::expr()->lte('vigenciaInicial', new DateTime()))
            ->andWhere(Criteria::expr()->gte('vigenciaFinal', new DateTime()))
        ;

        $modalidadeVigenciaCriteria = $modalidadeVigencia->matching($criteria);

        $modalidadeParcela = $modalidadeVigenciaCriteria->last()->getFkDividaModalidadeParcelas()->last();

        if (!$modalidadeParcela) {
            return false;
        }

        return $modalidadeParcela->getQtdParcela();
    }

    /**
     * @param string
     * @return Datetime
     */
    protected function convertToDateTime($dateString)
    {
        $dateParts = explode('/', $dateString);
        $date = new Datetime($dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0]);
        return $date;
    }

    /**
     * @param int
     * @return array
     */
    public function getDocumentos($codModalidade)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $documentosModalidade = $em->getRepository(DividaAtiva::class)->getDocumentos($codModalidade);

        return $documentosModalidade;
    }

    /**
     * @return array
     */
    public function getModelos()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $modelos = $em->getRepository(DividaAtiva::class)->getModelos(AcaoModel::COBRAR_DIVIDA_ATIVA);

        return $modelos;
    }

    /**
     * @param int
     * @return void
     */
    public function setSubtotal($subtotal)
    {
        $this->valorTotal = $subtotal;
    }

    /**
     * @param int
     * @param string
     * @return array
     */
    public function getPagamentos($parcelas = false, $dtVencimento = false, $valorTotal = false)
    {
        $parcelas = (int) ($parcelas) ?: $this->request->get('parcelas');
        $dataPagamento = explode('/', (($dtVencimento) ?: $this->request->get('dtVencimento')));
        $dataPagamento = sprintf('%d-%d-%d', $dataPagamento[2], $dataPagamento[1], $dataPagamento[0]);
        $dataPagamento = new DateTime($dataPagamento);
        $valorParcelas = $this->makeParcelamento((($valorTotal) ?: $this->valorTotal), $parcelas);

        $pagamentos = [];
        for ($i=0; $i < $parcelas; $i++) {
            $dtPagamento = $this->addMonthToDate($dataPagamento, $i);
            $pagamentos[] = [
                'parcela' => $i+1,
                'dtPagamento' => $dtPagamento->format('d/m/Y'),
                'valor' => $valorParcelas[$i]
            ];
        }

        return $pagamentos;
    }

    /**
     * @param DateTime
     * @param int
     * @return DateTime
     */
    protected function addMonthToDate(DateTime $dataPagamento, $month)
    {
        $dtPagamento = clone $dataPagamento;
        if ($month < 1) {
            return $dtPagamento;
        }

        $interval = sprintf('P%dM', $month);
        $dtPagamento->add(new DateInterval($interval));

        if (!$this->isWorkDay($dtPagamento)) {
            $dtPagamento->add(new DateInterval('P1D'));
            $this->addMonthToDate($dtPagamento, $month);
        }

        return $dtPagamento;
    }

    /**
     * @param DateTime
     * @return bool
     */
    protected function isWorkDay(DateTime $date)
    {
        return !(in_array($date->format('N'), [6,7]));
    }

    /**
     * @param int
     * @param int
     * @return array
     */
    protected function makeParcelamento($valorTotal = false, $parcelas = false)
    {
        $valor = ($valorTotal) ?: $this->valorTotal;
        $qtdParcelas = (int) ($parcelas) ?: $this->request->get('parcelas');
        $valorParcelaRound = round($valor/$qtdParcelas);
        $diferenca = ($valor - ($valorParcelaRound * $qtdParcelas));
        $ultimaParcela = $valorParcelaRound + $diferenca;

        $parcelas = [];
        for ($i=1; $i < $qtdParcelas; $i++) {
            $parcelas[] = $valorParcelaRound;
        }

        $parcelas[] = $ultimaParcela;

        return $parcelas;
    }

    /**
     * @param string
     * @param string
     * @param int
     * @return array | false
     */
    public function getTaxas($inscricao, $ano, $valor, $dtVencimento)
    {
        $dtPagamento = explode('/', $this->request->get('dtVencimento'));
        $dtPagamento = sprintf('%s-%s-%s', $dtPagamento[2], $dtPagamento[1], $dtPagamento[0]);
        $em = $this->modelManager->getEntityManager($this->getClass());
        $creditos = $em->getRepository(DividaAtiva::class)->getTaxas($inscricao, $ano, $valor, $dtVencimento, $dtPagamento);

        if ($creditos) {
            return array_shift($creditos);
        }

        return false;
    }

    /**
     * @param string
     * @param string
     * @return array
     */
    public function getCreditoDescricao($inscricao, $exercicio)
    {
        $inscricaoAno = sprintf('%d/%d', $inscricao, $exercicio);
        $em = $this->modelManager->getEntityManager($this->getClass());
        $creditos = $em->getRepository(DividaAtiva::class)->getRegistroParcelas(null, null, null, null, null, $inscricaoAno, false);

        if ($creditos) {
            return $creditos;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getModalidades()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $repository = $em->getRepository('CoreBundle:Divida\DividaAtiva');
        $modalidades = $repository->getModalidades();

        if (!$modalidades) {
            return false;
        }

        $modalidadesList = [];
        foreach ($modalidades as $modalidade) {
            $modalidadesList[] = [
                'cod_modalidade' => $modalidade->cod_modalidade,
                'descricao' => $modalidade->descricao
            ];
        }

        return $modalidadesList;
    }

    /**
     * @param int
     * @return string | false
     */
    public function getDescricaoModalidade($codModalidade)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $modalidade = $em->getRepository('CoreBundle:Divida\Modalidade')->findOneByCodModalidade($codModalidade);

        if (!$modalidade) {
            return false;
        }

        return $modalidade->getDescricao();
    }

    /**
     * @param string
     * @param string
     * @return array
     */
    public function getCgmByDividaAtiva($inscricao, $exercicio)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $dividaAtiva = $em->getRepository(DividaAtiva::class)->findOneBy(['exercicio' => $exercicio, 'codInscricao' => $inscricao]);

        $cgm = false;
        if ($dividaAtiva->getFkDividaDividaCgns()) {
            $cgm = $dividaAtiva->getFkDividaDividaCgns()->last()->getFkSwCgm();
        }

        return $cgm;
    }

    /**
     * @param string
     * @param string
     * @return string
     */
    public function getCgmAddress($inscricao, $exercicio)
    {
        $address = $this->getCgmByDividaAtiva($inscricao, $exercicio);

        $addressComplete = null;
        if ($address) {
            $addressComplete = sprintf('Rua %s, %s - CEP %s', ucwords($address->getLogradouro()), ucwords($address->getBairro()), $address->getCep());
        }

        return $addressComplete;
    }

    /**
     *  @param string
     *  @return array
     */
    public function getInscricoesVinculadas($anoInscricao)
    {
        $param = explode('~', $anoInscricao);
        $em = $this->modelManager->getEntityManager($this->getClass());
        $inscricoesVinculadas = $em->getRepository(DividaAtiva::class)->getInscricoesVinculadas($param[1], $param[0]);

        if ($inscricoesVinculadas) {
            return array_shift($inscricoesVinculadas);
        }
    }

    /**
     *  @param string
     *  @param string
     *  @return string | false
     */
    public function getInscricaoMunicipal($inscricao, $ano)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $inscricao = $em->getRepository(DividaImovel::class)->findOneBy(['exercicio' => $ano, 'codInscricao' => $inscricao]);

        if ($inscricao) {
            return $inscricao->getInscricaoMunicipal();
        }

        return false;
    }

    /**
     *  @param $inscricaoAno
     *  @return array | false
     */
    public function getComplementar($inscricaoAno)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $inscricao = $em->getRepository(DividaAtiva::class)->getRegistroParcelas(null, null, null, null, null, $inscricaoAno);

        if ($inscricao) {
            return $inscricao;
        }

        return false;
    }

    /**
     *  @param $codModalidade
     *  @param $inscricao
     *  @param $valor
     *  @param $codAcrescimo
     *  @param $codTipo
     *  @param $dtVencimento
     *  @param $qtdParcelas
     *  @return array | false
     */
    public function getReducaoModalidadeAcrescimo($codModalidade, $inscricao, $valor, $codAcrescimo, $codTipo, $dtVencimento, $qtdParcelas)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $reducao = $em->getRepository(DividaAtiva::class)->getReducaoModalidadeAcrescimo($codModalidade, $inscricao, $valor, $codAcrescimo, $codTipo, $dtVencimento, $qtdParcelas);

        if ($reducao) {
            return (int) reset($reducao)->valor;
        }

        return false;
    }

    /**
     *  @param $codModalidade
     *  @return array | false
     */
    public function getListaAcrescimosDaModalidade($codModalidade)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $acrescimosModalidade = $em->getRepository(DividaAtiva::class)->getListaAcrescimosDaModalidade($codModalidade);

        if ($acrescimosModalidade) {
            return $acrescimosModalidade;
        }

        return false;
    }

    /**
     *  @param $listaAcrescimo
     *  @param $descricao
     *  @return int
     */
    public function getKeyAcrescimoByDescricao(array $listaAcrescimo, $descricao)
    {
        foreach ($listaAcrescimo as $key => $value) {
            if (array_search($descricao, $value)) {
                return $key;
            }
        }
    }

    /*
     * @param exercicio
     * @param valorDocumento
     * @param dataVencimento
     * @param nossoNumero
     * @return string
     */
    public function generateBarCode($exercicio, $valorDocumento, \DateTime $dataVencimento, $nossoNumero)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $febraban = $em->getRepository(Configuracao::class)->findOneBy(['parametro' => 'FEBRABAN', 'exercicio' => $exercicio]);
        $codFebraban = str_pad($febraban->getValor(), 4, 0, STR_PAD_LEFT);
        $nossoNumero = str_pad(substr($nossoNumero, 0, strlen($nossoNumero)), 17, 0, STR_PAD_LEFT);
        $tipoMoeda = 6;
        $vencimento = $dataVencimento->format('yyyymmdd');
        $valorDocumento = str_replace('.', '', $valorDocumento);

        $dGeral = $this->modulo10('81' . $tipoMoeda . str_pad($valorDocumento, 11, 0, STR_PAD_LEFT) . $codFebraban . $vencimento .$nossoNumero);
        $linha = '81' . $tipoMoeda . $dGeral . $valorDocumento . $codFebraban . $vencimento . $nossoNumero;

        $linhaFebraban = substr($linha, 0, 11).' '.
                         $this->modulo10(substr($linha, 0, 11)).' '.
                         substr($linha, 11, 11).' '.
                         $this->modulo10(substr($linha, 11, 11)).' '.
                         substr($linha, 22, 11).' '.
                         $this->modulo10(substr($linha, 22, 11)).' '.
                         substr($linha, 33, 11).' '.
                         $this->modulo10(substr($linha, 33, 11));

        $barcode = new BarcodeGenerator();
        $barcode->setText($linha);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setScale(1);
        $barcode->setThickness(60);
        $barcode->setFontSize(10);
        $code = $barcode->generate();

        return $code;
    }

    /*
     * @param codModelo
     * @return Bool
     */
    protected function isModeloInModelos($codModelo)
    {
        foreach ((array) $this->getModelos() as $modelo) {
            if ($modelo->cod_modelo == $codModelo) {
                return true;
            }
        }
        return false;
    }

    /*
     * Retorna o digito verificador padrao febraban
     * @param String $codigo
     * @return Integer $dac
     */
    protected function modulo10($codigo)
    {
        $soma  = 0;
        $acc   = 0;
        $resto = 0;
        $dac   = 0;

        $len = strlen($codigo);

        for ($i = 0; $i < $len; $i++) {
            if ($i % 2 == 0) {
                $acc .= $codigo[$i] * 2;
            } else {
                $acc .= $codigo[$i] * 1;
            }
        }

        for ($i = 0; $i < strlen($acc); $i++) {
            $soma += $acc[$i];
        }

        $resto = $soma % 10;

        if ($resto == 0) {
            $dac = 0;
        } else {
            $dac = 10 - $resto;
        }

        return $dac;
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('simulacao', 'simulacao');
        $collection->add('download_documento', 'download-documento');
        $collection->add('emitir_documento', 'emitir-documento');
        $collection->add('download_carne', 'download-carne');
        $collection->add('carrega_num_parcelas_ajax', 'carrega-parcelas', array(), array(), array(), '', array(), array('POST'));
        $collection->clearExcept(
            [
                'list',
                'edit',
                'batch',
                'simulacao',
                'download_documento',
                'emitir_documento',
                'carrega_num_parcelas_ajax',
                'download_carne'
            ]
        );
    }
}
