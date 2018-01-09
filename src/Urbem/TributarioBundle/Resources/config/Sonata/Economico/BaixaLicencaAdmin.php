<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use DateTime;
use Exception;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Economico\BaixaLicenca;
use Urbem\CoreBundle\Entity\Economico\Licenca;
use Urbem\CoreBundle\Entity\Economico\ProcessoBaixaLicenca;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class BaixaLicencaAdmin extends AbstractSonataAdmin
{
    const TIPO_BAIXA = 1;
    const TIPO_SUSPENSAO = 2;
    const TIPO_CASSACAO = 3;

    public $codTipo;

    protected $baseRouteName = 'urbem_tributario_economico_baixa_licenca';
    protected $baseRoutePattern = 'tributario/cadastro-economico/licenca/baixa';
    protected $includeJs = ['/tributario/javascripts/economico/baixa-licenca.js'];

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        if ($this->codTipo == $this::TIPO_SUSPENSAO && $this->getAdminRequestId()) {
            return;
        }

        $form = $this->getForm();

        $baixaLicenca = $em->getRepository(BaixaLicenca::class)->findOneBy(
            [
                'codLicenca' => $this->getRequest()->get('codLicenca'),
                'exercicio' => $this->getRequest()->get('exercicio'),
                'dtInicio' => $form->get('dtInicio')->getData(),
            ]
        );

        if (!$baixaLicenca) {
            return;
        }

        $error = $this->getTranslator()->trans('label.economicoBaixaLicenca.erro');
        $errorElement->with('dtInicio')->addViolation($error)->end();
    }

    /**
    * @param BaixaLicenca $baixaLicenca
    * @return BaixaLicenca|null
    */
    public function getSuspensao(BaixaLicenca $baixaLicenca = null)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $codLicenca = $baixaLicenca ? $baixaLicenca->getCodLicenca() : $this->getRequest()->get('codLicenca');
        $exercicio = $baixaLicenca ? $baixaLicenca->getExercicio() : $this->getRequest()->get('exercicio');

        $qb = $em->getRepository(BaixaLicenca::class)->createQueryBuilder('o');

        $qb->andWhere('o.codLicenca = :codLicenca');
        $qb->setParameter('codLicenca', $codLicenca);

        $qb->andWhere('o.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);

        $qb->andWhere('o.codTipo = :codTipo');
        $qb->setParameter('codTipo', $this::TIPO_SUSPENSAO);

        $qb->andWhere('(o.dtTermino IS NULL OR o.dtTermino > CURRENT_DATE())');

        $qb->orderBy('o.timestamp', 'DESC');

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getLegendButtonSave()
    {
        $legend = ['icon' => 'arrow_downward', 'text' => 'Baixar'];
        if ($this->codTipo == $this::TIPO_SUSPENSAO && !$this->getAdminRequestId()) {
            $legend = ['icon' => 'arrow_downward', 'text' => 'Suspender'];
        }

        if ($this->codTipo == $this::TIPO_SUSPENSAO && $this->getAdminRequestId()) {
            $legend = ['icon' => 'arrow_downward', 'text' => 'Cancelar Suspensão'];
        }

        if ($this->codTipo == $this::TIPO_CASSACAO) {
            $legend = ['icon' => 'arrow_downward', 'text' => 'Cassar'];
        }

        return $legend;
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add('baixar', 'baixar');
        $routes->add('cassar', 'cassar');
        $routes->add('suspender', 'suspender');
        $routes->add('cancelar_suspensao', sprintf('cancelar-suspensao/%s', $this->getRouterIdParameter()));

        $routes->clearExcept(['baixar', 'cassar', 'suspender', 'cancelar_suspensao', 'create', 'edit']);
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return [];
        }

        return [
            'codLicenca' => $this->getRequest()->get('codLicenca'),
            'exercicio' => $this->getRequest()->get('exercicio'),
        ];
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $this->populateObject($object);

        $this->saveObject($object);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->populateObject($object);

        $this->saveObject($object);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $licenca = $em->getRepository(Licenca::class)->findOneBy(
            [
                'codLicenca' => $this->getRequest()->get('codLicenca'),
                'exercicio' => $this->getRequest()->get('exercicio'),
            ]
        );

        $licenca = $licenca ?: new Licenca();

        $fieldOptions = [];
        $fieldOptions['dtInicio'] = [
            'pk_class' => DatePK::class,
            'dp_default_date' => (new DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'label' => 'label.economicoBaixaLicenca.dtBaixa',
        ];

        $fieldOptions['dtTermino'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'readonly' => true,
            ]
        ];

        $fieldOptions['fkSwClassificacao'] = array(
            'class' => SwClassificacao::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('o')
                    ->orderBy('o.codClassificacao', 'ASC');
            },
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters js-select-processo-classificacao'
            ),
            'label' => 'label.economicoCadastroEconomico.processoClassificacao',
        );

        $fieldOptions['fkSwAssunto'] = array(
            'class' => SwAssunto::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('o')
                    ->orderBy('o.codAssunto', 'ASC');
            },
            'choice_value' => 'codAssunto',
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters js-select-processo-assunto'
            ),
            'label' => 'label.economicoCadastroEconomico.processoAssunto',
        );

        $fieldOptions['fkSwProcesso'] = [
            'class' => SwProcesso::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');
                $qb->innerJoin('o.fkAdministracaoUsuario', 'u');
                $qb->innerJoin('u.fkSwCgm', 'cgm');
                if ($request->get('codClassificacao') != '') {
                    $qb->andWhere('o.codClassificacao = :codClassificacao');
                    $qb->setParameter('codClassificacao', (int) $request->get('codClassificacao'));
                }
                if ($request->get('codAssunto') != '') {
                    $qb->andWhere('o.codAssunto = :codAssunto');
                    $qb->setParameter('codAssunto', (int) $request->get('codAssunto'));
                }
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->eq('o.codProcesso', ':codProcesso'),
                    $qb->expr()->eq('cgm.numcgm', ':numCgm'),
                    $qb->expr()->like('LOWER(cgm.nomCgm)', $qb->expr()->literal('%' . strtolower($term) . '%'))
                ));
                $qb->setParameter('numCgm', (int) $term);
                $qb->setParameter('codProcesso', (int) $term);
                $qb->orderBy('o.codProcesso', 'ASC');
                return $qb;
            },
            'required' => false,
            'req_params' => [
                'inscricaoEconomica' => 'varJsInscricaoEconomica',
                'codClassificacao' => 'varJsCodClassificacao',
                'codAssunto' => 'varJsCodAssunto',
            ],
            'attr' => [
                'class' => 'select2-parameters js-processo',
            ],
            'label' => 'label.economicoCadastroEconomico.processo',
        ];

        if ($this->codTipo == $this::TIPO_SUSPENSAO) {
            $fieldOptions['dtInicio']['label'] = 'label.economicoBaixaLicenca.dtSuspensao';
            $fieldOptions['dtTermino'] = [
                'pk_class' => DatePK::class,
                'mapped' => false,
                'required' => false,
                'format' => 'dd/MM/yyyy',
                'label' => 'label.economicoBaixaLicenca.dtTermino',
            ];
        }

        if ($this->codTipo == $this::TIPO_CASSACAO) {
            $fieldOptions['dtInicio']['label'] = 'label.economicoBaixaLicenca.dtCassacao';
        }

        if ($id) {
            $baixaLicenca = $this->getSubject();
            $licenca = $baixaLicenca->getFkEconomicoLicenca();

            $fieldOptions['dtInicio']['disabled'] = true;
            $fieldOptions['dtTermino']['required'] = true;
            $fieldOptions['dtTermino']['data'] = $baixaLicenca->getDtTermino();

            if ($baixaLicenca->getFkEconomicoProcessoBaixaLicencas()->count()) {
                $processo = $baixaLicenca->getFkEconomicoProcessoBaixaLicencas()->last();

                $fieldOptions['fkSwClassificacao']['disabled'] = true;
                $fieldOptions['fkSwClassificacao']['data'] = $processo->getFkSwProcesso()->getFkSwAssunto()->getFkSwClassificacao();

                $fieldOptions['fkSwAssunto']['disabled'] = true;
                $fieldOptions['fkSwAssunto']['data'] = $processo->getFkSwProcesso()->getFkSwAssunto();

                $fieldOptions['fkSwProcesso']['disabled'] = true;
                $fieldOptions['fkSwProcesso']['data'] = $processo->getFkSwProcesso();
            }
        }

        $formMapper
            ->with('label.economico.licenca.dadosLicenca')
                ->add(
                    'codTipo',
                    'hidden',
                    [
                        'data' => $this->codTipo,
                        'attr' => [
                            'readonly' => true,
                        ]
                    ]
                )
                ->add(
                    'codLicenca',
                    'hidden',
                    [
                        'data' => $licenca->getCodLicenca(),
                        'attr' => [
                            'readonly' => true,
                        ]
                    ]
                )
                ->add(
                    'numLicenca',
                    'text',
                    [
                        'mapped' => false,
                        'disabled' => true,
                        'data' => sprintf('%s/%s', $licenca->getCodLicenca(), $licenca->getExercicio()),
                        'label' => 'label.economico.licenca.numLicenca',
                    ]
                )
                ->add(
                    'cgm',
                    'text',
                    [
                        'mapped' => false,
                        'disabled' => true,
                        'data' => $this->getCgm($licenca),
                        'label' => 'label.economicoBaixaLicenca.cgm',
                    ]
                )
                ->add(
                    'dtInicio',
                    'datepkpicker',
                    $fieldOptions['dtInicio']
                )
                ->add(
                    'dtTermino',
                    $this->codTipo == $this::TIPO_SUSPENSAO ? 'datepkpicker' : 'hidden',
                    $fieldOptions['dtTermino']
                )
            ->end()
            ->with('label.economicoBaixaLicenca.cabecalhoProcesso')
                ->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao'])
                ->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto'])
                ->add(
                    'fkSwProcesso',
                    'autocomplete',
                    $fieldOptions['fkSwProcesso'],
                    [
                        'admin_code' => 'administrativo.admin.processo'
                    ]
                )
            ->end()
            ->with('label.economicoBaixaLicenca.cabecalhoMotivo')
                ->add(
                    'motivo',
                    'textarea',
                    [
                        'label' => false,
                    ]
                )
            ->end();
    }

    /**
    * @param Licenca $licenca
    * @return Urbem\CoreBundle\Entity\SwCgm
    */
    protected function getCgm(Licenca $licenca)
    {
        if ($licenca->getFkEconomicoLicencaDiversa()) {
            return $licenca->getFkEconomicoLicencaDiversa()->getFkSwCgm();
        }

        if ($licencaAtividade = $licenca->getFkEconomicoLicencaAtividades()->last()) {
            $cadastroEconomico = $licencaAtividade->getFkEconomicoAtividadeCadastroEconomico()->getFkEconomicoCadastroEconomico();
        }

        if ($licencaEspecial = $licenca->getFkEconomicoLicencaEspeciais()->last()) {
            $cadastroEconomico = $licencaEspecial->getFkEconomicoAtividadeCadastroEconomico()->getFkEconomicoCadastroEconomico();
        }

        if (!empty($cadastroEconomico)) {
            if ($empresaFato = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaFato()) {
                return $empresaFato->getFkSwCgmPessoaFisica()->getFkSwCgm();
            }

            if ($autonomo = $cadastroEconomico->getFkEconomicoCadastroEconomicoAutonomo()) {
                return $autonomo->getFkSwCgmPessoaFisica()->getFkSwCgm();
            }

            if ($empresaDireito = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaDireito()) {
                return $empresaDireito->getFkSwCgmPessoaJuridica()->getFkSwCgm();
            }
        }
    }

    /**
    * @param Licenca $object
    */
    protected function populateObject($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();

        $licenca = $em->getRepository(Licenca::class)->findOneBy(
            [
                'codLicenca' => $this->getRequest()->get('codLicenca'),
                'exercicio' => $this->getRequest()->get('exercicio'),
            ]
        );

        if (!$this->getAdminRequestId()) {
            $object->setFkEconomicoLicenca($licenca);
        }

        if ($dtTermino = $form->get('dtTermino')->getData()) {
            $object->setDtTermino((new DateTime())->createFromFormat('d/m/Y', $dtTermino));
        }

        if ($form->get('fkSwProcesso')->getData() && !$this->getAdminRequestId()) {
            $processo = $form->get('fkSwProcesso')->getData();
            $processoBaixaLicenca = (new ProcessoBaixaLicenca())->setFkSwProcesso($processo);
            $object->addFkEconomicoProcessoBaixaLicencas($processoBaixaLicenca);
        }
    }

    /**
    * @param Licenca $object
    */
    protected function saveObject($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();
        $em->getConnection()->beginTransaction();

        $label = 'label.economicoBaixaLicenca.baixar.msgBaixar';
        if ($object->getCodTipo() == $this::TIPO_SUSPENSAO) {
            $label = 'label.economicoBaixaLicenca.suspender.msgSuspender';
        }

        if ($object->getCodTipo() == $this::TIPO_CASSACAO) {
            $label = 'label.economicoBaixaLicenca.cassar.msgCassar';
        }

        try {
            if ($this->getAdminRequestId()) {
                $em->merge($object);
            }

            $em->persist($object);
            $em->flush();
            $em->getConnection()->commit();

            $container->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    $this->getTranslator()->trans($label)
                );
        } catch (Exception $e) {
            $em->getConnection()->rollBack();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
        } finally {
            $licenca = $object->getFkEconomicoLicenca();
            if ($licenca->getFkEconomicoLicencaDiversa()) {
                $this->forceRedirect('/tributario/cadastro-economico/licenca/licenca-diversa/list');
            }

            if ($licenca->getFkEconomicoLicencaAtividades()->count()) {
                $this->forceRedirect('/tributario/cadastro-economico/licenca/licenca-atividade/list');
            }

            if ($licenca->getFkEconomicoLicencaEspeciais()->count()) {
                $this->forceRedirect('/tributario/cadastro-economico/licenca/licenca-especial/list');
            }
        }
    }
}
