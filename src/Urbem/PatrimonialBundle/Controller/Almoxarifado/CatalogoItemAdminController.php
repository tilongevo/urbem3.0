<?php
namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;

class CatalogoItemAdminController extends Controller
{
    public function getCatalogoClassificacaoAction(Request $request)
    {
        $catalogo = $request->attributes->get('id');

        $classificacoes = $this->getDoctrine()
            ->getRepository('CoreBundle:Almoxarifado\CatalogoItem')
            ->getCatalogoClassificacao(array('codCatalogo' => $catalogo));

        $dados = array();
        foreach ($classificacoes as $classificacao) {
            $dados[$classificacao['cod_classificacao']] = $classificacao['cod_estrutural'].' - '.
                $classificacao['descricao'];
        }

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getClassificacaoAtributoAction(Request $request)
    {
        $codClassificacao = $request->get('codClassificacao');

        list($params['codClassificacao'], $params['codCatalogo']) = explode('~', $codClassificacao);

        $atributos = $this->getDoctrine()
            ->getRepository('CoreBundle:Almoxarifado\CatalogoItem')
            ->getAtributosClassificacao($params);

        $dados = array();
        foreach ($atributos as $atributo) {
            $dados[$atributo['cod_atributo']] = $atributo['nom_atributo'];
        }

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteAction(Request $request)
    {
        $q = $request->get('q');
        $em = $this->getDoctrine()->getEntityManager();

        $catalogoItemModel = new CatalogoItemModel($em);
        $results = $catalogoItemModel->searchByDescricao($q);

        $itens = [];
        /** @var Entity\Almoxarifado\CatalogoItem $catalogoItem */
        foreach ($results as $catalogoItem) {
            $id = $catalogoItemModel->getObjectIdentifier($catalogoItem);
            $label = (string) $catalogoItem;

            array_push($itens, ['id' => $id, 'label' => $label]);
        }

        $items = [
            'items' => $itens
        ];

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteExServicosAction(Request $request)
    {
        $q = $request->get('q');
        $em = $this->getDoctrine()->getEntityManager();

        $catalogoItemModel = new CatalogoItemModel($em);
        $results = $catalogoItemModel->searchByDescricaoExcetoServicos($q);

        $itens = [];
        /** @var Entity\Almoxarifado\CatalogoItem $catalogoItem */
        foreach ($results as $catalogoItem) {
            $id = $catalogoItemModel->getObjectIdentifier($catalogoItem);
            $label = (string) $catalogoItem;

            array_push($itens, ['id' => $id, 'label' => $label]);
        }

        $items = [
            'items' => $itens
        ];

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function infoAction(Request $request)
    {
        $codItem = $request->get('id');
        $em = $this->getDoctrine()->getManager();

        $catalogoItem = (new CatalogoItemModel($em))->getOneByCodItem($codItem);

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $metadata = $em->getClassMetadata(get_class($catalogoItem));
        $ignoredFields = $metadata->getAssociationNames();

        $normalizer->setCircularReferenceLimit(3);
        $normalizer->setIgnoredAttributes($ignoredFields);

        $serializer = new Serializer([$normalizer], [$encoder]);

        $catalogoItemData = $serializer->serialize($catalogoItem, 'json');

        $catalogoItemDataObject = json_decode($catalogoItemData);
        $catalogoItemDataObject->tipo = $catalogoItem->getFkAlmoxarifadoTipoItem()->getAlias();
        $catalogoItemDataObject->unidadeMedida = (string) $catalogoItem->getFkAdministracaoUnidadeMedida();

        return new JsonResponse($catalogoItemDataObject);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function descricaoCompletaDownloadAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        $catalogoItem = $this->admin->getObject($id);

        if (!$catalogoItem) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $paths = $this->container->getParameter('patrimonialbundle');
        $descricaoCompletaFilePath = sprintf('%s/%s', $paths['catalogoItemDescricao'], $catalogoItem->getDescricaoCompletaNomeArquivo());

        if (!file_exists($descricaoCompletaFilePath)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $fp = fopen($descricaoCompletaFilePath, 'r');
        $fileSize = filesize($descricaoCompletaFilePath);

        $response = new Response();
        $response->headers->set('Content-Description', 'File Transfer');
        $response->headers->set('Content-type', 'application/octect-stream');
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', basename($descricaoCompletaFilePath)));
        $response->headers->set('Content-Length', $fileSize);
        $response->setContent(fread($fp, $fileSize));

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function fotoAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        $catalogoItem = $this->admin->getObject($id);
        $foldersBundle = $this->container->getParameter('patrimonialbundle');

        $imagePath = sprintf('%s%s%s', $foldersBundle['catalogoItemFoto'], DIRECTORY_SEPARATOR, $catalogoItem->getFoto());
        if (!file_exists($imagePath)) {
            return Response('', Response::HTTP_NOT_FOUND);
        }

        $response = new Response();
        $response->headers->set('Content-Type', 'image/jpg');
        $response->headers->set('Content-Disposition', sprintf('inline; filename="%s"', $catalogoItem->getFoto()));
        $response->setContent(file_get_contents($imagePath));

        return $response;
    }
}
