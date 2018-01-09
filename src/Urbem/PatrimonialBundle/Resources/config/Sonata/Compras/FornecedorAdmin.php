<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Economico;
use Urbem\CoreBundle\Entity\SwCgm;

use Urbem\CoreBundle\Model\Patrimonial\Compras\FornecedorModel;

class FornecedorAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_fornecedor';
    protected $baseRoutePattern = 'patrimonial/compras/fornecedor';

    protected $model = FornecedorModel::class;
    protected $fkComprasFornecedorAtividades = [];
    protected $fkSwcgms = [];
    const NORMAL = 'label.fornecedor.tipo.N';
    const MICROEMPRESA = 'label.fornecedor.tipo.M';
    const PEQUENOPORTE = 'label.fornecedor.tipo.P';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add(
            'ativar-desativar',
            '{id}/ativar-desativar'
        );
    }

    public function preUpdate($object)
    {
        /** @var  $atividade Economico\Atividade */
        foreach ($object->getFkComprasFornecedorAtividades() as $atividade) {
            if (null !== $atividade->getFkEconomicoAtividade()) {
                $object->removeFkComprasFornecedorAtividades($atividade);
            }
        }
    }

    public function postPersist($object)
    {
        $em = $this->configurationPool->getContainer()->get('doctrine.orm.default_entity_manager');

        $form = $this->getForm();
        $fornecedorAtividades = $form->get('fkComprasFornecedorAtividades')->getData();

        foreach ($fornecedorAtividades as $atividades) {
            /** @var Compras\FornecedorAtividade $fornecedorAtividade */
            $fornecedorAtividade = new Compras\FornecedorAtividade();
            $fornecedorAtividade->setFkEconomicoAtividade($atividades);
            $fornecedorAtividade->setFkComprasFornecedor($object);
            $em->persist($fornecedorAtividade);
        }
        $em->flush();

        $this->redirect($object);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        /**
         * @var ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $fornecedorModel = new FornecedorModel($entityManager);

        $datagridMapperOption = [];

        $datagridMapperOption['tipo'] = [
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr' => ['class' => 'checkbox-sonata '],
            'choices' => [
                self::NORMAL => 'N',
                self::MICROEMPRESA => 'M',
                self::PEQUENOPORTE => 'P'
            ],
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'label.selecione'
        ];

        $datagridMapperOption['cgmFornecedor'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'to_string_callback' => function (SwCgm $swCgm, $property) {
                return strtoupper($swCgm->getNomCgm());
            },
            'class' => SwCgm::class,
            'property' => 'nomCgm',
            'label' => 'nomcgm',
            'placeholder' => 'Selecione'
        ];

        $datagridMapper
            ->add('fkSwCgm', 'doctrine_orm_model_autocomplete', ['label' => 'label.fornecedor.cgmFornecedor'], 'sonata_type_model_autocomplete', $datagridMapperOption['cgmFornecedor'])
            ->add('vlMinimoNf', null, ['label' => 'label.fornecedor.vlMinimoNf'])
            ->add('tipo', null, ['label' => 'label.tipo'], 'choice', $datagridMapperOption['tipo'])
            ->add('ativo', null, ['label' => 'label.fornecedor.ativo'], null, ['expanded' => true, 'placeholder' => 'nenhum']);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {

        $this->setBreadCrumb();

        $listMapper
            ->add('fkSwCgm', null, ['label' => 'label.bem.fornecedor'])
            ->add('vlMinimoNf', null, ['label' => 'label.fornecedor.vlMinimoNf'])
            ->add('ativo', null, ['label' => 'label.fornecedor.ativo'])
            ->add('tipo', 'choice', [
                'label' => 'label.tipo',
                'choices' => [
                    'N' => 'Normal',
                    'M' => 'Microempresa',
                    'P' => 'Pequeno Porte'
                ]
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'ativar-inativar' => [
                        'template' => 'CoreBundle:Sonata/CRUD:list__action_ativar-inativar.html.twig'
                    ],
                    'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    'edit' => ['template' => 'PatrimonialBundle:Sonata/Fornecedor/CRUD:list__action_profile.html.twig'],
                    'delete' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig']
                ]
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];
        $fieldOptions['cgmFornecedor'] = [
            'container_css_class' => 'select2-v4-parameters ',
            'to_string_callback' => function (SwCgm $swCgm, $property) {
                return sprintf('%s - %s', $swCgm->getNumcgm(), strtoupper($swCgm->getNomCgm()));
            },
            'class' => SwCgm::class,
            'property' => 'nomCgm',
            'label' => 'label.bem.fornecedor',
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['vlMinimoNf'] = [
            'label' => 'label.fornecedor.vlMinimoNf',
            'grouping' => false,
            'attr' => [
                'class' => 'money '
            ],
            'required' => true
        ];

        $fieldOptions['ativo'] = ['label' => 'label.fornecedor.ativo'];

        $fieldOptions['tipo'] = [
            'label_attr' => [
                'class' => 'checkbox-sonata '
            ],
            'attr' => [
                'class' => 'checkbox-sonata '
            ],
            'choices' => [
                'Normal' => 'N',
                'Microempresa' => 'M',
                'Pequeno Porte' => 'P'
            ],
            'expanded' => true,
            'multiple' => false
        ];

        $fieldOptions['codAtividade'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'class' => Economico\Atividade::class,
            'choice_label' => 'nomAtividade',
            'mapped' => false,
            'label' => 'label.fornecedor.atividade',
            'multiple' => true,
        ];

        /** @var Economico\Atividade $atividade */
        $atividade = $this->getSubject();
        $fornecedorAtividades = [];
        if (null !== $atividade->getFkComprasFornecedorAtividades()) {
            /** @var ApoliceBem $apoliceBens */
            foreach ($atividade->getFkComprasFornecedorAtividades() as $atividades) {
                $fornecedorAtividades[] = $atividades->getFkEconomicoAtividade();
            }

            $fieldOptions['codAtividade']['data'] = $fornecedorAtividades;
        }


        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        if (!is_null($id)) {
            /**
             * @var Compras\Fornecedor $fornecedor
             */
            $fornecedor = $this->getObject($id);

            $fieldOptions['cgmFornecedor']['disabled'] = true;
            $fieldOptions['vlMinimoNf']['data'] = $fornecedor->getVlMinimoNf();
        } else {
            $fieldOptions['cgmFornecedor']['callback'] = function ($admin, $property, $value) use ($entityManager) {
                $datagrid = $admin->getDatagrid();

                $query = $datagrid->getQuery();

                $swCgmModel = new SwCgmModel($entityManager);
                $swCgmModel->recuperaExcetoFornecedores($query);

                $datagrid->setValue($property, null, $value);
            };
        }

        $formMapper
            // Dados do Fornecedor
            ->with('Dados do Fornecedor')
            ->add(
                'fkSwCgm',
                'sonata_type_model_autocomplete',
                $fieldOptions['cgmFornecedor'],
                ['admin_code' => 'core.admin.filter.sw_cgm']
            )
            ->add('vlMinimoNf', 'number', $fieldOptions['vlMinimoNf'])
            ->add('ativo', null, $fieldOptions['ativo'])
            ->add('tipo', 'choice', $fieldOptions['tipo'])
            ->end()
            // Ramos de Atividades
            ->with('label.fornecedor.ramoAtividade')
            ->add('fkComprasFornecedorAtividades', 'entity', $fieldOptions['codAtividade'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('fkSwCgm', null, [
                'label' => 'label.fornecedor.cgmFornecedor',
                'associated_property' => function (SwCgm $fkSwCgm) {
                    $result = $fkSwCgm->getNomCgm();

                    return $result;
                }
            ])
            ->add('vlMinimoNf', null, ['label' => 'label.fornecedor.vlMinimoNf'])
            ->add('ativo', null, ['label' => 'label.fornecedor.ativo'])
            ->add('tipo', 'choice', [
                'label' => 'label.tipo',
                'choices' => [
                    'N' => 'Normal',
                    'M' => 'Microempresa',
                    'P' => 'Pequeno Porte'
                ]

            ])
            ->add('fkComprasFornecedorAtividades', null, [
                'label' => 'label.fornecedor.atividade',
                'associated_property' => function (Compras\FornecedorAtividade $fkComprasFornecedorAtividades) {
                    $result = $fkComprasFornecedorAtividades->getFkEconomicoAtividade()->getNomAtividade();

                    return $result;
                }
            ])
            ->add('fkComprasFornecedorContas', null, [
                'label' => 'label.fornecedor.dadosBancarios',
                'associated_property' => function (Compras\FornecedorConta $fornecedorConta) {
                    $banco = $fornecedorConta->getFkMonetarioAgencia()->getFkMonetarioBanco()->getNomBanco();
                    $agencia = $fornecedorConta->getFkMonetarioAgencia()->getNomAgencia();
                    $conta = $fornecedorConta->getNumConta();

                    $result = "{$conta} - {$agencia}/{$banco}";

                    return $result;
                }
            ])
            ->add('fkComprasFornecedorSocios', null, [
                'label' => 'label.fornecedor.socios',
                'associated_property' => function (Compras\FornecedorSocio $fornecedorSocio) {
                    $swcgm = $fornecedorSocio->getFkSwCgm()->getNomCgm();
                    $tipo = $fornecedorSocio->getFkComprasTipoSocio()->getDescricao();

                    return "{$swcgm} ({$tipo})";
                }
            ])
            ->add('fkComprasFornecedorClassificacoes', null, [
                'label' => 'label.fornecedor.classificacoes',
                'associated_property' => function (Compras\FornecedorClassificacao $fornecedorClassificacao) {
                    $catalogo = $fornecedorClassificacao->getFkAlmoxarifadoCatalogoClassificacao()->getDescricao();
                    $class = $fornecedorClassificacao->getFkAlmoxarifadoCatalogoClassificacao()->getDescricao();

                    return "{$catalogo} ({$class})";
                }
            ]);
    }

    public function redirect(Compras\Fornecedor $fornecedor)
    {
        $cgm = $fornecedor->getFkSwCgm()->getNumcgm();
        $this->forceRedirect("/patrimonial/compras/fornecedor/" . $cgm . "/show");
    }

    public function postUpdate($object)
    {
        $this->postPersist($object);
    }
}
