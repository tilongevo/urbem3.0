<?php

namespace Urbem\PortalServicosBundle\Resources\config\Sonata;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Urbem\CoreBundle\Entity\Divida\DividaAtiva;
use Urbem\CoreBundle\Model\Divida\ConsultaInscricaoDividaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConsultaInscricaoDividaAtivaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_portalservicos_divida_ativa_consulta_inscricao';
    protected $baseRoutePattern = 'portal-cidadao/divida-ativa/consulta/inscricao';
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoSalvar = false;
    protected $exibirMensagemFiltro = true;

    /**
    * @param string $action
    * @param null|Lancamento $object
    * @return void
    */
    public function checkAccess($action, $object = null)
    {
        if (in_array($action, ['list', 'export'])) {
            return;
        }

        $em = $this->modelManager->getEntityManager($this->getClass());
        $qb = $em->getRepository(DividaAtiva::class)->createQueryBuilder('da');

        $qb->join(sprintf('%s.fkDividaDividaCgns', $qb->getRootAlias()), 'dc');

        $qb->andWhere('da.codInscricao = :codInscricao');
        $qb->setParameter('codInscricao', $object->getCodInscricao());

        $qb->andWhere('da.exercicio = :exercicio');
        $qb->setParameter('exercicio', $object->getExercicio());

        $qb->andWhere('dc.numcgm = :numcgm');
        $qb->setParameter('numcgm', $this->getCurrentUser()->getNumcgm());

        if ($qb->getQuery()->getOneOrNullResult()) {
            return;
        }

        throw new AccessDeniedHttpException();
    }

    /**
     * @param RouteCollection $routes
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->clearExcept(
            [
                'list',
                'show',
                'export',
            ]
        );
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);

        $qb->join(sprintf('%s.fkDividaDividaCgns', $qb->getRootAlias()), 'dc');

        $qb->andWhere('dc.numcgm = :numcgm');
        $qb->setParameter('numcgm', $this->getCurrentUser()->getNumcgm());

        return $qb;
    }

    /**
     * @param $dividaAtiva
     * @return mixed
     */
    public function getDadosDividaAtiva($dividaAtiva)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        return (new ConsultaInscricaoDividaModel($entityManager))
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
                    'callback' => function ($qb, $alias, $field, $value) {
                        //dump($value);exit;
                    },
                    'label' => 'label.dividaAtivaConsultaInscricao.inscricaoAno'
                ],
                'entity',
                [
                    'class' => DividaAtiva::class,
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('da');

                        $qb->join('da.fkDividaDividaCgns', 'dc');

                        $qb->andWhere('dc.numcgm = :numcgm');
                        $qb->setParameter('numcgm', $this->getCurrentUser()->getNumcgm());

                        $qb->addOrderBy('da.codInscricao', 'ASC');
                        $qb->addOrderBy('da.exercicio', 'ASC');

                        return $qb;
                    },
                    'choice_label' => function (DividaAtiva $dividaAtiva) {
                        return sprintf(
                            '%d/%d',
                            $dividaAtiva->getCodInscricao(),
                            $dividaAtiva->getExercicio()
                        );
                    },
                    'attr' => [
                        'class' => 'select2-parameters'
                    ],
                ]
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
                        'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
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

        $this->showDetalhe($showMapper);
    }
}
