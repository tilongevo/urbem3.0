<?php
/**
 * @file
 * Contains \Urbem\PatrimonialBundle\Controller\Almoxarifado\PerecivelAdminController
 */

namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\Perecivel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\EstoqueMaterialModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoPerecivelModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\PerecivelModel;

/**
 * Class PerecivelAdminController
 * @package Urbem\PatrimonialBundle\Controller\Almoxarifado
 */
class PerecivelAdminController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function searchAction(Request $request)
    {
        $mode = $request->get('mode');

        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getEntityManager();

        /** @var EstoqueMaterial $estoqueMaterial */
        $estoqueMaterial = (new EstoqueMaterialModel($entityManager))->findEstoqueMaterial(
            $request->get('catalogo_item'),
            $request->get('marca'),
            $request->get('centro_custo'),
            $request->get('almoxarifado')
        );

        $pereciveis = (new PerecivelModel($entityManager))
            ->findPerecivelByEstoqueMaterial($estoqueMaterial);

        /** @var Perecivel $perecivel */
        foreach ($pereciveis as $perecivel) {
            $perecivel->saldoLote = (new LancamentoPerecivelModel($entityManager))
                ->getSaldoLote($perecivel);
        }

        if ($mode == "table") {
            return $this->searchActionRenderTable($pereciveis);
        }

        return $this->searchActionRenderJson($pereciveis);
    }

    /**
     * @param ArrayCollection $pereciveis
     * @return Response
     */
    protected function searchActionRenderTable(ArrayCollection $pereciveis)
    {
        return $this->render('PatrimonialBundle::Sonata\Almoxarifado\SaidasDiversas\API\view__table_perecivel.html.twig', [
            'pereciveis' => $pereciveis
        ]);
    }

    /**
     * @param ArrayCollection $pereciveis
     * @return JsonResponse
     */
    protected function searchActionRenderJson(ArrayCollection $pereciveis)
    {
        $encoder = new JsonEncoder();

        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(['fkAlmoxarifadoEstoqueMaterial', 'fkAlmoxarifadoLancamentoPereciveis']);

        $serializer = new Serializer([$normalizer], [$encoder]);

        $normalizer->setCallbacks([
            'dtFabricacao' => function (\DateTime $dtFabricacao) {
                return $dtFabricacao->format(\DateTime::W3C);
            },
            'dtValidade' => function (\DateTime $dtValidade) {
                return $dtValidade->format(\DateTime::W3C);
            }
        ]);

        $pereciveisJson = $serializer->serialize($pereciveis, 'json');
        $pereciveisData = json_decode($pereciveisJson, true);

        foreach ($pereciveisData as $index => $perecivelData) {
            $pereciveisData[$index]['saldoLote'] = $pereciveis[$index]->saldoLote;
        }

        return new JsonResponse($pereciveisData);
    }
}
