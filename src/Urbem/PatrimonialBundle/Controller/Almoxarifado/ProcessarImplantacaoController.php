<?php
namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\TipoItemModel;

/**
 * Class ProcessarImplantacaoController
 * @package Urbem\PatrimonialBundle\Controller\Almoxarifado
 */
class ProcessarImplantacaoController extends ControllerCore\BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function perfilAction(Request $request)
    {
        $this->setBreadCrumb();

        $id = array_combine([
            'codLancamento',
            'codItem',
            'codMarca',
            'codAlmoxarifado',
            'codCentro',
        ], explode('~', $request->query->get('id')));

        $lancamentoMaterial = $this->getDoctrine()
            ->getRepository('CoreBundle:Almoxarifado\LancamentoMaterial')
            ->find($id);

        $idCopy = $id;

        $lancamentoPerecivel = $this->getDoctrine()
            ->getRepository('CoreBundle:Almoxarifado\LancamentoPerecivel')
            ->getLancamentosByPereciveis(array_splice($idCopy, 1));

        return $this->render('PatrimonialBundle:Almoxarifado/ProcessarImportacao:perfil.html.twig', [
            'lancamentoMaterial' => $lancamentoMaterial,
            'lancamentoPerecivel' => $lancamentoPerecivel,
            'id' => $request->query->get('id')
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getItemAction(Request $request)
    {
        $cod = $request->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager
            ->getRepository('CoreBundle:Almoxarifado\CatalogoItem')
            ->createQueryBuilder('ci')
            ->join('ci.fkAlmoxarifadoTipoItem', 'tipo')
            ->where('ci.codItem = :code')
            ->setParameter('code', $cod);

        $catalogoItemCollection = $query
            ->getQuery()
            ->getResult();

        $item = [];
        $item['codUnidade'] = '';
        $item['codTipo'] = '';
        if ($catalogoItemCollection) {
            $item['codUnidade'] = $catalogoItemCollection[0]->getFkAdministracaoUnidadeMedida()->getNomUnidade();
            $item['codTipo'] = $catalogoItemCollection[0]->getFkAlmoxarifadoTipoItem()->getDescricao();
        }

        return new JsonResponse(['item' => $item]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function buscaCatalogoItemAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getEntityManager();

        $offset = $request->get('_per_page') * ($request->get('_page') - 1);
        $perPage = $request->get('_per_page');
        $query = strtolower($request->get('q'));

        $tipoItemModel = new TipoItemModel($entityManager);
        $tipoItemServico = $tipoItemModel->getByDescricao('Serviço');

        $query = $entityManager
            ->getRepository('CoreBundle:Almoxarifado\CatalogoItem')
            ->createQueryBuilder('ci')
            ->join('ci.fkAlmoxarifadoTipoItem', 'tipo')
            ->where('LOWER(ci.descricaoResumida) like :q')
            ->orWhere('LOWER(ci.descricao) like :q')
            ->orWhere('LOWER(tipo.descricao) like :q')
            ->andWhere('tipo.codTipo <> :tipo')
            ->setParameter('q', "%{$query}%")
            ->setParameter('tipo', $tipoItemServico->getCodTipo())
            ->setMaxResults($perPage)
            ->setFirstResult($offset);

        if (is_integer($query)) {
            $query
                ->orWhere('ci.codItem = :code')
                ->setParameter('code', $query);
        }

        $catalogoItemCollection = $query
            ->getQuery()
            ->getResult();

        $items = [];
        /** @var CatalogoItem $catalogoItem */
        foreach ($catalogoItemCollection as $catalogoItem) {
            $label = strtoupper(implode(' - ', [
                $catalogoItem->getCodItem(),
                $catalogoItem->getDescricaoResumida()
            ]));

            $items[] = [
                'id' => $tipoItemModel->getObjectIdentifier($catalogoItem),
                'label' => $label
            ];
        }

        return new JsonResponse(['items' => $items]);
    }
}
