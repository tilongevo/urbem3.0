<?php

namespace Urbem\CoreBundle\Form\Type\Orcamento;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Orcamento\Orgao;
use Urbem\CoreBundle\Form\Transform\EntityTransform;

class OrgaoType extends AbstractType
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('class', Orgao::class);
        $resolver->setDefault('placeholder', 'Selecione');
        $resolver->setDefault('label', 'Órgão Responsável');
        $resolver->setDefault('multiple', false);
        $resolver->setDefault('exercicio', date('Y'));
        $resolver->setDefault('attr', ['class' => 'select2-parameters ']);

        $resolver->setNormalizer('query_builder', function (Options $resolver, $value) {
            return $resolver['em']
                ->getRepository($resolver['class'])
                ->getByExercicioAsQueryBuilder($resolver['exercicio']);
        });

        $resolver->setNormalizer('choice_value', function (Options $resolver, $value) {
            return function($value) use ($resolver) {
                if (true === empty($value)) {
                    return null;
                }

                $value = (new EntityTransform(
                    $resolver['em']->getRepository(Orgao::class),
                    $resolver['em']->getClassMetadata(Orgao::class)
                ))->transform($value);

                if (true === empty($value)) {
                    return null;
                }

                $value = array_keys($value);

                return array_shift($value);
            };
        });
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return EntityType::class;
    }
}
