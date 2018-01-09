<?php

namespace Urbem\CoreBundle\Helper;

use Doctrine\ORM\EntityManagerInterface;

class ObjectKeyHelper
{
    const SEPARATOR = '~';

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Converts $object primary key(s) to string:
     *
     * Example: object(pk1 = 1, pk2 = 2) -> converts to 1~2
     *
     * @param $object
     * @param $separator
     * @return string
     */
    public function generate($object, $separator = self::SEPARATOR)
    {
        if (null === $object) {
            return null;
        }
        return implode($separator, $this->getIdentifierValues($object));
    }

    /**
     * Return identifier values
     * @param $object
     * @return array
     */
    public function getIdentifierValues($object)
    {
        return $this->em->getClassMetadata(get_class($object))->getIdentifierValues($object);
    }
}
