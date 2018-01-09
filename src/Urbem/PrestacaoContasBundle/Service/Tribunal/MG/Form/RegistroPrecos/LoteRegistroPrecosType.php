<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\RegistroPrecos;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Tcemg\LoteRegistroPrecos;
use Urbem\CoreBundle\Form\Type\PercentType;

class LoteRegistroPrecosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:544 */
        $builder->add('codLote', TextType::class, [
            'label' => 'Número do Lote',
            'required' => true,
            'constraints' => [new NotNull(), new Length(['min' => 1, 'max' => 4])],
            'attr' => ['class' => 'update-registro-orgao LoteRegistroPrecosType_codLote '],
        ]);

        $builder->add('descricaoLote', TextareaType::class, [
            'label' => 'Descrição do Lote',
            'required' => true,
            'constraints' => [new NotNull(), new Length(['max' => 250])]
        ]);

        $builder->add('percentualDescontoLote', PercentType::class, [
            'label' => 'Percentual por Lote',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $builder->add('fkTcemgItemRegistroPrecos', CollectionType::class, [
            'entry_type' => ItemRegistroPrecosType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'entry_options' => [
                'registroPrecos' => $options['registroPrecos'],
            ]
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', LoteRegistroPrecos::class);
        $resolver->setRequired('registroPrecos');
    }
}