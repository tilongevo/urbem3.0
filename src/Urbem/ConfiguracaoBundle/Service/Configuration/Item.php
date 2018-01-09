<?php

namespace Urbem\ConfiguracaoBundle\Service\Configuration;

use Doctrine\Common\Collections\ArrayCollection;

class Item extends ArrayCollection
{
    /**
     * @return string
     */
    public function getType()
    {
        return (string) $this->get('type');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (string) $this->get('name');
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        $options = [
            'mapped' => false
        ];

        foreach ($this->toArray() as $option => $value) {
            /* setters and getters defined */
            if (true === in_array($option, ['type', 'name'])) {
                continue;
            }

            $options[$option] = $value;
        }

        return $options;
    }
}
