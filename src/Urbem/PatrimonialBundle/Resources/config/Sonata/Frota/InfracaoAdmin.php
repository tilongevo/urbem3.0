<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\QueryBuilder;
use Urbem\CoreBundle\Entity\Frota\Infracao;
use Urbem\CoreBundle\Entity\Frota\Motorista;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Model\Patrimonial\Frota\InfracaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class InfracaoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Frota
 */
class InfracaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_infracao';
    protected $baseRoutePattern = 'patrimonial/frota/infracao';

    protected $includeJs = [
        '/patrimonial/javascripts/frota/infracao.js',
    ];

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add(
            'get_infracao_info',
            'get-infracao-info/' . $this->getRouterIdParameter()
        );
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkFrotaMotorista',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.infracao.codMotorista'
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Frota\Motorista',
                )
            )
            ->add(
                'autoInfracao',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.infracao.autoInfracao'
                )
            )
            ->add(
                'dataInfracao',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.infracao.dataInfracao'
                ),
                'datepkpicker',
                array(
                    'format' => 'dd/MM/yyyy',
                    'pk_class' => DatePK::class,
                    'mapped' => false,
                )
            );
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        $filter = $this->getDataGrid()->getValues();

        if (isset($filter['fkFrotaMotorista']) && $filter['fkFrotaMotorista']['value'] != '') {
            $queryBuilder->andWhere("{$alias}.fkFrotaMotorista = :fkFrotaMotorista");
            $queryBuilder->setParameter("fkFrotaMotorista", $filter['fkFrotaMotorista']['value']);
        }

        if (isset($filter['dataInfracao']) && $filter['dataInfracao']['value'] != '') {
            $queryBuilder->andWhere("{$alias}.dataInfracao = :dataInfracao");
            $dataInfracao = $filter['dataInfracao']['value'];
            $queryBuilder->setParameter("dataInfracao", $dataInfracao);
        }

        if (isset($filter['autoInfracao']) && $filter['autoInfracao']['value'] != '') {
            $queryBuilder->add(
                'where',
                $queryBuilder->expr()->like(
                    $queryBuilder->expr()->lower("{$alias}.autoInfracao"),
                    $queryBuilder->expr()->literal(sprintf('%%%s%%', $filter['autoInfracao']['value']))
                )
            );
        }

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $fieldOptions['codMotorista'] = [
            'class' => Motorista::class,
            'label' => 'label.infracao.codMotorista'
        ];

        $listMapper
            ->add(
                'autoInfracao',
                null,
                [
                    'label' => 'label.infracao.autoInfracao'
                ]
            )
            ->add(
                'dataInfracao',
                null,
                [
                    'label' => 'label.infracao.dataInfracao'
                ]
            )
            ->add(
                'fkFrotaMotorista',
                'text',
                $fieldOptions['codMotorista']
            );

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];

        /** @var InfracaoModel $infracaoModel */
        $infracaoModel = new InfracaoModel($em);
        $veiculos = $infracaoModel->getVeiculo();

        $fieldOptions['codVeiculo'] = [
            'choices' => $veiculos,
            'label' => 'label.infracao.codVeiculo',
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['codMotorista'] = [
            'class' => 'CoreBundle:Frota\Motorista',
            'label' => 'label.infracao.codMotorista',
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['autoInfracao'] = [
            'label' => 'label.infracao.autoInfracao',
            'attr' => [
                'maxlength' => 15
            ]
        ];

        $fieldOptions['dataInfracao'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.infracao.dataInfracao'
        ];

        $fieldOptions['codInfracao'] = [
            'class' => 'CoreBundle:Frota\MotivoInfracao',
            'label' => 'label.infracao.codInfracao',
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['baseLegal'] = [
            'label' => 'label.infracao.baseLegal',
            'mapped' => false,
            'disabled' => true,
            'required' => false
        ];

        $fieldOptions['gravidade'] = [
            'label' => 'label.infracao.gravidade',
            'mapped' => false,
            'disabled' => true,
            'required' => false
        ];

        $fieldOptions['pontos'] = [
            'label' => 'label.infracao.pontos',
            'mapped' => false,
            'disabled' => true,
            'required' => false
        ];

        if ($this->getSubject()) {
            if ($this->id($this->getSubject())) {
                $fieldOptions['codVeiculo']['data'] = $this->getSubject()->getFkFrotaVeiculo()->getCodVeiculo();
            }
        }

        $formMapper
            ->with('label.infracao.dados_infracao')
            ->add(
                'codVeiculo',
                'choice',
                $fieldOptions['codVeiculo']
            )
            ->add(
                'fkFrotaMotorista',
                'entity',
                $fieldOptions['codMotorista']
            )
            ->add(
                'autoInfracao',
                'text',
                $fieldOptions['autoInfracao']
            )
            ->add(
                'dataInfracao',
                'sonata_type_date_picker',
                $fieldOptions['dataInfracao']
            )
            ->add(
                'fkFrotaMotivoInfracao',
                'entity',
                $fieldOptions['codInfracao']
            )
            ->add(
                'baseLegal',
                'text',
                $fieldOptions['baseLegal']
            )
            ->add(
                'gravidade',
                'text',
                $fieldOptions['gravidade']
            )
            ->add(
                'pontos',
                'text',
                $fieldOptions['pontos']
            )
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['baseLegal'] = [
            'label' => 'label.infracao.baseLegal',
            'mapped' => false,
            'disabled' => true,
            'required' => false
        ];

        $fieldOptions['gravidade'] = [
            'label' => 'label.infracao.gravidade',
            'mapped' => false,
            'disabled' => true,
            'required' => false
        ];

        $fieldOptions['pontos'] = [
            'label' => 'label.infracao.pontos',
            'mapped' => false,
            'disabled' => true,
            'required' => false
        ];

        $showMapper
            ->add('autoInfracao', null, ['label' => 'label.infracao.autoInfracao'])
            ->add('dataInfracao', null, ['label' => 'label.infracao.dataInfracao'])
            ->add('fkFrotaMotorista', null, ['label' => 'label.infracao.codMotorista'])
            ->add('fkFrotaVeiculo', null, ['label' => 'label.infracao.codVeiculo'])
            ->add('fkFrotaMotivoInfracao', null, ['label' => 'label.infracao.codInfracao'])
            ->add('fkFrotaMotivoInfracao.baseLegal', 'text', $fieldOptions['baseLegal'])
            ->add('fkFrotaMotivoInfracao.gravidade', 'text', $fieldOptions['gravidade'])
            ->add('fkFrotaMotivoInfracao.pontos', 'text', $fieldOptions['pontos']);
    }

    /**
     * @param Infracao $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $codVeiculo = (new InfracaoModel($em))
            ->getVeiculoByCodVeiculo($this->getForm()->get('codVeiculo')->getData());

        $object->setFkFrotaVeiculo($codVeiculo);
    }

    /**
     * @param Infracao $object
     */
    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $codVeiculo = (new InfracaoModel($em))
            ->getVeiculoByCodVeiculo($this->getForm()->get('codVeiculo')->getData());

        $object->setFkFrotaVeiculo($codVeiculo);
    }
}
