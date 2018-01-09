<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ppa;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ProgramasMacroObjetivoReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_ppa_relatorios_programa_macro_objetivo';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/ppa/relatorios/programa-macro-objetivo';
    protected $layoutDefaultReport = '/gestaoFinanceira/fontes/RPT/ppa/report/design/programasMacroobjetivo.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar relatório'];

    public function prePersist($object)
    {

        /**
         *Esse é um teste para exibir o relatório diretamente no Birt
         *Essa é a url completa para o teste retornar o relatório
         *Observe que o db_conn_url esta para o urbem-old
         *Caso o Birt esteja configurado na sua maquina, essa url vai retornar um relatório
         *
         * http://urbem.dev:8080/viewer_440/run?
         * __report=/var/www/projetos/urbem/web/gestaoFinanceira/fontes/RPT/ppa/report/design/programasMacroobjetivo.rptdesign
         * &db_driver=org.postgresql.Driver
         * &term_user=suporte
         * &cod_acao=2726
         * &exercicio=2016
         * &db_conn_url=jdbc%3Apostgresql%3A%2F%2Flocalhost%3A5432%2Furbem-old
         * &inCodGestao=2
         * &inCodModulo=43
         * &inCodRelatorio=2
         * &cod_ppa=2
         * &ano_inicio=2014
         * &cod_tipo_programa=4
         * &tipo_relatorio=sintetico
         * &num_orgao=1
         * &num_unidade=1
         * &__format=html
         * &__locale=pt_BRfilename=RelatorioUrbem_201609301110.html
        **/

        $entity = $object;
        $fileName = $this->parseNameFile("programasMacroobjetivo");
        $params = [
            'ano_inicio' => $entity->getPpa()->getAnoInicio(),
            'cod_ppa' => $entity->getPpa()->getCodPpa(),
            'exercicio' => $this->getExercicio(),
            'cod_acao' => '2726',
            'cod_tipo_programa' => $entity->getTipoPrograma()->getCodTipoPrograma(),
            'tipo_relatorio' => $entity->getTipoRelatorio(),
            'num_orgao' => (int) $entity->getNumOrgao(),
            'num_unidade' => (int) $entity->getNumUnidade(),
            'inCodGestao' => 2,
            'inCodModulo' => 43,
            'inCodRelatorio' => 2,
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
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codFake')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codFake')
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
        $this->setBreadCrumb();

        $translator = $this->getConfigurationPool()->getContainer()->get('translator.default');
        $tipoRelatorio = [
            $translator->transChoice('label.ppa.sintetico', 0, [], 'messages')=>'sintetico',
            $translator->transChoice('label.ppa.analitico', 0, [], 'messages')=>'analitico'
        ];
        $entityManager = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $pmcRepository = $entityManager->getRepository('CoreBundle:Ppa\ProgramasMacroObjetivoReport');

        $orgaos = $pmcRepository->findAllOrgaoPorExercicio($this->getExercicio());

        $formMapper
            ->add(
                'ppa',
                'entity',
                array(
                    'class' => 'CoreBundle:Ppa\Ppa',
                    'label' => 'label.ppa.ppa',
                    'required' => true,
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                )
            )
            ->add(
                'tipoPrograma',
                'entity',
                array(
                    'class' => 'CoreBundle:Ppa\TipoPrograma',
                    'choice_label' => 'descricao',
                    'label' => 'label.programas.inCodTipoPrograma',
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                )
            )
            ->add(
                'tipoRelatorio',
                'choice',
                [
                    'required' => false,
                    'choices' => $tipoRelatorio,
                    'label' => 'label.ppa.tipoRelatorio',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'numOrgao',
                'choice',
                [
                    'required' => false,
                    'label' => 'label.ppa.numOrgao',
                    'choices' => $orgaos,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'numUnidade',
                'choice',
                [
                    'required' => false,
                    'label' => 'label.ppa.numUnidade',
                    'choices' => $orgaos,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codFake')
        ;
    }
}
