<?php

namespace Urbem\RecursosHumanosBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\RecursosHumanosBundle\Controller\FolhaPagamento\CalculoSalarioAdminController;

class ConsultaRegistrosEventoAdminController extends CalculoSalarioAdminController
{
    protected $layoutDefaultReport = '/bundles/report/gestaoRH/fontes/RPT/folhaPagamento/report/design/consultarRegistroEvento.rptdesign';

    /**
     * @param Request $request
     */
    public function geraRelatorioConsultaRegistrosEventoAction(Request $request)
    {
        $codPeriodoMovimentacao = $this->getRequest()->get('codPeriodoMovimentacao');
        $codContratos = $this->getRequest()->get('codContratos');
        $fileName = $this->admin->parseNameFile('consultaFichaFinanceira');
        $params = [
            'entidade' => 2,
            'stTipoFiltro' => 'contrato',
            'exercicio' => $this->admin->getExercicio(),
            'stCodigos' => $codContratos,
            'inCodGestao' => 4,
            'inCodModulo' => ConfiguracaoModel::MODULO_RH_FOLHAPAGAMENTO,
            'inCodRelatorio' => 30,
            'stEntidade' => '',
            'inCodPeriodoMovimentacao' => $codPeriodoMovimentacao,
            'inCodComplementar' => '',
            'inCodConfiguracao' => ''
        ];

        $apiService = $this->admin->getReportService();
        $apiService->setReportNameFile($fileName);
        $apiService->setLayoutDefaultReport($this->layoutDefaultReport);
        $res = $apiService->getReportContent($params);

        $this->admin->parseContentToPdf(
            $res->getBody()->getContents(),
            $fileName
        );
    }
}
