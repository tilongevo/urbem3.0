<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SecretariaOrgaoFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('idSecretariaTce', TextType::class, [
            'label' => 'ID Secretaria TCE'
        ]);
    }
}