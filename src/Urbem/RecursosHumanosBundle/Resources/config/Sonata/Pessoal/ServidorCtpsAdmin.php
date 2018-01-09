<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;
use Urbem\CoreBundle\Model\Pessoal\CtpsModel;

class ServidorCtpsAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_servidor_ctps';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/servidor-ctps';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create','edit','delete','list']);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formMapper
            ->with('label.servidor.dadosctps')
                ->add(
                    'codServidor',
                    'hidden',
                    [
                        'data' => $this->getRequest()->query->get('id'),
                        'mapped' => false,
                    ]
                )
                ->add(
                    'fkPessoalCtps',
                    'sonata_type_admin',
                    [
                        'label' => false,
                        'required' => true,
                    ],
                    [
                        'edit' => 'inline',
                        'inline' => 'table',
                    ],
                    null
                )
            ->end()
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function prePersist($servidorCtps)
    {
        $entityManager = $this->getDoctrine();

        $servidorCtps->setCodCtps((new CtpsModel($entityManager))->getNextCtpsCode());
        $fkPessoalServidor = $this->getModelManager()->find(
            Servidor::class,
            $this->getForm()->get('codServidor')->getData()
        );

        $servidorCtps->setFkPessoalServidor($fkPessoalServidor);
    }

    public function redirect(Servidor $servidor)
    {
        $servidor = $servidor->getCodServidor();
        $this->forceRedirect('/recursos-humanos/pessoal/servidor/' . $servidor .'/show');
    }

    /**
     * {@inheritDoc}
     */
    public function postPersist($servidorCtps)
    {
        $this->redirect($servidorCtps->getFkPessoalServidor());
    }

    /**
     * {@inheritDoc}
     */
    public function postUpdate($servidorCtps)
    {
        $this->redirect($servidorCtps->getFkPessoalServidor());
    }

    /**
     * {@inheritDoc}
     */
    public function postRemove($servidorCtps)
    {
        $this->redirect($servidorCtps->getFkPessoalServidor());
    }

    /**
     * {@inheritDoc}
     */
    public function toString($servidorCtps)
    {
        return $servidorCtps->getFkPessoalCtps()->getNumero();
    }
}
