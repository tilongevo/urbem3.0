<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Diarias;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Diarias\TipoDiariaDespesa;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Model\Diarias\TipoDiariaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class TipoDiariaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_diarias_tipo_diaria';
    protected $baseRoutePattern = 'recursos-humanos/diarias/tipo-diaria';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(['timestamp']);

        $datagridMapper
            ->add('nomTipo', null, ['label' => 'label.tipodiaria.nomTipo'])
            ->add('valor', null, ['label' => 'label.tipodiaria.valor'], null, ['attr' => ['class' => 'money ']])
            ->add(
                'vigencia',
                'doctrine_orm_callback',
                [
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.tipodiaria.vigencia',
                ],
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                ]
            );
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        if ($filter['vigencia']['value'] != '') {
            $queryBuilder->andWhere("{$alias}.vigencia = :vigencia");
            $queryBuilder->setParameter("vigencia", $filter['vigencia']['value']);
        }

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codTipo', null, ['label' => 'label.tipodiaria.codTipo'])
            ->add('nomTipo', null, ['label' => 'label.tipodiaria.nomTipo'])
            ->add(
                'fkNormasNorma',
                null,
                [
                    'label' => 'label.tipodiaria.codNorma',
                ]
            )
            ->add(
                'valor',
                'currency',
                [
                    'label' => 'label..valor',
                    'currency' => 'BRL',
                    'locale' => 'pt_BR',
                ]
            )
            ->add('vigencia', null, ['label' => 'label.tipodiaria.vigencia']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];

        $fieldOptions['nomTipo'] = [
            'label' => 'label.tipodiaria.nomTipo'
        ];

        $fieldOptions['fkNormasNorma'] = [
            'label' => 'label.tipodiaria.codNorma',
            'multiple' => false,
            'attr' => ['class' => 'select2-parameters '],
            'class' => Norma::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->createQueryBuilder('o')
                    ->andWhere('lower(o.nomNorma) LIKE lower(:nomNorma)')
                    ->andWhere('o.exercicio = :exercicio')
                    ->setParameter('nomNorma', "%{$term}%")
                    ->setParameter('exercicio', $this->getExercicio())
                ;
            },
            'required' => true,
        ];

        $fieldOptions['valor'] = [
            'label' => 'label.tipodiaria.vlUnitario',
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['rubricaDespesa'] = [
            'class' => ContaDespesa::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->createQueryBuilder('o')
                    ->andWhere('lower(o.descricao) LIKE lower(:descricao)')
                    ->andWhere('o.exercicio = :exercicio')
                    ->setParameter('descricao', "%{$term}%")
                    ->setParameter('exercicio', $this->getExercicio())
                ;
            },
            'label' => 'label.tipodiaria.rubricaDespesa',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['vigencia'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.tipodiaria.vigencia'
        ];

        if ($this->id($this->getSubject())) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $codTipo = explode('~', $id);
            $tipoDiariaDespesa = $em->getRepository(TipoDiariaDespesa::class)->findOneByCodTipo($codTipo[0]);
            if ($tipoDiariaDespesa != null) {
                /** @var ContaDespesa $contaDespesa */
                $contaDespesa = $tipoDiariaDespesa->getFkOrcamentoContaDespesa();
                $fieldOptions['rubricaDespesa']['data'] = $contaDespesa;
            }
        }

        $formMapper
            ->add(
                'nomTipo',
                null,
                $fieldOptions['nomTipo']
            )
            ->add(
                'fkNormasNorma',
                'autocomplete',
                $fieldOptions['fkNormasNorma']
            )
            ->add(
                'valor',
                'money',
                $fieldOptions['valor']
            )
            ->add(
                'rubricaDespesa',
                'autocomplete',
                $fieldOptions['rubricaDespesa']
            )
            ->add(
                'vigencia',
                'sonata_type_date_picker',
                $fieldOptions['vigencia']
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('codTipo', null, ['label' => 'label.tipodiaria.codTipo'])
            ->add('nomTipo', null, ['label' => 'label.tipodiaria.nomTipo'])
            ->add(
                'fkNormasNorma',
                null,
                [
                    'label' => 'label.tipodiaria.codNorma',
                ]
            )
            ->add(
                'valor',
                'currency',
                [
                    'label' => 'label.tipodiaria.valor',
                    'currency' => 'BRL',
                    'locale' => 'pt_BR',
                ]
            )
            ->add('vigencia', null, ['label' => 'label.tipodiaria.vigencia']);
    }

    /**
     * @param TipoDiaria $tipoDiaria
     */
    public function prePersist($tipoDiaria)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $tipoDiariaModel = new TipoDiariaModel($em);
        $tipoDiaria->setCodTipo($tipoDiariaModel->getProximoCod());
    }

    /**
     * @param TipoDiaria $tipoDiaria
     */
    public function postPersist($tipoDiaria)
    {
        $contaDespesa = $this->getForm()->get('rubricaDespesa')->getData();

        if ($contaDespesa != null) {
            /** @var Diarias\TipoDiariaDespesa $rubricaDespesa */
            $rubricaDespesa = new TipoDiariaDespesa();
            $rubricaDespesa->setFkOrcamentoContaDespesa($contaDespesa);
            $rubricaDespesa->setFkDiariasTipoDiaria($tipoDiaria);
        }
    }

    /**
     * @param TipoDiaria $tipoDiaria
     */
    public function preUpdate($tipoDiaria)
    {
        $id = $this->getAdminRequestId();

        $em = $this->modelManager->getEntityManager($this->getClass());
        $codTipo = explode('~', $id);
        $tipoDiariaDespesas = $em->getRepository(TipoDiariaDespesa::class)->findByCodTipo($codTipo[0]);
        $tipoDiariaModel = new TipoDiariaModel($em);
        if (!empty($tipoDiariaDespesas)) {
            foreach ($tipoDiariaDespesas as $tipoDiariaDespesa) {
                $tipoDiariaModel->remove($tipoDiariaDespesa);
            }
        }

        $contaDespesa = $this->getForm()->get('rubricaDespesa')->getData();

        if ($contaDespesa != null) {
            /** @var TipoDiariaDespesa $rubricaDespesa */
            $rubricaDespesa = new TipoDiariaDespesa();
            $rubricaDespesa->setFkOrcamentoContaDespesa($contaDespesa);
            $rubricaDespesa->setFkDiariasTipoDiaria($tipoDiaria);
            $tipoDiaria->setFkDiariasTipoDiariaDespesa($rubricaDespesa);
        }
    }
}
