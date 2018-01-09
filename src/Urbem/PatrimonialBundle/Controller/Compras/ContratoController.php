<?php

namespace Urbem\PatrimonialBundle\Controller\Compras;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ContratoModel;

/**
 * Compras\Contrato controller.
 *
 */
class ContratoController extends ControllerCore\BaseController
{
    /**
     * Home Contrato
     *
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Compras/Contrato/home.html.twig');
    }

    /**
     * @param Request $request
     */
    public function perfilAction(Request $request)
    {
        $this->setBreadCrumb();

        $id = $request->query->get('id');
        list($exercicio, $codEntidade, $numContrato) = explode('~', $id);

        $entityManager = $this->getDoctrine()->getManager();

        $contratoModel = new ContratoModel($entityManager);
        /** @var Licitacao\Contrato $contrato */
        $contrato = $contratoModel->getOneContrato($exercicio, $codEntidade, $numContrato);

        $documento = $contrato->getFkLicitacaoContratoDocumentos();

        $arquivos = $contrato->getFkLicitacaoContratoArquivos();

        $publicacoes = $contrato->getFkLicitacaoPublicacaoContratos();

        $aditivos = $contrato->getFkLicitacaoContratoAditivos();

        return $this->render('PatrimonialBundle::Compras/Contrato/perfil.html.twig', [
            'contrato' => $contrato,
            'documentos' => $documento,
            'arquivos' => $arquivos,
            'publicacoes' => $publicacoes,
            'aditivos' => $aditivos,
        ]);
    }
}
