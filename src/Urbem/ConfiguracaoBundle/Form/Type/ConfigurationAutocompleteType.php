<?php

namespace Urbem\ConfiguracaoBundle\Form\Type;

use Urbem\CoreBundle\Form\Type\AutoCompleteType;

class ConfigurationAutocompleteType extends ConfigurationAbstractType
{
    public function getParent()
    {
        return AutoCompleteType::class;
    }
}
