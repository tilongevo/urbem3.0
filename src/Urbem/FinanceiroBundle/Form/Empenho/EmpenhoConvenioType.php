<?php

namespace Urbem\FinanceiroBundle\Form\Empenho;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Query\Parameter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Repository\Empenho\EmpenhoRepository;
use Urbem\CoreBundle\Repository\Orcamento\EntidadeRepository;

class EmpenhoConvenioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fkOrcamentoEntidade', EntityType::class, [
            'class' => 'Urbem\CoreBundle\Entity\Orcamento\Entidade',
            'label' => 'label.entidade',
            'query_builder' => function (EntidadeRepository $repo) use ($options) {
                $qb = $repo->createQueryBuilder('e');

                $qb->select('e');
                $qb->join('\Urbem\CoreBundle\Entity\SwCgm', 'swCgm', Join::WITH, 'swCgm.numcgm = e.numcgm');

                $parameters = new ArrayCollection([
                    new Parameter('exercicio', $options['exercicio']),
                    new Parameter('parametro', 'data_implantacao'),
                    new Parameter('codModulo', 9)
                ]);

                $subUe = $repo->createQueryBuilder('sub');
                $subUe->resetDQLParts(['select', 'from']);
                $subUe->select("CONCAT(ue.codEntidade, '-', ue.exercicio)");
                $subUe->from('\Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade', 'ue');

                // admin não tem Orcamento/Entidade
                if (false === $options['authorization_checker']->isGranted('ROLE_SUPER_ADMIN')) {
                    $parameters->add(new Parameter('numcgm', $options['user']->getNumCgm()));

                    $subUe->andWhere('ue.numcgm = :numcgm AND ue.exercicio = :exercicio');
                } else {
                    $subUe->andWhere('ue.exercicio = :exercicio');
                }

                $subC = $repo->createQueryBuilder('sub');
                $subC->resetDQLParts(['select', 'from']);
                $subC->select("SUBSTRING(c.valor, 7, 4)");
                $subC->from('\Urbem\CoreBundle\Entity\Administracao\Configuracao', 'c');
                $subC->andWhere('c.parametro = :parametro AND c.exercicio = :exercicio AND c.codModulo = :codModulo');

                $qb->orWhere("CONCAT(e.codEntidade, '-', e.exercicio) IN (" . $subUe->getDQL() . ")");
                $qb->orWhere("e.exercicio < (" . $subC->getDQL() . ")");
                $qb->andWhere('e.exercicio = :exercicio');
                $qb->orderBy('e.codEntidade');

                $qb->setParameters($parameters);

                return $qb;
            },
            'choice_label' => function (Entidade $entidade) {
                return (string) $entidade->getFkSwCgm()->getNomCgm();
            },
            'choice_value' => function (Entidade $entidade = null) {
                if (null === $entidade) {
                    return;
                }
                return sprintf('%s~%s', $entidade->getCodEntidade(), $entidade->getExercicio());
            },
            'attr' => [
               'class' => 'select2-parameters basic-multiple'
            ]
        ]);

        $builder->add('fkEmpenhoEmpenho', EntityType::class, [
            'class' => 'Urbem\CoreBundle\Entity\Empenho\Empenho',
            'label' => 'label.empenho',
            'query_builder' => function (EmpenhoRepository $repo) use ($options) {
                $qb = $repo->createQueryBuilder('e');
                $qb->andWhere('e.exercicio = :exercicio');
                $qb->setParameter('exercicio', $options['exercicio']);

                return $qb;
            },
            'choice_value' => function (Empenho $empenho = null) {
                if (null === $empenho) {
                    return;
                }
                return sprintf('%s~%s~%s', $empenho->getCodEmpenho(), $empenho->getCodEntidade(), $empenho->getExercicio());
            },
            'attr' => [
                'class' => 'select2-parameters basic-multiple'
            ]
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['user', 'exercicio', 'authorization_checker']);
        $resolver->setAllowedTypes('user', ['\FOS\UserBundle\Model\UserInterface']);
        $resolver->setAllowedTypes('authorization_checker', ['\Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface']);
        $resolver->setAllowedTypes('exercicio', ['string']);

        $resolver->setDefaults(['data_class' => 'Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio']);
    }
}
