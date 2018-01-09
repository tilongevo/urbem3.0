<?php

namespace Urbem\CoreBundle\Doctrine\DBAL\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TimeType;
use Urbem\CoreBundle\Helper\TimeMicrosecondPK;

class TimeMicrosecondPKType extends TimeType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (true == is_string($value)) {
            $value = $this->convertToPHPValue($value, $platform);
        }

        return null !== $value ? $value->format(TimeMicrosecondPK::FORMAT) : null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return TimeMicrosecondPK::toPHPValue(TimeMicrosecondPK::FORMAT, $value);
    }

    public function getName()
    {
        return 'timemicrosecondpk';
    }
}
