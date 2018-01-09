<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Report;

use Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\AbstractReport;

/**
 * Class Report
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Report
 */
class Report extends AbstractReport
{
    protected $uf = "RS";

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
}