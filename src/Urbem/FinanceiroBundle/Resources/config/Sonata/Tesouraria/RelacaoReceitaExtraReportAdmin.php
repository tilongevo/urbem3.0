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

class RelacaoReceitaExtraReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_relatorio_relacao_receita_extra';
    protected $baseRoutePattern = 'financeiro/tesouraria/relatorios/relacao-receita-extra';
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/tesouraria/report/design/relacaoReceitaExtra.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];
    protected $periocidade = ['Dia','Mês','Ano','Intervalo'];
    protected $meses = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    protected $includeJs = ['/financeiro/javascripts/tesouraria/relacaoReceitaExtraReport/relacaoReceitaExtraReport.js'];
    const COD_ACAO ='1837';

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
            ->with('label.tesouraria.relatorios.relacaoReceitaExtraTitulo')
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
                'tipoRelatorio',
                'choice',
                array(
                    'placeholder' => 'label.selecione',
                    'choices' => array(
                        'por Banco' => 'B',
                        'por Entidade' => 'E',
                        'por Recurso' => 'R',
                    ),
                    'mapped' => false,
                    'required' => false,
                    'label' => 'label.contabilidade.relatorios.tipoRelatorio',
                )
            )
            ->add(
                'contaReceitaDe',
                'autocomplete',
                [
                    'label' => 'label.tesouraria.relatorios.contaReceitaDe',
                    'multiple' => false,
                    'required' => false,
                    'mapped' => false,
                    'route' => ['name' => 'get_plano_contas_receita']
                ]
            )
            ->add(
                'contaReceitaAte',
                'autocomplete',
                [
                    'label' => 'label.tesouraria.relatorios.contaReceitaAte',
                    'multiple' => false,
                    'required' => false,
                    'mapped' => false,
                    'route' => ['name' => 'get_plano_contas_receita']
                ]
            )
            ->add(
                'contaBancoDe',
                'autocomplete',
                [
                    'label' => 'label.tesouraria.relatorios.contaBancoDe',
                    'multiple' => false,
                    'required' => false,
                    'mapped' => false,
                    'route' => ['name' => 'get_plano_contas_banco']
                ]
            )
            ->add(
                'contaBancoAte',
                'autocomplete',
                [
                    'label' => 'label.tesouraria.relatorios.contaBancoAte',
                    'multiple' => false,
                    'mapped' => false,
                    'required' => false,
                    'route' => ['name' => 'get_plano_contas_banco']
                ]
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
                    'choice_value' => 'codFonte',
                    'choice_label' => function (Recurso $recurso) {
                        return "{$recurso->getCodFonte()} - {$recurso->getNomRecurso()}";
                    },
                    'attr' => ['class' => 'select2-parameters'],
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $exercicio);
                        $qb->orderBy('o.exercicio', 'ASC');
                        $qb->orderBy('o.codRecurso', 'ASC');
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
        $cod_receita_ini = $this->getForm()->get('contaReceitaDe')->getData();
        $cod_receita_fim = $this->getForm()->get('contaReceitaAte')->getData();
        $conta_banco_ini = $this->getForm()->get('contaBancoDe')->getData();
        $conta_banco_fim = $this->getForm()->get('contaBancoAte')->getData();
        $recurso = $this->getForm()->get('recurso')->getData();

        $fileName = $this->parseNameFile("relacaoReceitaExtra");

        $params = [
            'cod_entidade' => $cod_entidade,
            'exercicio' => $exercicio,
            'cod_acao' => self::COD_ACAO,
            'dt_inicial' => $valores['data_inicial'],
            'dt_final' => $valores['data_final'],
            'cod_plano' => 'BETWEEN '.$cod_receita_ini.' AND '.$cod_receita_fim,
            'conta_banco' => 'BETWEEN '.$conta_banco_ini.' AND '.$conta_banco_fim,
            'tipo_relatorio' => $tipoRelatorio ? (string) $tipoRelatorio : '',
            'recurso' => $recurso ? (string) $recurso->getCodRecurso() : '',
            'destinacaorecurso' => '',
            'cod_detalhamento' => '',
            'inCodGestao' => Gestao::GESTAO_FINANCEIRA,
            'inCodModulo' => Modulo::MODULO_TESOURARIA ,
            'inCodRelatorio' => Relatorio::FINANCEIRO_RELACAO_RECEITA_EXTRA,
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
