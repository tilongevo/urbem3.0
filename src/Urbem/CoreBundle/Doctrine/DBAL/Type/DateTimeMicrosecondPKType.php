<?php

namespace Urbem\CoreBundle\Doctrine\DBAL\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

class DateTimeMicrosecondPKType extends DateTimeType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (true == is_string($value)) {
            $value = $this->convertToPHPValue($value, $platform);
        }

        return null !== $value ? $value->format(DateTimeMicrosecondPK::FORMAT) : null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return DateTimeMicrosecondPK::toPHPValue(DateTimeMicrosecondPK::FORMAT, $value);
    }

    public function getName()
    {
        return 'datetimemicrosecondpk';
    }
}
