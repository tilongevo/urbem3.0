<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class HistoricoPadraoReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_relatorio_historico_padrao';
    protected $baseRoutePattern = 'financeiro/contabilidade/relatorios/historico-padrao';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $exercicio = $this->getExercicio();

        $formMapper
            ->add(
                'descricaoHistorico',
                'text',
                array(
                    'label' => 'label.historicoPadraoReport.descricaoHistorico',
                    'required' => false,
                    'mapped' => false,
                )
            )
            ->add(
                'numeroHistoricoPadraoDe',
                'text',
                array(
                    'label' => 'label.historicoPadraoReport.numeroHistoricoPadraoDe',
                    'required' => false,
                    'mapped' => false,
                )
            )
            ->add(
                'numeroHistoricoPadraoAte',
                'text',
                array(
                    'label' => 'label.historicoPadraoReport.numeroHistoricoPadraoAte',
                    'required' => false,
                    'mapped' => false,
                )
            )
            ->add(
                'complemento',
                'choice',
                array(
                    'choices' => array(
                        'Ambos' => 'ambos',
                        'Sim' => 'sim',
                        'Não' => 'nao'
                    ),
                    'mapped' => false,
                    'required' => false,
                    'label' => 'label.historicoPadraoReport.complemento',
                    'placeholder' => false,
                )
            )
            ->add(
                'ordenacao',
                'choice',
                array(
                    'choices' => array(
                        'Código Reduzido' => 'codigo reduzido',
                        'Descrição' => 'descricao'
                    ),
                    'mapped' => false,
                    'required' => false,
                    'label' => 'label.historicoPadraoReport.ordenacao',
                    'placeholder' => false,
                )
            )
        ;
    }
}
