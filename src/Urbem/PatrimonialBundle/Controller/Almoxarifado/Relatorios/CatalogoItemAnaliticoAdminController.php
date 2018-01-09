<?php
namespace Urbem\PatrimonialBundle\Controller\Almoxarifado\Relatorios;

use Datetime;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;

class CatalogoItemAnaliticoAdminController extends CRUDController
{
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
            'PatrimonialBundle::Almoxarifado/Relatorios/CatalogoItem/export_analitico.html.twig',
            [
                'modulo' => 'Patrimonial',
                'subModulo' => 'Almoxarifado',
                'funcao' => 'Relatorios',
                'nomRelatorio' => 'Relatório de Itens - Analítico',
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
                'filtro' => $request->get($request->get('uniqid')),
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

        $form = $this->admin->getForm();
        $form->handleRequest($this->getRequest());

        $qb->join(sprintf('%s.fkAdministracaoUnidadeMedida', $qb->getRootAlias()), 'um');
        $qb->join(sprintf('%s.fkAlmoxarifadoTipoItem', $qb->getRootAlias()), 'ti');
        $qb->join(sprintf('%s.fkAlmoxarifadoControleEstoque', $qb->getRootAlias()), 'ce');

        $this->admin->filterCategoria($qb, $qb->getRootAlias(), '', $form->get('categoria')->getData());
        $this->admin->filterPrioridade($qb, $qb->getRootAlias(), '', $form->get('prioridade')->getData());
        $this->admin->filterPeriodo($qb, $qb->getRootAlias(), '', $form->get('periodo')->getData(), $form->get('periodoInicial')->getViewData(), $form->get('periodoFinal')->getViewData());
        $this->admin->filterAlmoxarifado($qb, $qb->getRootAlias(), '', ['value' => $form->get('almoxarifado')->getViewData()]);
        $this->admin->filterCatalogo($qb, $qb->getRootAlias(), '', ['value' => $form->get('catalogo')->getViewData()]);
        $this->admin->filterCentroCusto($qb, $qb->getRootAlias(), '', ['value' => $form->get('centroCusto')->getViewData()]);

        $itens = array_diff_key($form->get('item')->getViewData() ?: [], ['_labels' => '']);
        $this->admin->filterItem($qb, $qb->getRootAlias(), '', ['value' => $itens]);

        $tipoItem = $form->get('tipoItem')->getData();
        $this->admin->filterTipoItem($qb, $qb->getRootAlias(), '', $tipoItem ? $tipoItem->getCodTipo() : null);

        $this->setOrderBy($qb, $form->get('agrupar')->getData());

        $qb->addSelect('um, ti, ce, lm, em, a, acgm, cclassificacao, c, cc');

        return $qb->getQuery()->getScalarResult();
    }

    /**
    * @param string $sortBy
    * @param string $sortOrder
    * @param QueryBuilder $qb
    * @return void
    */
    private function setOrderBy(QueryBuilder $qb, $sortBy, $sortOrder = 'ASC')
    {
        $admin = $this->admin;

        if (!in_array('lm', $qb->getAllAliases())) {
            $qb->leftJoin(sprintf('%s.fkAlmoxarifadoLancamentoMateriais', $qb->getRootAlias()), 'lm');
        }

        if (!in_array('em', $qb->getAllAliases())) {
            $qb->leftJoin('lm.fkAlmoxarifadoEstoqueMaterial', 'em');
        }

        if (!in_array('a', $qb->getAllAliases())) {
            $qb->leftJoin('em.fkAlmoxarifadoAlmoxarifado', 'a');
        }

        if (!in_array('acgm', $qb->getAllAliases())) {
            $qb->leftJoin('a.fkSwCgm', 'acgm');
        }

        if (!in_array('cclassificacao', $qb->getAllAliases())) {
            $qb->leftJoin(sprintf('%s.fkAlmoxarifadoCatalogoClassificacao', $qb->getRootAlias()), 'cclassificacao');
        }

        if (!in_array('c', $qb->getAllAliases())) {
            $qb->leftJoin('cclassificacao.fkAlmoxarifadoCatalogo', 'c');
        }

        if (!in_array('cc', $qb->getAllAliases())) {
            $qb->leftJoin('em.fkAlmoxarifadoCentroCusto', 'cc');
        }

        if ($sortBy == $admin::AGRUPAR_CENTRO_CUSTO) {
            $sortBy = 'cc.descricao';
        }

        if ($sortBy == $admin::AGRUPAR_CATALOGO) {
            $sortBy = 'c.descricao';
        }

        if ($sortBy == $admin::AGRUPAR_ALMOXARIFADO) {
            $sortBy = 'acgm.nomCgm';
        }

        if ($sortBy != $admin::AGRUPAR_ITEM) {
            $qb->addOrderBy($sortBy, $sortOrder);
        }

        $qb->addOrderBy('o.descricao', $sortOrder);
    }
}
