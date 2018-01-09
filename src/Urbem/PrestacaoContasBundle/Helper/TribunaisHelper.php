<?php

namespace Urbem\PrestacaoContasBundle\Helper;
use Urbem\CoreBundle\Helper\ArrayHelper;

/**
 * Class TribunaisHelper
 * @package Urbem\PrestacaoContasBundle\Helper
 */
class TribunaisHelper
{
    /**
     * @param $uf
     * @return array
     */
    public static function getContentJsonReportListByUF($uf)
    {
        $uf = strtoupper($uf);
        $fileItems = __DIR__ . "/../Service/Tribunal/{$uf}/formulario.json";

        if (false === file_exists($fileItems)) {
            return [];
        }

        $tribunais = json_decode(file_get_contents($fileItems), true);

        return array_key_exists($uf, $tribunais) ? $tribunais[$uf] : [];
    }

    /**
     * @param array $tribunal
     * @param $reportHash
     * @return mixed|null
     */
    public static function getContentReportJsonGroupByHash(array $tribunal, $reportHash)
    {
        $key = null;
        $report = null;
        array_walk($tribunal, function ($v, $k) use(&$key, &$report, $reportHash){
            if (array_key_exists('itens', $v) && !empty($report = ArrayHelper::searchBy("reportHash", $reportHash, $v['itens']))) {
                $key = $k;
            }
        });

        return $report;
    }
}
