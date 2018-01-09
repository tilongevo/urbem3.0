<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Compras\Modalidade;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Class ModalidadeType
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form
 */
class ModalidadeType extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * ModalidadeType constructor.
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
        $data = $this->em->getRepository(Modalidade::class)->findAll();
        if (!count($data)) {

            return $result;
        }
        /** @var Modalidade $item */
        foreach ($data as $item) {
            $name = $item->getCodModalidade() . ' - ' . $item->getDescricao();
            $result[$name] = $item->getCodModalidade();
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
