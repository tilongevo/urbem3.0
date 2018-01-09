<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao;

use Doctrine\ORM\EntityManager;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Administracao\Grupo;
use Urbem\CoreBundle\Entity\Administracao\GrupoUsuario;
use Urbem\CoreBundle\Model\Administracao\GrupoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class GrupoAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao
 */
class GrupoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_administrativo_administracao_grupo';
    protected $baseRoutePattern = 'administrativo/administracao/grupo';

    protected $defaultObjectId = 'codGrupo';

    protected $includeJs = [
        'administrativo/javascripts/administracao/grupo/permissoes.js',
        'administrativo/javascripts/administracao/grupo/form.js'
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('permissoes', $this->getRouterIdParameter() . '/permissoes');
        $collection->add('api_rotas_children', 'api/rotas/' . $this->getRouterIdParameter() . '/children');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nomGrupo', null, ['label' => 'label.grupo.nomGrupo',])
            ->add('ativo', 'doctrine_orm_callback', [
                'callback' => function (ProxyQuery $proxyQuery, $alias, $field, $data) {
                    if (is_null($data['value'])) {
                        return;
                    }

                    $proxyQuery
                        ->andWhere("{$alias}.{$field} = :status")
                        ->setParameter('status', $data['value']);
                },
                'label'    => 'label.grupo.ativo'
            ], 'choice', [
                'expanded' => true,
                'choices'  => [
                    'sim' => 1,
                    'nao' => 0
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', [
                'actions' => [
                    'show'       => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    'edit'       => ['template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'],
                    'permissoes' => ['template' => 'AdministrativoBundle:Sonata/Administracao/Grupo/CRUD:list__action_permissoes.html.twig'],
                    'delete'     => ['template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'],
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('nomGrupo', null, ['label' => 'label.grupo.nomGrupo',])
            ->add('descGrupo', null, ['label' => 'label.grupo.descGrupo',])
            ->add('ativo', null, ['label' => 'label.grupo.ativo',]);

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];

        $fieldOptions['nomGrupo'] = [
            'label' => 'label.grupo.nomGrupo',
        ];

        $fieldOptions['descGrupo'] = [
            'attr'  => ['maxlength' => 255],
            'label' => 'label.grupo.descGrupo',
        ];

        $fieldOptions['ativo'] = [
            'label'    => 'label.grupo.ativo',
            'required' => false
        ];

        $fieldOptions['grupoUsuario'] = [
            'attr'     => ['class' => 'select2-parameters '],
            'class'    => 'CoreBundle:Administracao\Usuario',
            'label'    => 'label.grupo.grupoUsuario',
            'multiple' => true
        ];

        $formMapper
            ->with('label.grupo.dadosGrupo')
                ->add('nomGrupo', 'text', $fieldOptions['nomGrupo'])
                ->add('descGrupo', 'textarea', $fieldOptions['descGrupo'])
                ->add('ativo', 'checkbox', $fieldOptions['ativo'])
            ->end()
            ->with('label.grupo.usuarios')
                ->add('fkAdministracaoGrupoUsuarios', 'sonata_type_collection', [
                    'by_reference' => true,
                    'label'        => false
                ], [
                    'edit'   => 'inline',
                    'inline' => 'table'
                ])
            ->end();
    }

    /**
     * @param Grupo $grupo
     */
    private function persistGrupoUsuarios(Grupo $grupo)
    {
        /** @var GrupoUsuario $fkAdministracaoGrupoUsuario */
        foreach ($grupo->getFkAdministracaoGrupoUsuarios() as $fkAdministracaoGrupoUsuario) {
            $fkAdministracaoGrupoUsuario->setFkAdministracaoGrupo($grupo);
        }
    }

    /**
     * @param Grupo $grupo
     */
    public function prePersist($grupo)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $codGrupo = (new GrupoModel($entityManager))->getNextCodGroup();

        $grupo->setCodGrupo($codGrupo);
        $this->persistGrupoUsuarios($grupo);
    }

    /**
     * @param Grupo $grupo
     *
     * @return Response
     */
    public function postPersist($grupo)
    {
        return $this->redirectByRoute($this->baseRouteName . '_permissoes', ['id' => $this->id($grupo)]);
    }

    /**
     * @param Grupo $grupo
     */
    public function preUpdate($grupo)
    {
        $this->persistGrupoUsuarios($grupo);
    }

    /**
     * @param Grupo $grupo
     *
     * @return Response
     */
    public function postUpdate($grupo)
    {
        return $this->redirectByRoute($this->baseRouteName . '_permissoes', ['id' => $this->id($grupo)]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $fieldOptions = [];

        $grupo = $this->getSubject();

        $users = [];

        foreach ($grupo->getFkAdministracaoGrupoUsuarios() as $teste) {
            $users[] = $teste->getFkAdministracaoUsuario();
        }

        $fieldOptions['nomGrupo'] = [
            'label' => 'label.grupo.nomGrupo',
        ];
        $fieldOptions['descGrupo'] = [
            'label' => 'label.grupo.descGrupo',
        ];
        $fieldOptions['ativo'] = [
            'label' => 'label.grupo.ativo',
        ];

        $fieldOptions['grupoUsuario'] = [
            'label' => 'label.grupo.grupoUsuario',
        ];

        $showMapper
            ->add('nomGrupo', null, $fieldOptions['nomGrupo'])
            ->add('descGrupo', null, $fieldOptions['descGrupo'])
            ->add('ativo', null, $fieldOptions['ativo'])
            ->add('fkAdministracaoGrupoUsuarios', 'entity', $fieldOptions['grupoUsuario'])
        ;
    }
}
