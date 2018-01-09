<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 11/08/16
 * Time: 09:31
 */

namespace Urbem\PatrimonialBundle\Controller\Compras;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Urbem\CoreBundle\Controller as ControllerCore;

use Urbem\CoreBundle\Entity\Compras;

class MapaComprasController extends ControllerCore\BaseController
{
    public function getObjetoByMapaComprasAction(Request $request)
    {
        $entityManager = $this->getDoctrine();

        $codMapa = $request->get('cod_mapa');
        if (false !== strpos($codMapa, '~')) {
            $codMapa = explode('~', $codMapa);
            $codMapa = $codMapa[1];
        };

        $exercicio = $request->get('exercicio');
        $exercicio = (isset($exercicio)) ? $request->get('exercicio') : $this->getExercicio() ;

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (is_null($codMapa)) {
            return $response;
        }

        /** @var  $mapa Compras\Mapa */
        $mapa = $entityManager
            ->getRepository(Compras\Mapa::class)
            ->find(
                [
                    'exercicio' => $exercicio,
                    'codMapa' => $codMapa
                ]
            );

        if (is_null($mapa)) {
            return $response;
        }

        $objeto = $mapa->getFkComprasObjeto()->getCodObjeto();

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $serializer = new Serializer([$normalizer], [$encoder]);
        $objeto = $serializer->serialize($objeto, 'json');

        $response->setContent($objeto);

        return $response;
    }

    public function perfilAction(Request $request)
    {
        $this->setBreadCrumb();

        $id = $request->query->get('id');
        list($exercicio, $codMapa) = explode('~', $id);

        $em = $this->getDoctrine()->getManager();

        $mapa = $this->getDoctrine()
            ->getRepository('CoreBundle:Compras\Mapa')
            ->findOneBy(
                [
                    'exercicio' => $exercicio,
                    'codMapa' => $codMapa
                ]
            );

        $solicitacoes = $em->getRepository('CoreBundle:Compras\Mapa')
            ->montaRecuperaMapaSolicitacoes($codMapa, $exercicio);

        $mAnulacao = $this->getDoctrine()
            ->getRepository('CoreBundle:Compras\MapaSolicitacaoAnulacao')
            ->findOneBy(
                [
                    'exercicio' => $exercicio,
                    'codMapa' => $codMapa
                ]
            );

        $solicitacoes = (count($solicitacoes) > 0) ? $solicitacoes : null;

        if (count($solicitacoes) > 0) {
            $items = $em->getRepository('CoreBundle:Compras\MapaItem')->montaRecuperaIncluirSolicitacaoMapa($solicitacoes[0]->cod_solicitacao, $solicitacoes[0]->cod_entidade, $solicitacoes[0]->exercicio);
        } else {
            $items = null;
        }

        return $this->render('PatrimonialBundle::Compras/Mapa/perfil.html.twig', [
            'mapa' => $mapa,
            'solicitacoes' => $solicitacoes,
            'itens' => $items,
            'anulacao' => $mAnulacao
        ]);
    }
}
