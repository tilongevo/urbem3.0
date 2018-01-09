<?php

namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra;

class ArrecadacaoExtraEstornosAdminController extends CRUDController
{
    const TIPO_RECIBO = 'R';

    public function lerCodigoDeBarrasAction(Request $request)
    {
        $codBarras = $request->request->get('codBarras');

        $codReciboExtra = (int) substr($codBarras, -12, 5);
        $exercicio = substr($codBarras, -7, 4);
        $codEntidade = (int) substr($codBarras, -3, 2);

        $em = $this->getDoctrine()->getEntityManager();

        $reciboExtra = $em->getRepository(ReciboExtra::class)
            ->findOneBy(
                array(
                    'codReciboExtra' => $codReciboExtra,
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'tipoRecibo' => self::TIPO_RECIBO
                )
            );

        $data = array();
        if ($reciboExtra) {
            $transferencia = $reciboExtra->getFkTesourariaReciboExtraTransferencias()->last()->getFkTesourariaTransferencia();

            $data = array(
                'codReciboExtra' => $codReciboExtra,
                'codEntidade' => $codEntidade,
                'codPlanoCredito' => $transferencia->getCodPlanoCredito(),
                'codPlanoContaCredito' => (string) $transferencia->getFkContabilidadePlanoAnalitica(),
                'codPlanoDebito' => $transferencia->getCodPlanoDebito(),
                'codPlanoContaDebito' => (string) $transferencia->getFkContabilidadePlanoAnalitica1(),
                'dtBoletim' => $transferencia->getFkTesourariaBoletim()->getDtBoletim()->format('d/m/Y'),
                'codBoletim' => $transferencia->getCodBoletim()
            );
        }

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
