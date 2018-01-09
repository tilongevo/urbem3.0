<?php

namespace Urbem\PatrimonialBundle\Controller\Licitacao;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Licitacao\PublicacaoEdital;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\VeiculosPublicidadeModel;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\BemModel;

class VeiculosPublicidadeController extends ControllerCore\BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaVeiculoPublicidadeAction(Request $request)
    {
        $numcgm = $request->get('q');
        list($numEdital, $exercicio) = explode('~', $request->get('id'));

        /** @var PublicacaoEdital $veiculos */
        $publicacaoEdital = $this->getDoctrine()
            ->getRepository(PublicacaoEdital::class)->findBy(
                [
                    'numEdital' => $numEdital,
                    'exercicio' => $exercicio
                ]
            );
        $searchNotInSql = null;
        $ids = [];
        if (!empty($publicacaoEdital)) {
            foreach ($publicacaoEdital as $publicacao) {
                $ids[] = $publicacao->getNumcgm();
            }

            $searchNotInSql = sprintf('cgm.numcgm NOT IN (%s)', implode(",", $ids));
        }

        $searchSql = is_numeric($numcgm) ?
            sprintf("vp.numcgm = %s", $numcgm) :
            sprintf("(lower(nom_cgm) LIKE '%%%s%%')", strtolower($request->get('q')));

        $params = (is_null($searchNotInSql)) ? [$searchSql] : [$searchSql, $searchNotInSql];
        $veiculosPublicidadeModel = new VeiculosPublicidadeModel($this->db);
        $result = $veiculosPublicidadeModel->carregaVeiculosPublicidadeJson($params);
        $bens = [];
        foreach ($result as $credor) {
            array_push($bens, ['id' => $credor->numcgm, 'label' => $credor->cod_tipo_veiculos_publicidade . " - " . $credor->descricao . "|" . $credor->numcgm . " - " . $credor->nom_cgm]);
        }
        $items = [
            'items' => $bens
        ];

        return new JsonResponse($items);
    }
}
