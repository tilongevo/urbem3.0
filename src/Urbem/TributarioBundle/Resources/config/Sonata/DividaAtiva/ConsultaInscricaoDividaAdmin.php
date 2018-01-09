<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\DividaAtiva;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Divida\ConsultaInscricaoDividaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConsultaInscricaoDividaAdmin extends AbstractSonataAdmin
{
    const SHOW_ACTION_DOCUMENTO = 'documento';
    const SHOW_ACTION_DETALHE = 'detalhe';

    public $showAction;

    protected $baseRouteName = 'urbem_tributario_divida_ativa_inscricao_divida_consulta';
    protected $baseRoutePattern = 'tributario/divida-ativa/inscricao-divida/consulta';
    protected $includeJs = ['/tributario/javascripts/dividaAtiva/consulta/inscricao-divida-consulta.js'];
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoSalvar = false;
    protected $exibirMensagemFiltro = true;

    /**
     * @param RouteCollection $routes
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add(
            'detalhe',
            sprintf('%s/detalhe', $this->getRouterIdParameter())
        );
        $routes->add(
            'documento',
            sprintf('%s/documento', $this->getRouterIdParameter())
        );

        $routes->add(
            'relatorio',
            sprintf('%s/relatorio', $this->getRouterIdParameter())
        );

        $routes->add('autocomplete_inscricao', 'autocomplete-inscricao');

        $routes->clearExcept(
            [
                'list',
                'detalhe',
                'documento',
                'relatorio',
                'autocomplete_inscricao'
            ]
        );
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getLoteDeSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $qb->join(sprintf('%s.fkDividaDividaImoveis', $alias), 'lotedf');
        $qb->join('lotedf.fkImobiliarioImovel', 'lotei');
        $qb->join('lotei.fkImobiliarioImovelLotes', 'loteil');
        $qb->join('loteil.fkImobiliarioLote', 'lotel');

        $qb->andWhere('lotel.codLote = :codLote');
        $qb->setParameter('codLote', $value['value']);

        return true;
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getLoteAteSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $qb->join(sprintf('%s.fkDividaDividaImoveis', $alias), 'lotelf');
        $qb->join('lotelf.fkImobiliarioImovel', 'loteli');
        $qb->join('loteli.fkImobiliarioImovelLotes', 'lotelil');
        $qb->join('lotelil.fkImobiliarioLote', 'lotell');

        $qb->andWhere('lotell.codLote = :codLote');
        $qb->setParameter('codLote', $value['value']);

        return true;
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getLocalizacaoDeSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $qb->join(sprintf('%s.fkDividaDividaImoveis', $alias), 'localizacaodf');
        $qb->join('localizacaodf.fkImobiliarioImovel', 'localizacaoi');
        $qb->join('localizacaoi.fkImobiliarioImovelLotes', 'localizacaoil');
        $qb->join('localizacaoil.fkImobiliarioLote', 'localizacaol');
        $qb->join('localizacaol.fkImobiliarioLoteLocalizacao', 'localizacaoll');

        $qb->andWhere('localizacaoll.codLocalizacao = :codLocalizacao');
        $qb->setParameter('codLocalizacao', $value['value']);

        return true;
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getLocalizacaoAteSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $qb->join(sprintf('%s.fkDividaDividaImoveis', $alias), 'localizacaodf');
        $qb->join('localizacaodf.fkImobiliarioImovel', 'localizacaoi');
        $qb->join('localizacaoi.fkImobiliarioImovelLotes', 'localizacaoil');
        $qb->join('localizacaoil.fkImobiliarioLote', 'localizacaol');
        $qb->join('localizacaol.fkImobiliarioLoteLocalizacao', 'localizacaoll');

        $qb->andWhere('localizacaoll.codLocalizacao = :codLocalizacao');
        $qb->setParameter('codLocalizacao', $value['value']);

        return true;
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (empty($value['value'])) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $inscricaoDividaList = (new ConsultaInscricaoDividaModel($entityManager))
            ->getListaInscricaoDivida($filter);

        $ids = array();

        if (!$inscricaoDividaList) {
            return true;
        }

        foreach ($inscricaoDividaList as $codInscricao) {
            $ids[] = $codInscricao->cod_inscricao;
        }

        if (count($inscricaoDividaList) > 0) {
            $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.codInscricao", $ids));
        } else {
            $queryBuilder->andWhere('1 = 0');
        }

        return true;
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere('1 = 0');
        }
        return $query;
    }

    /**
     * @param $dividaAtiva
     * @return mixed
     */
    public function getDadosDividaAtiva($dividaAtiva)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        return  (new ConsultaInscricaoDividaModel($entityManager))
            ->getDadosDividaAtiva($dividaAtiva);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codInscricaoAno',
                'doctrine_orm_callback',
                [
                    'mapped' => false,
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.dividaAtivaConsultaInscricao.inscricaoAno'
                ],
                'autocomplete',
                [
                    'route' => [
                        'name' => 'urbem_tributario_divida_ativa_inscricao_divida_consulta_autocomplete_inscricao'
                    ]
                ]
            )
            ->add(
                'numLivroDe',
                'doctrine_orm_callback',
                [
                    'callback' => array($this, 'getSearchFilter'),
                    'mapped' => false,
                    'label' => 'label.dividaAtivaConsultaInscricao.livroDe'
                ]
            )
            ->add(
                'numLivroAte',
                'doctrine_orm_callback',
                [
                    'mapped' => false,
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.dividaAtivaConsultaInscricao.livroAte'
                ]
            )
            ->add(
                'numFolhaDe',
                'doctrine_orm_callback',
                [
                    'mapped' => false,
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.dividaAtivaConsultaInscricao.folhaDe'
                ]
            )
            ->add(
                'numFolhaAte',
                'doctrine_orm_callback',
                [
                    'mapped' => false,
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.dividaAtivaConsultaInscricao.folhaAte'
                ]
            )
            ->add(
                'cobrancaAno',
                'doctrine_orm_callback',
                [
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.dividaAtivaConsultaInscricao.cobrancaAno'
                ]
            )
            ->add(
                'fkSwCgm',
                'doctrine_orm_callback',
                [
                    'mapped' => false,
                    'label' => 'label.dividaAtivaConsultaInscricao.contribuinte',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'autocomplete',
                [
                    'class' => SwCgm::class,
                    'route' => array(
                        'name' => 'api-search-swcgm-pessoa-fisica-numcgm-nomecgm'
                    )
                ]
            )
            ->add(
                'codLocalizacaoDe',
                'doctrine_orm_callback',
                [
                    'label' => 'label.dividaAtivaConsultaInscricao.localizacaoDe',
                    'callback' => array($this, 'getLocalizacaoDeSearchFilter')
                ],
                'autocomplete',
                [
                    'class' => Localizacao::class,
                    'mapped' => false,
                    'route' => [
                        'name' => 'urbem_tributario_imobiliario_localizacao_autocomplete_localizacao'
                    ],

                ]
            )
            ->add(
                'codLoteDe',
                'doctrine_orm_callback',
                [
                    'mapped' => false,
                    'label' => 'label.dividaAtivaConsultaInscricao.loteDe',
                    'callback' => array($this, 'getLoteDeSearchFilter')
                ],
                'autocomplete',
                [
                    'class' => Lote::class,
                    'route' => [
                        'name' => 'urbem_tributario_imobiliario_consultas_cadastro_imobiliario_autocomplete_lote'
                    ],
                    'req_params' => [
                        'codLocalizacao' => 'varJsCodLocalizacaoDe',
                    ],
                ]
            )
            ->add(
                'inscricaoMunicipalDe',
                'doctrine_orm_callback',
                [
                    'mapped' => false,
                    'label' => 'label.dividaAtivaConsultaInscricao.inscricaoImobiliariaDe',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'autocomplete',
                [
                    'class' => Imovel::class,
                    'route' => [
                        'name' => 'urbem_tributario_imobiliario_consultas_cadastro_imobiliario_autocomplete_imovel'
                    ],
                    'req_params' => [
                        'codLocalizacao' => 'varJsCodLocalizacaoDe',
                        'codLote' => 'varJsCodLoteDe'
                    ]
                ]
            )
            ->add(
                'codLocalizacaoAte',
                'doctrine_orm_callback',
                [
                    'mapped' => false,
                    'label' => 'label.dividaAtivaConsultaInscricao.localizacaoAte',
                    'callback' => array($this, 'getLocalizacaoAteSearchFilter')
                ],
                'autocomplete',
                [
                    'class' => Localizacao::class,
                    'route' => [
                        'name' => 'urbem_tributario_imobiliario_localizacao_autocomplete_localizacao'
                    ]
                ]
            )
            ->add(
                'codLoteAte',
                'doctrine_orm_callback',
                [
                    'mapped' => false,
                    'label' => 'label.dividaAtivaConsultaInscricao.loteAte',
                    'callback' => array($this, 'getLoteAteSearchFilter')
                ],
                'autocomplete',
                [
                    'class' => Lote::class,
                    'route' => [
                        'name' => 'urbem_tributario_imobiliario_consultas_cadastro_imobiliario_autocomplete_lote'
                    ],
                    'req_params' => [
                        'codLocalizacao' => 'varJsCodLocalizacaoAte',
                    ],
                ]
            )
            ->add(
                'inscricaoMunicipalAte',
                'doctrine_orm_callback',
                [
                    'mapped' => false,
                    'label' => 'label.dividaAtivaConsultaInscricao.inscricaoImobiliariaAte',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'autocomplete',
                [
                    'class' => Imovel::class,
                    'route' => [
                        'name' => 'urbem_tributario_imobiliario_consultas_cadastro_imobiliario_autocomplete_imovel'
                    ],
                    'req_params' => [
                        'codLocalizacao' => 'varJsCodLocalizacaoAte',
                        'codLote' => 'varJsCodLoteAte'
                    ]
                ]
            )
            ->add(
                'inscricaoEconomicaDe',
                'doctrine_orm_callback',
                array(
                    'mapped' => false,
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.dividaAtivaConsultaInscricao.inscricaoEconomicaDe'
                )
            )
            ->add(
                'inscricaoEconomicaAte',
                'doctrine_orm_callback',
                array(
                    'mapped' => false,
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.dividaAtivaConsultaInscricao.inscricaoEconomicaAte'
                )
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'exercicio',
                'customField',
                [
                    'label' => 'label.dividaAtivaConsultaInscricao.inscricaoAno',
                    'mapped' => false,
                    'template' => 'TributarioBundle:DividaAtiva\ConsultaInscricaoDivida:inscricaoAno.html.twig',
                ]
            )
            ->add(
                'numLivro',
                'customField',
                [
                    'label' => 'label.dividaAtivaConsultaInscricao.livroFolha',
                    'mapped' => false,
                    'template' => 'TributarioBundle:DividaAtiva\ConsultaInscricaoDivida:livroFolha.html.twig'
                ]
            )
            ->add(
                'cobrancaAno',
                'customField',
                [
                    'label' => 'label.dividaAtivaConsultaInscricao.cobrancaAno',
                    'mapped' => false,
                    'template' => 'TributarioBundle:DividaAtiva\ConsultaInscricaoDivida:cobrancaAno.html.twig'
                ]
            )
            ->add(
                'numcgmUsuario',
                'customField',
                [
                    'label' => 'label.dividaAtivaConsultaInscricao.contribuinte',
                    'mapped' => false,
                    'template' => 'TributarioBundle:DividaAtiva\ConsultaInscricaoDivida:contribuinte.html.twig'
                ]
            )
            ->add(
                'origem',
                'customField',
                [
                    'label' => 'label.dividaAtivaConsultaInscricao.origem',
                    'mapped' => false,
                    'template' => 'TributarioBundle:DividaAtiva\ConsultaInscricaoDivida:origem.html.twig'
                ]
            )
            ->add(
                'modalidade',
                'customField',
                [
                    'label' => 'label.dividaAtivaConsultaInscricao.origem',
                    'mapped' => false,
                    'template' => 'TributarioBundle:DividaAtiva\ConsultaInscricaoDivida:modalidade.html.twig'
                ]
            )
            ->add(
                'situacao',
                'customField',
                [
                    'label' => 'label.dividaAtivaConsultaInscricao.situacao',
                    'mapped' => false,
                    'template' => 'TributarioBundle:DividaAtiva\ConsultaInscricaoDivida:situacao.html.twig'
                ]
            )
            ->add(
                '_action',
                'actions',
                [
                    'actions' => array(
                        'consulta' => array('template' => 'TributarioBundle:DividaAtiva/ConsultaInscricaoDivida:list__action_consulta.html.twig')
                    )
                ]
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function showDetalhe(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $fieldOptions['numcgmUsuario'] = [
            'template' => 'TributarioBundle::DividaAtiva/ConsultaInscricaoDivida/inscricao_divida_show.html.twig'
        ];

        $fieldOptions['listaLancamentos'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::DividaAtiva/ConsultaInscricaoDivida/lista_lancamentos_show.html.twig',
        ];

        $fieldOptions['listaCobrancas'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::DividaAtiva/ConsultaInscricaoDivida/lista_cobrancas_show.html.twig',
        ];

        $showMapper
            ->with('label.dividaAtivaConsultaInscricao.dados')
            ->add('inscricaoDivida', 'customField', $fieldOptions['numcgmUsuario'])
            ->end()
            ->with('label.dividaAtivaConsultaInscricao.lancamentos.cabecalhoLista')
            ->add('listaLancamentos', 'customField', $fieldOptions['listaLancamentos'])
            ->end()
            ->with('label.dividaAtivaConsultaInscricao.cobrancas.cabecalhoLista')
            ->add('listaCobrancas', 'customField', $fieldOptions['listaCobrancas'])
            ->end();
    }

    protected function showDocumento(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $fieldOptions['numcgmUsuario'] = [
            'template' => 'TributarioBundle::DividaAtiva/ConsultaInscricaoDivida/inscricao_divida_show.html.twig'
        ];

        $fieldOptions['listaDocumentosInscricao'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::DividaAtiva/ConsultaInscricaoDivida/lista_documentos_inscricao_show.html.twig',
        ];

        $fieldOptions['listaCobrancas'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::DividaAtiva/ConsultaInscricaoDivida/lista_cobrancas_show.html.twig',
        ];

        $fieldOptions['listaDocumentosCobrancas'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::DividaAtiva/ConsultaInscricaoDivida/lista_documentos_cobranca_show.html.twig',
        ];

        $showMapper
            ->with('label.dividaAtivaConsultaInscricao.dados')
            ->add('inscricaoDivida', 'customField', $fieldOptions['numcgmUsuario'])
            ->end()
            ->with('label.dividaAtivaConsultaInscricao.documentos.cabecalhoListaInscricao')
            ->add('listaDocumentosInscricao', 'customField', $fieldOptions['listaDocumentosInscricao'])
            ->end()
            ->with('label.dividaAtivaConsultaInscricao.cobrancas.cabecalhoLista')
            ->add('listaCobrancas', 'customField', $fieldOptions['listaCobrancas'])
            ->end()
            ->with('label.dividaAtivaConsultaInscricao.documentos.cabecalhoListaCobranca')
            ->add('listaDocumentosCobrancas', 'customField', $fieldOptions['listaDocumentosCobrancas'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $dividaAtivaModel = (new ConsultaInscricaoDividaModel($entityManager));

        $this->cobrancasDivida = $dividaAtivaModel->getListaCobrancasDivida($this->getSubject());

        foreach ($this->cobrancasDivida as $cobrancaDivida) {
            $listaParcelasDividas = $dividaAtivaModel->getListaParcelasDivida($cobrancaDivida);

            $this->listaParcelas[$cobrancaDivida->num_parcelamento] = $listaParcelasDividas;

            foreach ($listaParcelasDividas as $parcelaDivida) {
                $this->detalheParcela[$parcelaDivida->cod_lancamento] = $dividaAtivaModel->getDetalheParcelaDivida($parcelaDivida);

                $detalheCredito = $dividaAtivaModel->getListaDetalheParcelaCredito($parcelaDivida);
                $this->listaDetalheCreditos[$parcelaDivida->cod_lancamento] = $dividaAtivaModel->getCalculoCredito($this->detalheParcela[$parcelaDivida->cod_lancamento], $detalheCredito);
            }
        }

        if ($this->showAction == $this::SHOW_ACTION_DETALHE) {
            $this->showDetalhe($showMapper);
        }

        if ($this->showAction == $this::SHOW_ACTION_DOCUMENTO) {
            $this->parcelas = $this->getSubject()->getFkDividaDividaParcelamentos()->last()->getFkDividaParcelamento()->getFkDividaParcelas();
            $this->documentosSemCobranca = $dividaAtivaModel->getListaDocumentoSemCobrancaDivida($this->getSubject());
            $this->documentosComCobranca = $dividaAtivaModel->getListaDocumentoComCobrancaDivida($this->getSubject());

            $this->showDocumento($showMapper);
        }
    }
}
