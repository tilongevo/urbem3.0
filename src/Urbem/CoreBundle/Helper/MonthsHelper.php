<?php

namespace Urbem\CoreBundle\Helper;

/**
 * Class MonthsHelper
 * @package Urbem\CoreBundle\Helper
 */
class MonthsHelper
{
    const JANUARY = 'JANEIRO';
    const FEBRUARY = 'FEVEREIRO';
    const MARCH = 'MARÇO';
    const APRIL = 'ABRIL';
    const MAY = 'MAIO';
    const JUNE = 'JUNHO';
    const JULY = 'JULHO';
    const AUGUST = 'AGOSTO';
    const SEPTEMBER = 'SETEMBRO';
    const OCTOBER = 'OUTUBRO';
    const NOVEMBER = 'NOVEMBRO';
    const DECEMBER = 'DEZEMBRO';

    const TWO_MONTH_NAME = 'Bimestre';
    const QUARTER_NAME = 'Trimestre';
    const FOUR_MONTH_PERIOD_NAME = 'Quadrimestre';
    const SEMESTER_NAME = 'Semestre';

    /**
     * @var array
     */
    public static $monthList = [
        '01' => self::JANUARY,
        '02' => self::FEBRUARY,
        '03' => self::MARCH,
        '04' => self::APRIL,
        '05' => self::MAY,
        '06' => self::JUNE,
        '07' => self::JULY,
        '08' => self::AUGUST,
        '09' => self::SEPTEMBER,
        '10' => self::OCTOBER,
        '11' => self::NOVEMBER,
        '12' => self::DECEMBER,
    ];

    /**
     * @var array
     */
    public static $twoMonthsNameList = [
        1 => self::JANUARY,
        2 => self::MARCH,
        3 => self::MAY,
        4 => self::JULY,
        5 => self::SEPTEMBER,
        6 => self::NOVEMBER,
    ];

    /**
     * @var array
     */
    public static $quarterNameList = [
        1 => self::JANUARY,
        2 => self::APRIL,
        3 => self::JULY,
        4 => self::OCTOBER,
    ];

    /**
     * @var array
     */
    public static $fourMonthPeriodNameList = [
        1 => self::JANUARY,
        2 => self::MAY,
        3 => self::SEPTEMBER,
    ];

    /**
     * @var array
     */
    public static $semesterNameList = [
        1 => self::JANUARY,
        2 => self::JULY,
    ];

    /**
     * @var array
     */
    public static $periodsYearNameList = [
        self::TWO_MONTH_NAME => self::TWO_MONTH_NAME,
        self::QUARTER_NAME => self::QUARTER_NAME,
        self::FOUR_MONTH_PERIOD_NAME => self::FOUR_MONTH_PERIOD_NAME,
        self::SEMESTER_NAME => self::SEMESTER_NAME,
    ];

    /**
     * @return array
     */
    public static function getMonthName($month)
    {
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);

        return isset (self::$monthList[$month]) ? self::$monthList[$month] : $month;

    }

    /**
     * @return array
     */
    public static function getTwoMonthsList()
    {
        $list = [];
        for($month = 1; $month <= 6; $month++) {
            $list[$month] = sprintf("{$month}º %s", self::TWO_MONTH_NAME);
        }

        return $list;
    }

    /**
     * @param $twoMonths
     *
     * @return mixed
     */
    public static function getTwoMonthsName($twoMonths)
    {
        return isset (self::$twoMonthsNameList[$twoMonths]) ? self::$twoMonthsNameList[$twoMonths] : $twoMonths;
    }

    /**
     * @return array
     */
    public static function getQuarterList()
    {
        $list = [];
        foreach (self::$quarterNameList as $quarter => $month) {
            $list[$quarter] = sprintf("{$quarter}º %s", self::QUARTER_NAME);
        }

        return $list;
    }

    /**
     * @return array
     */
    public static function getSemesterList()
    {
        $list = [];
        foreach (self::$semesterNameList as $semester => $month) {
            $list[$semester] = sprintf("{$semester}º %s", self::SEMESTER_NAME);
        }

        return $list;
    }

    /**
     * @return array
     */
    public static function getFourMonthPeriodList()
    {
        $list = [];
        foreach (self::$fourMonthPeriodNameList as $fourMonthPeriod => $month) {
            $list[$fourMonthPeriod] = sprintf("{$fourMonthPeriod}º %s", self::FOUR_MONTH_PERIOD_NAME);
        }

        return $list;
    }

    /**
     * @param $twoMonths
     * @param $financialYear
     * @return array
     */
    public static function periodInitialFinalTwoMonths($twoMonths, $financialYear)
    {
        $initialDate = '';
        $finalDate = '';
        switch($twoMonths) {
            case 1:
                $initialDate = '01/01/' . $financialYear;
                $finalDate   = date('d/m/Y', strtotime("-1 days",strtotime('01-03-' . $financialYear)) );
                break;
            case 2:
                $initialDate = '01/03/' . $financialYear;
                $finalDate   = '30/04/' . $financialYear;
                break;
            case 3:
                $initialDate = '01/05/' . $financialYear;
                $finalDate   = '30/06/' . $financialYear;
                break;
            case 4:
                $initialDate = '01/07/' . $financialYear;
                $finalDate   = '31/08/' . $financialYear;
                break;
            case 5:
                $initialDate = '01/09/' . $financialYear;
                $finalDate   = '31/10/' . $financialYear;
                break;
            case 6:
                $initialDate = '01/11/' . $financialYear;
                $finalDate   = '31/12/' . $financialYear;
                break;
        }

        return [$initialDate, $finalDate];
    }

    /**
     * @param $quarter
     * @param $financialYear
     * @return array
     */
    public static function periodInitialFinalQuarter($quarter, $financialYear)
    {
        $initialDate = '';
        $finalDate = '';
        switch($quarter) {
            case 1:
                $initialDate = '01/01/' . $financialYear;
                $finalDate   = '31/03/' . $financialYear;
                break;
            case 2:
                $initialDate = '01/04/' . $financialYear;
                $finalDate   = '30/06/' . $financialYear;
                break;
            case 3:
                $initialDate = '01/07/' . $financialYear;
                $finalDate   = '30/09/' . $financialYear;
                break;
            case 4:
                $initialDate = '01/10/' . $financialYear;
                $finalDate   = '31/12/' . $financialYear;
                break;
        }

        return [$initialDate, $finalDate];
    }

    /**
     * @param $fourMonth
     * @param $financialYear
     * @return array
     */
    public static function periodInitialFinalFourMonth($fourMonth, $financialYear)
    {
        $initialDate = '';
        $finalDate = '';
        switch($fourMonth) {
            case 1:
                $initialDate = '01/01/' . $financialYear;
                $finalDate   = '30/04/' . $financialYear;
                break;
            case 2:
                $initialDate = '01/05/' . $financialYear;
                $finalDate   = '31/08/' . $financialYear;
                break;
            case 3:
                $initialDate =  '01/09/' . $financialYear;
                $finalDate   = '31/12/' . $financialYear;
                break;
        }

        return [$initialDate, $finalDate];
    }

    /**
     * @param $semester
     * @param $financialYear
     * @return array
     */
    public static function periodInitialFinalSemester($semester, $financialYear)
    {
        $initialDate = '';
        $finalDate = '';
        switch($semester) {
            case 1:
                $initialDate = '01/01/' . $financialYear;
                $finalDate   = '30/06/' . $financialYear;
                break;
            case 2:
                $initialDate = '01/07/' . $financialYear;
                $finalDate   = '31/12/' . $financialYear;
                break;
        }

        return [$initialDate, $finalDate];
    }

    /**
     * @param $month
     * @param $financialYear
     * @return array
     */
    public static function firstDayAndLastDayMonth($month, $financialYear)
    {
        $initialDate = '01/' . $month . '/' . $financialYear;
        $finalDate = '';
        switch ($month) {
            case '01':
                $finalDate = '31/01/' . $financialYear;
                break;

            case '02':
                $finalDate = date('d/m/Y', strtotime("-1 days", strtotime('01-03-' . $financialYear)));
                break;

            case '03':
                $finalDate = '31/03/' . $financialYear;
                break;

            case '04':
                $finalDate = '30/04/' . $financialYear;
                break;

            case '05':
                $finalDate = '31/05/' . $financialYear;
                break;

            case '06':
                $finalDate = '30/06/' . $financialYear;
                break;

            case '07':
                $finalDate = '31/07/' . $financialYear;
                break;

            case '08':
                $finalDate = '31/08/' . $financialYear;
                break;

            case '09':
                $finalDate = '30/09/' . $financialYear;
                break;

            case '10':
                $finalDate = '31/10/' . $financialYear;
                break;

            case '11':
                $finalDate = '30/11/' . $financialYear;
                break;

            case '12':
                $finalDate = '31/12/' . $financialYear;
                break;
        }

        return [$initialDate, $finalDate];
    }

    /**
     * @param $month
     * @param $year
     * @return array
     * @throws \Exception
     */
    public static function getPreviousPeriodsAvailable($month, $year)
    {
        self::validateMonth($month);
        self::validateYear($year);

        $period = [];
        $yearToMonth = 12;
        for ($i = 0; $i < $yearToMonth; $i++) {
            $month--;
            if ($month == 0) {
                $month = 12;
                $year--;
            }
            $key = $month . '/' . $year;
            $period[$key] = self::getMonthName($month) . '/' . $year;
        }

        return $period;
    }

    /**
     * @param $month
     * @throws \Exception
     */
    protected static function validateMonth($month)
    {
        if (!is_numeric($month) || $month > 12 || $month < 1) {
            throw new \Exception("Month: {$month} is not valid.");
        }
    }

    /**
     * @param $year
     * @throws \Exception
     */
    protected static function validateYear($year)
    {
        if (!is_numeric($year) || strlen($year) !== 4) {
            throw new \Exception("Year: {$year} is not valid.");
        }
    }
}
