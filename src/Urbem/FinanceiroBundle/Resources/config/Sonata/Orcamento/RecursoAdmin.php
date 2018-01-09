<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model\Orcamento\OrgaoModel;
use Urbem\CoreBundle\Model\Orcamento\RecursoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class RecursoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_plano_plurianual_recursos';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/recursos';
    protected $model = RecursoModel::class;

    const TIPO_LIVRE = 'L';
    const TIPO_VINCULADO = 'V';

    public function createQuery($context = 'list')
    {
        $exercicio = $this->getExercicio();
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $exercicio);
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(array('codRecurso'));

        $datagridMapper
            ->add(
                'codRecurso',
                null,
                array(
                    'label' => 'label.recurso.codRecurso'
                )
            )
            ->add(
                'fkOrcamentoRecursoDireto.tipo',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.recurso.tipo'
                ),
                'choice',
                array(
                    'choices' => array(
                        'label.recurso.vinculado' => self::TIPO_VINCULADO,
                        'label.recurso.livre' => self::TIPO_LIVRE
                    )
                )
            )
            ->add(
                'nomRecurso',
                null,
                array(
                    'label' => 'label.recurso.nomRecurso'
                )
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'codRecurso',
                null,
                array(
                    'label' => 'label.recurso.codRecurso'
                )
            )
            ->add(
                'nomRecurso',
                null,
                array(
                    'label' => 'label.recurso.nomRecurso'
                )
            )
            ->add(
                'fkOrcamentoRecursoDireto.tipo',
                'choice',
                array(
                    'label' => 'label.recurso.tipo',
                    'choices' => array(
                        self::TIPO_VINCULADO => $this->getTranslator()->trans('label.recurso.vinculado'),
                        self::TIPO_LIVRE => $this->getTranslator()->trans('label.recurso.livre')
                    )
                )
            )
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.recurso.dadosRecurso')
                ->add(
                    'codRecurso',
                    null,
                    array(
                        'label' => 'label.recurso.codRecurso'
                    )
                )
                ->add(
                    'nomRecurso',
                    null,
                    array(
                        'label' => 'label.recurso.nomRecurso'
                    )
                )
                ->add(
                    'fkOrcamentoRecursoDireto.tipo',
                    'choice',
                    array(
                        'label' => 'label.recurso.tipo',
                        'choices' => [
                            self::TIPO_VINCULADO => $this->getTranslator()->trans('label.recurso.vinculado'),
                            self::TIPO_LIVRE => $this->getTranslator()->trans('label.recurso.livre')
                        ]
                    )
                )
            ->end()
        ;
    }
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $exercicio = $this->getExercicio();

        $fieldOptions = array();

        $fieldOptions['exercicio'] = array(
            'data' => $exercicio,
            'mapped' => false
        );

        $fieldOptions['codRecurso'] = array(
            'label' => 'label.recurso.codRecurso',
            'attr' => ['min' => "1", 'max' => "9999", 'maxlength' => "4"],
            'mapped' => false
        );

        $fieldOptions['nomRecurso'] = array(
            'label' => 'label.recurso.nomRecurso',
            'attr' => [
                'maxlength' => 160
            ]
        );

        if ($this->id($this->getSubject())) {
            $fieldOptions['codRecurso']['disabled'] = 'disabled';
            $fieldOptions['codRecurso']['data'] = $this->getSubject()->getCodRecurso();
        }

        $formMapper
            ->with('label.recurso.dadosRecurso')
                ->add(
                    'exercicio',
                    'hidden',
                    $fieldOptions['exercicio']
                )
                ->add(
                    'codRecurso',
                    null,
                    $fieldOptions['codRecurso']
                )
                ->add(
                    'nomRecurso',
                    null,
                    $fieldOptions['nomRecurso']
                )
                ->add(
                    'fkOrcamentoRecursoDireto',
                    'sonata_type_admin',
                    [
                        'by_reference' => true,
                        'label' => false
                    ],
                    [
                        'edit' => 'inline',
                        'inline' => 'table'
                    ]
                )
            ->end()
        ;
    }

    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        if (!$this->id($this->getSubject())) {
            $entityManager = $this->modelManager->getEntityManager($this->getClass());
            $recurso = $entityManager->getRepository('CoreBundle:Orcamento\Recurso')
                ->findOneBy([
                    'exercicio' => $this->getForm()->get('exercicio')->getData(),
                    'codRecurso' => $this->getForm()->get('codRecurso')->getData()
                ]);

            if ($recurso) {
                $error = $this->getTranslator()->trans('label.recurso.recursoExistente');
                $errorElement->with('codRecurso')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_error", $error);
            }

            if (strlen($this->getForm()->get('codRecurso')->getData()) > 4) {
                $error = $this->getTranslator()->trans('label.recurso.codDigitos');
                $errorElement->with('codRecurso')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_error", $error);
            }
        }

        if ($this->getForm()->get('fkOrcamentoRecursoDireto')->get('codigoTc')->getData() < 0) {
            $error = $this->getTranslator()->trans('label.recurso.numNegativo');
            $errorElement->with('fkOrcamentoRecursoDireto')->with('codigoTc')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_error", $error);
        }

        if (strlen($this->getForm()->get('fkOrcamentoRecursoDireto')->get('finalidade')->getData()) > 160) {
            $error = $this->getTranslator()->trans('label.recurso.erroTamanhoTexto');
            $errorElement->with('fkOrcamentoRecursoDireto')->with('finalidade')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_error", $error);
        }
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $exercicio = $this->getForm()->get('exercicio')->getData();
        $codRecurso = $this->getForm()->get('codRecurso')->getData();

        $object->setExercicio($exercicio);
        $object->setCodRecurso($codRecurso);
        $object->setCodFonte(str_pad($codRecurso, 4, "0", STR_PAD_LEFT));

        $object->getFkOrcamentoRecursoDireto()->setFkOrcamentoRecurso($object);
        $object->getFkOrcamentoRecursoDireto()->setNomRecurso($object->getNomRecurso());

        $periodo = (new OrgaoModel($entityManager))
            ->getPpaByExercicio($exercicio);

        $recursoModel = new RecursoModel($entityManager);
        $recursoModel->salvaRecursosPeriodo($object, $periodo);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $object->getFkOrcamentoRecursoDireto()->setFkOrcamentoRecurso($object);
        $object->getFkOrcamentoRecursoDireto()->setNomRecurso($object->getNomRecurso());

        $periodo = (new OrgaoModel($entityManager))
            ->getPpaByExercicio($object->getExercicio());

        $recursoModel = new RecursoModel($entityManager);
        $recursoModel->atualizaRecursosPeriodo($object, $periodo);
    }

    public function preRemove($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $recursoModel = new RecursoModel($em);
        if (!$recursoModel->canRemove($object)) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('erroRemove'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        } else {
            $periodo = (new OrgaoModel($em))
                ->getPpaByExercicio($object->getExercicio());
            $recursoModel->apagaRecursosPeriodo($object, $periodo);
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param $object
     * @return string
     */
    public function toString($object)
    {
        return $object->getCodRecurso()
            ? $object
            : $this->getTranslator()->trans('label.recurso.modulo');
    }
}
