<?php
namespace Urbem\PatrimonialBundle\Controller\Licitacao;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\PedidoTransferenciaModel;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LicitacaoAdminController extends Controller
{
    public function getItensLicitacaoAction(Request $request)
    {
        list($exercicio, $codMapa) = explode('~', $_GET['codMapa']);

        $em = $this->getDoctrine()->getManager();

        $mapaModel = new Model\Patrimonial\Compras\MapaItemModel($em);
        $mapasItens = $mapaModel->montaRecuperaItensCompraDireta($codMapa, $exercicio);
        $response = new Response();
        $mode = is_null($request->get('mode')) ? 'json' : 'table';

        $dados = array();
        foreach ($mapasItens as $itens) {
            if ($mode == 'table') {
                $dados[$itens->cod_item]['codItem'] = $itens->cod_item;
                $dados[$itens->cod_item]['descricaoResumida'] = $itens->descricao_resumida;
                $dados[$itens->cod_item]['centroCustoDescricao'] = $itens->centro_custo_descricao;
                $dados[$itens->cod_item]['valorTotal'] = $itens->valor_total;
            } else {
                $dados[$itens->cod_item] = $itens->cod_item . '-' . $itens->descricao_resumida . ' - ' . $itens->centro_custo_descricao . ' - ' . $itens->valor_total;
            }
        }

        if ($mode == 'table') {
            return $this->render('@Patrimonial/Licitacao/Licitacao/items.html.twig', [
                'dados' => $dados
            ]);
        }

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $serializer = new Serializer([$normalizer], [$encoder]);
        $mapas = $serializer->serialize($dados, 'json');

        $response->setContent($mapas);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function carregaInformacoesMapaAction(Request $request)
    {
        list($exercicio, $codMapa) = explode('~', $_GET['codMapa']);

        $em = $this->getDoctrine()->getManager();

        $mapaModel = new Model\Patrimonial\Compras\MapaItemModel($em);
        $mapasItens = $mapaModel->carregaInformacoesMapa($codMapa, $exercicio);
        $valor = $mapaModel->somaValoresMapa($codMapa, $exercicio);
        $dados = array();
        $dados['tipoLicitacao'] = $mapasItens['cod_tipo_licitacao']. " - ". $mapasItens['tipo_licitacao'];
        $dados['codTipoLicitacao'] = $mapasItens['cod_tipo_licitacao'];
        $dados['registroPrecos'] = ($mapasItens['registro_precos'] == true) ? 'Sim' : 'Não';
        $dados['vlTotal'] = $valor['vltotal'];

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function carregaModalidadeAction(Request $request)
    {
        $registroPreco = $request->get('registroPrecos');
        $em = $this->getDoctrine()->getManager();

        $mapaModel = new Model\Patrimonial\Compras\MapaItemModel($em);
        $queryBuilder = $mapaModel->carregaModalidade($registroPreco);

        $result = $queryBuilder->getQuery()->getResult();
        $modalidades = [];

        /** @var Entity\Compras\Modalidade $modalidade */
        foreach ($result as $modalidade) {
            array_push(
                $modalidades,
                [
                    'id' => $mapaModel->getObjectIdentifier($modalidade),
                    'label' => (string) $modalidade
                ]
            );
        }

        $itens = [
            'itens' => $modalidades
        ];

        $response = new Response();
        $response->setContent(json_encode($itens));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getMembrosComissaoAction(Request $request)
    {
        $codComissao = $_GET['codComissao'];

        $em = $this->getDoctrine()->getManager();

        $comissaoModel = new Model\Patrimonial\Licitacao\ComissaoModel($em);
        $comissaoMembros = $comissaoModel->getMembrosComissao($codComissao);

        $dados = array();
        foreach ($comissaoMembros as $membro) {
            $dados[$membro['numcgm']] = $membro['nom_cgm'] . ' - ' . $membro['tipo_membro'] . ' - ' . $membro['dt_publicacao'] . ' - ' . $membro['cargo'];
        }

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
