<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Tcepr\SecretariaOrgao;
use Urbem\CoreBundle\Form\Type\Organograma\OrgaoType;

class SecretariaOrgaoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fkOrganogramaOrgao', OrgaoType::class, [
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $builder->add('idSecretariaTce', TextType::class, [
            'label' => 'ID Secretaria TCE',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', SecretariaOrgao::class);
    }
}