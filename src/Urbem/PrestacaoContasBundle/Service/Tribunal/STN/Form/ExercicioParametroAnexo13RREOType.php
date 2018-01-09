<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Services\SessionService;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Class ExercicioParametroAnexo13RREO
 * @package Urbem\PrestacaoContasBundle\Form\Type
 */
class ExercicioParametroAnexo13RREOType extends AbstractType
{
    /**
     * @var SessionService
     */
    protected $session;

    /**
     * PpaType constructor.
     * @param \Urbem\CoreBundle\Services\SessionService $session
     */
    public function __construct(SessionService $session)
    {
        $this->session = $session;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('multiple', false);
        $resolver->setDefaults([
            'choices' => $this->getExercicios(),
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
     * @see gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/FMManterParametrosRREO13.php:75
     *
     * @return array
     */
    private function getExercicios()
    {
        $exercicioList = [];
        $exercicio = (int) $this->session->getExercicio();
        $exercicioAnterior = $exercicio - 1;
        $total = $exercicio + 75;
        for ($i = $exercicioAnterior; $i <= $total; $i++ ) {
            $exercicioList[$i] = $i;
        }

        return $exercicioList;
    }
}
