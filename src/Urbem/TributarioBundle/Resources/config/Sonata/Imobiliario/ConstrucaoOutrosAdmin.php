<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Imobiliario\Construcao;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\Imobiliario\ConstrucaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ConstrucaoOutrosAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_construcao_imovel';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/construcao/imovel';
    protected $includeJs = array(
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/tributario/javascripts/imobiliario/processo.js',
        '/tributario/javascripts/imobiliario/construcao.js'
    );

    /**
     * @param Construcao $construcao
     * @return boolean
     */
    public function verificaBaixa(Construcao $construcao)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new ConstrucaoModel($em))->verificaBaixa($construcao);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codConstrucao',
                'doctrine_orm_callback',
                [
                    'label' => 'label.codigo',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'text'
            )
            ->add(
                'codLocalizacao',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioImovel.localizacao',
                    'callback' => array($this, 'getSearchFilter')
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
                'codLote',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioConstrucao.numLote',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'text'
            )
            ->add(
                'inscricaoMunicipal',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioConstrucao.inscricaoImobiliaria',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'text'
            )
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        $filter = $this->getDataGrid()->getValues();

        $queryBuilder->resetDQLPart('join');

        $queryBuilder->leftJoin('o.fkImobiliarioConstrucaoOutros', 'co');
        $queryBuilder->leftJoin('o.fkImobiliarioConstrucaoCondominios', 'cm');
        $queryBuilder->leftJoin('o.fkImobiliarioUnidadeDependentes', 'd');
        $queryBuilder->leftJoin('d.fkImobiliarioUnidadeAutonoma', 'a');
        $queryBuilder->leftJoin('a.fkImobiliarioImovel', 'i');
        $queryBuilder->leftJoin('i.fkImobiliarioImovelConfrontacao', 'ic');
        $queryBuilder->leftJoin('ic.fkImobiliarioConfrontacaoTrecho', 'ct');
        $queryBuilder->leftJoin('ct.fkImobiliarioConfrontacao', 'c');
        $queryBuilder->leftJoin('c.fkImobiliarioLote', 'l');
        $queryBuilder->leftJoin('l.fkImobiliarioLoteLocalizacao', 'll');

        $queryBuilder->where('co.codConstrucao is not null and cm.codConstrucao is null');

        if ((array_key_exists("codConstrucao", $filter)) && ($filter['codConstrucao']['value'] != '')) {
            $queryBuilder->andWhere('o.codConstrucao = :codConstrucao');
            $queryBuilder->setParameter('codConstrucao', $filter['codConstrucao']['value']);
        }

        if ((array_key_exists("inscricaoMunicipal", $filter)) && ($filter['inscricaoMunicipal']['value'] != '')) {
            $queryBuilder->andWhere('a.inscricaoMunicipal = :inscricaoMunicipal');
            $queryBuilder->setParameter('inscricaoMunicipal', $filter['inscricaoMunicipal']['value']);
        }

        if ((array_key_exists("codLote", $filter)) && ($filter['codLote']['value'] != '')) {
            $queryBuilder->andWhere('lpad(upper(ll.valor), 10, \'0\') = :valor');
            $queryBuilder->setParameter('valor', str_pad($filter['codLote']['value'], 10, '0', STR_PAD_LEFT));
        }

        if ((array_key_exists("codLocalizacao", $filter)) && ($filter['codLocalizacao']['value'] != '')) {
            $queryBuilder->andWhere('ll.codLocalizacao = :codLocalizacao');
            $queryBuilder->setParameter('codLocalizacao', $filter['codLocalizacao']['value']);
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codConstrucao', null, array('label' => 'label.codigo'))
            ->add('descricao', null, array('label' => 'label.descricao'))
            ->add('imovel', null, array('label' => 'label.imobiliarioConstrucao.imovel'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Construcao/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Construcao/CRUD:list__action_delete.html.twig'),
                    'baixar' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Construcao/CRUD:list__action_baixar.html.twig'),
                    'reforma' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Construcao/CRUD:list__action_reforma.html.twig'),
                    'caracteristicas' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Construcao/CRUD:list__action_caracteristicas.html.twig')
                ),
                'header_style' => 'width: 30%'
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $construcaoModel = new ConstrucaoModel($em);

        $dtAtual = new \DateTime();

        $fieldOptions = array();

        $fieldOptions['codConstrucao'] = [
            'mapped' => false
        ];

        $fieldOptions['fkImobiliarioLocalizacao'] = [
            'label' => 'label.imobiliarioCondominio.localizacao',
            'class' => Localizacao::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term) {
                $qb = $er->createQueryBuilder('o');
                $qb->andWhere('o.codigoComposto LIKE :codigoComposto');
                $qb->setParameter('codigoComposto', sprintf('%%%s%%', strtolower($term)));
                $qb->orderBy('o.codLocalizacao', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => true,
        ];

        $fieldOptions['fkImobiliarioLote'] = array(
            'label' => 'label.imobiliarioCondominio.lote',
            'class' => Lote::class,
            'req_params' => [
                'codLocalizacao' => 'varJsCodLocalizacao'
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->innerJoin('o.fkImobiliarioLoteLocalizacao', 'l');
                if ($request->get('codLocalizacao') != '') {
                    $qb->andWhere('l.codLocalizacao = :codLocalizacao');
                    $qb->setParameter('codLocalizacao', $request->get('codLocalizacao'));
                }
                $qb->andWhere('lpad(upper(l.valor), 10, \'0\') = :valor');
                $qb->setParameter('valor', str_pad($term, 10, '0', STR_PAD_LEFT));
                // Parcelado
                $qb->leftJoin('o.fkImobiliarioLoteParcelados', 'p');
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->isNull('p.validado'),
                    $qb->expr()->eq('p.validado', 'true')
                ));
                // Baixa
                $qb->leftJoin('o.fkImobiliarioBaixaLotes', 'b');
                $qb->andWhere('b.dtInicio is not null AND b.dtTermino is not null OR b.dtInicio is null');
                // Imóvel
                $qb->leftJoin('o.fkImobiliarioImovelLotes', 'i');
                $qb->andWhere('i.inscricaoMunicipal is not null');
                $qb->orderBy('o.codLote', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => false,
        );

        $fieldOptions['fkImobiliarioImovel'] = array(
            'label' => 'label.imobiliarioImovel.inscricaoImobiliaria',
            'class' => Imovel::class,
            'req_params' => [
                'codLocalizacao' => 'varJsCodLocalizacao',
                'codLote' => 'varJsCodLote'
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->innerJoin('o.fkImobiliarioImovelConfrontacao', 'ic');
                if ($request->get('codLocalizacao') != '') {
                    $qb->innerJoin('ic.fkImobiliarioConfrontacaoTrecho', 't');
                    $qb->innerJoin('t.fkImobiliarioConfrontacao', 'c');
                    $qb->innerJoin('c.fkImobiliarioLote', 'l');
                    $qb->innerJoin('l.fkImobiliarioLoteLocalizacao', 'll');
                    $qb->andWhere('ll.codLocalizacao = :codLocalizacao');
                    $qb->setParameter('codLocalizacao', $request->get('codLocalizacao'));
                }
                if ($request->get('codLote') != '') {
                    $qb->andWhere('ic.codLote = :codLote');
                    $qb->setParameter('codLote', $request->get('codLote'));
                }
                $qb->andWhere('o.inscricaoMunicipal = :inscricaoMunicipal');
                $qb->setParameter('inscricaoMunicipal', $term);
                $qb->orderBy('o.inscricaoMunicipal', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => true,
        );

        $fieldOptions['dataConstrucao'] = [
            'label' => 'label.imobiliarioConstrucao.dataConstrucao',
            'format' => 'dd/MM/yyyy',
            'mapped' => false
        ];

        $fieldOptions['descricao'] = [
            'label' => 'label.descricao',
            'mapped' => false
        ];

        $fieldOptions['area'] = [
            'label' => 'label.imobiliarioConstrucao.area',
            'mapped' => false,
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['fkSwClassificacao'] = array(
            'label' => 'label.imobiliarioImovel.classificacao',
            'class' => SwClassificacao::class,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->orderBy('o.codClassificacao', 'ASC');
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkSwAssunto'] = array(
            'label' => 'label.imobiliarioImovel.assunto',
            'class' => SwAssunto::class,
            'choice_value' => 'codAssunto',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->orderBy('o.codAssunto', 'ASC');
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkSwProcesso'] = array(
            'label' => 'label.imobiliarioImovel.processo',
            'class' => SwProcesso::class,
            'req_params' => [
                'codClassificacao' => 'varJsCodClassificacao',
                'codAssunto' => 'varJsCodAssunto'
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->innerJoin('o.fkAdministracaoUsuario', 'u');
                $qb->innerJoin('u.fkSwCgm', 'cgm');
                if ($request->get('codClassificacao') != '') {
                    $qb->andWhere('o.codClassificacao = :codClassificacao');
                    $qb->setParameter('codClassificacao', (int) $request->get('codClassificacao'));
                }
                if ($request->get('codAssunto') != '') {
                    $qb->andWhere('o.codAssunto = :codAssunto');
                    $qb->setParameter('codAssunto', (int) $request->get('codAssunto'));
                }
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->eq('o.codProcesso', ':codProcesso'),
                    $qb->expr()->eq('cgm.numcgm', ':numCgm'),
                    $qb->expr()->like('LOWER(cgm.nomCgm)', $qb->expr()->literal('%' . strtolower($term) . '%'))
                ));
                $qb->setParameter('numCgm', (int) $term);
                $qb->setParameter('codProcesso', (int) $term);
                $qb->orderBy('o.codProcesso', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => false,
        );

        if ($this->id($this->getSubject())) {
            /** @var Construcao $construcao */
            $construcao = $this->getSubject();

            /** @var Imovel $imovel */
            $imovel = $construcao->getFkImobiliarioUnidadeDependentes()->last()->getFkImobiliarioUnidadeAutonoma()->getFkImobiliarioImovel();

            $fieldOptions['codConstrucao']['data'] = $construcao->getCodConstrucao();

            $fieldOptions['descricao']['data'] = $construcao->getFkImobiliarioConstrucaoOutros()->getDescricao();
            $fieldOptions['area']['data'] = number_format($construcao->getFkImobiliarioUnidadeDependentes()->last()->getFkImobiliarioAreaUnidadeDependentes()->last()->getArea(), 2, ',', '.');

            $fieldOptions['fkImobiliarioImovel']['disabled'] = true;
            $fieldOptions['fkImobiliarioImovel']['data'] = $imovel;
            $fieldOptions['fkImobiliarioLote']['disabled'] = true;
            $fieldOptions['fkImobiliarioLote']['data'] = $imovel->getFkImobiliarioImovelConfrontacao()->getFkImobiliarioConfrontacaoTrecho()->getFkImobiliarioConfrontacao()->getFkImobiliarioLote();
            $fieldOptions['fkImobiliarioLocalizacao']['disabled'] = true;
            $fieldOptions['fkImobiliarioLocalizacao']['data'] = $imovel->getFkImobiliarioImovelConfrontacao()->getFkImobiliarioConfrontacaoTrecho()->getFkImobiliarioConfrontacao()->getFkImobiliarioLote()->getFkImobiliarioLoteLocalizacao()->getFkImobiliarioLocalizacao();

            if ($construcao->getFkImobiliarioDataConstrucao()) {
                $fieldOptions['dataConstrucao']['data'] = $construcao->getFkImobiliarioDataConstrucao()->getDataConstrucao();
            }

            if ($construcao->getFkImobiliarioConstrucaoProcessos()->count()) {
                $fieldOptions['fkSwClassificacao']['disabled'] = true;
                $fieldOptions['fkSwClassificacao']['data'] = $construcao->getFkImobiliarioConstrucaoProcessos()->last()->getFkSwProcesso()->getFkSwAssunto()->getFkSwClassificacao();
                $fieldOptions['fkSwAssunto']['disabled'] = true;
                $fieldOptions['fkSwAssunto']['data'] = $construcao->getFkImobiliarioConstrucaoProcessos()->last()->getFkSwProcesso()->getFkSwAssunto();
                $fieldOptions['fkSwProcesso']['disabled'] = true;
                $fieldOptions['fkSwProcesso']['data'] = $construcao->getFkImobiliarioConstrucaoProcessos()->last()->getFkSwProcesso();
            }
        } else {
            $fieldOptions['dataConstrucao']['data'] = $dtAtual;
        }

        $formMapper->tab('label.imobiliarioConstrucao.construcao');
        $formMapper->with('label.imobiliarioImovel.inscricaoImobiliaria');
        $formMapper->add('fkImobiliarioLocalizacao', 'autocomplete', $fieldOptions['fkImobiliarioLocalizacao']);
        $formMapper->add('fkImobiliarioLote', 'autocomplete', $fieldOptions['fkImobiliarioLote']);
        $formMapper->add('fkImobiliarioImovel', 'autocomplete', $fieldOptions['fkImobiliarioImovel']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioConstrucao.dadosConstrucao');
        $formMapper->add('codConstrucao', 'hidden', $fieldOptions['codConstrucao']);
        $formMapper->add('dataConstrucao', 'sonata_type_date_picker', $fieldOptions['dataConstrucao']);
        $formMapper->add('descricao', 'text', $fieldOptions['descricao']);
        $formMapper->add('area', 'text', $fieldOptions['area']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioImovel.processo');
        $formMapper->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao']);
        $formMapper->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto']);
        $formMapper->add('fkSwProcesso', 'autocomplete', $fieldOptions['fkSwProcesso']);
        $formMapper->end();
        $formMapper->end();
        $formMapper->tab('label.imobiliarioConstrucao.caracteristicas');
        if ($this->id($this->getSubject())) {
            $atributosDinamicos = $construcaoModel->getNomAtributoValorByConstrucaoOutros($construcao->getFkImobiliarioConstrucaoOutros());

            $fieldOptions['atributosDinamicos'] = array(
                'label' => false,
                'mapped' => false,
                'template' => 'TributarioBundle::Imobiliario/Lote/atributosDinamicos.html.twig',
                'data' => array(
                    'atributosDinamicos' => $atributosDinamicos
                )
            );

            $formMapper->with('label.imobiliarioLote.atributos');
            $formMapper->add('atributosDinamicos', 'customField', $fieldOptions['atributosDinamicos']);
            $formMapper->end();
        } else {
            $formMapper->with('label.imobiliarioLote.atributos', array('class' => 'atributoDinamicoWith'));
            $formMapper->add('atributosDinamicos', 'text', array('mapped' => false, 'required' => false));
            $formMapper->end();
        }
        $formMapper->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codConstrucao')
            ->add('timestamp')
        ;
    }

    /**
     * @param Construcao $construcao
     */
    public function prePersist($construcao)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $construcaoModel = new ConstrucaoModel($em);

        $construcaoModel->popularConstrucaoOutros($construcao, $this->getForm(), $this->request->request);
    }

    /**
     * @param Construcao $construcao
     */
    public function preUpdate($construcao)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $construcaoModel = new ConstrucaoModel($em);

        $construcaoModel->alterarConstrucaoOutros($construcao, $this->getForm());
    }
}
