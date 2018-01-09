<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Urbem\CoreBundle\Entity\Administracao\Acao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao\ManterNotasExplicativas;

/**
 * Class AnexosType
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form
 */
class AnexosType extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * AnexosType constructor.
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
            'choices' => $this->getAnexos(),
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
    protected function getAnexos()
    {
        $data = [];
        $qb = $this->em->getRepository(Acao::class)->findStnAnexos(Modulo::MODULO_STN, ManterNotasExplicativas::COD_FUNCIONALIDADE);
        $anexos = $qb->getQuery()->getResult();
        /** @var Acao $anexo */
        foreach ($anexos as $anexo) {
            $key = $anexo->getFkAdministracaoFuncionalidade()->getNomFuncionalidade() . " - " . $anexo->getNomAcao();
            $data[$key] = $anexo->getCodAcao();
        }

        return $data;
    }
}