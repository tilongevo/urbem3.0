<?php

namespace Urbem\ConfiguracaoBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwUf;

class ConfigurationUFType extends ConfigurationAbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            /** @var SwUf $swUf */
            $swUf = $event->getForm()->getData();

            if (false === $swUf instanceof SwUf) {
                return;
            }

            $this->getConfigurationFromFormEvent($event, $event->getForm()->getName())->setValor($swUf->getCodUf());
        });

        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository(SwUf::class);

        $builder->addModelTransformer(
            new CallbackTransformer(
                /* transform */
                function ($value) use ($repo) {
                    /** @var QueryBuilder $qb */
                    $qb = $repo->createQueryBuilder('swuf');
                    $qb->where(sprintf('swuf.%s = :value', true === is_numeric($value) ? 'codUf' : 'siglaUf'));
                    $qb->setParameter('value', $value);
                    $qb->setMaxResults(1);

                    return $qb->getQuery()->getOneOrNullResult();
                },

                /* reverse */
                function (SwUf $swUf) {
                    return $swUf;
                }
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('class', SwUf::class);
        $resolver->setDefault(
            'query_builder',
            function (EntityRepository $repository) {
                $qb = $repository->createQueryBuilder('swuf');
                $qb->where($qb->expr()->notIn('swuf.siglaUf', ['NI', 'UR', 'PA', 'PT', 'AR']));
                $qb->orderBy('swuf.nomUf');

                return $qb;
            }
        );
    }

    public function getParent()
    {
        return EntityType::class;
    }

}
