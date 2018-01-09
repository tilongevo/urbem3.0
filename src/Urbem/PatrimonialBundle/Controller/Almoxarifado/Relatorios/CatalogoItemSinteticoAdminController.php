<?php
namespace Urbem\PatrimonialBundle\Controller\Almoxarifado\Relatorios;

use Datetime;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;

class CatalogoItemSinteticoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function apiItemAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $results = ['items' => []];
        if (!$request->get('q')) {
            return new JsonResponse($results);
        }

        $qb = $em->getRepository(CatalogoItem::class)->createQueryBuilder('ci');

        $qb->where('LOWER(ci.descricao) LIKE :descricao');
        $qb->setParameter('descricao', sprintf('%%%s%%', strtolower($request->get('q'))));

        $qb->orderBy('ci.codItem', 'ASC');

        foreach ((array) $qb->getQuery()->getResult() as $catalogoItem) {
            $results['items'][] = [
                'id' => $catalogoItem->getCodItem(),
                'label' => (string) $catalogoItem,
            ];
        }

        return new JsonResponse($results);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function exportAction(Request $request)
    {
        setlocale(LC_ALL, 'pt_BR.utf8');

        $em = $this->getDoctrine()->getManager();
        $container = $this->container;
        $admin = $this->admin;

        $qbTipoItem = $admin->getTiposItem()->getQuery()->getScalarResult();
        $tiposItem = array_combine(array_column($qbTipoItem, 'tipoItem_codTipo'), array_column($qbTipoItem, 'tipoItem_descricao'));

        $html = $this->renderView(
            'PatrimonialBundle::Almoxarifado/Relatorios/CatalogoItem/export_sintetico.html.twig',
            [
                'modulo' => 'Patrimonial',
                'subModulo' => 'Almoxarifado',
                'funcao' => 'Relatorios',
                'nomRelatorio' => 'Relatório de Itens - Sintético',
                'dtEmissao' => new DateTime(),
                'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
                'logoTipo' => $this->container->get('urbem.configuracao')->getLogoTipo(),
                'versao' => $container->getParameter('version'),
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'admin' => $admin,
                'categorias' => $admin::CATEGORIAS,
                'prioridades' => CatalogoItem::PRIORIDADES_LIST,
                'tiposItem' => $tiposItem,
                'periodos' => $admin::PERIODOS,
                'periodoDefinir' => $admin::PERIODO_DEFINIR,
                'catalogoItens' => $this->fetchCatalogoItens(),
                'filtro' => $this->admin->getDatagrid()->getValues(),
            ]
        );

        $filename = sprintf('RelatorioDeItens_%s.pdf', (new DateTime())->format('Y-m-d_His'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => true,
                    'footer-line' => true,
                    'footer-left' => 'URBEM - CNM',
                    'footer-right' => '[page]',
                    'footer-center' => 'www.cnm.org.br',
                    'orientation'=>'Landscape'
                ]
            ),
            200,
            [
                'Content-Description' => 'File Transfer',
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            ]
        );
    }

    /**
    * @return array
    */
    protected function fetchCatalogoItens()
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(CatalogoItem::class)->createQueryBuilder('o');

        $filtro = $this->getRequest()->get('filter') ?: $this->admin->getDatagrid()->getValues();

        $qb->join(sprintf('%s.fkAdministracaoUnidadeMedida', $qb->getRootAlias()), 'um');
        $qb->join(sprintf('%s.fkAlmoxarifadoTipoItem', $qb->getRootAlias()), 'ti');
        $qb->join(sprintf('%s.fkAlmoxarifadoControleEstoque', $qb->getRootAlias()), 'ce');

        $this->admin->filterCategoria($qb, $qb->getRootAlias(), '', $filtro['categoria']);
        $this->admin->filterPrioridade($qb, $qb->getRootAlias(), '', $filtro['prioridade']);
        $this->admin->filterTipoItem($qb, $qb->getRootAlias(), '', $filtro['fkAlmoxarifadoTipoItem']);
        $this->admin->filterPeriodo($qb, $qb->getRootAlias(), '', $filtro['periodo'], $filtro['periodoInicial'], $filtro['periodoFinal']);
        $this->admin->filterItem($qb, $qb->getRootAlias(), '', $filtro['item']);

        $this->setOrderBy($filtro['_sort_by'], $filtro['_sort_order'], $qb);

        return $qb->getQuery()->getResult();
    }

    /**
    * @param string $sortBy
    * @param string $sortOrder
    * @param QueryBuilder $qb
    * @return void
    */
    private function setOrderBy($sortBy, $sortOrder, QueryBuilder $qb)
    {
        $sortBy = sprintf('%s.%s', $qb->getRootAlias(), $sortBy);
        if (strpos($sortBy, 'fkAdministracaoUnidadeMedida.nomUnidade') !== false) {
            $sortBy = 'um.nomUnidade';
        }

        if (strpos($sortBy, 'fkAlmoxarifadoTipoItem.descricao') !== false) {
            $sortBy = 'ti.descricao';
        }

        if (strpos($sortBy, 'fkAlmoxarifadoControleEstoque.estoqueMinimo') !== false) {
            $sortBy = 'ce.estoqueMinimo';
        }

        if (strpos($sortBy, 'fkAlmoxarifadoControleEstoque.pontoPedido') !== false) {
            $sortBy = 'ce.pontoPedido';
        }

        if (strpos($sortBy, 'fkAlmoxarifadoControleEstoque.estoqueMaximo') !== false) {
            $sortBy = 'ce.estoqueMaximo';
        }

        $qb->addOrderBy($sortBy, $sortOrder);
    }
}
