<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Calendario;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class FeriadoAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_recursos_humanos_calendario_feriado';
    protected $baseRoutePattern = 'recursos-humanos/calendario/feriado';
    protected $includeJs = [
        '/recursoshumanos/javascripts/calendario/feriado.js',
    ];

    protected $model = Model\Calendario\FeriadoModel::class;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->setBreadCrumb();

        $datagridMapper
            ->add(
                'dtFeriado',
                'doctrine_orm_datetime',
                [
                    'field_type'=> 'sonata_type_datetime_picker',
                    'field_options' => [
                        'format' => 'dd/MM/yyyy',
                    ],
                    'label' => 'label.calendario_feriado.dataEvento'
                ]
            )
            ->add(
                'descricao',
                null,
                [
                    'label' => 'label.descricao'
                ]
            )
            ->add(
                'abrangencia',
                'doctrine_orm_callback',
                [
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => "label.calendario_feriado.abrangencia"
                ],
                'choice',
                [
                    'choices' => [
                        'label.calendario_feriado.federal' => 'F',
                        'label.calendario_feriado.estadual' => 'E',
                        'label.calendario_feriado.municipal' => 'M',
                        'label.calendario_feriado.naodeclarada' => 'N',
                    ],
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
        ;
    }

    /**
     * {@inheridoc}
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        if (isset($filter['abrangencia'])) {
            switch ($filter['abrangencia']['value']) {
                case "N":
                    $queryBuilder->andWhere($queryBuilder->expr()->eq("{$alias}.abrangencia", ':abrangencia'));
                    $queryBuilder->orWhere($queryBuilder->expr()->eq("TRIM({$alias}.abrangencia)", "''"));
                    $queryBuilder->setParameter('abrangencia', $filter['abrangencia']['value']);
                    break;
                default:
                    $queryBuilder->andWhere($queryBuilder->expr()->eq("{$alias}.abrangencia", ':abrangencia'));
                    $queryBuilder->setParameter('abrangencia', $filter['abrangencia']['value']);
                    break;
            }
        }

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add(
                'dtFeriado',
                null,
                [
                    'label' => 'label.calendario_feriado.dataEvento'
                ]
            )
            ->add(
                'descricao',
                null,
                [
                    'label' => 'label.descricao'
                ]
            )
            ->add(
                'choiceTipoFeriadoValue',
                'trans',
                [
                    'label' => 'label.calendario_feriado.tipoEvento'
                ]
            )
            ->add(
                'choiceAbrangenciaValue',
                'trans',
                [
                    'label' => 'label.calendario_feriado.abrangencia'
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

        $feriadosOpt = [
            'label.calendario_feriado.fixo' => 'F',
            'label.calendario_feriado.variavel' => 'V',
            'label.calendario_feriado.pontofacultativo' => 'P',
            'label.calendario_feriado.diacompensado' => 'D'
        ];

        $fieldOptions = [];

        $fieldOptions['dtFeriado'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.calendario_feriado.dataEvento'
        ];

        $fieldOptions['descricao'] = [
            'label' => 'label.descricao'
        ];

        $fieldOptions['tipoferiado'] = [
            'choices' => $feriadosOpt,
            'expanded' => true,
            'multiple' => false,
            'label' => 'label.calendario_feriado.tipoEvento',
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ]
        ];

        $fieldOptions['abrangencia'] = [
            'choices' => [
                'label.calendario_feriado.federal' => 'F',
                'label.calendario_feriado.estadual' => 'E',
                'label.calendario_feriado.municipal' => 'M',
            ],
            'label' => "label.calendario_feriado.abrangencia",
            'required' => false,
            'multiple' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $formMapper
            ->with('Evento')
            ->add(
                'dtFeriado',
                'sonata_type_date_picker',
                $fieldOptions['dtFeriado']
            )
            ->add(
                'descricao',
                null,
                $fieldOptions['descricao']
            )
            ->add(
                'tipoferiado',
                'choice',
                $fieldOptions['tipoferiado']
            )
            ->add(
                'abrangencia',
                'choice',
                $fieldOptions['abrangencia']
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add(
                'dtFeriado',
                null,
                [
                    'label' => 'Data Evento'
                ]
            )
            ->add(
                'descricao',
                null,
                [
                    'label' => 'label.descricao'
                ]
            )
            ->add(
                'choiceTipoFeriadoValue',
                'trans',
                [
                    'label' => 'label.calendario_feriado.tipoEvento'
                ]
            )
            ->add('choiceAbrangenciaValue', 'trans', ['label' => 'label.calendario_feriado.abrangencia'])
        ;
    }

    /**
     * {@inheridoc}
     */
    public function prePersist($object)
    {
        if ($object->getAbrangencia() === null) {
            $object->setAbrangencia('N');
        }
    }

    /**
     * {@inheridoc}
     */
    public function preUpdate($object)
    {
        if ($object->getAbrangencia() === null) {
            $object->setAbrangencia('N');
        }
    }
}
