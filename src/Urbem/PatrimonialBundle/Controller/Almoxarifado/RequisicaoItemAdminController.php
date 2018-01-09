<?php
namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Controller\CRUDController as Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Parametro;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoItemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class RequisicaoItemAdminController
 */
class RequisicaoItemAdminController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchMarcasAction(Request $request)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        /** @var Almoxarifado $almoxarifado */
        $almoxarifado = $entityManager->find(Almoxarifado::class, $request->get('cod_almoxarifado'));

        /** @var CatalogoItem $catalogoItem */
        $catalogoItem = $entityManager->find(CatalogoItem::class, $request->get('cod_item'));

        $requisicaoItemModel = new RequisicaoItemModel($entityManager);
        $marcasCollection = $requisicaoItemModel->searchMarcasForRequisicao($almoxarifado, $catalogoItem);

        $data = [];

        /** @var Marca $marca */
        foreach ($marcasCollection as $marca) {
            $data[] = [
                'value' => $requisicaoItemModel->getObjectIdentifier($marca),
                'label' => (string) $marca
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchCentroCustoAction(Request $request)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        /** @var Almoxarifado $almoxarifado */
        $almoxarifado = $entityManager->find(Almoxarifado::class, $request->get('cod_almoxarifado'));

        /** @var CatalogoItem $catalogoItem */
        $catalogoItem = $entityManager->find(CatalogoItem::class, $request->get('cod_item'));

        /** @var Marca $marca */
        $marca = $entityManager->find(Marca::class, $request->get('cod_marca'));

        /** @var Usuario $usuario */
        $usuario = $this->getUser();

        $requisicaoItemModel = new RequisicaoItemModel($entityManager);
        $centrosCustomCollection = $requisicaoItemModel->searchCentrosCustoForRequisicao(
            $almoxarifado,
            $catalogoItem,
            $marca,
            $usuario
        );

        $data = [];

        /** @var CentroCusto $centroCusto */
        foreach ($centrosCustomCollection as $centroCusto) {
            $data[] = [
                'value' => $requisicaoItemModel->getObjectIdentifier($centroCusto),
                'label' => (string) $centroCusto
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchCentroCustoGeralAction(Request $request)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        /** @var Almoxarifado $almoxarifado */
        $almoxarifado = $entityManager->find(Almoxarifado::class, $request->get('cod_almoxarifado'));

        /** @var CatalogoItem $catalogoItem */
        $catalogoItem = $entityManager->find(CatalogoItem::class, $request->get('cod_item'));

        /** @var Marca $marca */
        $marca = $entityManager->find(Marca::class, $request->get('cod_marca'));

        $requisicaoItemModel = new RequisicaoItemModel($entityManager);
        $centrosCustomCollection = $requisicaoItemModel->searchCentrosCustoGeralForRequisicao(
            $almoxarifado,
            $catalogoItem,
            $marca
        );

        $data = [];

        /** @var CentroCusto $centroCusto */
        foreach ($centrosCustomCollection as $centroCusto) {
            $data[] = [
                'value' => $requisicaoItemModel->getObjectIdentifier($centroCusto),
                'label' => (string) $centroCusto
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function searchSaldoEstoqueAction(Request $request)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        /** @var Almoxarifado $almoxarifado */
        $almoxarifado = $entityManager->find(Almoxarifado::class, $request->get('cod_almoxarifado'));

        /** @var CatalogoItem $catalogoItem */
        $catalogoItem = $entityManager->find(CatalogoItem::class, $request->get('cod_item'));

        /** @var CentroCusto $centroCusto */
        $centroCusto = $entityManager->find(CentroCusto::class, $request->get('cod_centro'));

        /** @var Marca $marca */
        $marca = $entityManager->find(Marca::class, $request->get('cod_marca'));

        /** @var AbstractSonataAdmin $admin */
        $admin = $this->admin;

        $dados = (new ConfiguracaoModel($entityManager))->pegaConfiguracao(
            Parametro::DEMONSTRAR_SALDO_ESTOQUE,
            Modulo::MODULO_PATRIMONIAL_ALMOXARIFADO,
            $admin->getExercicio()
        );

        $configuracao = reset($dados);

        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');

        if (true == ("true" === $configuracao['valor'])) {
            $saldoEstoque = (new RequisicaoItemModel($entityManager))
                ->getSaldoEstoque($almoxarifado, $catalogoItem, $marca, $centroCusto);

            $content = json_encode(reset($saldoEstoque));

            $response->setContent($content);
            $response->getStatusCode(200);

            return $response;
        }

        $response
            ->setStatusCode(403)
            ->setContent('Configuração não permite a exibição do saldo de estoque.')
            ->setCharset('UTF-8');

        return $response;
    }
}
