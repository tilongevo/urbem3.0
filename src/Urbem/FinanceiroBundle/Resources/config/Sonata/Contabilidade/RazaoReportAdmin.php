<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Helper\ReportHelper;

class RazaoReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_relatorio_razao';
    protected $baseRoutePattern = 'financeiro/contabilidade/relatorios/razao';
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/contabilidade/report/design/razao.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];
    protected $periocidade = ['Dia','Mês','Ano','Intervalo'];
    protected $meses = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    protected $includeJs = ['/financeiro/javascripts/contabilidade/razaoReport/razaoReport.js'];
    const COD_ACAO ='244';

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
            ->with('label.contabilidade.relatorios.razao')
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
                'codEstruturalDe',
                'autocomplete',
                array(
                    'multiple' => false,
                    'mapped' => false,
                    'required' => false,
                    'label' => 'label.contabilidade.relatorios.codEstruturalDe',
                    'route' => ['name' => 'get_plano_contas_estrutural']
                )
            )
            ->add(
                'codEstruturalAte',
                'autocomplete',
                array(
                    'multiple' => false,
                    'mapped' => false,
                    'required' => false,
                    'label' => 'label.contabilidade.relatorios.codEstruturalAte',
                    'route' => ['name' => 'get_plano_contas_estrutural']
                )
            )
            ->add(
                'codigoReduzidoDe',
                'autocomplete',
                array(
                    'multiple' => false,
                    'mapped' => false,
                    'required' => false,
                    'label' => 'label.contabilidade.relatorios.codigoReduzidoDe',
                    'route' => ['name' => 'get_plano_contas_reduzido']
                )
            )
            ->add(
                'codigoReduzidoAte',
                'autocomplete',
                array(
                    'multiple' => false,
                    'mapped' => false,
                    'required' => false,
                    'label' => 'label.contabilidade.relatorios.codigoReduzidoAte',
                    'route' => ['name' => 'get_plano_contas_reduzido']
                )
            )
            ->add(
                'imprimirContas',
                'choice',
                array(
                    'label' => 'label.contabilidade.relatorios.imprimirContas',
                    'mapped' => false,
                    'required' => false,
                    'placeholder' => false,
                    'choices' => array(
                        'Não' => 'N',
                        'Sim' => 'S'
                    )
                )
            )
            ->add(
                'historicoCompleto',
                'choice',
                array(
                    'label' => 'label.contabilidade.relatorios.historicoCompleto',
                    'mapped' => false,
                    'required' => false,
                    'placeholder' => false,
                    'choices' => array(
                        'Não' => 'N',
                        'Sim' => 'S'
                    )
                )
            )
            ->add(
                'quebrarPagina',
                'choice',
                array(
                    'label' => 'label.contabilidade.relatorios.quebrarPagina',
                    'mapped' => false,
                    'required' => false,
                    'placeholder' => false,
                    'choices' => array(
                        'Não' => 'N',
                        'Sim' => 'S'
                    )
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

        $cod_estrutural_inicial = $this->getForm()->get('codEstruturalDe')->getData();
        $cod_estrutural_final = $this->getForm()->get('codEstruturalAte')->getData();
        $cod_reduzido_inicial = $this->getForm()->get('codigoReduzidoDe')->getData();
        $cod_reduzido_final = $this->getForm()->get('codigoReduzidoAte')->getData();

        $fileName = $this->parseNameFile("razao");

        $params = [
            'cod_entidade' => $cod_entidade,
            'exercicio' => $exercicio,
            'cod_acao' => self::COD_ACAO,
            'dt_inicial' => $valores['data_inicial'],
            'dt_final' => $valores['data_final'],
            'entidade_descricao' => ReportHelper::getEntidadesDescricao($entities),
            'st_entidade' => $cod_entidade,
            'filtro' => ReportHelper::getFiltroValidado($cod_reduzido_inicial, $cod_reduzido_final),
            'cod_estrutural_inicial' => $cod_estrutural_inicial ? $cod_estrutural_inicial : '0.0.0.0.0.00.00.00.00.00',
            'cod_estrutural_final' => $cod_estrutural_final ? $cod_estrutural_final : '9.9.9.9.9.99.99.99.99.99',
            'dt_inicial_anterior' => $valores['data_inicial_anterior'],
            'dt_final_anterior' => $valores['data_final_anterior'],
            'bo_movimentacao' => $this->getForm()->get('imprimirContas')->getData(),
            'bo_historico' => $this->getForm()->get('historicoCompleto')->getData(),
            'bo_quebra_por_conta' => $this->getForm()->get('quebrarPagina')->getData(),
            'cod_reduzido_inicial' => $cod_reduzido_inicial ? $cod_reduzido_inicial : '',
            'cod_reduzido_final' => $cod_reduzido_final ? $cod_reduzido_final : '',
            'inCodGestao' => Gestao::GESTAO_FINANCEIRA,
            'inCodModulo' => Modulo::MODULO_CONTABILIDADE ,
            'inCodRelatorio' => Relatorio::FINANCEIRO_RAZAO,
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
