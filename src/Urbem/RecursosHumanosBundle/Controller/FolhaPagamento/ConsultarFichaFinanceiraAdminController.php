<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoCalculadoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;

class ConsultarFichaFinanceiraAdminController extends CRUDController
{

    /**
     * @param Request $request
     *
     * @return string
     */
    public function gerarPreviaAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        $this->admin->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $tipoFiltro = $this->getRequest()->get('tipoCalculo');
        $codComplementar = $this->getRequest()->get('codComplementar');
        $codMes = $this->getRequest()->get('codMes');
        $codAno = $this->getRequest()->get('codAno');

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $dtInicial = $periodoFinal->getDtInicial();
        $arMes = explode("/", $dtInicial->format('d/m/Y'));
        $arDescMes = ["Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

        /** @var Contrato $contrato */
        $contrato = $this->admin->getObject($id);
        $contrato->competencia = $arDescMes[($arMes[1] - 1)] . '/' . $arMes[2];
        $contrato->matricula = $contrato->getRegistro(). " - ". $contrato->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
                ->getFkPessoalServidor()
                ->getFkSwCgmPessoaFisica()
                ->getFkSwCgm()->getNomCgm();

        $codContrato = $id;
        $eventoCalculadoModel = new EventoCalculadoModel($em);
        $codConfiguracao = ($tipoFiltro) ? $tipoFiltro : 1;
        $codComplementar = ($codComplementar) ? $codComplementar : 0;
        $entidade = '';
        $ordem = 'codigo';
        $codPeriodoMovimentacao = $periodoFinal->getCodPeriodoMovimentacao();
        $rsEventoCalculado = $eventoCalculadoModel->recuperarEventosCalculadosFichaFinanceira(
            $codConfiguracao,
            $codPeriodoMovimentacao,
            $codContrato,
            $codComplementar,
            $entidade,
            $ordem
        );

        $processados = $eventoCalculadoModel->processarEventoFichaFinanceira($codConfiguracao, $codContrato, $entidade, $codPeriodoMovimentacao);

        $eventosCalculados = $eventoCalculadoModel->processarEventos($rsEventoCalculado, 1);
        $basesCalculos = $eventoCalculadoModel->processarEventos($rsEventoCalculado, 2);
        $eventosInformativos = $eventoCalculadoModel->processarEventos($rsEventoCalculado, 3);
        $totaisCalculados = $eventoCalculadoModel->processarEventos($rsEventoCalculado, 4);

        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($em);
        $codEntidade = $configuracaoModel->getConfiguracao('cod_entidade_prefeitura', Modulo::MODULO_ORCAMENTO, true);

        /** @var Entidade $entidade */
        $entidade = $em->getRepository(Entidade::class)->findOneBy(
            [
                'codEntidade' => $codEntidade,
                'exercicio' => $this->admin->getExercicio()
            ]
        );

        $contrato->eventosCalculados = $eventosCalculados;
        $contrato->basesCalculos = $basesCalculos;
        $contrato->eventosInformativos = $eventosInformativos;
        $contrato->totaisCalculados = $totaisCalculados;
        $contrato->codConfiguracao = $codConfiguracao;
        $contrato->processados = $processados;
        $contrato->codAno = $codAno;
        $contrato->codMes = $codMes;
        $container = $this->container;
        $dtEmissao = (new \DateTime())->format('Y-m-d H:i:s');
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/FolhaSalario/ConsultarFichaFinanceira:previa.html.twig',
            [
                'object' => $contrato,
                'modulo' => 'Recursos Humanos',
                'subModulo' => 'Folha Pagamento\Folha Salário',
                'funcao' => 'Consulta Ficha Financeira',
                'nomRelatorio' => 'Ficha Financeira',
                'dtEmissao' => $dtEmissao,
                'usuario' => $usuario,
                'versao' => $container->getParameter('version'),
                'entidade' => $entidade
            ]
        );
    }

    /**
     * @param Request $request
     */
    public function gerarRelatorioAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $tipoFiltro = $this->getRequest()->get('tipoCalculo');
        $codComplementar = $this->getRequest()->get('codComplementar');
        $codMes = $this->getRequest()->get('codMes');
        $codAno = $this->getRequest()->get('codAno');

        $mes = ((int) $codMes < 10) ? "0" . $codMes : $codMes;
        $dtCompetencia = $mes . "/" . $codAno;

        /** @var PeriodoMovimentacaoModel $periodoMovimentacaoModel */
        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacaoModel->recuperaPeriodoMovimentacao(null, $dtCompetencia);

        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacaoModel->getMovimentacaoByCodPeriodoMovimentacao($periodoUnico['cod_periodo_movimentacao']);
        $dtInicial = $periodoFinal->getDtInicial();
        $arMes = explode("/", $dtInicial->format('d/m/Y'));
        $arDescMes = ["Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

        /** @var Contrato $contrato */
        $contrato = $this->admin->getObject($id);
        $contrato->competencia = $arDescMes[($arMes[1] - 1)] . '/' . $arMes[2];
        $contrato->matricula = $contrato->getRegistro(). " - ". $contrato->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
                ->getFkPessoalServidor()
                ->getFkSwCgmPessoaFisica()
                ->getFkSwCgm()->getNomCgm();

        $codContrato = $id;
        $eventoCalculadoModel = new EventoCalculadoModel($em);
        $codConfiguracao = ($tipoFiltro) ? $tipoFiltro : 1;
        $codComplementar = ($codComplementar) ? $codComplementar : 0;
        $entidade = '';
        $ordem = 'codigo';
        $codPeriodoMovimentacao = $periodoFinal->getCodPeriodoMovimentacao();
        $rsEventoCalculado = $eventoCalculadoModel->recuperarEventosCalculadosFichaFinanceira(
            $codConfiguracao,
            $codPeriodoMovimentacao,
            $codContrato,
            $codComplementar,
            $entidade,
            $ordem
        );

        $processados = $eventoCalculadoModel->processarEventoFichaFinanceira($codConfiguracao, $codContrato, $entidade, $codPeriodoMovimentacao);

        $eventosCalculados = $eventoCalculadoModel->processarEventos($rsEventoCalculado, 1);
        $basesCalculos = $eventoCalculadoModel->processarEventos($rsEventoCalculado, 2);
        $eventosInformativos = $eventoCalculadoModel->processarEventos($rsEventoCalculado, 3);
        $totaisCalculados = $eventoCalculadoModel->processarEventos($rsEventoCalculado, 4);

        $configuracaoModel = new ConfiguracaoModel($em);
        $codEntidade = $configuracaoModel->getConfiguracao('cod_entidade_prefeitura', 8, true);

        $entidade = $em->getRepository(Entidade::class)->findOneBy(
            [
                'codEntidade' => $codEntidade,
                'exercicio' => $this->admin->getExercicio()
            ]
        );

        $contrato->eventosCalculados = $eventosCalculados;
        $contrato->basesCalculos = $basesCalculos;
        $contrato->eventosInformativos = $eventosInformativos;
        $contrato->totaisCalculados = $totaisCalculados;
        $contrato->codConfiguracao = $codConfiguracao;
        $contrato->processados = $processados;
        $contrato->codAno = $codAno;
        $contrato->codMes = $codMes;
        $container = $this->container;
        $dtEmissao = (new \DateTime())->format('Y-m-d H:i:s');
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        switch ($tipoFiltro) {
            case '1':
                $subModulo = 'Folha Salário';
                break;
            case '2':
                $subModulo = 'Folha Férias';
                break;
            case '3':
                $subModulo = 'Folha Décimo';
                break;
            case '4':
                $subModulo = 'Folha Rescisão';
                break;

            default:
                $subModulo = 'Folha Salário';
                break;
        }

        $html = $this->renderView(
            'RecursosHumanosBundle:FolhaPagamento/FolhaSalario/ConsultarFichaFinanceira:pdf.html.twig',
            [
                'object' => $contrato,
                'modulo' => 'Recursos Humanos',
                'subModulo' => 'Folha Pagamento\\'.$subModulo,
                'funcao' => 'Consulta Ficha Financeira',
                'nomRelatorio' => 'Ficha Financeira',
                'dtEmissao' => $dtEmissao,
                'usuario' => $usuario,
                'versao' => $container->getParameter('version'),
                'entidade' => $entidade
            ]
        );

        $filename = sprintf('Folha-Salario-Ficha-Financeira-%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => false,
                    'footer-line' => true,
                    'footer-left' => 'URBEM - CNM',
                    'footer-right' => '[page]',
                    'footer-center' => 'www.cnm.org.br'
                ]
            ),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            ]
        );
    }
}
