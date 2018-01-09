<?php

namespace Urbem\FinanceiroBundle\Controller\Orcamento;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Orcamento\ReceitaModel;

class ReceitaController extends BaseController
{
    public function getReceitaByExercicioAndCodReceitaAction(Request $request)
    {
        $codReceita = trim($request->query->get('receita'));
        $exercicio = $request->query->get('exercicio');

        $receita = $this->getDoctrine()
            ->getRepository('CoreBundle:Orcamento\Receita')
            ->getReceitaByExercicioAndCodReceita($exercicio, $codReceita);

        $receita = array_shift($receita);

        if (is_null($receita)) {
            $receita['cod_receita'] = '';
            $receita['mascara_classificacao'] = '';
            $receita['descricao'] = '';
            $receita['nom_recurso'] = '';
        }

        $entidade = $this->getDoctrine()
            ->getRepository('CoreBundle:Orcamento\Entidade')
            ->findOneBy([
                'exercicio' => $receita['exercicio'],
                'codEntidade' => $receita['cod_entidade']
            ]);

        $receita['nome_entidade'] = '';
        if (!empty($entidade)) {
            $receita['nome_entidade'] = $entidade->getFkSwCgm()->getNomCgm();
        }

        $response = new Response();
        $response->setContent(json_encode($receita));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getReceitaAction(Request $request)
    {
        $model = new ReceitaModel($this->getDoctrine()->getEntityManager());
        $filter = $model->getCodEstruturalOrDescricao($request->get('q'));
        $exercicio = $this->getExercicio();
        $receita = $this->getDoctrine()
            ->getRepository('CoreBundle:Orcamento\Receita')
            ->getReceitaByExercicioAndDescricao($exercicio, $filter);
        $list = [];
        foreach ($receita as $v) {
            array_push($list, ['id' => $v['cod_conta'], 'label' => $v['cod_estrutural'] .' - '. $v['descricao'] ]);
        }
        return new JsonResponse(['items' => $list]);
    }
}
