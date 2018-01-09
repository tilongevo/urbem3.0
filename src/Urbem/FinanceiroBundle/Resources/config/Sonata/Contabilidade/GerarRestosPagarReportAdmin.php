<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class GerarRestosPagarReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_encerramento_gerar_restos_a_pagar';
    protected $baseRoutePattern = 'financeiro/contabilidade/encerramento/gerar-restos-a-pagar';
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/contabilidade/report/design/relatorioInsuficiencia.rptdesign';

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $fileName = $this->parseNameFile("relatorioInsuficiencia");
        $params = [
            'exercicio' => $this->getExercicio(),
            'cod_acao' => '1375',
            'inCodGestao' => 2,
            'inCodModulo' => 9,
            'inCodRelatorio' => 4,
            'cod_entidade' => $this->getRequest()->query->get('cod_entidade'),
            'data_final' => '31/12/' . $this->getExercicio(),
            'term_user' => $this->getCurrentUser()->getUsername()
        ];

        $apiService = $this->getReportService();
        $apiService->setReportNameFile($fileName);
        $apiService->setLayoutDefaultReport($this->layoutDefaultReport);
        $res = $apiService->getReportContent($params);
        $this->parseContentToPdf(
            $res->getBody()->getContents(),
            $fileName
        );
    }
}
