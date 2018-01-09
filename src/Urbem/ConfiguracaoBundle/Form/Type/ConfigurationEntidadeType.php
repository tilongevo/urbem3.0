<?php

namespace Urbem\ConfiguracaoBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Form\Transform\EntityTransform;
use Urbem\CoreBundle\Form\Type\EntidadeType;

class ConfigurationEntidadeType extends ConfigurationAbstractType
{
    const OPTION_EXERCICIO_PARAMETER_NAME = 'exercicio_parameter';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            /** @var Entidade $entidade */
            $entidade = $event->getForm()->getData();

            if (false === $entidade instanceof Entidade) {
                return;
            }

            $this->getConfigurationFromFormEvent(
                $event,
                $event->getForm()
                    ->getName()
            )->setValor($entidade->getCodEntidade());

            $this->getConfigurationFromFormEvent(
                $event,
                $event->getForm()
                    ->getConfig()
                    ->getOption(self::OPTION_EXERCICIO_PARAMETER_NAME)
            )->setValor($entidade->getExercicio());
        });

        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository(Entidade::class);

        $builder->addModelTransformer(
            new CallbackTransformer(
            /* transform */
                function ($codEntidade) use ($repo, $options) {
                    $exercicio = (string) $options['module']->getFkAdministracaoConfiguracoes(
                        $options[self::OPTION_EXERCICIO_PARAMETER_NAME],
                        $options['year'],
                        true
                    )->getValor();

                    /** @var QueryBuilder $qb */
                    $qb = $repo->createQueryBuilder('Entidade');
                    $qb->andWhere('Entidade.codEntidade = :codEntidade');
                    $qb->andWhere('Entidade.exercicio = :exercicio');

                    $qb->setParameters([
                        'codEntidade' => (int) $codEntidade,
                        'exercicio' => $exercicio,
                    ]);

                    $qb->setMaxResults(1);

                    return $qb->getQuery()->getOneOrNullResult();
                },

                /* reverse */
                function ($entidade) use ($repo) {
                    return (new EntityTransform($repo, $this->em->getClassMetadata(Entidade::class)))->reverseTransform($entidade)->first();
                }
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([self::OPTION_EXERCICIO_PARAMETER_NAME]);
        $resolver->setDefault('usuario', $this->container
            ->get('security.token_storage')
            ->getToken()
            ->getUser()
        );
    }

    public function getParent()
    {
        return EntidadeType::class;
    }
}
