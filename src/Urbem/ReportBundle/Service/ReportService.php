<?php

namespace Urbem\ReportBundle\Service;

use GuzzleHttp;
use Symfony\Component\HttpFoundation;

class ReportService
{
    private $reportUrl;
    private $client;
    private $layoutDefaultReport;
    private $reportNameFile;
    private $connUrl;
    private $pathDefaultReport;

    public function __construct($reportUrl, $paramsDb = null)
    {
        $this->reportUrl = $reportUrl;
        $this->client = new GuzzleHttp\Client(['default' => true]);
        list($db,$dbHost,$dbPort) = $paramsDb;
        $this->connUrl = "jdbc:postgresql://{$dbHost}:{$dbPort}/{$db}";
        $this->pathDefaultReport = $this->getRootPath();
    }

    private function getRootPath()
    {
        $dir = explode("src/Urbem", __DIR__);
        return $dir[0] . "web";
    }

    /**
     * @return mixed
     */
    public function getLayoutDefaultReport()
    {
        return $this->layoutDefaultReport;
    }

    /**
     * @param mixed $layoutDefaultReport
     *
     * @return $this
     */
    public function setLayoutDefaultReport($layoutDefaultReport)
    {
        $this->layoutDefaultReport = $layoutDefaultReport;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReportNameFile()
    {
        return $this->reportNameFile;
    }

    /**
     * @param mixed $reportNameFile
     *
     * @return $this
     */
    public function setReportNameFile($reportNameFile)
    {
        $this->reportNameFile = $reportNameFile;

        return $this;
    }

    private function getDefaultParamsReport()
    {
        // Default dos relatórios
        return [
            'db_driver'   => 'org.postgresql.Driver',
            'db_conn_url' => $this->connUrl,
            '__format'    => 'pdf',
            '__locale'    => 'pt_BR',
            'filename'    => $this->getReportNameFile() . '.pdf',
            '__report'    => $this->pathDefaultReport . $this->getLayoutDefaultReport(),
            'term_user'   => 'Urbem Demo',
        ];
    }

    /**
     * Retorna o conteúdo do relatório
     *
     * @param  array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getReportContent($params = [])
    {
        return $this->client->get($this->reportUrl, [
            'auth'  => ['longevo', 'gevo4me', 'digest'],
            'query' => array_merge($this->getDefaultParamsReport(), $params)
        ]);
    }
}
