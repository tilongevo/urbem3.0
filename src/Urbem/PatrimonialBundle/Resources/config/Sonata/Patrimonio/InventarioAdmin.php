<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Model\Orcamento\OrgaoModel;
use Urbem\CoreBundle\Model\Organograma\LocalModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Entity\Patrimonio;

use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\InventarioModel;

/**
 * Class InventarioAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio
 */
class InventarioAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_patrimonio_inventario';
    protected $baseRoutePattern = 'patrimonial/patrimonio/inventario';

    protected $includeJs = [
        'patrimonial/javascripts/patrimonio/inventario/init.js',
        'patrimonial/javascripts/patrimonio/inventario/local.js',
        'patrimonial/javascripts/patrimonio/inventario/historico-bem.js'
    ];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('processar_inventario', '{id}/processar-inventario');
        $collection->add('api_local', 'api/local/{cod_orgao}/{exercicio}/{id_inventario}');
        $collection->add('api_historico_bem', 'api/historico-bem/{cod_orgao}/{cod_local}');
        $collection->add('termo_abertura_inventario', '{id}/termo-abertura-inventario');
        $collection->add('termo_encerramento_inventario', '{id}/termo-encerramento-inventario');
        $collection->add('exportar_coletora_txt', 'exportar-coletora-txt');
        $collection->add('exportar_coletora', 'exportar-coletora');
    }

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->where('o.processado = false');
        return $query;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('idInventario', null, ['label' => 'label.inventarioPatrimonio.idInventario'])
            ->add('exercicio', null, ['label' => 'label.inventarioPatrimonio.exercicio'])
            ->add('dtInicio', 'doctrine_orm_callback', [
                'callback' => function ($queryBuilder, $alias, $field, $value) {
                    if (!$value['value']) {
                        return;
                    }

                    $date = $value['value']->format('Y-m-d');

                    $queryBuilder
                        ->andWhere("DATE({$alias}.dtInicio) = :dtInicio")
                        ->setParameter('dtInicio', $date);

                    return true;
                },
                'label' => 'label.inventarioPatrimonio.dtInicio',
            ], 'sonata_type_date_picker', [
                'format' => 'dd/MM/yyyy',
            ])
            ->add('observacao', null, ['label' => 'label.inventarioPatrimonio.observacao']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('idInventario', null, [
                'label' => 'label.inventarioPatrimonio.idInventario',
                'sortable' => false
            ])
            ->add('exercicio', null, ['label' => 'label.inventarioPatrimonio.exercicio'])
            ->add('dtInicio', null, ['label' => 'label.inventarioPatrimonio.dtInicio'])
            ->add('observacao', null, ['label' => 'label.inventarioPatrimonio.observacao']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $exercicio = $this->getExercicio();

        /** @var EntityManager $em */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['idInventario'] = [
            'attr' => ['readonly' => 'readonly'],
            'label' => 'label.inventarioPatrimonio.idInventario',
        ];

        $fieldOptions['exercicio'] = [
            'attr' => ['readonly' => 'readonly'],
            'label' => 'label.inventarioPatrimonio.exercicio',
        ];

        $fieldOptions['dtInicio'] = [
            'label' => 'label.inventarioPatrimonio.dtInicio',
            'format' => 'dd/MM/yyyy',
        ];

        $fieldOptions['observacao'] = [
            'label' => 'label.inventarioPatrimonio.observacao',
        ];

        $fieldOptions['numcgm'] = [];

        if (!$this->id($this->getSubject())) {
            $fieldOptions['idInventario']['data'] = (new InventarioModel($entityManager))
                ->getProximoId(" WHERE exercicio ='$exercicio' ");

            $fieldOptions['exercicio']['data'] = $exercicio;
            $fieldOptions['numcgm']['data'] = $this->getCurrentUser()->getFkSwCgm()->getNumcgm();
        }

        $formMapper
            ->add('numcgm', 'hidden', $fieldOptions['numcgm'])
            ->add('idInventario', 'text', $fieldOptions['idInventario'])
            ->add('exercicio', 'text', $fieldOptions['exercicio'])
            ->add('dtInicio', 'sonata_type_date_picker', $fieldOptions['dtInicio'])
            ->add('observacao', 'textarea', $fieldOptions['observacao']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        list($exercicio, $idInventario) = explode('~', $this->getAdminRequestId());

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $inventarioModel = new InventarioModel($entityManager);
        $localModel = new LocalModel($entityManager);

        $arInventario = [];

        $orgaos = $inventarioModel->getOrgaoBens(new \DateTime());
        foreach ($orgaos as $key => $orgao) {
            $countTotalBem = 0;
            $orgaos[$key]['totalBens'] = 0;
            $arInventario[$key]['cod_orgao'] = $orgao['cod_orgao'];
            $arInventario[$key]['descricao'] = $orgao['descricao'];
            $arInventario[$key]['cod_estrutural'] = $orgao['cod_estrutural'];

            $orgaoObject = $entityManager->getRepository(Orgao::class)->findOneBy(['codOrgao' => $orgao['cod_orgao']]);
            $locais = $localModel->getLocalInHistoricoBem($orgaoObject, $exercicio, $idInventario);

            foreach ($locais as $chave => $local) {
                $arInventario[$key]['local'][$chave]['cod_local'] = $local['cod_local'];
                $arInventario[$key]['local'][$chave]['descricao'] = $local['descricao'];
                $arInventario[$key]['local'][$chave]['total_bem'] = $local['total'];
                $countTotalBem += $local['total'];
            }
            $orgaos[$key]['totalBens'] = $countTotalBem;
        }
        $this->orgaobem = $orgaos;
        $this->exercicio = $exercicio;
        $this->idInventario = $idInventario;
    }

    /**
     * @param Patrimonio\Inventario $inventario
     */
    public function postPersist($inventario)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        (new InventarioModel($entityManager))
            ->cargaInventarioPatrimonio([
                'exercicio' => $inventario->getExercicio(),
                'idInventario' => $inventario->getIdInventario(),
                'numcgm' => $inventario->getNumcgm()
            ]);

        $inventarioObjKey = $this->id($inventario);
        $this->redirectByRoute(sprintf('%s_show', $this->baseRouteName), ['id' => $inventarioObjKey]);
    }
}
