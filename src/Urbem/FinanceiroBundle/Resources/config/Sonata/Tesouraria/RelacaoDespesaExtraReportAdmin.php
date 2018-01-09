<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\Recurso;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Helper\ReportHelper;

class RelacaoDespesaExtraReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_relatorio_relacao_despesa_extra';
    protected $baseRoutePattern = 'financeiro/tesouraria/relatorios/relacao-despesa-extra';
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/tesouraria/report/design/relacaoDespesaExtra.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];
    protected $periocidade = ['Dia','Mês','Ano','Intervalo'];
    protected $meses = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    protected $includeJs = ['/financeiro/javascripts/tesouraria/relacaoDespesaExtraReport/relacaoDespesaExtraReport.js'];
    const COD_ACAO ='2216';

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

        $exercicio = $this->getExercicio();

        $formMapper
            ->with('label.tesouraria.relatorios.relatorio')
            ->add(
                'entidades',
                'entity',
                array(
                    'class' => Entidade::class,
                    'label' => 'label.contabilidade.relatorios.entidades',
                    'placeholder' => 'label.selecione',
                    'mapped' => false,
                    'required' => true,
                    'choice_value' => 'codEntidade',
                    'attr' => ['class' => 'select2-parameters'],
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $exercicio);
                        return $qb;
                    },
                    'multiple' => true,
                )
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
                    'required' => true,
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
                'sonata_type_date_picker',
                array(
                    'label' => 'label.contabilidade.relatorios.dia',
                    'mapped' => false,
                    'required' => true,
                    'format' => 'dd/MM/yyyy',
                    'dp_use_current' => false,
                    'dp_default_date' => '01/01/'.$this->getExercicio(),
                    'dp_min_date' => '01/01/'.$this->getExercicio(),
                    'dp_max_date' => '31/12/'.$this->getExercicio()
                )
            )
            ->add(
                'ano',
                'number',
                [
                    'required' => true,
                    'mapped' => false,
                    'label' => 'label.contabilidade.relatorios.ano',
                    'data' => $this->getExercicio(),
                    'attr' => [
                        'readonly' => 'readonly'
                    ]
                ]
            )
            ->add(
                'intervaloDe',
                'sonata_type_date_picker',
                array(
                    'label' => 'label.contabilidade.relatorios.intervaloDe',
                    'mapped' => false,
                    'required' => true,
                    'format' => 'dd/MM/yyyy',
                    'dp_use_current' => false,
                    'dp_default_date' => '01/01/'.$this->getExercicio(),
                    'dp_min_date' => '01/01/'.$this->getExercicio(),
                    'dp_max_date' => '31/12/'.$this->getExercicio()
                )
            )
            ->add(
                'intervaloAte',
                'sonata_type_date_picker',
                array(
                    'label' => 'label.contabilidade.relatorios.intervaloAte',
                    'mapped' => false,
                    'required' => true,
                    'format' => 'dd/MM/yyyy',
                    'dp_use_current' => false,
                    'dp_default_date' => '01/01/'.$this->getExercicio(),
                    'dp_min_date' => '01/01/'.$this->getExercicio(),
                    'dp_max_date' => '31/12/'.$this->getExercicio()
                )
            )
            ->end()
            ->with(' ')
            ->add(
                'DespesaDe',
                'number',
                array(
                    'label' => 'label.tesouraria.relatorios.despesaDe',
                    'required' => false,
                    'mapped' => false,
                )
            )
            ->add(
                'DespesaAte',
                'number',
                array(
                    'label' => 'label.tesouraria.relatorios.despesaAte',
                    'required' => false,
                    'mapped' => false,
                )
            )
            ->add(
                'BancoDe',
                'number',
                array(
                    'label' => 'label.tesouraria.relatorios.bancoDe',
                    'required' => false,
                    'mapped' => false,
                )
            )
            ->add(
                'BancoAte',
                'number',
                array(
                    'label' => 'label.tesouraria.relatorios.bancoAte',
                    'required' => false,
                    'mapped' => false,
                )
            )
            ->add(
                'tipoRelatorio',
                'choice',
                array(
                    'label' => 'label.tesouraria.relatorios.tipoRelatorio',
                    'mapped' => false,
                    'required' => false,
                    'placeholder' => 'label.selecione',
                    'choices' => array(
                        'por Banco' => 'B',
                        'por Entidade' => 'E',
                        'por Recurso' => 'R',
                    )
                )
            )
            ->add(
                'recurso',
                'entity',
                array(
                    'class' => Recurso::class,
                    'label' => 'label.tesouraria.relatorios.recurso',
                    'placeholder' => 'label.selecione',
                    'mapped' => false,
                    'required' => false,
                    'choice_value' => 'codRecurso',
                    'choice_label' => function (Recurso $recurso) {
                        return "{$recurso->getCodRecurso()} - {$recurso->getNomRecurso()}";
                    },
                    'attr' => ['class' => 'select2-parameters'],
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $exercicio);
                        return $qb;
                    },
                )
            )
            ->end()
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $entities = $this->getForm()->get('entidades')->getData();
        $cod_entidade = ReportHelper::getCodEntidades($entities);

        $exercicio = $this->getExercicio();

        $dia = $this->getForm()->get('dia')->getData();
        $mes = $this->getForm()->get('mes')->getData();
        $ano = $this->getForm()->get('ano')->getData();
        $intervaloDe = $this->getForm()->get('intervaloDe')->getData();
        $intervaloAte = $this->getForm()->get('intervaloAte')->getData();

        $periodos = array($dia, $mes, $ano, $intervaloDe, $intervaloAte);
        $periodicidade = $this->getForm()->get('periodicidade')->getData();

        $valores = ReportHelper::getValoresPeriodicidade($periodicidade, $periodos, $exercicio, true);

        $tipoRelatorio = $this->getForm()->get('tipoRelatorio')->getData();
        $cod_plano_ini = $this->getForm()->get('DespesaDe')->getData();
        $cod_plano_fim = $this->getForm()->get('DespesaAte')->getData();
        $conta_banco_ini = $this->getForm()->get('BancoDe')->getData();
        $conta_banco_fim = $this->getForm()->get('BancoAte')->getData();
        $recurso = $this->getForm()->get('recurso')->getData();

        $fileName = $this->parseNameFile("relacaoDespesaExtra");

        $params = [
            'cod_entidade' => $cod_entidade,
            'exercicio' => $exercicio,
            'cod_acao' => self::COD_ACAO,
            'dt_inicial' => $valores['data_inicial'],
            'dt_final' => $valores['data_final'],

            'cod_plano' => 'BETWEEN '.$cod_plano_ini.' AND '.$cod_plano_fim,
            'conta_banco' => 'BETWEEN '.$conta_banco_ini.' AND '.$conta_banco_fim,
            'tipo_relatorio' => $tipoRelatorio ? (string) $tipoRelatorio : '',
            'recurso' => $recurso ? (string) $recurso->getCodRecurso() : '',

            'filtro_extras' => " AND (
               ( cpcd.cod_estrutural like '1.1.2.%' AND cpc.cod_estrutural like '1.1.2.%' ) OR
               ( cpcd.cod_estrutural like '1.1.3.%' AND cpc.cod_estrutural like '1.1.3.%' ) OR
               ( cpcd.cod_estrutural like '1.2.1.%' AND cpc.cod_estrutural like '1.2.1.%' ) OR
               ( cpcd.cod_estrutural like '2.1.1.%' AND cpc.cod_estrutural like '2.1.1.%' ) OR
               ( cpcd.cod_estrutural like '2.1.2.%' AND cpc.cod_estrutural like '2.1.2.%' ) OR
               ( cpcd.cod_estrutural like '2.1.9.%' AND cpc.cod_estrutural like '2.1.9.%' ) OR
               ( cpcd.cod_estrutural like '2.2.1.%' AND cpc.cod_estrutural like '2.2.1.%' ) OR
               ( cpcd.cod_estrutural like '2.2.2.%' AND cpc.cod_estrutural like '2.2.2.%' )
             ) ",

            'inCodGestao' => Gestao::GESTAO_FINANCEIRA,
            'inCodModulo' => Modulo::MODULO_TESOURARIA ,
            'inCodRelatorio' => Relatorio::FINANCEIRO_RELACAO_DESPESA_EXTRA,
            'term_user' => $this->getCurrentUser()->getUserName()
        ];

        $apiService = $this->getReportService();
        $apiService->setReportNameFile($fileName);
        $apiService->setLayoutDefaultReport($this->layoutDefaultReport);
        $res = $apiService->getReportContent($params);

        $this->parseContentToPdf(
            $res->getBody()->getContents(),
            $fileName
        );
    }
}
