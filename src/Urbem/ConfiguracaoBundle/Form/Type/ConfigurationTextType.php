<?php

namespace Urbem\ConfiguracaoBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class ConfigurationTextType extends ConfigurationAbstractType
{
    public function getParent()
    {
        return TextType::class;
    }
}
