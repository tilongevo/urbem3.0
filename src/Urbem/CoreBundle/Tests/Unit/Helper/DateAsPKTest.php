<?php

namespace Urbem\CoreBundle\Tests\Unit\Helper;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Urbem\CoreBundle\Doctrine\DBAL\Type\DatePKType;
use Urbem\CoreBundle\Doctrine\DBAL\Type\DateTimeMicrosecondPKType;
use Urbem\CoreBundle\Doctrine\DBAL\Type\DateTimePKType;
use Urbem\CoreBundle\Doctrine\DBAL\Type\DateTimeTZPKType;
use Urbem\CoreBundle\Doctrine\DBAL\Type\TimeMicrosecondPKType;
use Urbem\CoreBundle\Doctrine\DBAL\Type\TimePKType;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Helper\DateTimePK;
use Urbem\CoreBundle\Helper\DateTimeTZPK;
use Urbem\CoreBundle\Helper\TimeMicrosecondPK;
use Urbem\CoreBundle\Helper\TimePK;

class DateAsPKTest extends TypeTestCase
{
    public function platformProvider()
    {
        $platform = $this->getMockForAbstractClass(AbstractPlatform::class, [], '', false, false, true, [
            'getDateFormatString',
            'getDateTimeFormatString',
            'getDateTimeTzFormatString',
            'getTimeFormatString'
        ]);

        $platform->method('getDateFormatString')->willReturn(DatePK::FORMAT);
        $platform->method('getDateTimeFormatString')->willReturn(DateTimePK::FORMAT);
        $platform->method('getDateTimeTzFormatString')->willReturn(DateTimeTZPK::FORMAT);
        $platform->method('getTimeFormatString')->willReturn(TimePK::FORMAT);

        return [[$platform]];
    }

    public function testDatePKAsString()
    {
        $expected = (new \DateTime())->format(DatePK::FORMAT);

        $this->assertEquals($expected, (string) new DatePK($expected));
    }

    public function testDateTimePKAsString()
    {
        $expected = (new \DateTime())->format(DateTimePK::FORMAT);

        $this->assertEquals($expected, (string) new DateTimePK($expected));
    }

    public function testDateTimeMicrosecondPKAsString()
    {
        $expected = (new \DateTime('2016-11-29 16:26:33.548600'))->format(DateTimeMicrosecondPK::FORMAT);

        $this->assertEquals($expected, (string) new DateTimeMicrosecondPK($expected));
    }

    public function testDateTimeTZPKAsString()
    {
        $expected = (new \DateTime())->format(DateTimeTZPK::FORMAT);

        $this->assertEquals($expected, (string) new DateTimeTZPK($expected));
    }

    public function testTimePKAsString()
    {
        $expected = (new \DateTime())->format(TimePK::FORMAT);

        $this->assertEquals($expected, (string) new TimePK($expected));
    }

    public function testTimeMicrosecondPKAsString()
    {
        $expected = (new \DateTime('16:26:33.548600'))->format(TimeMicrosecondPK::FORMAT);

        $this->assertEquals($expected, (string) new TimeMicrosecondPK($expected));
    }

    /**
     * @dataProvider platformProvider
     */
    public function testDatePKToPHPValue(AbstractPlatform $platform)
    {
        $type = $this->getMockBuilder(DatePKType::class)->disableOriginalConstructor()->setMethods(null)->getMock();

        $dateAsString = (new \DateTime())->format(DatePK::FORMAT);
        $date = new \DateTime($dateAsString);

        $dateAsPHP = $type->convertToPHPValue($dateAsString, $platform);

        $this->assertEquals(DatePK::class, get_class($dateAsPHP));
        $this->assertEquals($date->format(DatePK::FORMAT), $dateAsPHP->format(DatePK::FORMAT));
        $this->assertEquals($dateAsString, $type->convertToDatabaseValue($date, $platform));
        $this->assertEquals($dateAsString, $type->convertToDatabaseValue($dateAsString, $platform));

        $dateAsString = 'a-b-c';

        try {
            $type->convertToPHPValue($dateAsString, $platform);
            $this->fail('ConversionException on invalid date was not thrown');

        } catch (\Exception $e) {
            $this->assertEquals(sprintf('Could not convert database value "%s" to Doctrine Type %s. Expected format: %s', $dateAsString, DatePK::class, DatePK::FORMAT), $e->getMessage());
        }
    }

    /**
     * @dataProvider platformProvider
     */
    public function testDateTimePKToPHPValue(AbstractPlatform $platform)
    {
        $type = $this->getMockBuilder(DateTimePKType::class)->disableOriginalConstructor()->setMethods(null)->getMock();

        $dateAsString = (new \DateTime())->format(DateTimePK::FORMAT);
        $date = new \DateTime($dateAsString);

        $dateAsPHP = $type->convertToPHPValue($dateAsString, $platform);

        $this->assertEquals(DateTimePK::class, get_class($dateAsPHP));
        $this->assertEquals($date->format(DateTimePK::FORMAT), $dateAsPHP->format(DateTimePK::FORMAT));
        $this->assertEquals($dateAsString, $type->convertToDatabaseValue($date, $platform));
        $this->assertEquals($dateAsString, $type->convertToDatabaseValue($dateAsString, $platform));

        $dateAsString = 'a-b-c';

        try {
            $type->convertToPHPValue($dateAsString, $platform);
            $this->fail('ConversionException on invalid date was not thrown');

        } catch (\Exception $e) {
            $this->assertEquals(sprintf('Could not convert database value "%s" to Doctrine Type %s. Expected format: %s', $dateAsString, DateTimePK::class, DateTimePK::FORMAT), $e->getMessage());
        }
    }

    /**
     * @dataProvider platformProvider
     */
    public function testDateTimeMicrosecondPKToPHPValue(AbstractPlatform $platform)
    {
        $type = $this->getMockBuilder(DateTimeMicrosecondPKType::class)->disableOriginalConstructor()->setMethods(null)->getMock();

        $dateAsString = (new \DateTime('2016-11-29 16:26:33.548600'))->format(DateTimeMicrosecondPK::FORMAT);
        $date = new \DateTime($dateAsString);

        $dateAsPHP = $type->convertToPHPValue($dateAsString, $platform);

        $this->assertEquals(DateTimeMicrosecondPK::class, get_class($dateAsPHP));
        $this->assertEquals($date->format(DateTimeMicrosecondPK::FORMAT), $dateAsPHP->format(DateTimeMicrosecondPK::FORMAT));
        $this->assertEquals($dateAsString, $type->convertToDatabaseValue($date, $platform));
        $this->assertEquals($dateAsString, $type->convertToDatabaseValue($dateAsString, $platform));

        $dateAsString = 'a-b-c';

        try {
            $type->convertToPHPValue($dateAsString, $platform);
            $this->fail('ConversionException on invalid date was not thrown');

        } catch (\Exception $e) {
            $this->assertEquals(sprintf('Could not convert database value "%s" to Doctrine Type %s. Expected format: %s', $dateAsString, DateTimeMicrosecondPK::class, DateTimeMicrosecondPK::FORMAT), $e->getMessage());
        }
    }

    /**
     * @dataProvider platformProvider
     */
    public function testDateTimeTZPKToPHPValue(AbstractPlatform $platform)
    {
        $type = $this->getMockBuilder(DateTimeTZPKType::class)->disableOriginalConstructor()->setMethods(null)->getMock();

        $dateAsString = (new \DateTime())->format(DateTimeTZPK::FORMAT);
        $date = new \DateTime($dateAsString);

        $dateAsPHP = $type->convertToPHPValue($dateAsString, $platform);

        $this->assertEquals(DateTimeTZPK::class, get_class($dateAsPHP));
        $this->assertEquals($date->format(DateTimeTZPK::FORMAT), $dateAsPHP->format(DateTimeTZPK::FORMAT));
        $this->assertEquals($dateAsString, $type->convertToDatabaseValue($date, $platform));
        $this->assertEquals($dateAsString, $type->convertToDatabaseValue($dateAsString, $platform));

        $dateAsString = 'a-b-c';

        try {
            $type->convertToPHPValue($dateAsString, $platform);
            $this->fail('ConversionException on invalid date was not thrown');

        } catch (\Exception $e) {
            $this->assertEquals(sprintf('Could not convert database value "%s" to Doctrine Type %s. Expected format: %s', $dateAsString, DateTimeTZPK::class, DateTimeTZPK::FORMAT), $e->getMessage());
        }
    }

    /**
     * @dataProvider platformProvider
     */
    public function testTimePKToPHPValue(AbstractPlatform $platform)
    {
        $type = $this->getMockBuilder(TimePKType::class)->disableOriginalConstructor()->setMethods(null)->getMock();

        $dateAsString = (new \DateTime())->format(TimePK::FORMAT);
        $date = new \DateTime($dateAsString);

        $dateAsPHP = $type->convertToPHPValue($dateAsString, $platform);

        $this->assertEquals(TimePK::class, get_class($dateAsPHP));
        $this->assertEquals($date->format(TimePK::FORMAT), $dateAsPHP->format(TimePK::FORMAT));
        $this->assertEquals($dateAsString, $type->convertToDatabaseValue($date, $platform));
        $this->assertEquals($dateAsString, $type->convertToDatabaseValue($dateAsString, $platform));

        $dateAsString = 'a-b-c';

        try {
            $type->convertToPHPValue($dateAsString, $platform);
            $this->fail('ConversionException on invalid date was not thrown');

        } catch (\Exception $e) {
            $this->assertEquals(sprintf('Could not convert database value "%s" to Doctrine Type %s. Expected format: %s', $dateAsString, TimePK::class, TimePK::FORMAT), $e->getMessage());
        }
    }

    /**
     * @dataProvider platformProvider
     */
    public function testTimeMicrosecondPKToPHPValue(AbstractPlatform $platform)
    {
        $type = $this->getMockBuilder(TimeMicrosecondPKType::class)->disableOriginalConstructor()->setMethods(null)->getMock();

        $dateAsString = (new \DateTime('16:26:33.548600'))->format(TimeMicrosecondPK::FORMAT);
        $date = new \DateTime($dateAsString);

        $dateAsPHP = $type->convertToPHPValue($dateAsString, $platform);

        $this->assertEquals(TimeMicrosecondPK::class, get_class($dateAsPHP));
        $this->assertEquals($date->format(TimeMicrosecondPK::FORMAT), $dateAsPHP->format(TimeMicrosecondPK::FORMAT));
        $this->assertEquals($dateAsString, $type->convertToDatabaseValue($date, $platform));
        $this->assertEquals($dateAsString, $type->convertToDatabaseValue($dateAsString, $platform));

        $dateAsString = 'a-b-c';

        try {
            $type->convertToPHPValue($dateAsString, $platform);
            $this->fail('ConversionException on invalid date was not thrown');

        } catch (\Exception $e) {
            $this->assertEquals(sprintf('Could not convert database value "%s" to Doctrine Type %s. Expected format: %s', $dateAsString, TimeMicrosecondPK::class, TimeMicrosecondPK::FORMAT), $e->getMessage());
        }
    }

    public function testDatePKTransform()
    {
        $form = $this->factory->createBuilder()
        ->add('DatePK', \Urbem\CoreBundle\Form\Type\DatePKType::class, [
            'pk_class' => DatePK::class,
        ])
        ->add('DateTimeMicrosecondPK', \Urbem\CoreBundle\Form\Type\DatePKType::class, [
            'pk_class' => DateTimeMicrosecondPK::class,
        ])
        ->add('DateTimePK', \Urbem\CoreBundle\Form\Type\DatePKType::class, [
            'pk_class' => DateTimePK::class,
        ])
        ->add('DateTimeTZPK', \Urbem\CoreBundle\Form\Type\DatePKType::class, [
            'pk_class' => DateTimeTZPK::class,
        ])
        ->add('TimeMicrosecondPK', \Urbem\CoreBundle\Form\Type\DatePKType::class, [
            'pk_class' => TimeMicrosecondPK::class,
        ])
        ->add('TimePK', \Urbem\CoreBundle\Form\Type\DatePKType::class, [
            'pk_class' => TimePK::class,
        ])
        ->getForm();

        $form->submit($data = [
            'DatePK' => '2016-10-10',
            'DateTimeMicrosecondPK' => '2016-10-10 10:10:10.548600',
            'DateTimePK' => '2016-10-10 10:10:10',
            'DateTimeTZPK' => (new \DateTime())->format(DateTimeTZPK::FORMAT),
            'TimeMicrosecondPK' => '10:10:10.548600',
            'TimePK' => '10:10:10',
        ]);

        $this->assertTrue($form->isSynchronized());

        $this->assertEquals(DatePK::class, get_class($form->get('DatePK')->getData()));
        $this->assertEquals($data['DatePK'], (string) $form->get('DatePK')->getData());

        $this->assertEquals(DateTimeMicrosecondPK::class, get_class($form->get('DateTimeMicrosecondPK')->getData()));
        $this->assertEquals($data['DateTimeMicrosecondPK'], (string) $form->get('DateTimeMicrosecondPK')->getData());

        $this->assertEquals(DateTimePK::class, get_class($form->get('DateTimePK')->getData()));
        $this->assertEquals($data['DateTimePK'], (string) $form->get('DateTimePK')->getData());

        $this->assertEquals(DateTimeTZPK::class, get_class($form->get('DateTimeTZPK')->getData()));
        $this->assertEquals($data['DateTimeTZPK'], (string) $form->get('DateTimeTZPK')->getData());

        $this->assertEquals(TimeMicrosecondPK::class, get_class($form->get('TimeMicrosecondPK')->getData()));
        $this->assertEquals($data['TimeMicrosecondPK'], (string) $form->get('TimeMicrosecondPK')->getData());

        $this->assertEquals(TimePK::class, get_class($form->get('TimePK')->getData()));
        $this->assertEquals($data['TimePK'], (string) $form->get('TimePK')->getData());
    }
}
