<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Patrimonio\Bem;
use Urbem\CoreBundle\Entity\Patrimonio\TipoBaixa;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\BemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class BemBaixadoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_patrimonio_bem_baixado';

    protected $baseRoutePattern = 'patrimonial/patrimonio/bem-baixado';

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager  */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $bem = $this->getForm()->get('fkPatrimonioBem')->getData();
        if (strpos($bem, '-') != 0) {
            $bem = explode(' - ', $bem);
            $bem = $bem[0];
        }
        $bemModel = new BemModel($entityManager);
        /** @var Bem $bemObject */
        $bemObject = $bemModel->findOneByCodBem($bem);

        if (!is_null($bemObject) && $bemObject != $object->getFkPatrimonioBem()) {
            $message = $this->trans('bem_baixado.errors.already_registered', ['%bem%' => $bemObject], 'validators');

            $errorElement->with('fkPatrimonioBem')->addViolation($message)->end();
        }
    }

    /**
     * @param mixed $bemBaixado
     */
    public function prePersist($bemBaixado)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $bem = $this->getForm()->get('fkPatrimonioBem')->getData();
        /** @var BemModel $bemModel */
        $bemModel = new BemModel($entityManager);
        /** @var Bem $bemObject */
        $bemObject = $bemModel->findOneByCodBem($bem);
        $bemBaixado->setFkPatrimonioBem($bemObject);
    }

    /**
     * @param mixed $bemBaixado
     */
    public function preUpdate($bemBaixado)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $bem = $this->getForm()->get('fkPatrimonioBem')->getData();

        list($codBem, $descricao) = explode('-', $bem);
        /** @var BemModel $bemModel */
        $bemModel = new BemModel($entityManager);
        /** @var Bem $bemObject */
        $bemObject = $bemModel->findOneByCodBem($codBem);
        $bemBaixado->setFkPatrimonioBem($bemObject);
    }


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codBem',
                null,
                [
                    'label' => 'label.bemBaixado.codBem'
                ]
            )
            ->add(
                'dtBaixa',
                'doctrine_orm_datetime',
                [
                    'label' => 'label.bemBaixado.dtBaixa',
                    'field_type' => 'sonata_type_datetime_picker',
                    'field_options' => [
                        'format' => 'dd/MM/yyyy'
                    ]
                ]
            )
            ->add('motivo', null, ['label' => 'label.bemBaixado.motivo'])
            ->add('fkPatrimonioTipoBaixa', null, ['label' => 'label.bemBaixado.tipoBaixa']);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkPatrimonioBem', 'text', [
                'label' => 'label.bemBaixado.codBem'
            ])
            ->add('dtBaixa', 'date', ['label' => 'label.bemBaixado.dtBaixa', 'sortable' => false])
            ->add('motivo', 'text', ['label' => 'label.bemBaixado.motivo', 'sortable' => false])
            ->add('fkPatrimonioTipoBaixa', 'text', [
                'label' => 'label.bemBaixado.tipoBaixa', 'sortable' => false
            ]);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formMapper
            ->add(
                'fkPatrimonioBem',
                'autocomplete',
                [
                    'label' => 'label.bemBaixado.codBem',
                    'multiple' => false,
                    'mapped' => false,
                    'required' => false,
                    'route' => ['name' => 'patrimonio_carrega_bem'],
                    'data' => ($this->getObject($this->getAdminRequestId())) ? $this->getObject($this->getAdminRequestId())->getFkPatrimonioBem() : null
                ]
            )
            ->add(
                'dtBaixa',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.bemBaixado.dtBaixa'
                ]
            )
            ->add('motivo', null, ['label' => 'label.bemBaixado.motivo'])
            ->add('fkPatrimonioTipoBaixa', 'entity', array(
                'class' => 'CoreBundle:Patrimonio\TipoBaixa',
                'label' => 'label.bemBaixado.tipoBaixa',
                'attr' => [
                    'class' => 'select2-parameters '
                ]
            ));
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('fkPatrimonioBem', 'text', [
                'label' => 'label.bemBaixado.codBem'
            ])
            ->add('dtBaixa', 'date', ['label' => 'label.bemBaixado.dtBaixa', 'sortable' => false])
            ->add('motivo', 'text', ['label' => 'label.bemBaixado.motivo', 'sortable' => false])
            ->add('fkPatrimonioTipoBaixa', 'text', [
                'label' => 'label.bemBaixado.tipoBaixa', 'sortable' => false
            ]);
    }
}
