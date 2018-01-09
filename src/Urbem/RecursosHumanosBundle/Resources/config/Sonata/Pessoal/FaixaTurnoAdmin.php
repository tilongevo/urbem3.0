<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Urbem\CoreBundle\Entity\Pessoal\DiasTurno;
use Urbem\CoreBundle\Model\Pessoal\DiasTurnoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

class FaixaTurnoAdmin extends AbstractSonataAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->getDoctrine();
        $diasDaSemana = (new DiasTurnoModel($entityManager))->getDiasDaSemana();

        $fieldOptions = [];

        $fieldOptions['fkPessoalDiasTurno'] = [
            'class' => DiasTurno::class,
            'label' => 'label.gradeHorario.diaSemana',
            'choice_label' => 'nomDia',
            'query_builder' => $diasDaSemana,
            'attr' => ['class' => 'select2-parameters ']
        ];

        $fieldOptions['horaEntrada'] = [
            'attr' => ['class' => 'help-select '],
            'label' => 'label.gradeHorario.horaEntrada1'
        ];

        $fieldOptions['horaSaida'] = [
            'attr' => ['class' => 'help-select '],
            'label' => 'label.gradeHorario.horaSaida1'
        ];

        $fieldOptions['horaEntrada2'] = [
            'attr' => ['class' => 'help-select '],
            'label' => 'label.gradeHorario.horaEntrada2'
        ];

        $fieldOptions['horaSaida2'] = [
            'attr' => ['class' => 'help-select '],
            'label' => 'label.gradeHorario.horaSaida2'
        ];

        $formMapper
            ->add(
                'fkPessoalDiasTurno',
                'entity',
                $fieldOptions['fkPessoalDiasTurno']
            )
            ->add(
                'horaEntrada',
                null,
                $fieldOptions['horaEntrada']
            )
            ->add(
                'horaSaida',
                null,
                $fieldOptions['horaSaida']
            )
            ->add(
                'horaEntrada2',
                null,
                $fieldOptions['horaEntrada2']
            )
            ->add(
                'horaSaida2',
                null,
                $fieldOptions['horaSaida2']
            )
        ;
    }
}
