<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Licitacao\Contrato;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Entity\Licitacao\TipoContrato;
use Urbem\CoreBundle\Entity\Licitacao\TipoInstrumento;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\Orgao;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CompraDiretaModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ContratoCompraDiretaModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ContratoLicitacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ContratoModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\LicitacaoModel;
use Urbem\CoreBundle\Repository\Orcamento\EntidadeRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Orcamento;

class ContratoAdmin extends AbstractSonataAdmin
{
    const COMPRA_DIRETA = 2;
    const LICITACAO = 1;

    protected $baseRouteName = 'urbem_patrimonial_compras_contrato';

    protected $baseRoutePattern = 'patrimonial/compras/contrato';

    protected $includeJs = [
        '/patrimonial/javascripts/compras/contrato.js',
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consulta_dados_contrato', 'consulta-dados-contrato/' . $this->getRouterIdParameter());
    }

    public function createQuery($context = 'list')
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Licitacao\Contrato');

        $exercicio = $this->getExercicio();

        $contratoAnulado = $em->createQueryBuilder();
        $contratoAnulado
            ->select('(ContratoAnulado.numContrato)')
            ->from('CoreBundle:Licitacao\ContratoAnulado', 'ContratoAnulado');

        $rescisaoContrato = $em->createQueryBuilder();
        $rescisaoContrato
            ->select('(RescisaoContrato.numContrato)')
            ->from('CoreBundle:Licitacao\RescisaoContrato', 'RescisaoContrato');

        $query = parent::createQuery($context);

        $query
            ->andWhere($query->expr()->notIn('o.numContrato', $contratoAnulado->getDQL()))
            ->andWhere($query->expr()->notIn('o.numContrato', $rescisaoContrato->getDQL()));

        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere("{$query->getRootAliases()[0]}.exercicio = :exercicio")->setParameters(['exercicio' => $exercicio]);
        }

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('valorContratado')
            ->add('valorGarantia');
    }


    public function redirect(Contrato $contrato)
    {
        $this->forceRedirect("/patrimonial/compras/contrato/{$this->getObjectKey($contrato)}/show");
    }


    /**
     * @param Contrato $contrato
     */
    public function postUpdate($contrato)
    {
        $this->redirect($contrato);
    }

    /**
     * @param Contrato $contrato
     */
    public function postPersist($contrato)
    {
        $formData = $this->getForm();
        $choiceContrato = $formData->get('contrato')->getData();
        $exercicioLicitacaoCompra = $formData->get('exercicioLicitacaoCompra')->getData();
        $modalidade = $formData->get('modalidade')->getData();
        $licitacaoCompra = $formData->get('licitacaoCompra')->getData();

        $em = $this->modelManager->getEntityManager($this->getClass());
        if ($choiceContrato == self::LICITACAO) {
            $licitacaoModel = new LicitacaoModel($em);
            /** @var Licitacao $licitacao */
            $licitacao = $licitacaoModel->getOneLicitacao($licitacaoCompra, $modalidade, $contrato->getFkOrcamentoEntidade()->getCodEntidade(), $exercicioLicitacaoCompra);

            $licitacaoContratoLicitacao = new ContratoLicitacaoModel($em);
            $licitacaoContratoLicitacao->saveContratoLicitacao($contrato, $licitacao);
        } else {
            $compraDiretaModel = new CompraDiretaModel($em);
            /** @var Compras\CompraDireta $compraDireta */
            $compraDireta = $compraDiretaModel->getOneCompraDireta($licitacaoCompra, $contrato->getFkOrcamentoEntidade()->getCodEntidade(), $exercicioLicitacaoCompra, $modalidade);

            $contratoCompraDiretaModel = new ContratoCompraDiretaModel($em);
            $contratoCompraDiretaModel->saveContratoCompraDireta($contrato, $compraDireta);
        }
        $this->redirect($contrato);
    }

    /**
     * @param Contrato $contrato
     */
    public function preUpdate($contrato)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formData = $this->getForm();
        // Os dados numOrgao e NumUnidade precisam se validados, pois haverá erro caso eles tenham valor null
        if ($formData->get('numOrgao')->getData() !== null) {
            $numOrgao = $formData->get('numOrgao')->getData()->getNumOrgao();
        } else {
            $numOrgao = $contrato->getNumOrgao();
        }
        if ($formData->get('numUnidade')->getData() !== null) {
            $numUnidade = $formData->get('numUnidade')->getData()->getNumUnidade();
        } else {
            $numUnidade = $contrato->getNumUnidade();
        }
        $contrato->setNumOrgao($numOrgao);
        $contrato->setNumUnidade($numUnidade);
    }

    /**
     * @param Contrato $contrato
     */
    public function prePersist($contrato)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formData = $this->getForm();

        // Os dados numOrgao e NumUnidade precisam se validados, pois haverá erro caso eles tenham valor null
        if ($formData->get('numOrgao')->getData() !== null) {
            $numOrgao = $formData->get('numOrgao')->getData()->getNumOrgao();
        } else {
            $numOrgao = $contrato->getNumOrgao();
        }
        if ($formData->get('numUnidade')->getData() !== null) {
            $numUnidade = $formData->get('numUnidade')->getData()->getNumUnidade();
        } else {
            $numUnidade = $contrato->getNumUnidade();
        }
        $contrato->setNumOrgao($numOrgao);
        $contrato->setNumUnidade($numUnidade);

        $exercicioLicitacaoCompra = $formData->get('exercicioLicitacaoCompra')->getData();
        $numUnidade = $formData->get('numUnidade')->getData();
        $contrato->setFkOrcamentoUnidade($numUnidade);
        $contratoModel = new ContratoModel($em);
        $contrato->setNumContrato($contratoModel->getProximoNumContrato($exercicioLicitacaoCompra, $contrato->getFkOrcamentoEntidade()->getCodEntidade()));
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add('numeroContrato', null, ['label' => 'Número do Contrato'])
            ->add('dtAssinatura', null, ['label' => 'Data da Execução'])
            ->add('vencimento')
            ->add('valorContratado')
            ->add('valorGarantia')
            ->add('inicioExecucao')
            ->add('fimExecucao')
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => ['template' => 'PatrimonialBundle:Sonata/Contrato/CRUD:list__action_profile.html.twig'],
                    'delete' => ['template' => 'PatrimonialBundle:Sonata/RescisaoContrato/CRUD:list__action_create.html.twig'],
                    'create' => ['template' => 'PatrimonialBundle:Sonata/ContratoAnulado/CRUD:list__action_create.html.twig'],
                    'show' => ['template' => 'PatrimonialBundle:Sonata/ContratoApostila/CRUD:list__action_create.html.twig']
                ]
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        /** @var Contrato $contrato */
        $contrato = $this->getSubject();

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $exercicio = $this->getExercicio();

        $queryBuilder = function (EntidadeRepository $repo) use ($exercicio) {
            return $repo->getEntidadeByCgmAndExercicioQueryBuilder($exercicio);
        };

        if (!is_null($id)) {
            $exercicio = $this->getSubject()->getExercicio();

            $queryBuilder = function (EntidadeRepository $repo) use ($exercicio) {
                return $repo->getEntidadeByCgmAndExercicioQueryBuilder($exercicio, $this->getSubject()->getFkOrcamentoEntidade()->getCodEntidade());
            };
        }


        $fieldOptions['choiceContrato'] = [
            'choices' => [
                'Compras' => self::COMPRA_DIRETA,
                'Licitação' => self::LICITACAO
            ],
            'mapped' => false,
            'multiple' => false,
            'expanded' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['exercicioLicitacaoCompra'] = [
            'label' => 'Exercicio Licitação / Compra Direta',
            'mapped' => false,
            'attr' => [
                'readonly' => true,
                'maxlength' => '4'
            ],
            'data' => $exercicio
        ];

        $fieldOptions['licitacaoCompra'] = [
            'label' => 'Licitação / Compra Direta',
            'mapped' => false,
            'multiple' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['numOrgao'] = [
            'class' => Orcamento\Orgao::class,
            'choice_label' => function (Orcamento\Orgao $orgaoOrg) {
                return $orgaoOrg;
            },
            'label' => 'label.bem.orgaoOrg',
            'mapped' => false,
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'choice_value' => 'numOrgao',
            'query_builder' => function (EntityRepository $entityManager) use ($exercicio) {
                $qb = $entityManager->createQueryBuilder('orgaoOrg');
                $result = $qb->where('orgaoOrg.exercicio = :exercicio')
                    ->setParameter(':exercicio', $exercicio);

                return $result;
            },
            'placeholder' => 'label.selecione',
        ];


        $fieldOptions['numUnidade'] = [
            'class' => Orcamento\Unidade::class,
            'choice_label' => function (Orcamento\Unidade $unidade) {
                return $unidade;
            },
            'label' => 'label.bem.unidade',
            'mapped' => false,
            'required' => false,
            'choice_value' => 'numUnidade',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['fkOrcamentoEntidade'] = [
            'label' => 'label.patrimonial.compras.contrato.codEntidade',
            'class' => 'CoreBundle:Orcamento\Entidade',
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'choice_value' => 'codEntidade',
            'required' => true,
            'query_builder' => $queryBuilder,
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['fkLicitacaoTipoContrato'] = [
            'class' => TipoContrato::class,
            'choice_label' => 'descricao',
            'label' => 'label.patrimonial.compras.contrato.codTipoContrato',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'Selecione',
            'required' => true,
        ];

        $fieldOptions['fkLicitacaoTipoInstrumento'] = [
            'class' => TipoInstrumento::class,
            'choice_label' => 'descricao',
            'label' => 'label.patrimonial.compras.contrato.codTipoInstrumento',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'Selecione',
            'required' => true,
        ];

        $fieldOptions['exercicio'] = [
            'label' => 'label.patrimonial.compras.contrato.exercicioContrato',
            'attr' => [
                'readonly' => true
            ],
            'data' => $exercicio
        ];

        $fieldOptions['fkAdministracaoModeloDocumento'] = [
            'class' => ModeloDocumento::class,
            'choice_label' => 'fkAdministracaoTipoDocumento.descricao',
            'label' => 'label.patrimonial.compras.contrato.codTipoDocumento',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'Selecione',
            'required' => true,
        ];

        $fieldOptions['cgmContratado'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'class' => Compras\Fornecedor::class,
            'choice_label' => 'fkSwCgm.nomCgm',
            'label' => 'label.patrimonial.compras.contrato.cgmContratado',
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['fkSwCgmPessoaFisica'] = [
            'container_css_class' => 'select2-v4-parameters ',
            'to_string_callback' => function (SwCgmPessoaFisica $swCgm, $property) {
                return sprintf('%s - %s', $swCgm->getFkSwCgm()->getNumcgm(), strtoupper($swCgm->getFkSwCgm()->getNomCgm()));
            },
            'class' => SwCgmPessoaFisica::class,
            'property' => 'fkSwCgm.nomCgm',
            'label' => 'label.patrimonial.compras.contrato.cgmSignatario',
            'placeholder' => 'Selecione'
        ];
        $fieldOptions['fkSwCgmPessoaFisica1'] = $fieldOptions['fkSwCgmPessoaFisica'];
        $fieldOptions['fkSwCgmPessoaFisica1']['label'] = 'label.patrimonial.compras.contrato.cgmRepresentante';
        $fieldOptions['fkSwCgm'] = [
            'container_css_class' => 'select2-v4-parameters ',
            'to_string_callback' => function (SwCgm $swCgm, $property) {
                return sprintf('%s - %s', $swCgm->getFkSwCgm()->getNumcgm(), strtoupper($swCgm->getFkSwCgm()->getNomCgm()));
            },
            'class' => SwCgm::class,
            'property' => 'nomCgm',
            'label' => 'label.patrimonial.compras.contrato.cgmResponsavelJuridico',
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['modalidade'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
            'required' => true,
            'class' => Compras\Modalidade::class,
            'label' => 'Modalidade',
            'placeholder' => 'Selecione',
            'choice_value' => 'codModalidade',
        ];

        $fieldOptions['fkComprasTipoObjeto'] = [
            //'class' => 'CoreBundle:Compras\TipoObjeto',
            'class' => Compras\TipoObjeto::class,
            'label' => 'label.patrimonial.compras.contrato.tipoObjeto',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
            'required' => true,
            'choice_value' => 'codTipoObjeto',
        ];

        $fieldOptions['fkLicitacaoTipoGarantia'] = [
            'class' => 'CoreBundle:Licitacao\TipoGarantia',
            'choice_label' => 'descricao',
            'required' => true,
            'label' => 'label.patrimonial.compras.contrato.codGarantia',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'required' => true,
        ];

        $route = $this->getRequest()->get('_sonata_name');
        if (sprintf("%s_edit", $this->baseRouteName) == $route) {
            if (!is_null($contrato->getFkOrcamentoUnidade())) {
                $fieldOptions['numOrgao']['data'] = $contrato->getFkOrcamentoUnidade()->getFkOrcamentoOrgao();
            }


            $fieldOptions['numUnidade']['data'] = $contrato->getFkOrcamentoUnidade();

            if (!is_null($contrato->getFkLicitacaoContratoLicitacao())) {
                $contrato->getFkLicitacaoContratoLicitacao()->getFkLicitacaoLicitacao() ?
                    $fieldOptions['choiceContrato']['data'] = self::LICITACAO
                    : $fieldOptions['choiceContrato']['data'] = self::COMPRA_DIRETA;
            }

            if (!is_null($contrato->getFkLicitacaoContratoLicitacao())) {
                $fieldOptions['modalidade']['data'] = $contrato->getFkLicitacaoContratoLicitacao()->getFkLicitacaoLicitacao()->getFkComprasModalidade();
            } else {
                $fieldOptions['modalidade']['data'] = $contrato->getFkLicitacaoContratoCompraDireta()->getFkComprasCompraDireta()->getFkComprasModalidade();
            }
            $fieldOptions['fkComprasTipoObjeto']['data'] = $contrato->getFkComprasTipoObjeto();
        }

        $formMapper
            ->with('Dados do Contrato')
            ->add('contrato', 'choice', $fieldOptions['choiceContrato'])
            ->add('fkLicitacaoTipoContrato', null, $fieldOptions['fkLicitacaoTipoContrato'])
            ->add('fkLicitacaoTipoInstrumento', null, $fieldOptions['fkLicitacaoTipoInstrumento'])
            ->add('exercicio', null, $fieldOptions['exercicio'])
            ->add('numOrgao', 'entity', $fieldOptions['numOrgao'])
            ->add('numUnidade', 'entity', $fieldOptions['numUnidade'])
            ->add('numeroContrato', null, ['label' => 'label.patrimonial.compras.contrato.numContrato'])
            ->add('exercicioLicitacaoCompra', 'text', $fieldOptions['exercicioLicitacaoCompra'])
            ->add('fkOrcamentoEntidade', null, $fieldOptions['fkOrcamentoEntidade'], ['admin_code' => 'financeiro.admin.entidade'])
            ->add('modalidade', 'entity', $fieldOptions['modalidade'])
            ->add('licitacaoCompra', 'choice', $fieldOptions['licitacaoCompra'])
            ->add('fkAdministracaoModeloDocumento', null, $fieldOptions['fkAdministracaoModeloDocumento'])
            ->add('fkComprasTipoObjeto', null, $fieldOptions['fkComprasTipoObjeto'])
            ->add(
                'objeto',
                null,
                [
                    'label' => 'label.patrimonial.compras.contrato.objeto',
                    'attr' => [
                        'class' => 'mensagem-inicial ',
                        'placeholder' => 'Digite aquí o objeto do contrato.'
                    ]
                ]
            )
            ->end()
            ->with('Dados do Fornecedor')
            ->add('fkComprasFornecedor', 'entity', $fieldOptions['cgmContratado'], ['admin_code' => 'core.admin.filter.sw_cgm'])
            ->add('fkSwCgm', 'sonata_type_model_autocomplete', $fieldOptions['fkSwCgm'], ['admin_code' => 'core.admin.filter.sw_cgm'])
            ->add('fkSwCgmPessoaFisica1', 'sonata_type_model_autocomplete', $fieldOptions['fkSwCgmPessoaFisica1'], ['admin_code' => 'core.admin.filter.sw_cgm_pessoa_fisica'])
            ->add('formaFornecimento', null, ['label' => 'label.patrimonial.compras.contrato.formaFornecimento'])
            ->add('formaPagamento', null, ['label' => 'label.patrimonial.compras.contrato.formaPagamento'])
            ->add('fkSwCgmPessoaFisica', 'sonata_type_model_autocomplete', $fieldOptions['fkSwCgmPessoaFisica'], ['admin_code' => 'core.admin.filter.sw_cgm_pessoa_fisica'])
            ->add('prazoExecucao', null, ['label' => 'label.patrimonial.compras.contrato.prazoExecucao'])
            ->add('multaInadimplemento', null, ['label' => 'label.patrimonial.compras.contrato.multaInadimplemento'])
            ->add('multaRescisoria', null, ['label' => 'label.patrimonial.compras.contrato.multaRescisoria'])
            ->add(
                'dtAssinatura',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.patrimonial.compras.contrato.dtAssinatura',
                    'required' => true,
                ]
            )
            ->add(
                'vencimento',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.patrimonial.compras.contrato.vencimento',
                    'required' => true,
                ]
            )
            ->add(
                'inicioExecucao',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.patrimonial.compras.contrato.inicioExecucao',
                    'required' => true,
                ]
            )
            ->add(
                'fimExecucao',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.patrimonial.compras.contrato.fimExecucao',
                    'required' => true,
                ]
            )
            ->add(
                'valorContratado',
                'money',
                [
                    'label' => 'Valor Contratado',
                    'attr' => array(
                        'class' => 'money '
                    ),
                    'currency' => 'BRL'
                ]
            )
            ->add('fkLicitacaoTipoGarantia', null, $fieldOptions['fkLicitacaoTipoGarantia'])
            ->add(
                'valorGarantia',
                'money',
                [
                    'label' => 'label.patrimonial.compras.contrato.valorGarantia',
                    'attr' => array(
                        'class' => 'money '
                    ),
                    'currency' => 'BRL'
                ]
            )
            ->add('justificativa')
            ->add('razao')
            ->add('fundamentacaoLegal')
            ->end();


        $em = $this->modelManager->getEntityManager($this->getClass());
        $licitacaoModel = new LicitacaoModel($em);
        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $licitacaoModel) {
                $form = $event->getForm();
                $data = $event->getData();


                $licitacoes = $licitacaoModel->carregaLicitacaoContrato($data['modalidade'], $data['fkOrcamentoEntidade'], $data['exercicioLicitacaoCompra']);

                $dados = [];

                foreach ($licitacoes as $licitacao) {
                    $key = $licitacao->cod_licitacao . " / " . $licitacao->exercicio . " - " . $licitacao->nom_cgm;
                    $value = $licitacao->cod_licitacao;
                    $dados[$key] = $value;
                }

                $licitacaoCompraDireta = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                    'licitacaoCompra',
                    'choice',
                    null,
                    array(
                        'choices' => $dados,
                        'auto_initialize' => false,
                        'label' => 'Licitação / Compra Direta',
                        'mapped' => false,
                        'multiple' => false,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ]
                    )
                );

                $form->add($licitacaoCompraDireta);
            }
        );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        /** @var Contrato $contrato */
        $contrato = $this->getSubject();
        $contrato->contrato = $contrato;
        $contrato->documentos = $contrato->getFkLicitacaoContratoDocumentos();
        $contrato->publicacoes = $contrato->getFkLicitacaoPublicacaoContratos();
        $contrato->arquivos = $contrato->getFkLicitacaoContratoArquivos();
        $contrato->aditivos = $contrato->getFkLicitacaoContratoAditivos();
    }
}
