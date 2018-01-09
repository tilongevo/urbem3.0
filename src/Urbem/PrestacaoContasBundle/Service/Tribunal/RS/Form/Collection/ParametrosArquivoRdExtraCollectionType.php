<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Form\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoConta;
use Urbem\CoreBundle\Entity\Tcers\RdExtra;
use Urbem\CoreBundle\Services\SessionService;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\CustomDataInterface;
use Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Configuracao;

/**
 * Class ParametrosArquivoRdExtraType
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Form
 */
class ParametrosArquivoRdExtraCollectionType extends AbstractType implements CustomDataInterface
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
            'classificacao',
            ChoiceType::class,
            [
                'label' => "Classificação",
                'attr' => ['class' => 'select2-parameters '],
                'choices' => array_flip(RdExtra::$classificacaoList),
            ]
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
                'data_class' => RdExtra::class,
            )
        );
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getData()
    {
        $rdExtralist = Configuracao\ParametrosArquivoRdExtra::getListItemsRdExtra(self::$entityManager);
        $data = new ArrayCollection();

        foreach ($rdExtralist as $rdExtra) {
            $data->add($rdExtra);
        }

        return $data;
    }
}
