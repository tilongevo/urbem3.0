<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Datetime;
use stdClass;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Economico\AtributoCadEconAutonomoValor;
use Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoAutonomo;
use Urbem\CoreBundle\Entity\Economico\CadastroEconRespContabil;
use Urbem\CoreBundle\Entity\Economico\DomicilioFiscal;
use Urbem\CoreBundle\Entity\Economico\DomicilioInformado;
use Urbem\CoreBundle\Entity\Economico\ProcessoCadastroEconomico;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwBairro;
use Urbem\CoreBundle\Entity\SwBairroLogradouro;
use Urbem\CoreBundle\Entity\SwCep;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwLogradouro;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class CadastroEconomicoAutonomoAdmin extends AbstractSonataAdmin
{
    const MODULO = 14;
    const CADASTRO = 3;
    const TIPO_DOMICILIO_IMOVEL_CADASTRADO = 'cadastrado';
    const TIPO_DOMICILIO_ENDERECO_INFORMADO = 'informado';
    const TIPO_DOMICILIOS = [
        self::TIPO_DOMICILIO_IMOVEL_CADASTRADO => 'Imóvel Cadastrado',
        self::TIPO_DOMICILIO_ENDERECO_INFORMADO => 'Endereço Informado',
    ];

    protected $baseRouteName = 'urbem_tributario_economico_cadastro_economico_autonomo';
    protected $baseRoutePattern = 'tributario/cadastro-economico/inscricao-economica/autonomo';
    protected $includeJs = [
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/tributario/javascripts/economico/autonomo.js',
    ];

    /**
    * @param CadastroEconomico $cadastroEconomico
    * @return bool
    */
    public function hasBaixa(CadastroEconomico $cadastroEconomico)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        return (bool) $em->getRepository(BaixaCadastroEconomico::class)
            ->findBy(['inscricaoEconomica' => $cadastroEconomico->getInscricaoEconomica(), 'dtTermino' => null]);
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);
        $qb->join(
            CadastroEconomicoAutonomo::class,
            'a',
            'WITH',
            sprintf('%s.inscricaoEconomica = a.inscricaoEconomica', $qb->getRootAlias())
        );

        return $qb;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $em->persist($object);

        $this->populateObject($object);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->populateObject($object);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('inscricaoEconomica', null, ['label' => 'label.economicoCadastroEconomico.codInscricao'])
            ->add(
                'fkEconomicoCadastroEconomicoAutonomo.fkSwCgmPessoaFisica',
                'doctrine_orm_model_autocomplete',
                [
                    'label' => 'label.economicoCadastroEconomicoAutonomo.cgm',
                ],
                'sonata_type_model_autocomplete',
                [
                    'attr' => ['class' => 'select2-parameters '],
                    'callback' => function (AbstractSonataAdmin $admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();

                        /** @var QueryBuilder|ProxyQueryInterface $qb */
                        $qb = $datagrid->getQuery();

                        $rootAlias = $qb->getRootAlias();
                        $qb->join("{$rootAlias}.fkEconomicoCadastroEconomicoAutonomos", "fkEconomicoCadastroEconomicoAutonomos");

                        $fkSwCgm = sprintf('%s.fkSwCgm', $qb->getRootAlias());
                        $qb
                            ->join($fkSwCgm, 'cgm')
                            ->andWhere('LOWER(cgm.nomCgm) LIKE :nomCgm')
                            ->setParameter('nomCgm', sprintf('%%%s%%', strtolower($value)));

                        $datagrid->setValue($property, 'LIKE', $value);
                    },
                    'placeholder' => $this->trans('label.selecione'),
                    'property' => 'fkSwCgm.nomCgm'
                ],
                [
                    'admin_code' => 'core.admin.filter.sw_cgm_pessoa_fisica'
                ]
            )
            ->add(
                'dtAbertura',
                'doctrine_orm_date',
                [
                    'field_type' => 'sonata_type_date_picker',
                    'field_options' => [
                        'format' => 'dd/MM/yyyy'
                    ],
                    'label' => 'label.economicoCadastroEconomico.dtAbertura'
                ]
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('inscricaoEconomica', null, ['label' => 'label.economicoCadastroEconomico.codInscricao'])
            ->add('fkEconomicoCadastroEconomicoAutonomo.fkSwCgmPessoaFisica.numCgm', null, ['label' => 'label.economicoCadastroEconomicoAutonomo.cgm'])
            ->add('fkEconomicoCadastroEconomicoAutonomo.fkSwCgmPessoaFisica.fkSwCgm.nomCgm', null, ['label' => 'label.economicoCadastroEconomicoAutonomo.nomCgm'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    'edit' => ['template' => 'TributarioBundle:Sonata/Economico/CadastroEconomico/CRUD:list__action_edit.html.twig'],
                    'baixar' => ['template' => 'TributarioBundle:Sonata/Economico/CadastroEconomico/CRUD:list__action_baixar.html.twig'],
                    'delete' => ['template' => 'TributarioBundle:Sonata/Economico/CadastroEconomico/CRUD:list__action_delete.html.twig'],
                ],
                'header_style' => 'width: 40%'
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $cadastroEconomico = $this->getSubject();

        $fieldOptions = [];
        $fieldOptions['fkSwCgmPessoaFisica'] = [
            'mapped' => false,
            'callback' => function ($admin, $property, $value) use ($em) {
                /** @var AbstractSonataAdmin $admin */
                $datagrid = $admin->getDatagrid();

                /** @var QueryBuilder $qb */
                $qb = $datagrid->getQuery();

                $fkSwCgm = sprintf('%s.fkSwCgm', $qb->getRootAlias());
                $qb
                    ->join($fkSwCgm, 'cgm')
                    ->andWhere('LOWER(cgm.nomCgm) LIKE :nomCgm')
                    ->setParameter('nomCgm', sprintf('%%%s%%', strtolower($value)));

                $datagrid->setValue($property, null, $value);
            },
            'property' => 'fkSwCgm.nomCgm',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'container_css_class' => 'select2-v4-parameters ',
            'label' => 'label.economicoCadastroEconomicoAutonomo.cgm',
        ];

        $fieldOptions['fkEconomicoResponsavel'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join(sprintf('%s.fkEconomicoResponsaveis', $qb->getRootAlias()), 'responsavel');
                $qb->andWhere('LOWER(o.nomCgm) LIKE :nomCgm');
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('o.numcgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.economicoCadastroEconomico.responsavel',
        ];

        $fieldOptions['fkSwClassificacao'] = [
            'class' => SwClassificacao::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('o')
                    ->orderBy('o.codClassificacao', 'ASC');
            },
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters js-select-processo-classificacao'
            ],
            'label' => 'label.economicoCadastroEconomico.processoClassificacao',
        ];

        $fieldOptions['fkSwAssunto'] = [
            'class' => SwAssunto::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('o')
                    ->orderBy('o.codAssunto', 'ASC');
            },
            'choice_value' => 'codAssunto',
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters js-select-processo-assunto'
            ],
            'label' => 'label.economicoCadastroEconomico.processoAssunto',
        ];

        $fieldOptions['fkSwProcesso'] = [
            'class' => SwProcesso::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');
                $qb->innerJoin('o.fkAdministracaoUsuario', 'u');
                $qb->innerJoin('u.fkSwCgm', 'cgm');
                if ($request->get('codClassificacao')) {
                    $qb->andWhere('o.codClassificacao = :codClassificacao');
                    $qb->setParameter('codClassificacao', (int) $request->get('codClassificacao'));
                }

                if ($request->get('codAssunto')) {
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
                'codClassificacao' => 'varJsCodClassificacao',
                'codAssunto' => 'varJsCodAssunto'
            ],
            'attr' => [
                'class' => 'select2-parameters js-processo',
            ],
            'label' => 'label.economicoCadastroEconomico.processo',
        ];

        $fieldOptions['tipoDomicilio'] = [
            'mapped' => false,
            'choices' => array_flip($this::TIPO_DOMICILIOS),
            'expanded' => true,
            'multiple' => false,
            'data' => $this::TIPO_DOMICILIO_IMOVEL_CADASTRADO,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata js-tipo-domicilio ',
            ],
            'label' => 'label.economicoCadastroEconomico.tipoDomicilio',
        ];

        $fieldOptions['localizacao'] = [
            'class' => Localizacao::class,
            'mapped' => false,
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters js-imovel-localizacao js-imovel-cadastrado '
            ],
            'label' => 'label.imobiliarioLote.localizacao',
        ];

        $fieldOptions['fkImobiliarioLote'] = [
            'class' => Lote::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join('o.fkImobiliarioImovelLotes', 'il');

                $qb->where('o.codLote >= :codLote');
                $qb->setParameter('codLote', (int) $term);

                if ($request->get('codLocalizacao')) {
                    $qb->join('o.fkImobiliarioLoteLocalizacao', 'll');

                    $qb->andWhere('ll.codLocalizacao = :codLocalizacao');
                    $qb->setParameter('codLocalizacao', $request->get('codLocalizacao'));
                }

                $qb->orderBy('o.codLote', 'ASC');

                return $qb;
            },
            'req_params' => [
                'codLocalizacao' => 'varJsCodLocalizacao',
            ],
            'attr' => [
                'class' => 'select2-parameters js-imovel-cadastrado ',
            ],
            'label' => 'label.economicoCadastroEconomico.domicilio',
        ];

        $fieldOptions['fkSwLogradouro'] = [
            'class' => SwLogradouro::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join('o.fkSwNomeLogradouros', 'nome_logradouro');
                $qb->where('LOWER(nome_logradouro.nomLogradouro) LIKE :nomLogradouro');
                $qb->setParameter('nomLogradouro', sprintf('%%%s%%', strtolower($term)));
                $qb->orderBy('nome_logradouro.nomLogradouro', 'ASC');

                return $qb;
            },
            'json_choice_label' => function (SwLogradouro $logradouro) {
                return $logradouro->getFkSwNomeLogradouros()->first()->getNomLogradouro();
            },
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.economicoCadastroEconomico.logradouro',
        ];

        $fieldOptions['numero'] = [
            'mapped' => false,
            'attr' => [
                'class' => 'js-endereco-informado ',
            ],
            'label' => 'label.economicoCadastroEconomico.numero',
        ];

        $fieldOptions['complemento'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'js-endereco-informado ',
            ],
            'label' => 'label.economicoCadastroEconomico.complemento',
        ];

        $fieldOptions['bairro'] = [
            'class' =>  SwBairro::class,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters js-endereco-informado js-select-endereco-informado-bairro ',
            ],
            'label' => 'label.economicoCadastroEconomico.bairro',
        ];

        $fieldOptions['cep'] = [
            'class' =>  SwCep::class,
            'mapped' => false,
            'choice_label' => 'cep',
            'attr' => [
                'class' => 'select2-parameters js-endereco-informado js-select-endereco-informado-cep ',
            ],
            'label' => 'label.economicoCadastroEconomico.cep',
        ];

        $fieldOptions['caixaPostal'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'js-endereco-informado '
            ],
            'label' => 'label.economicoCadastroEconomico.caixaPostal',
        ];

        $fieldOptions['municipio'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'js-endereco-informado js-select-endereco-informado-municipio js-endereco-informado-disabled ',
            ],
            'label' => 'label.economicoCadastroEconomico.municipio',
        ];

        $fieldOptions['uf'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'js-endereco-informado js-select-endereco-informado-uf js-endereco-informado-disabled ',
            ],
            'label' => 'label.economicoCadastroEconomico.uf',
        ];

        $formMapper->with('label.economicoCadastroEconomico.cabecalho');

        if ($id) {
            $formMapper->add(
                'inscricaoEconomica',
                null,
                [
                    'disabled' => true,
                    'label' => 'label.economicoCadastroEconomico.codInscricao'
                ]
            );

            $fieldOptions['fkSwCgmPessoaFisica']['data_class'] = null;
            $fieldOptions['fkSwCgmPessoaFisica']['data'] = $cadastroEconomico->getFkEconomicoCadastroEconomicoAutonomo()->getFkSwCgmPessoaFisica();

            if ($cadastroEconomico->getFkEconomicoCadastroEconRespContabiis()->count()) {
                $fieldOptions['fkEconomicoResponsavel']['data'] = $cadastroEconomico->getFkEconomicoCadastroEconRespContabiis()->first()->getFkEconomicoResponsavel();
            }

            if ($cadastroEconomico->getFkEconomicoProcessoCadastroEconomicos()->count()) {
                $processo = $cadastroEconomico->getFkEconomicoProcessoCadastroEconomicos()->last();
                $fieldOptions['fkSwClassificacao']['data'] = $processo->getFkSwProcesso()->getFkSwAssunto()->getFkSwClassificacao();
                $fieldOptions['fkSwAssunto']['data'] = $processo->getFkSwProcesso()->getFkSwAssunto();
                $fieldOptions['fkSwProcesso']['data'] = $processo->getFkSwProcesso();
            }

            $domicilioFiscal = $cadastroEconomico->getFkEconomicoDomicilioFiscais()->last();
            $domicilioInformado = $cadastroEconomico->getFkEconomicoDomicilioInformados()->last();
            if ($domicilioFiscal && $domicilioInformado) {
                $domicilioFiscal = $domicilioFiscal->getTimestamp() > $domicilioInformado->getTimestamp() ? $domicilioFiscal : false;
                $domicilioInformado = $domicilioInformado->getTimestamp() > $domicilioFiscal->getTimestamp() ? $domicilioInformado : false;
            }

            if ($domicilioFiscal) {
                $lote = $domicilioFiscal->getFkImobiliarioImovel()->getfkImobiliarioImovelLotes()->last()->getFkImobiliarioLote();
                $fieldOptions['tipoDomicilio']['data'] = $this::TIPO_DOMICILIO_IMOVEL_CADASTRADO;
                $fieldOptions['localizacao']['data'] = $lote->getFkImobiliarioLoteLocalizacao()->getFkImobiliarioLocalizacao();
                $fieldOptions['fkImobiliarioLote']['data'] = $lote;
            }

            if ($domicilioInformado) {
                $fieldOptions['tipoDomicilio']['data'] = $this::TIPO_DOMICILIO_ENDERECO_INFORMADO;
                $fieldOptions['fkSwLogradouro']['data'] = $domicilioInformado->getFkSwLogradouro();
                $fieldOptions['numero']['data'] = $domicilioInformado->getNumero();
                $fieldOptions['complemento']['data'] = $domicilioInformado->getComplemento();
                $fieldOptions['bairro']['data'] = $domicilioInformado->getFkSwBairroLogradouro()->getFkSwBairro();
                $fieldOptions['cep']['data'] = $domicilioInformado->getFkSwLogradouro()->getFkSwCepLogradouros()->last()->getFkSwCep()->getCep();
                $fieldOptions['caixaPostal']['data'] = $domicilioInformado->getCaixaPostal();

                $municipio = $domicilioInformado->getFkSwLogradouro()->getFkSwBairroLogradouros()->last()->getFkSwBairro()->getFkSwMunicipio();
                $fieldOptions['municipio']['data'] = sprintf('%s - %s', $municipio->getCodMunicipio(), $municipio->getNomMunicipio());

                $uf = $municipio->getFkSwUf();
                $fieldOptions['uf']['data'] = sprintf('%s - %s', $uf->getCodUf(), $uf->getNomUf());
            }
        }

        $formMapper
            ->add(
                'fkEconomicoCadastroEconomicoAutonomo.fkSwCgmPessoaFisica',
                'sonata_type_model_autocomplete',
                $fieldOptions['fkSwCgmPessoaFisica'],
                [
                    'admin_code' => 'core.admin.filter.sw_cgm_pessoa_fisica'
                ]
            )
            ->add(
                'fkEconomicoResponsavel',
                'autocomplete',
                $fieldOptions['fkEconomicoResponsavel'],
                [
                    'admin_code' => 'tributario.admin.responsavel'
                ]
            )
            ->add(
                'dtAbertura',
                'datepkpicker',
                [
                    'pk_class' => DatePK::class,
                    'dp_default_date' => (new DateTime())->format('d/m/Y'),
                    'format' => 'dd/MM/yyyy',
                    'required' => true,
                    'label' => 'label.economicoCadastroEconomico.dtAbertura',
                ]
            )
            ->end()
            ->with('label.economicoCadastroEconomico.cabecalhoProcesso')
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
            ->with('label.economicoCadastroEconomico.cabecalhoDomicilio')
            ->add('tipoDomicilio', 'choice', $fieldOptions['tipoDomicilio'])
            ->add('localizacao', 'entity', $fieldOptions['localizacao'])
            ->add(
                'fkImobiliarioLote',
                'autocomplete',
                $fieldOptions['fkImobiliarioLote'],
                [
                    'admin_code' => 'tributario.admin.lote'
                ]
            )
            ->add(
                'fkSwLogradouro',
                'autocomplete',
                $fieldOptions['fkSwLogradouro'],
                [
                    'admin_code' => 'administrativo.admin.sw_logradouro'
                ]
            )
            ->add('numero', 'text', $fieldOptions['numero'])
            ->add('complemento', 'text', $fieldOptions['complemento'])
            ->add('bairro', 'entity', $fieldOptions['bairro'])
            ->add('cep', 'entity', $fieldOptions['cep'])
            ->add('caixaPostal', 'text', $fieldOptions['caixaPostal'])
            ->add('municipio', 'text', $fieldOptions['municipio'])
            ->add('uf', 'text', $fieldOptions['uf'])
            ->end()
            ->with('label.economicoCadastroEconomico.cabecalhoAtributos')
                ->add('atributosDinamicos', 'text', ['mapped' => false, 'required' => false])
                ->add(
                    'redirectCadastroAtividades',
                    'checkbox',
                    [
                        'mapped' => false,
                        'required' => false,
                        'label' => 'label.economicoCadastroEconomico.redirectCadastroAtividades',
                    ]
                )
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $this->cadastroEconomico = $this->getSubject();
        if ($this->cadastroEconomico->getFkEconomicoProcessoCadastroEconomicos()->count()) {
            $this->processo = $this->cadastroEconomico->getFkEconomicoProcessoCadastroEconomicos()->last()->getFkSwProcesso();
        }

        $domicilioFiscal = $this->cadastroEconomico->getFkEconomicoDomicilioFiscais()->last();
        $domicilioInformado = $this->cadastroEconomico->getFkEconomicoDomicilioInformados()->last();
        if ($domicilioFiscal && $domicilioInformado) {
            $domicilioFiscal = $domicilioFiscal->getTimestamp() > $domicilioInformado->getTimestamp() ? $domicilioFiscal : false;
            $domicilioInformado = $domicilioInformado->getTimestamp() > $domicilioFiscal->getTimestamp() ? $domicilioInformado : false;
        }

        $this->tipoDomicilio = '-';
        if ($domicilioFiscal) {
            $this->domicilioFiscal = $this->cadastroEconomico->getFkEconomicoDomicilioFiscais()->last();
            $this->tipoDomicilio = $this::TIPO_DOMICILIOS[$this::TIPO_DOMICILIO_IMOVEL_CADASTRADO];
        }

        if ($domicilioInformado) {
            $this->tipoDomicilio = $this::TIPO_DOMICILIOS[$this::TIPO_DOMICILIO_ENDERECO_INFORMADO];
            $this->domicilioInformado = $this->cadastroEconomico->getFkEconomicoDomicilioInformados()->last();
            $this->municipio = $this->domicilioInformado->getFkSwLogradouro()->getFkSwBairroLogradouros()->first()->getFkSwBairro()->getFkSwMunicipio();
            $this->uf = $this->municipio->getFkSwUf();
        }

        $this->atributos = $this->getAtributos();
        foreach ($this->atributos as &$atributo) {
            $atributoAutonomo = $em->getRepository(AtributoCadEconAutonomoValor::class)->findOneBy(
                [
                    'inscricaoEconomica' => $this->cadastroEconomico->getInscricaoEconomica(),
                    'codAtributo' => $atributo['codAtributo'],
                    'codModulo' => $this::MODULO,
                    'codCadastro' => $this::CADASTRO,
                ]
            );

            $atributo['value'] = '';
            if (!$atributoAutonomo) {
                continue;
            }

            $atributo['value'] = $atributoAutonomo->getValor();
            if (!empty($atributo['parameters']['choices']) && !empty($atributoAutonomo->getValor())) {
                $atributo['value'] = array_flip($atributo['parameters']['choices'])[$atributoAutonomo->getValor()];
            }
        }

        $fieldOptions['cadastroEconomico'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/CadastroEconomico/cadastro_economico_autonomo_show.html.twig',
        ];

        $showMapper->add('cadastroEconomico', 'customField', $fieldOptions['cadastroEconomico']);
    }

    /**
    * @param CadastroEconomico $object
    */
    protected function populateObject($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();

        $autonomo = $object->getFkEconomicoCadastroEconomicoAutonomo() ?: new CadastroEconomicoAutonomo();
        $autonomo->setFkSwCgmPessoaFisica($form->get('fkEconomicoCadastroEconomicoAutonomo__fkSwCgmPessoaFisica')->getData());
        $autonomo->setFkEconomicoCadastroEconomico($object);

        foreach ($object->getFkEconomicoCadastroEconRespContabiis() as $cadastroEconomicoResponsavel) {
            $object->removeFkEconomicoCadastroEconRespContabiis($cadastroEconomicoResponsavel);
        }

        foreach ($autonomo->getFkEconomicoAtributoCadEconAutonomoValores() as $atributoAutonomo) {
            $autonomo->removeFkEconomicoAtributoCadEconAutonomoValores($atributoAutonomo);
        }

        if ($responsavel = $form->get('fkEconomicoResponsavel')->getData()) {
            $cadastroEconomicoResponsavel = (new CadastroEconRespContabil())->setFkEconomicoResponsavel($responsavel->getFkEconomicoResponsaveis()->first());
            $object->addFkEconomicoCadastroEconRespContabiis($cadastroEconomicoResponsavel);
        }

        if ($processo = $form->get('fkSwProcesso')->getData()) {
            $processoCadastroEconomico = (new ProcessoCadastroEconomico())->setFkSwProcesso($processo);
            $object->addFkEconomicoProcessoCadastroEconomicos($processoCadastroEconomico);
        }

        $tipoDomicilio = $form->get('tipoDomicilio')->getData();
        if ($tipoDomicilio == $this::TIPO_DOMICILIO_IMOVEL_CADASTRADO) {
            $lote = $form->get('fkImobiliarioLote')->getData();
            $imovel = $lote->getFkImobiliarioImovelLotes()->first()->getFkImobiliarioImovel();
            $domicilioFiscal = (new DomicilioFiscal())->setFkImobiliarioImovel($imovel);

            $object->addFkEconomicoDomicilioFiscais($domicilioFiscal);
        }

        if ($tipoDomicilio == $this::TIPO_DOMICILIO_ENDERECO_INFORMADO) {
            $enderecoInformado = new DomicilioInformado();
            $enderecoInformado->setFkSwLogradouro($form->get('fkSwLogradouro')->getData());
            $enderecoInformado->setNumero($form->get('numero')->getData());
            $enderecoInformado->setComplemento($form->get('complemento')->getData());

            $bairroLogradouro = $em->getRepository(SwBairroLogradouro::class)->findOneBy(
                [
                    'codLogradouro' => $form->get('fkSwLogradouro')->getData()->getCodLogradouro(),
                    'codBairro' => $form->get('bairro')->getData()->getCodBairro(),
                ]
            );
            if (!$bairroLogradouro) {
                $bairroLogradouro = (new SwBairroLogradouro())
                    ->setFkSwLogradouro($form->get('fkSwLogradouro')->getData())
                    ->setFkSwBairro($form->get('bairro')->getData());
                $em->persist($bairroLogradouro);
            }

            $enderecoInformado->setFkSwBairroLogradouro($bairroLogradouro);
            $enderecoInformado->setCep($form->get('cep')->getViewData());
            $enderecoInformado->setCaixaPostal($form->get('caixaPostal')->getData());

            $object->addFkEconomicoDomicilioInformados($enderecoInformado);
        }

        foreach ($this->getRequest()->get('atributoDinamico') as $codAtributo => $atributo) {
            $value = array_shift($atributo);
            $atributo = $em->getRepository(AtributoDinamico::class)->findOneBy(
                [
                    'codAtributo' => $codAtributo,
                    'codModulo' => $this::MODULO,
                    'codCadastro' => $this::CADASTRO,
                ]
            );

            $atributoEmpresaAutonomo = new AtributoCadEconAutonomoValor();
            $atributoEmpresaAutonomo->setValor($value);
            $atributoEmpresaAutonomo->setFkAdministracaoAtributoDinamico($atributo);
            $autonomo->addFkEconomicoAtributoCadEconAutonomoValores($atributoEmpresaAutonomo);
        }

        $object->setFkEconomicoCadastroEconomicoAutonomo($autonomo);
    }

    /**
    * @param PersistentCollection|array|null $atributosSalvos
    * @return array
    */
    protected function getAtributos($atributosSalvos = [])
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $atributos = (new AtributoDinamicoModel($em))->getAtributosDinamicosPessoal(['cod_modulo' => $this::MODULO, 'cod_cadastro' => $this::CADASTRO]);
        $data = [];
        foreach ($atributos as $atributo) {
            $id = sprintf('%d-%d-%d', $this::MODULO, $this::CADASTRO, $atributo->cod_atributo);
            $data[$id]['codAtributo'] = $atributo->cod_atributo;
            $data[$id]['name'] = $atributo->nom_atributo;
            $data[$id]['hash'] = md5($atributo->nom_atributo);
            $this->setParametrosAtributo($atributo, $data[$id]);
        }

        foreach ($atributosSalvos as $atributo) {
            $id = sprintf('%d-%d-%d', $atributo->getCodModulo(), $atributo->getCodCadastro(), $atributo->getCodAtributo());
            if (empty($data[$id])) {
                continue;
            }

            $data[$id]['parameters']['data'] = $atributo->getValor();
        }

        return $data;
    }

    /**
    * @param stdClass $atributo
    * @param array $parametros
    */
    protected function setParametrosAtributo(stdClass $atributo, array &$parametros)
    {
        if ($atributo->cod_tipo != 3) {
            return;
        }

        $data = array_combine(explode(',', $atributo->valor_padrao), explode('[][][]', $atributo->valor_padrao_desc));
        asort($data);

        $parametros['type'] = 'choice';
        $parametros['parameters']['choices'] = array_flip($data);
    }
}
