<?php

namespace Urbem\PrestacaoContasBundle\Helper;

use Urbem\CoreBundle\Helper\MonthsHelper;
use Urbem\PrestacaoContasBundle\Enum\FieldsAndData;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataView;

/**
 * Class ExportAdjustmentHelper
 * @package Urbem\PrestacaoContasBundle\Helper
 */
class ExportAdjustmentHelper
{
    /**
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection $params
     * @param $financialYear
     * @return \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection
     */
    public static function setFinancialYear(DataCollection $params, $financialYear)
    {
        $params->checkContentIsValid();
        self::validateFinancialYear($financialYear);

        $dataView = new DataView();
        $dataView->setName(FieldsAndData::FINANCIAL_YEAR_NAME);
        $dataView->setValue($financialYear);
        $dataView->setLabel($dataView->getName());
        $dataView->setText($financialYear);
        $params->add($dataView);

        return $params;
    }

    /**
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection $params
     * @param array $cnpj
     * @return \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection
     */
    public static function setCnpj(DataCollection $params, array $cnpj)
    {
        if (!empty($cnpj)) {
            $dataView = new DataView();
            $dataView->setName(FieldsAndData::CNPJ_SETOR_NAME);
            $dataView->setValue(array_shift($cnpj));
            $dataView->setLabel($dataView->getName());
            $dataView->setText($dataView->getValue());
            $params->add($dataView);
        }

        return $params;
    }

    /**
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection $params
     * @param $financialYear
     * @param string $controller
     * @param string $prefix
     * @return \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection
     */
    public static function setPeriodInitialAndFinal(DataCollection $params, $financialYear, $controller = FieldsAndData::REPORT_TYPE_NAME, $prefix = FieldsAndData::PREFIX_NAME)
    {
        $params->checkContentIsValid();
        self::validateFinancialYear($financialYear);

        if ($dataView = $params->findObjectByName($controller)) {
            $initialDate = '';
            $finalDate = '';

            switch ($dataView->getValue()) {
                case FieldsAndData::TWO_MONTHS_NAME:
                    $key = $prefix . FieldsAndData::TWO_MONTHS_NAME;
                    $reportType = $params->findObjectByName($key);
                    list($initialDate, $finalDate) = MonthsHelper::periodInitialFinalTwoMonths($reportType->getValue(), $financialYear);
                    break;
                case FieldsAndData::QUARTER_NAME:
                    $key = $prefix . FieldsAndData::QUARTER_NAME;
                    $reportType = $params->findObjectByName($key);
                    list($initialDate, $finalDate) = MonthsHelper::periodInitialFinalQuarter($reportType->getValue(), $financialYear);
                    break;
                case FieldsAndData::FOUR_MONTH_PERIOD_NAME:
                    $key = $prefix . FieldsAndData::FOUR_MONTH_PERIOD_NAME;
                    $reportType = $params->findObjectByName($key);
                    list($initialDate, $finalDate) = MonthsHelper::periodInitialFinalFourMonth($reportType->getValue(), $financialYear);
                    break;
            }

            $initialDateView = new DataView();
            $initialDateView->setName(FieldsAndData::INITIAL_DATE_NAME);
            $initialDateView->setValue($initialDate);
            $initialDateView->setLabel($initialDateView->getName());
            $initialDateView->setText($initialDate);

            $finalDateView = new DataView();
            $finalDateView->setName(FieldsAndData::FINAL_DATE_NAME);
            $finalDateView->setValue($finalDate);
            $finalDateView->setLabel($finalDateView->getName());
            $finalDateView->setText($finalDate);

            $params->add($initialDateView);
            $params->add($finalDateView);
        }

        return $params;
    }

    /**
     * @param DataCollection $params
     * @param $financialYear
     * @param string $controller
     * @return DataCollection
     * @throws \Exception
     */
    public static function setFirstDayAndLastDayMonth(DataCollection $params, $financialYear, $controller = FieldsAndData::MONTH_NAME)
    {
        $params->checkContentIsValid();
        self::validateFinancialYear($financialYear);

        if ($dataView = $params->findObjectByName($controller)) {
            $month = $dataView->getValue();
            $dateArray = MonthsHelper::firstDayAndLastDayMonth($month, $financialYear);
            list($initialDate, $finalDate) = $dateArray;

            $initialDateView = new DataView();
            $initialDateView->setName(FieldsAndData::INITIAL_DATE_NAME);
            $initialDateView->setValue($initialDate);
            $initialDateView->setLabel($initialDateView->getName());
            $initialDateView->setText($initialDate);

            $finalDateView = new DataView();
            $finalDateView->setName(FieldsAndData::FINAL_DATE_NAME);
            $finalDateView->setValue($finalDate);
            $finalDateView->setLabel($finalDateView->getName());
            $finalDateView->setText($finalDate);

            $params->add($initialDateView);
            $params->add($finalDateView);
        }

        return $params;
    }

    /**
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection $params
     * @param string $controller
     * @param string $prefix
     * @return \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection
     */
    public static function unsetUnusedParameters(DataCollection $params, $controller = FieldsAndData::REPORT_TYPE_NAME, $prefix = FieldsAndData::PREFIX_NAME)
    {
        $params->checkContentIsValid();

        if ($dataView = $params->findObjectByName($controller)) {
            self::unsetUnusedValue($params, $dataView, $prefix);
            $params->orderByKey();
        }

        return $params;
    }

    /**
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection $params
     * @param array $governmentAgency
     * @return \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection
     */
    public static function setGovernmentAgency(DataCollection $params, array $governmentAgency)
    {
        $params->checkContentIsValid();
        self::validateGovernmentAgency($governmentAgency);

        $setorGoverno = $params->findObjectByName(FieldsAndData::ST_CNPJ_SETOR_NAME);
        $governmentAgency = self::getGovernmentAgencyValue($setorGoverno, $governmentAgency);

        $dataView = new DataView();
        $dataView->setName(FieldsAndData::GOVERNMENT_AGENCY_NAME);
        $dataView->setValue($governmentAgency);
        $dataView->setLabel($dataView->getName());
        $dataView->setText($governmentAgency);
        $params->add($dataView);

        return $params;
    }

    /**
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection $dataCollection
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataView $dataView
     * @param $prefix
     */
    private static function unsetUnusedValue(DataCollection $dataCollection, DataView $dataView, $prefix)
    {
        foreach (MonthsHelper::$periodsYearNameList as $period) {
            $chosenPeriod = sprintf("%s%s", $prefix, $dataView->getValue());
            $periodWithPrefix = sprintf("%s%s", $prefix, strtolower($period));

            if ($periodWithPrefix != $chosenPeriod && $dataViewSelected = $dataCollection->findObjectByName($periodWithPrefix)) {
                $dataCollection->removeElement($dataViewSelected);
            }
        }
    }

    /**
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataView $setorGoverno
     * @param array $governmentAgency
     * @return string
     */
    private static function getGovernmentAgencyValue(DataView $setorGoverno, array $governmentAgency)
    {
        $result = FieldsAndData::GOVERNMENT_AGENCY_VALUE;
        list( , $governmentAgencyValue) = explode('~', self::getValueWhenArray($setorGoverno->getValue()));
        foreach ($governmentAgency as $item) {
            if ($governmentAgencyValue == $item) {
                return str_pad(trim($item), 4, "0", STR_PAD_LEFT);
            }
        }

       return $result;
    }

    // HotFix
    private static function getValueWhenArray($value) {
        if (is_array($value)) {
            return key($value);
        }

        return $value;
    }

    /**
     * @param $financialYear
     * @throws \Exception
     */
    private static function validateFinancialYear($financialYear)
    {
        if (empty($financialYear)) {
            throw new \Exception('Error: Exercicio Invalido!');
        }
    }

    /**
     * @param $governmentAgency
     * @throws \Exception
     */
    private static function validateGovernmentAgency(array $governmentAgency = null)
    {
        if (!count($governmentAgency)) {
            throw new \Exception('Error: Órgão do Governo Invalido!');
        }
    }
}
