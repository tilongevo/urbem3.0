<?php

namespace Urbem\ConfiguracaoBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ConfigurationTextareaType extends ConfigurationAbstractType
{
    public function getParent()
    {
        return TextareaType::class;
    }
}
