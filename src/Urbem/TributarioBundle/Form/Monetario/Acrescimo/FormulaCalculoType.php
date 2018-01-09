<?php

namespace Urbem\TributarioBundle\Form\Monetario\Acrescimo;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Monetario\AcrescimoModel;

class FormulaCalculoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldOptions = array();

        $fieldOptions['funcao'] = array(
            'label' => 'label.monetarioAcrescimo.funcao',
            'class' => Funcao::class,
            'required' => true,
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'choice_value' => function (Funcao $funcao = null) {
                if (null === $funcao) {
                    return false;
                }
                return sprintf('%s.%s.%s', $funcao->getCodModulo(), $funcao->getCodBiblioteca(), $funcao->getCodFuncao());
            },
            'query_builder' => function (EntityRepository $repo) {
                $qb = $repo->createQueryBuilder('f')
                    ->where('f.codModulo = :codModulo')
                    ->andWhere('f.codBiblioteca = :codBiblioteca')
                    ->setParameter('codModulo', ConfiguracaoModel::MODULO_TRIBUTARIO_MONETARIO_ACRESCIMOS)
                    ->setParameter('codBiblioteca', AcrescimoModel::BIBLIOTECA_ORIGEM);
                return $qb;
            },
        );

        $fieldOptions['dtVigencia'] = array(
            'label' => 'label.monetarioAcrescimo.dtVigencia',
            'mapped' => false,
            'attr' => [
                'class' => 'datepicker',
                'data-provide' => 'datepicker',
            ],
        );

        $builder
            ->add('funcao', EntityType::class, $fieldOptions['funcao'])
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
