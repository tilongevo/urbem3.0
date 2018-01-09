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
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Form\Transform\EntityTransform;
use Urbem\CoreBundle\Repository\Orcamento\EntidadeRepository;
use Urbem\CoreBundle\Services\SessionService;

/**
 * Class EntidadeRpsType
 * @package Urbem\PrestacaoContasBundle\Form\Type
 */
class EntidadeRpsType extends AbstractType
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
     * EntidadeRpsType constructor.
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

        $builder->addModelTransformer(
            new CallbackTransformer(
                /* transform */
                function ($value) use ($repo, $options) {
                    $value = (new EntityTransform($repo, $this->em->getClassMetadata(Entidade::class)))->reverseTransform($value);

                    if (true === $options['multiple']) {
                        return $value;
                    }

                    return $value instanceof ArrayCollection ? $value->first() : null;
                },
                /* reverse */
                function ($entidade) use ($repo, $options) {
                    $value = (new EntityTransform($repo, $this->em->getClassMetadata(Entidade::class)))->transform($entidade);
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
        $resolver->setDefault('class', Entidade::class);
        $resolver->setDefault('multiple', false);
        $resolver->setDefault('attr', ['class' => 'select2-parameters select2-multiple-options-custom']);
        $resolver->setDefault(
            'query_builder',
            function (EntidadeRepository $repository) {
                return $repository->withRpsExercicioQueryBuilder($this->session->getExercicio());
            }
        );
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return EntityType::class;
    }
}
