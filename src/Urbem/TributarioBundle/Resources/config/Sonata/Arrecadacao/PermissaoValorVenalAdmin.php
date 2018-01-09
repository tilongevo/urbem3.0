<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\Arrecadacao\PermissaoValorVenal;
use Urbem\CoreBundle\Entity\Administracao\Usuario;

class PermissaoValorVenalAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_movimentacoes_definir_permissao';
    protected $baseRoutePattern = 'tributario/arrecadacao/movimentacoes/definir-permissao';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $datagridMapper
            ->add(
                'fkSwCgm',
                'doctrine_orm_model_autocomplete',
                [
                    'label' => 'usuario'
                ],
                'sonata_type_model_autocomplete',
                [
                    'attr' => ['class' => 'select2-parameters '],
                    'callback' => function (AbstractSonataAdmin $admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();
                        /** @var QueryBuilder|ProxyQueryInterface $query */
                        $query = $datagrid->getQuery();

                        $subquery = clone $query;
                        $subquery->resetDQLPart('select');
                        $subquery->resetDQLPart('from');

                        $rootAlias = $query->getRootAlias();

                        $query->join(Usuario::class, "u", "WITH", "{$rootAlias}.numcgm = u.numcgm");

                        $query->andWhere($query->expr()->orX(
                            $query->expr()->eq("{$query->getRootAlias()}.numcgm", ':numcgm'),
                            $query->expr()->like("LOWER(o.nomCgm)", ':parameter')
                        ));

                        $query->andWhere(
                            $query->expr()->in(
                                "o.numcgm",
                                $subquery->select('pe.numcgm')
                                    ->from(PermissaoValorVenal::class, 'pe')
                                    ->getDQL()
                            )
                        );

                        $query->setParameter('parameter', sprintf('%%%s%%', strtolower($value)));
                        $query->setParameter('numcgm', (int) ($value));
                    },
                    'property' => 'nomCgm',
                ],
                [
                    'admin_code' => 'core.admin.filter.sw_cgm'
                ]
            )
        ;
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $repository = $em->getRepository('CoreBundle:Arrecadacao\PermissaoValorVenal');
        $permissaoValorVenal = $repository->findAll();

        $numCgmPermitidos = [];
        foreach ($permissaoValorVenal as $item) {
            $numCgmPermitidos[] = $item->getNumcgm();
        }

        $query = parent::createQuery($context);
        $query->andWhere($query->expr()->in("o.numcgm", $numCgmPermitidos));
        return $query;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add('numcgm', null, ['label' => 'label.arrecadacaoPermissaoValorVenal.numcgm'])
            ->add('fkSwCgm.nomCgm', null, ['label' => 'nome'])
            ->add('username', null, ['label' => 'label.usuario.username'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig')
                ),
                'header_style' => 'width: 20%'
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();

        $fieldOptions['fkAdministracaoUsuario'] = [
            'class' => Usuario::class,
            'attr' => ['class' => 'select2-parameters '],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                $qb = $repo->createQueryBuilder('o');
                $qb->join(SwCgm::class, 'swcgm', 'WITH', 'o.numcgm = swcgm.numcgm');
                $qb->where($qb->expr()->orX(
                    $qb->expr()->like('LOWER(swcgm.nomCgm)', ':nomCgm'),
                    $qb->expr()->eq('o.numcgm', ':numcgm')
                ));
                $qb->setParameters([
                    'nomCgm' => sprintf('%%%s%%', strtolower($term)),
                    'numcgm' => ((int) $term) ? $term: null
                ]);
                return $qb;
            },
            'label' => 'usuario',
            'required' => true,
            'mapped' => false,
        ];

        $formMapper
            ->with('label.arrecadacaoPermissaoValorVenal.dados')
                ->add('usuario', 'autocomplete', $fieldOptions['fkAdministracaoUsuario'], ['admin_code' => 'administrativo.admin.usuario'])
            ->end()
        ;
    }

    /**
     * @param $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();

        $permissaoValorVenal = $em
            ->getRepository(PermissaoValorVenal::class)
            ->findOneByNumcgm($this->getForm()->get('usuario')->getData()->getNumcgm())
        ;

        if (!$permissaoValorVenal) {
            $permissaoValorVenal = new PermissaoValorVenal();
            $permissaoValorVenal->setNumcgm($this->getForm()->get('usuario')->getData()->getNumcgm());

            $entityManager = $this->modelManager->getEntityManager(PermissaoValorVenal::class);
            $entityManager->persist($permissaoValorVenal);
            $entityManager->flush();

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.arrecadacaoPermissaoValorVenal.sucesso'));
        }

        $this->forceRedirect($this->generateUrl('list'));
    }

    /**
     * @param $object
     */
    public function preRemove($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();

        $permissaoValorVenal = $em->getRepository(PermissaoValorVenal::class)
            ->findOneByNumcgm($object->getNumcgm());

        if ($permissaoValorVenal) {
            $entityManager = $this->modelManager->getEntityManager(PermissaoValorVenal::class);
            $entityManager->remove($permissaoValorVenal);
            $entityManager->flush();
        }

        $this->forceRedirect($this->generateUrl('list'));
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('numcgm')
        ;
    }
}
