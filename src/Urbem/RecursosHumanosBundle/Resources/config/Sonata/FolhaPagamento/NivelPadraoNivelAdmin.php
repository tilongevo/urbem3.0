<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class NivelPadraoNivelAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formOptions = array();
        
        $formOptions['descricao'] = array(
            'label' => 'label.nivelPadraoNivel.descricao',
        );
        
        
        $formOptions['percentual'] = array(
            'label' => 'label.nivelPadraoNivel.percentual',
            'attr' => array(
                'class' => 'percentual money '
            ),
        );
        
        $formOptions['valor'] = array(
            'label' => 'label.nivelPadraoNivel.valor',
            'grouping' => false,
            'currency' => 'BRL',
            'attr' => array(
                'readonly' => 'readonly',
                'class' => 'money '
            )
        );
        
        $formOptions['qtdmeses'] = array(
            'label' => 'label.nivelPadraoNivel.qtdmeses',
        );
        
        $formMapper
            ->add(
                'descricao',
                null,
                $formOptions['descricao']
            )
            ->add(
                'percentual',
                null,
                $formOptions['percentual']
            )
            ->add(
                'valor',
                'money',
                $formOptions['valor']
            )
            ->add(
                'qtdmeses',
                null,
                $formOptions['qtdmeses']
            )
        ;
    }
}
