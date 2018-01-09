<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class RecursoDiretoAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $fieldOptions = array();

        $fieldOptions['tipo'] = array(
            'label' => 'label.recurso.tipo',
            'choices' => array(
                'label.recurso.vinculado' => RecursoAdmin::TIPO_VINCULADO,
                 'label.recurso.livre' => RecursoAdmin::TIPO_LIVRE
            ),
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
        );

        $fieldOptions['fkOrcamentoFonteRecurso'] = array(
            'label' => 'label.recurso.codFonte',
            'placeholder' => 'label.selecione',
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkAdministracaoEsfera'] = array(
            'label' => 'label.recurso.codTipoEsfera',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['codigoTc'] = array(
            'label' => 'label.recurso.codigoTc'
        );

        $fieldOptions['finalidade'] = array(
            'label' => 'label.recurso.finalidade',
            'attr' => [
                'maxlength' => 160
            ]
        );

        $formMapper
            ->add(
                'tipo',
                'choice',
                $fieldOptions['tipo']
            )
            ->add(
                'fkOrcamentoFonteRecurso',
                null,
                $fieldOptions['fkOrcamentoFonteRecurso']
            )
            ->add(
                'fkAdministracaoEsfera',
                null,
                $fieldOptions['fkAdministracaoEsfera']
            )
            ->add(
                'codigoTc',
                null,
                $fieldOptions['codigoTc']
            )
            ->add(
                'finalidade',
                'textarea',
                $fieldOptions['finalidade']
            )
        ;
    }
}
