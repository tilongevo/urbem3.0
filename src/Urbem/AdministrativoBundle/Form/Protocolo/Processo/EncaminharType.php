<?php

namespace Urbem\AdministrativoBundle\Form\Protocolo\Processo;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EncaminharType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $options['em'];

        $organograma = $em->getRepository('CoreBundle:Organograma\Organograma')->findOneByAtivo(true);

        $required = true;
        $first = 'first ';

        foreach ($organograma->getFkOrganogramaNiveis() as $nivel) {
            $nom = 'orgao_'.$nivel->getCodNivel();

            $fieldOptions[$nom] = [
                'label' => $nivel->getDescricao(),
                'class' => 'CoreBundle:Organograma\Orgao',
                'choice_label' => 'descricao',
                'mapped' => false,
                'required' => $required,
                'attr' => ['class' => 'select2-parameters ' . $first . 'orgao-dinamico organograma-' . $organograma->getCodOrganograma() . ' nivel-'.$nivel->getCodNivel()],
                'label_attr' => ['class' => 'control-label required ']
            ];

            $builder->add($nom, EntityType::class, $fieldOptions[$nom]);
            $required = false;
            $first = '';
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Organograma\Orgao',
            'em' => null,
            'type' => null,
        ));
    }
}
