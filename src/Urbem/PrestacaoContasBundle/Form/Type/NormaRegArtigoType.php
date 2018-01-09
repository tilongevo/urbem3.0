<?php

namespace Urbem\PrestacaoContasBundle\Form\Type;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Form\Transform\EntityTransform;
use Urbem\CoreBundle\Services\SessionService;
use Symfony\Component\OptionsResolver\Options;
use Urbem\CoreBundle\Repository\Normas\NormaRepository;

/**
 * Class NormaRegArtigoType
 * @package Urbem\PrestacaoContasBundle\Form\Type
 */
class NormaRegArtigoType extends AbstractType
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
     * NormaRegArtigoType constructor.
     * @param SessionService $session
     * @param EntityManager $em
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
        $repo = $this->em->getRepository(Norma::class);

        $builder->addModelTransformer(
            new CallbackTransformer(
            /* transform */
                function ($value) use ($repo, $options) {
                    $value = (new EntityTransform($repo, $this->em->getClassMetadata(Norma::class)))->reverseTransform($value);

                    if (true === $options['multiple']) {
                        return $value;
                    }

                    return $value instanceof ArrayCollection ? $value->first() : null;
                },
                /* reverse */
                function ($entidade) use ($repo, $options) {
                    $value = (new EntityTransform($repo, $this->em->getClassMetadata(Norma::class)))->transform($entidade);

                    if (null === $value) {
                        return null;
                    }

                    $value = array_keys($value);

                    if (true === $options['multiple']) {
                        return $value;
                    }

                    return array_shift($value);
                }
            )
        );
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('class', Norma::class);
        $resolver->setDefault('multiple', false);
        $resolver->setDefault('attr', ['class' => 'select2-parameters select2-multiple-options-custom']);
        $resolver->setDefault(
            'query_builder',
            function (NormaRepository $repository) {
                return $repository->withExercicioQueryBuilder($this->session->getExercicio());
            }
        );

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
                    $this->em->getRepository(Norma::class),
                    $this->em->getClassMetadata(Norma::class)
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
