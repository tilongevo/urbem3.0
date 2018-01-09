<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Tcers\Uniorcam;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Services\SessionService;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ExercicioUniorcamType extends AbstractType
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
     * PpaType constructor.
     * @param \Urbem\CoreBundle\Services\SessionService $session
     * @param \Doctrine\ORM\EntityManager $em
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
        $resolver->setDefault('multiple', false);
        $resolver->setDefaults([
            'choices' => ArrayHelper::parseInvertArrayToChoice($this->getExerciciosFromUniorcamList(), $camelcase = true),
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
    private function getExerciciosFromUniorcamList()
    {
        $exerciciosList = $this->em->getRepository(Uniorcam::class)->findExerciciosList();
        $yearList = [];

        foreach($exerciciosList as $exercicio) {
            $exercicio = (object) $exercicio;
            $yearList[$exercicio->exercicio] = $exercicio->exercicio;
        }

        return $yearList;
    }
}
