<?php

namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorCasoCausaModel;

class ContratoServidorCasoCausaAdminController extends CRUDController
{
    public function casoCausaAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $codContrato = $request->request->get('codContrato');
        $codCausaRescisao = $request->request->get('codCausaRescisao');
        $dtRescisao = $request->request->get('dtRescisao');

        $casoCausa = (new ContratoServidorCasoCausaModel($entityManager))
        ->getCasoCausa($codContrato, $codCausaRescisao, $dtRescisao, $this->admin->getExercicio());

        return new JsonResponse($casoCausa);
    }
}
