<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Patrimonio\TipoNatureza;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model;

class NaturezaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_patrimonio_natureza';

    protected $baseRoutePattern = 'patrimonial/patrimonio/natureza';

    protected $model = Model\Patrimonial\Patrimonio\NaturezaModel::class;

    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager('CoreBundle:Patrimonio\Natureza');
        $naturezaModel = new Model\Patrimonial\Patrimonio\NaturezaModel($em);
        $codNatureza = $naturezaModel->buildCodNatureza();

        $object->setCodNatureza($codNatureza);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapperOption['codTipo'] = [
            'class' => 'CoreBundle:Patrimonio\TipoNatureza',
            'placeholder'   => 'label.selecione',
        ];

        $datagridMapper
            ->add('nomNatureza', null, ['label' => 'label.patrimonial.grupo.natureza'])
            ->add('fkPatrimonioTipoNatureza', null, ['label' => 'label.natureza.codTipo'], 'entity', $datagridMapperOption['codTipo'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codNatureza', 'number', ['label' => 'label.codigo', 'sortable' => false])
            ->add('nomNatureza', 'text', ['label' => 'label.natureza.nomNatureza', 'sortable' => false])
            ->add('fkPatrimonioTipoNatureza', null, [
                'label' => 'label.natureza.codTipo',
                'sortable' => false
            ])
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

        $formMapper
            ->add('nomNatureza', null, ['label' => 'label.natureza.nomNatureza'])
            ->add('fkPatrimonioTipoNatureza', 'entity', [
                'class' => 'CoreBundle:Patrimonio\TipoNatureza',
                'label' => 'label.natureza.codTipo',
                'attr' => [
                    'class' => 'select2-parameters '
                ]
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('codNatureza', null, ['label' => 'label.codigo'])
            ->add('nomNatureza', null, ['label' => 'label.natureza.nomNatureza'])
            ->add('fkPatrimonioTipoNatureza', null, ['label' => 'label.natureza.codTipo'])
        ;
    }
}
