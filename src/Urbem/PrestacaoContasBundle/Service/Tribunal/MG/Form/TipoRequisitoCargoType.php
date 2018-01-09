<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Tcemg\TipoRequisitosCargo;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Class TipoRequisitoCargoType
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form
 */
class TipoRequisitoCargoType extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * TipoRequisitosCargoType constructor.
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
        $data = $this->em->getRepository(TipoRequisitosCargo::class)->findAll();
        if (!count($data)) {

            return $result;
        }
        /** @var TipoRequisitosCargo $item */
        foreach ($data as $item) {
            $name = $item->getCodTipo() . ' - ' . $item->getDescricao();
            $result[$name] = $item->getCodTipo();
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
