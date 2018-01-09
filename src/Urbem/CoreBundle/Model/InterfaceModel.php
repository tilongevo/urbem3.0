<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM\EntityManager;

interface InterfaceModel
{
    /**
     * InterfaceModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager);

    /**
     * @param object $object
     *
     * @return boolean
     */
    public function canRemove($object);
}
