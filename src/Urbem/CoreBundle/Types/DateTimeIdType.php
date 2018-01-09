<?php
namespace Urbem\CoreBundle\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Urbem\CoreBundle\Helper\DateTimeIdHelper;

class DateTimeIdType extends Type
{
    const DATETIMEID = 'datetimeid';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getDateTimeTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $dateTime = parent::convertToPHPValue($value, $platform);

        if (! $dateTime) {
            return $dateTime;
        }

        if (is_object($dateTime)) {
            $value = new DateTimeIdHelper('@' . $dateTime->format('U'));
        }
        return $value;
    }

    public function getName()
    {
        return self::DATETIMEID;
    }
}
