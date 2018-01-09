<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SequenciaCalculoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_sequencia_calculo';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/sequencia-calculo';

    protected $model = null;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('sequencia', null, ['label' => 'label.numero'])
            ->add('descricao', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('sequencia', 'number', ['label' => 'label.numero', 'sortable' => false])
            ->add('descricao', 'text', ['label' => 'label.descricao', 'sortable' => false])
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
            ->add('sequencia', null, [
                'label' => 'label.numero',
                'attr' => [
                    'min' => 0,
                ],
            ])
            ->add('descricao', 'textarea', ['label' => 'label.descricao'])
            ->add('complemento', 'textarea')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
//            ->add('codSequencia', null, ['label' => 'label.codigo'])
            ->add('sequencia', null, ['label' => 'label.numero'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->add('complemento', null, ['label' => 'label.complemento'])
        ;
    }

    public function preValidate($object)
    {

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $sequenciaCalculoModel = new Model\Folhapagamento\SequenciaCalculoModel($entityManager);

        $res = $sequenciaCalculoModel->isUnique(['sequencia' => $object->getSequencia()]);

        $container = $this->getConfigurationPool()->getContainer();
        
        if($res){
            $message = $this->trans('sequencia_calculo.errors.already_registered', [], 'validators');

            $container->get('session')
                ->getFlashBag()
                ->add('error', $message);

            (new RedirectResponse($this->request->headers->get('referer')))->send();
        };
    }
}
