<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\NaturezaLancamentoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class SaidaEstornoEntradaAdmin
 */
class SaidaEstornoEntradaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_saida_estorno';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/saida-estorno';

    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'numLancamento'
    ];

    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['show', 'list']);
    }

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $exercicio = $this->getExercicio();
        $filter = $this->request->get('filter');

        $proxyQuery = parent::createQuery($context);

        if (false == is_null($filter)) {
            if (false == empty($filter['exercicio']['value'])) {
                $exercicio = $filter['exercicio']['value'];
            }
        }

        $proxyQuery = (new NaturezaLancamentoModel($entityManager))
            ->findListaEntradasValidasEstorno($proxyQuery, $exercicio);

        return $proxyQuery;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();

        $filter = $this->getDatagrid()->getValues();

        if (false == empty($filter['exercicio']['value'])) {
            $exercicio = $filter['exercicio']['value'];
        }

        $datagridMapper
            ->add('numLancamento', null, [
                'label' => 'label.saidaEstorno.numLancamento',
            ])
            ->add('exercicio', 'doctrine_orm_callback', [
                'callback' => [$this, 'searchFilter']
            ], null, [
                'attr' => ['value' => $exercicio],
                'data' => $exercicio
            ])
            ->add('timestamp', 'doctrine_orm_callback', [
                'callback' => [$this, 'searchFilter'],
                'label' => 'label.saidaEstorno.dtLancamento'
            ], 'sonata_type_date_picker', [
                'format' => 'dd/MM/yyyy'
            ])
        ;
    }

    /**
     * @param ProxyQuery $proxyQuery
     * @param string     $alias
     * @param string     $field
     * @param array      $data
     * @return void|boolean
     */
    public function searchFilter(ProxyQuery $proxyQuery, $alias, $field, array $data)
    {
        if (!$data['value']) {
            return;
        }

        $filter = $this->getDatagrid()->getValues();

        if (false == empty($filter['exercicio']['value'])) {
            $proxyQuery
                ->andWhere("{$alias}.exercicioLancamento = :exercicio")
                ->setParameter('exercicio', $filter['exercicio']['value']);
        }

        if (false == empty($filter['timestamp']['value'])) {
            $timestamp = \DateTime::createFromFormat('d/m/Y', $filter['timestamp']['value']);

            $proxyQuery
                ->andWhere("DATE({$alias}.timestamp) = :timestamp")
                ->setParameter('timestamp', $timestamp);
        }
    }

    /**
     * @param NaturezaLancamento $naturezaLancamento
     */
    public function configureCustomData(NaturezaLancamento $naturezaLancamento)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $aditionalInfo = (new NaturezaLancamentoModel($entityManager))
            ->findEntradaValidaEstorno($naturezaLancamento);

        $naturezaLancamento->fkAlmoxarifadoAlmoxarifado =
            $this->modelManager->find(Almoxarifado::class, $aditionalInfo['cod_almoxarifado']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $saidaEstornoTemplatePath = "PatrimonialBundle:Sonata/Almoxarifado/SaidaEstorno/CRUD:";

        $numLancamentoTemplate = $saidaEstornoTemplatePath . "list__numLancamento.html.twig";
        $timestampTemplate = $saidaEstornoTemplatePath . "list__timestamp.html.twig";
        $customAlmoxarifadoTemplate = $saidaEstornoTemplatePath . "list__customAlmoxarifado.html.twig";
        $customAlmoxarifeTemplate = $saidaEstornoTemplatePath . "list__customAlmoxarife.html.twig";

        $listMapper
            ->add('numLancamento', null, [
                'label' => 'label.saidaEstorno.codigo',
                'template' => $numLancamentoTemplate
            ])
            ->add('exercicioLancamento')
            ->add('timestamp', null, [
                'format' => 'd/m/Y',
                'label' => 'label.saidaEstorno.data',
                'template' => $timestampTemplate
            ])
            ->add('customAlmoxarifado', 'text', [
                'label' => 'label.saidaEstorno.almoxarifado',
                'template' => $customAlmoxarifadoTemplate
            ])
            ->add('customAlmoxarife', 'text', [
                'label' => 'label.saidaEstorno.almoxarife',
                'template' => $customAlmoxarifeTemplate
            ])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        /** @var NaturezaLancamento $naturezaLancamento */
        $naturezaLancamento = $this->getSubject();

        $naturezaLancamento->nomAlmorifado =
            $this->configureCustomData($naturezaLancamento, 'nom_almoxarifado');
        $naturezaLancamento->nomAlmoxarife =
            $this->configureCustomData($naturezaLancamento, 'nom_almoxarife');

        $naturezaLancamento->itensEntrada = (new NaturezaLancamentoModel($entityManager))->getItensEntrada([
            'exercicio' => $naturezaLancamento->getExercicioLancamento(),
            'numLancamento' => $naturezaLancamento->getNumLancamento(),
            'codNatureza' => $naturezaLancamento->getCodNatureza(),
            'tipoNatureza' => $naturezaLancamento->getTipoNatureza()
        ]);
    }
}
