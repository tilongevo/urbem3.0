<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Form\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Tcers\ContratosLiquidacao;
use Urbem\CoreBundle\Services\SessionService;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\CustomDataInterface;
use Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Configuracao;

/**
 * Class ContratosLiquidacaoCollectionType
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Form\Collection
 */
class ContratosLiquidacaoCollectionType extends AbstractType implements CustomDataInterface
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
            'codLiquidacao',
            TextType::class,
            [
                'label' => "Número da liquidação",
                'attr' => ['class' => 'protocolo-numeric ']
            ]
        );
        $builder->add(
            'codContrato',
            TextType::class,
            [
                'label' => "Número do contrato",
                'attr' => ['class' => 'protocolo-numeric ']
            ]
        );
        $builder->add(
            'codContratoTce',
            TextType::class,
            [
                'label' => "Número do contrato TCE",
                'attr' => ['class' => 'protocolo-numeric ']
            ]
        );
        $builder->add(
            'exercicio',
            TextType::class,
            [
                'label' => "Ano do contrato",
                'data' => self::$session->getExercicio(),
                'attr' => ['class' => 'protocolo-numeric ']
            ]
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => ContratosLiquidacao::class,
            )
        );
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getData()
    {
        $contratosLiquidacao = Configuracao\ContratosLiquidacao::getListItemsContratosLiquidacao(self::$entityManager);
        $data = new ArrayCollection();

        foreach ($contratosLiquidacao as $contratoLiquidacao) {
            $data->add($contratoLiquidacao);
        }

        return $data;
    }
}
