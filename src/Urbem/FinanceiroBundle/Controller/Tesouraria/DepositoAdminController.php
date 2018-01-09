<?php

namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Tesouraria\Transferencia;
use Urbem\CoreBundle\Entity\Tesouraria\VwTransferenciaView;

/**
 * Class DepositoAdminController
 * @package Urbem\FinanceiroBundle\Controller\Tesouraria
 */
class DepositoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function detalheAction(Request $request)
    {
        $id = $this->admin->getIdParameter();

        $this->admin->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));
        $container = $this->container;
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        try {
            $id = $request->get($this->admin->getIdParameter());
            list($codLote, $codEntidade, $exercicio) = explode('~', $id);

            $transferecia = $em->getRepository(Transferencia::class)->findOneBy(array('codLote' => $codLote, 'codEntidade' => $codEntidade, 'exercicio' => $exercicio));
            $transfereciaView = $em->getRepository(VwTransferenciaView::class)->findOneBy(array('codLote' => $codLote, 'codEntidade' => $codEntidade, 'exercicio' => $exercicio));

            $codEstruturalContaCredito = $transferecia->getFkContabilidadePlanoAnalitica()->getFkContabilidadePlanoConta()->getCodEstrutural();
            $codEstruturalContaDebito = $transferecia->getFkContabilidadePlanoAnalitica1()->getFkContabilidadePlanoConta()->getCodEstrutural();

            $transfereciaView->setNomContaCredito($codEstruturalContaCredito.' - '.$transfereciaView->getNomContaCredito());
            $transfereciaView->setNomContaDebito($codEstruturalContaDebito.' - '.$transfereciaView->getNomContaDebito());
            $transfereciaView->setDtBoletim(date('d/m/Y', strtotime($transfereciaView->getDtBoletim())));
            $transfereciaView->setDtTransferencia(date('d/m/Y', strtotime($transfereciaView->getDtTransferencia())));

            return $this->render('FinanceiroBundle::Tesouraria/OutrasOperacoes/Deposito/base_show.html.twig', array('object' => $transfereciaView,));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.recursosHumanos.registrosEventoFerias.erro'));
            throw $e;
        }
    }
}
