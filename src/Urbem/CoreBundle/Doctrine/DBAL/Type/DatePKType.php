<?php

namespace Urbem\CoreBundle\Doctrine\DBAL\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateType;
use Urbem\CoreBundle\Helper\DatePK;

/**
 * Class DatePKType
 * @package Urbem\CoreBundle\Doctrine\DBAL\Type
 */
class DatePKType extends DateType
{
    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (true == is_string($value)) {
            $value = $this->convertToPHPValue($value, $platform);
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return \DateTime|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return DatePK::toPHPValue($platform->getDateFormatString(), $value);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'datepk';
    }
}
