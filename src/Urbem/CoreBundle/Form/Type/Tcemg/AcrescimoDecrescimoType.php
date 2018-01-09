<?php

namespace Urbem\CoreBundle\Form\Type\Tcemg;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo;

class AcrescimoDecrescimoType extends AbstractType
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('label', 'Tipo de Alteração do Valor');
        $resolver->setDefault('attr', ['class' => 'select2-parameters ']);
        $resolver->setDefault('choices', [
            'Acréscimo' => ContratoAditivo::COD_TIPO_VALOR_ACRESCIMO,
            'Decréscimo' => ContratoAditivo::COD_TIPO_VALOR_DECRESCIMO
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
