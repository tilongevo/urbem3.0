<?php

namespace Urbem\FinanceiroBundle\Controller\Empenho;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Empenho\NotaLiquidacaoItemAnuladoModel;
use Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel;
use Urbem\CoreBundle\Services\Financeiro\Empenho\Liquidacao\DocumentoFiscal\DocumentoFiscal;
use Urbem\CoreBundle\Services\Financeiro\Empenho\Liquidacao\DocumentoFiscal\DocumentoFiscalFactory;

class LiquidarEmpenhoAdminController extends CRUDController
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function reemitirLiquidacaoAction(Request $request)
    {
        $container = $this->container;

        $assinaturas = $container->get('session')->getFlashBag()->get('assinaturas');

        $em = $this->getDoctrine()->getManager();

        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $dtEmissao = new \DateTime('now');

        $id = $request->attributes->get('id');

        list($codEmpenho, $exercicio, $codEntidade) = explode('~', $id);

        $empenho = $em->getRepository(Empenho::class)
            -> findOneBy([
                'codEmpenho' => $codEmpenho,
                'exercicio' => $exercicio,
                'codEntidade' => $codEntidade
            ]);

        $cgmPessoaJuridica = $em->getRepository(SwCgmPessoaJuridica::class)
            ->find($empenho->getFkOrcamentoEntidade()->getNumcgm());

        $preEmpenhoModel = new PreEmpenhoModel($em);
        $dadosEmpenho = $preEmpenhoModel->getDadosEmpenho($empenho->getCodPreEmpenho(), $empenho->getExercicio());

        // Retorna o Estado
        $configuracaoModel = new ConfiguracaoModel($em);
        $configuracaoUf = $configuracaoModel->pegaConfiguracao('cod_uf', ConfiguracaoModel::MODULO_ADMINISTRACAO, $empenho->getExercicio());
        $configuracaoUf = array_shift($configuracaoUf);

        $swUf = $em->getRepository(SwUf::class)
            ->findOneByCodUf($configuracaoUf['valor']);

        $documentoFiscal = new DocumentoFiscal(new DocumentoFiscalFactory(), $em, $container->get('session'));
        $documentoFiscal->setType($swUf->getSiglaUf());
        $documentoFiscal->setCodEmpenho($id);
        $documentoFiscalInfo = $documentoFiscal->getInfo();

        $html = $this->renderView(
            'FinanceiroBundle:Empenho/Liquidacao:notaLiquidacao.html.twig',
            [
                'object' => $empenho,
                'entidade' => $empenho->getFkOrcamentoEntidade(),
                'cgmPessoaJuridica' => $cgmPessoaJuridica,
                'usuario' => $usuario,
                'modulo' => 'Empenho',
                'subModulo' => 'Liquidação',
                'funcao' => 'Nota de Liquidação',
                'nomRelatorio' => 'Nota N. ' . $empenho->getCodEmpenho() . '/' . $empenho->getExercicio(),
                'dtEmissao' => $dtEmissao,
                'versao' => $container->getParameter('version'),
                'dadosEmpenho' => $dadosEmpenho,
                'documentoFiscal' => $documentoFiscalInfo,
                'assinaturas' => $assinaturas,
            ]
        );

        $filename = sprintf('NotaDeLiquidacao-%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(utf8_decode($html)),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
                'header-spacing' => 2,
            ]
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function reemitirAnulacaoLiquidacaoAction(Request $request)
    {
        $container = $this->container;
        $em = $this->getDoctrine()->getManager();

        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $dtEmissao = new \DateTime('now');

        $id = $request->attributes->get('id');

        list($codEmpenho, $exercicio, $codEntidade) = explode('~', $id);

        $empenho = $em->getRepository(Empenho::class)
            -> findOneBy([
                'codEmpenho' => $codEmpenho,
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicio
            ]);

        $itemPreEmpenhoModel = new NotaLiquidacaoItemAnuladoModel($em);
        $itensAnulados = $itemPreEmpenhoModel->getItensAnulados($empenho->getCodPreEmpenho(), $exercicio);

        $totalAnulado = 0;
        $itens = [];
        foreach ($itensAnulados as $item) {
            $itens[] = $item;
            $totalAnulado += $item['anulado'];
        }

        $cgmPessoaJuridica = $em->getRepository(SwCgmPessoaJuridica::class)
            ->find($empenho->getFkOrcamentoEntidade()->getNumcgm());

        $preEmpenhoModel = new PreEmpenhoModel($em);
        $dadosEmpenho = $preEmpenhoModel->getDadosEmpenho($empenho->getCodPreEmpenho(), $empenho->getExercicio());

        $configuracaoModel = new ConfiguracaoModel($em);
        $configuracaoUf = $configuracaoModel->pegaConfiguracao('cod_uf', ConfiguracaoModel::MODULO_ADMINISTRACAO, $empenho->getExercicio());
        $configuracaoUf = array_shift($configuracaoUf);

        $swUf = $em->getRepository(SwUf::class)
            ->findOneByCodUf($configuracaoUf['valor']);

        $documentoFiscal = new DocumentoFiscal(new DocumentoFiscalFactory(), $em, $container->get('session'));
        $documentoFiscal->setType($swUf->getSiglaUf());
        $documentoFiscal->setCodEmpenho($id);
        $documentoFiscalInfo = $documentoFiscal->getInfo();
    }
}
