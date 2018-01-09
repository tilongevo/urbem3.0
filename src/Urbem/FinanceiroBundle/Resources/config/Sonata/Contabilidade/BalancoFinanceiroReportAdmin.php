<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Helper\ReportHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class BalancoFinanceiroReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_relatorio_balanco_financeiro';
    protected $baseRoutePattern = 'financeiro/contabilidade/relatorios/balanco-financeiro';
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/contabilidade/report/design/relatorioBalancoFinanceiro.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];
    protected $periocidade = ['Dia','Mês','Ano','Intervalo'];
    protected $meses = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    protected $includeJs = [
        '/financeiro/javascripts/contabilidade/sharedReport/periodicidade.js',
        '/financeiro/javascripts/contabilidade/sharedReport/carregaAssinaturas.js'
    ];
    const COD_ACAO = '2896';

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
            ->with('label.contabilidade.relatorios.balancoFinanceiro')
            ->add(
                'exercicio',
                'hidden',
                array(
                    'data' => $this->getExercicio(),
                    'mapped' => false,
                    'required' => true
                )
            )
            ->add(
                'entidades',
                'entity',
                array(
                    'class' => Entidade::class,
                    'label' => 'label.lote.codEntidade',
                    'placeholder' => 'label.selecione',
                    'mapped' => false,
                    'required' => true,
                    'choice_value' => function ($entidade) {
                        if ($entidade) {
                            return sprintf('%s', $entidade->getCodEntidade());
                        }
                    },
                    'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
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
                    'dp_default_date' => '01/01/' . $this->getExercicio(),
                    'dp_min_date' => '01/01/' . $this->getExercicio(),
                    'dp_max_date' => '31/12/' . $this->getExercicio()
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
                    'dp_default_date' => '01/01/' . $this->getExercicio(),
                    'dp_min_date' => '01/01/' . $this->getExercicio(),
                    'dp_max_date' => '31/12/' . $this->getExercicio()
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
                    'dp_default_date' => '01/01/' . $this->getExercicio(),
                    'dp_min_date' => '01/01/' . $this->getExercicio(),
                    'dp_max_date' => '31/12/' . $this->getExercicio()
                )
            )
            ->end()
            ->with(' ')
            ->add(
                'situacao',
                'choice',
                array(
                    'placeholder' => 'label.selecione',
                    'choices' => array(
                        'Empenhadas' => 'E',
                        'Liquidadas' => 'L',
                        'Pagas' => 'P',
                    ),
                    'mapped' => false,
                    'required' => true,
                    'label' => 'label.contabilidade.relatorios.situacao',
                )
            )
            ->add(
                'incluirAssinatura',
                'choice',
                array(
                    'placeholder' => false,
                    'choices' => array(
                        'Não' => false,
                        'Sim' => true,
                    ),
                    'mapped' => false,
                    'required' => true,
                    'disabled' => true,
                    'label' => 'label.contabilidade.relatorios.incluirAssinatura',
                )
            )
            ->add(
                'listaAssinaturas',
                'choice',
                array(
                    'placeholder' => false,
                    'choices' => array(),
                    'mapped' => false,
                    'required' => false,
                    'disabled' => false,
                    'label' => 'label.contabilidade.relatorios.listaAssinaturas',
                    'multiple' => true,
                    'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
                )
            )
            ->end();

        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin) {
                $form = $event->getForm();
                $data = $event->getData();

                $subject = $admin->getSubject($data);

                $em = $this->modelManager->getEntityManager($this->getClass());
                $assinaturas = (new \Urbem\CoreBundle\Model\Administracao\AssinaturaModel($em))
                    ->getListaAssinatura($admin->getExercicio(), implode(',', $data['entidades']));

                $options = array();

                foreach ($assinaturas as $a) {
                    $options[$a->cod_entidade.'|'.$a->numcgm.'|'.$a->timestamp] = $a->cod_entidade . ' - ' . $a->nom_cgm .' - '. $a->cargo;
                }

                if ($form->has('listaAssinaturas')) {
                    $form->remove('listaAssinaturas');

                    $listaAssinaturas = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'listaAssinaturas',
                        'choice',
                        null,
                        array(
                            'placeholder' => false,
                            'mapped' => false,
                            'required' => false,
                            'choices' => array_flip($options),
                            'disabled' => false,
                            'label' => 'label.contabilidade.relatorios.listaAssinaturas',
                            'multiple' => true,
                            'auto_initialize' => false,
                        )
                    );
                    $form->add($listaAssinaturas);
                }
            }
        );
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $exercicio = $this->getExercicio();

        $entities = $this->getForm()->get('entidades')->getData();
        $cod_entidade = ReportHelper::getCodEntidades($entities);

        $poderAndNome = ReportHelper::getPoderAndNomeEntidade($entities);

        $dia = $this->getForm()->get('dia')->getData();
        $mes = $this->getForm()->get('mes')->getData();
        $ano = $this->getForm()->get('ano')->getData();
        $intervaloDe = $this->getForm()->get('intervaloDe')->getData();
        $intervaloAte = $this->getForm()->get('intervaloAte')->getData();

        $periodos = array($dia, $mes, $ano, $intervaloDe, $intervaloAte);
        $periodicidade = $this->getForm()->get('periodicidade')->getData();
        $valores = ReportHelper::getValoresPeriodicidade($periodicidade, $periodos, $exercicio, false);

        $listaAssinaturas = $this->getForm()->get('listaAssinaturas')->getData();
        $assinaturaParams = ReportHelper::getAssinaturaParams($listaAssinaturas);

        $fileName = $this->parseNameFile("balancoFinanceiro");

        $params = [
            'term_user' => $this->getCurrentUser()->getUserName(),
            'acao' => self::COD_ACAO,
            'exercicio' => $exercicio,
            'inCodGestao' => Gestao::GESTAO_FINANCEIRA,
            'inCodModulo' => Modulo::MODULO_CONTABILIDADE ,
            'inCodRelatorio' => Relatorio::BALANCO_FINANCEIRO,
            'nom_entidade' => $poderAndNome['nom_entidade'],
            'poder' => $poderAndNome['poder'],
            'tipo_despesa' => $this->getForm()->get('situacao')->getData(),
            'periodo' => $valores['periodo'],
            'cod_entidade' => $cod_entidade,
            'dt_inicial' => $valores['data_inicial'],
            'dt_final' => $valores['data_final'],
            'cod_acao' => self::COD_ACAO,
            'data_inicial_nota' => $valores['data_inicial_nota'],
            'data_final_nota' => $valores['data_final_nota'],
            'numero_assinatura' => $assinaturaParams['numero_assinatura'] ? $assinaturaParams['numero_assinatura'] : 0,
            'entidade_assinatura' => $assinaturaParams['codEntidade'] ? $assinaturaParams['codEntidade'] : '',
            'timestamp_assinatura' => $assinaturaParams['timestamp'] ? $assinaturaParams['timestamp'] : '',
            'numcgm_assinatura' => $assinaturaParams['numcgm'] ? $assinaturaParams['numcgm'] : '',
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
