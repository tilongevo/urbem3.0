<?php

namespace Urbem\PatrimonialBundle\Controller\Licitacao;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ParticipanteCertificacaoModel;

/**
 * Licitacao\Comissao Licitacao controller.
 *
 */
class ParticipanteCertificacaoController extends ControllerCore\BaseController
{
    /**
     * Home Comissao Licitacao
     *
     */
    public function perfilAction(Request $request)
    {
        $this->setBreadCrumb();

        $id = $request->query->get('id');
        list($numCertificado, $exercicio, $cgmFornecedor) = explode('~', $id);
        $entityManager = $this->getDoctrine()->getManager();

        $pCertificacao = $this->getDoctrine()
            ->getRepository('CoreBundle:Licitacao\ParticipanteCertificacao')
            ->findOneBy([
                'numCertificacao' => $numCertificado,
                'exercicio' => $exercicio,
                'cgmFornecedor' => $cgmFornecedor
            ]);

        $documentos = $this->getDoctrine()
            ->getRepository('CoreBundle:Licitacao\CertificacaoDocumentos')
            ->findBy([
                'numCertificacao' => $numCertificado,
                'exercicio' => $exercicio,
                'cgmFornecedor' => $cgmFornecedor
            ]);

        $penalidades = $this->getDoctrine()
            ->getRepository('CoreBundle:Licitacao\PenalidadesCertificacao')
            ->findBy([
                'numCertificacao' => $numCertificado,
                'exercicio' => $exercicio,
                'cgmFornecedor' => $cgmFornecedor
            ]);

        $participanteCertificacaoModel = new ParticipanteCertificacaoModel($entityManager);

        return $this->render('PatrimonialBundle::Licitacao/ParticipanteCertificacao/perfil.html.twig', [
            'objectKey'     => $id,
            'model'         => $participanteCertificacaoModel,
            'certificacao'  => $pCertificacao,
            'documentos'    => $documentos,
            'penalidades'   => $penalidades
        ]);
    }
}
