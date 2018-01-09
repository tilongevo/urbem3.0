<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Economico\BaixaNaturezaJuridica;
use Urbem\CoreBundle\Model\Economico\BaixaNaturezaJuridicaModel;
use Urbem\CoreBundle\Model\Economico\NaturezaJuridicaModel;

/**
 * Class NaturezaJuridicaController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class NaturezaJuridicaController extends BaseController
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

            $naturezaJuridica = (new NaturezaJuridicaModel($em))
                ->getNaturezaJuridicaByCodNatureza($dataForm['codNatureza']);

            $baixarNatureza = new BaixaNaturezaJuridica();
            $baixarNatureza->setMotivo($dataForm['natureza_juridica']['motivo']);
            $baixarNatureza->setFkEconomicoNaturezaJuridica($naturezaJuridica);

            $baixaNaturezaJuridicaModel = new BaixaNaturezaJuridicaModel($em);
            $baixaNaturezaJuridicaModel->save($baixarNatureza);

            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.economico.baixaNaturezaJuridica.validate.sucesso'));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.economico.baixaNaturezaJuridica.validate.erro'));
        }

        return (new RedirectResponse("/tributario/cadastro-economico/natureza-juridica/list"))->send();
    }
}
