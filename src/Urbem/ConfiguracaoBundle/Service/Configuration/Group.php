<?php

namespace Urbem\ConfiguracaoBundle\Service\Configuration;

use Doctrine\Common\Collections\ArrayCollection;

class Group extends ArrayCollection
{
    const KEY_NAME = 'name';
    const KEY_ITEMS = 'items';

    public function __construct(array $group)
    {
        parent::__construct($group);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (string) $this->offsetGet(self::KEY_NAME);
    }

    /**
     * @return \CallbackFilterIterator
     */
    public function getIterator()
    {
        return new \CallbackFilterIterator(new \IteratorIterator(new \ArrayIterator($this->get(self::KEY_ITEMS))), function(&$item) {
            $item = new Item($item);

            return true;
        });
    }

    /**
     * @return \Iterator|Item
     */
    public function getItems()
    {
        return $this->getIterator();
    }
}
