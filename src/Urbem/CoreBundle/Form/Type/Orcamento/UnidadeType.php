<?php

namespace Urbem\CoreBundle\Form\Type\Orcamento;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Orcamento\Orgao;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Form\Transform\EntityTransform;
use Urbem\CoreBundle\Repository\Orcamento\OrgaoRepository;
use Urbem\CoreBundle\Repository\Orcamento\UnidadeRepository;

class UnidadeType extends AbstractType
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('exercicio', null);
        $resolver->setDefault('orgao', null);

        $resolver->setDefault('class', Unidade::class);
        $resolver->setDefault('placeholder', 'Selecione');
        $resolver->setDefault('label', 'Unidade');
        $resolver->setDefault('multiple', false);
        $resolver->setDefault('attr', ['class' => 'select2-parameters ']);

        $resolver->setNormalizer('query_builder', function (Options $resolver, $value) {
            $orgao = $resolver['orgao'];
            $orgao = false === is_object($orgao) && 0 == $orgao ? null : $orgao;

            if (true === is_numeric($orgao)) {
                $numOrgao = $orgao;

                $orgao = new Orgao();
                $orgao->setExercicio($resolver['exercicio']);
                $orgao->setNumOrgao($numOrgao);
                $orgao->setNomOrgao($orgao);
            }

            if (true === is_string($orgao)) {
                $orgao = (new EntityTransform(
                    $resolver['em']->getRepository(Orgao::class),
                    $resolver['em']->getClassMetadata(Orgao::class)
                ))->reverseTransform($orgao);

                $orgao = null === $orgao ? $orgao : $orgao->first();
            }

            return $resolver['em']
                ->getRepository($resolver['class'])
                ->getByExercicioAndOrgaoAsQueryBuilder($resolver['exercicio'], $orgao);
        });

        $resolver->setNormalizer('choice_value', function (Options $resolver, $value) {
            return function($value) use ($resolver) {
                if (true === empty($value)) {
                    return null;
                }

                $value = (new EntityTransform(
                    $resolver['em']->getRepository(Unidade::class),
                    $resolver['em']->getClassMetadata(Unidade::class)
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
