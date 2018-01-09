<?php

namespace Urbem\FinanceiroBundle\Controller\Empenho;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho;
use Urbem\CoreBundle\Model;

class PreEmpenhoAdminController extends Controller
{
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/empenho/report/design/notaAutorizacaoEmpenho.rptdesign';

    public function getDotacaoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $current_user = $this->get('security.token_storage')->getToken()->getUser();
        $codDespesaChoices = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getDotacaoOrcamentaria(
            $request->request->get('exercicio'),
            $current_user->getFkSwCgm()->getNumcgm(),
            $request->request->get('codEntidade')
        );
        return new JsonResponse($codDespesaChoices);
    }

    public function getDtAutorizacaoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $dtAutorizacao = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getDtAutorizacao($request->request->get('codEntidade'), $request->request->get('exercicio'));

        return new JsonResponse($dtAutorizacao);
    }

    public function getDesdobramentoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $desdobramentoChoices = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getDesdobramento($request->request->get('codDespesa'), $request->request->get('exercicio'));

        return new JsonResponse($desdobramentoChoices);
    }

    public function getSaldoDotacaoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $locale = $this->container->getParameter('locale');

        $saldoDotacaos = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getSaldoDotacaoDataAtual(
            $request->request->get('stExercicio'),
            $request->request->get('inCodDespesa'),
            $request->request->get('stDataEmpenho'),
            $request->request->get('inEntidade'),
            $locale
        );

        return new JsonResponse($saldoDotacaos);
    }

    public function getOrgaoOrcamentarioAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $current_user = $this->get('security.token_storage')->getToken()->getUser();

        $orgaoOrcamentarioChoices = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getOrgaoOrcamentario(
            $request->request->get('exercicio'),
            $request->request->get('codEntidade'),
            $current_user->getFkSwCgm()->getNumcgm()
        );

        return new JsonResponse($orgaoOrcamentarioChoices);
    }

    public function getOrgaoOrcamentarioDespesaAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $current_user = $this->get('security.token_storage')->getToken()->getUser();

        $orgaoOrcamentarioChoices = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getOrgaoOrcamentarioDespesa(
            $request->request->get('exercicio'),
            $request->request->get('codEntidade'),
            $current_user->getFkSwCgm()->getNumcgm(),
            $request->request->get('codDespesa')
        );

        return new JsonResponse($orgaoOrcamentarioChoices);
    }

    public function getUnidadeOrcamentariaAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $unidadeOrcamentarioChoices = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getUnidadeOrcamentaria(
            $request->request->get('codEntidade'),
            $request->request->get('numOrgao')
        );

        return new JsonResponse($unidadeOrcamentarioChoices);
    }

    public function getContrapartidaAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $unidadeOrcamentarioChoices = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getContrapartida(
            $request->request->get('exercicio'),
            $request->request->get('numcgm')
        );

        return new JsonResponse($unidadeOrcamentarioChoices);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getUnidadeMedidaItemAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $unidadeMedida = (new Model\Empenho\PreEmpenhoModel($em))->getUnidadeMedidaByItem($request->request->get('codItem'));
        return new JsonResponse($unidadeMedida);
    }

    public function getUnidadeMedidaAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $model = new Model\Empenho\PreEmpenhoModel($entityManager);
        $unidadeMedida = $model->getUnidadeMedida($request->request->get('codItem'));

        return new JsonResponse($unidadeMedida);
    }

    public function getOrgaoUnidadeAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $codDespesa = $entityManager->getRepository("CoreBundle:Orcamento\Despesa")
        ->findOneByCodDespesa($request->request->get('codDespesa'));
        
        $numUnidade = $entityManager->getRepository("CoreBundle:Orcamento\Unidade")
        ->findOneByNumUnidade($codDespesa->getNumUnidade());

        $numOrgao = $entityManager->getRepository("CoreBundle:Orcamento\Orgao")
        ->findOneByNumOrgao($codDespesa->getNumOrgao());
        
        $despesa = array();
        $despesa['numUnidade'] = $numUnidade->getNumUnidade() . " - " . $numUnidade->getNomUnidade();
        $despesa['numOrgao'] = $numOrgao->getNumOrgao() . " - " . $numOrgao->getNomOrgao();
        
        return new JsonResponse($despesa);
    }

    /**
     * @param Request $request
     */
    public function gerarNotaAction(Request $request)
    {
        list($exercicio, $codPreEmpenho) = explode('~', $request->get('id'));

        /** @var AutorizacaoEmpenho $autorizacaoEmpenho */
        $autorizacaoEmpenho = $this->getDoctrine()->getRepository(AutorizacaoEmpenho::class)->findOneBy([
            'exercicio' => $exercicio,
            'codPreEmpenho' => $codPreEmpenho
        ]);

        list($exercicioAnulada, $codPreEmpenhoAnulada) = explode('~', $request->get('codPreEmpenhoAnulada'));

        /** @var AutorizacaoEmpenho $autorizacaoEmpenhoAnulada */
        $autorizacaoEmpenhoAnulada = $this->getDoctrine()->getRepository(AutorizacaoEmpenho::class)->findOneBy([
            'exercicio' => $exercicioAnulada,
            'codPreEmpenho' => $codPreEmpenhoAnulada
        ]);

        $fileName = $this->admin->parseNameFile('NotaAutorizacao');

        $params = [
            'inCodGestao' => Gestao::GESTAO_FINANCEIRA,
            'inCodModulo' => Modulo::MODULO_EMPENHO,
            'inCodRelatorio' => Relatorio::FINANCEIRO_EMPENHO_NOTA_AUTORIZACAO,
            'cod_entidade' => (string) $autorizacaoEmpenho->getCodEntidade(),
            'exercicio' => $autorizacaoEmpenho->getExercicio(),
            'cod_pre_empenho' => (string) $autorizacaoEmpenho->getCodPreEmpenho(),
            'cod_autorizacao' => (string) $autorizacaoEmpenho->getCodAutorizacao(),
            'cod_autorizacao_anulada' => (string) $autorizacaoEmpenhoAnulada->getCodAutorizacao(),
            'cod_pre_empenho_anulada' => (string) $autorizacaoEmpenhoAnulada->getCodPreEmpenho(),
            'dt_cabecalho' => $autorizacaoEmpenho->getDtAutorizacao()->format('d/m/Y'),
            'hora_cabecalho' => $autorizacaoEmpenho->getDtAutorizacao()->format('H:i'),
            'tipo_relatorio' => 'autorizacao'
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
