<?php
namespace Urbem\CoreBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Form\Transform\EntityTransform;
use Urbem\CoreBundle\Repository\Orcamento\EntidadeRepository;

class EntidadeType extends AbstractType
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('exercicio', date('Y'));
        $resolver->setRequired('usuario');
        $resolver->setAllowedTypes('usuario', [Usuario::class]);

        $resolver->setDefault('class', Entidade::class);
        $resolver->setDefault('placeholder', 'Selecione');
        $resolver->setDefault('label', 'Entidade');
        $resolver->setDefault('multiple', false);
        $resolver->setDefault('attr', ['class' => 'select2-parameters ']);

        $resolver->setNormalizer('query_builder', function (Options $resolver, $value) {
            return $resolver['em']
                ->getRepository($resolver['class'])
                ->getByExercicioAndSwCgmAsQueryBuilder(
                    $resolver['exercicio'],
                    $resolver['usuario']->getFkSwCgm()
                );
        });

        $resolver->setNormalizer('choice_value', function (Options $resolver, $value) {
            return function($value) use ($resolver) {
                if (true === empty($value)) {
                    return null;
                }

                $value = (new EntityTransform(
                    $resolver['em']->getRepository(Entidade::class),
                    $resolver['em']->getClassMetadata(Entidade::class)
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
