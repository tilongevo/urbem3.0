<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class SaldoDotacaoViewAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_saldodotacao';
    protected $baseRoutePattern = 'financeiro/orcamento/dotacao/saldo-dotacao';
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;
    private $exercicioQuery;

    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->remove('batch');
        $routeCollection->remove('export');
    }

    public function createQuery($context = 'list')
    {
        $parameters = $this->getFilterParameters();
        $exercicio = $this->getExercicio();
        if (array_key_exists("exercicio", $parameters) && !empty($parameters['exercicio']['value'])) {
            $exercicio = $parameters['exercicio']['value'];
        }
        $this->exercicioQuery = $exercicio;

        $qb = parent::createQuery($context);
        $qb->where(sprintf("o.exercicio='%s'", $exercicio));

        return $qb;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $recursoDiretoRepository = $entityManager->getRepository('CoreBundle:Orcamento\RecursoDireto');
        $recursosDiretos = ArrayHelper::parseArrayToChoice($recursoDiretoRepository->findByUniqueRecursoDireto(), 'recurso', 'cod_recurso');

        $entidadeModel = new Model\Orcamento\EntidadeModel($entityManager);
        $entidades = ArrayHelper::parseArrayToChoice($entidadeModel->getEntidades($this->getExercicio()), 'entidade', 'cod_entidade');

        $datagridMapper
            ->add(
                'codEntidade',
                'doctrine_orm_callback',
                [
                    'callback' => array($this, 'getFilter'),
                    'label' => 'label.saldoDotacao.entidade'
                ],
                'choice',
                [
                    'choices' => $entidades
                ]
            )
            ->add(
                'descricao',
                'doctrine_orm_callback',
                [
                    'callback' => array($this, 'getFilter'),
                    'label' => 'label.saldoDotacao.descricao'
                ]
            )
            ->add(
                'nomRecurso',
                'doctrine_orm_callback',
                [
                    'callback' => array($this, 'getFilter'),
                    'label' => 'label.saldoDotacao.recurso'
                ],
                'choice',
                [
                    'choices' => $recursosDiretos
                ]
            )
            ->add(
                'exercicio',
                null,
                [
                    'label' => 'label.saldoDotacao.exercicio',
                ],
                'text',
                [
                    'attr' => [
                        'value' => $this->exercicioQuery
                    ]
                ]
            )
        ;
    }

    public function getFilter($queryBuilder, $alias, $field, $value)
    {
        if (empty($value['value'])) {
            return;
        }
        $valorBusca = $value['value'];

        $ors = [];
        if ($field == "nomRecurso" && isset($value['value']) && !empty($value['value'])) {
            $ors[] = $queryBuilder->expr()->orx($alias . '.codRecurso = ' . $queryBuilder->expr()->literal($valorBusca));
        }

        if ($field == "codEntidade" && isset($value['value']) && !empty($value['value'])) {
            $ors[] = $queryBuilder->expr()->orx($alias . '.codEntidade = ' . $queryBuilder->expr()->literal($valorBusca));
        }

        if ($field == "descricao" && isset($value['value']) && !empty($value['value'])) {
            $ors[] = $queryBuilder->expr()->like('lower('.$alias.'.descricao)', $queryBuilder->expr()->literal('%' . $valorBusca . '%'));
        }

        $queryBuilder->andWhere(join(' OR ', $ors));
        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $this->addActionsGrid($listMapper);

        $listMapper
            ->add('rowNumber', null, ['label' => '#'])
            ->add('codEntidade', null, ['label' => 'label.saldoDotacao.entidade'])
            ->add('codDespesa', null, ['label' => 'label.saldoDotacao.reduzido'])
            ->add('descricao', null, ['label' => 'label.saldoDotacao.descricao'])
            ->add('numOrgaoNumEntidade', null, ['label' => 'label.saldoDotacao.orgaoUnidade'])
            ->add('saldoDisponivel', null, [
                'label' => 'label.saldoDotacao.saldoDisponivel'
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
            ->with('label.saldoDotacao.dadosDotacao')
                ->add('getEntidadeComposto', null, ['label' => 'label.saldoDotacao.entidade'])
                ->add('getDotacaoComposto', null, ['label' => 'label.saldoDotacao.dotacao'])
                ->add('getOrgaoComposto', null, ['label' => 'label.saldoDotacao.orgao'])
                ->add('getUnidadeComposto', null, ['label' => 'label.saldoDotacao.unidade'])
                ->add('getFuncaoComposto', null, ['label' => 'label.saldoDotacao.funcao'])
                ->add('getSubfuncaoComposto', null, ['label' => 'label.saldoDotacao.subfuncao'])
                ->add('getProgramaComposto', null, ['label' => 'label.saldoDotacao.programa'])
                ->add('getPaoComposto', null, ['label' => 'label.saldoDotacao.pao'])
                ->add('codEstrutural', null, ['label' => 'label.saldoDotacao.desdobramento'])
                ->add('getRecursoComposto', null, ['label' => 'label.saldoDotacao.recurso'])
            ->end()
            ->with("label.saldoDotacao.saldos")
                ->add('valorOrcado', null, ['label' => 'label.saldoDotacao.valorOrcado'])
                ->add('valorSuplementado', null, ['label' => 'label.saldoDotacao.valorSuplementado'])
                ->add('valorReduzido', null, ['label' => 'label.saldoDotacao.valorReduzido'])
                ->add('valorEmpenhado', null, ['label' => 'label.saldoDotacao.valorEmpenhado'])
                ->add('valorAnulado', null, ['label' => 'label.saldoDotacao.valorAnulado'])
                ->add('valorLiquidado', null, ['label' => 'label.saldoDotacao.valorLiquidacao'])
                ->add('valorPago', null, ['label' => 'label.saldoDotacao.valorPago'])
                ->add('valorReserva', null, ['label' => 'label.saldoDotacao.valorReserva'])
                ->add('saldoDisponivel', null, ['label' => 'label.saldoDotacao.saldoDisponivel'])
            ->end()
        ;
    }
}
