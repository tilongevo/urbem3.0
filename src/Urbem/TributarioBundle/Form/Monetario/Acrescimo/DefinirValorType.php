<?php

namespace Urbem\TributarioBundle\Form\Monetario\Acrescimo;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Monetario\AcrescimoModel;

class DefinirValorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldOptions = array();

        $fieldOptions['valor'] = array(
            'label' => 'label.monetarioAcrescimo.valor',
            'required' => false,
            'mapped' => false,
            'attr' => array(
                'class' => 'mask-monetaria '
            )
        );

        $fieldOptions['dtVigencia'] = array(
            'label' => 'label.monetarioAcrescimo.dtVigencia',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'datepicker',
                'data-provide' => 'datepicker',
            ],
        );

        $builder
            ->add('valor', TextType::class, $fieldOptions['valor'])
            ->add('dtVigencia', TextType::class, $fieldOptions['dtVigencia'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
