<?php

namespace Urbem\CoreBundle\Doctrine\DBAL\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeTzType;
use Doctrine\DBAL\Types\DateType;
use Urbem\CoreBundle\Helper\DateTimeTZPK;

class DateTimeTZPKType extends DateTimeTzType
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
        return DateTimeTZPK::toPHPValue($platform->getDateTimeTzFormatString(), $value);
    }

    public function getName()
    {
        return 'datetimetzpk';
    }
}
