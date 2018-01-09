<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Beneficio;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Model\Beneficio\ValeTransporteModel;
use Urbem\CoreBundle\Model\Beneficio\ContratoServidorConcessaoValeTransporteModel;

class ContratoServidorConcessaoValeTransporteAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codConcessao')
            ->add('codMes')
            ->add('exercicio')
            ->add('vigencia')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codConcessao')
            ->add('codMes')
            ->add('exercicio')
            ->add('vigencia')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->modelManager->getEntityManager('CoreBundle:Pessoal\ContratoServidor');

        $formMapper
            ->add(
                'codContrato',
                'entity',
                array(
                    'class' => 'CoreBundle:Pessoal\ContratoServidor',
                    'choice_label' => 'codContrato',
                //        function ($codContrato) use ($entityManager) {
                //                        $contratoServidorModel = new ContratoServidorConcessaoValeTransporteModel($entityManager);
                //                        $cgm = $contratoServidorModel->getCgm($codContrato);
                //
                //                        return $cgm->getNomCgm();
                //                    },
                    'label' => 'label.matricula',
                    'placeholder' => 'label.selecione',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                )
            )
            ->add(
                'codGrupo',
                'entity',
                array(
                    'class' => 'CoreBundle:Beneficio\GrupoConcessao',
                    'choice_label' => 'descricao',
                    'label' => 'label.grupos',
                    'placeholder' => 'label.selecione',
                    'mapped' => false,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                )
            )
            ->add(
                'vigencia',
                'sonata_type_date_picker',
                array(
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.vigencia'
                )
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codConcessao')
            ->add('codMes')
            ->add('exercicio')
            ->add('vigencia')
        ;
    }
}
