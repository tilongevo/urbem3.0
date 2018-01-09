<?php

namespace Urbem\ConfiguracaoBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ConfigurationChoiceType extends ConfigurationAbstractType
{
    public function getParent()
    {
        return ChoiceType::class;
    }
}
