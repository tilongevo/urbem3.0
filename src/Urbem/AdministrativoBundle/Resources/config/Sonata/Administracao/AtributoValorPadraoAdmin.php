<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AtributoValorPadraoAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao
 */
class AtributoValorPadraoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_administracao_atributo_atributo_valor_padrao';
    protected $baseRoutePattern = 'administrativo/administracao/atributo/atributo-valor-padrao';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept('create');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codAtributoValorPadrao')
            ->add('codModulo')
            ->add('codCadastro')
            ->add('codValor')
            ->add('ativo')
            ->add('valorPadrao')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codAtributoValorPadrao')
            ->add('codModulo')
            ->add('codCadastro')
            ->add('codValor')
            ->add('ativo')
            ->add('valorPadrao')
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
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('valorPadrao', 'text', [
                'constraints' => [new Assert\Length([
                    'max'        => 500,
                    'maxMessage' => $this->trans('default.errors.lengthExceeded', ['%number%' => 500], 'validators')
                ])],
                'label'       => 'label.atributoDinamico.valor',
                'required'    => true
            ])
            ->add('ativo', 'choice', [
                'choices'  => ['sim' => true, 'nao' => false],
                'label'    => 'label.atributoDinamico.ativo',
                'expanded' => true,
                'data'     => true
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codAtributoValorPadrao')
            ->add('codModulo')
            ->add('codCadastro')
            ->add('codValor')
            ->add('ativo')
            ->add('valorPadrao')
        ;
    }
}
