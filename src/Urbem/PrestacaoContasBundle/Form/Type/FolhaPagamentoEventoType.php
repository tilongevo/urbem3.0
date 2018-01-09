<?php

namespace Urbem\PrestacaoContasBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityManager;

/**
 * Class FolhaPagamentoEventoType
 * @package Urbem\PrestacaoContasBundle\Form\Type
 */
class FolhaPagamentoEventoType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * FolhaPagamentoEventoType constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('placeholder', 'Selecione');
        $resolver->setDefault('multiple', false);
        $resolver->setDefaults([
            'choices' => $this->getEventoModel()->getEventos(),
            'choices_as_values' => true,
        ]);
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return ChoiceType::class;
    }

    /**
     * @return EventoModel
     */
    protected function getEventoModel()
    {
        return new EventoModel($this->entityManager);
    }
}
