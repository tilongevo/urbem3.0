<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Datetime;
use stdClass;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Economico\AtributoEmpresaDireitoValor;
use Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoAutonomo;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaFato;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito;
use Urbem\CoreBundle\Entity\Economico\CadastroEconRespContabil;
use Urbem\CoreBundle\Entity\Economico\Categoria;
use Urbem\CoreBundle\Entity\Economico\DomicilioFiscal;
use Urbem\CoreBundle\Entity\Economico\DomicilioInformado;
use Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica;
use Urbem\CoreBundle\Entity\Economico\NaturezaJuridica;
use Urbem\CoreBundle\Entity\Economico\ProcessoCadastroEconomico;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwBairro;
use Urbem\CoreBundle\Entity\SwBairroLogradouro;
use Urbem\CoreBundle\Entity\SwCep;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwLogradouro;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class CadastroEconomicoEmpresaDireitoAdmin extends AbstractSonataAdmin
{
    const MODULO = 14;
    const CADASTRO = 2;
    const TIPO_DOMICILIO_IMOVEL_CADASTRADO = 'cadastrado';
    const TIPO_DOMICILIO_ENDERECO_INFORMADO = 'informado';
    const TIPO_DOMICILIOS = [
        self::TIPO_DOMICILIO_IMOVEL_CADASTRADO => 'Imóvel Cadastrado',
        self::TIPO_DOMICILIO_ENDERECO_INFORMADO => 'Endereço Informado',
    ];

    public $converterEmpresaDireito = false;

    protected $baseRouteName = 'urbem_tributario_economico_cadastro_economico_empresa_direito';
    protected $baseRoutePattern = 'tributario/cadastro-economico/inscricao-economica/empresa-direito';
    protected $includeJs = [
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/tributario/javascripts/economico/empresa-direito.js',
    ];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add(
            'converter_empresa_direito',
            sprintf(
                'converter-empresa-direito/%s',
                $this->getRouterIdParameter()
            )
        );
    }

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
            CadastroEconomicoEmpresaDireito::class,
            'ed',
            'WITH',
            sprintf('%s.inscricaoEconomica = ed.inscricaoEconomica', $qb->getRootAlias())
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
     * @param mixed $object
     */
    public function postUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        if (!$this->converterEmpresaDireito) {
            return;
        }

        if ($empresaFato = $object->getFkEconomicoCadastroEconomicoEmpresaFato()) {
            $em->remove($empresaFato);
        }

        if ($autonomo = $object->getFkEconomicoCadastroEconomicoAutonomo()) {
            $em->remove($autonomo);
        }

        $em->flush();
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('inscricaoEconomica', null, ['label' => 'label.economicoCadastroEconomico.codInscricao'])
            ->add(
                'fkEconomicoCadastroEconomicoEmpresaDireito.fkSwCgmPessoaJuridica',
                'doctrine_orm_model_autocomplete',
                [
                    'label' => 'label.economicoCadastroEconomicoEmpresaDireito.cgm',
                ],
                'sonata_type_model_autocomplete',
                [
                    'attr' => ['class' => 'select2-parameters '],
                    'callback' => function (AbstractSonataAdmin $admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();

                        /** @var QueryBuilder|ProxyQueryInterface $qb */
                        $qb = $datagrid->getQuery();

                        $rootAlias = $qb->getRootAlias();
                        $qb->join("{$rootAlias}.fkEconomicoCadastroEconomicoEmpresaDireitos", "fkEconomicoCadastroEconomicoEmpresaDireitos");

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
                    'admin_code' => 'administrativo.admin.sw_cgm_admin_pj'
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
            ->add('fkEconomicoCadastroEconomicoEmpresaDireito.fkSwCgmPessoaJuridica.numCgm', null, ['label' => 'label.economicoCadastroEconomicoEmpresaDireito.cgm'])
            ->add('fkEconomicoCadastroEconomicoEmpresaDireito.fkSwCgmPessoaJuridica.fkSwCgm.nomCgm', null, ['label' => 'label.economicoCadastroEconomicoEmpresaDireito.nomCgm'])
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
            'required' => false,
            'attr' => [
                'readonly' => true,
            ],
            'label' => 'label.economicoCadastroEconomicoEmpresaDireito.cgmPessoaFisica',
        ];

        $fieldOptions['fkSwCgmPessoaJuridica'] = [
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
            'label' => 'label.economicoCadastroEconomicoEmpresaDireito.cgm',
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

        $fieldOptions['fkEconomicoNaturezaJuridica'] = [
            'class' => NaturezaJuridica::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->where('LOWER(o.nomNatureza) LIKE :nomNatureza')
                    ->setParameter('nomNatureza', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('o.nomNatureza', 'ASC');

                return $qb;
            },
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.economicoCadastroEconomicoEmpresaDireito.naturezaJuridica',
        ];

        $fieldOptions['fkEconomicoCategoria'] = [
            'class' => Categoria::class,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.economicoCadastroEconomicoEmpresaDireito.categoria',
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

            if ($this->converterEmpresaDireito) {
                $entidade = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaFato() ?: $cadastroEconomico->getFkEconomicoCadastroEconomicoAutonomo();
                $fieldOptions['fkSwCgmPessoaFisica']['data'] = $entidade->getFkSwCgmPessoaFisica();
                $fieldOptions['fkSwCgmPessoaJuridica']['label'] = 'label.economicoCadastroEconomicoEmpresaDireito.cgmPessoaJuridica';
            }

            $empresaDireito = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaDireito() ?: new CadastroEconomicoEmpresaDireito();
            $fieldOptions['fkSwCgmPessoaJuridica']['data_class'] = null;
            $fieldOptions['fkSwCgmPessoaJuridica']['data'] = $empresaDireito->getFkSwCgmPessoaJuridica();

            if ($cadastroEconomico->getFkEconomicoCadastroEconRespContabiis()->count()) {
                $fieldOptions['fkEconomicoResponsavel']['data'] = $cadastroEconomico->getFkEconomicoCadastroEconRespContabiis()->first()->getFkEconomicoResponsavel();
            }

            $fieldOptions['numRegistroJunta']['data'] = $empresaDireito->getNumRegistroJunta();

            if ($empresaDireito->getFkEconomicoEmpresaDireitoNaturezaJuridicas()->count()) {
                $fieldOptions['fkEconomicoNaturezaJuridica']['data'] = $empresaDireito->getFkEconomicoEmpresaDireitoNaturezaJuridicas()->last()->getFkEconomicoNaturezaJuridica();
            }

            $fieldOptions['fkEconomicoCategoria']['data'] = $empresaDireito->getFkEconomicoCategoria();

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
                'fkSwCgmPessoaFisica',
                $this->converterEmpresaDireito ? 'text' : 'hidden',
                $fieldOptions['fkSwCgmPessoaFisica']
            )
            ->add(
                'fkEconomicoCadastroEconomicoEmpresaDireito.fkSwCgmPessoaJuridica',
                'sonata_type_model_autocomplete',
                $fieldOptions['fkSwCgmPessoaJuridica'],
                [
                    'admin_code' => 'administrativo.admin.sw_cgm_admin_pj'
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
            ->add(
                'numRegistroJunta',
                'number',
                [
                    'mapped' => false,
                    'required' => false,
                    'label' => 'label.economicoCadastroEconomicoEmpresaDireito.numRegistroJunta',
                ]
            )
            ->add(
                'fkEconomicoNaturezaJuridica',
                'autocomplete',
                $fieldOptions['fkEconomicoNaturezaJuridica']
            )
            ->add('fkEconomicoCategoria', 'entity', $fieldOptions['fkEconomicoCategoria'])
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
            $atributoEmpresaDireito = $em->getRepository(AtributoEmpresaDireitoValor::class)->findOneBy(
                [
                    'inscricaoEconomica' => $this->cadastroEconomico->getInscricaoEconomica(),
                    'codAtributo' => $atributo['codAtributo'],
                    'codModulo' => $this::MODULO,
                    'codCadastro' => $this::CADASTRO,
                ]
            );

            $atributo['value'] = '';
            if (!$atributoEmpresaDireito) {
                continue;
            }

            $atributo['value'] = $atributoEmpresaDireito->getValor();
            if (!empty($atributo['parameters']['choices']) && !empty($atributoEmpresaDireito->getValor())) {
                $atributo['value'] = array_flip($atributo['parameters']['choices'])[$atributoEmpresaDireito->getValor()];
            }
        }

        $fieldOptions['cadastroEconomico'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/CadastroEconomico/cadastro_economico_empresa_direito_show.html.twig',
        ];

        $showMapper->add('cadastroEconomico', 'customField', $fieldOptions['cadastroEconomico']);
    }

    /**
    * @param CadastroEconomico $object
    */
    protected function populateObject(CadastroEconomico $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();

        $empresaDireito = $object->getFkEconomicoCadastroEconomicoEmpresaDireito() ?: new CadastroEconomicoEmpresaDireito();
        $empresaDireito->setNumRegistroJunta($form->get('numRegistroJunta')->getData());
        $empresaDireito->setFkSwCgmPessoaJuridica($form->get('fkEconomicoCadastroEconomicoEmpresaDireito__fkSwCgmPessoaJuridica')->getData());
        $empresaDireito->setFkEconomicoCadastroEconomico($object);

        foreach ($object->getFkEconomicoCadastroEconRespContabiis() as $cadastroEconomicoResponsavel) {
            $object->removeFkEconomicoCadastroEconRespContabiis($cadastroEconomicoResponsavel);
        }

        foreach ($empresaDireito->getFkEconomicoAtributoEmpresaDireitoValores() as $atributoEmpresaDireito) {
            $empresaDireito->removeFkEconomicoAtributoEmpresaDireitoValores($atributoEmpresaDireito);
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

        if ($naturezaJuridica = $form->get('fkEconomicoNaturezaJuridica')->getData()) {
            $naturezaJuridica = (new EmpresaDireitoNaturezaJuridica())->setFkEconomicoNaturezaJuridica($naturezaJuridica);
            $empresaDireito->addFkEconomicoEmpresaDireitoNaturezaJuridicas($naturezaJuridica);
        }

        $empresaDireito->setFkEconomicoCategoria($form->get('fkEconomicoCategoria')->getData());

        foreach ($this->getRequest()->get('atributoDinamico') as $codAtributo => $atributo) {
            $value = array_shift($atributo);
            $atributo = $em->getRepository(AtributoDinamico::class)->findOneBy(
                [
                    'codAtributo' => $codAtributo,
                    'codModulo' => $this::MODULO,
                    'codCadastro' => $this::CADASTRO,
                ]
            );

            $atributoEmpresaDireito = new AtributoEmpresaDireitoValor();
            $atributoEmpresaDireito->setValor($value);
            $atributoEmpresaDireito->setFkAdministracaoAtributoDinamico($atributo);
            $empresaDireito->addFkEconomicoAtributoEmpresaDireitoValores($atributoEmpresaDireito);
        }

        if ($form->get('fkSwCgmPessoaFisica')->getData()) {
            $this->converterEmpresaDireito = true;
        }

        $object->setFkEconomicoCadastroEconomicoEmpresaDireito($empresaDireito);
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
            $this->setParametrosAtributo($atributo, $data[$id]);
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
