<?php

namespace Urbem\CoreBundle\Controller\Filter;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Model\SwAssuntoModel;

/**
 * Class SwAssuntoAdminController
 * @package Urbem\CoreBundle\Controller
 */
class SwAssuntoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchClassificacaoAction(Request $request)
    {
        $codClassificacao = $request->get('cod_classificacao');

        $entityManager = $this->getDoctrine()->getEntityManager();
        $assuntos = (new SwAssuntoModel($entityManager))->findByCodClassificacao($codClassificacao);

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $entityMetadata = $entityManager->getClassMetadata(SwAssunto::class);
        $ignoredFields = $entityMetadata->getAssociationNames();

        $normalizer->setIgnoredAttributes($ignoredFields);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $data = $serializer->serialize($assuntos, 'json');

        return new JsonResponse($data);
    }
}
