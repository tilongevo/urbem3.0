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
use Urbem\CoreBundle\Entity\SwTipoLogradouro;
use Urbem\CoreBundle\Form\Transform\EntityTransform;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;

class ConfigurationTipoLogradouroType extends ConfigurationAbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            /** @var SwTipoLogradouro $swTipoLogradouro */
            $swTipoLogradouro = $event->getForm()->getData();

            if (false === $swTipoLogradouro instanceof SwTipoLogradouro) {
                return;
            }

            $this->getConfigurationFromFormEvent($event, $event->getForm()->getName())->setValor($swTipoLogradouro->getNomTipo());
        });

        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository(SwTipoLogradouro::class);

        $builder->addModelTransformer(
            new CallbackTransformer(
                /* transform */
                function ($tipoLogradouro) use ($repo, $options) {
                    /** @var QueryBuilder $qb */
                    $qb = $repo->createQueryBuilder('SwTipoLogradouro');
                    $qb->andWhere(sprintf('SwTipoLogradouro.%s = :tipoLogradouro', true === is_numeric($tipoLogradouro) ? 'codTipo' : 'nomTipo'));

                    $qb->setParameters([
                        'tipoLogradouro' => $tipoLogradouro,
                    ]);

                    $qb->setMaxResults(1);

                    return $qb->getQuery()->getOneOrNullResult();
                },

                /* reverse */
                function ($swTipoLogradouro) use ($repo) {
                    return (new EntityTransform($repo, $this->em->getClassMetadata(SwTipoLogradouro::class)))->reverseTransform($swTipoLogradouro)->first();
                }
            )
        );
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('class', SwTipoLogradouro::class);
    }

    public function getParent()
    {
        return EntityType::class;
    }
}
