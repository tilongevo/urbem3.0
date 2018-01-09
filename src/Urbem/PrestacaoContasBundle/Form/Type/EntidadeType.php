<?php

namespace Urbem\PrestacaoContasBundle\Form\Type;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Form\Transform\EntityTransform;
use Urbem\CoreBundle\Repository\Orcamento\EntidadeRepository;
use Urbem\CoreBundle\Services\SessionService;

/**
 * Class EntidadeType
 * @package Urbem\PrestacaoContasBundle\Form\Type
 */
class EntidadeType extends AbstractType
{
    /**
     * @var SessionService
     */
    protected $session;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * EntidadeType constructor.
     * @param \Urbem\CoreBundle\Services\SessionService $session
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(SessionService $session, EntityManager $em)
    {
        $this->session = $session;
        $this->em = $em;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository(Entidade::class);
        $transformer =  new EntityTransform($repo, $this->em->getClassMetadata(Entidade::class), null);

        $builder->addModelTransformer(
            new CallbackTransformer(
                /* transform */
                function ($value) use ($transformer, $options) {
                    if (true === empty($value)) {
                        return null;
                    }

                    if (true === $options['return_object_key']) {
                        return $transformer->reverseTransform($value);
                    }

                    $value = $transformer->transform($value);

                    if (false === $options['multiple']) {
                        $value = array_shift($value);
                    }

                    return $value;
                },

                /* reverse */
                function ($value) use ($transformer, $options) {
                    if (null === $value) {
                        return null;
                    }

                    if (true === $options['return_object_key']) {
                        return $transformer->transform($value);
                    }

                    $value = $transformer->reverseTransform($value);

                    if (false === $options['multiple']) {
                        $value = $value->first();
                    }

                    return $value;
                }
            )
        );
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('class', Entidade::class);
        $resolver->setDefault('placeholder', 'Selecione');
        $resolver->setDefault('label', 'Entidade');
        $resolver->setDefault('multiple', false);

        // return object.key if true else return object itself
        $resolver->setDefault('return_object_key', true);

        $resolver->setDefault('attr', ['class' => 'select2-parameters ']);

        $resolver->setDefault('query_builder', function (EntidadeRepository $repository) {
            return $repository->withExercicioQueryBuilder($this->session->getExercicio());
        });

        $resolver->setDefault('fix_option_value', true);

        $resolver->setNormalizer('choice_value', function (Options $options, $value) {
            if (false === $options->offsetGet('fix_option_value')) {
                return $value;
            }

            return function($value) {
                if (true === empty($value)) {
                    return null;
                }

                $value = (new EntityTransform(
                    $this->em->getRepository(Entidade::class),
                    $this->em->getClassMetadata(Entidade::class)
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
