<?php

namespace Urbem\PrestacaoContasBundle\Form\Type\Stn;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Stn\IdentificadorRiscoFiscal;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Class IdentificadorRiscoFiscalType
 * @package Urbem\PrestacaoContasBundle\Form\Type
 */
class IdentificadorRiscoFiscalType extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * IdentificadorRiscoFiscalType constructor.
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
            'choices' => $this->getIdentificadores(),
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
    protected function getIdentificadores()
    {
        $data = [];
        $identificadores = $this->em->getRepository(IdentificadorRiscoFiscal::class)->findAll();
        /** @var IdentificadorRiscoFiscal $identificador */
        foreach ($identificadores as $identificador) {
            $key = $identificador->getCodIdentificador() . " - " . $identificador->getDescricao();
            $data[$key] = $identificador->getCodIdentificador();
        }

        return $data;
    }
}
