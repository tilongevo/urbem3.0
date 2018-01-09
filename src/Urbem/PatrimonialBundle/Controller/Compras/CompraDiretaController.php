<?php

namespace Urbem\PatrimonialBundle\Controller\Compras;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Model\Empenho\EmpenhoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CompraDiretaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CotacaoFornecedorItemModel;

/**
 * Compras\Compra_direta controller.
 *
 */
class CompraDiretaController extends ControllerCore\BaseController
{
    /**
     * Home compra_direta
     *
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Compras/CompraDireta/home.html.twig');
    }

    public function publicacoesAction(Request $requet)
    {
        $this->setBreadCrumb(['cod_compra_direta' => $requet->get('cod_compra_direta')]);

        $codCompraDireta = $requet->get('cod_compra_direta');
        $entityManager = $this->getDoctrine()->getManager();

        list($codCompraDireta, $codEntidade, $exercicioEntidade, $codModalidade) = explode('~', $codCompraDireta);

        /** @var  $compraDireta Compras\CompraDireta*/
        $compraDireta = $entityManager
            ->getRepository(Compras\CompraDireta::class)
            ->findOneBy(
                [
                    'codCompraDireta' => $codCompraDireta,
                    'codEntidade' => $codEntidade,
                    'exercicioEntidade' => $exercicioEntidade,
                    'codModalidade' => $codModalidade,
                ]
            );

        $publicacoes = $entityManager
            ->getRepository(Compras\PublicacaoCompraDireta::class)
            ->findBy([
                'codCompraDireta' => $codCompraDireta,
                'codEntidade' => $codEntidade,
                'exercicioEntidade' => $exercicioEntidade,
                'codModalidade' => $codModalidade,
            ]);

        /** @var  $publicacao Compras\PublicacaoCompraDireta */
        foreach ($publicacoes as $publicacao) {
            $publicacao->identifier = implode("~", [
                $publicacao->getFkComprasCompraDireta()->getCodCompraDireta(),
                $publicacao->getFkComprasCompraDireta()->getCodEntidade(),
                $publicacao->getFkComprasCompraDireta()->getExercicioEntidade(),
                $publicacao->getFkComprasCompraDireta()->getCodModalidade(),
                $publicacao->getFkLicitacaoVeiculosPublicidade()->getFkSwCgm()->getNumcgm()
            ]);
        }

        return $this->render('PatrimonialBundle::Compras/CompraDireta/publicacoes.html.twig', [
            'compraDireta' => $compraDireta,
            'publicacoes' => $compraDireta->getFkComprasPublicacaoCompraDiretas()
        ]);
    }

    public function getByCodAction(Request $request)
    {
        $entityManager = $this->getDoctrine();
        $codCompraDireta = $request->get('cod_compra_direta');

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function getItemsByCompraDiretaAction(Request $request)
    {
        $exercicio = $request->get('exercicio');
        $codEntidade = $request->get('cod_entidade');
        $codModalidade = $request->get('cod_modalidade');
        $codCompraDireta = $request->get('cod_compra_direta');

        $mode = is_null($request->get('mode')) ? 'json' : 'table';

        $response = new Response();

        if (is_null($exercicio) && is_null($codEntidade) && is_null($codModalidade) && is_null($codCompraDireta)) {
            return $response;
        }

        $entityManager = $this->getDoctrine()->getManager();

        $compraDiretaModel = new CompraDiretaModel($entityManager);

        $itens = $compraDiretaModel->montaRecuperaItensComStatus($exercicio, $codEntidade, $codModalidade, $codCompraDireta);

        if (count($itens) == 0
            || is_null($itens)) {
            return $response;
        }

        if ($mode == 'table') {
            return $this->render('PatrimonialBundle::Compras/HomologacaoCompraDireta/items.html.twig', [
                'itens' => $itens
            ]);
        }

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $serializer = new Serializer([$normalizer], [$encoder]);
        $mapas = $serializer->serialize($itens, 'json');

        $response->setContent($mapas);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getInfoCompraDiretaAction(Request $request)
    {
        $exercicio = $request->get('exercicio');
        $codEntidade = $request->get('cod_entidade');
        $codModalidade = $request->get('cod_modalidade');
        $codCompraDireta = $request->get('cod_compra_direta');

        $mode = is_null($request->get('mode')) ? 'json' : 'table';

        $response = new Response();

        if (is_null($exercicio) && is_null($codEntidade) && is_null($codModalidade) && is_null($codCompraDireta)) {
            return $response;
        }

        $entityManager = $this->getDoctrine()->getManager();

        $compraDiretaModel = new CompraDiretaModel($entityManager);

        $mapa = $compraDiretaModel->montaRecuperaMapaCompraDiretaJulgada($codCompraDireta, $codModalidade, $codEntidade, $exercicio);

        if (count($mapa) == 0
            || is_null($mapa)) {
            return $response;
        }

        $cFIModel = new CotacaoFornecedorItemModel($entityManager);
        $itens = $cFIModel->montaRecuperaItensCotacaoJulgadosCompraDireta($mapa[0]->exercicio_mapa, $mapa[0]->cod_mapa);

        if ($mode == 'table') {
            return $this->render('PatrimonialBundle::Compras/AutorizacaoEmpenhoCompraDireta/items.html.twig', [
                'itens' => $itens
            ]);
        }

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $serializer = new Serializer([$normalizer], [$encoder]);
        $mapas = $serializer->serialize($itens, 'json');

        $response->setContent($mapas);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function recuperaUltimaDataContabilAction(Request $request)
    {
        $response = new Response();
        $entityManager = $this->getDoctrine()->getManager();
        $empenhoModel = new EmpenhoModel($entityManager);
        $exercicio = $this->getExercicio();
        $codEntidade = $request->get('cod_entidade');

        if (is_null($codEntidade) || $codEntidade == '') {
            return $response;
        }

        $recuperaUltimaDataContabil = $empenhoModel->recuperaUltimaDataContabil($exercicio, $codEntidade);
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(\GuzzleHttp\json_encode($recuperaUltimaDataContabil));
        return $response;
    }
}
