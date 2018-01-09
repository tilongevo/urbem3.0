<?php

namespace Urbem\CoreBundle\Form\Transform;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Urbem\CoreBundle\Helper\DateTimePK;
use Urbem\CoreBundle\Helper\TimePK;

class DatePKTransform implements DataTransformerInterface
{
    protected $options = [
        'class' => DateTimePK::class,
        'force_hour' => false,
        'force_minute' => false,
        'force_second' => false,
        'force_microsecond' => false,
        'force_timezone' => false,
        'force_default' => false,
    ];

    public function __construct(array $options)
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Convert a string date to DatePKInterface
     *
     * @param mixed $date
     * @return \Urbem\CoreBundle\Helper\DatePKInterface|null
     */
    public function transform($date)
    {
        if (true === empty($date)) {
            if (true === $this->options['force_default']) {
                $date = $this->reverseTransform(new \DateTime());
            } else {
                return null;
            }
        }

        return $date;
    }

    /**
     * Convert \DateTime to to DatePKInterface
     *
     * @param mixed $date
     * @return \Urbem\CoreBundle\Helper\DatePKInterface
     */
    public function reverseTransform($date)
    {
        if (true === empty($date)) {
            return null;
        }

        $class = $this->options['class'];

        /** @var $date \DateTime */
        if (false === ($date instanceof \DateTime)) {
            $date = (new $this->options['class'])->toPHPValue(constant($class . '::FORMAT'), $date);
        }

        $hour = $date->format('H');
        $minute = $date->format('i');
        $second = $date->format('s');
        $microsecond = $date->format('u');
        $timezone = $date->format('O');

        if (true === $this->options['force_hour']) {
            $hour = date('H');
        }

        if (true === $this->options['force_minute']) {
            $minute = date('i');
        }

        if (true === $this->options['force_second']) {
            $second = date('s');
        }

        if (true === $this->options['force_microsecond']) {
            $microsecond = explode(',', microtime(true));
            $microsecond = 2 === count($microsecond) ? $microsecond : explode('.', end($microsecond));
            $microsecond = end($microsecond);
        }

        if (true === $this->options['force_timezone']) {
            $timezone = date('O');
        }

        $time = sprintf(
            '%s %s.%s%s',
            $date->format('Y-m-d'),
            sprintf('%s:%s:%s', $hour, $minute, $second),
            $microsecond,
            $timezone
        );

        return new $this->options['class']((new \DateTime($time))->format(constant($class . '::FORMAT')));
    }
}
