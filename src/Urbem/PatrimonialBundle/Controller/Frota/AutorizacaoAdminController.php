<?php
namespace Urbem\PatrimonialBundle\Controller\Frota;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;

class AutorizacaoAdminController extends CRUDController
{
    protected $layoutDefaultReport = '/bundles/report/gestaoPatrimonial/fontes/RPT/frota/report/design/autorizacaoAbastecimento.rptdesign';

    /**
     * @param Request $request
     */
    public function geraRelatorioAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());

        $boVias = $request->get('quantVias');
        $exercicio = $request->get('exercicio');
        $object = $this->admin->getObject($id);
        $fileName = $this->admin->parseNameFile("reemitir-autorizacao");

        $params = [
            'term_user' => $this->admin->getCurrentUser()->getUserName(),
            'cod_acao' => '1426',
            'exercicio' => $exercicio,
            'inCodGestao' => Gestao::GESTAO_PATRIMONIAL,
            'inCodModulo' => Modulo::MODULO_FROTA ,
            'inCodRelatorio' => Relatorio::RECURSOS_HMANOS_PESSOAL_CARGOS,
            'stExercicio' => $exercicio,
            'boVias' => $boVias,
            'inCodAutorizacao' => '2'
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
