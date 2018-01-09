<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Beneficio;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor;
use Urbem\CoreBundle\Entity\Compras\Fornecedor;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class LayoutFornecedorAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_beneficio_layout_fornecedor';

    protected $baseRoutePattern = 'recursos-humanos/beneficio/layout-fornecedor';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'cgmFornecedor',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.layoutfornecedor.fornecedor_plano'
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Beneficio\LayoutFornecedor',
                    'choice_label' => 'fkComprasFornecedor.fkSwCgm.nomCgm',
                )
            )
            ->add(
                'codLayout',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.layoutfornecedor.layout_importacao'
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Beneficio\LayoutPlanoSaude',
                    'choice_label' => 'padrao',
                )
            );
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        if ($filter['cgmFornecedor']['value'] != '') {
            $queryBuilder->andWhere("{$alias}.cgmFornecedor = :cgmFornecedor");
            $queryBuilder->setParameter("cgmFornecedor", $filter['cgmFornecedor']['value']);
        }
        if ($filter['codLayout']['value'] != '') {
            $queryBuilder->andWhere("{$alias}.codLayout = :codLayout");
            $queryBuilder->setParameter("codLayout", $filter['codLayout']['value']);
        }

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $listMapper
            ->add(
                'fkComprasFornecedor.fkSwCgm.nomCgm',
                null,
                array(
                    'label' => 'label.layoutfornecedor.fornecedor_plano',
                )
            )
            ->add(
                'fkBeneficioLayoutPlanoSaude.padrao',
                null,
                array(
                    'label' => 'label.layoutfornecedor.layout_importacao',
                )
            )
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                ]
            ]);
    }

    /**
     * @param LayoutFornecedor $layoutFornecedor
     */
    public function prePersist($layoutFornecedor)
    {
        $form = $this->getForm();
        $cgmFornecedor = $form->get('cgmFornecedor')->getData();
        $codLayout = $form->get('codLayout')->getData();

        $layoutFornecedor->setCgmFornecedor($cgmFornecedor->getCgmFornecedor());
        $layoutFornecedor->setCodLayout($codLayout->getCodLayout());
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\Fornecedor');
        /** @var LayoutFornecedor $layoutFornecedores */
        $layoutFornecedores = $entityManager->getRepository("CoreBundle:Beneficio\LayoutFornecedor")->findAll();
        $fornecedoresArray = [];
        /** @var LayoutFornecedor $layoutFornecedor */
        foreach ($layoutFornecedores as $layoutFornecedor) {
            $fornecedoresArray[] = $layoutFornecedor->getCgmFornecedor();
        }

        $fornecedoresArray = empty($fornecedoresArray) ? 0 : $fornecedoresArray;

        $fieldOptions['cgmFornecedor'] = [
            'class' => Fornecedor::class,
            'label' => 'label.layoutfornecedor.fornecedor_plano',
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) use ($fornecedoresArray, $entityManager) {
                $queryBuilder = $repo->createQueryBuilder('fornecedor');
                $subqb = $entityManager->getRepository('CoreBundle:SwCgm')
                    ->createQueryBuilder('swCgm')
                    ->select('swCgm.numcgm')
                    ->where('swCgm.numcgm IN (' . implode(',', $fornecedoresArray) . ')');
                $qb = $repo->createQueryBuilder('f')
                    ->join('f.fkSwCgm', 'cgm')
                    ->join('cgm.fkSwCgmPessoaJuridica', 'pj')
                    ->where('lower(cgm.nomCgm) like :term')
                    ->orWhere('lower(pj.nomFantasia) like :term')
                    ->andWhere($queryBuilder->expr()->notIn('cgm.numcgm', $subqb->getDQL()))
                    ->setParameter('term', strtolower("%{$term}%"));

                if (is_numeric($term)) {
                    $qb->orWhere('pj.numcgm = :numcgm')
                        ->setParameter('numcgm', (int) $term);
                }

                return $qb;
            },
            'multiple' => false,
            'required' => true,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ],
        ];

        $fieldOptions['codLayout'] = [
            'class' => 'CoreBundle:Beneficio\LayoutPlanoSaude',
            'choice_label' => 'padrao',
            'label' => 'label.layoutfornecedor.layout_importacao',
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        if (!is_null($id)) {
            $codLayout = $this->getSubject()->getFkBeneficioLayoutPlanoSaude();
            $cgmFornecedor = $this->getSubject()->getFkComprasFornecedor();

            $fieldOptions['cgmFornecedor']['data'] = $cgmFornecedor;
            $fieldOptions['codLayout']['data'] = $codLayout;
        }

        $formMapper
            ->with('label.layoutfornecedor.layout_importacao_plano_saude')
            ->add('fkComprasFornecedor', 'autocomplete', $fieldOptions['cgmFornecedor'], ['admin_code' => 'patrimonial.admin.fornecedor'])
            ->add('codLayout', 'entity', $fieldOptions['codLayout'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $showMapper
            ->with('label.layoutfornecedor.layout_importacao_plano_saude')
            ->add('cgmFornecedor.cgmFornecedor.nomCgm', null, array(
                'label' => 'label.layoutfornecedor.fornecedor_plano',
            ))
            ->add('codLayout', 'entity', array(
                'label' => 'label.layoutfornecedor.layout_importacao',
            ))
            ->end();
    }
}
