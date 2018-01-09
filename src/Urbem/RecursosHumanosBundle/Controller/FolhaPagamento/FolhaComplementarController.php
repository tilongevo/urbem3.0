<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Folhapagamento\Complementar;
use Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacao;
use Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacaoFechada;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaSituacaoModel;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;

class FolhaComplementarController extends ControllerCore\BaseController
{
    public function indexAction()
    {
        $this->setBreadCrumb();

        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/FolhaComplementar/index.html.twig'
        );
    }

    public function abrirFolhaComplementarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $request->attributes->all();

        try {
            $folhaModel = new Model\Folhapagamento\FolhaComplementarModel($em);
            $situacaoModel = new Model\Folhapagamento\ComplementarSituacaoModel($em);
            $folha = $folhaModel->getFolhaComplementar($data['id']);

            $periodo = $em->getRepository('Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao')->findOneBy(array('codPeriodoMovimentacao' => $data['id']));
            $prox_cod = (count($folha) > 0) ? ($folha['cod_complementar'] + 1) : 1;

            $date = new \DateTime();

            $newComplementar = new Complementar();
            $newComplementar->setCodComplementar($prox_cod);
            $newComplementar->setCodPeriodoMovimentacao($periodo);
            $folhaModel->save($newComplementar);

            $newComplementarSituacao = new ComplementarSituacao();
            $newComplementarSituacao->setCodPeriodoMovimentacao($periodo->getCodPeriodoMovimentacao());
            $newComplementarSituacao->setCodComplementar($newComplementar->getCodComplementar());
            $newComplementarSituacao->setSituacao('a');
            $newComplementarSituacao->setTimestamp($date);

            $situacaoModel->save($newComplementarSituacao);

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Sucesso ao abrir a folha complementar!');
        } catch (Exception $e) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', "Erro ao abrir a folha complementar!");
            throw $e;
        }

        return $this->redirectToRoute('folha_pagamento_folha_complementar');
    }

    public function reabrirFolhaComplementarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $request->attributes->all();

        try {
            $situacaoModel = new Model\Folhapagamento\ComplementarSituacaoModel($em);

            $date = new \DateTime();
            $newComplementarSituacao = $em->getRepository('Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacao')->findOneBy(array('id' => $data['id']));

            $newComplementarSituacao->setSituacao('a');
            $newComplementarSituacao->setTimestamp($date);

            $situacaoModel->save($newComplementarSituacao);

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Sucesso ao reabrir a folha complementar!');
        } catch (Exception $e) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', "Erro ao reabrir a folha complementar!");
            throw $e;
        }

        return $this->redirectToRoute('folha_pagamento_folha_complementar');
    }

    public function fecharFolhaComplementarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $request->attributes->all();

        try {
            $folhaModel = new Model\Folhapagamento\FolhaComplementarModel($em);
            $situacaoModel = new Model\Folhapagamento\FolhaSituacaoModel($em);
            $complementarModel = new Model\Folhapagamento\ComplementarSituacaoModel($em);
            $complementarSituacaoFechadaModel = new Model\Folhapagamento\ComplementarSituacaoFechadaModel($em);

            //Pega a folha complementar
            $folha = $folhaModel->getFolhaComplementar($data['id']);

            //Pega a folha complementar aberta
            $folhaAberta = $folhaModel->consultaFolhaComplementar($data['id']);

            //Folha Situacão
            $folhaSituacao = $situacaoModel->getFolhaSituacaoByMaxTimestapAndCodPeriodoMovimentacao($data['id']);

            //Periodo Movimentação
            $periodo = $em->getRepository('Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao')->findOneBy(array('codPeriodoMovimentacao' => $data['id']));

            $date = new \DateTime();

            //Inserindo uma nova situação complementar como fechada
            $newComplementarSituacao = new ComplementarSituacao();
            $newComplementarSituacao->setCodPeriodoMovimentacao($periodo->getCodPeriodoMovimentacao());
            $newComplementarSituacao->setCodComplementar($folhaAberta['cod_complementar']);
            $newComplementarSituacao->setSituacao('f');
            $newComplementarSituacao->setTimestamp($date);

            $complementarModel->save($newComplementarSituacao);

            $dataFolha = new \DateTime($folhaSituacao['timestamp']);

            //Inserindo uma nova situação complementar como fechada tabela = complementar_situacao_fechada
            $newComplementarSituacaoFechada = new ComplementarSituacaoFechada();
            $newComplementarSituacaoFechada->setCodPeriodoMovimentacao($periodo->getCodPeriodoMovimentacao());
            $newComplementarSituacaoFechada->setCodComplementar($folhaAberta['cod_complementar']);
            $newComplementarSituacaoFechada->setTimestamp($date);
            $newComplementarSituacaoFechada->setTimestampFolha($dataFolha);
            $newComplementarSituacaoFechada->setCodPeriodoMovimentacaoFolha($folhaAberta['cod_periodo_movimentacao']);

            $complementarSituacaoFechadaModel->save($newComplementarSituacaoFechada);

            //se a folha situação estava como aberta
            if ($folhaSituacao['situacao'] == 'a') {
                $contratoServidorModel = new Model\Pessoal\ContratoServidorModel($em);
                $registroEventoPeriodoModel = new Model\Folhapagamento\RegistroEventoPeriodoModel($em);

                //Pegando os contratos com regitro de evento reduzido
                $crer = $contratoServidorModel->montaRecuperaContratosComRegistroDeEventoReduzido($data['id'], $folhaAberta['cod_complementar']);

                if (count($crer > 0)) {
                    $stCodContratos = "";
                    $cgms = "";
                    foreach ($crer as $cre) {
                        $stCodContratos .= $cre["cod_contrato"] . ",";
                        $cgms .= $cre["numcgm"] . ",";
                    }
                    $stFiltro = " AND registro_evento_periodo.cod_periodo_movimentacao = " . $periodo->getCodPeriodoMovimentacao();
                    $stFiltro .= " AND registro_evento_periodo.cod_contrato IN (" . $stCodContratos . ")";

                    $registroEventosPeriodo = $registroEventoPeriodoModel->montaRecuperaRegistrosDeEventos($stFiltro);

                    foreach ($registroEventosPeriodo as $rep) {
                        $inCodEvento = $rep['cod_evento'];
                        $inCodRegistro = $rep['cod_registro'];
                        $stTimestamp = $rep['timestamp'];

                        $eventoCalculadoDependenteModel = new Model\Folhapagamento\EventoCalculadoDependenteModel($em);
                        $eventoCalculadoDependente = $eventoCalculadoDependenteModel->findOneBy(array('cod_evento' => $inCodEvento, 'cod_registro' => $inCodRegistro, 'timestamp' => $stTimestamp));
                        $eventoCalculadoDependente->remove();

                        $eventoCalculadoModel = new Model\Folhapagamento\EventoCalculadoModel($em);
                        $eventoCalculadoModel->findOneBy(array('cod_evento' => $inCodEvento, 'cod_registro' => $inCodRegistro, 'timestamp' => $stTimestamp));
                        $eventoCalculadoModel->remove();

                        $logErroCalculoModel = new Model\Folhapagamento\LogErroCalculoModel($em);
                        $logErroCalculoModel->findOneBy(array('cod_evento' => $inCodEvento, 'cod_registro' => $inCodRegistro, 'timestamp' => $stTimestamp));
                        $logErroCalculoModel->remove();
                    }
                }

                //Calculo dos contratos na folha salário
                $rsContratos = $registroEventoPeriodoModel->montaRecuperaContratosAutomaticos($periodo->getCodPeriodoMovimentacao(), $cgms);

                //Deletando as informações de Calculo vide arquivo RFolhaPagamentoFolhaComplementar do Urbem antigo Linha 342
                $stTipoFolha = "S";
                $inCodComplementar = 0;
                $entidade = "";
                $deleteCalculo = $registroEventoPeriodoModel->deletarInformacoesCalculo($stCodContratos, $stTipoFolha, $inCodComplementar, $entidade);

                $tipo = 1;
                $erro = 'f';
                $entidade = "";
                $exercicio = date('Y');
                foreach ($rsContratos as $contrato) {
                    $registroEventoPeriodoModel->calculaFolha($contrato['cod_contrato'], $tipo, $erro, $entidade, $exercicio);
                }
            }

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Sucesso ao fechar a folha complementar!');
        } catch (Exception $e) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', "Erro ao fechar a folha complementar!");
            throw $e;
        }

        return $this->redirectToRoute('folha_pagamento_folha_complementar');
    }

    public function folhaComplementarAction()
    {
        $this->setBreadCrumb();
        $timestamp = '';
        $em = $this->getDoctrine()->getManager();

        $folhaComplementar = (new Model\Folhapagamento\PeriodoMovimentacaoModel($em))->montaRecuperaUltimaMovimentacao();

        $folhaSituacao = (new Model\Folhapagamento\FolhaSituacaoModel($em))->getFolhaSituacaoByMaxTimestapAndCodPeriodoMovimentacao($folhaComplementar['cod_periodo_movimentacao']);

        $folhaFechadaAnterior[] = (new Model\Folhapagamento\FolhaComplementarModel($em))->recuperaFolhaComplementarFechadaAnteriorFolhaSalario($folhaSituacao['timestamp'], $folhaComplementar['cod_periodo_movimentacao']);

        $complementarFechada[] = (new Model\Folhapagamento\FolhaComplementarModel($em))->recuperaFolhaComplementarFechada($folhaSituacao['timestamp'], $folhaComplementar['cod_periodo_movimentacao']);

        $folha = (new Model\Folhapagamento\FolhaComplementarModel($em))->consultaFolhaComplementar($folhaComplementar['cod_periodo_movimentacao']);

        $folhaArray = [
            'situacao' => ($folha['situacao'] == 'a') ? $folha['situacao'] : 'Nenhuma Folha Aberta',
            'data' => (isset($folha['timestamp'])) ? $folha['timestamp'] : ''
        ];

        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/FolhaComplementar/folha_complementar.html.twig',
            array(
                'folhaComplementar' => $folhaComplementar,
                'folhaFechadaAnterior' => $folhaFechadaAnterior,
                'complementarFechada' => $complementarFechada,
                'folha' => $folhaArray,
                'folhaSituacao' => $folhaSituacao
            )
        );
    }

    public function registrarEventoComplementarPorContratoAction()
    {
        $this->setBreadCrumb();

        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/FolhaComplementar/registrar_evento_complementar_contrato.html.twig'
        );
    }

    public function calcularFolhaComplementarAction()
    {
        $this->setBreadCrumb();

        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/FolhaComplementar/calcular_folha_complementar.html.twig'
        );
    }

    public function consultarRegistroEventoComplementarAction()
    {
        $this->setBreadCrumb();
        $meses = $this->db->getRepository('CoreBundle:Administracao\Mes')->findAll();

        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/FolhaComplementar/consultar_registro_evento_complementar.html.twig',
            array(
                'meses' => $meses,
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function carregaFolhaComplementarFechadaAnteriorAction(Request $request)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        /** @var Model\Folhapagamento\FolhaComplementarModel $complementarModel */
        $complementarModel = new FolhaComplementarModel($entityManager);
        /** @var Model\Folhapagamento\FolhaSituacaoModel $folhaSituacaoModel */
        $folhaSituacaoModel = new FolhaSituacaoModel($entityManager);
        $folhaSituacaoFechada = $folhaSituacaoModel->montaRecuperaRelacionamento($periodoFinal->getCodPeriodoMovimentacao());
        if (is_null($folhaSituacaoFechada)) {
            $folhaSituacaoFechada = $folhaSituacaoModel->montaRecuperaRelacionamento($periodoFinal->getCodPeriodoMovimentacao(), 'a');
        }
        $timestampFolhaSalario = $folhaSituacaoFechada['timestamp_fechado'];

        /** @var ComplementarSituacao $complementarSituacao */
        $complementarSituacao = $entityManager->getRepository(ComplementarSituacao::class)
            ->findOneBy(
                [
                    'codPeriodoMovimentacao' => $periodoFinal->getCodPeriodoMovimentacao(),
                ],
                [
                    'timestamp' => 'DESC'
                ]
            );

        $folhaComplementarPosterior = [];
        if (!is_null($complementarSituacao)) {
            $folhaComplementarPosterior = $complementarModel->recuperaRelacionamentoFechadaPosteriorSalario($periodoFinal->getCodPeriodoMovimentacao(), $timestampFolhaSalario);
        }

        return $this->render('@RecursosHumanos/FolhaPagamento/FolhaComplementar/folhaComplementarFechadaAnterior.html.twig', [
            'folhaComplementarPosterior' => $folhaComplementarPosterior,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function carregaFolhaComplementarFechadaAnteriorFolhaSalarioAction(Request $request)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        /** @var Model\Folhapagamento\FolhaComplementarModel $complementarModel */
        $complementarModel = new FolhaComplementarModel($entityManager);
        /** @var Model\Folhapagamento\FolhaSituacaoModel $folhaSituacaoModel */
        $folhaSituacaoModel = new FolhaSituacaoModel($entityManager);
        $folhaSituacaoFechada = $folhaSituacaoModel->montaRecuperaRelacionamento($periodoFinal->getCodPeriodoMovimentacao());
        if (is_null($folhaSituacaoFechada)) {
            $folhaSituacaoFechada = $folhaSituacaoModel->montaRecuperaRelacionamento($periodoFinal->getCodPeriodoMovimentacao(), 'a');
        }
        $timestampFolhaSalario = $folhaSituacaoFechada['timestamp_fechado'];

        /** @var ComplementarSituacao $complementarSituacao */
        $complementarSituacao = $entityManager->getRepository(ComplementarSituacao::class)
            ->findOneBy(
                [
                    'codPeriodoMovimentacao' => $periodoFinal->getCodPeriodoMovimentacao(),
                ],
                [
                    'timestamp' => 'DESC'
                ]
            );

        $complementarFechadas = [];
        if (!is_null($complementarSituacao)) {
            $complementarFechadas = $complementarModel->recuperaFolhaComplementarFechadaAnteriorFolhaSalario($timestampFolhaSalario, $periodoFinal->getCodPeriodoMovimentacao());
        }

        return $this->render('@RecursosHumanos/FolhaPagamento/FolhaComplementar/folhaComplementarFechadaAnteriorFolhaSalario.html.twig', [
            'complementarFechadas' => $complementarFechadas,
        ]);
    }
}
