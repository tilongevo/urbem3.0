<?php

namespace Urbem\CoreBundle\Entity;

/**
 * Class Entity
 * @package Urbem\PrestacaoContasBundle\Entity
 */
abstract class Entity implements EntityInterface
{
    /**
     * @return array
     */
    public static function getConstants()
    {
        $reflectionClass = new \ReflectionClass(static::class);

        return $reflectionClass->getConstants();
    }
}