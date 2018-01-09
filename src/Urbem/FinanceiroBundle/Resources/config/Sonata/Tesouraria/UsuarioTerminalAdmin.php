<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Helper\ArrayHelper;

class UsuarioTerminalAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_usuario_terminal';
    protected $baseRoutePattern = 'financeiro/tesouraria/usuario-terminal';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codTerminal')
            ->add('timestampTerminal')
            ->add('timestampUsuario')
            ->add('responsavel')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {

        $listMapper
            ->add('codTerminal')
            ->add('timestampTerminal')
            ->add('timestampUsuario')
            ->add('responsavel')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $repository = $entityManager->getRepository('CoreBundle:Tesouraria\Terminal');
        $usuarios =  ArrayHelper::parseArrayToChoice($repository->findAllUsuariosTerminalCgm(), 'nom_cgm', 'numcgm');

        $formMapper
            ->add(
                'cgmUsuario',
                'choice',
                [
                    'required' => false,
                    'choices' => $usuarios,
                    'label' => 'label.tesouraria.terminalUsuarios.usuario',
                    'placeholder' => 'label.selecione',
                    'mapped' => true,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add('responsavel', null, [ 'required' => false, 'label' => 'label.tesouraria.terminalUsuarios.responsavel'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codTerminal')
            ->add('timestampTerminal')
            ->add('timestampUsuario')
            ->add('responsavel')
        ;
    }
}
