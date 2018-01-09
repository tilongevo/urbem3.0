<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 26/07/16
 * Time: 14:43
 */

namespace Urbem\PatrimonialBundle\Controller\Compras;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Urbem\CoreBundle\Controller as ControllerCore;

use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoClassificacaoModel;

class FornecedorController extends ControllerCore\BaseController
{
    public function ativarAction(Request $request)
    {
        $this->setBreadCrumb();
        $id = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();

        $em->getRepository('CoreBundle:Compras\Fornecedor')->ativarFornecedor($id);

        return $this->redirectToRoute('urbem_patrimonial_compras_fornecedor_list');
    }

    public function inativarAction(Request $request)
    {
        $this->setBreadCrumb();
        $id = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();

        $em->getRepository('CoreBundle:Compras\Fornecedor')->inativarFornecedor($id);

        return $this->redirectToRoute('urbem_patrimonial_compras_fornecedor_list');
    }

    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Compras/Fornecedor/home.html.twig');
    }

    public function getCatalogoClassificacaoAction(Request $request)
    {
        $entityManager = $this->getDoctrine();

        $catalogoId = $request->get('cod_catalogo');

        $classificacoes = $entityManager
            ->getRepository(Almoxarifado\CatalogoClassificacao::class)
            ->findByCodCatalogo($catalogoId);

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $serializer = new Serializer([$normalizer], [$encoder]);
        $classificacoes = $serializer->serialize($classificacoes, 'json');

        $response = new Response();
        $response->setContent($classificacoes);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function perfilAction(Request $request)
    {
        $this->setBreadCrumb();

        $id = $request->query->get('id');
        $entityManager = $this->getDoctrine()->getManager();

        $fornecedor = $entityManager
            ->getRepository(Compras\Fornecedor::class)
            ->find($id);

        return $this->render('PatrimonialBundle::Compras/Fornecedor/perfil.html.twig', [
            'fornecedor' => $fornecedor,
            'atividades' => $fornecedor->getFkComprasFornecedorAtividades(),
            'contas' => $fornecedor->getFkComprasFornecedorContas(),
            'socios' => $fornecedor->getFkComprasFornecedorSocios(),
            'classificacoes' => $fornecedor->getFkComprasFornecedorClassificacoes(),
        ]);
    }

    public function carregaCatalogoClassificacaoAction(Request $request)
    {
        $search = $request->get('q');

        $searchSql = strpos($search, '.') ?
            sprintf("cod_estrutural LIKE '%%%s%%'", $search) :
            sprintf("(lower(descricao) LIKE '%%%s%%')", $request->get('q'));

        $params = [$searchSql];
        $catalogoClassificacao = new CatalogoClassificacaoModel($this->db);
        $result = $catalogoClassificacao->getCatalogoClassificacao($params);
        $classificacoes = [];

        foreach ($result as $classificacao) {
            array_push($classificacoes, ['id' => $classificacao->cod_classificacao, 'label' => $classificacao->cod_estrutural . " - " . $classificacao->descricao]);
        }
        $items = [
            'items' => $classificacoes
        ];
        return new JsonResponse($items);
    }
}
