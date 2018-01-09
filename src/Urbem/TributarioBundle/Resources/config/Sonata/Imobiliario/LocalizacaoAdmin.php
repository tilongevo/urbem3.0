<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoAliquota;
use Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoValorM2;
use Urbem\CoreBundle\Entity\Imobiliario\Nivel;
use Urbem\CoreBundle\Entity\Imobiliario\Vigencia;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Model\Imobiliario\CadastroImobiliarioConfiguracaoModel;
use Urbem\CoreBundle\Model\Imobiliario\LocalizacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\TributarioBundle\Controller\Imobiliario\ConfiguracaoController;

class LocalizacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_localizacao';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/localizacao';
    protected $includeJs = array(
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/tributario/javascripts/imobiliario/localizacao.js'
    );
    protected $model = LocalizacaoModel::class;
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => "ASC",
        '_sort_by' => 'codigoComposto'
    );

    /**
     * @param Localizacao $localizacao
     * @return bool
     */
    public function verificaBaixaLocalizacao(Localizacao $localizacao)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new LocalizacaoModel($em))->verificaBaixa($localizacao);
    }

    /**
     * @param Localizacao $localizacao
     * @return bool
     */
    public function verificaCaracteristicasLocalizacao(Localizacao $localizacao)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new LocalizacaoModel($em))->verificaCaracteristicas($localizacao);
    }

    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consultar_nivel', 'consultar-nivel');
        $collection->add('consultar_localizacao', 'consultar-localizacao');
        $collection->add('consultar_mascara', 'consultar-mascara');
        $collection->add('consultar_mascara_filtro', 'consultar-mascara-filtro');
        $collection->add('consultar_codigo', 'consultar-codigo');
        $collection->add('baixar', $this->getRouterIdParameter() . '/baixar');
        $collection->add('baixar_localizacao', 'baixar-localizacao');
        $collection->add('reativar', $this->getRouterIdParameter() . '/reativar');
        $collection->add('reativar_localizacao', 'reativar-localizacao');
        $collection->add('caracteristicas', $this->getRouterIdParameter() . '/caracteristicas');
        $collection->add('alterar_caracteristicas', 'alterar-caracteristicas');
        $collection->add('autocomplete_localizacao', 'autocomplete-localizacao');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkImobiliarioVigencia',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.imobiliarioLocalizacao.vigencia',
                    'callback' => array($this, 'getSearchFilter')
                ),
                'entity',
                array(
                    'class' => Vigencia::class,
                    'choice_value' => 'codVigencia',

                ),
                array(
                    'admin_code' => 'tributario.admin.vigencia'
                )
            )

            ->add('codigoComposto', 'doctrine_orm_callback', array(
                'label' => 'label.imobiliarioLocalizacao.modulo',
                'callback' => array($this, 'getSearchFilter')
            ))
            ->add('nomLocalizacao', null, array('label' => 'label.imobiliarioLocalizacao.nomLocalizacao'))
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

        $queryBuilder->resetDQLPart('join');

        if ($filter['fkImobiliarioVigencia']['value'] != "") {
            $queryBuilder->leftJoin('o.fkImobiliarioLocalizacaoNiveis', 'n');
            $queryBuilder->andWhere('n.codVigencia = :codVigencia');
            $queryBuilder->setParameter('codVigencia', $filter['fkImobiliarioVigencia']['value']);
        }

        if (isset($filter['codigoComposto']['value'])) {
            $queryBuilder->andWhere('o.codigoComposto LIKE :codigoComposto');
            $queryBuilder->setParameter('codigoComposto', $filter['codigoComposto']['value'] . '%');
        }
    }

    /**
     * @param Localizacao $localizacao
     * @return string
     */
    public function getNivel(Localizacao $localizacao)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $nivel = (new LocalizacaoModel($em))->getNivel($localizacao);
        return (string) $nivel;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codigoComposto', null, array('label' => 'label.imobiliarioLocalizacao.codLocalizacao', 'header_style' => 'width: 15%'))
            ->add('nivel', 'customField', array(
                'label' => 'label.imobiliarioLocalizacao.nivel',
                'template' => 'TributarioBundle::Imobiliario/Localizacao/nivel.html.twig',
            ))
            ->add('nomLocalizacao', null, array('label' => 'label.imobiliarioLocalizacao.nomLocalizacao'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                    'baixar' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Localizacao/CRUD:list__action_baixar.html.twig'),
                    'caracteristicas' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Localizacao/CRUD:list__action_caracteristicas.html.twig')
                ),
                'header_style' => 'width: 20%'
            ))
        ;
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
                $this->getTranslator()->trans('label.imobiliarioLocalizacao.modulo')
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
                $this->getTranslator()->trans('label.imobiliarioLocalizacao.modulo')
            );
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = array();

        $fieldOptions['codLocalizacao'] = array(
            'label' => 'label.imobiliarioLocalizacao.codLocalizacao',
            'mapped' => false
        );

        $fieldOptions['fkImobiliarioVigencia'] = array(
            'label' => 'label.imobiliarioLocalizacao.vigencia',
            'class' => Vigencia::class,
            'choice_value' => 'codVigencia',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkImobiliarioNivel'] = array(
            'label' => 'label.imobiliarioLocalizacao.nivel',
            'class' => Nivel::class,
            'choice_value' => 'codNivel',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkImobiliarioLocalizacao'] = array(
            'label' => 'label.imobiliarioLocalizacao.modulo',
            'class' => Localizacao::class,
            'choice_value' => 'codLocalizacao',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) {
                return $er
                    ->createQueryBuilder('o')
                    ->leftJoin('o.fkImobiliarioBaixaLocalizacoes', 'bl')
                    ->where('bl.codLocalizacao is null');
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkImobiliarioLocalizacaoValorM2s.valorM2Territorial'] = [
            'label' => 'label.imobiliarioEdificacao.valorTerritorial',
            'attr' => [
                'class' => 'money '
            ],
            'currency' => 'BRL',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioLocalizacaoValorM2s.valorM2Predial'] = [
            'label' => 'label.imobiliarioEdificacao.aliquotaPredial',
            'attr' => [
                'class' => 'money '
            ],
            'currency' => 'BRL',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioLocalizacaoValorM2s.dtVigencia'] = [
            'label' => 'label.imobiliarioEdificacao.inicioVigencia',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioLocalizacaoValorM2s.fkNormasNorma'] = array(
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

        $fieldOptions['fkImobiliarioLocalizacaoAliquotas.aliquotaTerritorial'] = [
            'label' => 'label.imobiliarioEdificacao.valorTerritorial',
            'attr' => [
                'class' => 'money ',
            ],
            'currency' => 'BRL',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioLocalizacaoAliquotas.aliquotaPredial'] = [
            'label' => 'label.imobiliarioEdificacao.aliquotaPredial',
            'attr' => [
                'class' => 'money ',
            ],
            'currency' => 'BRL',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioLocalizacaoAliquotas.dtVigencia'] = [
            'label' => 'label.imobiliarioEdificacao.inicioVigencia',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioLocalizacaoAliquotas.fkNormasNorma'] = array(
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
            $em = $this->modelManager->getEntityManager($this->getClass());
            $localizacaoModel = new LocalizacaoModel($em);

            $localizacaoModel->verificaBaixa($this->getSubject());

            $nivel = $localizacaoModel->getNivel($this->getSubject());
            $localizacao = $localizacaoModel->getLocalizacaoSuperior($this->getSubject(), $nivel);

            $dependentes = $localizacaoModel->verificaDependentes($this->getSubject());
            $fieldOptions['codLocalizacao']['data'] = $localizacaoModel->getValorLocalizacao($this->getSubject());
            if ($dependentes) {
                $fieldOptions['codLocalizacao']['disabled'] = true;
            }

            $fieldOptions['fkImobiliarioVigencia']['disabled'] = true;
            $fieldOptions['fkImobiliarioVigencia']['data'] = $nivel->getFkImobiliarioVigencia();

            $fieldOptions['fkImobiliarioNivel']['query_builder'] = function (EntityRepository $er) use ($nivel) {
                return $er
                    ->createQueryBuilder('o')
                    ->where('o.codVigencia = :codVigencia')
                    ->setParameter('codVigencia', $nivel->getCodVigencia());
            };
            $fieldOptions['fkImobiliarioNivel']['disabled'] = true;
            $fieldOptions['fkImobiliarioNivel']['data'] = $nivel;

            $fieldOptions['fkImobiliarioLocalizacao']['disabled'] = true;
            $fieldOptions['fkImobiliarioLocalizacao']['data'] = $localizacao;

            if ($this->verificaValorMD() && $this->getSubject()->getFkImobiliarioLocalizacaoValorM2s()->count()) {
                /** @var LocalizacaoValorM2 $localizacaoValorM2 */
                $localizacaoValorM2 = $this->getSubject()->getFkImobiliarioLocalizacaoValorM2s()->last();

                $fieldOptions['fkImobiliarioLocalizacaoValorM2s.valorM2Territorial']['data'] = $localizacaoValorM2->getValorM2Territorial();
                $fieldOptions['fkImobiliarioLocalizacaoValorM2s.valorM2Predial']['data'] = $localizacaoValorM2->getValorM2Predial();
                $fieldOptions['fkImobiliarioLocalizacaoValorM2s.dtVigencia']['data'] = $localizacaoValorM2->getDtVigencia();
                $fieldOptions['fkImobiliarioLocalizacaoValorM2s.fkNormasNorma']['data'] = $localizacaoValorM2->getFkNormasNorma();
            }

            if ($this->verificaAliquota() && $this->getSubject()->getFkImobiliarioLocalizacaoAliquotas()->count()) {
                /** @var LocalizacaoAliquota $localizacaoAliquota */
                $localizacaoAliquota = $this->getSubject()->getFkImobiliarioLocalizacaoAliquotas()->last();

                $fieldOptions['fkImobiliarioLocalizacaoAliquotas.aliquotaTerritorial']['data'] = $localizacaoAliquota->getAliquotaTerritorial();
                $fieldOptions['fkImobiliarioLocalizacaoAliquotas.aliquotaPredial']['data'] = $localizacaoAliquota->getAliquotaPredial();
                $fieldOptions['fkImobiliarioLocalizacaoAliquotas.dtVigencia']['data'] = $localizacaoAliquota->getDtVigencia();
                $fieldOptions['fkImobiliarioLocalizacaoAliquotas.fkNormasNorma']['data'] = $localizacaoAliquota->getFkNormasNorma();
            }
        }

        $formMapper
            ->with('label.imobiliarioLocalizacao.dados')
            ->add('fkImobiliarioVigencia', 'entity', $fieldOptions['fkImobiliarioVigencia'])
            ->add('fkImobiliarioNivel', 'entity', $fieldOptions['fkImobiliarioNivel'])
            ->add('fkImobiliarioLocalizacao', 'entity', $fieldOptions['fkImobiliarioLocalizacao'])
            ->add('mascara', 'hidden', array('mapped' => false))
            ->add('id', 'hidden', array('mapped' => false, 'data' => ($this->getSubject()) ? $this->getSubject()->getCodLocalizacao() : null))
            ->add('codLocalizacao', null, $fieldOptions['codLocalizacao'])
            ->add('nomLocalizacao', null, array('label' => 'label.imobiliarioLocalizacao.nomLocalizacao'))
            ->end()
            ->with('label.imobiliarioLocalizacao.atributos', array('class' => 'atributoDinamicoWith'))
            ->add('atributosDinamicos', 'text', array('mapped' => false, 'required' => false))
            ->end()
        ;

        if ($this->verificaValorMD()) {
            $formMapper
                ->with('label.imobiliarioEdificacao.valoresM2')
                ->add(
                    'fkImobiliarioLocalizacaoValorM2s.valorM2Territorial',
                    'money',
                    $fieldOptions['fkImobiliarioLocalizacaoValorM2s.valorM2Territorial']
                )
                ->add(
                    'fkImobiliarioLocalizacaoValorM2s.valorM2Predial',
                    'money',
                    $fieldOptions['fkImobiliarioLocalizacaoValorM2s.valorM2Predial']
                )
                ->add(
                    'fkImobiliarioLocalizacaoValorM2s.dtVigencia',
                    'sonata_type_date_picker',
                    $fieldOptions['fkImobiliarioLocalizacaoValorM2s.dtVigencia']
                )
                ->add(
                    'fkImobiliarioLocalizacaoValorM2s.fkNormasNorma',
                    'autocomplete',
                    $fieldOptions['fkImobiliarioLocalizacaoValorM2s.fkNormasNorma']
                )
                ->end()
            ;
        }

        if ($this->verificaAliquota()) {
            $formMapper
                ->with('label.imobiliarioEdificacao.aliquotas')
                ->add(
                    'fkImobiliarioLocalizacaoAliquotas.aliquotaTerritorial',
                    'money',
                    $fieldOptions['fkImobiliarioLocalizacaoAliquotas.aliquotaTerritorial']
                )
                ->add(
                    'fkImobiliarioLocalizacaoAliquotas.aliquotaPredial',
                    'money',
                    $fieldOptions['fkImobiliarioLocalizacaoAliquotas.aliquotaPredial']
                )
                ->add(
                    'fkImobiliarioLocalizacaoAliquotas.dtVigencia',
                    'sonata_type_date_picker',
                    $fieldOptions['fkImobiliarioLocalizacaoAliquotas.dtVigencia']
                )
                ->add(
                    'fkImobiliarioLocalizacaoAliquotas.fkNormasNorma',
                    'autocomplete',
                    $fieldOptions['fkImobiliarioLocalizacaoAliquotas.fkNormasNorma']
                )
                ->end()
            ;
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $em = $this->modelManager->getEntityManager($this->getClass());
        $localizacaoModel = new LocalizacaoModel($em);
        $nivel = $localizacaoModel->getNivel($this->getSubject());
        $superior = $localizacaoModel->getLocalizacaoSuperior($this->getSubject(), $nivel);
        $codigo = $localizacaoModel->getValorLocalizacao($this->getSubject());

        $showMapper->with('label.imobiliarioLocalizacao.modulo');
        $showMapper->add('nivel', 'customField', array(
            'label' => 'label.imobiliarioLocalizacao.nivel',
            'template' => 'TributarioBundle:Sonata/Imobiliario/Localizacao/CRUD:custom_show_field.html.twig',
            'data' => (string) $nivel
        ));
        if ($superior) {
            $showMapper->add('localizacaoSuperior', 'customField', array(
                'label' => 'label.imobiliarioLocalizacao.localizacaoSuperior',
                'template' => 'TributarioBundle:Sonata/Imobiliario/Localizacao/CRUD:custom_show_field.html.twig',
                'data' => (string) $superior
            ));
        }
        $showMapper->add('codigo', 'customField', array(
            'label' => 'label.imobiliarioLocalizacao.codLocalizacao',
            'template' => 'TributarioBundle:Sonata/Imobiliario/Localizacao/CRUD:custom_show_field.html.twig',
            'data' => $codigo
        ));
        $showMapper->add('nomLocalizacao', null, array('label' => 'label.imobiliarioLocalizacao.nomLocalizacao'));
        $showMapper->add('atributos', 'customField', array(
            'label' => 'label.imobiliarioLocalizacao.atributos',
            'template' => 'TributarioBundle:Sonata/Imobiliario/Localizacao/CRUD:custom_show_atributos.html.twig',
            'data' => $this->getSubject()
        ));
        $showMapper->end();
    }

    /**
     * @param ErrorElement $errorElement
     * @param Localizacao $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $localizacaoModel = new LocalizacaoModel($em);

        $codigoAtual = null;
        $codigoNovo = $this->getForm()->get('codLocalizacao')->getData();

        if ($this->id($object)) {
            $codigoAtual = $localizacaoModel->getValorLocalizacao($object);
            $dependentes = $localizacaoModel->verificaDependentes($object);
            if (($dependentes) && ($codigoAtual != $codigoNovo)) {
                $error = $this->getTranslator()->trans('label.imobiliarioLocalizacao.erroAlterar');
                $errorElement->with('codLocalizacao')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            }
        }
        if ($codigoAtual != $codigoNovo) {
            $existe = $localizacaoModel
                ->verificaCodigo(
                    $this->getForm()->get('fkImobiliarioNivel')->getData(),
                    $codigoNovo,
                    $this->getForm()->get('fkImobiliarioLocalizacao')->getData()
                );
            if ($existe) {
                $error = $this->getTranslator()->trans('label.imobiliarioLocalizacao.erroCodigo', array('%codigo%' => $codigoNovo));
                $errorElement->with('codLocalizacao')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            }
        }
    }

    /**
     * @param mixed $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $atributoDinamico = $this->request->request->get('atributoDinamico');

        $em->persist($object);

        $retorno = (new LocalizacaoModel($em))
            ->salvarLocalizacao(
                $object,
                $this->getForm(),
                $this->verificaValorMD(),
                $this->verificaAliquota(),
                $atributoDinamico
            );

        if ($retorno != true) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $retorno->getMessage());
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }
    }

    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $localizacaoModel = new LocalizacaoModel($em);

        $atributoDinamico = $this->request->request->get('atributoDinamico');
        if ($atributoDinamico) {
            $localizacaoModel->atualizarAtributoDinamico($object, $atributoDinamico);
        }

        if ($this->verificaValorMD()) {
            $localizacaoModel->insereValorMD($object, $this->getForm());
        }

        if ($this->verificaAliquota()) {
            $localizacaoModel->insereAliquota($object, $this->getForm());
        }

        $codigoAtual = $localizacaoModel->getValorLocalizacao($object);
        $codigoNovo = $this->getForm()->get('codLocalizacao')->getData();
        if ($codigoAtual != $codigoNovo) {
            $retorno = $localizacaoModel->atualizarLocalizacao($object, $codigoNovo, $this->getForm(), $this->verificaValorMD(), $this->verificaAliquota());
            if ($retorno != true) {
                $container = $this->getConfigurationPool()->getContainer();
                $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
                $container->get('session')->getFlashBag()->add('error', $retorno->getMessage());
                $this->getDoctrine()->clear();
                return $this->redirectToUrl($this->request->headers->get('referer'));
            }
        }
    }

    /**
     * @param Localizacao $localizacao
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function preRemove($localizacao)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $dependentes = (new LocalizacaoModel($em))->verificaDependentes($localizacao);

        $container = $this->getConfigurationPool()->getContainer();
        if ($dependentes) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.imobiliarioLocalizacao.erroExcluirNiveis'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }

        $loteLocalizacoes = $localizacao->getFkImobiliarioLoteLocalizacoes();
        $faceQuadras = $localizacao->getFkImobiliarioFaceQuadras();

        if (count($loteLocalizacoes) || count($faceQuadras)) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.imobiliarioLocalizacao.erroExcluirDependentes'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }
    }

    /**
     * @param Localizacao $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getCodLocalizacao())
            ? (string) $object
            : $this->getTranslator()->trans('label.imobiliarioLocalizacao.modulo');
    }
}
