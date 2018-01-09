<?php

namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoDecimoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoFeriasModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoRescisaoModel;

class ContratoController extends ControllerCore\BaseController
{
    public function carregaContratoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $filtro = $request->get('q');

        $contratoList = $em->getRepository(Contrato::class)->getContrato($filtro);

        $contratos = array();

        foreach ($contratoList as $contrato) {
            array_push(
                $contratos,
                array(
                    'id' => $contrato->cod_contrato,
                    'label' => $contrato->registro . " - " . $contrato->numcgm . " - " . $contrato->nom_cgm
                )
            );
        }

        $items = array(
            'items' => $contratos
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function carregaContratoAllAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $filtro = $request->get('q');

        $contratoList = $em->getRepository(Contrato::class)->getContratoAll($filtro);

        $contratos = array();

        foreach ($contratoList as $contrato) {
            array_push(
                $contratos,
                array(
                    'id' => $contrato->cod_contrato,
                    'label' => $contrato->registro . " - " . $contrato->numcgm . " - " . $contrato->nom_cgm
                )
            );
        }

        $items = array(
            'items' => $contratos
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaContratoFeriasAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var RegistroEventoFeriasModel $registroEventoFeriasModel */
        $registroEventoFeriasModel = new RegistroEventoFeriasModel($em);

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $exercicio = $this->getExercicio();

        $anoMesCompetencia = $periodoFinal->getDtFinal()->format('Ym');

        $filtro = $request->get('q');

        $contratoList = $registroEventoFeriasModel->recuperaContratosDoFiltro($exercicio, '', $anoMesCompetencia, $filtro);

        $contratos = array();

        foreach ($contratoList as $contrato) {
            array_push(
                $contratos,
                array(
                    'id' => $contrato['cod_contrato'],
                    'label' => $contrato['registro'] . " - " . $contrato['numcgm'] . " - " . $contrato['nom_cgm']
                )
            );
        }

        $items = array(
            'items' => $contratos
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaContratoDecimoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var RegistroEventoDecimoModel $registroEventoDecimoModel */
        $registroEventoDecimoModel = new RegistroEventoDecimoModel($em);

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $exercicio = $this->getExercicio();

        $anoMesCompetencia = $periodoFinal->getDtFinal()->format('Ym');

        $filtro = $request->get('q');

        $contratoList = $registroEventoDecimoModel->recuperaContratosDoFiltro($exercicio, '', true, $filtro);

        $contratos = array();

        foreach ($contratoList as $contrato) {
            array_push(
                $contratos,
                array(
                    'id' => $contrato['cod_contrato'],
                    'label' => $contrato['registro'] . " - " . $contrato['numcgm'] . " - " . $contrato['nom_cgm']
                )
            );
        }

        $items = array(
            'items' => $contratos
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaContratoRescisaoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var RegistroEventoRescisaoModel $registroEventoRescisaoModel */
        $registroEventoRescisaoModel = new RegistroEventoRescisaoModel($em);

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $exercicio = $this->getExercicio();

        $anoMesCompetencia = $periodoFinal->getDtFinal()->format('Ym');

        $filtro = $request->get('q');

        $contratoList = $registroEventoRescisaoModel->recuperaContratosDoFiltro($exercicio, '', $anoMesCompetencia, $filtro);

        if (empty($contratoList)) {
            $contratoList = $registroEventoRescisaoModel->recuperaRescisaoContratoPensionista($exercicio, '', $anoMesCompetencia, $filtro);
        }
        $contratos = array();

        foreach ($contratoList as $contrato) {
            array_push(
                $contratos,
                array(
                    'id' => $contrato['cod_contrato'],
                    'label' => $contrato['registro'] . " - " . $contrato['numcgm'] . " - " . $contrato['nom_cgm']
                )
            );
        }

        $items = array(
            'items' => $contratos
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaContratoRescindidoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $filtro = $request->get('q');

        $contratoList = $em->getRepository(Contrato::class)
                            ->getContratoRescindido($filtro);

        $contratos = array();

        foreach ($contratoList as $contrato) {
            array_push(
                $contratos,
                array(
                    'id' => $contrato->cod_contrato,
                    'label' => $contrato->registro . " - " . $contrato->numcgm . " - " . $contrato->nom_cgm
                )
            );
        }

        $items = array(
            'items' => $contratos
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaContratoNaoRescindidoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $filtro = $request->get('q');

        $contratoList = $em->getRepository(Contrato::class)
            ->getContratoNotRescindido($filtro);

        $contratos = array();

        foreach ($contratoList as $contrato) {
            array_push(
                $contratos,
                array(
                    'id' => $contrato->cod_contrato,
                    'label' => $contrato->registro . " - " . $contrato->numcgm . " - " . $contrato->nom_cgm
                )
            );
        }

        $items = array(
            'items' => $contratos
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaContratoServidorPeriodoAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $filtro = $request->get('q');
        $codPeriodoMovimentacao = $request->get('codPeriodoMovimentacao');

        $contratoList = $em->getRepository(Contrato::class)
            ->getContratoServidorPeriodo($filtro, $codPeriodoMovimentacao);

        $contratos = array();

        foreach ($contratoList as $contrato) {
            array_push(
                $contratos,
                array(
                    'id' => $codPeriodoMovimentacao.'~'.$contrato->cod_contrato,
                    'label' => $contrato->registro . " - " . $contrato->numcgm . " - " . $contrato->nom_cgm
                )
            );
        }

        $items = array(
            'items' => $contratos
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function carregaContratoAposentadoriaAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $filtro = $request->get('q');

        $contratoList = $em->getRepository(Contrato::class)
            ->carregaContratoAposentadoria($filtro);

        $contratos = array();

        foreach ($contratoList as $contrato) {
            array_push(
                $contratos,
                array(
                    'id' => $contrato['cod_contrato'],
                    'label' => $contrato['registro'] . " - " . $contrato['numcgm'] . " - " . $contrato['nom_cgm']
                )
            );
        }

        $items = array(
            'items' => $contratos
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function carregaContratoCgmPensionistaAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $filtro = $request->get('q');

        $contratoList = $em->getRepository(Contrato::class)
            ->carregaContratoCgmPensionista($filtro);

        $contratos = array();

        foreach ($contratoList as $contrato) {
            array_push(
                $contratos,
                array(
                    'id' => $contrato['registro'] . " - " . $contrato['numcgm'] . " - " . $contrato['nom_cgm'],
                    'label' => $contrato['registro'] . " - " . $contrato['numcgm'] . " - " . $contrato['nom_cgm']
                )
            );
        }

        $items = array(
            'items' => $contratos
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function carregaContratoServidorPensionistaAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $filtro = $request->get('q');

        $contratoList = $em->getRepository(Contrato::class)
            ->getContratoServidorPensionista($filtro);

        $contratos = array();

        foreach ($contratoList as $contrato) {
            array_push(
                $contratos,
                array(
                    'id' => $contrato['cod_contrato'],
                    'label' => $contrato['registro'] . " - " . $contrato['numcgm'] . " - " . $contrato['nom_cgm']
                )
            );
        }

        $items = array(
            'items' => $contratos
        );

        return new JsonResponse($items);
    }
}
