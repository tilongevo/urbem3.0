<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoRescisaoModel;
use Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento\FolhaPagamentoConfiguracaoAdmin;

class ContratoServidorPeriodoRescisaoAdminController extends CRUDController
{
    public function detalhesRescisaoAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());

        $this->admin->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $eventoModel = new EventoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();

        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);
        $dtInicial = $periodoFinal->getDtInicial();
        $dtFinal = $periodoFinal->getDtFinal();
        $arMes = explode("/", $dtInicial->format('d/m/Y'));
        $arDescMes = ["Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

        /** @var ContratoServidor $object */
        $object = $this->admin->getSubject();
        $object->periodo = $dtInicial->format('d/m/Y') . ' à ' . $dtFinal->format('d/m/Y');
        $object->competencia = $arDescMes[($arMes[1] - 1)] . '/' . $arMes[2];
        $object->matricula = $object->getFkPessoalContrato()->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
            ->getFkPessoalServidor()
            ->getFkSwCgmPessoaFisica()
            ->getFkSwCgm();

        /** @var RegistroEventoRescisaoModel $registroEventoDecimoModel */
        $registroEventoRescisaoModel = new RegistroEventoRescisaoModel($entityManager);
        $eventosCadastrados = $registroEventoRescisaoModel->montaRecuperaRelacionamento(
            $object->getFkPessoalContrato()->getCodContrato(),
            $periodoFinal->getCodPeriodoMovimentacao()
        );

        $arEventosFixos = $arEventosBases = [];
        foreach ($eventosCadastrados as $key => $eventos) {
            if ($eventos['evento_sistema'] == false) {
                $arEventosFixos[] = $eventos;
            }

            $rsEvento = $eventoModel->listarEvento($eventos['cod_evento']);
            $rsEventoBase = $eventoModel->listarEventosBase($eventos['cod_evento'], $rsEvento[0]['timestamp']);

            if (is_array($rsEventoBase)) {
                foreach ($rsEventoBase as $bases) {
                    $rsEventosBasePai = $eventoModel->listarEvento($bases['cod_evento']);
                    $rsEvento = $eventoModel->listarEvento($bases['cod_evento_base']);

                    $arElementos = [];
                    $arElementos['codigo'] = $rsEventosBasePai[0]['codigo'];
                    $arElementos['descricao'] = $rsEvento[0]['descricao'];
                    $arElementos['valor'] = $rsEvento[0]['valor_quantidade'];
                    $arElementos['quantidade'] = $rsEvento[0]['unidade_quantitativa'];
                    $arElementos['inCodRegistro'] = $eventos['cod_registro'];
                    $arElementos['inCodigo'] = $rsEventosBasePai[0]['codigo'];
                    $arEventosBases[] = $arElementos;
                }
            }
        }

        $exercicio = $this->admin->getExercicio();

        $anoMesCompetencia = $periodoFinal->getDtFinal()->format('Ym');

        $filtro = "AND  registro =". $object->getFkPessoalContrato()->getRegistro();

         /** @var RegistroEventoRescisaoModel $registroEventoRescisaoModel */
        $registroEventoRescisaoModel = new RegistroEventoRescisaoModel($entityManager);
        $contratoRescindido = $registroEventoRescisaoModel->recuperaRescisaoContrato($exercicio, $filtro);

        if (empty($contratoRescindido)) {
            $contratoRescindido = $registroEventoRescisaoModel->recuperaRescisaoContratoPensionista($exercicio, '', $anoMesCompetencia, $filtro);
        }

        $configuracaoModel = new ConfiguracaoModel($entityManager);
        $boBase = $configuracaoModel->getConfiguracao('apresenta_aba_base', ConfiguracaoModel::MODULO_RH_FOLHAPAGAMENTO, true);
        $apresentaAbaBase = ($boBase == 'true') ? true : false;

        $object->apresentaAbaBase = $apresentaAbaBase;
        $object->eventosFixos = $arEventosFixos;
        $object->eventosBases = $arEventosBases;
        $object->dados = $contratoRescindido;
        $object->codPeriodoMovimentacao = $periodoFinal->getCodPeriodoMovimentacao();

        return $this->render('RecursosHumanosBundle:Sonata/FolhaPagamento/ContratoServidorPeriodoRescisao/CRUD:show.html.twig', array(
            'object' => $object,
        ));
    }
}
