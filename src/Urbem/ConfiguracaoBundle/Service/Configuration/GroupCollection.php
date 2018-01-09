<?php

namespace Urbem\ConfiguracaoBundle\Service\Configuration;

use Doctrine\Common\Collections\ArrayCollection;

class GroupCollection extends ArrayCollection
{
    /**
     * GroupCollection constructor.
     * @param array $groups
     */
    public function __construct(array $groups)
    {
        parent::__construct($groups);
    }

    /**
     * @return \CallbackFilterIterator
     */
    public function getIterator()
    {
        return new \CallbackFilterIterator(parent::getIterator(), function(&$group) {
            $group = new Group($group);

            return true;
        });
    }

    /**
     * @return \Iterator|Group
     */
    public function getGroups()
    {
        return $this->getIterator();
    }
}
