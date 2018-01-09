<?php

namespace Urbem\PrestacaoContasBundle\Form\Type\Stn;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Urbem\CoreBundle\Entity\Stn\TipoVinculoStnReceita;

/**
 * Class TipoVinculoStnReceitaType
 * @package Urbem\PrestacaoContasBundle\Form\Type
 */
class TipoVinculoStnReceitaType extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * TipoVinculoStnReceitaType constructor.
     * @param EntityManager $em
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
        $resolver->setDefault('placeholder', 'Selecione');
        $resolver->setDefault('multiple', false);
        $resolver->setDefault('attr', ['class' => 'select2-parameters ']);
        $resolver->setDefaults([
            'choices' => $this->getTipoVinculo(),
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
    protected function getTipoVinculo()
    {
        $data = [];
        $tiposVinculo = $this->em->getRepository(TipoVinculoStnReceita::class)->findAll();
        /** @var TipoVinculoStnReceita $tipoVinculo */
        foreach ($tiposVinculo as $tipoVinculo) {
            $key = $tipoVinculo->getCodTipo() . " - " . $tipoVinculo->getDescricao();
            $data[$key] = $tipoVinculo->getCodTipo();
        }

        return $data;
    }
}
