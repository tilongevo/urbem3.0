<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class DiarioGeralReportAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_relatorios_diario_geral';
    protected $baseRoutePattern = 'financeiro/contabilidade/relatorios/diario-geral';
    protected $layoutDefaultReport = '/bundles/report/gestaoRH/fontes/RPT/pessoal/report/design/EmitirAvisoFerias.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Emitir relatório'];
    protected $periocidade = ['Dia','Mês','Ano','Intervalo'];
    protected $meses = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    protected $includeJs = ['/financeiro/javascripts/contabilidade/diarioGeralReport/diarioGeralReport.js'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $repository = $entityManager->getRepository('CoreBundle:Tesouraria\SaldoTesouraria');
        $entidades =  ArrayHelper::parseArrayToChoice($repository->getEntidadesValidas($this->getCurrentUser()->getId(), $this->getExercicio()), 'nom_cgm', 'cod_entidade');

        $formMapper

            ->add(
                'entidade',
                'choice',
                [
                    'required' => true,
                    'mapped' => false,
                    'choices' => $entidades,
                    'label' => 'label.entidades',
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )

            ->add(
                'periodicidade',
                'choice',
                [
                    'required' => true,
                    'mapped' => false,
                    'choices' => ArrayHelper::parseInvertArrayToChoice($this->periocidade),
                    'label' => 'label.contabilidade.relatorios.periodicidade',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'mes',
                'choice',
                [
                    'required' => false,
                    'mapped' => false,
                    'choices' => ArrayHelper::parseInvertArrayToChoice($this->meses),
                    'label' => 'label.contabilidade.relatorios.mes',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'dia',
                'number',
                [
                    'required' => false,
                    'mapped' => false,
                    'label' => 'label.contabilidade.relatorios.dia',
                ]
            )
            ->add(
                'ano',
                'number',
                [
                    'required' => false,
                    'mapped' => false,
                    'label' => 'label.contabilidade.relatorios.dia',
                    'data' => $this->getExercicio(),
                    'attr' => [
                        'readonly' => 'readonly'
                    ]
                ]
            )
            ->add(
                'intervaloDe',
                'text',
                [
                    'required' => false,
                    'mapped' => false,
                    'label' => 'label.contabilidade.relatorios.intervaloDe',
                ]
            )
            ->add(
                'intervaloAte',
                'text',
                [
                    'required' => false,
                    'mapped' => false,
                    'label' => 'label.contabilidade.relatorios.intervaloAte',
                ]
            )
        ;
    }
}
