<?php

namespace Urbem\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Helper\MonthsHelper;

/**
 * Class FourMonthPeriodType
 * @package Urbem\CoreBundle\Form\Type
 */
class FourMonthPeriodType extends AbstractType
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('multiple', false);
        $resolver->setDefaults([
            'choices' => ArrayHelper::parseInvertArrayToChoice(MonthsHelper::getFourMonthPeriodList()),
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
}
