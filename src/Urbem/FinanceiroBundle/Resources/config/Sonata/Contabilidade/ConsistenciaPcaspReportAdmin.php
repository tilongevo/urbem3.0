<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConsistenciaPcaspReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_relatorio_consistencia_pcasp';
    protected $baseRoutePattern = 'financeiro/contabilidade/relatorios/consistencia-pcasp';
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/contabilidade/report/design/consistenciaPCASP.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];
    protected $periocidade = ['Dia','Mês','Ano','Intervalo'];
    protected $meses = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    protected $includeJs = ['/financeiro/javascripts/contabilidade/consistenciaPcaspReport/consistenciaPcaspReport.js'];
    const COD_ACAO = '2910';

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
            ->add(
                'entidades',
                'entity',
                array(
                    'class' => Entidade::class,
                    'label' => 'label.lote.codEntidade',
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
                    'attr' => ['class' => 'select2-parameters select2-multiple-options-custom ']
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
            ->add(
                'tipoRelatorio',
                'choice',
                array(
                    'placeholder' => false,
                    'choices' => array(
                        'Sintético' => 'S',
                        'Analítico' => 'A'
                    ),
                    'mapped' => false,
                    'required' => true,
                    'label' => 'label.contabilidade.relatorios.tipoRelatorio',
                )
            )
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $entities = $this->getForm()->get('entidades')->getData();
        $cod_entidades = 'cod_entidade IN ('.$this::getCodEntidades($entities).')';
        $exercicio = $this->getExercicio();

        $dia = $this->getForm()->get('dia')->getData();
        $mes = $this->getForm()->get('mes')->getData();
        $ano = $this->getForm()->get('ano')->getData();
        $intervaloDe = $this->getForm()->get('intervaloDe')->getData();
        $intervaloAte = $this->getForm()->get('intervaloAte')->getData();

        $periodos = array($dia, $mes, $ano, $intervaloDe, $intervaloAte);
        $periodicidade = $this->getForm()->get('periodicidade')->getData();

        $fileName = $this->parseNameFile("consistenciaPCASP");

        $params = [
            'filtro' => $cod_entidades,
            'exercicio' => $exercicio,
            'cod_acao' => self::COD_ACAO,
            'dt_inicial' => $this::getValores($periodicidade, $periodos)['data_inicial'],
            'dt_final' => $this::getValores($periodicidade, $periodos)['data_final'],
            'estilo' => $this->getForm()->get('tipoRelatorio')->getData(),
            'inCodGestao' => Gestao::GESTAO_FINANCEIRA,
            'inCodModulo' => Modulo::MODULO_CONTABILIDADE ,
            'inCodRelatorio' => Relatorio::FINANCEIRO_CONSISTENCIA_PCASP,
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

    /**
     * @param $entities
     * @return string
     */
    private function getCodEntidades($entities)
    {
        $cod_Entidades = '';
        foreach ($entities as $entity) {
            $cod_Entidades .= $entity->getCodEntidade().',';
        }

        $cod_Entidades = substr($cod_Entidades, 0, -1);

        return $cod_Entidades;
    }

    /**
     * @return array
     */
    private function getValores($periodicidade, $periodos)
    {
        $exercicio = $this->getExercicio();

        if ($periodicidade == 0) {
            $data = $periodos[0];
            $valores = array(
                "data_inicial" => $data->format('d/m/Y'),
                "data_final" => $data->format('d/m/Y')
            );

            return $valores;
        }

        if ($periodicidade == 1) {
            $numeroMes = $periodos[1] ;
            $dataInicio = new \DateTime("first day of last month");
            $dataInicio = $dataInicio->setDate($exercicio, $numeroMes, 1);

            $dataFinal = new \DateTime("last day of last month");
            $dataFinal = $dataFinal->setDate($exercicio, $numeroMes, 30);

            $valores = array(
                "data_inicial" => $dataInicio->format('d/m/Y'),
                "data_final" => $dataFinal->format('d/m/Y'),
            );

            return $valores;
        }

        if ($periodicidade == 2) {
            $valores = array(
                "data_inicial" => '01/01/'.$exercicio,
                "data_final" => '31/12/'.$exercicio,
            );

            return $valores;
        }

        if ($periodicidade == 3) {
            $data_ini = $periodos[3];
            $data_fim = $periodos[4];

            $valores = array(
                "data_inicial" => $data_ini->format('d/m/Y'),
                "data_final" => $data_fim->format('d/m/Y')
            );

            return $valores;
        }
    }
}
