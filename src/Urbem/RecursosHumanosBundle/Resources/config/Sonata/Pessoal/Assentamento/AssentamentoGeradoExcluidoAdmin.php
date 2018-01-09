<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal\Assentamento;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class AssentamentoGeradoExcluidoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_assentamento_gerar_assentamento_excluido';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/assentamento/gerar-assentamento-excluido';
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create', 'edit'));
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
                'codAssentamentoGerado',
                'hidden',
                array(
                    'data' => $this->request->query->get('id'),
                    'mapped' => false
                )
            )
            ->add(
                'descricao',
                'textarea',
                array(
                    'label' => 'label.descricao'
                )
            )
        ;
    }
    
    /**
     * Pre persiste
     * @param  \Urbem\CoreBundle\Pessoal\AssentamentoGeradoExcluido $object
     */
    public function prePersist($object)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();
        
        $fkPessoalAssentamentoGerado = $entityManager->getRepository("CoreBundle:Pessoal\AssentamentoGerado")
        ->findOneByCodAssentamentoGerado($this->getForm()->get('codAssentamentoGerado')->getData());
        
        $object->setFkPessoalAssentamentoGerado($fkPessoalAssentamentoGerado);
    }
    
    /**
     * Post persiste
     * @param  \Urbem\CoreBundle\Pessoal\AssentamentoGeradoExcluido $object
     */
    public function postPersist($object)
    {
        $this->getConfigurationPool()->getContainer()
        ->get('session')->getFlashBag()->add('success', 'Assentamento gerado, excluído com sucesso');
        $this->forceRedirect('/recursos-humanos/pessoal/assentamento/gerar-assentamento/list');
    }
}
