<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;

use Urbem\CoreBundle\Model\Administracao\AuditoriaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class AuditoriaAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao
 */
class AuditoriaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_administracao_auditoria';
    protected $baseRoutePattern = 'administrativo/administracao/auditoria';

    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;

    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by'    => 'id',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->clearExcept(['show', 'list']);
    }

    /**
     * @param array  $arr
     * @param string $columnName
     *
     * @return array
     */
    private function generateChoiceArray(array $arr, $columnName)
    {
        $filteredArray = array_map(function ($item) use ($columnName) {
            return $item[$columnName];
        }, $arr);

        return array_combine($filteredArray, $filteredArray);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $auditoriaModel = new AuditoriaModel($entityManager);

        $usuarios = $auditoriaModel->getValuesGroupedBy('nomcgm');
        $modulos = $auditoriaModel->getValuesGroupedBy('modulo');
        $submodulos = $auditoriaModel->getValuesGroupedBy('submodulo');
        $entidades = $auditoriaModel->getValuesGroupedBy('entidade');
        $tipos = $auditoriaModel->getValuesGroupedBy('tipo');

        $datagridMapper
            ->add('nomcgm', null, [
                'label' => 'usuario'
            ], 'choice', [
                'choices'     => $this->generateChoiceArray($usuarios, 'nomcgm'),
                'placeholder' => 'label.selecione'
            ])
            ->add('ip', null, [
                'label' => 'label.auditoria.ip'
            ], null, [
                'attr' => ['data-mask' => '099.099.099.099']
            ])
            ->add('rota', null, [
                'label' => 'label.auditoria.url'
            ])
            ->add('modulo', null, [
                'label' => 'label.auditoria.modulo'
            ], 'choice', [
                'choices'     => $this->generateChoiceArray($modulos, 'modulo'),
                'placeholder' => 'label.selecione'
            ])
            ->add('submodulo', null, [
                'label' => 'label.auditoria.submodulo'
            ], 'choice', [
                'choices'     => $this->generateChoiceArray($submodulos, 'submodulo'),
                'placeholder' => 'label.selecione'
            ])
            ->add('entidade', null, [
                'label' => 'label.auditoria.entidade'
            ], 'choice', [
                'choices'     => $this->generateChoiceArray($entidades, 'entidade'),
                'placeholder' => 'label.selecione'
            ])
            ->add('createdAt', 'doctrine_orm_callback', [
                'label' => 'label.auditoria.createAt',
                'callback' => function ($queryBuilder, $alias, $field, $data) {
                    if (!$data['value']) {
                        return;
                    }

                    $date = $data['value']->format('Y-m-d');

                    $queryBuilder
                        ->andWhere("DATE({$alias}.createdAt) = :createdAt")
                        ->setParameter('createdAt', $date);

                    return true;
                },
            ], 'sonata_type_date_picker', [
                'format' => 'dd/MM/yyyy'
            ])
            ->add('tipo', null, [
                'label' => 'label.auditoria.tipo'
            ], 'choice', [
                'choices'     => $this->generateChoiceArray($tipos, 'tipo'),
                'placeholder' => 'label.selecione'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('nomcgm', null, [
                'label' => 'usuario'
            ])
            ->add('ip', null, [
                'label' => 'label.auditoria.ip'
            ])
            ->add('rota', null, [
                'label' => 'label.auditoria.url'
            ])
            ->add('modulo', null, [
                'label' => 'label.auditoria.modulo'
            ])
            ->add('submodulo', null, [
                'label' => 'label.auditoria.submodulo'
            ])
            ->add('entidade', null, [
                'label' => 'label.auditoria.entidade'
            ])
            ->add('createdAt', 'date', [
                'label' => 'label.auditoria.createAt',
                'format' => 'd/m/Y H:i:s'
            ])
            ->add('tipo', null, [
                'label' => 'label.auditoria.tipo'
            ]);

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('nomcgm', null, [
                'label' => 'usuario'
            ])
            ->add('ip', null, [
                'label' => 'label.auditoria.ip'
            ])
            ->add('rota', null, [
                'label' => 'label.auditoria.url'
            ])
            ->add('modulo', null, [
                'label' => 'label.auditoria.modulo'
            ])
            ->add('submodulo', null, [
                'label' => 'label.auditoria.submodulo'
            ])
            ->add('entidade', null, [
                'label' => 'label.auditoria.entidade'
            ])
            ->add('createdAt', 'date', [
                'label' => 'label.auditoria.createAt',
                'format' => 'd/m/Y H:i:s'
            ])
            ->add('conteudo', null, [
                'label' => 'label.auditoria.conteudo'
            ])
            ->add('tipo', null, [
                'label' => 'label.auditoria.tipo'
            ]);
    }
}
