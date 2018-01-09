<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento\Suplementacao;

use Urbem\CoreBundle\Entity\Orcamento\Despesa;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Orcamento\DespesaAdmin;

class SuplementacaoSuplementadaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_orcamento_suplementacao_suplementada';
    protected $baseRoutePattern = 'orcamento/suplementacao-suplementada';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('codSuplementacao')
            ->add('codDespesa')
            ->add('valor')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('exercicio')
            ->add('codSuplementacao')
            ->add('codDespesa')
            ->add('valor')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $fieldOptions = array();

        $fieldOptions['dotacoes'] = array(
            'label' => 'label.suplementacao.dotacoes',
            'required' => true,
            'attr' => ['class' => 'select2-parameters'],
            'property' => 'codDespesaDescricao',
            'to_string_callback' => function (Despesa $despesa) {
                return (string) $despesa;
            },
            'callback' => function (DespesaAdmin $admin, $property, $value) {
                $datagrid = $admin->getDatagrid();

                /** @var \Doctrine\ORM\QueryBuilder $query */
                $query = $datagrid->getQuery();
                $query->andWhere('o.exercicio = :exercicio');
                $query->setParameter('exercicio', $this->getExercicio());

                $datagrid->setValue($property, null, $value);
            }
        );

        $fieldOptions['valorSuplementado'] = array(
            'label' => 'label.suplementacao.valor',
            'currency' => 'BRL',
            'attr' => ['class' => 'money ']
        );

        $formMapper
            ->add('fkOrcamentoDespesa', 'sonata_type_model_autocomplete', $fieldOptions['dotacoes'], ['admin_code' => 'core.admin.filter.despesa'])
            ->add('valor', 'money', $fieldOptions['valorSuplementado'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicio')
            ->add('codSuplementacao')
            ->add('codDespesa')
            ->add('valor')
        ;
    }
}
