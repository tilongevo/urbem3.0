<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Services\SessionService;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Class ConfiguracaoProjecaoAtuarialType
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form
 */
class ConfiguracaoProjecaoAtuarialType extends AbstractType
{
    const COD_ENTIDADE_RPPS = 3;

    /**
     * @var SessionService
     */
    protected $session;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * ConfiguracaoProjecaoAtuarialType constructor.
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
        $resolver->setDefault('placeholder', 'Selecione');
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
        $entity = $this->em->getRepository(Entidade::class)->findOneBy(['exercicio' => $this->session->getExercicio(), 'codEntidade' => self::COD_ENTIDADE_RPPS]);
        if ($entity instanceof Entidade) {
            $key = $entity->getCodEntidade() . ' - ' . $entity->getCustomEntidadeNomeToString();
            $result[$key] = $entity->getCodEntidade();
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
