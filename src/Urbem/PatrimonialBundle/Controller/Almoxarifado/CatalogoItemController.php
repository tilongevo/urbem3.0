<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 11/08/16
 * Time: 14:21
 */

namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Urbem\CoreBundle\Controller as ControllerCore;

use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Compras\MapaItem;
use Urbem\CoreBundle\Entity\Compras\MapaSolicitacao;
use Urbem\CoreBundle\Entity\Compras\Solicitacao;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;

/**
 * Class CatalogoItemController
 * @package Urbem\PatrimonialBundle\Controller\Almoxarifado
 */
class CatalogoItemController extends ControllerCore\BaseController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function getItemsByMapaComprasAction(Request $request)
    {
        $id = $request->get('cod_mapa');
        if (false !== strpos($id, '~')) {
            $id = explode('~', $id);
            $codMapa = $id[1];
        };

        $exercicio = $request->get('exercicio');
        $exercicio = (isset($exercicio)) ? $request->get('exercicio') : $id[0];

        $mode = is_null($request->get('mode')) ? 'json' : 'table';

        $response = new Response();

        if (is_null($id)) {
            return $response;
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine();

        /** @var Compras\Mapa $mapas */
        $mapas = $entityManager
            ->getRepository(Compras\Mapa::class)
            ->findOneBy([
                'exercicio' => $exercicio,
                'codMapa'   => $codMapa,
            ]);

        if (count($mapas) == 0
            || is_null($mapas)
        ) {
            return $response;
        }

        /** @var MapaSolicitacao $mapaSolicitacao */
        $mapaSolicitacao = $mapas->getFkComprasMapaSolicitacoes()->last();
        $mapas = $mapaSolicitacao->getFkComprasMapaItens();

        $mapaItens = $entityManager->getRepository(MapaItem::class)
            ->montaRecuperaItemSolicitacaoMapa(
                $mapaSolicitacao->getCodSolicitacao(),
                $mapaSolicitacao->getCodEntidade(),
                $mapaSolicitacao->getExercicioSolicitacao(),
                null,
                null,
                $mapaSolicitacao->getCodMapa(),
                $mapaSolicitacao->getExercicio()
            );

        if ($mode == 'table') {
            return $this->render('@Patrimonial/Almoxarifado/Catalogo/items.html.twig', [
                'mapaItems' => $mapaItens,
            ]);
        }

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $serializer = new Serializer([$normalizer], [$encoder]);
        $mapas = $serializer->serialize($mapas, 'json');

        $response->setContent($mapas);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getItemsByClassificacaoAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getDoctrine()->getEntityManager();

        $codClassificacao = $request->get('cod_classificacao');

        $response = new Response();

        if (is_null($codClassificacao)) {
            return $response;
        }

        /**
         * @var Almoxarifado\CatalogoClassificacao $classificacao
         */
        $classificacao = $entityManager
            ->getRepository(Almoxarifado\CatalogoClassificacao::class)
            ->find($codClassificacao);

        $catalogoItemModel = new CatalogoItemModel($entityManager);
        $itens = $catalogoItemModel->getCatalogoItemByClassificacao($classificacao);

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $serializer = new Serializer([$normalizer], [$encoder]);
        $catalogoItens = $serializer->serialize($itens, 'json');

        $response->setContent($catalogoItens);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
