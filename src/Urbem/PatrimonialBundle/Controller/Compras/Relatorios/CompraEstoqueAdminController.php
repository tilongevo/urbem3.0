<?php
namespace Urbem\PatrimonialBundle\Controller\Compras\Relatorios;

use Datetime;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Compras\Solicitacao;

class CompraEstoqueAdminController extends CRUDController
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
            'PatrimonialBundle::Compras/Relatorios/CompraEstoque/export.html.twig',
            [
                'modulo' => 'Patrimonial',
                'subModulo' => 'Compras',
                'funcao' => 'Relatorios',
                'nomRelatorio' => 'Relatório de Compras e Estoque',
                'dtEmissao' => new DateTime(),
                'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
                'logoTipo' => $this->container->get('urbem.configuracao')->getLogoTipo(),
                'versao' => $container->getParameter('version'),
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'admin' => $admin,
                'almoxarifado' => $this->getAlmoxarifado(),
                'centroCusto' => $this->getCentroCusto(),
                'prioridades' => CatalogoItem::PRIORIDADES_LIST,
                'tiposItem' => $tiposItem,
                'periodos' => $admin::PERIODOS,
                'periodoDefinir' => $admin::PERIODO_DEFINIR,
                'catalogoItens' => $this->fetchCatalogoItens(),
                'statusSolicitacao' => Solicitacao::STATUS_LIST,
                'filtro' => $admin->getDatagrid()->getValues(),
            ]
        );

        $filename = sprintf('RelatorioCompraEstoque_%s.pdf', (new DateTime())->format('Y-m-d_His'));

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
    * @return Almoxarifado|null
    */
    protected function getAlmoxarifado()
    {
        $em = $this->getDoctrine()->getManager();

        $filtro = $this->getRequest()->get('filter') ?: $this->admin->getDatagrid()->getValues();
        if (empty($filtro['almoxarifado']['value'])) {
            return;
        }

        return $em->getRepository(Almoxarifado::class)->findOneByCodAlmoxarifado($filtro['almoxarifado']['value']);
    }

    /**
    * @return CentroCusto|null
    */
    protected function getCentroCusto()
    {
        $em = $this->getDoctrine()->getManager();

        $filtro = $this->getRequest()->get('filter') ?: $this->admin->getDatagrid()->getValues();
        if (empty($filtro['centroCusto']['value'])) {
            return;
        }

        return $em->getRepository(CentroCusto::class)->findOneByCodCentro($filtro['centroCusto']['value']);
    }

    /**
    * @return array
    */
    protected function fetchCatalogoItens()
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(CatalogoItem::class)->createQueryBuilder('ci');

        $filtro = $this->getRequest()->get('filter');
        if (empty($filtro)) {
            return [];
        }

        $this->admin->applyFilters($qb, $filtro);

        return $qb->getQuery()->getResult();
    }
}
