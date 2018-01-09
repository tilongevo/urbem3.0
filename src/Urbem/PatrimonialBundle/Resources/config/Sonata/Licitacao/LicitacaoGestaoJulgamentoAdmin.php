<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Model;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LicitacaoGestaoJulgamentoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_gestao_julgamento';
    protected $baseRoutePattern = 'patrimonial/licitacao/gestao-julgamento';
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;

    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->remove('batch');
        $routeCollection->remove('export');
    }

    public function createQuery($context = 'list')
    {
        $ids = [0];
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $liticacoesSemjulgamentoPropostas = $entityManager
            ->getRepository('CoreBundle:Licitacao\Licitacao')
            ->findLicitacaoSemJulgamentoPropostas($this->getExercicio());
        $ids = [0];
        if (!empty($liticacoesSemjulgamentoPropostas)) {
            $ids = array_column($liticacoesSemjulgamentoPropostas, 'cod_licitacao');
        }

        $qb = parent::createQuery($context);
        $qb->where(sprintf('o.codLicitacao IN (%s)', implode(",", $ids)));

        return $qb;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $exercicio = $this->getExercicio();
        $datagridMapper
            ->add('codLicitacao', null, [
                'label' => 'Licitação'
            ])
            ->add('exercicio', null, [], null, [])
            ->add('codEntidade', null, [
                'label' => 'label.comprasDireta.codEntidade',
                'admin_code' => 'financeiro.admin.entidade',
                'choice_label' => 'numcgm.nomCgm',
                'query_builder' => function (EntityRepository $entityManager) use ($exercicio) {
                    $qb = $entityManager->createQueryBuilder('entidade');
                    $result = $qb->where('entidade.exercicio = :exercicio')
                        ->setParameter(':exercicio', $exercicio);

                    return $result;
                },
                'placeholder' => 'label.selecione'
            ])
            ->add('codModalidade', null, [
                'label' => 'label.comprasDireta.codModalidade',
                'choice_label' => 'descricao',
                'placeholder' => 'label.selecione'
            ])
            ->add('registroPrecos');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $this->addActionsGrid($listMapper);

        $listMapper
            ->add('licitacaoExercicio', null, [
                'label' => 'Licitação'
            ])
            ->add('codEntidade', null, [
                'associated_property' => function (Entity\Orcamento\Entidade $entidade) {
                    return "{$entidade->getCodEntidade()} - {$entidade->getNumcgm()->getNomCgm()}";
                },
                'label' => 'label.patrimonial.licitacao.entidade',
                'admin_code' => 'financeiro.admin.entidade'
            ])
            ->add('codProcesso', null, [
                'associated_property' => function (Entity\SwProcesso $processo) {
                    return "{$processo->getCodProcesso()} - {$processo->getAnoExercicio()} - {$processo->getCodAssunto()}";
                },
                'label' => 'label.comprasDireta.codProcesso',
                'admin_code' => 'administrativo.admin.processo'
            ])
            ->add('codModalidade', null, [
                'associated_property' => function (Entity\Compras\Modalidade $modalidade) {
                    return "{$modalidade->getCodModalidade()} - {$modalidade->getDescricao()}";
                },
                'label' => 'label.comprasDireta.codModalidade'
            ])
            ->add('vlCotado', null, ['label' => 'label.patrimonial.licitacao.vlCotado'])
            ->add('registroPrecos', null, [
                'label' => 'Registro preços',
            ])
            ->remove('_action')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                )
            ));
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with("Licitação")
                ->add('licitacaoExercicio', null, [
                    'label' => 'Cód. licitação'
                ])
                ->add('exercicio', null, [])
                ->add('exercicioMapa', null, [])
                ->add('exercicioProcesso')
                ->add('vlCotado', null, ['label' => 'label.patrimonial.licitacao.vlCotado'])
                ->add('timestamp', null, [
                    'format' => 'd/m/Y',
                    'label' => 'label.comprasDireta.timestamp'
                ])
                ->add('registroPrecos', null, [])
            ->end();
    }

    /**
     * @param Entity\Compras\CompraDireta $object
     */
    public function preRemove($object)
    {
        /** @var Entity\Compras\Cotacao $cotacao */
        $cotacao = $object->getFkComprasMapa()->getFkComprasMapaCotacoes()->first()->getFkComprasCotacao();
        $codCotacao = $cotacao->getCodCotacao();
        $exercicio = $cotacao->getExercicio();

        $container = $this->getConfigurationPool()->getContainer();
        $em = $this->modelManager->getEntityManager($this->getClass());

        try {
            $em->getConnection()->beginTransaction();
            $compraDiretaModel = new Model\Patrimonial\Compras\CompraDiretaModel($em);
            $compraDiretaModel->deleteJulgamentoCompraDireta($codCotacao, $exercicio);

            $container->get('session')->getFlashBag()->add('success', 'O item foi removido.');
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', 'Erro ao Excluir o item selecionado: ' . $e->getMessage());
            $em->getConnection()->rollback();
        }

        (new RedirectResponse("/patrimonial/licitacao/gestao-julgamento/list"))->send();
        exit;
    }
}
