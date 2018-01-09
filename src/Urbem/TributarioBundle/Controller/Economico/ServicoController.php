<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Economico\NivelServico;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Model\Economico\AliquotaServicoModel;

/**
 * Class ServicoController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class ServicoController extends BaseController
{
    /**
     * @param Request $request
     */
    public function salvarAction(Request $request)
    {
        $container = $this->container;
        $em = $this->getDoctrine()->getManager();

        try {
            $dataForm = $request->request->all();

            $valor = $dataForm['servico']['valor'];
            $dtVigencia = $dataForm['servico']['dtVigencia'];
            $dtVigencia = $this->formatDtVigencia($dtVigencia);
            $aliquotaModel = new AliquotaServicoModel($em);
            $aliquota = $aliquotaModel->getAliquota($dataForm['codServico']);
            $aliquotaModel->verifica($aliquota, $valor, $dtVigencia, $dataForm['codServico']);

            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.economico.servico.validate.aliquotaAlterada'));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.economico.servico.validate.aliquotaErroAlteracao'));
        }
        return (new RedirectResponse("/tributario/cadastro-economico/servico/list"))->send();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getMascaraCodEstruturalAction(Request $request)
    {
        $nivelServicoField = $request->query->get('nivel');
        list($codNivel, $nomNivel) = explode('-', $nivelServicoField);
        $em = $this->getDoctrine()->getManager();
        $nivelServico = $em->getRepository(NivelServico::class)
            ->findOneByCodNivel(trim($codNivel));
        $mascara = null;
        if ($nivelServico) {
            $mascara = $nivelServico->getMascara();
        }
        $items = [
            'items' => $mascara
        ];

        return new JsonResponse($items);
    }

    /**
     * @param $dtVigencia
     * @return bool|\DateTime
     */
    public function formatDtVigencia($dtVigencia)
    {
        $dtVigenciaExp = explode('/', $dtVigencia);
        $dtVigencia = $dtVigenciaExp[2].'-'.$dtVigenciaExp[1].'-'.$dtVigenciaExp[0];
        $date = \DateTime::createFromFormat('Y-m-d', $dtVigencia);

        return $date;
    }
}
