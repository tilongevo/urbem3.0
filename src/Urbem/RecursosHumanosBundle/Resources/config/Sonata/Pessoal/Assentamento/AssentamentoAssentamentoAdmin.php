<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal\Assentamento;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\Entity\Folhapagamento;
use Urbem\CoreBundle\Entity\Normas;
use Urbem\CoreBundle\Entity\Pessoal;
use Urbem\CoreBundle\Helper\DatePK;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Model\Pessoal\Assentamento\AssentamentoAssentamentoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

class AssentamentoAssentamentoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_assentamento_configuracao';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/assentamento/configuracao';
    protected $includeJs = array(
        '/recursoshumanos/javascripts/pessoal/configuracaoAssentamento.js',
    );
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'desc',
        '_sort_by' => 'codAssentamento'
    ];
    const COD_OPERADOR = 1;
    const COD_TIPO = [2, 3, 4];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkPessoalClassificacaoAssentamento',
                null,
                [
                    'label' => 'label.classificacao'
                ],
                'entity',
                [
                    'class' => Pessoal\ClassificacaoAssentamento::class,
                    'choice_label' => 'descricao',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
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
            ->add('codAssentamento', null, [
                'label' => 'label.codigo'
            ])
            ->add('sigla', null, [
                'label' => 'label.sigla'
            ])
            ->add('descricao', null, [
                'label' => 'label.descricao'
            ])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     * @TODO: Campos especiais quando o Motivo = 5, 6, 9
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];

        $fieldOptions['fkPessoalClassificacaoAssentamento'] = [
            'class' => 'CoreBundle:Pessoal\ClassificacaoAssentamento',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('ca')
                    ->orderBy('ca.descricao', 'ASC');
            },
            'choice_label' => function ($classificacaoAssentamento) {
                return $classificacaoAssentamento->getCodClassificacao()
                . " - "
                . $classificacaoAssentamento->getDescricao();
            },
            'label' => 'label.classificacao',
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['descricao'] = [
            'label' => 'label.descricao'
        ];

        $fieldOptions['sigla'] = [
            'label' => 'label.sigla'
        ];

        $fieldOptions['abreviacao'] = [
            'label' => 'label.abreviacao',
            'required' => false,
            'attr' => [
                'maxlength' => 3
            ]
        ];

        $fieldOptions['fkFolhapagamentoRegimePrevidencia'] = [
            'class' => Folhapagamento\RegimePrevidencia::class,
            'choice_label' => 'descricao',
            'expanded' => false,
            'label' => 'label.regimePrevidencia',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'multiple' => false,
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['assentamentoInicio'] = [
            'label' => 'label.assentamento.assentamentoInicio',
            'required' => false,
            'mapped' => false,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ],
        ];

        $fieldOptions['gradeEfetividade'] = [
            'label' => 'label.assentamento.gradeEfetividade',
            'required' => false,
            'mapped' => false,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ],
        ];

        $fieldOptions['relFuncaoGratificada'] = [
            'label' => 'label.assentamento.relFuncaoGratificada',
            'required' => false,
            'mapped' => false,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ],
        ];

        $fieldOptions['codTipoNorma'] = [
            'label' => 'label.gerarAssentamento.codTipoNorma',
            'class' => 'CoreBundle:Normas\TipoNorma',
            'choice_label' => function ($tipoNorma) {
                return $tipoNorma->getCodTipoNorma()
                . " - "
                . $tipoNorma->getNomTipoNorma();
            },
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'placeholder' => 'label.selecione',
            'required' => true,
        ];

        $fieldOptions['codNorma'] = [
            'label' => 'label.gerarAssentamento.stCodNorma',
            'class' => 'CoreBundle:Normas\Norma',
            'req_params' => [
                'codTipoNorma' => 'varJsCodTipoNorma'
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                $qb = $repo->createQueryBuilder('n')
                    ->where('LOWER(n.nomNorma) LIKE :nomNorma')
                    ->andWhere('n.codTipoNorma = :codTipoNorma')
                    ->andWhere('n.exercicio = :exercicio')
                    ->setParameter('nomNorma', "%" . strtolower($term) . "%")
                    ->setParameter('codTipoNorma', $request->get('codTipoNorma'))
                    ->setParameter('exercicio', $this->getExercicio())
                ;

                return $qb;
            },
            'mapped' => false,
            'required' => true,
        ];

        $fieldOptions['dtPublicacao'] = [
            'label' => 'label.dtPublicacao',
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'mapped' => false,
            'disabled' => true,
            'required' => false,
        ];

        $fieldOptions['codSubDivisao'] = [
            'class' => Pessoal\SubDivisao::class,
            'choice_label' => function ($subDivisao) {
                $regime = $subDivisao->getFkPessoalRegime();

                $output = $regime->getDescricao() . "/";
                $output .= $subDivisao->getDescricao();

                return $output;
            },
            'label' => 'label.assentamento.assentamentoSubDivisao',
            'placeholder' => 'label.selecione',
            'multiple' => true,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters ',
            ]
        ];

        $fieldOptions['codEsfera'] = [
            'class' => Pessoal\EsferaOrigem::class,
            'choice_label' => function ($esferaOrigem) {
                return $esferaOrigem->getCodEsfera()
                . " - "
                . $esferaOrigem->getDescricao();
            },
            'label' => 'label.assentamento.esfera',
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
        ];

        $fieldOptions['fkPessoalAssentamentoOperador'] = [
            'class' => Pessoal\AssentamentoOperador::class,
            'choice_label' => function ($assentamentoOperador) {
                return $assentamentoOperador->getCodOperador()
                . " - "
                . $assentamentoOperador->getDescricao();
            },
            'label' => 'label.assentamento.operador',
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters ',
            ]
        ];

        $fieldOptions['dtInicial'] = [
            'label' => 'label.dtInicial',
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'mapped' => false,
        ];

        $fieldOptions['dtFinal'] = [
            'label' => 'label.dtFinal',
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'mapped' => false,
        ];

        $fieldOptions['cancelarDireito'] = [
            'label' => 'label.assentamento.cancelarDireito',
            'required' => false,
            'mapped' => false,
        ];

        $fieldOptions['eventoAutomatico'] = [
            'label' => 'label.assentamento.lancarEventoAutomatico',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['assentamentoEvento'] = [
            'class' => Folhapagamento\Evento::class,
            'choice_label' => 'descricao',
            'label' => 'label.evento',
            'mapped' => false,
            'multiple' => true,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters ',
            ]
        ];

        $fieldOptions['informarEventosProporcionalizacao'] = [
            'label' => 'label.assentamento.informarEventosProporcionalizacao',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['assentamentoEventoProporcional'] = [
            'class' => Folhapagamento\Evento::class,
            'choice_label' => 'descricao',
            'label' => 'label.evento',
            'mapped' => false,
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters ',
            ]
        ];

        $fieldOptions['fkPessoalAssentamentoMotivo'] = [
            'class' => Pessoal\AssentamentoMotivo::class,
            'choice_label' => function ($assentamentoMotivo) {
                return $assentamentoMotivo->getCodMotivo()
                . " - "
                . $assentamentoMotivo->getDescricao();
            },
            'label' => 'label.assentamento.motivo',
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters ',
            ]
        ];

        $fieldOptions['quantDiasOnusEmpregador'] = [
            'label' => 'label.assentamento.quantDiasOnusEmpregador',
            'required' => true,
            'mapped' => false,
        ];

        $fieldOptions['quantDiasLicencaPremio'] = [
            'label' => 'label.assentamento.quantDiasLicencaPremio',
            'required' => true,
            'mapped' => false,
        ];

        $fieldOptions['assentamentoAutomatico'] = [
            'choices' => ['sim' => 1, 'nao' => 0],
            'expanded' => true,
            'label' => 'label.assentamento.assentamentoAutomatico',
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ],
            'mapped' => false,
            'multiple' => false,
            'data' => 0
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['descricao']['disabled'] = true;
            $fieldOptions['sigla']['disabled'] = true;
            $fieldOptions['fkFolhapagamentoRegimePrevidencia']['disabled'] = true;

            if (in_array($this->getSubject()->getFkPessoalClassificacaoAssentamento()->getCodTipo(), self::COD_TIPO)) {
                $fieldOptions['fkPessoalClassificacaoAssentamento']['disabled'] = true;
            }

            $fieldOptions['fkPessoalAssentamentoMotivo']['disabled'] = true;
            $fieldOptions['assentamentoInicio']['data'] = $this->getSubject()->getFkPessoalAssentamentos()->last()->getAssentamentoInicio();
            $fieldOptions['assentamentoAutomatico']['data'] = $this->getSubject()->getFkPessoalAssentamentos()->last()->getAssentamentoAutomatico();
            $fieldOptions['gradeEfetividade']['data'] = $this->getSubject()->getFkPessoalAssentamentos()->last()->getGradeEfetividade();
            $fieldOptions['relFuncaoGratificada']['data'] = $this->getSubject()->getFkPessoalAssentamentos()->last()->getRelFuncaoGratificada();
            $fieldOptions['codTipoNorma']['disabled'] = true;
            $fieldOptions['codTipoNorma']['data'] = $this->getSubject()->getFkNormasNorma()->getFkNormasTipoNorma();
            $fieldOptions['codNorma']['disabled'] = true;
            $fieldOptions['codNorma']['data'] = $this->getSubject()->getFkNormasNorma();
            $fieldOptions['dtPublicacao']['data'] = $this->getSubject()->getFkNormasNorma()->getDtPublicacao();
            $fieldOptions['codSubDivisao']['data'] = (new AssentamentoAssentamentoModel($entityManager))
            ->getSubDivisoes($this->getSubject()->getFkPessoalAssentamentos()->last()->getFkPessoalAssentamentoSubDivisoes());
            $fieldOptions['codEsfera']['data'] = $this->getSubject()->getFkPessoalAssentamentos()->last()->getFkPessoalEsferaOrigem();
            $fieldOptions['dtInicial']['data'] = $this->getSubject()->getFkPessoalAssentamentos()->last()->getFkPessoalAssentamentoValidade()
            ->getDtInicial();
            $fieldOptions['dtFinal']['data'] = $this->getSubject()->getFkPessoalAssentamentos()->last()->getFkPessoalAssentamentoValidade()
            ->getDtFinal();
            $fieldOptions['cancelarDireito']['data'] = $this->getSubject()->getFkPessoalAssentamentos()->last()->getFkPessoalAssentamentoValidade()
            ->getCancelarDireito();
            $fieldOptions['quantDiasOnusEmpregador']['data'] = $this->getSubject()->getFkPessoalAssentamentos()->last()->getQuantDiasOnusEmpregador();
            $fieldOptions['quantDiasLicencaPremio']['data'] = $this->getSubject()->getFkPessoalAssentamentos()->last()->getQuantDiasLicencaPremio();

            $fkPessoalAssentamentoEventos = (new AssentamentoAssentamentoModel($entityManager))
            ->getEventos($this->getSubject()->getFkPessoalAssentamentos()->last()->getFkPessoalAssentamentoEventos());

            if (! $fkPessoalAssentamentoEventos->isEmpty()) {
                $fieldOptions['eventoAutomatico']['data'] = true;
                $fieldOptions['assentamentoEvento']['data'] = $fkPessoalAssentamentoEventos;
            }

            $fkPessoalAssentamentoEventoProporcionais = (new AssentamentoAssentamentoModel($entityManager))
            ->getEventosProporcionais($this->getSubject()->getFkPessoalAssentamentos()->last()->getFkPessoalAssentamentoEventoProporcionais());

            if (! $fkPessoalAssentamentoEventoProporcionais->isEmpty()) {
                $fieldOptions['informarEventosProporcionalizacao']['data'] = true;
                $fieldOptions['assentamentoEventoProporcional']['data'] = $fkPessoalAssentamentoEventoProporcionais;
            }

            if ($this->getSubject()->getFkPessoalAssentamentos()->last()->getFkPessoalEsferaOrigem()->getCodEsfera() != 3) {
                $fieldOptions['fkPessoalAssentamentoOperador']['disabled'] = true;
            }
        }

        $formMapper
        ->with('label.assentamento.dadosAssentamento')
            ->add(
                'fkPessoalClassificacaoAssentamento',
                'entity',
                $fieldOptions['fkPessoalClassificacaoAssentamento']
            )
            ->add(
                'descricao',
                null,
                $fieldOptions['descricao']
            )
            ->add(
                'sigla',
                null,
                $fieldOptions['sigla']
            )
            ->add(
                'abreviacao',
                null,
                $fieldOptions['abreviacao']
            )
            ->add(
                'fkFolhapagamentoRegimePrevidencia',
                'entity',
                $fieldOptions['fkFolhapagamentoRegimePrevidencia']
            )
            ->add(
                'assentamentoInicio',
                'checkbox',
                $fieldOptions['assentamentoInicio']
            )
            ->add(
                'gradeEfetividade',
                'checkbox',
                $fieldOptions['gradeEfetividade']
            )
            ->add(
                'relFuncaoGratificada',
                'checkbox',
                $fieldOptions['relFuncaoGratificada']
            )
            ->add(
                'codTipoNorma',
                'entity',
                $fieldOptions['codTipoNorma']
            )
            ->add(
                'codNorma',
                'autocomplete',
                $fieldOptions['codNorma']
            )
            ->add(
                'dtPublicacao',
                'datepkpicker',
                $fieldOptions['dtPublicacao']
            )
            ->add(
                'codSubDivisao',
                'entity',
                $fieldOptions['codSubDivisao']
            )
            ->add(
                'codEsfera',
                'entity',
                $fieldOptions['codEsfera']
            )
            ->add(
                'fkPessoalAssentamentoOperador',
                'entity',
                $fieldOptions['fkPessoalAssentamentoOperador']
            )
        ->end()
        ->with('label.assentamento.periodoValidade')
            ->add(
                'dtInicial',
                'datepkpicker',
                $fieldOptions['dtInicial']
            )
            ->add(
                'dtFinal',
                'datepkpicker',
                $fieldOptions['dtFinal']
            )
            ->add(
                'cancelarDireito',
                'checkbox',
                $fieldOptions['cancelarDireito']
            )
        ->end()
        ->with('label.assentamento.proporcaoEventos')
            ->add(
                'eventoAutomatico',
                'checkbox',
                $fieldOptions['eventoAutomatico']
            )
            ->add(
                'assentamentoEvento',
                'entity',
                $fieldOptions['assentamentoEvento']
            )
            ->add(
                'informarEventosProporcionalizacao',
                'checkbox',
                $fieldOptions['informarEventosProporcionalizacao']
            )
            ->add(
                'assentamentoEventoProporcional',
                'entity',
                $fieldOptions['assentamentoEventoProporcional']
            )
        ->end()
        ->with('label.assentamento.comportamento')
            ->add(
                'fkPessoalAssentamentoMotivo',
                'entity',
                $fieldOptions['fkPessoalAssentamentoMotivo']
            )
            ->add(
                'quantDiasOnusEmpregador',
                'number',
                $fieldOptions['quantDiasOnusEmpregador']
            )
            ->add(
                'quantDiasLicencaPremio',
                'number',
                $fieldOptions['quantDiasLicencaPremio']
            )
            ->add(
                'assentamentoAutomatico',
                'choice',
                $fieldOptions['assentamentoAutomatico']
            )
        ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();

        $formData = $this->getRequest()->request->get($this->getUniqid());

        $fkNormasNorma = $entityManager->getRepository("CoreBundle:Normas\Norma")
        ->findOneBy(
            array(
                'codNorma' => $formData['codNorma']
            )
        );

        if ($this->getForm()->get('codEsfera')->getData()->getCodEsfera() != 3) {
            $fkPessoalAssentamentoOperador = $entityManager->getRepository("CoreBundle:Pessoal\AssentamentoOperador")
            ->findOneBy(
                array(
                    'codOperador' => self::COD_OPERADOR
                )
            );

            $object->setFkPessoalAssentamentoOperador($fkPessoalAssentamentoOperador);
        }

        $object->setFkNormasNorma($fkNormasNorma);
    }

    /**
     * {@inheritdoc}
     */
    public function postPersist($object)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();

        (new AssentamentoAssentamentoModel($entityManager))
        ->create($object, $this->getForm());
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();

        $formData = $this->getRequest()->request->get($this->getUniqid());

        if ($this->getForm()->get('codEsfera')->getData()->getCodEsfera() != 3) {
            $fkPessoalAssentamentoOperador = $entityManager->getRepository("CoreBundle:Pessoal\AssentamentoOperador")
            ->findOneBy(
                array(
                    'codOperador' => self::COD_OPERADOR
                )
            );

            $object->setFkPessoalAssentamentoOperador($fkPessoalAssentamentoOperador);
        }

        (new AssentamentoAssentamentoModel($entityManager))
        ->create($object, $this->getForm());
    }
}
