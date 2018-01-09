<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoConta;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ContaContabilRpNpAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_configuracao_conta_contabil_restos_pagar_np';
    protected $baseRoutePattern = 'financeiro/contabilidade/configuracao/conta-contabil-restos-pagar-np';
    protected $exibirBotaoEditar = false;

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $exercicio = $this->getExercicio();
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $exercicio);
        return $query;
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        if ($filter['codEntidade']['value'] !=  '') {
            $queryBuilder->andWhere("{$alias}.codEntidade = :codEntidade");
            $queryBuilder->setParameter("codEntidade", $filter['codEntidade']['value']);
        }

        if ($filter['codConta']['value'] !=  '') {
            $queryBuilder->andWhere("{$alias}.codConta = :codConta");
            $queryBuilder->setParameter("codConta", $filter['codConta']['value']);
        }

        return true;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();

        $datagridMapper
            ->add(
                'codEntidade',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.assinatura.codEntidade',
                    'callback' => array($this, 'getSearchFilter')
                ),
                'entity',
                array(
                    'class' => Entidade::class,
                    'choice_label' => function ($codEntidade) {
                        return sprintf('%s - %s', $codEntidade->getCodEntidade(), $codEntidade->getFkSwCgm()->getNomCgm());
                    },
                    'choice_value' => 'codEntidade',
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('e');
                        $qb->where('e.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $exercicio);
                        $qb->orderBy('e.sequencia', 'ASC');
                        return $qb;
                    }
                ),
                ['admin_code' => 'financeiro.admin.entidade']
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
            ->add(
                'fkContabilidadePlanoConta.codEstrutural',
                null,
                [
                    'label' => 'label.codigoReduzido'
                ]
            )
            ->add(
                'fkOrcamentoEntidade.fkSwCgm.nomCgm',
                null,
                [
                    'label' => 'entidade'
                ],
                [
                    'admin_code' => 'financeiro.admin.entidade'
                ]
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
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

        $fieldOptions = [];

        $fieldOptions['fkContabilidadePlanoConta'] = array(
            'label' => 'label.codigoReduzido',
            'property' => 'nomConta',
            'to_string_callback' => function (PlanoConta $planoConta, $property) {
                return $planoConta->getCodEstrutural() . ' - ' . strtoupper($planoConta->getNomConta());
            },
            'callback' => function ($admin, $property, $value) {
                $datagrid = $admin->getDatagrid();

                $query = $datagrid->getQuery();

                $query
                    ->where("o.exercicio = :exercicio")
                    ->setParameter('exercicio', $this->getExercicio());

                $datagrid->setValue($property, null, $value);
            },
            'attr' => array(
                'mapped' => false
            )
        );

        $fieldOptions['fkOrcamentoEntidade'] = array(
            'class' => 'CoreBundle:Orcamento\Entidade',
            'choice_label' => function ($entidade) {
                return $entidade->getFkSwCgm()->getNomCgm();
            },
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('e')
                    ->where('e.exercicio = :exercicio')
                    ->setParameter('exercicio', $this->getExercicio());
            },
            'label' => 'entidade',
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $formMapper
            ->add(
                'fkContabilidadePlanoConta',
                'sonata_type_model_autocomplete',
                $fieldOptions['fkContabilidadePlanoConta']
            )
            ->add(
                'fkOrcamentoEntidade',
                'entity',
                $fieldOptions['fkOrcamentoEntidade'],
                [
                    'admin_code' => 'financeiro.admin.entidade'
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('fkContabilidadePlanoConta.codEstrutural', null, ['label' => 'label.codigoReduzido'])
            ->add('fkOrcamentoEntidade.fkSwCgm.nomCgm', null, ['label' => 'entidade'])
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $uniqid = $this->getRequest()->query->get('uniqid');
        $formData = $this->getRequest()->request->get($uniqid);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $fkContabilidadePlanoConta = explode('~', $formData['fkContabilidadePlanoConta']);
        list($planoConta, $exercicio) = $fkContabilidadePlanoConta;

        $planoContaObj = $em->getRepository('CoreBundle:Contabilidade\\PlanoConta')
            ->findOneBy([
                'codConta' => $planoConta,
                'exercicio' => $exercicio
            ]);

        $object->setFkContabilidadePlanoConta($planoContaObj);
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $uniqid = $this->getRequest()->query->get('uniqid');
        $formData = $this->getRequest()->request->get($uniqid);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $fkContabilidadePlanoConta = explode('~', $formData['fkContabilidadePlanoConta']);
        list($planoConta, $exercicio) = $fkContabilidadePlanoConta;

        $contaContabilNp = $em->getRepository($this->getClass())
            ->findBy([
                'codConta' => $planoConta,
                'exercicio' => $exercicio
            ]);

        if ($contaContabilNp) {
            $error = $this->getTranslator()->trans('label.contaContabilRpNp.planoContaEmUso', ['%planoconta%' => $planoConta]);
            $errorElement->with('fkContabilidadePlanoConta')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }
    }
}
