<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Urbem\CoreBundle\Form\Type\CurrencyType;
use Urbem\PrestacaoContasBundle\Form\Type\FolhaPagamentoEventoType;
use Symfony\Component\Validator\Constraints\NotNull;

class ConfigurarTetoRemuneratorioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('teto', CurrencyType::class, [
            'label' => 'Teto Remuneratório',
            'required' => true,
            'constraints' => [new NotNull()],
        ]);

        $builder->add('vigencia', 'prestacao_contas_date_picker', [
            'label' => 'Vigência',
            'required' => true,
            'constraints' => [new NotNull()],
        ]);
        $builder->add('justificativa', TextType::class, [
            'label' => 'Justificativa',
            'required' => false,
        ]);

        $builder->add('evento', FolhaPagamentoEventoType::class, [
            'label' => 'Evento Abate Teto',
            'attr' => ['class' => 'select2-parameters '],
            'required' => false,
        ]);
    }
}