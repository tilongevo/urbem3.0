<?php

namespace Urbem\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Urbem\CoreBundle\Helper\ArrayHelper;
use \DateTime;

/**
 * Class YearType
 * @package Urbem\CoreBundle\Form\Type
 */
class YearType extends AbstractType
{
    CONST QUANTITY_YEARS = 4;

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('multiple', false);
        $resolver->setDefaults([
            'choices' => ArrayHelper::parseInvertArrayToChoice($this->getFinancialYearList(), $camelcase = true),
            'choices_as_values' => true,
        ]);
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return ChoiceType::class;
    }

    /**
     * @return array
     */
    private function getFinancialYearList()
    {
        $dateTime = new DateTime();
        $year = $dateTime->format('Y');
        $yearList = [];

        for ($i = 1; $i <= self::QUANTITY_YEARS; $i++)
        {
            $yearList[$year] = $year;
            $year--;
        }

        return $yearList;
    }
}
