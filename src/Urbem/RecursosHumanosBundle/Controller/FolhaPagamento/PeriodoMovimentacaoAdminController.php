<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\DecimoEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\Fgts;
use Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculo;
use Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoComplementar;
use Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoDecimo;
use Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoFerias;
use Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoRescisao;
use Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia;
use Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoPeriodoModel;
use Urbem\CoreBundle\Model\Folhapagamento\TabelaIrrfModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;

class PeriodoMovimentacaoAdminController extends CRUDController
{
    /**
     * @param PeriodoMovimentacao $periodo
     *
     * @return null|string
     */
    public function validaPeriodoMovimentacao(PeriodoMovimentacao $periodo)
    {
        $mensagem = null;
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var PeriodoMovimentacaoModel $periodoMovimentacaoModel */
        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($em);

        $folhaSituacao = $periodoMovimentacaoModel->recuperaUltimaFolhaSituacao();

        if ((!empty($folhaSituacao)) && $folhaSituacao['situacao'] == 'a') {
            $mensagem = $this->trans('recursosHumanos.periodoMovimentacao.errors.folhaSalarioAberta', [], 'validators');
        }

        /** @var FolhaComplementarModel $complementarModel */
        $complementarModel = new FolhaComplementarModel($em);
        $folhaComplementar = $complementarModel->consultaFolhaComplementar($periodo->getCodPeriodoMovimentacao());

        if ($folhaComplementar) {
            $mensagem = $this->trans('recursosHumanos.periodoMovimentacao.errors.folhaComplementarAberta', [], 'validators');
        }

        /** @var LogErroCalculo $folhaLogErroCalculo */
        $folhaLogErroCalculo = $em->getRepository(LogErroCalculo::class)->findAll();
        if ($folhaLogErroCalculo) {
            $mensagem = $this->trans('recursosHumanos.periodoMovimentacao.errors.logGenerica', ['%generica%' => 'salário'], 'validators');
        }

        /** @var LogErroCalculoComplementar $folhaLogErroCalculoComplementar */
        $folhaLogErroCalculoComplementar = $em->getRepository(LogErroCalculoComplementar::class)->findAll();
        if ($folhaLogErroCalculoComplementar) {
            $mensagem = $this->trans('recursosHumanos.periodoMovimentacao.errors.logGenerica', ['%generica%' => 'complementar'], 'validators');
        }

        /** @var LogErroCalculoFerias $folhaLogErroCalculoFerias */
        $folhaLogErroCalculoFerias = $em->getRepository(LogErroCalculoFerias::class)->findAll();
        if ($folhaLogErroCalculoFerias) {
            $mensagem = $this->trans('recursosHumanos.periodoMovimentacao.errors.logGenerica', ['%generica%' => 'férias'], 'validators');
        }

        /** @var LogErroCalculoDecimo $folhaLogErroCalculoDecimo */
        $folhaLogErroCalculoDecimo = $em->getRepository(LogErroCalculoDecimo::class)->findAll();
        if ($folhaLogErroCalculoDecimo) {
            $mensagem = $this->trans('recursosHumanos.periodoMovimentacao.errors.logGenerica', ['%generica%' => 'décimo'], 'validators');
        }

        /** @var LogErroCalculoRescisao $folhaLogErroCalculoRescisao */
        $folhaLogErroCalculoRescisao = $em->getRepository(LogErroCalculoRescisao::class)->findAll();
        if ($folhaLogErroCalculoRescisao) {
            $mensagem = $this->trans('recursosHumanos.periodoMovimentacao.errors.logGenerica', ['%generica%' => 'rescisão'], 'validators');
        }

        return $mensagem;
    }

    /**
     * @param EntityManager $em
     *
     * @return null|string
     */
    public function validaCalculoSalario(EntityManager $em)
    {
        $message = null;

        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        //VERIFICA SE EXISTE CÁLCULO DE PENSÃO ALIMENTÍCIA CONFIGURADA
        /** @var PensaoEvento $pensaoEvento */
        $pensaoEvento = $em->getRepository(PensaoEvento::class)->findAll();

        if (empty($pensaoEvento)) {
            $message = 'Configuração do Cálculo de Pensão Alimentícia inexistente!';
        }

        //VERIFICA SE EXISTE CÁLCULO DE FÉRIAS
        /** @var FeriasEvento $feriasEvento */
        $feriasEvento = $em->getRepository(FeriasEvento::class)->findAll();

        if (empty($feriasEvento)) {
            $message = 'Configuração do Cálculo de Férias inexistente!';
        }

        //VERIFICA SE EXISTE CÁLCULO DE 13º
        /** @var DecimoEvento $decimoEvento */
        $decimoEvento = $em->getRepository(DecimoEvento::class)->findAll();

        if (empty($decimoEvento)) {
            $message = 'Configuração Cálculo de 13º Salário inexistente!';
        }

        //VERIFICA SE O CÁLCULO PREVIDÊNCIA ESTÁ EM VIGÊNCIA
        /** @var PrevidenciaPrevidencia $previdenciaPrevidencia */
        $previdenciaPrevidencia = $em->getRepository(PrevidenciaPrevidencia::class)->findAll();
        $previdenciaPrevidencia = end($previdenciaPrevidencia);

        if ($previdenciaPrevidencia->getVigencia() > $periodoFinal->getDtFinal() || $previdenciaPrevidencia->getVigencia() == "" || is_null($previdenciaPrevidencia)) {
            $message = "Configuração da Previdência inexistente ou não está em vigor para competência!";
        }

        //VERIFICA SE O CÁLCULO PREVIDÊNCIA ESTÁ EM VIGÊNCIA
        /** @var SalarioFamilia $salarioFamilia */
        $salarioFamilia = $em->getRepository(SalarioFamilia::class)->findAll();
        $salarioFamilia = end($salarioFamilia);

        if ($salarioFamilia->getVigencia() > $periodoFinal->getDtFinal() || $salarioFamilia->getVigencia() == "" || is_null($salarioFamilia)) {
            $message = "Configuração do Salário Família inexistente ou não está em vigor para competência!";
        }

        //VERIFICA SE O CÁLCULO IRRF ESTÁ EM VIGOR
        /** @var TabelaIrrfModel $tabelaIrrfModel */
        $tabelaIrrfModel = new TabelaIrrfModel($em);
        $tabelaIrrf = $tabelaIrrfModel->montaRecuperaUltimaVigencia();

        if ($tabelaIrrf[0]->vigencia > $periodoFinal->getDtFinal() || $tabelaIrrf[0]->vigencia == "" || is_null($tabelaIrrf[0])) {
            $message = "Configuração da Tabela IRRF inexistente ou não está em vigor para competência!";
        }

        //VERIFICA SE O CÁLCULO DO FGTS ESTÁ EM VIGOR
        /** @var Fgts $pagamentoFgts */
        $pagamentoFgts = $em->getRepository(Fgts::class)->findAll();
        $pagamentoFgts = end($pagamentoFgts);

        if ($pagamentoFgts->getVigencia() > $periodoFinal->getDtFinal() || $pagamentoFgts->getVigencia() == "" || is_null($pagamentoFgts)) {
            $message = "Configuração do FGTS inexistente ou não está em vigor para competência!";
        }

        return $message;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deletarInformacoesCalculoAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $contratosStr = $request->get('contratosStr');
        /** @var RegistroEventoPeriodoModel $registroEventoPeriodoModel */
        $registroEventoPeriodoModel = new RegistroEventoPeriodoModel($em);

        $retorno = true;
        if (!empty($contratosStr)) {
            $retorno = $registroEventoPeriodoModel->deletarInformacoesCalculo(
                $contratosStr,
                'S',
                0,
                ''
            );
        }

        return new JsonResponse($retorno);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function abrirPeriodoMovimentacaoAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $dtInicial = $request->query->get('dtInicial');
        $dtFinal = $request->query->get('dtFinal');

        $exercicio = $this->admin->getExercicio();

        /** @var PeriodoMovimentacaoModel $periodoMovimentacaoModel */
        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($em);
        $periodoMovimentacaoModel->abrirPeriodoMovimentacao($dtInicial, $dtFinal, $exercicio, '');

        return new JsonResponse($periodoMovimentacaoModel);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function montaCalculaFolhaAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $erro = $this->validaCalculoSalario($em);
        $contratos = $request->query->get('contrato');
        $exercicio = $this->admin->getExercicio();
        $retorno = true;
        $contratosNew = [];

        /** @var PeriodoMovimentacaoModel $periodoMovimentacaoModel */
        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacaoModel->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacaoModel->getOnePeriodo($periodoUnico);

        if ($contratos[0] == '') {
            return new JsonResponse($retorno);
        } else {
            foreach ($contratos as $contrato) {
                $codContrato = $em->getRepository(ContratoServidorPeriodo::class)->findOneBy(
                    [
                        'codContrato' => $contrato,
                        'codPeriodoMovimentacao' => $periodoFinal->getCodPeriodoMovimentacao()
                    ]
                );

                if (!is_null($codContrato)) {
                    $contratosNew[] = $codContrato->getCodContrato();
                }
            }
        }

        if (null == $erro) {
            /** @var ContratoModel $contratoModel */
            $contratoModel = new ContratoModel($em);
            if (!empty($contratosNew)) {
                foreach ($contratosNew as $contrato) {
                    $retorno = $contratoModel->montaCalculaFolha($contrato, ContratoModel::IN_COD_CONFIGURACAO, 'f', '', $exercicio);
                }
            }
        }

        return new JsonResponse($retorno);
    }

    /**
     * @param Request $request
     * @param mixed   $object
     *
     * @return mixed
     */
    public function preCreate(Request $request, $object)
    {
        $container = $this->admin->getConfigurationPool()->getContainer();

        /** @var EntityManager $em */
        $em =  $em = $this->getDoctrine()->getManager();
        /** @var PeriodoMovimentacaoModel $periodoMovimentacaoModel */
        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($em);

        $periodoUnico = $periodoMovimentacaoModel->listPeriodoMovimentacao();
        $periodo = $periodoMovimentacaoModel->getOnePeriodo($periodoUnico);

        if (($periodo) && ($request->getMethod() != 'POST')) {
            $retorno = $this->validaPeriodoMovimentacao($periodo);
            if (null !== $retorno) {
                $container->get('session')->getFlashBag()->add('error', $retorno);
                return $this->redirectToRoute('folha_pagamento_rotina_mensal_index');
            }
        }
    }
}
