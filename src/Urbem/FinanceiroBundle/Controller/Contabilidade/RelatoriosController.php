<?php

namespace Urbem\FinanceiroBundle\Controller\Contabilidade;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Contabilidade\PlanoContaModel;
use Urbem\CoreBundle\Model\Administracao\AssinaturaModel;

class RelatoriosController extends BaseController
{
    /**
     * Home
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Contabilidade/Relatorios/home.html.twig');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getPlanoContasCodEstruturalAction(Request $request)
    {
        $like = " (pc.cod_estrutural like '1.1.1.%') AND ";

        $em = $this->getDoctrine()->getManager();
        $planoContaModel = new PlanoContaModel($em);
        $nomeConta = $request->query->get('q');

        $result = $planoContaModel->getPlanoContaByExercicioAndCodReduzidoAndCodEstrutural($this->getExercicio(), $nomeConta, $like);

        $planoContas = array();

        foreach ($result as $r) {
            array_push($planoContas, ['id' => $r['cod_estrutural'], 'label' => $r['cod_estrutural']. " - " . $r['nom_conta']]);
        }

        $items = [
            'items' => $planoContas
        ];

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getPlanoContasCodReduzidoAction(Request $request)
    {
        $like = " (pc.cod_estrutural like '1.1.2.%' OR
                pc.cod_estrutural like '1.1.3.%' OR
                pc.cod_estrutural like '1.2.1.%' OR
                pc.cod_estrutural like '2.1.1.%' OR
                pc.cod_estrutural like '2.1.2.%' OR
                pc.cod_estrutural like '2.1.9.%' OR
                pc.cod_estrutural like '2.2.1.%' OR
                pc.cod_estrutural like '2.2.2.%' OR
                pc.cod_estrutural like '3.5.%'   OR
                pc.cod_estrutural like '4.5.%' ) AND ";

        $em = $this->getDoctrine()->getManager();
        $planoContaModel = new PlanoContaModel($em);
        $nomeConta = $request->query->get('q');

        $result = $planoContaModel->getPlanoContaByExercicioAndCodReduzidoAndCodEstrutural($this->getExercicio(), $nomeConta, $like);

        $planoContas = array();

        foreach ($result as $r) {
            array_push($planoContas, ['id' => $r['cod_plano'], 'label' => $r['cod_estrutural']. " - " . $r['nom_conta']]);
        }

        $items = [
            'items' => $planoContas
        ];

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function getListaAssinaturaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $assinaturaModel = new AssinaturaModel($em);

        $entidades = $request->get('entidades');

        $result = $assinaturaModel->getListaAssinatura($this->getExercicio(), $entidades);

        return new JsonResponse($result);

        $assinaturas = array();

        foreach ($result as $r) {
            array_push($assinaturas, ['id' => $r->cod_entidade.'|'.$r->numcgm.'|'.$r->timestamp,
                'label' => $r->cod_entidade. " - " .$r->nom_cgm. " - " . $r->cargo]);
        }

        $items = [
            'items' => $assinaturas
        ];

        return new JsonResponse($items);
    }
}
