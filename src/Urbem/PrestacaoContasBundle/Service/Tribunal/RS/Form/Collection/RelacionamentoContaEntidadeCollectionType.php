<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Form\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoConta;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Tcers\PlanoContaEntidade;
use Urbem\CoreBundle\Entity\Tcers\RdExtra;
use Urbem\CoreBundle\Services\SessionService;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\CustomDataInterface;
use Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Configuracao;

/**
 * Class RelacionamentoContaEntidadeCollectionType
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Form\Collection
 */
class RelacionamentoContaEntidadeCollectionType extends AbstractType implements CustomDataInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected static $entityManager;

    /**
     * @var \Urbem\CoreBundle\Services\SessionService
     */
    protected static $session;

    /**
     * ContratosLiquidacaoType constructor.
     * @param \Urbem\CoreBundle\Services\SessionService $session
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(SessionService $session, EntityManager $entityManager)
    {
        self::$entityManager = $entityManager;
        self::$session = $session;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $exercicio = self::$session->getExercicio();

        $builder->add(
            'fkContabilidadePlanoConta',
            'autocomplete',
            [
                'label' => 'Conta Contábil',
                'class' => PlanoConta::class,
                'route' => [
                    'name' => 'urbem_financeiro_contabilidade_lote_autocomplete_plano_analitica',
                    'parameters' => [
                        'getPlanoConta' => 1
                    ]
                ],
                'attr' => array(
                    'class' => 'select2-parameters '
                ),
                'req_params' => array(
                    'exercicio' => self::$session->getExercicio()
                ),
                'json_choice_label' =>  function (PlanoConta $planoConta) {
                    return $planoConta->getStringPlanoConta();
                }
            ]
        );
        $builder->add(
            'fkOrcamentoEntidade',
            'entity',
            [
                'label' => "Entidade",
                'attr' => ['class' => 'select2-parameters '],
                'class' => Entidade::class,
                'choice_label' => function ($codEntidade) {
                    return sprintf('%s - %s', $codEntidade->getCodEntidade(), $codEntidade->getFkSwCgm()->getNomCgm());
                },
                'choice_value' => 'codEntidade',
                'query_builder' => function ($em) use ($exercicio) {
                    $qb = $em->createQueryBuilder('e');
                    $qb->where('e.exercicio = :exercicio');
                    $qb->setParameter('exercicio', $exercicio);
                    $qb->orderBy('e.sequencia', 'ASC');
                    return $qb;
                }
            ]
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
                'data_class' => PlanoContaEntidade::class,
            )
        );
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getData()
    {
        $planoContaEntidadeList = Configuracao\RelacionamentoContaEntidade::getListContaEntidade(
            self::$entityManager,
            self::$session->getExercicio()
        );
        $data = new ArrayCollection();

        foreach ($planoContaEntidadeList as $planoContaEntidade) {
            $data->add($planoContaEntidade);
        }

        return $data;
    }
}
