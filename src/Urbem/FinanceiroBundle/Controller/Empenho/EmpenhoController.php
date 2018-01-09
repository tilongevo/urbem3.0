<?php

namespace Urbem\FinanceiroBundle\Controller\Empenho;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Empenho\EmpenhoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\OrdemModel;

/**
 * Class EmpenhoController
 * @package Urbem\FinanceiroBundle\Controller\Empenho
 */
class EmpenhoController extends BaseController
{
    /**
     * Home
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();

        return $this->render('FinanceiroBundle::Empenho/Empenho/home.html.twig');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaEmpenhoEmpenhoAction(Request $request)
    {
        $filtro = $request->get('q');
        $em = $this->getDoctrine()->getManager();

        $searchSql =
            sprintf(
                "(empenho.cod_empenho || '/' || empenho.exercicio) LIKE '%%%s%%'",
                strtolower($filtro)
            );
        $limit = " LIMIT 100 OFFSET 0";
        $params = [$searchSql];
        $empenhoModel = new OrdemModel($em);
        $result = $empenhoModel->getEmpenhosAtivos($params, $limit);
        $empenhos = [];

        foreach ($result as $empenho) {
            array_push(
                $empenhos,
                [
                    'id' => $empenho->cod_empenho.'~'.$empenho->exercicio.'~'.$empenho->cod_entidade,
                    'label' => $empenho->cod_empenho . "/" . $empenho->exercicio
                ]
            );
        }
        $items = [
            'items' => $empenhos
        ];
        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function buscaEmpenhoEmpenhoAtivosAction(Request $request)
    {
        $filtro = $request->get('q');
        $em = $this->getDoctrine()->getManager();

        $searchSql =
            sprintf(
                "AND (cod_empenho || '/' || exercicio_empenho) LIKE '%%%s%%'",
                strtolower($filtro)
            );
        $limit = " LIMIT 100 OFFSET 0";
        $params = $searchSql;
        $empenhoModel = new OrdemModel($em);
        $result = $empenhoModel->getEmpenhosAtivos(false, $params, $limit);
        $empenhos = [];

        foreach ($result as $empenho) {
            array_push(
                $empenhos,
                [
                    'id' => $empenho['cod_empenho'].'~'.$empenho['exercicio_empenho'].'~'.$empenho['cod_entidade'],
                    'label' => $empenho['cod_empenho']. "/" . $empenho['exercicio_empenho']
                ]
            );
        }
        $items = [
            'items' => $empenhos
        ];
        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaEmpenhoEmpenhoAtivosAction(Request $request)
    {
        $filtro = $request->get('q');
        $entidade = $request->get('entidade');
        list($exercicio, $codEntidade) = explode('~', $entidade);

        $em = $this->getDoctrine()->getManager();

        $searchSql =
            sprintf(
                "AND cod_empenho::VARCHAR LIKE '%%%s%%' AND exercicio_empenho = %s::VARCHAR AND cod_entidade = %d",
                strtolower($filtro),
                $exercicio,
                $codEntidade
            );
        $limit = " LIMIT 100 OFFSET 0";
        $params = $searchSql;
        $empenhoModel = new OrdemModel($em);
        $result = $empenhoModel->getEmpenhosAtivos(false, $params, $limit);
        $empenhos = [];

        foreach ($result as $empenho) {
            array_push(
                $empenhos,
                [
                    'id' => $empenho['cod_empenho'].'~'.$empenho['exercicio_empenho'].'~'.$empenho['cod_entidade'],
                    'label' => $empenho['cod_empenho']
                ]
            );
        }
        $items = [
            'items' => $empenhos
        ];
        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaEmpenhoPorExercicioAction(Request $request)
    {
        $codEmpenho = $request->get('q');
        $exercicio = $request->get('exercicio');
        $em = $this->getDoctrine()->getManager();

        $params = array(
            sprintf("(cod_empenho || '/' || exercicio) LIKE '%%%s%%'", strtolower($codEmpenho)),
            sprintf("exercicio = '%s'", $exercicio)
        );

        $limit = " LIMIT 100 OFFSET 0";

        $empenhoModel = new EmpenhoModel($em);
        $result = $empenhoModel->carregaEmpenhoEmpenho($params, $limit);
        $empenhos = [];

        foreach ($result as $empenho) {
            array_push(
                $empenhos,
                [
                    'id' => $empenho->cod_empenho.'~'.$empenho->exercicio.'~'.$empenho->cod_entidade,
                    'label' => $empenho->cod_empenho. "/" . $empenho->exercicio
                ]
            );
        }

        $items = [
            'items' => $empenhos
        ];

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function consultaEmpenhoAction(Request $request)
    {
        $codEntidade = $request->query->get('entidade');
        list($codEmpenho, $exercicio) = explode('/', $request->query->get('empenho'));

        $em = $this->getDoctrine()->getManager();

        $params = array(
            sprintf("cod_empenho = '%d'", strtolower($codEmpenho)),
            sprintf("exercicio = '%s'", $exercicio),
            sprintf("cod_entidade = '%d'", $codEntidade)
        );

        $limit = " LIMIT 1";

        $empenhoModel = new EmpenhoModel($em);
        $empenho = $empenhoModel->carregaEmpenhoEmpenho($params, $limit);

        $isValid = count($empenho) > 0 ? true : false;

        return new JsonResponse(array('isValid' => $isValid));
    }
}
