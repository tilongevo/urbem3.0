<?php

namespace Urbem\PrestacaoContasBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Model\Contabilidade\PlanoContaModel;
use Urbem\CoreBundle\Services\SessionService;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Class GrupoContasType
 * @package Urbem\PrestacaoContasBundle\Form\Type
 */
class GrupoContasType extends AbstractType
{
    /**
     * @var SessionService
     */
    protected $session;

    /**
     * @var PlanoContaModel
     */
    protected $model;

    /**
     * GrupoContasType constructor.
     * @param \Urbem\CoreBundle\Services\SessionService $session
     * @param PlanoContaModel $model
     */
    public function __construct(SessionService $session, PlanoContaModel $model)
    {
        $this->session = $session;
        $this->model = $model;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('placeholder', 'Selecione');
        $resolver->setDefault('multiple', false);
        $resolver->setDefaults([
            'choices' => $this->model->getGrupoContasChoiceType($this->session->getExercicio()),
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
}
