<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Imobiliario\Permissao;
use Urbem\CoreBundle\Entity\Imobiliario\TipoLicenca;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Imobiliario\PermissaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PermissaoLicencasAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_licencas_permissao';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/licencas/permissao';

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $subquery = clone $query;
        $subquery->resetDQLPart('select');
        $subquery->resetDQLPart('from');
        $subquery->resetDQLPart('orderBy');

        $query->where(
            $query->expr()->in(
                'o.timestamp',
                $subquery->select('MAX(o2.timestamp) as timestamp')
                    ->from(Permissao::class, 'o2')
                    ->where('o.numcgm = o2.numcgm and o.codTipo = o2.codTipo')
                    ->groupBy('o2.codTipo', 'o2.numcgm')
                    ->getDQL()
            )
        );

        return $query;
    }


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('fkImobiliarioTipoLicenca', null, ['label' => 'label.imobiliarioLicencasPermissao.tipoLicenca'])
            ->add(
                'fkAdministracaoUsuario.fkSwCgm',
                'doctrine_orm_model_autocomplete',
                [
                    'label' => 'label.imobiliarioLicencasPermissao.usuario'
                ],
                'sonata_type_model_autocomplete',
                [
                    'callback' => function (AbstractAdmin $admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();

                        /** @var QueryBuilder|ProxyQueryInterface $qb */
                        $qb = $datagrid->getQuery();

                        $qb->leftJoin("{$qb->getRootAlias()}.fkSwCgmPessoaFisica", 'pf');
                        $qb->leftJoin("{$qb->getRootAlias()}.fkAdministracaoUsuario", 'u');
                        $qb->where('u.status = :status');
                        $qb->andWhere("{$qb->getRootAlias()}.numcgm != 0");
                        $qb->andWhere($qb->expr()->orX(
                            $qb->expr()->like("LOWER({$qb->getRootAlias()}.nomCgm)", ':parameter'),
                            $qb->expr()->eq("o.numcgm", ':numcgm'),
                            $qb->expr()->like("pf.cpf", ':parameter')
                        ));

                        $qb->setParameter('parameter', sprintf('%%%s%%', strtolower($value)));
                        $qb->setParameter('numcgm', (int) $value);
                        $qb->setParameter('status', 'A');

                        $datagrid->setValue($property, 'LIKE', $value);
                    },
                    'property' => 'nomCgm',
                    'to_string_callback' => function (SwCgm $cgm) {
                        return (string) $cgm;
                    }
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('numcgm', null, ['label' => 'cgm'])
            ->add('fkAdministracaoUsuario.fkSwCgm.nomCgm', null, ['label' => 'label.nome'])
            ->add('fkImobiliarioTipoLicenca', null, ['label' => 'label.imobiliarioLicencasPermissao.tipoLicenca'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig')
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = array();

        $fieldOptions['fkImobiliarioTipoLicenca'] = [
            'label' => 'label.imobiliarioLicencasPermissao.tipoLicenca',
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $fieldOptions['fkSwCgm'] = [
            'label' => 'label.imobiliarioLicencasPermissao.usuario',
            'class' => SwCgm::class,
            'req_params' => [],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term) {
                $qb = $er->createQueryBuilder('o');
                $qb->leftJoin('o.fkSwCgmPessoaFisica', 'pf');
                $qb->leftJoin('o.fkAdministracaoUsuario', 'u');
                $qb->where('u.status = :status');
                $qb->andWhere('o.numcgm != 0');
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->like('LOWER(o.nomCgm)', $qb->expr()->literal('%' . strtolower($term) . '%')),
                    $qb->expr()->eq('o.numcgm', ':numcgm'),
                    $qb->expr()->like('pf.cpf', $qb->expr()->literal($term . '%'))
                ));
                $qb->setParameter('numcgm', (int) $term);
                $qb->setParameter('status', 'A');
                $qb->orderBy('o.nomCgm', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => true,
        ];

        $formMapper
            ->with('label.imobiliarioLicencasPermissao.dados')
            ->add('fkImobiliarioTipoLicenca', null, $fieldOptions['fkImobiliarioTipoLicenca'])
            ->add('fkSwCgm', 'autocomplete', $fieldOptions['fkSwCgm'])
            ->end()
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param Permissao $permissao
     */
    public function validate(ErrorElement $errorElement, $permissao)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        /** @var SwCgm $swCgm */
        $swCgm = $this->getForm()->get('fkSwCgm')->getData();

        /** @var TipoLicenca $tipoLicenca */
        $tipoLicenca = $this->getForm()->get('fkImobiliarioTipoLicenca')->getData();

        /** @var  $permissao */
        $existe = $em->getRepository(Permissao::class)->findOneBy(
            array(
                'codTipo' => $tipoLicenca->getCodTipo(),
                'numcgm' => $swCgm->getNumcgm()
            )
        );

        if ($existe) {
            $message = $this->getTranslator()->trans('label.imobiliarioLicencasPermissao.usuarioExistente');
            $errorElement->with('fkSwCgm')->addViolation($message)->end();
        }
    }

    /**
     * @param Permissao $permissao
     */
    public function prePersist($permissao)
    {
        /** @var SwCgm $swCgm */
        $swCgm = $this->getForm()->get('fkSwCgm')->getData();

        $permissao->setFkImobiliarioTipoLicenca($this->getForm()->get('fkImobiliarioTipoLicenca')->getData());
        $permissao->setFkAdministracaoUsuario($swCgm->getFkAdministracaoUsuario());
    }

    /**
     * @param mixed $permissao
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function preRemove($permissao)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $permissoes = (new PermissaoModel($em))->verificarLicencas($permissao);

        $container = $this->getConfigurationPool()->getContainer();
        if ($permissoes) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.imobiliarioLicencasPermissao.erroExcluir'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }
    }

    /**
     * @param Permissao $permissao
     */
    public function postRemove($permissao)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        (new PermissaoModel($em))->removerPermissoes($permissao);
    }

    /**
     * @param Permissao $permissao
     * @return string
     */
    public function toString($permissao)
    {
        return ($permissao->getCodTipo())
            ? (string) $permissao
            : $this->getTranslator()->trans('label.imobiliarioLicencasPermissao.modulo');
    }
}
