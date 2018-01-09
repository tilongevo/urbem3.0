<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Entity\Pessoal\Dependente;
use Urbem\CoreBundle\Entity\Pessoal\Incidencia;
use Urbem\CoreBundle\Entity\Pessoal\Pensao;
use Urbem\CoreBundle\Entity\Pessoal\ServidorDependente;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Model\Administracao\FuncaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PensaoFuncaoPadraoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorModel;
use Urbem\CoreBundle\Model\Pessoal\PensaoBancoModel;
use Urbem\CoreBundle\Model\Pessoal\PensaoFuncaoModel;
use Urbem\CoreBundle\Model\Pessoal\PensaoIncidenciaModel;
use Urbem\CoreBundle\Model\Pessoal\PensaoModel;
use Urbem\CoreBundle\Model\Pessoal\PensaoValorModel;
use Urbem\CoreBundle\Model\Pessoal\ResponsavelLegalModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ServidorDependenteAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_pensao_alimenticia';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/pensao-alimenticia';

    protected $includeJs = [
        '/recursoshumanos/javascripts/pessoal/pensaoForm.js'
    ];

    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoExcluir = false;

    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('inativar', '{id}/inativar');
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        return $query;
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     *
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $filter = $this->getDataGrid()->getValues();

        // FILTRO POR MATRICULA
        if (!empty($filter['codContrato']['value'])) {
            $contratos = $filter['codContrato']['value'];

            $rootAlias = $queryBuilder->getRootAlias();

            $queryBuilder->resetDQLPart('where');
            $queryBuilder->join("$rootAlias.fkPessoalServidor", "servidor");
            $queryBuilder->join("servidor.fkPessoalServidorContratoServidores", "servidorContratosServidor");
            $queryBuilder->join("servidorContratosServidor.fkPessoalContratoServidor", "contratoServidor");
            $queryBuilder->join("contratoServidor.fkPessoalContrato", "contrato");

            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('contrato.codContrato', $contratos)
            );
        }
        return true;
    }


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->setBreadCrumb();

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $fielOptions['fkPessoalDependente'] = [
            'property' => 'fkSwCgmPessoaFisica.fkSwCgm.nomCgm',
            'to_string_callback' => function (Dependente $dependente, $property) {
                return (string) $dependente->getFkSwCgmPessoaFisica();
            },
            'callback' => function (AbstractSonataAdmin $admin, $property, $value) {
                $cgm = (int) $value;

                $datagrid = $admin->getDatagrid();
                /** @var QueryBuilder|ProxyQueryInterface $query */
                $query = $datagrid->getQuery();

                $rootAlias = $query->getRootAlias();

                $query->join("$rootAlias.fkPessoalServidorDependentes", "cg");
                $query->join("$rootAlias.fkSwCgmPessoaFisica", "pf");
                $query->join("pf.fkSwCgm", "cgm");

                if ($cgm) {
                    $query->where("cgm.numcgm = :numCgm");
                    $query->setParameter('numCgm', $cgm);
                } else {
                    $query->where("LOWER(cgm.nomCgm) LIKE :nomCgm");
                    $query->setParameter('nomCgm', sprintf('%%%s%%', strtolower($value)));
                }

                $datagrid->setValue($property, 'LIKE', $value);
            },
            'placeholder' => $this->trans('label.selecione'),
            'required' => true
        ];

        $formGridOptions['fkPessoalContratoServidor'] = [
            'label' => 'label.cgmmatricula',
            'callback' => [
                $this,
                'getSearchFilter'
            ],
            'required' => true,
        ];

        $formGridOptions['fkPessoalContratoServidorChoices'] = [
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato_all'
            ],
            'multiple' => false,
            'json_choice_label' => function ($contrato) use ($entityManager) {
                $nomcgm = $this->getServidor($contrato);

                return $nomcgm;
            },
            'attr' => ['class' => 'select2-parameters '],
        ];

        $datagridMapper
            /*->add('fkPessoalServidor', 'doctrine_orm_model_autocomplete', [
                'label' => 'label.servidor.modulo'
            ], 'sonata_type_model_autocomplete', [
                'property' => 'fkSwCgmPessoaFisica.fkSwCgm.nomCgm',
                'to_string_callback' => function (Servidor $servidor, $property) {
                    $contrato = $servidor
                                    ->getfkPessoalServidorContratoServidores()
                                    ->last()
                                    ->getFkPessoalContratoServidor()
                                    ->getFkPessoalContrato();

                    $servidorMatricula = $contrato->getRegistro(). ' - ';
                    $servidorMatricula .= (string) $servidor->getFkSwCgmPessoaFisica();

                    return (string) $servidorMatricula;
                },
                'callback' => function (AbstractSonataAdmin $admin, $property, $value) {
                    $this->filterServidorByNomeCgmMatricula($admin, $property, $value);
                },
                'placeholder' => $this->trans('label.selecione'),
                'required' => true
            ], ['admin_code' => 'core.admin.filter.servidor'])*/
            ->add(
                'codContrato',
                'doctrine_orm_callback',
                $formGridOptions['fkPessoalContratoServidor'],
                'autocomplete',
                $formGridOptions['fkPessoalContratoServidorChoices']
            )
            ->add('fkPessoalDependente', 'doctrine_orm_model_autocomplete', ['label' => 'label.servidor.depedentes'], 'sonata_type_model_autocomplete', $fielOptions['fkPessoalDependente'], [
                'admin_code' => 'core.admin.filter.dependente'
            ]);
    }

    private function filterServidorByNomeCgmMatricula($admin, $property, $value)
    {
        $datagrid = $admin->getDatagrid();
        $matriculaOuCgm = (int) $value;

        /** @var QueryBuilder|ProxyQueryInterface $query */
        $query = $datagrid->getQuery();

        $rootAlias = $query->getRootAlias();

        $query->join("$rootAlias.fkPessoalServidorDependentes", "cg");
        $query->join("$rootAlias.fkSwCgmPessoaFisica", "pf");
        $query->join("pf.fkSwCgm", "cgm");

        if ($matriculaOuCgm) {
            $query->join("$rootAlias.fkPessoalServidorContratoServidores", "servidorContratosServidor");
            $query->join("servidorContratosServidor.fkPessoalContratoServidor", "contratoServidor");
            $query->join("contratoServidor.fkPessoalContrato", "contrato");

            $query->where("cgm.numcgm = :numCgm");
            $query->setParameter('numCgm', $matriculaOuCgm);

            $query->orWhere("contrato.registro = :matricula");
            $query->setParameter('matricula', $matriculaOuCgm);
        } else {
            $query->where("LOWER(cgm.nomCgm) LIKE :nomCgm");
            $query->setParameter('nomCgm', sprintf('%%%s%%', strtolower($value)));
        }

        $datagrid->setValue($property, 'LIKE', $value);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add(
                'nomCgm',
                'customField',
                [
                    'label' => 'Servidor',
                    'mapped' => false,
                    'template' => 'RecursosHumanosBundle:Pessoal\Contrato:contratoServidor.html.twig',
                ]
            )
            ->add('fkPessoalDependente', 'text', [
                'label' => 'label.servidor.depedentes',
                'admin_code' => 'core.admin.filter.dependente'
            ])
            ->add('situacao', 'text', [
                'template' => 'RecursosHumanosBundle:Sonata/Pessoal/PensaoFuncaoPadrao:situacao_contrato_pensao.html.twig'
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'create' => ['template' => 'RecursosHumanosBundle:Sonata/Pessoal/PensaoFuncaoPadrao:create_edit_pensao.html.twig'],
                    'show' => ['template' => 'RecursosHumanosBundle:Sonata/Pessoal/PensaoFuncaoPadrao:show_pensao.html.twig'],
                    'delete' => ['template' => 'RecursosHumanosBundle:Sonata/Pessoal/PensaoFuncaoPadrao:remove_pensao.html.twig'],
                ]
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $codServidorDependente = $this->getRequest()->get('id');
        $em = $this->getModelManager();
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $formData = $this->getRequest()->request->get($this->getUniqid());
        if (!$this->getRequest()->isMethod('GET')) {
            $codServidorDependente = $formData['codServidorDependente'];
            $route = null;
        } else {
            $route = $this->getRequest()->get('_sonata_name');
            if (!is_null($route)) {
                $codServidorDependente = $codServidorDependente;
            } else {
                $codServidorDependente = $formData['codServidorDependente'];
            }
        }

        $codAgencia = null;

        $dados = [];

        $fieldOptions['servidor'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.servidor.modulo',
            'attr' => [
                'readonly' => true,
            ]
        ];

        $fieldOptions['dependente'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.servidor.depedentes',
            'attr' => [
                'readonly' => true,
            ]
        ];

        if (!is_null($route)) {
            /** @var ServidorDependente $servidorDependente */
            $servidorDependente = $em->find('CoreBundle:Pessoal\ServidorDependente', $codServidorDependente);
            $dados = $this->recuperaDadosForm($servidorDependente);

            $fieldOptions['servidor']['data'] = $servidorDependente->getFkPessoalServidor();
            $fieldOptions['dependente']['data'] = $servidorDependente
                                                            ->getFkPessoalDependente()
                                                            ->getFkSwCgmPessoaFisica();
        }

        $fieldOptions['pensaoTipo'] = [
            'label' => 'label.pensao.tipoPensao',
            'choices' => [
                'label.pensao.choices.tipoPensao.amigavel' => 'A',
                'label.pensao.choices.tipoPensao.judicial' => 'J'
            ],
            'expanded' => false,
            'multiple' => false,
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters '],
            'data' => isset($dados['pensaoTipo']) ? $dados['pensaoTipo'] : null
        ];

        $fieldOptions['observacao'] = [
            'label' => 'label.pensao.observacao',
            'required' => false,
            'mapped' => false,
            'data' => isset($dados['observacao']) ? $dados['observacao'] : null
        ];

        $fieldOptions['percentual'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.pensao.percentual',
            'type' => 'integer',
            'constraints' => [new Assert\Callback(function ($percentual, $context) {
                if ($percentual > 100) {
                    $message = $this->trans('pensao.errors.campoPercentualInvalido', [], 'validators');
                    $context->addViolation($message);
                }
            })],
            'attr' => [
                'class' => 'percent ',
            ],
            'data' => isset($dados['percentual']) ? $dados['percentual'] : null
        ];

        $fieldOptions['dtInclusao'] = [
            'mapped' => false,
            'label' => 'label.pensao.dtInclusao',
            'dp_default_date' => (new \DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'data' => isset($dados['dtInclusao']) ? $dados['dtInclusao'] : null
        ];

        $fieldOptions['dtLimite'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.pensao.dtLimite',
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'data' => isset($dados['dtLimite']) ? $dados['dtLimite'] : null
        ];

        $fieldOptions['valor'] = [
            'label' => 'label.pensao.valor',
            'mapped' => false,
            'required' => true,
            'attr' => [
                'class' => 'money ',
            ],
            'data' => isset($dados['valor']) ? $dados['valor'] : null
        ];

        $fieldOptions['codBanco'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'class' => Banco::class,
            'choice_label' => function (Banco $banco) {
                return "{$banco->getnumBanco()} - {$banco->getnomBanco()}";
            },
            'mapped' => false,
            'label' => 'label.fornecedor.codBanco',
            'placeholder' => 'label.selecione',
            'data' => isset($dados['codBanco']) ? $dados['codBanco'] : null
        ];
        $agenciaArray = [];
        /** @var ServidorDependente $servidorDependente */
        $servidorDependente = $this->getSubject();
        /** @var Pensao $pensao */
        $pensao = $servidorDependente->getFkPessoalPensoes()->last();
        $codBanco = (is_object($pensao)) ? $pensao->getFkPessoalPensaoBanco()->getCodBanco() : null;
        if ($this->id($this->getSubject())) {
            $codBanco = isset($dados['codBanco']) ? $dados['codBanco']->getCodbanco() : $codBanco;
            $agencias = $entityManager->getRepository(Agencia::class)->findBy(['codBanco' => $codBanco]);

            foreach ($agencias as $agencia) {
                $choiceKey = (string) $agencia->getNumAgencia() . " - " . $agencia->getNomAgencia();
                $choiceValue = $agencia->getCodAgencia();

                $agenciaArray[$choiceKey] = $choiceValue;
            }
            $codAgencia = $pensao->getFkPessoalPensaoBanco()->getCodAgencia();
        }

        $fieldOptions['codAgencia'] = [
            'label' => 'label.fornecedor.codAgencia',
            'mapped' => false,
            'choices' => isset($agenciaArray) ? $agenciaArray : [],
            'choice_attr' => function ($entidade, $key, $index) use ($codAgencia) {
                if ($index == $codAgencia) {
                    return ['selected' => 'selected'];
                } else {
                    return ['selected' => false];
                }
            }
        ];

        $fieldOptions['numConta'] = [
            'mapped' => false,
            'label' => 'label.fornecedor.numConta',
            'data' => isset($dados['numConta']) ? $dados['numConta'] : null
        ];

        $incidencias = $this
                        ->getEntityManager()
                        ->getRepository('CoreBundle:Pessoal\Incidencia')
                        ->findAll();

        $incidenciaChoices = [];

        /** @var Incidencia $incidencia */
        foreach ($incidencias as $incidencia) {
            $incidenciaChoices[$incidencia->getDescricao()] = $incidencia->getCodIncidencia();
        }

        $fieldOptions['incidencia'] = [
            'label' => 'label.pensao.chIncidencia',
            'choices' => $incidenciaChoices,
            'expanded' => true,
            'multiple' => true,
            'mapped' => false,
            'required' => false,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => ['class' => 'checkbox-sonata'],
            'data' => isset($dados['incidencias']) ? $dados['incidencias'] : null
        ];

        $fieldOptions['choiceValFunc'] = [
            'label' => 'label.pensao.choices.descontoFixado.descontoFixado',
            'choices' => [
                'label.pensao.choices.descontoFixado.valor' => 'V',
                'label.pensao.choices.descontoFixado.funcao' => 'F'
            ],
            'expanded' => false,
            'multiple' => false,
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters '],
            'data' => isset($dados['choiceValFunc']) ? $dados['choiceValFunc'] : 'V',
        ];

        $fieldOptions['funcao'] = [
            'class' => Funcao::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->createQueryBuilder('o')
                    ->where('LOWER(o.nomFuncao) LIKE :nomFuncao')
                    ->setParameter('nomFuncao', sprintf('%%%s%%', strtolower($term)))
                    ;
            },
            'label' => 'label.funcao.modulo',
            'mapped' => false,
            'data' => isset($dados['funcao']) ? $dados['funcao'] : null
        ];

        $fieldOptions['funcaoDefault'] = [
            'data' => isset($dados['funcao']) ? $dados['funcao'] : null,
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['responsavelChoice'] = [
            'label' => 'label.pensao.rdoResponsavel',
            'choices' => [
                'label.pensao.choices.rdoResponsavel.dependente' => 'D',
                'label.pensao.choices.rdoResponsavel.resplegal' => 'R'
            ],
            'expanded' => false,
            'multiple' => false,
            'mapped' => false,
            'required' => true,
            'attr' => ['class' => 'select2-parameters '],
            'data' => isset($dados['responsavelChoice']) ? $dados['responsavelChoice'] : 'D'
        ];

        $fieldOptions['responsavelConta'] = [
            'class' => SwCgmPessoaFisica::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                $cgm = (int) $term;

                $result = $repo->createQueryBuilder('o')
                    ->join('o.fkSwCgm', 'fkcgm');

                if ($cgm) {
                    $result
                        ->where('o.numcgm = :numCgm')
                        ->setParameter('numCgm', $cgm);
                } else {
                    $result
                        ->where('lower(fkcgm.nomCgm) LIKE lower(:nomCgm)')
                        ->setParameter('nomCgm', "%{$term}%");
                }

                return $result;
            },
            'label' => 'label.pensao.codResponsavelLegal',
            'mapped' => false,
            'data' => isset($dados['responsavel']) ? $dados['responsavel'] : null
        ];

        $formMapper
            ->with('label.pensao.modulo')
            ->add('pensaoTipo', 'choice', $fieldOptions['pensaoTipo'])
            ->add('servidor', 'text', $fieldOptions['servidor'], ['admin_code' => 'recursos_humanos.admin.servidor'])
            ->add('codServidorDependente', 'hidden', ['mapped' => false , 'data' => $codServidorDependente])
            ->add('dependente', 'text', $fieldOptions['dependente'])
            ->add('percentual', 'percent', $fieldOptions['percentual'])
            ->add('dtInclusao', 'datepkpicker', $fieldOptions['dtInclusao'])
            ->add('dtLimite', 'datepkpicker', $fieldOptions['dtLimite'])
            ->add('choiceValFunc', 'choice', $fieldOptions['choiceValFunc'])
            ->add('valor', 'number', $fieldOptions['valor'])
            ->add('funcao', 'autocomplete', $fieldOptions['funcao'])
            ->add('funcaoDefault', 'hidden', $fieldOptions['funcaoDefault'])
            ->add('observacao', 'textarea', $fieldOptions['observacao'])
            ->end()

            // Informacoes Bancarias
            ->with('label.estagio.informacoesbancarias')
            ->add('codBanco', 'entity', $fieldOptions['codBanco'])
            ->add('codAgencia', 'choice', $fieldOptions['codAgencia'])
            ->add('numConta', 'text', $fieldOptions['numConta'])
            ->add('responsavelChoice', 'choice', $fieldOptions['responsavelChoice'])
            ->add('responsavelConta', 'autocomplete', $fieldOptions['responsavelConta'])
            ->add('responsavelEnderecoTable', 'hidden', ['mapped' => false])
            ->end()

            // Incidencias
            ->with('label.pensao.chIncidencia')
            ->add('incidencia', 'choice', $fieldOptions['incidencia'])
            ->end();


        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $entityManager) {
                $form = $event->getForm();
                $data = $event->getData();

                if (isset($data['codBanco']) && $data['codBanco'] != "") {
                    $agencias = $entityManager->getRepository(Agencia::class)->findBy(['codBanco' => $data['codBanco']]);

                    foreach ($agencias as $agencia) {
                        $choiceKey = (string) $agencia->getNumAgencia() . " - " . $agencia->getNomAgencia();
                        $choiceValue = $agencia->getCodAgencia();

                        $dados[$choiceKey] = $choiceValue;
                    }

                    $codAgencia = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codAgencia', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.estagio.instituicao_ensino',
                            'mapped' => false,
                        ]);

                    $form->add($codAgencia);
                }
            }
        );
    }

    /**
     * @param ServidorDependente $servidorDependente
     */
    public function prePersist($servidorDependente)
    {
        $em = $this->getEntityManager();

        $form = $this->getForm();
        $observacao = $form->get('observacao')->getData();
        $codServidorDependente = $form->get('codServidorDependente')->getData();
        $pensaoTipo = $form->get('pensaoTipo')->getData();
        $dtInclusao = $form->get('dtInclusao')->getData();
        $dtLimite = $form->get('dtLimite')->getData();
        $percentual = $form->get('percentual')->getData();
        $agencia = $form->get('codAgencia')->getData();
        $banco = $form->get('codBanco')->getData();
        $conta = $form->get('numConta')->getData();
        $funcao = $form->get('funcao')->getData();
        $codIncidencias = $form->get('incidencia')->getData();
        $valor = $form->get('valor')->getData();
        $choiceValor = $form->get('choiceValFunc')->getData();
        $responsavelConta = $form->get('responsavelConta')->getData();

        $servidorDependente = $this->getModelManager()
                                        ->find('CoreBundle:Pessoal\ServidorDependente', $codServidorDependente);

        $param = [
            "observacao" => $observacao,
            "pensaoTipo" => $pensaoTipo,
            "dtInclusao" => $dtInclusao,
            "dtLimite" => $dtLimite,
            "percentual" => $percentual
        ];

        $em->getConnection()->beginTransaction();

        try {
            $pensaoModel = new PensaoModel($em);
            $pensao = $pensaoModel->savePensao($servidorDependente, $param);

            $pensaoBancoModel = new PensaoBancoModel($em);
            $agencia = $em->getRepository(Agencia::class)->findOneBy(
                [
                    'codAgencia' => $agencia,
                    'codBanco' => $banco->getCodBanco()
                    ]
            );

            $pensaoBanco = $pensaoBancoModel->savaPensaoBanco($agencia, $pensao, $conta);

            $pensaoFuncaoModel = new PensaoFuncaoModel($em);

            if ($choiceValor != "V") {
                $pensaoFuncao = $pensaoFuncaoModel->savePensaoFuncaoModel($pensao, $funcao);
            } else {
                $funcaoPadrao = (new PensaoFuncaoPadraoModel($this->getEntityManager()))
                                                                  ->recuperaPensaoFuncaoPadrao(true);

                $pensaoFuncao = $pensaoFuncaoModel->savePensaoFuncaoModel($pensao, $funcaoPadrao);

                $pensaoValorModel = new PensaoValorModel($em);
                $pensaoValorModel->savePensaoValor($pensao, $valor);
            }

            if (!is_null($responsavelConta)) {
                $responsavelContaModel = new ResponsavelLegalModel($em);
                $responsavelContaModel->saveResponsavelLegal($pensao, $responsavelConta);
            }

            $pensaoIncidenciaModel = new PensaoIncidenciaModel($em);
            $incidencias = [];

            foreach ($codIncidencias as $codIncidencia) {
                $incidencia = $em
                    ->getRepository('CoreBundle:Pessoal\Incidencia')
                    ->findOneBy(['codIncidencia' => $codIncidencia]);

                $incidencias[] = $pensaoIncidenciaModel->savePensaoIncidencia($pensao, $incidencia);
            }

            $message = $this->trans('rh.pessoal.pensao.success', [], 'flashes');

            $container = $this->getConfigurationPool()->getContainer();

            $container->get('session')->getFlashBag()->add('success', $message);

            $em->getConnection()->commit();
        } catch (\Exception $exception) {
            throw $exception;
        }

        $this->redirectToUrl("/recursos-humanos/pessoal/pensao-alimenticia/list");
    }

    /**
     * @param ServidorDependente $servidorDependente
     */
    public function preUpdate($servidorDependente)
    {
        $em = $this->getEntityManager();

        $form = $this->getForm();
        $observacao = $form->get('observacao')->getData();
        $codServidorDependente = $form->get('codServidorDependente')->getData();
        $pensaoTipo = $form->get('pensaoTipo')->getData();
        $dtInclusao = $form->get('dtInclusao')->getData();
        $dtLimite = $form->get('dtLimite')->getData();
        $percentual = $form->get('percentual')->getData();
        $agencia = $form->get('codAgencia')->getData();
        $banco = $form->get('codBanco')->getData();
        $conta = $form->get('numConta')->getData();
        $funcao = $form->get('funcao')->getData();
        $codIncidencias = $form->get('incidencia')->getData();
        $valor = $form->get('valor')->getData();
        $choiceValor = $form->get('choiceValFunc')->getData();
        $responsavelConta = $form->get('responsavelConta')->getData();

        $param = [
            "observacao" => $observacao,
            "pensaoTipo" => $pensaoTipo,
            "dtInclusao" => $dtInclusao,
            "dtLimite" => $dtLimite,
            "percentual" => $percentual
        ];

        $em->getConnection()->beginTransaction();

        try {
            $pensaoModel = new PensaoModel($em);
            /** @var Pensao $pensao */
            $pensao = $pensaoModel->savePensao($servidorDependente, $param);

            /** @var PensaoBancoModel $pensaoBancoModel */
            $pensaoBancoModel = new PensaoBancoModel($em);

            $agencia = $em->getRepository(Agencia::class)->findOneBy(
                [
                    'codAgencia' => $agencia,
                    'codBanco' => $banco->getCodBanco()
                ]
            );
            $pensaoBanco = $pensaoBancoModel->savaPensaoBanco($agencia, $pensao, $conta);

            $pensaoFuncaoModel = new PensaoFuncaoModel($em);

            if ($choiceValor != "V") {
                $pensaoFuncao = $pensaoFuncaoModel->savePensaoFuncaoModel($pensao, $funcao);
            } else {
                $funcaoPadrao = (new PensaoFuncaoPadraoModel($this->getEntityManager()))
                    ->recuperaPensaoFuncaoPadrao(true);

                $pensaoFuncao = $pensaoFuncaoModel->savePensaoFuncaoModel($pensao, $funcaoPadrao);

                $pensaoValorModel = new PensaoValorModel($em);
                $pensaoValorModel->savePensaoValor($pensao, $valor);
            }

            if (!is_null($responsavelConta)) {
                $responsavelContaModel = new ResponsavelLegalModel($em);
                $responsavelContaModel->saveResponsavelLegal($pensao, $responsavelConta);
            }

            $pensaoIncidenciaModel = new PensaoIncidenciaModel($em);
            $incidencias = [];

            foreach ($codIncidencias as $codIncidencia) {
                $incidencia = $em
                    ->getRepository('CoreBundle:Pessoal\Incidencia')
                    ->findOneBy(['codIncidencia' => $codIncidencia]);

                $incidencias[] = $pensaoIncidenciaModel->savePensaoIncidencia($pensao, $incidencia);
            }

            $em->getConnection()->commit();
        } catch (\Exception $exception) {
            throw $exception;
        }

        $this->redirectToUrl("/recursos-humanos/pessoal/pensao-alimenticia/list");
    }

    /**
     * @param ServidorDependente $servidorDependente
     * @return array
     */
    private function recuperaDadosForm(ServidorDependente $servidorDependente)
    {
        $dados = [];
        $funcaoPadrao = (new PensaoFuncaoPadraoModel($this->getEntityManager()))
                                                          ->recuperaPensaoFuncaoPadrao();

        $dados['funcao'] = (new FuncaoModel($this->getEntityManager()))
                                    ->recuperaFuncao($funcaoPadrao[0]);
        /** @var Pensao $pensao */
        $pensao = $servidorDependente->getFkPessoalPensoes()->last();

        if ($pensao && $pensao->getFkPessoalPensaoExcluida()) {
            $pensao = null;
        }

        if ($pensao && !is_null($pensao)) {
            $dados['pensaoTipo'] = $pensao->getTipoPensao();
            $dados['dtInclusao'] = $pensao->getDtInclusao();
            $dados['codBanco'] = ($pensao->getFkPessoalPensaoBanco()) ? $pensao->getFkPessoalPensaoBanco()->getFkMonetarioAgencia()
                ->getFkMonetarioBanco() : null;

            $dados['codAgencia'] = ($pensao->getFkPessoalPensaoBanco()) ? $pensao->getFkPessoalPensaoBanco()->getFkMonetarioAgencia() : null;

            $dados['numConta'] = ($pensao->getFkPessoalPensaoBanco()) ? $pensao
                                    ->getFkPessoalPensaoBanco()
                                    ->getContaCorrente() : null;

            if (!is_null($pensao->getPercentual())) {
                $dados['percentual'] = $pensao->getPercentual();
            }

            if (!is_null($pensao->getDtLimite())) {
                $dados['dtLimite'] = $pensao->getDtLimite();
            }

            if (!is_null($pensao->getFkPessoalPensaoValor())) {
                $dados['valor'] = $pensao->getFkPessoalPensaoValor()->getValor();
            } else {
                $dados['funcao'] = $pensao->getFkPessoalPensaoFuncao()->getFkAdministracaoFuncao();
            }

            if (!is_null($pensao->getObservacao())) {
                $dados['observacao'] = $pensao->getObservacao();
            }

            if (count($pensao->getFkPessoalPensaoIncidencias()) > 0) {
                $dados['incidencias'] = [];
                /** @var Incidencia $incidencia */
                foreach ($pensao->getFkPessoalPensaoIncidencias() as $incidencia) {
                    $dados['incidencias'][] = $incidencia->getCodIncidencia();
                }
            }

            if ($pensao->getFkPessoalResponsavelLegal()) {
                $dados['responsavel'] = $pensao->getFkPessoalResponsavelLegal()->getFkSwCgmPessoaFisica();
            }

            if (is_null($pensao->getFkPessoalPensaoValor())) {
                $dados['choiceValFunc'] = 'F';
            }

            if (!is_null($pensao->getFkPessoalResponsavelLegal())) {
                $dados['responsavelChoice'] = 'R';
            }
        }

        return $dados;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        /** @var ServidorDependente $servidorDependente */
        $servidorDependente = $this->getSubject();
        $pensao = $servidorDependente
                        ->getFkPessoalPensoes()
                        ->last();

        $showMapper
            ->with('label.pensao.modulo')
                ->add('servidor', 'customField', [
                    'label' => 'Servidor ',
                    'data' => ['pensao' => $pensao],
                    'template' => 'RecursosHumanosBundle:\Pessoal\Servidor:servidor_linha.html.twig',
                ])
            ->end();
    }

    /**
     * @param integer $codContrato
     * @return mixed
     */
    public function recuperarSituacaoDoContratoLiteral($codContrato)
    {
        return $this->getEntityManager()
                    ->getRepository(Contrato::class)
                    ->recuperarSituacaoDoContratoLiteral($codContrato);
    }

    /**
     * @param Contrato $contrato
     *
     * @return string
     */
    public function getServidor($contrato)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        if ($contrato instanceof ServidorDependente) {
            $contrato = $entityManager->getRepository(Contrato::class)->findOneBy(
                [
                    'codContrato' => $contrato->getFkPessoalServidor()->getFkPessoalServidorContratoServidores()->last()->getCodContrato()
                ]
            );
        }

        if (is_null($contrato)) {
            return '';
        }


        /** @var ContratoServidor $contratoServidor */
        $contratoServidor = (new ContratoServidorModel($entityManager))->findOneByCodContrato($contrato->getCodContrato());

        if (!is_null($contratoServidor)) {
            return $contratoServidor->getFkPessoalServidorContratoServidores()->last()
                    ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNumcgm()
                . " - "
                . $contratoServidor->getFkPessoalServidorContratoServidores()->last()
                    ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomcgm();
        }

        /** @var ContratoPensionista $contratoPensionista */
        $contratoPensionista = $entityManager->getRepository(ContratoPensionista::class)->findOneByCodContrato($contrato->getCodContrato());

        if (!is_null($contratoPensionista)) {
            return $contratoPensionista->getFkPessoalPensionista()->getFkSwCgmPessoaFisica()->getNumcgm()
                . " - "
                . $contratoPensionista->getFkPessoalPensionista()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomcgm();
        }

        return '';
    }
}
