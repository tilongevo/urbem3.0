<?php

namespace Urbem\PatrimonialBundle\Controller\Frota;

use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Frota\Item;
use Urbem\CoreBundle\Model\Patrimonial\Frota\ItemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Frota\Item controller.
 *
 */
class ItemController extends ControllerCore\BaseController
{
    /**
     * Home Item Manutencao
     *
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();

        $catalogos = $em->getRepository('CoreBundle:Almoxarifado\Catalogo')->findAll();

        return $this->render(
            'PatrimonialBundle::Frota/Item/home.html.twig',
            array(
              'catalogos' => $catalogos,
            )
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaFrotaItemAction(Request $request)
    {
        $filtro = $request->get('q');
        $tipoManutencaoAutorizacao = $request->get('tipoManutencaoAutorizacao', false);

        $itemModel = new ItemModel($this->db);
        $queryBuilder = $itemModel->carregaFrotaItemQuery(strtolower($filtro));
        $itens = [];

        if ($tipoManutencaoAutorizacao) {
            $queryBuilder->andWhere('item.codTipo <> 1');
        }

        /** @var CatalogoItem $item */
        foreach ($queryBuilder->getQuery()->getResult() as $item) {
            $itens[] = [
                'id' => $itemModel->getObjectIdentifier($item),
                'label' => $item->__toString()
            ];
        }

        $items = [
            'items' => $itens
        ];
        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     */
    public function infoAction(Request $request)
    {
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');

        $codItem = $request->get('id');

        $entityManager = $this->getDoctrine()->getManager();

        /** @var Item $frotaItem */
        $frotaItem = $entityManager->find(Item::class, $codItem);

        if (is_null($frotaItem)) {
            return $response
                ->setStatusCode(403)
                ->setContent('Configuração não permite a exibição do saldo de estoque.')
                ->setCharset('UTF-8');
        }

        $catalogoItem = $frotaItem->getFkAlmoxarifadoCatalogoItem();

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $metadata = $entityManager->getClassMetadata(get_class($catalogoItem));
        $ignoredFields = $metadata->getAssociationNames();

        $normalizer->setCircularReferenceLimit(3);
        $normalizer->setIgnoredAttributes($ignoredFields);

        $serializer = new Serializer([$normalizer], [$encoder]);

        $catalogoItemData = $serializer->serialize($catalogoItem, 'json');

        return $response
            ->setContent($catalogoItemData)
            ->setStatusCode(200);
    }
}
