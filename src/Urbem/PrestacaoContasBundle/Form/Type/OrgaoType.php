<?php

namespace Urbem\PrestacaoContasBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Model\Orcamento\OrgaoModel;
use Urbem\CoreBundle\Services\SessionService;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Class OrgaoType
 * @package Urbem\PrestacaoContasBundle\Form\Type
 */
class OrgaoType extends AbstractType
{
    /**
     * @var SessionService
     */
    protected $session;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * OrgaoType constructor.
     * @param \Urbem\CoreBundle\Services\SessionService $session
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
        $resolver->setDefaults([
            'choices' => $this->getOrgaoModel()->getOrgaoByExercicioForChoiceType($this->session->getExercicio()),
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
     * @return OrgaoModel
     */
    protected function getOrgaoModel()
    {
        return new OrgaoModel($this->em);
    }
}
