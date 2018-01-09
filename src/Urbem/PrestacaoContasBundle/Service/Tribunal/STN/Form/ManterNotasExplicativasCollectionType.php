<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Orcamento\Receita;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;

/**
 * Class ManterNotasExplicativasCollectionType
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form
 */
class ManterNotasExplicativasCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('anexo','prestacao_contas_stn_anexos', [
            'label' => 'Anexo',
            'required' => true,
        ]);

        $builder->add('dataInicial', DatePickerType::class, [
            'label' => 'Inicio Data da Nota',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $builder->add('dataFinal', DatePickerType::class, [
            'label' => 'Término Data da Nota',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $builder->add('notaExplicativa', TextareaType::class, [
            'label' => 'Nota Explicativa',
            'required' => true,
        ]);
    }
}