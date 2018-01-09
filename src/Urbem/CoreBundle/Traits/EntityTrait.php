<?php

namespace Urbem\CoreBundle\Traits;

trait EntityTrait
{
    public function __call($method, $params)
    {
        $property = lcfirst(substr($method, 3));

        if (property_exists($this, $property)) {
            switch (substr($method, 0, 3)) {
                case "get":
                    return $this->$property;
                    break;
                case "set":
                    $this->$property = $params[0];
                    break;
            }
        } else {
            throw new \Exception("Property {$property} not found.", 1);
        }

        return $this;
    }
}
