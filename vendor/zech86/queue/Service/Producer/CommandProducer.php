<?php

namespace Zechim\QueueBundle\Service\Producer;

class CommandProducer extends AbstractProducer
{
    public function publish($name, array $options = [], \DateInterval $interval = null)
    {
        $normalized = [];

        array_walk($options, function ($value, $key) use (&$normalized) {
            $normalized[sprintf('--%s', trim($key, '-'))] = $value;
        });

        $this->doPublish(['command' => $name, 'options' => $normalized], $interval);
    }
}
