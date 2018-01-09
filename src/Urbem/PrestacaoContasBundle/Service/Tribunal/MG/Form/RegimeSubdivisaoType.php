<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Pessoal\Regime;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Class RegimeSubdivisaoType
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form
 */
class RegimeSubdivisaoType extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * RegimeSubdivisaoType constructor.
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('multiple', false);
        $resolver->setDefaults([
            'choices' => $this->getValues(),
            'choices_as_values' => true,
        ]);
    }

    /**
     * @return array
     */
    protected function getValues()
    {
        $result = [];
        $data = $this->em->getRepository(Regime::class)->getRegimeSubdivisao();
        if (!count($data)) {

            return $result;
        }
        /** @var Regime $item */
        foreach ($data as $item) {
            $name = $item['nomRegime'] . " - " . $item['nomSubDivisao'];
            $result[$name] = $item['codSubDivisao'];
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return ChoiceType::class;
    }
}
