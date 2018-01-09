<?php

namespace Urbem\CoreBundle\Doctrine\TypeConverter;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class ConverterFactory
{
    /**
     * @var $em \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    const TYPE_DATETIMEMICROSECOND = 'DateTimeMicrosecondType';

    const TYPE_TIMEMICROSECOND = 'TimeMicrosecondType';

    private $instance = [];

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $className
     * @param $column
     * @return array
     */
    public function getToDateTimeMicrosecondTypeUpdateList($className, $column)
    {
        return $this->getImplementation(self::TYPE_DATETIMEMICROSECOND)->getUpdateList($className, $column);
    }

    /**
     * @param $className
     * @param $column
     * @return array
     */
    public function getToTimeMicrosecondTypeUpdateList($className, $column)
    {
        return $this->getImplementation(self::TYPE_TIMEMICROSECOND)->getUpdateList($className, $column);
    }

    /**
     * @param $type
     * @return \Urbem\CoreBundle\Doctrine\TypeConverter\Type\AbstractType;
     */
    protected function getImplementation($type)
    {
        $type = sprintf('\Urbem\CoreBundle\Doctrine\TypeConverter\Type\%s', $type);

        if (true == array_key_exists($type, $this->instance)) {
            return $this->instance[$type];
        }

        return $this->instance[$type] = new $type($this->em);
    }
}
