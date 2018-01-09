<?php

namespace Urbem\RecursosHumanosBundle\Controller\Ima;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Folhapagamento\TipoFolha;

class ExportarArquivoIpersAdminController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function downloadAction(Request $request)
    {
        $hash = $request->attributes->get('id');

        $decoded = base64_decode($hash);
        $object = \GuzzleHttp\json_decode($decoded);

        $content = file_get_contents('/tmp/' . $object->fileName);

        return new Response(
            $content,
            200,
            array(
                'Content-type' => 'text/plain; charset=ISO-8859-15',
                'Content-disposition' => sprintf('attachment; filename=' . $object->fileName)
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function detalheAction(Request $request)
    {
        $this->admin->setBreadCrumb();
        $hash = $request->query->get('id');

        $decoded = base64_decode($hash);
        $object = \GuzzleHttp\json_decode($decoded);

        switch ($object->tipoEmissao) {
            case 1:
                $strEmissao = "Manutenção";
                break;
            case 2:
                $strEmissao = "Acerto de Manutenção";
                break;
            case 3:
                $strEmissao = "Inclusão";
                break;
            case 4:
                $strEmissao = "Acerto de Inclusão";
                break;
        }

        switch ($object->inCodConfiguracao) {
            case 0:
                $tipoFolha = "Complementar";
                break;
            case 1:
                $tipoFolha = "Salário";
                break;
            case 2:
                $tipoFolha = "Férias";
                break;
            case 3:
                $tipoFolha = "13 Salário";
                break;
            case 4:
                $tipoFolha = "Rescisão";
                break;
        }

        $object->strFolha = $tipoFolha;
        $object->strEmissao = $strEmissao;
        $object->totalServidores = isset($object->quant_registros) ? $object->quant_registros : 99;
        $object->hash = $hash;

        return $this->render('RecursosHumanosBundle:Sonata/Ima/Ipers/CRUD:detalhe.html.twig', ['object' => $object]);
    }

    /**
     * @param Request $request
     */
    public function reportAction(Request $request)
    {
        $layout = '/bundles/report/gestaoRH/fontes/RPT/IMA/report/design/conveniadosIpers.rptdesign';
        $fileName = 'conveniadosIpers';
        $hash = $request->attributes->get('id');


        $decoded = base64_decode($hash);
        $object = \GuzzleHttp\json_decode($decoded);

        switch ($object->inCodTipoEmissao) {
            case 1:
                $strEmissao = "Manutenção";
                break;
            case 2:
                $strEmissao = "Acerto de Manutenção";
                break;
            case 3:
                $strEmissao = "Inclusão";
                break;
            case 4:
                $strEmissao = "Acerto de Inclusão";
                break;
        }

        switch ($object->inCodConfiguracao) {
            case 0:
                $tipoFolha = "Complementar";
                break;
            case 1:
                $tipoFolha = "Salário";
                break;
            case 2:
                $tipoFolha = "Férias";
                break;
            case 3:
                $tipoFolha = "13 Salário";
                break;
            case 4:
                $tipoFolha = "Rescisão";
                break;
        }

        $params = [
            'term_user' => 'suporte',
            'cod_acao' => 2238,
            'exercicio' => (string) $object->exercicio,
            'inCodGestao' => Gestao::GESTAO_RECURSOS_HUMANOS,
            'inCodModulo' => Modulo::MODULO_IMA,
            'inCodRelatorio' => Relatorio::RECURSOS_HUMANOS_IMA_MANUTENCAO_CONVENIADO_IPERS,
            'entidade' => (string) $object->entidade,
            'stEntidade' => '',
            'stExercicio' => (string) $object->exercicio,
            'inCodPeriodoMovimentacao' => (string) $object->inCodPeriodoMovimentacao,
            'inCodFolha' => (string) $object->inCodConfiguracao,
            'inCodComplementar' => (string) $object->inCodComplementar,
            'stDesdobramento' => '',
            'stSituacaoCadastro' => (string) $object->stSituacaoCadastro,
            'stTipoFiltro' => (string) $object->stTipoFiltro,
            'stValoresFiltro' => (string) $object->stValoresFiltro,
            'inCodTipoEmissao' => (string) $object->inCodTipoEmissao,
            'stCompetenciaTitulo' => (string) $object->stCompetenciaTitulo,
            'stCodigoOrgao' => (string) $object->stCodigoOrgao,
            'inValorPerContPatronal' => (string) $object->inValorPerContPatronal,
            'stDescTipoEmissao' => (string) $strEmissao,
            'boAgruparFolhas' => ($object->boAgruparFolhas == 1) ? 'false' : 'true',
        ];

        $apiService = $this->admin->getReportService();
        $apiService->setReportNameFile($fileName);
        $apiService->setLayoutDefaultReport($layout);
        $res = $apiService->getReportContent($params);

        $this->admin->parseContentToPdf(
            $res->getBody()->getContents(),
            $fileName
        );
    }
}
