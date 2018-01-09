<?php

namespace Urbem\CoreBundle\Doctrine\DBAL\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Types\TimeType;
use Urbem\CoreBundle\Helper\TimePK;

class TimePKType extends TimeType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (true == is_string($value)) {
            $value = $this->convertToPHPValue($value, $platform);
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return TimePK::toPHPValue($platform->getTimeFormatString(), $value);
    }

    public function getName()
    {
        return 'timepk';
    }
}
