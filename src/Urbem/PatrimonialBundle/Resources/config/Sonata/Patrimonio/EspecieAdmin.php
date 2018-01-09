<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Patrimonio\Especie;
use Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo;
use Urbem\CoreBundle\Entity\Patrimonio\Grupo;
use Urbem\CoreBundle\Entity\Patrimonio\Natureza;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\EspecieAtributoModel;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\EspecieModel;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\GrupoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;

class EspecieAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_patrimonio_especie';

    protected $baseRoutePattern = 'patrimonial/patrimonio/especie';

    protected $includeJs = [
        '/patrimonial/javascripts/patrimonio/especie.js'
    ];

    public function prePersist($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $em = $this->modelManager->getEntityManager('CoreBundle:Patrimonio\Especie');
        $especieModel = new EspecieModel($em);
        $grupoModel = new GrupoModel($em);
        $grupo = $grupoModel->findOneBy([
            'codGrupo'=>$formData['codGrupo'],
            'codNatureza'=>$formData['codNatureza'],
        ]);

        $codEspecie = $especieModel->buildCodEspecie($grupo);
        $object->setCodEspecie($codEspecie);
        $object->setFkPatrimonioGrupo($grupo);

    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $filter = $this->getRequest()->query->get('filter');

        if ($filter['fkPatrimonioGrupo__fkPatrimonioNatureza']['value'] != '') {
            $query->andWhere('o.codNatureza= :codNatureza');
            $query->setParameter(
                'codNatureza' , $filter['fkPatrimonioGrupo__fkPatrimonioNatureza']['value']
            );
        }

        if ($filter['fkPatrimonioGrupo']['value'] != '') {
            $query->andWhere('o.codGrupo= :codGrupo');
            $query->setParameter(
                'codGrupo', $filter['fkPatrimonioGrupo']['value']
            );
        }

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

        $filter = $this->getRequest()->query->get('filter');
        $fieldOptions = [];
        $fieldOptions['fkPatrimonioGrupo'] =  [
            'class' => Grupo::class,
            'choices' => []
        ];
        if ($filter['fkPatrimonioGrupo__fkPatrimonioNatureza']['value'] != '' && $filter['fkPatrimonioGrupo']['value'] != '') {
            $em = $this->modelManager->getEntityManager('CoreBundle:Patrimonio\Especie');
            $grupoModel = new GrupoModel($em);
            $grupos = $grupoModel->findBy(
                [
                    'codNatureza'=>$filter['fkPatrimonioGrupo__fkPatrimonioNatureza']['value']
                ],
                [
                    'codGrupo' => 'ASC'
                ]
            );
            $selectedGrupo = $grupoModel->findOneBy([
                'codNatureza'=>$filter['fkPatrimonioGrupo__fkPatrimonioNatureza']['value'],
                'codGrupo'=>$filter['fkPatrimonioGrupo']['value']
            ]);
            $fieldOptions['fkPatrimonioGrupo'] =  [
                'class' => Grupo::class,
                'choices' => $grupos,
                'choice_value' => 'codGrupo',
                'attr' => [
                    'class' => 'grupoDestravado '
                ],
                'choice_attr' => function ($grupo, $key, $index) use ($selectedGrupo) {
                    if ($grupo->getCodGrupo() == $selectedGrupo->getCodGrupo()
                        && $grupo->getCodNatureza() == $selectedGrupo->getCodNatureza()) {
                        return ['selected' => 'selected'];
                    }
                    return ['selected' => false];
                },
            ];
        }

        $datagridMapper
            ->add(
                'fkPatrimonioGrupo.fkPatrimonioNatureza',
                'composite_filter',
                [
                    'label' => 'label.grupo.natureza'
                ],
                null,
                [
                    'class' => Natureza::class,
                ]
            )
            ->add(
                'fkPatrimonioGrupo',
                'composite_filter',
                [
                    'label' => 'label.grupo.grupo'
                ],
                null,
                $fieldOptions['fkPatrimonioGrupo']
            )
            ->add(
                'nomEspecie',
                null,
                [
                    'label' => 'label.especie.descricao'
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkPatrimonioGrupo.fkPatrimonioNatureza', 'text', [
                'label' => 'label.grupo.natureza', 'sortable' => false
            ])
            ->add('fkPatrimonioGrupo', 'text', [
                'label' => 'label.grupo.grupo', 'sortable' => false
            ])
            ->add(
                'nomEspecie',
                null,
                [
                    'label' => 'label.especie.descricao',
                    'sortable' => false
                ]
            )
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];
        $fieldOptions['codAtributo'] = [
            'class' => 'CoreBundle:Administracao\AtributoDinamico',
            'label' => 'label.especie.atributos',
            'choice_label' => 'nom_atributo',
            'mapped' => false,
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        if (!is_null($id)) {
            $especie = $this->getObject($id);

            $grupo = $especie->getFkPatrimonioGrupo();
            $natureza = $especie->getFkPatrimonioGrupo()->getFkPatrimonioNatureza();
            $fieldOptions['codNatureza']['disabled'] = true;
            $fieldOptions['codGrupo']['disabled'] = true;
            $fieldOptions['codGrupo']['label'] = 'label.grupo.grupo';
            $fieldOptions['codNatureza']['label'] = 'label.grupo.natureza';
            $fieldOptions['codGrupo']['data'] = $grupo;
            $fieldOptions['codNatureza']['data'] = $natureza;
            $type = 'text';

            $codAtributo = [];
            foreach ($especie->getFkPatrimonioEspecieAtributos() as $especieAtributo) {
                $codAtributo[] = $especieAtributo->getFkAdministracaoAtributoDinamico();
            }
            $fieldOptions['codAtributo']['data'] = $codAtributo;
        } else {
            $fieldOptions['codNatureza'] = [
                'class' => 'CoreBundle:Patrimonio\Natureza',
                'label' => 'label.grupo.natureza',
                'attr' => array(
                    'class' => 'select2-parameters '
                ),
                'placeholder'=> 'label.selecione'
            ];
            $fieldOptions['codGrupo'] = [
                'class' => 'CoreBundle:Patrimonio\Grupo',
                'choice_label' => 'nom_grupo',
                'label' => 'label.grupo.grupo',
                'attr' => array(
                    'class' => 'select2-parameters '
                ),
            ];
            $type = 'entity';
        }
        $formMapper
            ->with("Dados da Situação do Bem")
                ->add(
                    'codNatureza',
                    $type,
                    $fieldOptions['codNatureza']
                )
                ->add(
                    'codGrupo',
                    $type,
                    $fieldOptions['codGrupo']
                )
                ->add(
                    'nomEspecie',
                    'text',
                    [
                        'label' => 'label.especie.descricao'
                    ]
                )
            ->end()
            ->with("Atributos")
                ->add(
                    'codAtributo',
                    'entity',
                    $fieldOptions['codAtributo']
                )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add(
                'fkPatrimonioGrupo.fkPatrimonioNatureza',
                'text',
                [
                    'class' => 'CoreBundle:Patrimonio\Natureza',
                    'label' => 'label.grupo.natureza'
                ]
            )
            ->add(
                'fkPatrimonioGrupo',
                'text',
                [
                    'class' => 'CoreBundle:Patrimonio\Grupo',
                    'label' => 'label.grupo.grupo'
                ]
            )
            ->add(
                'nomEspecie',
                null,
                [
                    'label' => 'label.especie.descricao'
                ]
            )
        ;
    }

    public function postPersist($especie)
    {
        $atributos = $this->getForm()->get('codAtributo')->getData()->toArray();

        $entityManager = $this->modelManager->getEntityManager('CoreBundle:Patrimonio\EspecieAtributo');
        $atributoModel = new EspecieAtributoModel($entityManager);

        foreach ($atributos as $atributo) {
            $atributoModel->salvar(
                $this->buildEspecieAtributoEntity($atributo, $especie)
            );
        }
    }

    public function preUpdate($especie)
    {
        foreach ($especie->getFkPatrimonioEspecieAtributos() as $especieAtributo) {
            $especie->removeFkPatrimonioEspecieAtributos($especieAtributo);
        }
    }

    public function postUpdate($especie)
    {
        $atributos = $this->getForm()->get('codAtributo')->getData();

        $entityManager = $this->modelManager->getEntityManager('CoreBundle:Patrimonio\EspecieAtributo');
        $atributoModel = new EspecieAtributoModel($entityManager);

        foreach ($atributos as $atributo) {
            $atributoModel->salvar(
                $this->buildEspecieAtributoEntity($atributo, $especie)
            );
        }
    }

    /**
     * @param AtributoDinamico $atributoDinamico
     * @param Especie $especie
     * @return EspecieAtributo
     */
    private function buildEspecieAtributoEntity(AtributoDinamico $atributoDinamico, Especie $especie)
    {
        $especieAtributo = new EspecieAtributo();

        $especieAtributo->setFkPatrimonioEspecie($especie);
        $especieAtributo->setFkAdministracaoAtributoDinamico($atributoDinamico);

        return $especieAtributo;
    }
}
