<?php

namespace Urbem\AdministrativoBundle\Form\Protocolo\Processo;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class DespacharType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descricao', TextareaType::class, [
                'label' => "label.descricao"
            ]);
    }
}
