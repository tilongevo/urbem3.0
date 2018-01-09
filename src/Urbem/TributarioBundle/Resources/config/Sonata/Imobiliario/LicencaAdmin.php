<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Cse\Profissao;
use Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico;
use Urbem\CoreBundle\Entity\Imobiliario\Construcao;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\Licenca;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\Loteamento;
use Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo;
use Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacao;
use Urbem\CoreBundle\Entity\Imobiliario\TipoLicenca;
use Urbem\CoreBundle\Entity\Imobiliario\TipoParcelamento;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Imobiliario\LicencaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class LicencaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_licencas_licenca';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/licencas/licenca';
    protected $legendButtonSave = array('icon' => 'save', 'text' => 'Salvar');
    protected $codTipo;
    protected $includeJs = array(
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/tributario/javascripts/imobiliario/processo.js',
        '/tributario/javascripts/imobiliario/licenca.js',
        '/tributario/javascripts/imobiliario/licenca-responsaveis-tecnicos.js'
    );

    const NOVA_UNIDADE_CONSTRUCAO = 0;
    const NOVA_UNIDADE_EDIFICACAO = 1;

    /**
     * @param Licenca $licenca
     * @return boolean
     */
    public function verificaBaixa(Licenca $licenca)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new LicencaModel($em))->verificaBaixa($licenca);
    }

    /**
     * @param Licenca $licenca
     * @return boolean
     */
    public function verificaSuspensao(Licenca $licenca)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new LicencaModel($em))->verificaSuspensao($licenca);
    }

    /**
     * @param Licenca $licenca
     * @return boolean
     */
    public function verificaSuspensaoACancelar(Licenca $licenca)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new LicencaModel($em))->verificaSuspensaoACancelar($licenca);
    }

    /**
     * @param Licenca $licenca
     * @return boolean
     */
    public function verificaCassacao(Licenca $licenca)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new LicencaModel($em))->verificaCassacao($licenca);
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'codTipo' => $this->getRequest()->get('codTipo'),
        );
    }

    /**
     * @return null|TipoLicenca
     */
    public function getTipoLicenca()
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $tipoLicenca = null;
        if ($this->getPersistentParameter('codTipo')) {
            /** @var TipoLicenca $tipoLicenca */
            $tipoLicenca = $em->getRepository(TipoLicenca::class)->find($this->getPersistentParameter('codTipo'));
        }
        return $tipoLicenca;
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consultar_responsavel_tecnico', 'consultar-responsavel-tecnico');
        $collection->add('consultar_construcao', 'consultar-construcao');
        $collection->add('consultar_lote', 'consultar-lote');
        $collection->add('consultar_loteamento', 'consultar-loteamento');
        $collection->add('consultar_parcelamento_solo', 'consultar-parcelamento-solo');
        $collection->add('consultar_imovel', 'consultar-imovel');
    }

    public function createQuery($context = 'list')
    {
        $container = $this->getConfigurationPool()->getContainer();
        /** @var Usuario $user */
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $queryBuilder = parent::createQuery($context);

        $queryBuilder->innerJoin('o.fkImobiliarioPermissao', 'p');
        $queryBuilder->leftJoin('o.fkImobiliarioLicencaLotes', 'ol');
        $queryBuilder->leftJoin('ol.fkImobiliarioLote', 'l');
        $queryBuilder->leftJoin('l.fkImobiliarioLoteLocalizacao', 'll');

        $queryBuilder->where('p.numcgm = :numcgm');
        $queryBuilder->setParameter('numcgm', $usuario->getNumcgm());

        return $queryBuilder;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codLicenca', null, ['label' => 'label.imobiliarioLicenca.licenca'])
            ->add('exercicio', null, ['label' => 'label.imobiliarioLicenca.exercicio'])
            ->add('fkImobiliarioPermissao.fkImobiliarioTipoLicenca', null, ['label' => 'label.imobiliarioLicenca.tipoEdificacao'])
            ->add(
                'fkImobiliarioLicencaImoveis.fkImobiliarioImovel',
                'doctrine_orm_model_autocomplete',
                [
                    'label' => 'label.imobiliarioLicenca.inscricaoImobiliario',
                ],
                'sonata_type_model_autocomplete',
                [
                    'callback' => function (AbstractAdmin $admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();

                        $query = $datagrid->getQuery();
                        $query->where('o.inscricaoMunicipal = :inscricaoMunicipal');
                        $query->setParameter('inscricaoMunicipal', $value);

                        $datagrid->setValue($property, 'LIKE', $value);
                    },
                    'property' => 'inscricaoMunicipal'
                ],
                [
                    'admin_code' => 'tributario.admin.imovel_fotos'
                ]
            )
            ->add(
                'codLocalizacao',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioLicenca.localizacao',
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
                    'label' => 'label.imobiliarioLicenca.lote',
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

        if ((array_key_exists("codLote", $filter)) && ($filter['codLote']['value'] != '')) {
            $queryBuilder->andWhere('lpad(upper(ll.valor), 10, \'0\') = :valor');
            $queryBuilder->setParameter('valor', str_pad($filter['codLote']['value'], 10, '0', STR_PAD_LEFT));
        }

        if ((array_key_exists("codLocalizacao", $filter)) && ($filter['codLocalizacao']['value'] != '')) {
            $queryBuilder->andWhere('ll.codLocalizacao = :codLocalizacao');
            $queryBuilder->setParameter('codLocalizacao', $filter['codLocalizacao']['value']);
        }

        if ((array_key_exists("fkImobiliarioTipoEdificacao", $filter)) && ($filter['fkImobiliarioTipoEdificacao']['value'] != '')) {
            $queryBuilder->andWhere('e.codTipo = :codTipo');
            $queryBuilder->setParameter('codTipo', $filter['fkImobiliarioTipoEdificacao']['value']);
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('__toString', 'text', ['label' => 'label.imobiliarioLicenca.modulo'])
            ->add('fkImobiliarioPermissao.fkImobiliarioTipoLicenca', 'text', ['label' => 'label.imobiliarioLicenca.tipoEdificacao'])
            ->add('origem', 'text', ['label' => 'label.imobiliarioLicenca.origem'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Licenca/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Licenca/CRUD:list__action_delete.html.twig'),
                    'baixar' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Licenca/CRUD:list__action_baixar.html.twig'),
                    'suspender' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Licenca/CRUD:list__action_suspender.html.twig'),
                    'cancelar' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Licenca/CRUD:list__action_cancelar.html.twig'),
                    'cassar' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Licenca/CRUD:list__action_cassar.html.twig')
                ),
                'header_style' => 'width: 35%'
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    public function setFormTipoLicenca(FormMapper $formMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();

        /** @var Usuario $user */
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $fieldOptions['fkImobiliarioTipoLicenca'] = [
            'label' => 'label.imobiliarioLicenca.tipoLicenca',
            'class' => TipoLicenca::class,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) use ($usuario) {
                return $er->createQueryBuilder('o')
                    ->leftJoin('o.fkImobiliarioPermissoes', 'p')
                    ->where('p.numcgm = :numcgm')
                    ->setParameter('numcgm', $usuario->getNumcgm());
            }
        ];

        $formMapper->with('label.imobiliarioLicenca.dados');
        $formMapper->add('fkImobiliarioTipoLicenca', 'entity', $fieldOptions['fkImobiliarioTipoLicenca']);
        $formMapper->end();
    }

    /**
     * @param FormMapper $formMapper
     */
    public function setFormInscricaoMunicipal(FormMapper $formMapper)
    {
        $fieldOptions['fkImobiliarioLocalizacao'] = [
            'label' => 'label.imobiliarioCondominio.localizacao',
            'class' => Localizacao::class,
            'req_params' => [
                'codTipo' => $this->codTipo
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term) {
                $qb = $er->createQueryBuilder('o');
                $qb->andWhere('o.codigoComposto LIKE :codigoComposto');
                $qb->setParameter('codigoComposto', sprintf('%%%s%%', strtolower($term)));
                $qb->orderBy('o.codLocalizacao', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioLote'] = array(
            'label' => 'label.imobiliarioLicenca.lote',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true
        );

        $fieldOptions['fkImobiliarioImovel'] = [
            'label' => 'label.imobiliarioImovel.inscricaoImobiliaria',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true
        ];

        if ($this->id($this->getSubject())) {
            /** @var Licenca $licenca */
            $licenca = $this->getSubject();

            /** @var Localizacao $localizacao */
            $localizacao = $licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioImovel()->getLocalizacao();

            $fieldOptions['fkImobiliarioLocalizacao']['data'] = $localizacao;
            $fieldOptions['fkImobiliarioLocalizacao']['disabled'] = true;

            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());
            $licencaModel = new LicencaModel($em);
            /** @var Lote $lote */
            $lote = $licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioImovel()->getLote();

            $fieldOptions['fkImobiliarioLote']['choices'] = array_flip($licencaModel->getOptionsLotesByCodLocalizacao($localizacao->getCodLocalizacao()));
            $fieldOptions['fkImobiliarioLote']['data'] = $lote->getCodLote();
            $fieldOptions['fkImobiliarioLote']['disabled'] = true;

            $novaUnidade = self::NOVA_UNIDADE_EDIFICACAO;
            if ($licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioLicencaImovelNovaConstrucao()) {
                $novaUnidade = self::NOVA_UNIDADE_CONSTRUCAO;
            }

            $fieldOptions['fkImobiliarioImovel']['choices'] = array_flip($licencaModel->getOptionsImoveisByCodLote($lote->getCodLote(), $novaUnidade));
            $fieldOptions['fkImobiliarioImovel']['data'] = $licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioImovel();
            $fieldOptions['fkImobiliarioImovel']['disabled'] = true;
        }

        $formMapper->with('label.imobiliarioLicenca.dados');
        $formMapper->add('fkImobiliarioLocalizacao', 'autocomplete', $fieldOptions['fkImobiliarioLocalizacao']);
        $formMapper->add('fkImobiliarioLote', 'choice', $fieldOptions['fkImobiliarioLote']);
        $formMapper->add('fkImobiliarioImovel', 'choice', $fieldOptions['fkImobiliarioImovel']);
    }

    public function setFormLoteamento(FormMapper $formMapper)
    {
        $fieldOptions['fkImobiliarioLocalizacao'] = [
            'label' => 'label.imobiliarioLicenca.localizacao',
            'class' => Localizacao::class,
            'req_params' => [
                'codTipo' => $this->codTipo
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term) {
                $qb = $er->createQueryBuilder('o');
                $qb->andWhere('o.codigoComposto LIKE :codigoComposto');
                $qb->setParameter('codigoComposto', sprintf('%%%s%%', strtolower($term)));
                $qb->orderBy('o.codLocalizacao', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioLote'] = array(
            'label' => 'label.imobiliarioLicenca.lote',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true
        );

        $fieldOptions['fkImobiliarioLoteamento'] = array(
            'label' => 'label.imobiliarioLicenca.loteamento',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true
        );

        if ($this->id($this->getSubject())) {
            /** @var Licenca $licenca */
            $licenca = $this->getSubject();

            /** @var Localizacao $localizacao */
            $localizacao = $licenca->getFkImobiliarioLicencaLotes()->last()->getFkImobiliarioLote()->getFkImobiliarioLoteLocalizacao()->getFkImobiliarioLocalizacao();

            $fieldOptions['fkImobiliarioLocalizacao']['data'] = $localizacao;
            $fieldOptions['fkImobiliarioLocalizacao']['disabled'] = true;

            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());
            $licencaModel = new LicencaModel($em);
            /** @var Lote $lote */
            $lote = $licenca->getFkImobiliarioLicencaLotes()->last()->getFkImobiliarioLote();

            $fieldOptions['fkImobiliarioLote']['choices'] = array_flip($licencaModel->getOptionsLotesByCodLocalizacao($localizacao->getCodLocalizacao()));
            $fieldOptions['fkImobiliarioLote']['data'] = $lote->getCodLote();
            $fieldOptions['fkImobiliarioLote']['disabled'] = true;

            $fieldOptions['fkImobiliarioLoteamento']['choices'] = array_flip($licencaModel->getOptionsLoteamentosByCodLote($lote->getCodLote()));
            $fieldOptions['fkImobiliarioLoteamento']['data'] = $licenca->getFkImobiliarioLicencaLotes()->last()->getFkImobiliarioLicencaLoteLoteamentos()->last()->getFkImobiliarioLoteamento()->getCodLoteamento();
            $fieldOptions['fkImobiliarioLoteamento']['disabled'] = true;
        }

        $formMapper->with('label.imobiliarioLicenca.dados');
        $formMapper->add('fkImobiliarioLocalizacao', 'autocomplete', $fieldOptions['fkImobiliarioLocalizacao']);
        $formMapper->add('fkImobiliarioLote', 'choice', $fieldOptions['fkImobiliarioLote']);
        $formMapper->add('fkImobiliarioLoteamento', 'choice', $fieldOptions['fkImobiliarioLoteamento']);
    }

    public function setFormDesmembramento(FormMapper $formMapper)
    {
        $fieldOptions['fkImobiliarioLocalizacao'] = [
            'label' => 'label.imobiliarioLicenca.localizacao',
            'class' => Localizacao::class,
            'req_params' => [
                'codTipo' => $this->codTipo
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term) {
                $qb = $er->createQueryBuilder('o');
                $qb->andWhere('o.codigoComposto LIKE :codigoComposto');
                $qb->setParameter('codigoComposto', sprintf('%%%s%%', strtolower($term)));
                $qb->orderBy('o.codLocalizacao', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioLote'] = [
            'label' => 'label.imobiliarioLicenca.lote',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioTipoParcelamento'] = [
            'mapped' => false,
            'data' => TipoParcelamento::TIPO_PARCELAMENTO_DESMEMBRAMENTO
        ];

        $fieldOptions['fkImobiliarioParcelamentoSolo'] = [
            'label' => 'label.imobiliarioLicenca.desmembramento',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true
        ];

        if ($this->id($this->getSubject())) {
            /** @var Licenca $licenca */
            $licenca = $this->getSubject();

            /** @var Localizacao $localizacao */
            $localizacao = $licenca->getFkImobiliarioLicencaLotes()->last()->getFkImobiliarioLote()->getFkImobiliarioLoteLocalizacao()->getFkImobiliarioLocalizacao();

            $fieldOptions['fkImobiliarioLocalizacao']['data'] = $localizacao;
            $fieldOptions['fkImobiliarioLocalizacao']['disabled'] = true;

            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());
            $licencaModel = new LicencaModel($em);
            /** @var Lote $lote */
            $lote = $licenca->getFkImobiliarioLicencaLotes()->last()->getFkImobiliarioLote();

            $fieldOptions['fkImobiliarioLote']['choices'] = array_flip($licencaModel->getOptionsLotesByCodLocalizacao($localizacao->getCodLocalizacao()));
            $fieldOptions['fkImobiliarioLote']['data'] = $lote->getCodLote();
            $fieldOptions['fkImobiliarioLote']['disabled'] = true;

            $fieldOptions['fkImobiliarioParcelamentoSolo']['choices'] = array_flip($licencaModel->getOptionsParcelamentosSoloByCodLote($lote->getCodLote(), TipoParcelamento::TIPO_PARCELAMENTO_DESMEMBRAMENTO));
            $fieldOptions['fkImobiliarioParcelamentoSolo']['data'] = $licenca->getFkImobiliarioLicencaLotes()->last()->getFkImobiliarioLicencaLoteParcelamentoSolos()->last()->getCodParcelamento();
            $fieldOptions['fkImobiliarioParcelamentoSolo']['disabled'] = true;
        }

        $formMapper->with('label.imobiliarioLicenca.dados');
        $formMapper->add('fkImobiliarioLocalizacao', 'autocomplete', $fieldOptions['fkImobiliarioLocalizacao']);
        $formMapper->add('fkImobiliarioLote', 'choice', $fieldOptions['fkImobiliarioLote']);
        $formMapper->add('fkImobiliarioParcelamentoSolo', 'choice', $fieldOptions['fkImobiliarioParcelamentoSolo']);
        $formMapper->add('fkImobiliarioTipoParcelamento', 'hidden', $fieldOptions['fkImobiliarioTipoParcelamento']);
    }

    public function setFormAglutinacao(FormMapper $formMapper)
    {
        $fieldOptions['fkImobiliarioLocalizacao'] = [
            'label' => 'label.imobiliarioLicenca.localizacao',
            'class' => Localizacao::class,
            'req_params' => [
                'codTipo' => $this->codTipo
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term) {
                $qb = $er->createQueryBuilder('o');
                $qb->andWhere('o.codigoComposto LIKE :codigoComposto');
                $qb->setParameter('codigoComposto', sprintf('%%%s%%', strtolower($term)));
                $qb->orderBy('o.codLocalizacao', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioLote'] = [
            'label' => 'label.imobiliarioLicenca.lote',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioTipoParcelamento'] = [
            'mapped' => false,
            'data' => TipoParcelamento::TIPO_PARCELAMENTO_AGLUTINACAO
        ];

        $fieldOptions['fkImobiliarioParcelamentoSolo'] = [
            'label' => 'label.imobiliarioLicenca.aglutinacao',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true
        ];

        if ($this->id($this->getSubject())) {
            /** @var Licenca $licenca */
            $licenca = $this->getSubject();

            /** @var Localizacao $localizacao */
            $localizacao = $licenca->getFkImobiliarioLicencaLotes()->last()->getFkImobiliarioLote()->getFkImobiliarioLoteLocalizacao()->getFkImobiliarioLocalizacao();

            $fieldOptions['fkImobiliarioLocalizacao']['data'] = $localizacao;
            $fieldOptions['fkImobiliarioLocalizacao']['disabled'] = true;

            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());
            $licencaModel = new LicencaModel($em);
            /** @var Lote $lote */
            $lote = $licenca->getFkImobiliarioLicencaLotes()->last()->getFkImobiliarioLote();

            $fieldOptions['fkImobiliarioLote']['choices'] = array_flip($licencaModel->getOptionsLotesByCodLocalizacao($localizacao->getCodLocalizacao()));
            $fieldOptions['fkImobiliarioLote']['data'] = $lote->getCodLote();
            $fieldOptions['fkImobiliarioLote']['disabled'] = true;

            $fieldOptions['fkImobiliarioParcelamentoSolo']['choices'] = array_flip($licencaModel->getOptionsParcelamentosSoloByCodLote($lote->getCodLote(), TipoParcelamento::TIPO_PARCELAMENTO_AGLUTINACAO));
            $fieldOptions['fkImobiliarioParcelamentoSolo']['data'] = $licenca->getFkImobiliarioLicencaLotes()->last()->getFkImobiliarioLicencaLoteParcelamentoSolos()->last()->getCodParcelamento();
            $fieldOptions['fkImobiliarioParcelamentoSolo']['disabled'] = true;
        }

        $formMapper->with('label.imobiliarioLicenca.dados');
        $formMapper->add('fkImobiliarioLocalizacao', 'autocomplete', $fieldOptions['fkImobiliarioLocalizacao']);
        $formMapper->add('fkImobiliarioLote', 'choice', $fieldOptions['fkImobiliarioLote']);
        $formMapper->add('fkImobiliarioParcelamentoSolo', 'choice', $fieldOptions['fkImobiliarioParcelamentoSolo']);
        $formMapper->add('fkImobiliarioTipoParcelamento', 'hidden', $fieldOptions['fkImobiliarioTipoParcelamento']);
    }

    /**
     * @param FormMapper $formMapper
     */
    public function setFormNovaUnidade(FormMapper $formMapper)
    {
        $fieldOptions['codConstrucao'] = [
            'mapped' => false,
        ];

        $novaUnidadeOpcoes = [
            self::NOVA_UNIDADE_CONSTRUCAO => 'label.imobiliarioLicenca.construcao',
            self::NOVA_UNIDADE_EDIFICACAO => 'label.imobiliarioLicenca.edificacao'
        ];

        $fieldOptions['novaUnidade'] = [
            'label' => 'label.imobiliarioLicenca.novaUnidade',
            'mapped' => false,
            'required' => true,
            'expanded' => true,
            'choices' => array_flip($novaUnidadeOpcoes),
            'data' => self::NOVA_UNIDADE_CONSTRUCAO,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ]
        ];

        $fieldOptions['descricao'] = [
            'label' => 'label.descricao',
            'mapped' => false,
            'required' => true,
        ];

        $fieldOptions['fkImobiliarioTipoEdificacao'] = [
            'class' => TipoEdificacao::class,
            'label' => 'label.imobiliarioConstrucao.tipoEdificacao',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true
        ];

        if ($this->id($this->getSubject())) {
            /** @var Licenca $licenca */
            $licenca = $this->getSubject();

            if ($licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioLicencaImovelNovaEdificacao()) {
                $fieldOptions['novaUnidade']['data'] = self::NOVA_UNIDADE_EDIFICACAO;
                $fieldOptions['codConstrucao']['data'] = $licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioLicencaImovelNovaEdificacao()->getFkImobiliarioConstrucaoEdificacao()->getCodConstrucao();
                $fieldOptions['fkImobiliarioTipoEdificacao']['data'] = $licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioLicencaImovelNovaEdificacao()->getFkImobiliarioConstrucaoEdificacao()->getFkImobiliarioTipoEdificacao();
                $fieldOptions['fkImobiliarioTipoEdificacao']['disabled'] = true;
            } else {
                $fieldOptions['codConstrucao']['data'] = $licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioLicencaImovelNovaConstrucao()->getCodConstrucao();
                $fieldOptions['descricao']['data'] = $licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioLicencaImovelNovaConstrucao()->getFkImobiliarioConstrucao()->getFkImobiliarioConstrucaoOutros()->getDescricao();
            }
            $fieldOptions['novaUnidade']['disabled'] = true;
        }

        $formMapper->add('codConstrucao', 'hidden', $fieldOptions['codConstrucao']);
        $formMapper->add('novaUnidade', 'choice', $fieldOptions['novaUnidade']);
        $formMapper->add('descricao', 'textarea', $fieldOptions['descricao']);
        $formMapper->add('fkImobiliarioTipoEdificacao', 'entity', $fieldOptions['fkImobiliarioTipoEdificacao']);
    }

    /**
     * @param FormMapper $formMapper
     */
    public function setFormConstrucao(FormMapper $formMapper)
    {
        $fieldOptions['fkImobiliarioConstrucao'] = [
            'label' => 'label.imobiliarioLicenca.edificacaoConstrucao',
            'placeholder' => 'label.selecione',
            'choices' => array(),
            'mapped' => false,
            'required' => true
        ];

        if ($this->id($this->getSubject())) {
            /** @var Licenca $licenca */
            $licenca = $this->getSubject();

            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());
            $licencaModel = new LicencaModel($em);

            /** @var Imovel $imovel */
            $imovel = $licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioImovel();

            if ($licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioLicencaImovelUnidadeAutonomas()->count()) {
                $construcao = $licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioLicencaImovelUnidadeAutonomas()->last()->getFkImobiliarioUnidadeAutonoma()->getFkImobiliarioConstrucaoEdificacao()->getFkImobiliarioConstrucao();
            } else {
                $construcao = $licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioLicencaImovelUnidadeDependentes()->last()->getFkImobiliarioUnidadeDependente()->getFkImobiliarioConstrucao();
            }

            $fieldOptions['fkImobiliarioConstrucao']['choices'] = $licencaModel->getOptionsConstrucoesByIncricaoMunicipal($imovel->getInscricaoMunicipal());
            $fieldOptions['fkImobiliarioConstrucao']['data'] = $construcao;
            $fieldOptions['fkImobiliarioConstrucao']['disabled'] = true;
        }

        $formMapper->add('fkImobiliarioConstrucao', 'choice', $fieldOptions['fkImobiliarioConstrucao']);
    }

    public function setForm(FormMapper $formMapper)
    {
        $this->legendButtonSave = array('icon' => 'save', 'text' => 'Salvar');

        switch ($this->codTipo) {
            case TipoLicenca::TIPO_LICENCA_NOVA_EDIFICACAO:
                $this->setFormInscricaoMunicipal($formMapper);
                $this->setFormNovaUnidade($formMapper);
                $this->setFormLicenca($formMapper);
                break;
            case TipoLicenca::TIPO_LICENCA_HABITE_SE:
            case TipoLicenca::TIPO_LICENCA_REFORMA:
            case TipoLicenca::TIPO_LICENCA_REPAROS:
            case TipoLicenca::TIPO_LICENCA_RECONSTRUCAO:
            case TipoLicenca::TIPO_LICENCA_DEMOLICAO:
                $this->setFormInscricaoMunicipal($formMapper);
                $this->setFormConstrucao($formMapper);
                $this->setFormLicenca($formMapper);
                break;
            case TipoLicenca::TIPO_LICENCA_LOTEAMENTO:
                $this->setFormLoteamento($formMapper);
                $this->setFormLicenca($formMapper);
                break;
            case TipoLicenca::TIPO_LICENCA_DESMEMBRAMENTO:
                $this->setFormDesmembramento($formMapper);
                $this->setFormLicenca($formMapper);
                break;
            case TipoLicenca::TIPO_LICENCA_AGLUTINACAO:
                $this->setFormAglutinacao($formMapper);
                $this->setFormLicenca($formMapper);
                break;
            default:
                $this->legendButtonSave = array('icon' => 'arrow_forward', 'text' => 'Continuar');
                $this->setFormTipoLicenca($formMapper);
                break;
        }
    }

    public function setFormLicenca(FormMapper $formMapper)
    {
        $fieldOptions = array();

        $fieldOptions['codTipo'] = [
            'mapped' => false,
            'data' => $this->codTipo
        ];

        $fieldOptions['codLicenca'] = [
            'mapped' => false
        ];

        $fieldOptions['exercicio'] = [
            'mapped' => false
        ];

        $fieldOptions['area'] = [
            'label' => 'label.imobiliarioLicenca.area',
            'mapped' => false,
            'required' => true,
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['fkSwClassificacao'] = [
            'label' => 'label.imobiliarioImovel.classificacao',
            'class' => SwClassificacao::class,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->orderBy('o.codClassificacao', 'ASC');
            },
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['fkSwAssunto'] = [
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
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['fkSwProcesso'] = [
            'label' => 'label.imobiliarioImovel.processo',
            'class' => SwProcesso::class,
            'req_params' => [
                'codClassificacao' => 'varJsCodClassificacao',
                'codAssunto' => 'varJsCodAssunto',
                'codTipo' => $this->codTipo
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
        ];

        $fieldOptions['observacao'] = [
            'label' => false,
            'required' => false
        ];

        $fieldOptions['dtInicio'] = [
            'label' => 'label.imobiliarioLicenca.dtInicio',
            'format' => 'dd/MM/yyyy'
        ];

        $fieldOptions['dtTermino'] = [
            'label' => 'label.imobiliarioLicenca.dtTermino',
            'format' => 'dd/MM/yyyy'
        ];

        $profissoes = [
            Profissao::ARQUITETO
        ];

        if (!(($this->codTipo == TipoLicenca::TIPO_LICENCA_LOTEAMENTO) || ($this->codTipo == TipoLicenca::TIPO_LICENCA_DESMEMBRAMENTO) || ($this->codTipo == TipoLicenca::TIPO_LICENCA_AGLUTINACAO))) {
            array_push($profissoes, Profissao::ENGENHEIRO);
        }

        $fieldOptions['fkCseProfissao'] = [
            'label' => 'label.imobiliarioLicenca.profissao',
            'class' => Profissao::class,
            'placeholder' => 'label.selecione',
            'choice_label' => 'nomProfissao',
            'mapped' => false,
            'required' => false,
            'query_builder' => function (EntityRepository $er) use ($profissoes) {
                $qb = $er->createQueryBuilder('o');
                $qb->where($qb->expr()->in('o.codProfissao', $profissoes));
                return $qb;
            }
        ];

        $fieldOptions['fkSwUf'] = [
            'label' => 'label.imobiliarioLicenca.estado',
            'class' => SwUf::class,
            'placeholder' => 'label.selecione',
            'choice_label' => 'nomUf',
            'mapped' => false,
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->where('o.codUf != :codUf')
                    ->setParameter('codUf', 0);
            }
        ];

        $fieldOptions['fkImobiliarioResponsavelTecnico'] = [
            'label' => 'label.imobiliarioLicenca.responsavelTecnico',
            'class' => ResponsavelTecnico::class,
            'req_params' => [
                'codProfissao' => 'varJsCodProfissao',
                'codUf' => 'varJsCodUf',
                'codTipo' => $this->codTipo
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->leftJoin('o.fkSwCgm', 'cgm');
                $qb->leftJoin('cgm.fkEconomicoResponsaveis', 'er');
                $qb->where('er.numcgm is not null');
                if ($request->get('codProfissao') != '') {
                    $qb->andWhere('o.codProfissao = :codProfissao');
                    $qb->setParameter('codProfissao', (int) $request->get('codProfissao'));
                }
                if ($request->get('codUf') != '') {
                    $qb->andWhere('o.codUf = :codUf');
                    $qb->setParameter('codUf', (int) $request->get('codUf'));
                }
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->like('LOWER(cgm.nomCgm)', $qb->expr()->literal('%' . strtolower($term) . '%')),
                    $qb->expr()->eq('o.numcgm', ':numCgm'),
                    $qb->expr()->like('LOWER(o.numRegistro)', $qb->expr()->literal('%' . strtolower($term) . '%'))
                ));
                $qb->setParameter('numCgm', (int) $term);
                return $qb;
            },
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['licencaResponsaveisTecnicos_lista'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/Licencas/Licenca/licencaResponsaveisTecnicos.html.twig',
            'data' => array(
                'licencaResponsaveisTecnicos' => array()
            )
        );

        $fieldOptions['emissaoDocumentos'] = [
            'label' => 'label.imobiliarioLicenca.emissaoDocumentos',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['fkAdministracaoModeloDocumento'] = [
            'label' => 'label.imobiliarioLicenca.modelo',
            'class' => ModeloDocumento::class,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->leftJoin('o.fkImobiliarioTipoLicencaDocumentos', 'tld')
                    ->where('tld.codDocumento is not null')
                    ->andWhere('tld.codTipo = :codTipo')
                    ->setParameter('codTipo', $this->codTipo);
            }
        ];

        if ($this->id($this->getSubject())) {
            /** @var Licenca $licenca */
            $licenca = $this->getSubject();

            $fieldOptions['codLicenca']['data'] = $licenca->getCodLicenca();
            $fieldOptions['exercicio']['data'] = $licenca->getExercicio();

            if ($licenca->getFkImobiliarioLicencaImoveis()->count()) {
                $fieldOptions['area']['data'] = number_format($licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioLicencaImovelArea()->getArea(), 2, ',', '.');
            } else {
                $fieldOptions['area']['data'] = number_format($licenca->getFkImobiliarioLicencaLotes()->last()->getFkImobiliarioLicencaLoteArea()->getArea(), 2, ',', '.');
            }

            if ($licenca->getFkImobiliarioLicencaProcessos()->count()) {
                $fieldOptions['fkSwClassificacao']['data'] = $licenca->getFkImobiliarioLicencaProcessos()->last()->getFkSwProcesso()->getFkSwAssunto()->getFkSwClassificacao();
                $fieldOptions['fkSwAssunto']['data'] = $licenca->getFkImobiliarioLicencaProcessos()->last()->getFkSwProcesso()->getFkSwAssunto();
                $fieldOptions['fkSwProcesso']['data'] = $licenca->getFkImobiliarioLicencaProcessos()->last()->getFkSwProcesso();
            }

            $fieldOptions['licencaResponsaveisTecnicos_lista']['data'] = ['licencaResponsaveisTecnicos' => $licenca->getFkImobiliarioLicencaResponsavelTecnicos()];

            $fieldOptions['fkAdministracaoModeloDocumento']['data'] = $licenca->getFkImobiliarioLicencaDocumentos()->last()->getFkAdministracaoModeloDocumento();
        }

        $formMapper->add('codTipo', 'hidden', $fieldOptions['codTipo']);
        $formMapper->add('codLicenca', 'hidden', $fieldOptions['codLicenca']);
        $formMapper->add('exercicio', 'hidden', $fieldOptions['exercicio']);
        $formMapper->add('area', 'text', $fieldOptions['area']);
        $formMapper->end();

        $formMapper->with('label.imobiliarioLicenca.processo');
        $formMapper->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao']);
        $formMapper->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto']);
        $formMapper->add('fkSwProcesso', 'autocomplete', $fieldOptions['fkSwProcesso']);
        $formMapper->end();

        $formMapper->with('label.imobiliarioLicenca.observacoes');
        $formMapper->add('observacao', 'textarea', $fieldOptions['observacao']);
        $formMapper->end();

        $formMapper->with('label.imobiliarioLicenca.atributos', array('class' => 'atributoDinamicoWith'));
        $formMapper->add('atributosDinamicos', 'text', array('mapped' => false, 'required' => false));
        $formMapper->end();

        $formMapper->with('label.imobiliarioLicenca.validadeLicenca');
        $formMapper->add('dtInicio', 'sonata_type_date_picker', $fieldOptions['dtInicio']);
        $formMapper->add('dtTermino', 'sonata_type_date_picker', $fieldOptions['dtTermino']);
        $formMapper->end();

        $formMapper->with('label.imobiliarioLicenca.responsaveisTecnicos');
        $formMapper->add('fkCseProfissao', 'entity', $fieldOptions['fkCseProfissao']);
        $formMapper->add('fkSwUf', 'entity', $fieldOptions['fkSwUf']);
        $formMapper->add('fkImobiliarioResponsavelTecnico', 'autocomplete', $fieldOptions['fkImobiliarioResponsavelTecnico']);
        $formMapper->add('licencaResponsaveisTecnicos_lista', 'customField', $fieldOptions['licencaResponsaveisTecnicos_lista']);
        $formMapper->end();

        $formMapper->with('label.imobiliarioLicenca.atributosLicenca', array('class' => 'atributoDinamicoLicenca'));
        $formMapper->add('atributosDinamicosLicenca', 'text', array('mapped' => false, 'required' => false));
        $formMapper->end();

        $formMapper->with('label.imobiliarioLicenca.dadosDocumento');
        $formMapper->add('fkAdministracaoModeloDocumento', 'entity', $fieldOptions['fkAdministracaoModeloDocumento']);
        $formMapper->add('emissaoDocumentos', 'checkbox', $fieldOptions['emissaoDocumentos']);
        $formMapper->end();

        if (!$this->id($this->getSubject())) {
            $admin = $this;
            $formMapper->getFormBuilder()->addEventListener(
                FormEvents::PRE_SUBMIT,
                function (FormEvent $event) use ($formMapper, $admin) {
                    $form = $event->getForm();
                    $data = $event->getData();
                    $subject = $admin->getSubject($data);

                    if ($form->has('fkImobiliarioConstrucao')) {
                        $form->remove('fkImobiliarioConstrucao');

                        $fkImobiliarioConstrucao = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                            'fkImobiliarioConstrucao',
                            'entity',
                            null,
                            array(
                                'class' => Construcao::class,
                                'label' => 'label.imobiliarioLicenca.edificacaoConstrucao',
                                'mapped' => false,
                                'auto_initialize' => false,
                                'query_builder' => function (EntityRepository $er) use ($data) {
                                    $qb = $er->createQueryBuilder('o');
                                    $qb->leftJoin('o.fkImobiliarioUnidadeDependentes', 'ud');
                                    $qb->leftJoin('o.fkImobiliarioConstrucaoEdificacoes', 'ce');
                                    $qb->leftJoin('ce.fkImobiliarioUnidadeAutonomas', 'ua');
                                    $qb->where($qb->expr()->orX(
                                        $qb->expr()->eq('ud.inscricaoMunicipal', ':inscricaoMunicipal'),
                                        $qb->expr()->eq('ua.inscricaoMunicipal', ':inscricaoMunicipal')
                                    ));
                                    $qb->setParameter('inscricaoMunicipal', $data['fkImobiliarioImovel']);
                                },
                                'placeholder' => 'label.selecione'
                            )
                        );
                        $form->add($fkImobiliarioConstrucao);
                    }

                    if ($form->has('fkImobiliarioLote')) {
                        $form->remove('fkImobiliarioLote');

                        $fkImobiliarioLote = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                            'fkImobiliarioLote',
                            'entity',
                            null,
                            array(
                                'class' => Lote::class,
                                'label' => 'label.imobiliarioLicenca.lote',
                                'mapped' => false,
                                'auto_initialize' => false,
                                'query_builder' => function (EntityRepository $er) use ($data) {
                                    $qb = $er->createQueryBuilder('o');
                                    $qb->leftJoin('o.fkImobiliarioLoteLocalizacao', 'l');
                                    $qb->andWhere('l.codLocalizacao = :codLocalizacao');
                                    $qb->setParameter('codLocalizacao', $data['fkImobiliarioLocalizacao']);
                                    $qb->leftJoin('o.fkImobiliarioLoteParcelados', 'p');
                                    $qb->andWhere($qb->expr()->orX(
                                        $qb->expr()->isNull('p.validado'),
                                        $qb->expr()->eq('p.validado', 'true')
                                    ));
                                    $qb->leftJoin('o.fkImobiliarioBaixaLotes', 'b');
                                    $qb->andWhere('b.dtInicio is not null AND b.dtTermino is not null OR b.dtInicio is null');
                                    $qb->leftJoin('o.fkImobiliarioImovelLotes', 'i');
                                    $qb->andWhere('i.inscricaoMunicipal is not null');
                                    $qb->orderBy('o.codLote', 'ASC');
                                },
                                'placeholder' => 'label.selecione'
                            )
                        );
                        $form->add($fkImobiliarioLote);
                    }

                    if ($form->has('fkImobiliarioLoteamento')) {
                        $form->remove('fkImobiliarioLoteamento');

                        $fkImobiliarioLoteamento = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                            'fkImobiliarioLoteamento',
                            'entity',
                            null,
                            array(
                                'class' => Loteamento::class,
                                'label' => 'label.imobiliarioLicenca.loteamento',
                                'mapped' => false,
                                'auto_initialize' => false,
                                'query_builder' => function (EntityRepository $er) use ($data) {
                                    $qb = $er->createQueryBuilder('o');
                                    $qb->leftJoin('o.fkImobiliarioLoteamentoLoteOrigens', 'lo');
                                    $qb->andWhere('lo.codLote = :codLote');
                                    $qb->setParameter('codLote', $data['fkImobiliarioLote']);
                                    $qb->orderBy('o.codLoteamento', 'ASC');
                                },
                                'placeholder' => 'label.selecione'
                            )
                        );
                        $form->add($fkImobiliarioLoteamento);
                    }

                    if ($form->has('fkImobiliarioParcelamentoSolo')) {
                        $form->remove('fkImobiliarioParcelamentoSolo');

                        $fkImobiliarioParcelamentoSolo = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                            'fkImobiliarioParcelamentoSolo',
                            'entity',
                            null,
                            array(
                                'class' => ParcelamentoSolo::class,
                                'label' => 'label.imobiliarioLicenca.desmembramento',
                                'mapped' => false,
                                'auto_initialize' => false,
                                'query_builder' => function (EntityRepository $er) use ($data) {
                                    $qb = $er->createQueryBuilder('o');
                                    $qb->where('o.codLote = :codLote');
                                    $qb->setParameter('codLote', $data['fkImobiliarioLote']);
                                    $qb->orderBy('o.codLoteamento', 'ASC');
                                },
                                'placeholder' => 'label.selecione'
                            )
                        );
                        $form->add($fkImobiliarioParcelamentoSolo);
                    }

                    if ($form->has('fkImobiliarioImovel')) {
                        $form->remove('fkImobiliarioImovel');

                        $fkImobiliarioImovel = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                            'fkImobiliarioImovel',
                            'entity',
                            null,
                            array(
                                'class' => Imovel::class,
                                'label' => 'label.imobiliarioLicenca.inscricaoImobiliario',
                                'mapped' => false,
                                'auto_initialize' => false,
                                'query_builder' => function (EntityRepository $er) use ($data) {
                                    $qb = $er->createQueryBuilder('o');
                                    $qb->leftJoin('o.fkImobiliarioImovelConfrontacao', 'ic');
                                    $qb->where('ic.codLote = :codLote');
                                    $qb->setParameter('codLote', $data['fkImobiliarioLote']);
                                    $qb->orderBy('o.codLoteamento', 'ASC');
                                },
                                'placeholder' => 'label.selecione'
                            )
                        );
                        $form->add($fkImobiliarioImovel);
                    }
                }
            );
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        if ((is_null($this->codTipo)) && (!($this->id($this->getSubject())))) {
            $this->codTipo = $this->getPersistentParameter('codTipo');
        } else {
            $this->codTipo = $this->getSubject()->getCodTipo();
        }

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $this->setForm($formMapper);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('codLicenca')
            ->add('exercicio')
            ->add('codTipo')
            ->add('numcgm')
            ->add('timestamp')
            ->add('dtInicio')
            ->add('dtTermino')
            ->add('observacao')
        ;
    }

    /**
     * @param Licenca $licenca
     */
    public function prePersist($licenca)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $licencaModel = new LicencaModel($em);

        $container = $this->getConfigurationPool()->getContainer();

        /** @var Usuario $user */
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        if (!$this->getTipoLicenca()) {
            /** @var TipoLicenca $tipoLicenca */
            $tipoLicenca = $this->getForm()->get('fkImobiliarioTipoLicenca')->getData();

            if ($licencaModel->retornaImobiliarioPermissao($usuario, $tipoLicenca)) {
                $this->forceRedirect($this->generateUrl('create', ['codTipo' => $tipoLicenca->getCodTipo()]));
            } else {
                $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.imobiliarioLicenca.erroPermissao'));
                $this->getDoctrine()->clear();
                $this->forceRedirect($this->request->headers->get('referer'));
            }
        }

        $licencaModel->concederLicenca($this->getTipoLicenca(), $licenca, $this->getExercicio(), $usuario, $this->getForm(), $this->getRequest());
    }

    /**
     * @param Licenca $licenca
     */
    public function preUpdate($licenca)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $licencaModel = new LicencaModel($em);

        $container = $this->getConfigurationPool()->getContainer();

        /** @var Usuario $user */
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        if (!$licencaModel->retornaImobiliarioPermissao($usuario, $licenca->getFkImobiliarioPermissao()->getFkImobiliarioTipoLicenca())) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.imobiliarioLicenca.erroPermissao'));
            $this->getDoctrine()->clear();
            $this->forceRedirect($this->request->headers->get('referer'));
        }

        $licencaModel->alterarLicenca($licenca, $usuario, $this->getForm(), $this->getRequest());
    }

    /**
     * @param Licenca $licenca
     */
    public function postPersist($licenca)
    {
        $this->forceRedirect($this->generateUrl('create', ['codTipo' => '']));
    }
}
