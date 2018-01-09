<?php

namespace Urbem\RecursosHumanosBundle\Controller\Ima;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Ima\ConfiguracaoBbContaModel;

class ExportarRemessaBBAdminController extends CRUDController
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detalheAction(Request $request)
    {
        $this->admin->setBreadCrumb();
        $hash = $request->query->get('id');

        $decoded = base64_decode($hash);
        $object = \GuzzleHttp\json_decode($decoded);

        $dadosExtra = [];
        foreach ($object->dadosExtra as $key => $dados) {
            $dados->nomeArquivo = $key;
            $dadosExtra[] = $dados;
        }

        unset($object->dadosExtra);
        $object->dadosExtra = $dadosExtra;
        $object->hash = $hash;

        return $this->render('RecursosHumanosBundle:Sonata/Ima/BB/CRUD:detalhe.html.twig', ['object' => $object]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function carregaContasConvenioAction(Request $request)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $mes = $request->get('mes');
        $ano = $request->get('ano');

        $mes = ($mes < 10) ? "0" . $mes : $mes;
        $dtCompetencia = $mes . "/" . $ano;
        $stFiltro = " AND to_char(dt_final, 'mm/yyyy') = '" . $dtCompetencia . "'";
        $rsPeriodoMovimentacao = $periodoMovimentacao->recuperaPeriodoMovimentacaoDaCompetencia($stFiltro);

        $stFiltro = " WHERE vigencia <= to_date('" . $rsPeriodoMovimentacao["dt_final"] . "','dd/mm/yyyy')";
        $stOrdem = " ORDER BY dt_vigencia DESC LIMIT 1";
        /** @var ConfiguracaoBbContaModel $configuracaoBBContaModel */
        $configuracaoBBContaModel = new ConfiguracaoBbContaModel($entityManager);
        $rsVigencia = $configuracaoBBContaModel->recuperaVigencias($stFiltro, $stOrdem);

        $rsContas = [];
        if (is_object($rsVigencia)) {
            $params['vigencia'] = $rsVigencia->vigencia;
            $rsContas = $configuracaoBBContaModel->recuperaRelacionamento($params);
        }

        return $this->render('@RecursosHumanos/Informacoes/ExportarPagamentos/BB/contas.html.twig', [
            'contas' => $rsContas,
        ]);
    }
}
