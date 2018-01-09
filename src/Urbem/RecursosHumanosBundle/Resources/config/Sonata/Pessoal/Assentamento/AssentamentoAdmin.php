<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal\Assentamento;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Entity\Folhapagamento;
use Urbem\CoreBundle\Entity\Pessoal;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

class AssentamentoAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('descricao')
            ->add('sigla')
            ->add('abreviacao')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('descricao')
            ->add('sigla')
            ->add('abreviacao')
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
        $formMapper
            ->add('codEsfera', 'entity', [
                'class' => Pessoal\EsferaOrigem::class,
                'choice_label' => 'descricao',
                'label' => 'label.assentamento.esfera',
                'placeholder' => 'label.selecione',
                'attr' => array(
                    'class' => 'select2-parameters '
                )
            ])
            ->add('assentamentoInicio', 'checkbox', [
                'label' => 'label.assentamento.assentamentoInicio',
                'required' => false
            ])
            ->add('gradeEfetividade', 'checkbox', [
                'label' => 'label.assentamento.gradeEfetividade',
                'required' => false
            ])
            ->add('relFuncaoGratificada', 'checkbox', [
                'label' => 'label.assentamento.relFuncaoGratificada',
                'required' => false
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('descricao')
            ->add('sigla')
            ->add('abreviacao')
        ;
    }
}
