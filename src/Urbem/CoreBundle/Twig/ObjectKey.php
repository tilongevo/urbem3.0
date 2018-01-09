<?php

namespace Urbem\CoreBundle\Twig;

use Urbem\CoreBundle\Helper\ObjectKeyHelper;

class ObjectKey extends \Twig_Extension
{

    /**
     * @var ObjectKeyHelper
     */
    private $objectKeyHelper;

    public function __construct(ObjectKeyHelper $objectKeyHelper)
    {
        $this->objectKeyHelper = $objectKeyHelper;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('objectKey', array($this, 'getObjectKey')),
        );
    }

    public function getObjectKey($object)
    {
        return $this->objectKeyHelper->generate($object);
    }

    public function getName()
    {
        return 'objectkey';
    }
}
