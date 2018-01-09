<?php

namespace Urbem\PrestacaoContasBundle\Service\TribunalStrategy;

use Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Helper\StringHelper;
use Urbem\PrestacaoContasBundle\Helper\TribunaisHelper;

abstract class AbstractReport
{
    protected $uf = "NI";

    protected $filename = null;

    /**
     * @param $path
     * @param FilaRelatorio $filaRelatorio
     * @return string path where the file was created
     */
    public function build($path, FilaRelatorio $filaRelatorio)
    {
        $this->addContentReportToFileCompacted($filaRelatorio, $path);

        return $this->filename;
    }

    protected function sanitizePath($path)
    {
        $path = rtrim($path, '/\\');
        $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path) . DIRECTORY_SEPARATOR;

        if (false === is_dir($path)) {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    /**
     * @param \Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio $filaRelatorio
     * @param $uf
     * @return mixed|string
     */
    protected function getReportName(FilaRelatorio $filaRelatorio, $uf)
    {
        $tribunal = TribunaisHelper::getContentJsonReportListByUF(strtoupper($uf));
        $reportDetail = TribunaisHelper::getContentReportJsonGroupByHash($tribunal, $filaRelatorio->getRelatorio());

        $reportName = empty($reportDetail) ? 'RelatoriosTribunalDeContas' : $reportDetail['label'];

        return sprintf("TCE_%s_%s", $uf, StringHelper::removeSpecialCharacter(
            StringHelper::removeAllSpace($reportName),
            $inputToUpper = false,
            $responseToLower = false
        ));
    }

    /**
     * @param \Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio $filaRelatorio
     */
    protected function setNormalizedNameFile(FilaRelatorio $filaRelatorio)
    {
        $this->filename = sprintf(
            '%s_%s.zip',
            $this->getReportName($filaRelatorio, $this->uf),
            $filaRelatorio->getDataCriacao()->format('d_m_Y_h_i_s')
        );
    }

    /**
     * @param \Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio $filaRelatorio
     * @param $filename
     */
    protected function addContentReportToFileCompacted(FilaRelatorio $filaRelatorio, $path, $filename = null)
    {
        $path = $this->sanitizePath($path);

        if (empty($filename)) {
            $this->setNormalizedNameFile($filaRelatorio);
            $filename = $this->filename;
        }

        $zip = new \ZipArchive();
        $zip->open($path . $filename, \ZipArchive::CREATE);

        foreach ($filaRelatorio->getResposta() as $name => $data) {
            $zip->addFromString($name, implode("\r\n", true === is_array($data) ? $data : []));
        }

        $zip->close();
    }
}