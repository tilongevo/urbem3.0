<?php

namespace Urbem\CoreBundle\Controller;

use Doctrine\ORM;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\SwCgmModel;

/**
 * Class SwCgmAdminController
 * @package Urbem\CoreBundle\Controller
 */
class SwCgmAdminController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteAction(Request $request)
    {
        $q = $request->get('q');

        $cgms = [];

        /** @var ORM\EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getEntityManager();

        $swCgmModel = new SwCgmModel($entityManager);
        $results = $swCgmModel->findLike(['nomCgm'], $q);

        /** @var SwCgm $swCgm */
        foreach ($results as $swCgm) {
            $id = $swCgmModel->getObjectIdentifier($swCgm);
            $label = $swCgm->getNomCgm();

            array_push($cgms, ['id' => $id, 'label' => $label]);
        }

        $items = [
            'items' => $cgms
        ];

        return new JsonResponse($items);
    }
}
