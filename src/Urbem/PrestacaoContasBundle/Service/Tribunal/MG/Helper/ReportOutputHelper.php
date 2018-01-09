<?php
namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Helper;

abstract class ReportOutputHelper
{
    const RECORD_TYPE_NAME = 'tipo_registro';

    /**
     * @var array
     */
    protected static $reportJobName = [
        '/TCE/MG/BI_TCEMG_ARQ_ACOMP_MENSAL_JOB',
        '/TCE/MG/BI_TCEMG_ARQ_FOLHA_PAGAMENTO_JOB',
        '/TCE/MG/BI_TCEMG_ARQ_BALANCETE_CONTABIL_JOB'
    ];

    /**
     * @var string
     */
    protected static $recordType = [
        self::RECORD_TYPE_NAME => '99'
    ];

    /**
     * @param $reportJobName
     * @param $content
     * @return string
     */
    public static function formatRecordType($reportJobName, $content)
    {
        if (in_array($reportJobName, self::$reportJobName)) {

            return self::hasContent($content);
        }

        return $content;
    }

    /**
     * @param $content
     * @return mixed
     */
    protected static function hasContent($content)
    {
        return (is_null($content) || !count($content)) || empty($content) ? self::$recordType : $content;
    }
}