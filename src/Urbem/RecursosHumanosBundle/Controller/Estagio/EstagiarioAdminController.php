<?php

namespace Urbem\RecursosHumanosBundle\Controller\Estagio;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;

class EstagiarioAdminController extends CRUDController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response|RedirectResponse
     */
    public function listAction()
    {
        /** @var EntityManager $entityManager */
        $em = $this->getDoctrine()->getManager();

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();

        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $container = $this->container;

        $situacao = $periodoFinal->getFkFolhapagamentoPeriodoMovimentacaoSituacoes()->last()->getSituacao();

        if ($situacao != 'a') {
            $message = $this->trans('recursosHumanos.folhaSituacao.errors.periodoMovimentacaoNaoAberto', [], 'validators');
            $container->get('session')->getFlashBag()->add('error', $message);

            return new RedirectResponse(
                $this->redirectToRoute('recursos_humanos')
            );
        }

        return parent::listAction();
    }
}
