<?php
namespace Urbem\PatrimonialBundle\Controller\Licitacao;

use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Urbem\CoreBundle\Controller as ControllerCore;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Class ManutencaoPropostaController
 * @package Urbem\PatrimonialBundle\Controller\Licitacao
 */
class ManutencaoPropostaController extends ControllerCore\BaseController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function getItensByFornecedorAction(Request $request)
    {
        $codLicitacao = $request->get('cod_licitacao');
        $exercicio = $request->get('exercicio');
        $codModalidade = $request->get('cod_modalidade');
        $codEntidade = $request->get('cod_entidade');
        $participante = $request->get('participante');

        $mode = is_null($request->get('mode')) ? 'json' : 'table';

        $response = new Response();

        if (is_null($codLicitacao)) {
            return $response;
        }

        $entityManager = $this->getDoctrine()->getManager();

        /** @var Licitacao $licitacao */
        $licitacao = $entityManager
            ->getRepository(Licitacao::class)
            ->findOneBy([
                'codLicitacao' => $codLicitacao,
                'codModalidade' => $codModalidade,
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicio
            ]);

        $mapaItemModel = new Model\Patrimonial\Compras\MapaItemModel($entityManager);
        $cotacaoFornecedorItemModel = new Model\Patrimonial\Compras\CotacaoFornecedorItemModel($entityManager);

        $cotacaoValida = $mapaItemModel->montaRecuperaMapaCotacaoValida(
            $licitacao->getFkComprasMapa()->getCodMapa(),
            $licitacao->getFkComprasMapa()->getExercicio()
        );
        $mapaItens = $mapaItemModel->montaRecuperaItensPropostaAgrupados(
            $licitacao->getFkComprasMapa()->getCodMapa(),
            $licitacao->getFkComprasMapa()->getExercicio()
        );

        $arrayItens = array();
        foreach ($mapaItens as $index => $itens) {
            if (!empty($cotacaoValida)) {
                $ultimaCompra = $cotacaoFornecedorItemModel->montaRecuperaValorItemUltimaCompra(
                    $itens->cod_item,
                    $licitacao->getFkComprasMapa()->getExercicio()
                );
            }

            /** @var Almoxarifado\CatalogoItem $item */
            $item = $entityManager
                ->getRepository(Almoxarifado\CatalogoItem::class)
                ->findOneBy([
                    'codItem' => $itens->cod_item,
                ]);

            $valorTotalFormatado = str_replace(',', '', str_replace('.', '', $itens->vl_total));
            $quantidadeFormatado = str_replace(',', '', str_replace('.', '', $itens->quantidade));

            $valorReferencia = $valorTotalFormatado / $quantidadeFormatado;
            $valorReferencia = number_format($valorReferencia, 4, ',', '.');

            $arrayItens[$index]['vl_unitario_ultima_compra'] =
                (!empty($ultimaCompra)) ? $ultimaCompra[0]->vl_unitario_ultima_compra : null;
            $arrayItens[$index]['item'] = $item->getDescricao();
            $arrayItens[$index]['quantidade'] = $itens->quantidade;
            $arrayItens[$index]['vl_referencia'] = $itens->vl_unit;
            if (!empty($cotacaoValida)) {
                $arrayItens[$index]['exercicio'] = $cotacaoValida->exercicio_cotacao;
                $arrayItens[$index]['cod_cotacao'] = $cotacaoValida->cod_cotacao;
            }
            $arrayItens[$index]['cod_item'] = $itens->cod_item;
            $arrayItens[$index]['cgm_fornecedor'] = $participante;
            $arrayItens[$index]['lote'] = $itens->lote;
        }

        $marcas = $entityManager
            ->getRepository(Almoxarifado\Marca::class)
            ->findAll();

        if ($mode == 'table') {
            return $this->render('PatrimonialBundle::Licitacao/ManutencaoProposta/items.html.twig', [
                'itens' => $arrayItens,
                'marcas' => $marcas
            ]);
        }

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $serializer = new Serializer([$normalizer], [$encoder]);
        $itens = $serializer->serialize($itens, 'json');

        $response->setContent($itens);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
