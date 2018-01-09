<?php

namespace Urbem\PatrimonialBundle\Controller\Patrimonio;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Patrimonio\Bem;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\BemModel;

class BemController extends BaseController
{
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Patrimonial/Bem/home.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function consultaBemAction(Request $request)
    {
        $codBem = $request->attributes->get('id');

        $bem = $this->getDoctrine()
            ->getRepository('CoreBundle:Patrimonio\Bem')
            ->findOneByCodBem($codBem);
        $bemInfo = [
            'codBem' => $bem->getCodBem(),
            'descricao' => $bem->getDescricao(),
            'numPlaca' => $bem->getNumPlaca(),
            'natureza' => $bem->getFkPatrimonioEspecie()->getFkPatrimonioGrupo()->getFkPatrimonioNatureza()->getNomNatureza(),
            'grupo' => $bem->getFkPatrimonioEspecie()->getFkPatrimonioGrupo()->getNomGrupo(),
            'especie' => $bem->getFkPatrimonioEspecie()->getNomEspecie(),
        ];

        $response = new Response();
        $response->setContent(json_encode($bemInfo));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function carregaBemAction(Request $request)
    {
        $numcgm = $request->get('q');

        $searchSql = is_numeric($numcgm) ?
            sprintf("cod_bem = %s", $numcgm) :
            sprintf("(lower(descricao) LIKE '%%%s%%')", strtolower($request->get('q')));

        $params = [$searchSql];
        $bemModel = new BemModel($this->db);
        $result = $bemModel->getBemDisponiveisJson($params);
        $bens = [];

        foreach ($result as $credor) {
            array_push($bens, ['id' => $credor->cod_bem, 'label' => $credor->cod_bem . " - " . $credor->descricao]);
        }
        $items = [
            'items' => $bens
        ];
        return new JsonResponse($items);
    }


    public function bensPorLocalAction(Request $request)
    {
        $codLocal = $request->get('id');
        $qb = $this->db->getRepository(Bem::class)->createQueryBuilder('b');
        $bens = $qb->select('b')
            ->join('b.fkPatrimonioHistoricoBens', 'h')
            ->join('h.fkOrganogramaLocal', 'l')
            ->where('l.codLocal = :codLocal')
            ->setParameter('codLocal', $codLocal)
            ->getQuery()
            ->getResult()
        ;

        $items = [];
        /** @var Bem $bem */
        foreach ($bens as $bem) {
            $items[] = [
                'codBem' => $bem->getCodBem(),
                'bem' => (string) $bem,
            ];
        }

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaBemProprioAction(Request $request)
    {

        $codBem = $request->get('id');
        $bemModel = new BemModel($this->db);
        $result = $bemModel->carregaBemProprio($codBem);
        $bens = [];

        foreach ($result as $credor) {
            $bens['responsavel'] = $credor->num_responsavel . ' - ' . $credor->nom_responsavel;
            $bens['dtInicio'] = $credor->dt_inicio;
        }
        return new JsonResponse($bens);
    }
}
