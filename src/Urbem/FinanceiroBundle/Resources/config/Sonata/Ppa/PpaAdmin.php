<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ppa;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Ppa\Ppa;
use Urbem\CoreBundle\Model\Ppa\PpaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model\Ppa\AcaoValidadaModel;
use Sonata\AdminBundle\Route\RouteCollection;

class PpaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_plano_plurianual_ppa';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/ppa';
    protected $customHeader = 'FinanceiroBundle:Ppa:conf/cabecalhoPpa.html.twig';
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;
    private $infoPpa = array();
    private $codPpa = null;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('homologar', 'homologar/' . $this->getRouterIdParameter());
        $collection->add('estimativa', 'estimativa/' . $this->getRouterIdParameter());
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codPpa',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.macroObjetivos.codPpa'
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Ppa\Ppa',
                    'choice_label' => function ($ppa) {
                        if (!empty($ppa)) {
                            return $ppa;
                        }
                    },
                    'choice_value' => function ($ppa) {
                        if (!empty($ppa)) {
                            return $ppa->getCodPpa();
                        }
                    }
                )
            )
            ->add(
                'homologado',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'status'
                ),
                'choice',
                array(
                    'choices' => [
                        'label.ppa.homologado' => 'true',
                        'label.ppa.naoHomologado' => 'false'
                    ]
                )
            )
        ;
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        if ($filter['homologado'] != '') {
            $em = $this->modelManager->getEntityManager(Ppa::class);
            $ppaModel = new PpaModel($em);
            $result = $ppaModel->getPpasHomologados();

            $ids = array();
            foreach ($result as $codPpa) {
                $ids[] = $codPpa['codPpa'];
            }

            if (count($ids) == 0) {
                $queryBuilder->andWhere('1 = 0');
            }

            if ($filter['homologado']['value'] == 'true') {
                $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.codPpa", $ids));
            } else {
                $queryBuilder->andWhere($queryBuilder->expr()->notIn("{$alias}.codPpa", $ids));
            }
        }

        return true;
    }

    /**
     * @return array
     */
    public function getInfoPpa()
    {
        return $this->infoPpa;
    }

    /**
     * @param array $infoPpa
     */
    public function setInfoPpa($infoPpa)
    {
        $this->infoPpa = $infoPpa;
    }

    /**
     * @return mixed
     */
    public function getCodPpa()
    {
        return $this->codPpa;
    }

    /**
     * @param mixed $codPpa
     */
    public function setCodPpa($codPpa)
    {
        $this->codPpa = $codPpa;
    }

    /**
     * @param $codPpa
     * @return array
     */
    public function recuperaDadosPpa($codPpa, $type)
    {
        if (is_null($this->getCodPpa()) || $codPpa != $this->getCodPpa()) {
            $this->setCodPpa($codPpa);

            $entityManager = $this->modelManager->getEntityManager($this->getClass());
            $ppaModel = new PpaModel($entityManager);
            $dadosPpa = $ppaModel->getDadosPpa($codPpa);

            $this->setInfoPpa($dadosPpa);

            $dadosPpa = $this->getInfoPpa();
            if (is_null($dadosPpa[$type])) {
                return '';
            }

            return $dadosPpa[$type];
        }

        $dadosPpa = $this->getInfoPpa();
        if (is_null($dadosPpa[$type])) {
            return '';
        }

        return $dadosPpa[$type];
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('anoInicio', null, array('label' => 'label.ppa.anoInicio', 'sortable' => true))
            ->add('anoFinal', null, array('label' => 'label.ppa.anoFim', 'sortable' => true))
            ->add(
                'status',
                'customField',
                [
                    'label' => 'status',
                    'mapped' => false,
                    'template' => 'FinanceiroBundle:PlanoPlurianual\Ppa:status.html.twig',
                ]
            )
            ->add(
                'dtencaminhamento',
                'customField',
                [
                    'label' => 'label.ppa.dtEncaminhamento',
                    'mapped' => false,
                    'template' => 'FinanceiroBundle:PlanoPlurianual\Ppa:detalhes.html.twig',
                ]
            )
            ->add(
                'dtdevolucao',
                'customField',
                [
                    'label' => 'label.ppa.dtDevolucao',
                    'mapped' => false,
                    'template' => 'FinanceiroBundle:PlanoPlurianual\Ppa:detalhes.html.twig',
                ]
            )
            ->add(
                'nomperiodicidade',
                'customField',
                [
                    'label' => 'label.ppa.periodoApuracaoMetas',
                    'mapped' => false,
                    'template' => 'FinanceiroBundle:PlanoPlurianual\Ppa:detalhes.html.twig',
                ]
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'delete' => array('template' => 'FinanceiroBundle:PlanoPlurianual/Ppa:delete.html.twig'),
                    'homologar' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_homologar.html.twig'),
                    'estimativa' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_estimativa.html.twig'),
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setCustomHeader();

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $em = $this->modelManager->getEntityManager($this->getClass());
        $ppas = $em->getRepository('CoreBundle:Ppa\\Ppa')->findAll();
        $date = new \DateTime();
        $anoInicial = $date->format('Y');
        foreach ($ppas as $ppa) {
            if ($ppa->getAnoFinal() > $anoInicial) {
                $anoInicial = $ppa->getAnoFinal() + 1;
            }
        }
        $anoFinal = $anoInicial + 3;

        $fieldOptions = array();
        $fieldOptions['arredondarValores'] = array(
            'label'     => 'label.ppa.arredondamento',
            'mapped'    => false,
            'data'      => true,
            'attr'          => [
                'class'         => 'select2-parameters'
            ]
        );
        $fieldOptions['anoInicio'] = array(
            'label'         => 'label.ppa.anoInicio',
            'data'          => $anoInicial,
            'attr'          => array('readonly' => true)
        );
        $fieldOptions['anoFinal'] = array(
            'label'         => 'label.ppa.anoFim',
            'data'          => $anoFinal,
            'attr'          => array('readonly' => true)
        );

        $formMapper
            ->add('anoInicio', null, $fieldOptions['anoInicio'])
            ->add('anoFinal', null, $fieldOptions['anoFinal'])
            ->add('arredondarValores', 'checkbox', $fieldOptions['arredondarValores'])
            ->add('importado', null, ['label' => 'label.ppa.importar'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $this->setIncludeJs(['/financeiro/javascripts/ppa/consulta-ppa.js']);

        $em = $this->modelManager->getEntityManager($this->getClass());

        // Busca a lista de programas do PPA
        $params = ['ppa' => $this->getSubject()->getCodPpa()];

        $ppaModel = new PpaModel($em);
        $programasPpa = $ppaModel->getProgramasPpa($params);

        $showMapper
            ->add(
                'itensPrograma',
                'customField',
                [
                    'mapped' => false,
                    'label' => false,
                    'template' => 'FinanceiroBundle::PlanoPlurianual/Ppa/show.html.twig',
                    'data' => [
                        'programasPpa' => $programasPpa
                    ],
                    'attr' => [
                        'class' => ''
                    ]
                ]
            );
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $isHomologado = $this->getDoctrine()->getRepository(Ppa::class)->validaHomologacaoPorAno($object->getAnoInicio(), $object->getAnoFinal());
        if ($isHomologado) {
            $this->validatePpa(
                $errorElement,
                $this->getContainer()->get('translator')->transChoice('label.ppa.homologacaoMsg.jaHomologado', 0, [], 'messages'),
                "anoInicio"
            );
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param $error
     */
    public function validatePpa(ErrorElement $errorElement, $error, $with)
    {
        $errorElement->with($with)->addViolation($error)->end();
        $this->getRequest()->getSession()->getFlashBag()->add("error", $error);
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $object->setTimestamp(new \Datetime());
        $object->setValorTotalPpa(0);
        $em = $this->modelManager->getEntityManager($this->getClass());
        $ppaModel = (new \Urbem\CoreBundle\Model\Ppa\PpaModel($em));
        $ppaPorExercicio = $ppaModel->getPpaExercicio($this->getExercicio());

        $ppaModel->fnGerarDadosPpa($object->getAnoInicio(), $this->getExercicio());
        if (!empty($ppaPorExercicio)) {
            if (!$ppaPorExercicio->getFkPpaMacroObjetivos()->isEmpty()) {
                $ppaModel->iniciandoCopiaDadosParaPpa($ppaPorExercicio, $object, $this->getForm()->get('importado')->getData(), $this->getForm()->get('arredondarValores')->getData());
            }
        }
    }

    /**
     * @param $ppa
     * @return string
     */
    public function getStatus($ppa)
    {
        if (count($ppa->getFkPpaPpaPublicacoes())) {
            return 'Homologado';
        }
        return 'Não Homologado';
    }

    /**
     * @param mixed $object
     * @return bool
     */
    public function preRemove($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        if (count($object->getFkPpaPpaPublicacoes())) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.ppa.erroRemoverHomologado'));

            $this->getDoctrine()->clear();

            (new RedirectResponse($this->request->headers->get('referer')))->send();
        }
        return true;
    }
}
