<?php

namespace Urbem\PortalServicosBundle\Tests\Service\Tribunal\MG\Helper;

use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Helper\ReportOutputHelper;
use \PHPUnit_Framework_Constraint_IsType as PHPUnitType;

/**
 * Class ReportOutputHelperTest
 * @package Urbem\PortalServicosBundle\Tests\Service\Tribunal\MG\Helper
 */
class ReportOutputHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider responseWithOutputRecordTypeProvider
     */
    public function testFormatRecordTypeWithNullReturnRecordType($data, $reportName, $expected)
    {
        $this->assertInternalType($expected, ReportOutputHelper::formatRecordType($reportName, $data));
    }

    /**
     * @dataProvider responseWithOutputWithoutRecordTypeProvider
     */
    public function testFormatRecordTypeWithNullReturnNullIfNotContent($data, $reportName, $expected)
    {
        $this->assertInternalType($expected, ReportOutputHelper::formatRecordType($reportName, $data));
    }

    /**
     * @return array
     */
    public function responseWithOutputRecordTypeProvider()
    {
        return [
            [null, '/TCE/MG/BI_TCEMG_ARQ_BALANCETE_CONTABIL_JOB', PHPUnitType::TYPE_ARRAY],
            ['1234567', '/TCE/MG/BI_TCEMG_ARQ_BALANCETE_CONTABIL_JOB', PHPUnitType::TYPE_STRING],
            [['1234567'], '/TCE/MG/BI_TCEMG_ARQ_BALANCETE_CONTABIL_JOB', PHPUnitType::TYPE_ARRAY],
            [new \stdClass(), '/TCE/MG/BI_TCEMG_ARQ_BALANCETE_CONTABIL_JOB', PHPUnitType::TYPE_OBJECT],
            [[], '/TCE/MG/BI_TCEMG_ARQ_BALANCETE_CONTABIL_JOB', PHPUnitType::TYPE_ARRAY],
            ['', '/TCE/MG/BI_TCEMG_ARQ_BALANCETE_CONTABIL_JOB', PHPUnitType::TYPE_ARRAY],
            [100, '/TCE/MG/BI_TCEMG_ARQ_BALANCETE_CONTABIL_JOB', PHPUnitType::TYPE_INT],
            [true, '/TCE/MG/BI_TCEMG_ARQ_BALANCETE_CONTABIL_JOB', PHPUnitType::TYPE_BOOL],
            [false, '/TCE/MG/BI_TCEMG_ARQ_BALANCETE_CONTABIL_JOB', PHPUnitType::TYPE_ARRAY],
        ];
    }

    /**
     * @return array
     */
    public function responseWithOutputWithoutRecordTypeProvider()
    {
        return [
            [null, '/NOT_JOB_NAME_IN_HELPER', PHPUnitType::TYPE_NULL],
            ['1234567', '/NOT_JOB_NAME_IN_HELPER', PHPUnitType::TYPE_STRING],
            [['1234567'], '/NOT_JOB_NAME_IN_HELPER', PHPUnitType::TYPE_ARRAY],
            [new \stdClass(), '/NOT_JOB_NAME_IN_HELPER', PHPUnitType::TYPE_OBJECT],
            [[], '/NOT_JOB_NAME_IN_HELPER', PHPUnitType::TYPE_ARRAY],
            ['', '/NOT_JOB_NAME_IN_HELPER', PHPUnitType::TYPE_STRING],
            [100, '/NOT_JOB_NAME_IN_HELPER', PHPUnitType::TYPE_INT],
            [true, '/NOT_JOB_NAME_IN_HELPER', PHPUnitType::TYPE_BOOL],
            [false, '/NOT_JOB_NAME_IN_HELPER', PHPUnitType::TYPE_BOOL],
        ];
    }
}

