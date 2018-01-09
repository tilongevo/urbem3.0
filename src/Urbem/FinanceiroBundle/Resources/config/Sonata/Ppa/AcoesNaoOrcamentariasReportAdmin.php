<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ppa;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class AcoesNaoOrcamentariasReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_ppa_relatorios_acoes_nao_orcamentarias';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/ppa/relatorios/acoes-nao-orcamentarias';
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/ppa/report/design/acoesNaoOrcamentarias.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar relatório'];
    protected $includeJs = ['/financeiro/javascripts/ppa/acao.js'];

    public function prePersist($object)
    {
        $codTipoAcao = $object->getTipoAcao();
        $codPrograma = $object->getPrograma();
        $entity = $object->getPpa();
        $fileName = $this->parseNameFile("acoesNaoOrcamentarias");
        $params = [
            'ano_inicio' => $entity->getAnoInicio(),
            'cod_ppa' => $entity->getCodPpa(),
            'exercicio' => $this->getExercicio(),
            'cod_tipo_acao' => $codTipoAcao,
            'cod_programa' => $codPrograma,
            'cod_acao' => '2728',
            'inCodGestao' => 2,
            'inCodModulo' => 43,
            'inCodRelatorio' => 5,
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

        $entityManager = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $pmcRepository = $entityManager->getRepository('CoreBundle:Ppa\AcoesNaoOrcamentariasReport');
        $tipoAcoes = $pmcRepository->findAllTipoAcao();
        $allProgramas = ArrayHelper::parseInvertArrayToChoice($pmcRepository->findAllPrograma());

        $formMapper
            ->add(
                'ppa',
                'entity',
                array(
                    'required' => false,
                    'class' => 'CoreBundle:Ppa\Ppa',
                    'label' => 'label.ppa.ppa',
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters ppa-ppa'
                    ],
                )
            )
            ->add(
                'programa',
                'choice',
                [
                    'required' => false,
                    'choices' => $allProgramas,
                    'label' => 'label.ppaAcao.programa',
                    'choice_value' => function ($value) {
                        return $value;
                    },
                    'attr' => [
                        'class' => 'select2-parameters ppa-programa'
                    ],
                ]
            )
            ->add(
                'tipoAcao',
                'choice',
                [
                    'required' => false,
                    'choices' => $tipoAcoes,
                    'label' => 'label.ppaAcao.tipoAcao',
                    'choice_value' => function ($value) {
                        return $value;
                    },
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
