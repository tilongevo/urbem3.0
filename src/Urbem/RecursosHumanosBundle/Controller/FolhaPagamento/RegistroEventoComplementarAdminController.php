<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoComplementarModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorModel;

class RegistroEventoComplementarAdminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function imprimirRegistroEventoComplementarAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        /** @var RegistroEventoComplementar $object */
        $object = $this->admin->getObject($id);

        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();
        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($entityManager);

        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacaoModel->getMovimentacaoByCodPeriodoMovimentacao($object->getCodPeriodoMovimentacao());
        $dtInicial = $periodoFinal->getDtInicial();
        $arMes = explode("/", $dtInicial->format('d/m/Y'));
        $arDescMes = ["Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

        $object->competencia = $arDescMes[($arMes[1] - 1)] . '/' . $arMes[2];

        /** @var ContratoServidorModel $contratoServidorModel */
        $contratoServidorModel = new ContratoServidorModel($entityManager);
        $dados = $contratoServidorModel->montaRecuperaContratosServidorResumido($this->admin->getExercicio(), '', $object->getCodRegistro());
        /** @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $contratoServidor */
        $contratoServidor = $object->getFkFolhapagamentoContratoServidorComplementar()->getFkPessoalContrato()->getFkPessoalContratoServidor();
        $servidor = $contratoServidor->getFkPessoalServidorContratoServidores()->current()->getFkPessoalServidor()->getFkSwCgmPessoaFisica();
        $object->servidor = $servidor;
        $container = $this->container;
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $configuracaoModel = new ConfiguracaoModel($entityManager);
        $codEntidade = $configuracaoModel->getConfiguracao('cod_entidade_prefeitura', 8, true);

        $dtEmissao = (new \DateTime())->format('Y-m-d H:i:s');
        $entidade = $entityManager->getRepository(Entidade::class)->findOneBy(
            [
                'codEntidade' => $codEntidade,
                'exercicio' => $this->admin->getExercicio()
            ]
        );

        /** @var RegistroEventoComplementarModel $registroEventoComplementarModel */
        $registroEventoComplementarModel = new RegistroEventoComplementarModel($entityManager);
        $rsRegistroEventoComplementar = $registroEventoComplementarModel->montaRecuperaRegistrosEventoDoContrato(
            $object->getCodPeriodoMovimentacao(),
            $object->getCodComplementar(),
            $object->getCodContrato()
        );

        foreach ($rsRegistroEventoComplementar as $registroEvento) {
            $inCountBase = $inCountEventos = 0;
            if ($registroEvento["natureza"] == "B") {
                $arEventos["base"][$inCountBase]["codigo"] = $registroEvento["codigo"];
                $arEventos["base"][$inCountBase]["descricao"] = $registroEvento["descricao"];
                $arEventos["base"][$inCountBase]["valor"] = $registroEvento["valor"];
                $arEventos["base"][$inCountBase]["quantidade"] = $registroEvento["quantidade"];
                $inCountBase = $inCountBase + 1;
            } else {
                $arEventos["eventos"][$inCountEventos]["codigo"] = $registroEvento["codigo"];
                $arEventos["eventos"][$inCountEventos]["descricao"] = $registroEvento["descricao"];
                $arEventos["eventos"][$inCountEventos]["valor"] = $registroEvento["valor"];
                $arEventos["eventos"][$inCountEventos]["quantidade"] = $registroEvento["quantidade"];
                $inCountEventos = $inCountEventos + 1;
            }
        }

        $object->eventos = (isset($arEventos['eventos'])) ? $arEventos['eventos'] : null;
        $object->bases = (isset($arEventos['base'])) ? $arEventos['base'] : null;

        $html = $this->renderView(
            'RecursosHumanosBundle:FolhaPagamento/FolhaComplementar:registro_evento_complementar_pdf.html.twig',
            [
                'object' => $object,
                'modulo' => 'Folha Pagamento',
                'subModulo' => 'Folha Complementar',
                'funcao' => 'Consultar Registro de Evento na Complementar',
                'nomRelatorio' => 'Consultar Registro de Evento na Complementar',
                'dtEmissao' => $dtEmissao,
                'usuario' => $usuario,
                'versao' => $container->getParameter('version'),
                'entidade' => $entidade,
            ]
        );

        $filename = sprintf('ConsultarRegistroDeEventoNaComplementar-%s.pdf', date('Y-m-d'));

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
