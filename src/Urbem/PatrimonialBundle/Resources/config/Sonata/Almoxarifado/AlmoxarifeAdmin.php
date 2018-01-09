<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;

use Urbem\CoreBundle\Entity\Administracao;
use Urbem\CoreBundle\Entity\Almoxarifado;

use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\AlmoxarifeModel;

/**
 * Class AlmoxarifeAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class AlmoxarifeAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_almoxarife';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/almoxarife';

    protected $model = Model\Patrimonial\Almoxarifado\AlmoxarifeModel::class;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('cgmAlmoxarife', 'doctrine_orm_callback', [
                'callback' => function (ProxyQuery $queryBuilder, $alias, $field, $data) {
                    if (!$data['value']) {
                        return;
                    }

                    /** @var Administracao\Usuario $usuario */
                    $usuario = $data['value'];

                    $queryBuilder
                        ->andWhere(sprintf('%s.cgmAlmoxarife = :cgmAlmoxarife', $alias))
                        ->setParameter('cgmAlmoxarife', $usuario->getNumcgm());

                    return true;
                },
                'label' => 'label.almoxarife.cgmAlmoxarife'
            ], 'entity', [
                'class' => Administracao\Usuario::class,
                'choice_label' => function (Administracao\Usuario $usuario) {
                    return strtoupper($usuario->getFkSwCgm()->getNomCgm());
                },
                'choice_value' => 'numcgm',
                'query_builder' => function (ORM\EntityRepository $repository) {
                    $almoxarifeJoinClause = 'almoxarife.cgmAlmoxarife = usuario.numcgm';

                    $queryBuilder = $repository->createQueryBuilder('usuario');
                    $queryBuilder
                        ->join(Almoxarifado\Almoxarife::class, 'almoxarife', 'WITH', $almoxarifeJoinClause);

                    return $queryBuilder;
                }
            ]);
    }

    /**
     * @param string|integer $cgmAlmoxarife
     * @return string
     */
    public function getCgmAlmoxarifeField($cgmAlmoxarife)
    {
        /** @var ORM\EntityManager $em */
        $em = $this->getModelManager()->getEntityManager($this->getClass());

        $almoxarifeModel = new AlmoxarifeModel($em);
        $usuario = $almoxarifeModel->getUsuarioByCgmAlmoxarife($cgmAlmoxarife);

        return $usuario->getFkSwCgm()->getNomCgm();
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('cgmAlmoxarife', null, [
                'label' => 'label.almoxarife.cgmAlmoxarife',
                'template' => 'PatrimonialBundle:Sonata/Almoxarifado/Almoxarife/CRUD:list__cgmAlmoxarife.html.twig'
            ])
            ->add('ativo', 'boolean', [
                'label' => 'Ativo',
                'sortable' => false
            ]);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var ORM\EntityManager $em */
        $em = $this->getModelManager()->getEntityManager($this->getClass());
        $objectId = $this->getAdminRequestId();

        /** @var Almoxarifado\Almoxarife $almoxarife */
        $almoxarife = $this->getSubject();

        $this->setBreadCrumb($objectId ? ['id' => $objectId] : []);
        $this->setIncludeJs(['/patrimonial/javascripts/almoxarifado/almoxarife.js']);

        $fieldOptions['ativo'] = [
            'required' => false
        ];

        if (is_null($almoxarife)) {
            $fieldOptions['cgmAlmoxarife'] = [
                'label' => 'label.almoxarife.cgmAlmoxarife',
                'class' => Administracao\Usuario::class,
                'data' => $almoxarife->getFkAdministracaoUsuario(),
                'multiple' => false,
                'route' => ['name' => 'urbem_administrativo_administracao_usuarios_search']
            ];
        } else {
            $fieldOptions['cgmAlmoxarife'] = [
                'label' => 'label.almoxarife.cgmAlmoxarife',
                'class' => Administracao\Usuario::class,
                'data' => $almoxarife->getFkAdministracaoUsuario(),
                'route' => ['name' => 'urbem_administrativo_administracao_usuarios_search']
            ];
        }

        $fieldCgmAlmoxarifeType = (!is_null($almoxarife)) ? 'text' : 'autocomplete';

        $formMapper
            ->with('label.almoxarife.dados')
            ->add('fkAdministracaoUsuario', 'autocomplete', $fieldOptions['cgmAlmoxarife'], ['admin_code' => 'administrativo.admin.usuario'])
            ->add('ativo', 'checkbox', $fieldOptions['ativo'])
            ->end()
            ->with('label.almoxarife.permissao')
            ->add('fkAlmoxarifadoPermissaoAlmoxarifados', 'sonata_type_collection', [
                'by_reference' => false,
                'label' => false
            ], [
                'edit' => 'inline',
                'inline' => 'table'
            ])
            ->end();
    }

    /**
     * @param ErrorElement $errorElement
     * @param Almoxarifado\Almoxarife $almoxarife
     */
    public function validate(ErrorElement $errorElement, $almoxarife)
    {
        /** @var ORM\EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $oldAlmoxarife = $em->getRepository(Almoxarifado\Almoxarife::class)->findOneBy(
            [
                'cgmAlmoxarife' => $almoxarife->getFkAdministracaoUsuario()->getNumcgm()
            ]
        );

        if (is_null($almoxarife->getCgmAlmoxarife())) {
            $message = sprintf('Obrigatório a seleção do almoxarife');
            $errorElement->with('cgmAlmoxarife')->addViolation($message)->end();
        }
        $route = $this->getRequest()->get('_sonata_name');

        if (!is_null($oldAlmoxarife) && strpos($route, '_edit') === false) {
            $message = sprintf('Almoxarife %s - já está cadastrado!', $almoxarife->getCgmAlmoxarife());
            $errorElement->with('cgmAlmoxarife')->addViolation($message)->end();
        }

        $duplicado = false;

        /** @var Almoxarifado\PermissaoAlmoxarifados $permissaoAlmoxarifado */
        foreach ($almoxarife->getFkAlmoxarifadoPermissaoAlmoxarifados() as $permissaoAlmoxarifado) {
            $fkAlmoxarifadoPermissaoAlmoxarifados = clone $almoxarife->getFkAlmoxarifadoPermissaoAlmoxarifados();
            $fkAlmoxarifadoPermissaoAlmoxarifados->removeElement($permissaoAlmoxarifado);

            /** @var Almoxarifado\PermissaoAlmoxarifados $clonedPermissaoAlmoxarifado */
            foreach ($fkAlmoxarifadoPermissaoAlmoxarifados as $clonedPermissaoAlmoxarifado) {
                if ($permissaoAlmoxarifado->getCodAlmoxarifado() == $clonedPermissaoAlmoxarifado->getCodAlmoxarifado()) {
                    $duplicado = true;
                }
            }

            unset($fkAlmoxarifadoPermissaoAlmoxarifados);
        }

        if ($duplicado) {
            $message = "Almoxarifados duplicados!";
            $errorElement->with('fkAlmoxarifadoPermissaoAlmoxarifados')->addViolation($message)->end();
        }
    }

    /**
     * @param Almoxarifado\Almoxarife $almoxarife
     */
    public function prePersist($almoxarife)
    {
        $this->checkSelectedDeleteInListCollecion(
            $almoxarife,
            'fkAlmoxarifadoPermissaoAlmoxarifados',
            'setFkAlmoxarifadoAlmoxarife'
        );
        /** @var Almoxarifado\PermissaoAlmoxarifados $permissaoAlmoxarifado */
        foreach ($almoxarife->getFkAlmoxarifadoPermissaoAlmoxarifados() as $permissaoAlmoxarifado) {
            $permissaoAlmoxarifado->setFkAlmoxarifadoAlmoxarife($almoxarife);
        }
    }

    /**
     * @param Almoxarifado\Almoxarife $almoxarife
     */
    public function preUpdate($almoxarife)
    {
        $this->checkSelectedDeleteInListCollecion(
            $almoxarife,
            'fkAlmoxarifadoPermissaoAlmoxarifados',
            'setFkAlmoxarifadoAlmoxarife'
        );
        /** @var Almoxarifado\PermissaoAlmoxarifados $permissaoAlmoxarifado */
        foreach ($almoxarife->getFkAlmoxarifadoPermissaoAlmoxarifados() as $permissaoAlmoxarifado) {
            $permissaoAlmoxarifado->setFkAlmoxarifadoAlmoxarife($almoxarife);
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $objectId = $this->getAdminRequestId();
        $this->setBreadCrumb(['id' => $objectId]);

        /** @var ORM\EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var Almoxarifado\Almoxarife $almoxarife */
        $almoxarife = $this->getSubject();

        $cgmAlmoxarife = $this->getCgmAlmoxarifeField($almoxarife->getCgmAlmoxarife());
        $almoxarife->nomCgmAlmoxarife = $cgmAlmoxarife;
        $this->data['fkAlmoxarifadoPermissaoAlmoxarifados'] = $almoxarife->getFkAlmoxarifadoPermissaoAlmoxarifados();
        $showMapper
            ->with('label.almoxarife.dados')
            ->add('nomCgmAlmoxarife', null, [
                'label' => 'label.almoxarife.cgmAlmoxarife'
            ])
            ->add('ativo', 'boolean', [
                'label' => 'Ativo',
                'sortable' => false
            ])
            ->add('fkAlmoxarifadoPermissaoAlmoxarifados', null, [
                'label' => 'label.almoxarife.permissao',
                'template' => 'PatrimonialBundle:Almoxarifado\Almoxarife:permissaoAlmoxarifado.html.twig'
            ])
            ->end();
    }
}
