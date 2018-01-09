<?php

namespace Urbem\CoreBundle\Twig;

/**
 * Class NbspExtension
 * @package Urbem\CoreBundle\Twig
 */
class NbspExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return array (
            new \Twig_SimpleFilter('nbsp', [$this, 'convertNullEmptytoNbsp'])
        );
    }

    /**
     * Quando o valor do campo no twig for nulo ou vazio, retornar um non-breaking-space &nbsp;
     * @param mixed $value
     * @return string
     */
    public function convertNullEmptytoNbsp($value)
    {
        if (is_null($value) or empty(trim($value))) {
            return html_entity_decode("&nbsp;");
        }
        return $value;
    }
}
