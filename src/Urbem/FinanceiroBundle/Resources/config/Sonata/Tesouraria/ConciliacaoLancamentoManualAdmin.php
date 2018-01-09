<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ConciliacaoLancamentoManualAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codPlano')
            ->add('exercicio')
            ->add('mes')
            ->add('sequencia')
            ->add('dtLancamento')
            ->add('tipoValor')
            ->add('vlLancamento')
            ->add('descricao')
            ->add('conciliado')
            ->add('dtConciliacao')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codPlano')
            ->add('exercicio')
            ->add('mes')
            ->add('sequencia')
            ->add('dtLancamento')
            ->add('tipoValor')
            ->add('vlLancamento')
            ->add('descricao')
            ->add('conciliado')
            ->add('dtConciliacao')
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

        $fieldOptions['dtLancamento'] = array(
            'label' => 'label.tesourariaConciliacao.data',
            'format' => 'dd/MM/yyyy'
        );

        $fieldOptions['tipoValor'] = array(
            'label' => 'label.tesourariaConciliacao.tipoValor',
            'attr'  => array(
                'class' => 'select2-parameters'
            ),
            'choices' => array(
                'label.tesourariaConciliacao.entradas' => ConciliacaoAdmin::TIPO_VALOR_ENTRADA,
                'label.tesourariaConciliacao.saidas' => ConciliacaoAdmin::TIPO_VALOR_SAIDA,
            )
        );

        $fieldOptions['vlLancamento'] = array(
            'label' => 'label.tesourariaConciliacao.valor',
            'attr' => array(
                'class' => 'money '
            ),
            'required' => true
        );

        if ($this->id($this->getSubject())) {
            if ($this->getSubject()->getTipoValor() == ConciliacaoAdmin::TIPO_VALOR_SAIDA) {
                $fieldOptions['vlLancamento']['data'] = (float) $this->getSubject()->getVlLancamento() * -1;
            }
        } else {
            list($dia, $mes, $ano) = explode('/', $this->request->get('dtExtrato'));
            $fieldOptions['dtLancamento']['data'] = new \DateTime(sprintf('%s-%s-%s', $ano, $mes, $dia));
        }

        $formMapper
            ->add('sequencia', null, ['data' => 1])
            ->add('dtLancamento', 'sonata_type_date_picker', $fieldOptions['dtLancamento'])
            ->add('vlLancamento', null, $fieldOptions['vlLancamento'])
            ->add('tipoValor', 'choice', $fieldOptions['tipoValor'])
            ->add('conciliado', null, array('label' => 'label.tesourariaConciliacao.conciliar'))
            ->add('descricao', null, array('label' => 'label.tesourariaConciliacao.descricao'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codPlano')
            ->add('exercicio')
            ->add('mes')
            ->add('sequencia')
            ->add('dtLancamento')
            ->add('tipoValor')
            ->add('vlLancamento')
            ->add('descricao')
            ->add('conciliado')
            ->add('dtConciliacao')
        ;
    }
}
