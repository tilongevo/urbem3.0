<?php
namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Almoxarifado\Requisicao;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoHomologadaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class RequisicaoAdminController
 */
class RequisicaoAdminController extends Controller
{
    private $layoutDefaultReport = '/bundles/report/gestaoPatrimonial/fontes/RPT/almoxarifado/report/design/relRequisicao.rptdesign';

    /**
     * Homologa requisicao
     *
     * @param Request $request
     * @return Response
     */
    public function homologarAction(Request $request)
    {
        $requisicaoObjectKey = $request->get('id');

        $entityManager = $this->getDoctrine()->getEntityManager();

        /** @var AbstractSonataAdmin $admin */
        $admin = $this->admin;

        try {
            /** @var Requisicao $requisicao */
            $requisicao = $admin->getModelManager()->find(Requisicao::class, $requisicaoObjectKey);

            /** @var Usuario $usuario */
            $usuario = $admin->getCurrentUser();

            (new RequisicaoHomologadaModel($entityManager))->homologaRequisicao($requisicao, $usuario);
        } catch (Exception $e) {
            throw new Exception($e);
        }

        $url = $this->generateUrl("{$admin->getBaseRouteName()}_show", ['id' => $requisicaoObjectKey]);
        return (new RedirectResponse($url))->send();
    }

    /**
     * Action que cancela/anula a ultima homologacao feita
     *
     * @param Request $request
     * @return Response
     */
    public function anularHomologacaoAction(Request $request)
    {
        $requisicaoObjectKey = $request->get('id');

        $entityManager = $this->getDoctrine()->getEntityManager();

        /** @var AbstractSonataAdmin $admin */
        $admin = $this->admin;

        try {
            /** @var Requisicao $requisicao */
            $requisicao = $admin->getModelManager()->find(Requisicao::class, $requisicaoObjectKey);

            /** @var Usuario $usuario */
            $usuario = $admin->getCurrentUser();

            $requisicaoHomologada = null;
            (new RequisicaoHomologadaModel($entityManager))->anulaHomologacaoRequisicao($requisicao);
        } catch (Exception $e) {
            throw new Exception($e);
        }

        $url = $this->generateUrl("{$admin->getBaseRouteName()}_show", ['id' => $requisicaoObjectKey]);
        return (new RedirectResponse($url))->send();
    }

    /**
     * @TODO Arrumar relatorios
     * @param Request $request
     */
    public function gerarRelatorioAction(Request $request)
    {

        // Para gerar a data por extenso no PHP e em português
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        $ids = $request->attributes->get('id');

        $id = explode('~', $ids);

        $params = array(
            'inCodGestao' => 3,
            'inCodModulo' => 29,
            'inCodRelatorio' => 2,
            'prCodRequisicao' => $id[0],
            'prCodAlmoxarifado' => $id[1],
            'stExercicio' => $id[2],
            'cod_acao' => 1399
        );

        $apiHttp = $this->container->getParameter("url_api_urbem");
        $reportHttp = $this->container->getParameter("url_api_report");
        $tokenApi = $this->container->getParameter("api_longevo_token");
        $paramsDb = [
            $this->container->getParameter('database_name'),
            $this->container->getParameter('database_host'),
            $this->container->getParameter('database_port')
        ];

        $apiService = new ApiService($reportHttp, $apiHttp, $tokenApi, $paramsDb);
        $apiService->setLayoutDefaultReport($this->layoutDefaultReport);
        $res = $apiService->getReportContent($params);
        exit();
    }
}
