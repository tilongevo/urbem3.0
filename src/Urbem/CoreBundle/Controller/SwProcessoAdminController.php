<?php

namespace Urbem\CoreBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\SwProcessoModel;

class SwProcessoAdminController extends CRUDController
{
    public function autocompleteAction(Request $request)
    {
        $parameter = $request->get('q');
        $pageSize = 10;
        $page = 1;

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $processoModel = new SwProcessoModel($em);
        $limit = $pageSize;
        $offset = $page * $limit;
        $processos = $processoModel->getProcessosAdministrativos($parameter, $limit, $offset);

        $json = [
            'items' => []
        ];

        foreach ($processos as $value) {
            /** @var SwProcesso $processo */
            $processo = $value['swProcesso'];
            /** @var SwCgm $cgm */
            $cgm = $value['swCgm'];

            $json['items'][] = [
                'id' => $this->get('objectkey.helper')->generate($processo),
                'label' => "$processo | {$cgm->getNomCgm()}",
            ];
        }
        return new JsonResponse($json);
    }
}
