<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Services\SessionService;

/**
 * Class ConfiguracaoRGF1Type
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form
 */
class ConfiguracaoRGF1Type extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var SessionService
     */
    protected $session;

    /**
     * ConfiguracaoRGF1 constructor.
     * @param SessionService $session
     * @param EntityManager $em
     */
    public function __construct(SessionService $session, EntityManager $em)
    {
        $this->session = $session;
        $this->em = $em;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('placeholder', 'Selecione');
        $resolver->setDefault('multiple', false);
        $resolver->setDefault('attr', ['class' => 'select2-parameters select2-multiple-options-custom ']);
        $resolver->setDefaults([
            'choices' => $this->getDespesas(),
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
     * @return array
     */
    protected function getDespesas()
    {
        $data = [];
        $qb = $this->em->getRepository(ContaDespesa::class)->getDespesaExercicioAnterior($this->session->getExercicio());
        $despesas = $qb->getQuery()->getResult();
        /** @var ContaDespesa $despesa */
        foreach ($despesas as $despesa) {
            $key = $despesa->getCodEstrutural() . " - " . $despesa->getDescricao();
            $data[$key] = $despesa->getCodEstrutural();
        }

        return $data;
    }
}