<?php

namespace Urbem\PrestacaoContasBundle\Form;

use Urbem\CoreBundle\Form\Type\DynamicCollectionType;
use Symfony\Component\Form\FormTypeInterface;

/**
 * Class DynamicCollectionManagerFactory
 * @package Urbem\PrestacaoContasBundle\Form
 */
class DynamicCollectionManagerFactory
{
    /**
     * @param \Symfony\Component\Form\FormTypeInterface $dynamicType
     * @return \Urbem\CoreBundle\Form\Type\DynamicCollectionType
     */
    public static function createNewsletterManager(FormTypeInterface $dynamicType)
    {
        return new DynamicCollectionType($dynamicType);
    }
}
