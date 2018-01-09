<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra;
use Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraAliquota;
use Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraValorM2;
use Urbem\CoreBundle\Entity\Imobiliario\Trecho;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\SwBairro;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Imobiliario\CadastroImobiliarioConfiguracaoModel;
use Urbem\CoreBundle\Model\Imobiliario\FaceQuadraModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\TributarioBundle\Controller\Imobiliario\ConfiguracaoController;

class FaceQuadraAdmin extends AbstractAdmin
{
    const NAO_INFORMADO = 0;

    protected $baseRouteName = 'urbem_tributario_imobiliario_face_quadra';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/face-quadra';
    protected $exibirBotaoEditar = true;
    protected $exibirBotaoExcluir = true;
    protected $includeJs = array(
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/tributario/javascripts/imobiliario/face-quadra.js'
    );

    /**
     * @param FaceQuadra $faceQuadra
     * @return boolean
     */
    public function verificaBaixaFaceQuadra(FaceQuadra $faceQuadra)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new FaceQuadraModel($em))->verificaBaixa($faceQuadra);
    }

    /**
     * @return bool
     */
    public function verificaCaracteristicasFaceQuadra()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new FaceQuadraModel($em))->verificaCaracteristicas();
    }

    /**
     * @return bool
     */
    public function verificaAliquota()
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        return (new CadastroImobiliarioConfiguracaoModel($em))
            ->verificaConfiguracao(
                $this->getExercicio(),
                Modulo::MODULO_CADASTRO_IMOBILIARIO,
                ConfiguracaoController::PARAMETRO_ALIQUOTAS,
                $this->getTranslator()->trans('label.imobiliarioFaceQuadra.modulo')
            );
    }

    /**
     * @return bool
     */
    public function verificaValorMD()
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        return (new CadastroImobiliarioConfiguracaoModel($em))
            ->verificaConfiguracao(
                $this->getExercicio(),
                Modulo::MODULO_CADASTRO_IMOBILIARIO,
                ConfiguracaoController::PARAMETRO_VALOR_MD,
                $this->getTranslator()->trans('label.imobiliarioFaceQuadra.modulo')
            );
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consulta_face_quadra_trecho', 'consulta-face-quadra-trecho');
        $collection->add('baixar', $this->getRouterIdParameter() . '/baixar');
        $collection->add('baixar_face_quadra', 'baixar-face-quadra');
        $collection->add('reativar', $this->getRouterIdParameter() . '/reativar');
        $collection->add('reativar_face_quadra', 'reativar-face-quadra');
        $collection->add('caracteristicas', $this->getRouterIdParameter() . '/caracteristicas');
        $collection->add('alterar_caracteristicas', 'alterar-caracteristicas');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('fkImobiliarioLocalizacao', null, array('label' => 'label.imobiliarioFaceQuadra.localizacao'))
            ->add('codFace', null, array('label' => 'label.imobiliarioFaceQuadra.codFace'))
            ->add(
                'fkSwUf',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.imobiliarioFaceQuadra.estado',
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
                    }
                )
            )
            ->add(
                'fkSwMunicipio',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.imobiliarioFaceQuadra.municipio',
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
                    }
                )
            )
            ->add(
                'fkSwBairro',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.imobiliarioFaceQuadra.bairro',
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
                'fkImobiliarioFaceQuadraTrechos.fkImobiliarioTrecho.fkSwLogradouro',
                null,
                array(
                    'label' => 'label.imobiliarioFaceQuadra.logradouro'
                ),
                null,
                array(),
                array(
                    'admin_code' => 'administrativo.admin.sw_logradouro'
                )
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

        if (!count($value['value'])) {
            return;
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkImobiliarioLocalizacao.codigoComposto', 'text', array('label' => 'label.imobiliarioFaceQuadra.localizacao'))
            ->add('codFace', 'text', array('label' => 'label.imobiliarioFaceQuadra.codFace'))
            ->add('fkImobiliarioLocalizacao.nomLocalizacao', 'text', array('label' => 'label.imobiliarioFaceQuadra.nomLocalizacao'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'TributarioBundle:Sonata/Imobiliario/FaceQuadra/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'TributarioBundle:Sonata/Imobiliario/FaceQuadra/CRUD:list__action_delete.html.twig'),
                    'baixar' => array('template' => 'TributarioBundle:Sonata/Imobiliario/FaceQuadra/CRUD:list__action_baixar.html.twig'),
                    'caracteristicas' => array('template' => 'TributarioBundle:Sonata/Imobiliario/FaceQuadra/CRUD:list__action_caracteristicas.html.twig')
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
        (new FaceQuadraModel($em))->consultaFaceQuadraTrecho(35, 95, 95, 1);
        $configuracaoModel = new ConfiguracaoModel($em);
        $codUf = $configuracaoModel->pegaConfiguracao('cod_uf', Modulo::MODULO_ADMINISTRATIVO, $this->getExercicio(), true);
        $codMunicipio = $configuracaoModel->pegaConfiguracao('cod_municipio', Modulo::MODULO_ADMINISTRATIVO, $this->getExercicio(), true);

        $uf = $municipio = null;
        if (((int) $codUf) && ((int) $codMunicipio)) {
            $uf = $em->getRepository(SwUf::class)->find((integer) $codUf);
            $municipio = $em->getRepository(SwMunicipio::class)->findOneBy(array('codMunicipio' => (integer) $codMunicipio, 'codUf' => (integer) $codUf));
        }

        $fieldOptions = array();

        $fieldOptions['codFace'] = array(
            'label' => 'label.imobiliarioFaceQuadra.codFace',
            'required' => false,
            'mapped' => false
        );

        $fieldOptions['fkImobiliarioLocalizacao'] = array(
            'label' => 'label.imobiliarioFaceQuadra.localizacao',
            'placeholder' => 'label.selecione',
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkSwUf'] = array(
            'label' => 'label.imobiliarioFaceQuadra.estado',
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
            'label' => 'label.imobiliarioFaceQuadra.municipio',
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

        $fieldOptions['fkImobiliarioTrecho'] = array(
            'label' => 'label.imobiliarioFaceQuadra.trecho',
            'class' => Trecho::class,
            'choice_value' => 'codTrecho',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkImobiliarioFaceQuadraTrechos'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/FaceQuadra/faceQuadraTrechos.html.twig',
            'attr' => array(
                'style' => 'display:none;'
            ),
            'data' => array(
                'faceQuadraTrechos' => array()
            )
        );

        $fieldOptions['fkImobiliarioFaceQuadraValorM2s.valorM2Territorial'] = [
            'label' => 'label.imobiliarioEdificacao.valorTerritorial',
            'attr' => [
                'class' => 'money '
            ],
            'currency' => 'BRL',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioFaceQuadraValorM2s.valorM2Predial'] = [
            'label' => 'label.imobiliarioEdificacao.aliquotaPredial',
            'attr' => [
                'class' => 'money '
            ],
            'currency' => 'BRL',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioFaceQuadraValorM2s.dtVigencia'] = [
            'label' => 'label.imobiliarioEdificacao.inicioVigencia',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioFaceQuadraValorM2s.fkNormasNorma'] = array(
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

        $fieldOptions['fkImobiliarioFaceQuadraAliquotas.aliquotaTerritorial'] = [
            'label' => 'label.imobiliarioEdificacao.valorTerritorial',
            'attr' => [
                'class' => 'money ',
            ],
            'currency' => 'BRL',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioFaceQuadraAliquotas.aliquotaPredial'] = [
            'label' => 'label.imobiliarioEdificacao.aliquotaPredial',
            'attr' => [
                'class' => 'money ',
            ],
            'currency' => 'BRL',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioFaceQuadraAliquotas.dtVigencia'] = [
            'label' => 'label.imobiliarioEdificacao.inicioVigencia',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioFaceQuadraAliquotas.fkNormasNorma'] = array(
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
            /** @var FaceQuadra $faceQuadra */
            $faceQuadra = $this->getSubject();

            $fieldOptions['codFace']['disabled'] = true;
            $fieldOptions['codFace']['data'] = $faceQuadra->getCodFace();

            $fieldOptions['fkImobiliarioLocalizacao']['mapped'] = false;
            $fieldOptions['fkImobiliarioLocalizacao']['disabled'] = true;
            $fieldOptions['fkImobiliarioLocalizacao']['data'] = $faceQuadra->getFkImobiliarioLocalizacao();

            $fieldOptions['fkImobiliarioFaceQuadraTrechos']['data'] = array(
                'faceQuadraTrechos' => $faceQuadra->getFkImobiliarioFaceQuadraTrechos()
            );

            if ($this->verificaValorMD() && $faceQuadra->getFkImobiliarioFaceQuadraValorM2s()->count()) {
                /** @var FaceQuadraValorM2 $faceQuadraValorM2 */
                $faceQuadraValorM2 = $faceQuadra->getFkImobiliarioFaceQuadraValorM2s()->current();

                $fieldOptions['fkImobiliarioFaceQuadraValorM2s.valorM2Territorial']['data'] = $faceQuadraValorM2->getValorM2Territorial();
                $fieldOptions['fkImobiliarioFaceQuadraValorM2s.valorM2Predial']['data'] = $faceQuadraValorM2->getValorM2Predial();
                $fieldOptions['fkImobiliarioFaceQuadraValorM2s.dtVigencia']['data'] = $faceQuadraValorM2->getDtVigencia();
                $fieldOptions['fkImobiliarioFaceQuadraValorM2s.fkNormasNorma']['data'] = $faceQuadraValorM2->getFkNormasNorma();
            }

            if ($this->verificaAliquota() && $faceQuadra->getFkImobiliarioFaceQuadraAliquotas()->count()) {
                /** @var FaceQuadraAliquota $faceQuadraAliquota */
                $faceQuadraAliquota = $faceQuadra->getFkImobiliarioFaceQuadraAliquotas()->current();

                $fieldOptions['fkImobiliarioFaceQuadraAliquotas.aliquotaTerritorial']['data'] = $faceQuadraAliquota->getAliquotaTerritorial();
                $fieldOptions['fkImobiliarioFaceQuadraAliquotas.aliquotaPredial']['data'] = $faceQuadraAliquota->getAliquotaPredial();
                $fieldOptions['fkImobiliarioFaceQuadraAliquotas.dtVigencia']['data'] = $faceQuadraAliquota->getDtVigencia();
                $fieldOptions['fkImobiliarioFaceQuadraAliquotas.fkNormasNorma']['data'] = $faceQuadraAliquota->getFkNormasNorma();
            }
        }

        $formMapper->with('label.imobiliarioFaceQuadra.dados');
        $formMapper->add('codFace', null, $fieldOptions['codFace']);
        $formMapper->add('fkImobiliarioLocalizacao', null, $fieldOptions['fkImobiliarioLocalizacao']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioFaceQuadra.atributos', array('class' => 'atributoDinamicoWith'));
        $formMapper->add('atributosDinamicos', 'text', array('mapped' => false, 'required' => false));
        $formMapper->end();

        if ($this->verificaValorMD()) {
            $formMapper
                ->with('label.imobiliarioEdificacao.valoresM2')
                ->add(
                    'fkImobiliarioFaceQuadraValorM2s.valorM2Territorial',
                    'money',
                    $fieldOptions['fkImobiliarioFaceQuadraValorM2s.valorM2Territorial']
                )
                ->add(
                    'fkImobiliarioFaceQuadraValorM2s.valorM2Predial',
                    'money',
                    $fieldOptions['fkImobiliarioFaceQuadraValorM2s.valorM2Predial']
                )
                ->add(
                    'fkImobiliarioFaceQuadraValorM2s.dtVigencia',
                    'sonata_type_date_picker',
                    $fieldOptions['fkImobiliarioFaceQuadraValorM2s.dtVigencia']
                )
                ->add(
                    'fkImobiliarioFaceQuadraValorM2s.fkNormasNorma',
                    'autocomplete',
                    $fieldOptions['fkImobiliarioFaceQuadraValorM2s.fkNormasNorma']
                )
                ->end()
            ;
        }

        if ($this->verificaAliquota()) {
            $formMapper
                ->with('label.imobiliarioEdificacao.aliquotas')
                ->add(
                    'fkImobiliarioFaceQuadraAliquotas.aliquotaTerritorial',
                    'money',
                    $fieldOptions['fkImobiliarioFaceQuadraAliquotas.aliquotaTerritorial']
                )
                ->add(
                    'fkImobiliarioFaceQuadraAliquotas.aliquotaPredial',
                    'money',
                    $fieldOptions['fkImobiliarioFaceQuadraAliquotas.aliquotaPredial']
                )
                ->add(
                    'fkImobiliarioFaceQuadraAliquotas.dtVigencia',
                    'sonata_type_date_picker',
                    $fieldOptions['fkImobiliarioFaceQuadraAliquotas.dtVigencia']
                )
                ->add(
                    'fkImobiliarioFaceQuadraAliquotas.fkNormasNorma',
                    'autocomplete',
                    $fieldOptions['fkImobiliarioFaceQuadraAliquotas.fkNormasNorma']
                )
                ->end()
            ;
        }

        $formMapper->with('label.imobiliarioFaceQuadra.trecho');
        $formMapper->add('fkSwUf', 'entity', $fieldOptions['fkSwUf']);
        $formMapper->add('fkSwMunicipio', 'entity', $fieldOptions['fkSwMunicipio']);
        $formMapper->add('fkImobiliarioTrecho', 'entity', $fieldOptions['fkImobiliarioTrecho']);
        $formMapper->add('fkImobiliarioFaceQuadraTrechos', 'customField', $fieldOptions['fkImobiliarioFaceQuadraTrechos']);
        $formMapper->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        if ($this->verificaBaixaFaceQuadra($this->getSubject())) {
            $this->exibirBotaoEditar = false;
            $this->exibirBotaoExcluir = false;
        }

        $showMapper
            ->with('label.imobiliarioFaceQuadra.modulo')
            ->add('codFace', 'text', array('label' => 'label.imobiliarioFaceQuadra.codFace'))
            ->add('fkImobiliarioLocalizacao', 'text', array('label' => 'label.imobiliarioFaceQuadra.localizacao'))
            ->add('atributos', 'customField', array(
                'label' => 'label.imobiliarioFaceQuadra.atributos',
                'template' => 'TributarioBundle:Sonata/Imobiliario/FaceQuadra/CRUD:custom_show_atributos.html.twig',
                'data' => $this->getSubject()
            ))
            ->add('fkImobiliarioFaceQuadraTrechos', 'collection', array('label' => 'label.imobiliarioFaceQuadra.listaTrechos'))
            ->end()
        ;
    }

    /**
     * @param FaceQuadra $object
     */
    public function prePersist($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $faceQuadraModel = new FaceQuadraModel($em);

        $object->setCodFace($faceQuadraModel->getProximoCodFaceQuadra($object->getCodLocalizacao()));
        $em->persist($object);

        if ($this->verificaValorMD()) {
            $faceQuadraModel->insereValorMD($object, $this->getForm());
        }

        if ($this->verificaValorMD()) {
            $faceQuadraModel->insereAliquota($object, $this->getForm());
        }

        $faceQuadraModel->faceQuadraTrechos($object, $this->request->request->get('faceQuadraTrecho'));
        $faceQuadraModel->atributoDinamico($object, $this->request->request->get('atributoDinamico'));
    }

    public function preUpdate($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $faceQuadraModel = new FaceQuadraModel($em);

        if ($this->verificaValorMD()) {
            $faceQuadraModel->insereValorMD($object, $this->getForm());
        }

        if ($this->verificaValorMD()) {
            $faceQuadraModel->insereAliquota($object, $this->getForm());
        }

        $faceQuadraModel->faceQuadraTrechos($object, $this->request->request->get('faceQuadraTrecho'));
        $faceQuadraModel->atributoDinamico($object, $this->request->request->get('atributoDinamico'));
    }

    /**
     * @param mixed $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function preRemove($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        if ($this->verificaBaixaFaceQuadra($object)) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.imobiliarioFaceQuadra.erroExcluir'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }
    }

    /**
     * @param FaceQuadra $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getCodFace())
            ? (string) $object
            : $this->getTranslator()->trans('label.imobiliarioFaceQuadra.modulo');
    }
}
