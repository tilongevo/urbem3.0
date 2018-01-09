<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ppa;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Ppa\ProgramaDados;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Ppa\ProgramaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ProgramaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_plano_plurianual_programa';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/programa';
    protected $datagridValues = array(
       '_page' => 1,
       '_sort_order' => 'DESC',
       '_sort_by' => 'codPrograma'
    );

    protected $includeJs = array(
        '/financeiro/javascripts/ppa/programa.js',
        '/financeiro/javascripts/validate/input-number-validate.js'
    );

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('get_macro_objetivo', 'get-macro-objetivo', array(), array(), array(), '', array(), array('POST'));
        $collection->add('get_programa_setorial', 'get-programa-setorial', array(), array(), array(), '', array(), array('POST'));
        $collection->add('get_unidade_orgao', 'get-unidade-orgao', array(), array(), array(), '', array(), array('POST'));
        $collection->add('get_number_programa', 'get-number-programa', array(), array(), array(), '', array(), array('GET'));
    }

    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                    'indicadores' => array('template' => 'FinanceiroBundle:Ppa/Programa:indicadores_action.html.twig')
                )
            ))
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $boNatureza = new ProgramaModel($this->getDoctrine());
        $datagridMapper
            ->add(
                'inCodPPA',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.programas.inCodPPA'
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Ppa\Ppa',
                    'placeholder' => 'label.selecione',
                    'attr' => array(
                        'class' => 'select2-parameters'
                    )
                )
            )
            ->add(
                'boNatureza',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.programas.boNatureza'
                ),
                'choice',
                array(
                    'choices' => $boNatureza::NATUREZA_TEMPORAL,
                    'expanded' => true,
                    'label_attr' => array('class' => 'checkbox-sonata'),
                    'attr' => array('class' => 'checkbox-sonata')
                )
            )
            ->add(
                'numPrograma',
                null,
                array(
                    'label' => 'label.programas.numPrograma'
                )
            )
            ->add(
                'inIdPrograma',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.programas.inIdPrograma'
                )
            )
        ;
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        $queryBuilder->resetDQLPart('join');

        if ($filter['inCodPPA']['value'] != '') {
            $queryBuilder->innerJoin("{$alias}.fkPpaProgramaSetorial", "ps");
            $queryBuilder->innerJoin("ps.fkPpaMacroObjetivo", "mo");
            $queryBuilder->innerJoin("mo.fkPpaPpa", "ppa");
            $queryBuilder->andWhere("ppa.codPpa = :codPpa");
            $queryBuilder->setParameter("codPpa", $filter['inCodPPA']['value']);
        }

        $queryBuilder->innerJoin("{$alias}.fkPpaProgramaDados", "pd");

        if ($filter['boNatureza']['value'] != '') {
            $queryBuilder->andWhere("pd.continuo = :continuo");
            $queryBuilder->setParameter("continuo", ($filter['boNatureza']['value'] == 't' ? true : false));
        }

        if ($filter['inIdPrograma']['value'] != '') {
            $queryBuilder->andWhere('LOWER(pd.identificacao) LIKE :identificacao');
            $queryBuilder->setParameter("identificacao", sprintf('%%%s%%', mb_strtolower($filter['inIdPrograma']['value'])));
        }

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'numProgramaFormatado',
                null,
                array(
                    'label' => 'label.programas.numPrograma'
                )
            )
            ->add(
                'fkPpaProgramaSetorial.fkPpaMacroObjetivo.fkPpaPpa',
                'text',
                array(
                    'label' => 'label.programas.inCodPPA',
                )
            )
            ->add(
                'identificacao',
                null,
                array(
                    'label' => 'label.programas.inIdPrograma',
                )
            )
            ->add(
                'naturezaTemporalLabel',
                'trans',
                array(
                    'label' => 'label.programas.boNatureza',
                )
            )
        ;

        $this->addActionsGrid($listMapper);
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $this->exibirBotaoEditar = false;
        $this->exibirBotaoExcluir = false;
        $programaTemporarioVigencia = (new \Urbem\CoreBundle\Model\Ppa\ProgramaModel($this->getDoctrine()))
            ->getProgramaTemporarioVigencia($this->getObject($id));

        $showMapper
            ->with('label.programas.programaPpa')
            ->add('fkPpaProgramaSetorial.fkPpaMacroObjetivo.fkPpaPpa', 'string', ['label' => 'label.programas.inCodPPA'])
            ->add('identificacao', 'string', ['label' => 'label.programas.inCodMacroObjetivo'])
            ->add('fkPpaProgramaSetorial', 'string', ['label' => 'label.programas.codSetorial'])
            ->add('numPrograma', 'string', ['label' => 'label.programas.numPrograma'])
            ->add('getTipoPrograma', 'string', ['label' => 'label.programas.inCodTipoPrograma'])
            ->add('getProgramaDados.identificacao', 'string', ['label' => 'label.programas.inIdPrograma'])
            ->add('getJustificativa', 'text', ['label' => 'label.programas.stJustificativa'])
            ->add('getDiagnostico', 'text', ['label' => 'label.programas.inDigPrograma'])
            ->add('getObjetivo', 'string', ['label' => 'label.programas.inObjPrograma'])
            ->add('getDiretriz', 'string', ['label' => 'label.programas.inDirPrograma'])
            ->add('getPublicoAlvo', 'string', ['label' => 'label.programas.inPublicoAlvo'])
            ->add('getContinuo', 'trans', ['label' => 'label.programas.boNatureza'])
            ->add('getOrgao', 'string', ['label' => 'label.programas.inCodOrgao'])
            ->add('getUnidade', 'string', ['label' => 'label.programas.inCodUnidade'])
        ;

        if (!empty($programaTemporarioVigencia)) {
            $showMapper
                ->add(
                    'stDataInicial',
                    'text',
                    [
                        'label' => 'label.programas.stDataInicial',
                        'mapped' => false,
                        'template' => 'CoreBundle:Sonata/CRUD:show_custom_html.html.twig',
                        'data' => $programaTemporarioVigencia->getDtInicial()
                    ]
                )
                ->add(
                    'stDataFinal',
                    'text',
                    [
                        'label' => 'label.programas.stDataFinal',
                        'mapped' => false,
                        'template' => 'CoreBundle:Sonata/CRUD:show_custom_html.html.twig',
                        'data' => $programaTemporarioVigencia->getDtFinal()
                    ]
                )
            ;
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $boNatureza = new ProgramaModel($this->getDoctrine());
        $formOptions = array();

        $formOptions['exercicio'] = array(
            'mapped' => false,
            'data' => $this->getExercicio(),
        );

        $formOptions['inCodPPA'] = array(
            'mapped' => false,
            'label' => 'label.programas.inCodPPA',
            'class' => 'CoreBundle:Ppa\Ppa',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters'
            )
        );

        $formOptions['inCodMacroObjetivo'] = array(
            'mapped' => false,
            'choices' => array(),
            'label' => 'label.programas.inCodMacroObjetivo',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters',
                'disabled' => true
            )
        );

        $formOptions['codSetorial'] = array(
            'choices' => array(),
            'label' => 'label.programas.codSetorial',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters',
                'disabled' => true
            )
        );

        $formOptions['inCodTipoPrograma'] = array(
            'mapped' => false,
            'label' => 'label.programas.inCodTipoPrograma',
            'class' => 'CoreBundle:Ppa\TipoPrograma',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters'
            )
        );

        $formOptions['inIdPrograma'] = array(
            'mapped' => false,
            'label' => 'label.programas.inIdPrograma',
        );

        $formOptions['stJustificativa'] = array(
            'mapped' => false,
            'label' => 'label.programas.stJustificativa',
        );

        $formOptions['inDigPrograma'] = array(
            'mapped' => false,
            'label' => 'label.programas.inDigPrograma',
        );

        $formOptions['inObjPrograma'] = array(
            'mapped' => false,
            'label' => 'label.programas.inObjPrograma',
        );

        $formOptions['inDirPrograma'] = array(
            'mapped' => false,
            'label' => 'label.programas.inDirPrograma',
        );

        $formOptions['inPublicoAlvo'] = array(
            'mapped' => false,
            'label' => 'label.programas.inPublicoAlvo',
        );

        $formOptions['boNatureza'] = array(
            'mapped' => false,
            'label' => 'label.programas.boNatureza',
            'choices' => $boNatureza::NATUREZA_TEMPORAL,
            'expanded' => true,
            'label_attr' => array('class' => 'checkbox-sonata'),
            'attr' => array('class' => 'checkbox-sonata')
        );

        $formOptions['inCodOrgao'] = array(
            'mapped' => false,
            'label' => 'label.programas.inCodOrgao',
            'class' => 'CoreBundle:Orcamento\Orgao',
            'choice_value' => 'numOrgao',
            'placeholder' => 'label.selecione',
            'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                return $er->createQueryBuilder("u")
                    ->where("u.exercicio = '" . $this->getExercicio() . "'");
            },
            'attr' => array(
                'class' => 'select2-parameters'
            )
        );

        $formOptions['inCodUnidade'] = array(
            'class' => 'CoreBundle:Orcamento\Unidade',
            'choice_value' => 'numUnidade',
            'label' => 'label.programas.inCodUnidade',
            'mapped' => false,
            'auto_initialize' => false,
            'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                $queryBuilder = $er->createQueryBuilder('u');
                $queryBuilder->where('u.exercicio = :exercicio');
                $queryBuilder->setParameter('exercicio', $this->getExercicio());
                return $queryBuilder;
            },
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'required' => true
        );

        $formOptions['stDataInicial'] = array(
            'format' => 'dd/MM/yyyy',
            'label' => 'label.programas.stDataInicial',
            'mapped' => false,
            'required' => false
        );

        $formOptions['stDataFinal'] = array(
            'format' => 'dd/MM/yyyy',
            'label' => 'label.programas.stDataFinal',
            'mapped' => false,
            'required' => false
        );

        $formOptions['numPrograma'] = array(
            'label' => 'label.programas.numPrograma',
            'mapped' => false,
            'required' => true,
            'attr' => ['min' => 1, 'max' => 9999,
                'class' => 'validateNumber '
            ]
        );

        if ($this->id($this->getSubject())) {
            $programaDados = $this->getDoctrine()->getRepository(ProgramaDados::class)
                ->findOneBy(['codPrograma' => $this->getSubject()->getCodPrograma(), 'timestampProgramaDados' => $this->getSubject()->getUltimoTimestampProgramaDados()]);

            $programaTemporarioVigencia = (new \Urbem\CoreBundle\Model\Ppa\ProgramaModel($entityManager))
                ->getProgramaTemporarioVigencia($this->getSubject());

            $formOptions['inCodPPA']['data'] = $this->getSubject()->getFkPpaProgramaSetorial()
                ->getFkPpaMacroObjetivo()->getFkPpaPpa();
            $formOptions['inCodPPA']['disabled'] = true;
            $formOptions['numPrograma']['disabled'] = true;
            $formOptions['numPrograma']['data'] = $this->getSubject()->getNumPrograma();

            $continuo = 'f';
            if ($programaDados) {
                if ($programaDados->getContinuo()) {
                    $continuo = 't';
                }
                $formOptions['inCodTipoPrograma']['data'] = $programaDados->getFkPpaTipoPrograma();
                $formOptions['inIdPrograma']['data'] = $programaDados->getIdentificacao();
                $formOptions['stJustificativa']['data'] = $programaDados->getJustificativa();
                $formOptions['inDigPrograma']['data'] = $programaDados->getDiagnostico();
                $formOptions['inObjPrograma']['data'] = $programaDados->getObjetivo();
                $formOptions['inDirPrograma']['data'] = $programaDados->getDiretriz();
                $formOptions['inPublicoAlvo']['data'] = $programaDados->getPublicoAlvo();
                $formOptions['boNatureza']['data'] = $continuo;

                $codOrgao = $programaDados->getFkOrcamentoUnidade()->getFkOrcamentoOrgao();
                $formOptions['inCodOrgao']['choice_attr'] = function ($entidade, $key, $index) use ($codOrgao) {
                    if ($entidade->getNumOrgao() == $codOrgao->getNumOrgao()) {
                        return ['selected' => 'selected'];
                    } else {
                        return ['selected' => false];
                    }
                };
            }

            if ($programaTemporarioVigencia) {
                $formOptions['stDataInicial']['data'] = $programaTemporarioVigencia->getDtInicial();
                $formOptions['stDataFinal']['data'] = $programaTemporarioVigencia->getDtFinal();
            } else {
                $formOptions['stDataInicial']['data'] = new \DateTime();
                $formOptions['stDataFinal']['data'] = new \DateTime();
            }
        }

        $formMapper
            ->with('label.programas.dadosInclusaoProgramasPPA')
                ->add(
                    'exercicio',
                    'hidden',
                    $formOptions['exercicio']
                )
                ->add(
                    'inCodPPA',
                    'entity',
                    $formOptions['inCodPPA']
                )
                ->add(
                    'inCodMacroObjetivo',
                    'choice',
                    $formOptions['inCodMacroObjetivo']
                )
                ->add(
                    'codSetorial',
                    'choice',
                    $formOptions['codSetorial']
                )
                ->add(
                    'numPrograma',
                    null,
                    $formOptions['numPrograma']
                )
                ->add(
                    'inCodTipoPrograma',
                    'entity',
                    $formOptions['inCodTipoPrograma']
                )
                ->add(
                    'inIdPrograma',
                    'textarea',
                    $formOptions['inIdPrograma']
                )
                ->add(
                    'stJustificativa',
                    'textarea',
                    $formOptions['stJustificativa']
                )
                ->add(
                    'inDigPrograma',
                    'textarea',
                    $formOptions['inDigPrograma']
                )
                ->add(
                    'inObjPrograma',
                    'textarea',
                    $formOptions['inObjPrograma']
                )
                ->add(
                    'inDirPrograma',
                    'textarea',
                    $formOptions['inDirPrograma']
                )
                ->add(
                    'inPublicoAlvo',
                    'textarea',
                    $formOptions['inPublicoAlvo']
                )
                ->add(
                    'boNatureza',
                    'choice',
                    $formOptions['boNatureza']
                )
                ->add(
                    'stDataInicial',
                    'sonata_type_date_picker',
                    $formOptions['stDataInicial']
                )
                ->add(
                    'stDataFinal',
                    'sonata_type_date_picker',
                    $formOptions['stDataFinal']
                )
            ->end()
            ->with('label.programas.orgaoResponsavel')
                ->add(
                    'inCodOrgao',
                    'entity',
                    $formOptions['inCodOrgao']
                )
                ->add(
                    'inCodUnidade',
                    'entity',
                    $formOptions['inCodUnidade']
                )
            ->end()
        ;

        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin) {
                $form = $event->getForm();
                $data = $event->getData();
                $subject = $admin->getSubject($data);

                if ($form->has('inCodMacroObjetivo')) {
                    $form->remove('inCodMacroObjetivo');
                }

                if (isset($data['inCodPPA']) && $data['inCodPPA'] != "") {
                    $codMacro = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'inCodMacroObjetivo',
                        'entity',
                        null,
                        array(
                            'class' => 'CoreBundle:Ppa\MacroObjetivo',
                            'label' => 'label.programas.inCodMacroObjetivo',
                            'mapped' => false,
                            'auto_initialize' => false,
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $er) use ($data) {
                                return $er->createQueryBuilder("u")
                                    ->where("u.codPpa = {$data['inCodPPA']}");
                            },
                            'placeholder' => 'label.selecione',
                            'attr' => array(
                                'class' => 'select2-parameters'
                            )
                        )
                    );

                    $form->add($codMacro);
                }

                if ($form->has('codSetorial')) {
                    $form->remove('codSetorial');
                }

                if (isset($data['inCodMacroObjetivo'])) {
                    $codSetorial = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codSetorial',
                        'entity',
                        null,
                        array(
                            'class' => 'CoreBundle:Ppa\ProgramaSetorial',
                            'label' => 'label.programas.codSetorial',
                            'mapped' => false,
                            'auto_initialize' => false,
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $er) use ($data) {
                                return $er->createQueryBuilder("u")
                                    ->where("u.codMacro = {$data['inCodMacroObjetivo']}");
                            },
                            'placeholder' => 'label.selecione',
                            'attr' => array(
                                'class' => 'select2-parameters'
                            )
                        )
                    );
                    $form->add($codSetorial);
                }

                if ($form->has('inCodUnidade')) {
                    $form->remove('inCodUnidade');
                }

                if (isset($data['inCodOrgao'])) {
                    $inCodUnidade = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'inCodUnidade',
                        'entity',
                        null,
                        array(
                            'class' => 'CoreBundle:Orcamento\Unidade',
                            'choice_value' => 'numUnidade',
                            'label' => 'label.programas.inCodUnidade',
                            'mapped' => false,
                            'auto_initialize' => false,
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $er) use ($data) {
                                return $er->createQueryBuilder("u")
                                    ->where("u.exercicio = '" . $this->getExercicio() . "' AND u.numOrgao = {$data['inCodOrgao']}");
                            },
                            'placeholder' => 'label.selecione',
                            'attr' => array(
                                'class' => 'select2-parameters'
                            )
                        )
                    );
                    $form->add($inCodUnidade);
                }
            }
        );

        if ($this->id($this->getSubject())) {
            $formMapper->getFormBuilder()->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use ($formMapper, $admin, $programaDados) {
                    $form = $event->getForm();
                    $data = $event->getData();
                    $subject = $admin->getSubject($data);

                    $codMacro = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'inCodMacroObjetivo',
                        'entity',
                        null,
                        array(
                            'class' => 'CoreBundle:Ppa\MacroObjetivo',
                            'label' => 'label.programas.inCodMacroObjetivo',
                            'mapped' => false,
                            'auto_initialize' => false,
                            'data' => $this->getSubject()->getFkPpaProgramaSetorial()->getFkPpaMacroObjetivo(),
                            'placeholder' => 'label.selecione',
                            'attr' => array(
                                'class' => 'select2-parameters'
                            ),
                            'disabled' => true
                        )
                    );

                    $form->add($codMacro);

                    if ($form->has('codSetorial')) {
                        $form->remove('codSetorial');
                    }

                    $codSetorial = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codSetorial',
                        'entity',
                        null,
                        array(
                            'class' => 'CoreBundle:Ppa\ProgramaSetorial',
                            'label' => 'label.programas.codSetorial',
                            'mapped' => false,
                            'auto_initialize' => false,
                            'data' => $subject->getFkPpaProgramaSetorial(),
                            'placeholder' => 'label.selecione',
                            'attr' => array(
                                'class' => 'select2-parameters'
                            ),
                            'disabled' => true,
                        )
                    );
                    $form->add($codSetorial);

                    if ($form->has('inCodUnidade')) {
                        $form->remove('inCodUnidade');
                    }

                    $inCodUnidade = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'inCodUnidade',
                        'entity',
                        null,
                        array(
                            'class' => 'CoreBundle:Orcamento\Unidade',
                            'choice_value' => 'numUnidade',
                            'label' => 'label.programas.inCodUnidade',
                            'mapped' => false,
                            'auto_initialize' => false,
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $er) use ($data, $programaDados) {
                                $queryBuilder = $er->createQueryBuilder('u');
                                $queryBuilder->where('u.exercicio = :exercicio');
                                $queryBuilder->setParameter('exercicio', $this->getExercicio());
                                if ($programaDados) {
                                    $queryBuilder->andWhere('u.numOrgao = :numOrgao');
                                    $queryBuilder->setParameter('numOrgao', $programaDados->getNumOrgao());
                                }
                                $queryBuilder->orderBy('u.numUnidade', 'ASC');
                                return $queryBuilder;
                            },
                            'placeholder' => 'label.selecione',
                            'data' => ($programaDados) ? $programaDados->getFkOrcamentoUnidade() : null,
                            'attr' => array(
                                'class' => 'select2-parameters'
                            ),
                            'required' => true
                        )
                    );

                    $form->add($inCodUnidade);
                }
            );
        }
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $programaRepository = $entityManager->getRepository('CoreBundle:Ppa\Programa');
        $codPrograma = $programaRepository->getProximoCodGrupo();
        $numPrograma = $this->getForm()->get('numPrograma')->getData();
        if (!$numPrograma) {
            $numPrograma = $programaRepository->getProximoNumPrograma();
        }

        $object->setCodPrograma($codPrograma);
        $object->setNumPrograma($numPrograma);
        $object->setFkPpaProgramaSetorial($this->getForm()->get('codSetorial')->getData());
        $object->setUltimoTimestampProgramaDados(new DateTimeMicrosecondPK());
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $object->setUltimoTimestampProgramaDados(new DateTimeMicrosecondPK());
    }

    /**
     * @param mixed $object
     */
    public function postPersist($object)
    {
        $this->post($object);
    }

    /**
     * @param mixed $object
     */
    public function postUpdate($object)
    {
        $this->post($object);
    }


    /**
     * @param mixed $object
     * @return bool|\Symfony\Component\HttpFoundation\Response|void
     */
    public function preRemove($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        (new \Urbem\CoreBundle\Model\Ppa\ProgramaModel($entityManager))
        ->removeRelationships($object);
    }

    /**
     * @param \Sonata\CoreBundle\Validator\ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        if (!$this->id($this->getSubject())) {
            $entityManager = $this->modelManager->getEntityManager($this->getClass());
            $result = (new \Urbem\CoreBundle\Model\Ppa\ProgramaModel($entityManager))
                ->getNumberPrograma($this->getForm()->get('numPrograma')->getData());

            if (!$this->getForm()->get('numPrograma')->getData()) {
                $errorElement->with('numPrograma')->addViolation($this->getTranslator()->trans('label.programas.validate.required'))->end();
            } elseif ($this->getForm()->get('numPrograma')->getData() && !$result) {
                $errorElement->with('numPrograma')->addViolation($this->getTranslator()->trans('label.programas.validate.programaExistente'))->end();
            }
        }
    }
    /**
     * @param $object
     */
    protected function post($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $model =  (new \Urbem\CoreBundle\Model\Ppa\ProgramaModel($entityManager));

        $model->newProgramaDados($this->getForm(), $object);
        $arrayCollection = new ArrayCollection();
        $arrayCollection->set('object', $object);
        $arrayCollection->set('model', $model);
        array_map([$this, (preg_replace('/.*(::)/', '', $this->getRequest()->attributes->get('_controller')) . 'OrcamentoPrograma')], [$arrayCollection]);
    }

    /**
     * @param Collection $collection
     */
    protected function createActionOrcamentoPrograma(Collection $collection)
    {
        $collection->get('model')->newOrcaomentoPrograma($this->getForm(), $collection->get('object'));
    }

    /**
     * @param Collection $collection
     */
    protected function editActionOrcamentoPrograma(Collection $collection)
    {
        $collection->get('model')->editOrcaomentoPrograma($this->getForm(), $collection->get('object'));
    }
}
