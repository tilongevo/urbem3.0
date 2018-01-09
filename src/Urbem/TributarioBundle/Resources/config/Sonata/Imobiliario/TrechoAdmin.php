<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Imobiliario\Trecho;
use Urbem\CoreBundle\Entity\Imobiliario\TrechoAliquota;
use Urbem\CoreBundle\Entity\Imobiliario\TrechoValorM2;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\SwBairro;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Imobiliario\CadastroImobiliarioConfiguracaoModel;
use Urbem\CoreBundle\Model\Imobiliario\TrechoModel;
use Urbem\CoreBundle\Model\SwLogradouroModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\TributarioBundle\Controller\Imobiliario\ConfiguracaoController;

class TrechoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_trecho';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/trecho';
    protected $exibirBotaoEditar = true;
    protected $exibirBotaoExcluir = true;
    protected $includeJs = array(
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/tributario/javascripts/imobiliario/trecho.js'
    );
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => "ASC",
        '_sort_by' => 'codTrecho, sequencia'
    );

    const NAO_INFORMADO = 0;

    /**
     * @param Trecho $trecho
     * @return boolean
     */
    public function verificaBaixaTrecho(Trecho $trecho)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new TrechoModel($em))->verificaBaixa($trecho);
    }

    /**
     * @return bool
     */
    public function verificaCaracteristicasTrecho()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new TrechoModel($em))->verificaCaracteristicas();
    }

    public function verificaAliquota()
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        return (new CadastroImobiliarioConfiguracaoModel($em))
            ->verificaConfiguracao(
                $this->getExercicio(),
                Modulo::MODULO_CADASTRO_IMOBILIARIO,
                ConfiguracaoController::PARAMETRO_ALIQUOTAS,
                $this->getTranslator()->trans('label.imobiliarioTrecho.modulo')
            );
    }

    public function verificaValorMD()
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        return (new CadastroImobiliarioConfiguracaoModel($em))
            ->verificaConfiguracao(
                $this->getExercicio(),
                Modulo::MODULO_CADASTRO_IMOBILIARIO,
                ConfiguracaoController::PARAMETRO_VALOR_MD,
                $this->getTranslator()->trans('label.imobiliarioTrecho.modulo')
            );
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consultar_sequencia', 'consultar-sequencia');
        $collection->add('consultar_proxima_sequencia', 'consultar-proxima-sequencia');
        $collection->add('baixar', $this->getRouterIdParameter() . '/baixar');
        $collection->add('baixar_trecho', 'baixar-localizacao');
        $collection->add('reativar', $this->getRouterIdParameter() . '/reativar');
        $collection->add('reativar_trecho', 'reativar-localizacao');
        $collection->add('caracteristicas', $this->getRouterIdParameter() . '/caracteristicas');
        $collection->add('alterar_caracteristicas', 'alterar-caracteristicas');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

        $this->setBreadCrumb();

        $datagridMapper
            ->add(
                'fkSwUf',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.imobiliarioTrecho.estado',
                    'callback' => array($this, 'getSearchFilter')
                ),
                'entity',
                array(
                    'class' => SwUf::class,
                    'choice_value' => 'codUf',
                    'choice_label' => 'nomUf',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('uf')
                            ->where('uf.codUf != :codUf')
                            ->setParameter('codUf', self::NAO_INFORMADO);
                    },
                    'attr' => array(
                        'required' => 'required'
                    )
                )
            )
            ->add(
                'fkSwMunicipio',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.imobiliarioTrecho.municipio',
                    'callback' => array($this, 'getSearchFilter')
                ),
                'entity',
                array(
                    'class' => SwMunicipio::class,
                    'choice_value' => 'codMunicipio',
                    'choice_label' => 'nomMunicipio',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('m')
                            ->where('m.codMunicipio != :codMunicipio')
                            ->setParameter('codMunicipio', self::NAO_INFORMADO);
                    },
                    'attr' => array(
                        'required' => 'required'
                    )
                )
            )
            ->add(
                'fkSwBairro',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.imobiliarioTrecho.bairro',
                    'callback' => array($this, 'getSearchFilter')
                ),
                'entity',
                array(
                    'class' => SwBairro::class,
                    'choice_value' => 'codBairro',
                    'choice_label' => 'nomBairro'

                )
            )
            ->add(
                'fkSwLogradouro',
                null,
                array(
                    'label' => 'label.imobiliarioTrecho.logradouro'
                ),
                null,
                array(),
                array(
                    'admin_code' => 'administrativo.admin.sw_logradouro'
                )
            )
            ->add('sequencia', null, array('label' => 'label.imobiliarioTrecho.sequencia'))
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

        if (!count($value['value'])) {
            return;
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        if ($this->verificaBaixaTrecho($this->getSubject())) {
            $this->exibirBotaoEditar = false;
            $this->exibirBotaoExcluir = false;
        }

        $showMapper
            ->with('label.imobiliarioTrecho.dados')
            ->add('codigoComposto', 'text', array('label' => 'label.imobiliarioTrecho.codTrecho'))
            ->add('fkSwLogradouro', 'text', array('label' => 'label.imobiliarioTrecho.nomLogradouro', 'admin_code' => 'administrativo.admin.sw_logradouro'))
            ->add('extensao', 'text', array('label' => 'label.imobiliarioTrecho.extensao'))
            ->add('atributos', 'customField', array(
                'label' => 'label.imobiliarioTrecho.atributos',
                'template' => 'TributarioBundle:Sonata/Imobiliario/Trecho/CRUD:custom_show_atributos.html.twig',
                'data' => $this->getSubject()
            ))
            ->end()
        ;
    }

    /**
     * @param Trecho $object
     */
    public function prePersist($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $trechoModel = new TrechoModel($em);

        $object->setCodTrecho($trechoModel->getCodTrecho($object->getCodLogradouro()));
        $em->persist($object);

        if ($this->verificaValorMD()) {
            $trechoModel->insereValorMD($object, $this->getForm());
        }

        if ($this->verificaAliquota()) {
            $trechoModel->insereAliquota($object, $this->getForm());
        }

        if ($this->request->request->get('atributoDinamico')) {
            $trechoModel->atributoDinamico($object, $this->request->request->get('atributoDinamico'));
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codigoComposto', 'text', array('label' => 'label.imobiliarioTrecho.codigo'))
            ->add('fkSwLogradouro', 'text', array('label' => 'label.imobiliarioTrecho.logradouro', 'admin_code' => 'administrativo.admin.sw_logradouro'))
            ->add('extensao', 'customField', array(
                'label' => 'label.imobiliarioTrecho.extensao',
                'template' => 'TributarioBundle::Imobiliario/Trecho/extensao.html.twig',
            ))

            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Trecho/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Trecho/CRUD:list__action_delete.html.twig'),
                    'baixar' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Trecho/CRUD:list__action_baixar.html.twig'),
                    'caracteristicas' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Trecho/CRUD:list__action_caracteristicas.html.twig')
                ),
                'header_style' => 'width: 20%'
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
        $configuracaoModel = new ConfiguracaoModel($em);
        $codUf = $configuracaoModel->pegaConfiguracao('cod_uf', Modulo::MODULO_ADMINISTRATIVO, $this->getExercicio(), true);
        $codMunicipio = $configuracaoModel->pegaConfiguracao('cod_municipio', Modulo::MODULO_ADMINISTRATIVO, $this->getExercicio(), true);

        $uf = $municipio = null;
        if (((int) $codUf) && ((int) $codMunicipio)) {
            $uf = $em->getRepository(SwUf::class)->find((integer) $codUf);
            $municipio = $em->getRepository(SwMunicipio::class)->findOneBy(array('codMunicipio' => (integer) $codMunicipio, 'codUf' => (integer) $codUf));
        }

        $fieldOptions = array();

        $fieldOptions['codTrecho'] = array(
            'mapped' => false
        );

        $fieldOptions['fkSwUf'] = array(
            'label' => 'label.imobiliarioTrecho.estado',
            'class' => SwUf::class,
            'choice_label' => 'nomUf',
            'choice_value' => 'codUf',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('uf')
                    ->where('uf.codUf != :codUf')
                    ->setParameter('codUf', self::NAO_INFORMADO);
            },
            'data' => $uf,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkSwMunicipio'] = array(
            'label' => 'label.imobiliarioTrecho.municipio',
            'class' => SwMunicipio::class,
            'choice_label' => 'nomMunicipio',
            'choice_value' => 'codMunicipio',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('m')
                    ->where('m.codMunicipio != :codMunicipio')
                    ->setParameter('codMunicipio', self::NAO_INFORMADO);
            },
            'data' => $municipio,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkSwBairro'] = array(
            'label' => 'label.imobiliarioTrecho.bairro',
            'class' => SwBairro::class,
            'choice_label' => 'nomBairro',
            'choice_value' => 'codBairro',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkSwLogradouro'] = array(
            'label' => 'label.imobiliarioTrecho.logradouro',
            'choice_value' => 'codLogradouro',
            'placeholder' => 'label.selecione',
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['sequencia'] = array(
            'label' => 'label.imobiliarioTrecho.sequencia'
        );

        $fieldOptions['extensao'] = array(
            'label' => 'label.imobiliarioTrecho.extensao',
            'data' => 0.00
        );

        $fieldOptions['fkImobiliarioTrechoValorM2s.valorM2Territorial'] = [
            'label' => 'label.imobiliarioEdificacao.valorTerritorial',
            'attr' => [
                'class' => 'money '
            ],
            'currency' => 'BRL',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioTrechoValorM2s.valorM2Predial'] = [
            'label' => 'label.imobiliarioEdificacao.aliquotaPredial',
            'attr' => [
                'class' => 'money '
            ],
            'currency' => 'BRL',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioTrechoValorM2s.dtVigencia'] = [
            'label' => 'label.imobiliarioEdificacao.inicioVigencia',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioTrechoValorM2s.fkNormasNorma'] = array(
            'label' => 'label.imobiliarioEdificacao.fundamentacaoLegalValorM2',
            'class' => Norma::class,
            'req_params' => [],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term) {
                $qb = $er->createQueryBuilder('o');
                $qb->innerJoin('o.fkNormasNormaTipoNormas', 'ntn');
                $qb->innerJoin('ntn.fkNormasTipoNorma', 'tn');
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->like('LOWER(tn.nomTipoNorma)', $qb->expr()->literal('%' . strtolower($term) . '%')),
                    $qb->expr()->eq('o.codNorma', ':codNorma'),
                    $qb->expr()->like('CONCAT(o.numNorma, \'/\', o.exercicio)', $qb->expr()->literal('%' . $term . '%')),
                    $qb->expr()->like('LOWER(o.numNorma)', $qb->expr()->literal('%' . strtolower($term) . '%')),
                    $qb->expr()->like('LOWER(o.descricao)', $qb->expr()->literal('%' . strtolower($term) . '%'))
                ));
                $qb->setParameter('codNorma', (int) $term);
                $qb->orderBy('o.codNorma', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => true,
        );

        $fieldOptions['fkImobiliarioTrechoAliquotas.aliquotaTerritorial'] = [
            'label' => 'label.imobiliarioEdificacao.valorTerritorial',
            'attr' => [
                'class' => 'money ',
            ],
            'currency' => 'BRL',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioTrechoAliquotas.aliquotaPredial'] = [
            'label' => 'label.imobiliarioEdificacao.aliquotaPredial',
            'attr' => [
                'class' => 'money ',
            ],
            'currency' => 'BRL',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioTrechoAliquotas.dtVigencia'] = [
            'label' => 'label.imobiliarioEdificacao.inicioVigencia',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioTrechoAliquotas.fkNormasNorma'] = array(
            'label' => 'label.imobiliarioEdificacao.fundamentacaoLegalValorM2',
            'class' => Norma::class,
            'req_params' => [],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term) {
                $qb = $er->createQueryBuilder('o');
                $qb->innerJoin('o.fkNormasNormaTipoNormas', 'ntn');
                $qb->innerJoin('ntn.fkNormasTipoNorma', 'tn');
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->like('LOWER(tn.nomTipoNorma)', $qb->expr()->literal('%' . strtolower($term) . '%')),
                    $qb->expr()->eq('o.codNorma', ':codNorma'),
                    $qb->expr()->like('CONCAT(o.numNorma, \'/\', o.exercicio)', $qb->expr()->literal('%' . $term . '%')),
                    $qb->expr()->like('LOWER(o.numNorma)', $qb->expr()->literal('%' . strtolower($term) . '%')),
                    $qb->expr()->like('LOWER(o.descricao)', $qb->expr()->literal('%' . strtolower($term) . '%'))
                ));
                $qb->setParameter('codNorma', (int) $term);
                $qb->orderBy('o.codNorma', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => true,
        );



        if ($this->id($this->getSubject())) {
            /** @var Trecho $trecho */
            $trecho = $this->getSubject();

            $fieldOptions['codTrecho']['data'] = $trecho->getCodTrecho();

            $fieldOptions['fkSwUf']['data'] = $trecho->getFkSwLogradouro()->getFkSwMunicipio()->getFkSwUf();
            $fieldOptions['fkSwMunicipio']['data'] = $trecho->getFkSwLogradouro()->getFkSwMunicipio();
            $fieldOptions['fkSwBairro']['data'] = $trecho->getFkSwLogradouro()->getFkSwBairroLogradouros()->current()->getFkSwBairro();

            $fieldOptions['fkSwLogradouro']['mapped'] = false;
            $fieldOptions['fkSwLogradouro']['data'] = $trecho->getFkSwLogradouro();

            $fieldOptions['sequencia']['mapped'] = false;
            $fieldOptions['sequencia']['data'] = $trecho->getSequencia();

            $fieldOptions['extensao']['data'] = $trecho->getExtensao();

            if ($this->verificaValorMD() && $trecho->getFkImobiliarioTrechoValorM2s()->count()) {
                /** @var TrechoValorM2 $trechoValorM2 */
                $trechoValorM2 = $trecho->getFkImobiliarioTrechoValorM2s()->current();

                $fieldOptions['fkImobiliarioTrechoValorM2s.valorM2Territorial']['data'] = $trechoValorM2->getValorM2Territorial();
                $fieldOptions['fkImobiliarioTrechoValorM2s.valorM2Predial']['data'] = $trechoValorM2->getValorM2Predial();
                $fieldOptions['fkImobiliarioTrechoValorM2s.dtVigencia']['data'] = $trechoValorM2->getDtVigencia();
                $fieldOptions['fkImobiliarioTrechoValorM2s.fkNormasNorma']['data'] = $trechoValorM2->getFkNormasNorma();
            }

            if ($this->verificaAliquota() && $trecho->getFkImobiliarioTrechoAliquotas()->count()) {
                /** @var TrechoAliquota $trechoAliquota */
                $trechoAliquota = $trecho->getFkImobiliarioTrechoAliquotas()->current();

                $fieldOptions['fkImobiliarioTrechoAliquotas.aliquotaTerritorial']['data'] = $trechoAliquota->getAliquotaTerritorial();
                $fieldOptions['fkImobiliarioTrechoAliquotas.aliquotaPredial']['data'] = $trechoAliquota->getAliquotaPredial();
                $fieldOptions['fkImobiliarioTrechoAliquotas.dtVigencia']['data'] = $trechoAliquota->getDtVigencia();
                $fieldOptions['fkImobiliarioTrechoAliquotas.fkNormasNorma']['data'] = $trechoAliquota->getFkNormasNorma();
            }
        }

        $formMapper
            ->with('label.imobiliarioTrecho.dados')
            ->add('codTrecho', 'hidden', $fieldOptions['codTrecho'])
            ->add('fkSwUf', 'entity', $fieldOptions['fkSwUf'])
            ->add('fkSwMunicipio', 'entity', $fieldOptions['fkSwMunicipio'])
            ->add('fkSwBairro', 'entity', $fieldOptions['fkSwBairro'])
            ->add('fkSwLogradouro', null, $fieldOptions['fkSwLogradouro'], ['admin_code' => 'administrativo.admin.sw_logradouro'])
            ->add('sequencia', null, $fieldOptions['sequencia'])
            ->add('extensao', null, $fieldOptions['extensao'])
            ->end()
            ->with('label.imobiliarioTrecho.atributos', array('class' => 'atributoDinamicoWith'))
            ->add('atributosDinamicos', 'text', array('mapped' => false, 'required' => false))
            ->end()
        ;

        if ($this->verificaValorMD()) {
            $formMapper
                ->with('label.imobiliarioEdificacao.valoresM2')
                ->add(
                    'fkImobiliarioTrechoValorM2s.valorM2Territorial',
                    'money',
                    $fieldOptions['fkImobiliarioTrechoValorM2s.valorM2Territorial']
                )
                ->add(
                    'fkImobiliarioTrechoValorM2s.valorM2Predial',
                    'money',
                    $fieldOptions['fkImobiliarioTrechoValorM2s.valorM2Predial']
                )
                ->add(
                    'fkImobiliarioTrechoValorM2s.dtVigencia',
                    'sonata_type_date_picker',
                    $fieldOptions['fkImobiliarioTrechoValorM2s.dtVigencia']
                )
                ->add(
                    'fkImobiliarioTrechoValorM2s.fkNormasNorma',
                    'autocomplete',
                    $fieldOptions['fkImobiliarioTrechoValorM2s.fkNormasNorma']
                )
                ->end()
            ;
        }

        if ($this->verificaAliquota()) {
            $formMapper
                ->with('label.imobiliarioEdificacao.aliquotas')
                ->add(
                    'fkImobiliarioTrechoAliquotas.aliquotaTerritorial',
                    'money',
                    $fieldOptions['fkImobiliarioTrechoAliquotas.aliquotaTerritorial']
                )
                ->add(
                    'fkImobiliarioTrechoAliquotas.aliquotaPredial',
                    'money',
                    $fieldOptions['fkImobiliarioTrechoAliquotas.aliquotaPredial']
                )
                ->add(
                    'fkImobiliarioTrechoAliquotas.dtVigencia',
                    'sonata_type_date_picker',
                    $fieldOptions['fkImobiliarioTrechoAliquotas.dtVigencia']
                )
                ->add(
                    'fkImobiliarioTrechoAliquotas.fkNormasNorma',
                    'autocomplete',
                    $fieldOptions['fkImobiliarioTrechoAliquotas.fkNormasNorma']
                )
                ->end()
            ;
        }
    }

    /**
     * @param Trecho $object
     */
    public function preUpdate($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $trechoModel = new TrechoModel($em);

        if ($this->verificaValorMD()) {
            $trechoModel->insereValorMD($object, $this->getForm());
        }

        if ($this->verificaAliquota()) {
            $trechoModel->insereAliquota($object, $this->getForm());
        }

        if ($this->request->request->get('atributoDinamico')) {
            $trechoModel->atributoDinamico($object, $this->request->request->get('atributoDinamico'));
        }
    }

    /**
     * @param Trecho $trecho
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function preRemove($trecho)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();

        //Baixa Trecho
        if ($this->verificaBaixaTrecho($trecho)) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.imobiliarioTrecho.erroExcluir'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }

        // Face de Quadra
        if ((new TrechoModel($em))->getFaceQuadraByTrecho($trecho->getCodTrecho(), $trecho->getCodLogradouro())) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.imobiliarioTrecho.erroExcluirFaceQuadra'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }

        // Domicilio Informado
        if (!$trecho->getFkSwLogradouro()->getFkEconomicoDomicilioInformados()->isEmpty()) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.imobiliarioTrecho.erroExcluirLogradouro'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }

        // Confrontações
        if (!$trecho->getFkImobiliarioConfrontacaoTrechos()->isEmpty()) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.imobiliarioTrecho.erroExcluirConfrontacao'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }
    }
}
