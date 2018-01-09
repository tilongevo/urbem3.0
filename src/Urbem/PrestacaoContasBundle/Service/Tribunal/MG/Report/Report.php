<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Report;

use Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\AbstractReport;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Helper\ReportOutputHelper;

/**
 * Class Report
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Report
 */
class Report extends AbstractReport
{
    protected $uf = "MG";

    /**
     * @param $path
     * @param \Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio $filaRelatorio
     * @return string
     */
    public function build($path, FilaRelatorio $filaRelatorio)
    {
        $this->addContentReportToFileCompacted($filaRelatorio, $path);

        return $this->filename;
    }

    protected function addContentReportToFileCompacted(FilaRelatorio $filaRelatorio, $path, $filename = null)
    {
        $path = $this->sanitizePath($path);

        if (empty($filename)) {
            $this->setNormalizedNameFile($filaRelatorio);
            $filename = $this->filename;
        }

        $zip = new \ZipArchive();
        $zip->open($path . $filename, \ZipArchive::CREATE);

        $reportJobName = $filaRelatorio->getNome();

        foreach ($filaRelatorio->getResposta() as $name => $data) {
            $content = ReportOutputHelper::formatRecordType($reportJobName, $data);
            $zip->addFromString($name, implode("\r\n", true === is_array($content) ? $content : []));
        }

        $zip->close();
    }
}