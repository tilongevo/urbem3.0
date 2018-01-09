<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints as Assert;

use Urbem\AdministrativoBundle\Helper\Constants\TipoAtributo as TipoAtributoConstant;

use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\AtributoValorPadrao;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class AtributoDinamicoAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao
 */
class AtributoDinamicoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_administracao_atributo';
    protected $baseRoutePattern = 'administrativo/administracao/atributo';
    protected $defaultObjectId = 'codAtributo';

    protected $includeJs = [
        '/administrativo/javascripts/administracao/atributo-dinamico/base.js',
        '/administrativo/javascripts/administracao/atributo-dinamico/init.js'
    ];

    protected $datagridValues = [
        '_page'       => 1,
        '_sort_order' => 'DESC',
        '_sort_by'    => 'codAtributo'
    ];

    protected $exibirMensagemFiltro = true;

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consultar_modulo', 'consultar-modulo/' . $this->getRouterIdParameter());
        $collection->add('consultar_cadastro', 'consultar-cadastro/' . $this->getRouterIdParameter());
        $collection->add('consultar_campos', 'consultar-campos/');
        $collection->add('consultar_campos_por_cadastro', 'consultar-campos-por-cadastro');
        $collection->add('consultar_campos_por_modulo_cadastro_e_atributo', 'consultar-campos-por-modulo-cadastro-e-atributo');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagrid = $this->getDataGrid();
        $datagrid->getPager()->setCountColumn(['codModulo','codCadastro','codAtributo']);

        array_push($this->includeJs, '/administrativo/javascripts/administracao/atributo-dinamico/form--filter.js');

        $filterValues = $datagrid->getValues();
        $filteredMode = (isset($filterValues['codGestao']) || !empty($filterValues['codGestao']['value']));

        $datagridMapperFieldOptions = [];
        $datagridMapperFieldOptions['codGestao'] = [
            'attr'          => ['required' => true],
            'class'         => Gestao::class,
            'choice_label'  => 'nomGestao',
            'choice_value'  => 'codGestao',
            'placeholder'   => 'label.selecione',
            'query_builder' => function (EntityRepository $repository) {
                return $repository
                    ->createQueryBuilder('g')
                    ->orderBy('g.nomGestao', 'ASC');
            }
        ];

        $datagridMapperFieldOptions['codModulo'] = [
            'attr'          => ['required' => true],
            'class'         => Modulo::class,
            'choice_label'  => 'nomModulo',
            'choice_value'  => 'codModulo',
            'placeholder'   => 'label.selecione',
            'query_builder' => function (EntityRepository $entityRepository) use ($filterValues) {
                $queryBuilder = $entityRepository
                    ->createQueryBuilder('m')
                    ->orderBy('m.nomModulo', 'ASC');

                if (isset($filterValues['codGestao'])
                    || !empty($filterValues['codGestao']['value'])
                ) {
                    $queryBuilder
                        ->where('m.codGestao = :cod_gestao')
                        ->setParameter('cod_gestao', $filterValues['codGestao']['value']);
                }

                return $queryBuilder;
            }
        ];

        $datagridMapperFieldOptions['codCadastro'] = [
            'attr'          => ['required' => true],
            'class'         => Cadastro::class,
            'choice_label'  => 'nomCadastro',
            'choice_value'  => 'codCadastro',
            'placeholder'   => 'label.selecione',
            'query_builder' => function (EntityRepository $entityRepository) use ($filterValues) {
                $queryBuilder = $entityRepository
                    ->createQueryBuilder('c')
                    ->orderBy('c.nomCadastro', 'ASC');

                if (isset($filterValues['codModulo'])
                    || !empty($filterValues['codModulo']['value'])
                ) {
                    $queryBuilder
                        ->where('c.codModulo = :cod_modulo')
                        ->setParameter('cod_modulo', $filterValues['codModulo']['value']);
                }

                return $queryBuilder;
            }
        ];

        if (!$filteredMode) {
            $datagridMapperFieldOptions['codModulo']['choices'] = [];
            $datagridMapperFieldOptions['codModulo']['disabled'] = true;

            $datagridMapperFieldOptions['codCadastro']['choices'] = [];
            $datagridMapperFieldOptions['codCadastro']['disabled'] = true;
        }

        $datagridMapper
            ->add('codGestao', 'doctrine_orm_callback', [
                'label'    => 'label.atributoDinamico.codGestaoAsteristico',
                'callback' => [$this, 'getSearchFilter']
            ], 'entity', $datagridMapperFieldOptions['codGestao'])
            ->add('codModulo', 'doctrine_orm_callback', [
                'label'    => 'label.atributoDinamico.codModuloAsteristico',
                'callback' => [$this, 'getSearchFilter']
            ], 'entity', $datagridMapperFieldOptions['codModulo'])
            ->add('codCadastro', 'doctrine_orm_callback', [
                'label'    => 'label.atributoDinamico.codGestaoCadastro',
                'callback' => [$this, 'getSearchFilter']
            ], 'entity', $datagridMapperFieldOptions['codCadastro'])
            ->add('nomAtributo', null, ['label' => 'label.atributoDinamico.nomAtributo']);
    }

    /**
     * @param QueryBuilder|ProxyQuery $queryBuilder
     * @param string                  $alias
     * @param string                  $field
     * @param array                   $data
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $data)
    {
        $filterValues = $this->getDataGrid()->getValues();

        if (!$filterValues['codGestao']) {
            $queryBuilder->andWhere('1 = 0');
        }

        if (!count($data['value'])) {
            return;
        }

        if (isset($filterValues['codModulo'])
            && !empty($filterValues['codModulo']['value'])
        ) {
            $queryBuilder
                ->andWhere("{$alias}.codModulo = :codModulo")
                ->setParameter('codModulo', $filterValues['codModulo']['value']);
        }

        if (isset($filterValues['codCadastro'])
            && !empty($filterValues['codCadastro']['value'])
        ) {
            $queryBuilder
                ->andWhere("{$alias}.codCadastro = :codCadastro")
                ->setParameter('codCadastro', $filterValues['codCadastro']['value']);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codAtributo', null, ['label' => 'label.codigo'])
            ->add('fkAdministracaoCadastro.fkAdministracaoModulo.fkAdministracaoGestao.codGestao.nomGestao', null, ['label' => 'label.atributoDinamico.codGestao'])
            ->add('fkAdministracaoCadastro.fkAdministracaoModulo.nomModulo', null, ['label' => 'label.atributoDinamico.codModulo'])
            ->add('fkAdministracaoCadastro.nomCadastro', null, ['label' => 'label.atributoDinamico.codCadastro'])
            ->add('nomAtributo', null, ['label' => 'label.atributoDinamico.nomAtributo'])
            ->add('fkAdministracaoTipoAtributo.nomTipo', null, ['label' => 'label.atributoDinamico.codTipo'])
            ->add('ativo', null, ['label' => 'label.atributoDinamico.ativo']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var AtributoDinamico $atributoDinamico */
        $atributoDinamico = $this->getSubject();

        /** @var boolean $isAnUpdate */
        $isAnUpdate = !is_null($this->getObjectKey($atributoDinamico));

        if ($isAnUpdate) {
            $this->configureFormFieldsUpdate($formMapper);
        } else {
            $this->configureFormFieldsCreate($formMapper);
        }
    }

    /**
     * @param integer $length
     *
     * @return Assert\Length
     */
    private function addConstraintLength($length)
    {
        return new Assert\Length([
            'max'        => $length,
            'maxMessage' => $this->trans('default.errors.lengthExceeded', ['%number%' => $length], 'validators')
        ]);
    }

    /**
     * Fomulário de criação de um atributo.
     *
     * @param FormMapper $formMapper
     */
    private function configureFormFieldsCreate(FormMapper $formMapper)
    {
        $this->includeJs = array_merge($this->includeJs, [
            '/administrativo/javascripts/administracao/atributo-dinamico/form.js',
            '/administrativo/javascripts/administracao/atributo-dinamico/form--tipo-atributo.js'
        ]);

        $fieldOptions = [];
        $fieldOptions['codGestao'] = [
            'attr'          => [
                'class'    => 'select2-parameters ',
                'required' => true
            ],
            'class'         => Gestao::class,
            'choice_label'  => 'nomGestao',
            'choice_value'  => 'codGestao',
            'label'         => 'label.atributoDinamico.codGestao',
            'mapped'        => false,
            'placeholder'   => 'label.selecione',
            'query_builder' => function (EntityRepository $repository) {
                return $repository
                    ->createQueryBuilder('g')
                    ->orderBy('g.nomGestao', 'ASC');
            }
        ];

        $fieldOptions['codModulo'] = [
            'attr'         => [
                'class'    => 'select2-parameters ',
                'required' => true
            ],
            'class'        => Modulo::class,
            'choice_label' => 'nomModulo',
            'choice_value' => 'codModulo',
            'choices'      => [],
            'label'        => 'label.atributoDinamico.codModulo',
            'mapped'       => false,
            'placeholder'  => 'label.selecione'
        ];

        $fieldOptions['codCadastro'] = [
            'attr'         => [
                'class'    => 'select2-parameters ',
                'required' => true
            ],
            'class'        => Cadastro::class,
            'choice_label' => 'nomCadastro',
            'choice_value' => 'codCadastro',
            'choices'      => [],
            'label'        => 'label.atributoDinamico.codCadastro',
            'mapped'       => false,
            'placeholder'  => 'label.selecione'
        ];

        $fieldOptions['fkAdministracaoTipoAtributo'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'label'       => 'label.atributoDinamico.codTipo',
            'placeholder' => 'label.selecione',
            'required'    => true
        ];

        $fieldOptions['valorPadraoTexto'] = [
            'attr'        => ['class' => 'init-hidden '],
            'label'       => 'label.atributoDinamico.valorPadrao.texto',
            'mapped'      => false,
            'required'    => false,
            'constraints' => [$this->addConstraintLength(500)]
        ];

        $fieldOptions['valorPadraoNumero'] = [
            'attr'        => [
                'class' => 'init-hidden ',
                'type'  => 'number',
                'min'   => 0
            ],
            'label'       => 'label.atributoDinamico.valorPadrao.numero',
            'mapped'      => false,
            'required'    => false,
            'constraints' => [$this->addConstraintLength(500)]
        ];

        $fieldOptions['valorPadraoDecimal'] = [
            'attr'        => ['class' => 'money init-hidden money '],
            'label'       => 'label.atributoDinamico.valorPadrao.decimal',
            'mapped'      => false,
            'required'    => false,
            'constraints' => [$this->addConstraintLength(500)]
        ];

        $fieldOptions['valorPadraoData'] = [
            'attr'     => ['class' => 'init-hidden '],
            'format'   => 'dd/MM/yyyy',
            'label'    => 'label.atributoDinamico.valorPadrao.data',
            'mapped'   => false,
            'required' => false
        ];

        $fieldOptions['valorPadraoTextoLongo'] = [
            'attr'        => [
                'class'     => 'init-hidden ',
                'maxlength' => 500
            ],
            'label'       => 'label.atributoDinamico.valorPadrao.textoLongo',
            'mapped'      => false,
            'required'    => false,
            'constraints' => [$this->addConstraintLength(500)]
        ];

        $formMapper->with('label.atributoDinamico.dadosAtributo');

        // Campos de Exibição
        $formMapper->add('codGestao', 'entity', $fieldOptions['codGestao']);
        $formMapper->add('codModulo', 'entity', $fieldOptions['codModulo']);
        $formMapper->add('codCadastro', 'entity', $fieldOptions['codCadastro']);

        $this->configureFormFieldsBase($formMapper);

        $formMapper
            ->add('fkAdministracaoTipoAtributo', null, $fieldOptions['fkAdministracaoTipoAtributo'])
            // Campos de valores padrão dependente do tipo do atributo
            ->add('valorPadraoNumero', 'number', $fieldOptions['valorPadraoNumero'])
            ->add('valorPadraoTexto', 'text', $fieldOptions['valorPadraoTexto'])
            ->add('valorPadraoData', 'sonata_type_date_picker', $fieldOptions['valorPadraoData'])
            ->add('valorPadraoDecimal', 'text', $fieldOptions['valorPadraoDecimal'])
            ->add('valorPadraoTextoLongo', 'textarea', $fieldOptions['valorPadraoTextoLongo'])
            ->end()
            ->with('label.atributoDinamico.listaValores', ['class' => 'init-hidden--with '])
            ->add('fkAdministracaoAtributoValorPadroes', 'sonata_type_collection', [
                'by_reference' => false,
                'label'        => false,
                'required'     => false
            ], [
                'edit'   => 'inline',
                'inline' => 'table'
            ])
            ->end();

        $formMapper
            ->getFormBuilder()
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                function (FormEvent $event) use ($formMapper, $fieldOptions) {
                    $form = $event->getForm();
                    $data = $event->getData();

                    if (isset($data['codModulo']) && !empty($data['codModulo'])) {
                        unset($fieldOptions['codModulo']['choices']);

                        $fieldOptions['codModulo']['auto_initialize'] = false;
                        $fieldOptions['codModulo']['query_builder'] =
                            function (EntityRepository $entityRepository) use ($data) {
                                return $entityRepository
                                    ->createQueryBuilder('m')
                                    ->where('m.codGestao = :cod_gestao')
                                    ->setParameter('cod_gestao', $data['codGestao']);
                            };
                        $fieldCodModulo = $formMapper->getFormBuilder()
                            ->getFormFactory()
                            ->createNamed('codModulo', 'entity', null, $fieldOptions['codModulo']);

                        $form->add($fieldCodModulo);
                    }

                    if (isset($data['codCadastro']) && !empty($data['codCadastro'])) {
                        unset($fieldOptions['codCadastro']['choices']);

                        $fieldOptions['codCadastro']['auto_initialize'] = false;
                        $fieldOptions['codCadastro']['query_builder'] =
                            function (EntityRepository $entityRepository) use ($data) {
                                return $entityRepository
                                    ->createQueryBuilder('c')
                                    ->where('c.codModulo = :cod_modulo')
                                    ->setParameter('cod_modulo', $data['codModulo']);
                            };

                        $fieldCodCadastro = $formMapper->getFormBuilder()
                            ->getFormFactory()
                            ->createNamed('codCadastro', 'entity', null, $fieldOptions['codCadastro']);

                        $form->add($fieldCodCadastro);
                    }
                }
            );
    }

    /**
     * Campo base que haverá tanto na edição quanto a atualização do atributo.
     *
     * @param FormMapper $formMapper
     */
    private function configureFormFieldsBase(FormMapper $formMapper)
    {
        $fieldOptions['ativo'] = [
            'choices'    => ['sim' => true, 'nao' => false],
            'label'      => 'label.atributoDinamico.ativo',
            'expanded'   => true,
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr'       => ['class' => 'checkbox-sonata ']
        ];

        $fieldOptions['nomAtributo'] = [
            'label'       => 'label.atributoDinamico.nomAtributo',
            'required'    => true,
            'constraints' => [$this->addConstraintLength(80)]
        ];

        $fieldOptions['mascara'] = [
            'label'       => 'label.atributoDinamico.mascara',
            'required'    => false,
            'constraints' => [$this->addConstraintLength(40)]
        ];

        $fieldOptions['naoNulo'] = [
            'choices'    => ['sim' => true, 'nao' => false],
            'label'      => 'label.atributoDinamico.naoNulo',
            'expanded'   => true,
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr'       => ['class' => 'checkbox-sonata ']
        ];

        $fieldOptions['indexavel'] = [
            'choices'    => ['sim' => true, 'nao' => false],
            'label'      => 'label.atributoDinamico.indexavel',
            'expanded'   => true,
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr'       => ['class' => 'checkbox-sonata ']
        ];

        $fieldOptions['ajuda'] = [
            'label'       => 'label.atributoDinamico.ajuda',
            'required'    => false,
            'constraints' => [$this->addConstraintLength(80)]
        ];

        $formMapper
            ->add('ativo', 'choice', $fieldOptions['ativo'])
            ->add('nomAtributo', 'text', $fieldOptions['nomAtributo'])
            ->add('mascara', 'text', $fieldOptions['mascara'])
            ->add('naoNulo', 'choice', $fieldOptions['naoNulo'])
            ->add('indexavel', 'choice', $fieldOptions['indexavel'])
            ->add('ajuda', 'text', $fieldOptions['ajuda']);
    }

    /**
     * Monta o campo de valor padrão de acordo com o escolhido pelo usuario.
     *
     * @param FormMapper       $formMapper
     * @param AtributoDinamico $atributoDinamico
     */
    private function configureFormFieldValorPadraoBasedFkAdministracaoTipoAtributo(FormMapper $formMapper, AtributoDinamico $atributoDinamico)
    {
        $fieldOptions['valorPadraoTexto'] = [
            'label'       => 'label.atributoDinamico.valorPadrao.texto',
            'mapped'      => false,
            'required'    => false,
            'constraints' => [$this->addConstraintLength(500)]
        ];

        $fieldOptions['valorPadraoNumero'] = [
            'attr'        => [
                'type' => 'number',
                'min'  => 0
            ],
            'label'       => 'label.atributoDinamico.valorPadrao.numero',
            'mapped'      => false,
            'required'    => false,
            'constraints' => [$this->addConstraintLength(500)]
        ];

        $fieldOptions['valorPadraoDecimal'] = [
            'attr'        => ['class' => 'money '],
            'label'       => 'label.atributoDinamico.valorPadrao.decimal',
            'mapped'      => false,
            'required'    => false,
            'constraints' => [$this->addConstraintLength(500)]
        ];

        $fieldOptions['valorPadraoData'] = [
            'format'      => 'dd/MM/yyyy',
            'label'       => 'label.atributoDinamico.valorPadrao.data',
            'mapped'      => false,
            'required'    => false
        ];

        $fieldOptions['valorPadraoTextoLongo'] = [
            'attr'        => ['maxlength' => 500],
            'label'       => 'label.atributoDinamico.valorPadrao.textoLongo',
            'mapped'      => false,
            'required'    => false,
            'constraints' => [$this->addConstraintLength(500)]
        ];

        switch ($atributoDinamico->getCodTipo()) {
            case TipoAtributoConstant::NUMERICO:
                $fieldOptions['valorPadraoNumero']['data'] = (int) $atributoDinamico->getValorPadrao();
                $formMapper->add('valorPadraoNumero', 'number', $fieldOptions['valorPadraoNumero']);
                break;
            case TipoAtributoConstant::TEXTO:
                $fieldOptions['valorPadraoTexto']['data'] = $atributoDinamico->getValorPadrao();
                $formMapper->add('valorPadraoTexto', 'text', $fieldOptions['valorPadraoTexto']);
                break;
            case TipoAtributoConstant::LISTA:
            case TipoAtributoConstant::LISTA_MULTIPLA:
                $formMapper
                    ->end()
                    ->with('label.atributoDinamico.listaValores')
                        ->add('fkAdministracaoAtributoValorPadroes', 'sonata_type_collection', [
                            'by_reference' => false,
                            'label'        => false,
                            'required'     => false,
                            'type_options' => [
                                'delete'         => false,
                                'delete_options' => [
                                    'type' => 'hidden'
                                ],
                            ]
                        ], [
                            'edit'   => 'inline',
                            'inline' => 'table'
                        ])
                    ->end();
                break;
            case TipoAtributoConstant::DATA:
                $data = $atributoDinamico->getValorPadrao();

                if (!is_null($data)) {
                    $fieldOptions['valorPadraoData']['data'] = \DateTime::createFromFormat('d/m/Y', $data);
                }

                $formMapper->add('valorPadraoData', 'sonata_type_date_picker', $fieldOptions['valorPadraoData']);
                break;
            case TipoAtributoConstant::NUMERICO_2:
                $fieldOptions['valorPadraoDecimal']['data'] =$atributoDinamico->getValorPadrao();
                $formMapper->add('valorPadraoDecimal', 'text', $fieldOptions['valorPadraoDecimal']);
                break;
            case TipoAtributoConstant::TEXTO_LONGO:
                $fieldOptions['valorPadraoTextoLongo']['data'] = $atributoDinamico->getValorPadrao();
                $formMapper->add('valorPadraoTextoLongo', 'textarea', $fieldOptions['valorPadraoTextoLongo']);
                break;
        }
    }

    /**
     * Monta formulário de update.
     *
     * @param FormMapper $formMapper
     */
    private function configureFormFieldsUpdate(FormMapper $formMapper)
    {
        /** @var AtributoDinamico $atributoDinamico */
        $atributoDinamico = $this->getSubject();

        $customFieldGenericTemplate = 'AdministrativoBundle::Sonata/field__generic.html.twig';

        $cadastro = $atributoDinamico->getFkAdministracaoCadastro();
        $modulo = $cadastro->getFkAdministracaoModulo();
        $gestao = $modulo->getFkAdministracaoGestao();

        $fieldOptions['codGestao'] = [
            'attr'     => ['class' => 'form_row col s3 campo-sonata'],
            'label'    => false,
            'mapped'   => false,
            'template' => $customFieldGenericTemplate,
            'data'     => [
                'label' => 'label.atributoDinamico.codGestao',
                'value' => $gestao
            ]
        ];

        $fieldOptions['codModulo'] = [
            'attr'     => ['class' => 'form_row col s3 campo-sonata'],
            'label'    => false,
            'mapped'   => false,
            'template' => $customFieldGenericTemplate,
            'data'     => [
                'label' => 'label.atributoDinamico.codModulo',
                'value' => $modulo
            ]
        ];

        $fieldOptions['codCadastro'] = [
            'attr'     => ['class' => 'form_row col s3 campo-sonata'],
            'label'    => false,
            'mapped'   => false,
            'template' => $customFieldGenericTemplate,
            'data'     => [
                'label' => 'label.atributoDinamico.codCadastro',
                'value' => $cadastro
            ]
        ];

        $fieldOptions['fkAdministracaoTipoAtributo'] = [
            'attr'     => ['class' => 'form_row col s3 campo-sonata'],
            'label'    => false,
            'mapped'   => false,
            'template' => $customFieldGenericTemplate,
            'data'     => [
                'label' => 'label.atributoDinamico.codTipo',
                'value' => $atributoDinamico->getFkAdministracaoTipoAtributo()
            ]
        ];

        $formMapper->with('label.atributoDinamico.dadosAtributo');

        // Campos de Exibição
        $formMapper->add('codGestao', 'customField', $fieldOptions['codGestao']);
        $formMapper->add('codModulo', 'customField', $fieldOptions['codModulo']);
        $formMapper->add('codCadastro', 'customField', $fieldOptions['codCadastro']);

        $this->configureFormFieldsBase($formMapper);

        $formMapper->add('fkAdministracaoTipoAtributo', 'customField', $fieldOptions['fkAdministracaoTipoAtributo']);

        $this->configureFormFieldValorPadraoBasedFkAdministracaoTipoAtributo($formMapper, $atributoDinamico);

        $formMapper->end();
    }

    /**
     * @param ErrorElement     $errorElement
     * @param AtributoDinamico $atributoDinamico
     */
    public function validate(ErrorElement $errorElement, $atributoDinamico)
    {
        $form = $this->getForm();

        if (is_null($this->getObjectKey($atributoDinamico))) {
            /** @var Cadastro $cadastro */
            $cadastro = $form->get('codCadastro')->getData();

            $nomAtributo = $form->get('nomAtributo')->getData();

            /** @var AtributoDinamico $cloneAtributoDinamico */
            $cloneAtributoDinamico = $this->modelManager->findOneBy(AtributoDinamico::class, [
                'fkAdministracaoCadastro'     => $cadastro,
                'fkAdministracaoTipoAtributo' => $atributoDinamico->getFkAdministracaoTipoAtributo(),
                'nomAtributo'                 => $nomAtributo
            ]);

            if (!is_null($cloneAtributoDinamico)) {
                $message = $this->trans('atributoDinamico.errors.alreadyHasAtributoDinamico', [
                    '%atributo_dinamico%' => $cloneAtributoDinamico->getNomAtributo()
                ]);

                $errorElement->with('nomAtributo')->addViolation($message)->end();
            }
        }
    }

    /**
     * @param AtributoDinamico $atributoDinamico
     * @param bool             $update
     */
    private function persistValorPadrao(AtributoDinamico $atributoDinamico, $update = false)
    {
        $valorPadrao = null;

        switch ($atributoDinamico->getCodTipo()) {
            case TipoAtributoConstant::NUMERICO:
                $valorPadrao = $this->getForm()->get('valorPadraoNumero')->getData();
                break;
            case TipoAtributoConstant::TEXTO:
                $valorPadrao = $this->getForm()->get('valorPadraoTexto')->getData();
                break;
            case TipoAtributoConstant::LISTA:
            case TipoAtributoConstant::LISTA_MULTIPLA:
                if ($update) {
                    $this->updateFkAdministracaoAtributoValorPadroes($atributoDinamico);
                } else {
                    $this->persistFkAdministracaoAtributoValorPadroes($atributoDinamico);
                }
                break;
            case TipoAtributoConstant::DATA:
                /** @var \DateTime $valorPadraoData */
                $valorPadraoData = $this->getForm()->get('valorPadraoData')->getData();

                if ($valorPadraoData) {
                    $valorPadrao = $valorPadraoData->format('d/m/Y');
                }
                break;
            case TipoAtributoConstant::NUMERICO_2:
                $valorPadrao = $this->getForm()->get('valorPadraoDecimal')->getData();
                break;
            case TipoAtributoConstant::TEXTO_LONGO:
                $valorPadrao = $this->getForm()->get('valorPadraoTextoLongo')->getData();
                break;
        }

        $atributoDinamico->setValorPadrao($valorPadrao);
    }

    /**
     * Persiste many to one de valores padrõres.
     *
     * @param AtributoDinamico $atributoDinamico
     */
    private function persistFkAdministracaoAtributoValorPadroes(AtributoDinamico $atributoDinamico)
    {
        /** @var AtributoValorPadrao $atributoValorPadrao */
        foreach ($atributoDinamico->getFkAdministracaoAtributoValorPadroes() as $codValor => $atributoValorPadrao) {
            $atributoValorPadrao->setFkAdministracaoAtributoDinamico($atributoDinamico);
            $atributoValorPadrao->setCodValor($codValor + 1);
        }
    }

    /**
     * Faz um update dos valores padrões do atributo dinamico.
     *
     * @param AtributoDinamico $atributoDinamico
     */
    private function updateFkAdministracaoAtributoValorPadroes(AtributoDinamico $atributoDinamico)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();
        $atributoDinamicoModel = new AtributoDinamicoModel($entityManager);

        /** @var Form $fkAdministracaoAtributoValorPadraoForm */
        foreach ($form->get('fkAdministracaoAtributoValorPadroes') as $fkAdministracaoAtributoValorPadraoForm) {
            /** @var boolean $toDelete */
            $toDelete = $fkAdministracaoAtributoValorPadraoForm->get('_delete')->getData();

            if ($toDelete) {
                /** @var AtributoValorPadrao $atributoValorPadrao */
                $atributoValorPadrao = $fkAdministracaoAtributoValorPadraoForm->getData();

                $atributoDinamico->removeFkAdministracaoAtributoValorPadroes($atributoValorPadrao);
                $atributoDinamicoModel->remove($atributoValorPadrao);
            }
        }

        $this->persistFkAdministracaoAtributoValorPadroes($atributoDinamico);
    }

    /**
     * @param AtributoDinamico $atributoDinamico
     */
    public function prePersist($atributoDinamico)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        /** @var Cadastro $cadastro */
        $cadastro = $this->getForm()->get('codCadastro')->getData();

        $model = new AtributoDinamicoModel($entityManager);
        $codAtributo = $model->getProximoCodAtributo($cadastro->getCodModulo(), $cadastro->getCodCadastro());

        $atributoDinamico->setFkAdministracaoCadastro($cadastro);
        $atributoDinamico->setCodAtributo($codAtributo);

        $this->persistValorPadrao($atributoDinamico);
    }

    /**
     * @param AtributoDinamico $atributoDinamico
     */
    public function preUpdate($atributoDinamico)
    {
        $this->persistValorPadrao($atributoDinamico);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $this->label = $this->trans('label.atributoDinamico.modulo');

        $showMapper
            ->add('codAtributo', null, ['label' => 'label.codigo'])
            ->add('fkAdministracaoCadastro.fkAdministracaoModulo.fkAdministracaoGestao', null, ['label' => 'label.atributoDinamico.codGestao'])
            ->add('fkAdministracaoCadastro.fkAdministracaoModulo', null, [
                'admin_code' => 'administrativo.admin.modulo',
                'label' => 'label.atributoDinamico.codModulo',
            ])
            ->add('fkAdministracaoCadastro', null, ['label' => 'label.atributoDinamico.codCadastro'])
            ->add('nomAtributo', null, ['label' => 'label.atributoDinamico.nomAtributo'])
            ->add('mascara', null, ['label' => 'label.atributoDinamico.mascara'])
            ->add('naoNulo', null, ['label' => 'label.atributoDinamico.naoNulo'])
            ->add('indexavel', null, ['label' => 'label.atributoDinamico.indexavel'])
            ->add('ajuda', null, ['label' => 'label.atributoDinamico.ajuda'])
            ->add('ativo')
            ->add('fkAdministracaoTipoAtributo.nomTipo', null, ['label' => 'label.atributoDinamico.codTipo'])
            ;

        /** @var AtributoDinamico $atributoDinamico */
        $atributoDinamico = $this->getSubject();

        if ($atributoDinamico->getCodTipo() == TipoAtributoConstant::LISTA_MULTIPLA
            || $atributoDinamico->getCodTipo() == TipoAtributoConstant::LISTA) {
            $showMapper->add('fkAdministracaoAtributoValorPadroes', null, ['label' => 'label.atributoDinamico.valores']);
        } else {
            $showMapper->add('valorPadrao', null, ['label' => 'label.atributoDinamico.valor']);
        }
    }
}
