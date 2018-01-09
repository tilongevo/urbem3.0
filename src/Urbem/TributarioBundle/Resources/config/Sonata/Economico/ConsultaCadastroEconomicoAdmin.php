<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use stdClass;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Economico\AtributoCadEconAutonomoValor;
use Urbem\CoreBundle\Entity\Economico\AtributoEmpresaDireitoValor;
use Urbem\CoreBundle\Entity\Economico\AtributoEmpresaFatoValor;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoAutonomo;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaFato;
use Urbem\CoreBundle\Entity\Economico\Licenca;
use Urbem\CoreBundle\Entity\Economico\LicencaAtividade;
use Urbem\CoreBundle\Entity\Economico\LicencaEspecial;
use Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConsultaCadastroEconomicoAdmin extends AbstractSonataAdmin
{
    const SHOW_ACTION_EMPRESA = 'empresa';
    const SHOW_ACTION_RESPONSAVEL = 'responsavel';
    const SHOW_ACTION_ATIVIDADE = 'atividade';
    const SHOW_ACTION_LICENCA = 'licenca';

    public $showAction;

    protected $baseRouteName = 'urbem_tributario_economico_cadastro_economico_consulta';
    protected $baseRoutePattern = 'tributario/cadastro-economico/consulta';
    protected $includeJs = ['/tributario/javascripts/economico/cadastro-economico-consulta.js'];
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoSalvar = false;

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);

        if (!$this->getRequest()->query->get('filter')) {
            $qb->where(sprintf('%s.inscricaoEconomica IS NULL', $qb->getRootAlias()));
        }

        return $qb;
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add(
            'empresa',
            sprintf('empresa/%s', $this->getRouterIdParameter())
        );

        $routes->add(
            'responsavel',
            sprintf('responsavel/%s', $this->getRouterIdParameter())
        );

        $routes->add(
            'atividade',
            sprintf('atividade/%s', $this->getRouterIdParameter())
        );

        $routes->add(
            'licenca',
            sprintf('licenca/%s', $this->getRouterIdParameter())
        );

        $routes->add('api_lote', 'api/lote');

        $routes->add('api_licenca', 'api/licenca');

        $routes->clearExcept(
            [
                'list',
                'empresa',
                'responsavel',
                'atividade',
                'licenca',
                'api_lote',
                'api_licenca',
            ]
        );
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getCnpjSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $qb->join(sprintf('%s.fkEconomicoCadastroEconomicoEmpresaDireitos', $alias), 'cnpjceed');

        $qb->andWhere(sprintf('%s.cnpj = :cnpj', $alias));
        $qb->setParameter('cnpj', str_replace(['.', '/', '-'], '', $value['value']));

        return true;
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getCpfSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $qb->leftJoin(sprintf('%s.fkEconomicoCadastroEconomicoAutonomo', $alias), 'cpfcea');
        $qb->leftJoin(sprintf('%s.fkEconomicoCadastroEconomicoEmpresaFato', $alias), 'cpfceef');
        $qb->leftJoin('cpfcea.fkSwCgmPessoaFisica', 'cpfceapf');
        $qb->leftJoin('cpfceef.fkSwCgmPessoaFisica', 'cpfceefpf');

        $qb->andWhere('COALESCE(cpfceapf.cpf, cpfceefpf.cpf) = :cpf');
        $qb->setParameter('cpf', str_replace(['.', '-'], '', $value['value']));

        return true;
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getNomeSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $qb->leftJoin(
            CadastroEconomicoAutonomo::class,
            'nomecea',
            'WITH',
            sprintf('%s.inscricaoEconomica = nomecea.inscricaoEconomica', $alias)
        );
        $qb->leftJoin(
            CadastroEconomicoEmpresaFato::class,
            'nomeceef',
            'WITH',
            sprintf('%s.inscricaoEconomica = nomeceef.inscricaoEconomica', $alias)
        );
        $qb->leftJoin(
            CadastroEconomicoEmpresaDireito::class,
            'nomeceed',
            'WITH',
            sprintf('%s.inscricaoEconomica = nomeceed.inscricaoEconomica', $alias)
        );

        $qb->join(SwCgm::class, 'nomecgm', 'WITH', 'nomecgm.numcgm = COALESCE(nomecea.numcgm, nomeceef.numcgm, nomeceed.numcgm)');

        $qb->andWhere('LOWER(nomecgm.nomCgm) LIKE :nomCgm');
        $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($value['value'])));

        return true;
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getCgmSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $qb->leftJoin(
            CadastroEconomicoAutonomo::class,
            'cgmcea',
            'WITH',
            sprintf('%s.inscricaoEconomica = cgmcea.inscricaoEconomica', $alias)
        );
        $qb->leftJoin(
            CadastroEconomicoEmpresaFato::class,
            'cgmceef',
            'WITH',
            sprintf('%s.inscricaoEconomica = cgmceef.inscricaoEconomica', $alias)
        );
        $qb->leftJoin(
            CadastroEconomicoEmpresaDireito::class,
            'cgmceed',
            'WITH',
            sprintf('%s.inscricaoEconomica = cgmceed.inscricaoEconomica', $alias)
        );

        $qb->leftJoin('cgmcea.fkSwCgmPessoaFisica', 'cgmceapf');
        $qb->leftJoin('cgmceef.fkSwCgmPessoaFisica', 'cgmceefpf');
        $qb->leftJoin('cgmceed.fkSwCgmPessoaJuridica', 'cgmceedpj');

        $qb->andWhere('COALESCE(cgmceapf.numcgm, cgmceefpf.numcgm, cgmceedpj.numcgm) = :numcgm');
        $qb->setParameter('numcgm', $value['value']);

        return true;
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSocioSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $qb->join(sprintf('%s.fkEconomicoCadastroEconomicoEmpresaDireito', $alias), "socioceed");
        $qb->join('socioceed.fkEconomicoSociedades', 'socios');
        $qb->join('socios.fkSwCgm', 'sociocgm');

        $qb->andWhere('sociocgm.numcgm = :numcgm');
        $qb->setParameter('numcgm', $value['value']);

        return true;
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getLocalizacaoSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $qb->join(sprintf('%s.fkEconomicoDomicilioFiscais', $alias), 'localizacaodf');
        $qb->join('localizacaodf.fkImobiliarioImovel', 'localizacaoi');
        $qb->join('localizacaoi.fkImobiliarioImovelLotes', 'localizacaoil');
        $qb->join('localizacaoil.fkImobiliarioLote', 'localizacaol');
        $qb->join('localizacaol.fkImobiliarioLoteLocalizacao', 'localizacaoll');

        $qb->andWhere('localizacaoll.codLocalizacao = :codLocalizacao');
        $qb->setParameter('codLocalizacao', $value['value']);

        return true;
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getLoteSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $qb->join(sprintf('%s.fkEconomicoDomicilioFiscais', $alias), 'lotedf');
        $qb->join('lotedf.fkImobiliarioImovel', 'lotei');
        $qb->join('lotei.fkImobiliarioImovelLotes', 'loteil');
        $qb->join('loteil.fkImobiliarioLote', 'lotel');

        $qb->andWhere('lotel.codLote = :codLote');
        $qb->setParameter('codLote', $value['value']);

        return true;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('inscricaoEconomica', null, ['label' => 'label.economicoConsultaCadastroEconomico.inscricaoEconomica'])
            ->add(
                'fkEconomicoCadastroEconomicoEmpresaDireito.fkSwCgmPessoaJuridica.cnpj',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'getCnpjSearchFilter'],
                    'label' => 'label.economicoConsultaCadastroEconomico.cnpj',
                ],
                'text',
                [
                    'attr' => [
                        'class' => 'js-cnpj',
                    ],
                ]
            )
            ->add(
                'cpf',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'getCpfSearchFilter'],
                    'label' => 'label.economicoConsultaCadastroEconomico.cpf',
                ],
                'text',
                [
                    'attr' => [
                        'class' => 'js-cpf',
                    ],
                ]
            )
            ->add(
                'nome',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'getNomeSearchFilter'],
                    'label' => 'label.economicoConsultaCadastroEconomico.nome',
                ],
                'text'
            )
            ->add(
                'fkSwCgm',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'getCgmSearchFilter'],
                    'label' => 'label.economicoConsultaCadastroEconomico.cgm',
                ],
                'autocomplete',
                [
                    'class' => SwCgm::class,
                    'route' => [
                        'name' => 'api-search-swcgm-by-nomcgm'
                    ],
                ]
            )
            ->add(
                'fkEconomicoAtividadeCadastroEconomicos.fkEconomicoAtividade',
                'doctrine_orm_model_autocomplete',
                [
                    'label' => 'label.economicoConsultaCadastroEconomico.atividade',
                ],
                'sonata_type_model_autocomplete',
                [
                    'attr' => ['class' => 'select2-parameters '],
                    'callback' => function (AbstractSonataAdmin $admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();

                        /** @var QueryBuilder|ProxyQueryInterface $qb */
                        $qb = $datagrid->getQuery();

                        $rootAlias = $qb->getRootAlias();
                        $qb->join("{$rootAlias}.fkEconomicoAtividadeCadastroEconomicos", "ace");

                        $qb->andWhere(sprintf('LOWER(%s.nomAtividade) LIKE :nomAtividade', $qb->getRootAlias()));
                        $qb->setParameter('nomAtividade', sprintf('%%%s%%', strtolower($value)));

                        $datagrid->setValue($property, 'LIKE', $value);
                    },
                    'placeholder' => $this->trans('label.selecione'),
                    'property' => 'nomAtividade'
                ],
                [
                    'admin_code' => 'tributario.admin.economico_atividade'
                ]
            )
            ->add(
                'socio',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'getSocioSearchFilter'],
                    'label' => 'label.economicoConsultaCadastroEconomico.socio',
                ],
                'autocomplete',
                [
                    'class' => SwCgm::class,
                    'route' => [
                        'name' => 'api-search-swcgm-by-nomcgm'
                    ],
                ]
            )
            ->add(
                'localizacao',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'getLocalizacaoSearchFilter'],
                    'label' => 'label.economicoConsultaCadastroEconomico.localizacao',
                ],
                'entity',
                [
                    'class' => Localizacao::class,
                    'attr' => [
                        'class' => 'js-localizacao'
                    ],
                ]
            )
            ->add(
                'lote',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'getLoteSearchFilter'],
                    'label' => 'label.economicoConsultaCadastroEconomico.lote',
                ],
                'autocomplete',
                [
                    'class' => Lote::class,
                    'route' => [
                        'name' => 'urbem_tributario_economico_cadastro_economico_consulta_api_lote'
                    ],
                    'req_params' => [
                        'codLocalizacao' => 'varJsLocalizacao',
                    ],
                ]
            )
            ->add(
                'fkEconomicoCadastroEconomicoEmpresaDireito.fkEconomicoEmpresaDireitoNaturezaJuridicas.fkEconomicoNaturezaJuridica',
                'doctrine_orm_model_autocomplete',
                [
                    'label' => 'label.economicoConsultaCadastroEconomico.naturezaJuridica',
                ],
                'sonata_type_model_autocomplete',
                [
                    'attr' => ['class' => 'select2-parameters '],
                    'callback' => function (AbstractSonataAdmin $admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();

                        /** @var QueryBuilder|ProxyQueryInterface $qb */
                        $qb = $datagrid->getQuery();

                        $datagrid->setValue($property, 'LIKE', $value);
                    },
                    'placeholder' => $this->trans('label.selecione'),
                    'property' => 'nomNatureza'
                ],
                [
                    'admin_code' => 'tributario.admin.natureza_juridica'
                ]
            )
            ->add(
                'fkEconomicoAtividadeCadastroEconomicos.fkEconomicoLicencaAtividades.codLicenca',
                null,
                [
                    'label' => 'label.economicoConsultaCadastroEconomico.codLicenca',
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
            ->add('inscricaoEconomica', null, ['label' => 'label.economicoConsultaCadastroEconomico.inscricaoEconomica'])
            ->add(
                'nomCgm',
                null,
                [
                    'template'=>'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/list_nom_cgm.html.twig',
                    'label' => 'label.economicoConsultaCadastroEconomico.nome',
                ]
            )
            ->add(
                'atividade',
                null,
                [
                    'template'=>'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/list_atividade.html.twig',
                    'label' => 'label.economicoConsultaCadastroEconomico.atividade',
                ]
            )
            ->add(
                'situacao',
                null,
                [
                    'template'=>'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/list_situacao.html.twig',
                    'label' => 'label.economicoConsultaCadastroEconomico.situacao'
                ]
            )
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'consulta' => ['template' => 'TributarioBundle:Economico/CadastroEconomico/ConsultaCadastroEconomico:list__action_consulta.html.twig'],
                    ],
                    'header_style' => 'width: 35%'
                ]
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $this->cadastroEconomico = $this->getSubject();

        if ($this->showAction == $this::SHOW_ACTION_EMPRESA) {
            $this->showEmpresa($showMapper);
        }

        if ($this->showAction == $this::SHOW_ACTION_RESPONSAVEL) {
            $this->showResponsavel($showMapper);
        }

        if ($this->showAction == $this::SHOW_ACTION_ATIVIDADE) {
            $this->showAtividade($showMapper);
        }

        if ($this->showAction == $this::SHOW_ACTION_LICENCA) {
            $this->showLicenca($showMapper);
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    private function showEmpresa(ShowMapper $showMapper)
    {
        $fieldOptions['cadastroEconomico'] = [
            'mapped' => false,
            'label' => false,
        ];

        $fieldOptions['domicilioFiscal'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/domicilio_fiscal_show.html.twig',
        ];

        $fieldOptions['sociedade'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/sociedade_show.html.twig',
        ];

        $fieldOptions['listaSocios'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/lista_socios_show.html.twig',
        ];

        $fieldOptions['listaAtividades'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/lista_atividades_show.html.twig',
        ];

        $fieldOptions['listaDias'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/lista_dias_show.html.twig',
        ];

        $fieldOptions['atributo'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/atributo_show.html.twig',
        ];

        if ($this->cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaFato()) {
            $this->atributos = $this->getAtributos(CadastroEconomicoEmpresaFatoAdmin::MODULO, CadastroEconomicoEmpresaFatoAdmin::CADASTRO, new AtributoEmpresaFatoValor());
            $fieldOptions['cadastroEconomico']['template'] = 'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/cadastro_economico_empresa_fato_show.html.twig';
        }

        if ($this->cadastroEconomico->getFkEconomicoCadastroEconomicoAutonomo()) {
            $this->atributos = $this->getAtributos(CadastroEconomicoAutonomoAdmin::MODULO, CadastroEconomicoAutonomoAdmin::CADASTRO, new AtributoCadEconAutonomoValor());
            $fieldOptions['cadastroEconomico']['template'] = 'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/cadastro_economico_autonomo_show.html.twig';
        }

        if ($this->empresaDireito = $this->cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaDireito()) {
            $this->atributos = $this->getAtributos(CadastroEconomicoEmpresaDireitoAdmin::MODULO, CadastroEconomicoEmpresaDireitoAdmin::CADASTRO, new AtributoEmpresaDireitoValor());
            $fieldOptions['cadastroEconomico']['template'] = 'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/cadastro_economico_empresa_direito_show.html.twig';
        }

        $domicilioFiscal = $this->cadastroEconomico->getFkEconomicoDomicilioFiscais()->last();
        $domicilioInformado = $this->cadastroEconomico->getFkEconomicoDomicilioInformados()->last();
        if ($domicilioFiscal && $domicilioInformado) {
            $domicilioFiscal = $domicilioFiscal->getTimestamp() > $domicilioInformado->getTimestamp() ? $domicilioFiscal : false;
            $domicilioInformado = $domicilioInformado->getTimestamp() > $domicilioFiscal->getTimestamp() ? $domicilioInformado : false;
        }

        if ($domicilioFiscal) {
            $this->domicilioFiscal = $this->cadastroEconomico->getFkEconomicoDomicilioFiscais()->last();
        }

        if ($domicilioInformado) {
            $this->domicilioInformado = $this->cadastroEconomico->getFkEconomicoDomicilioInformados()->last();
            $this->municipio = $this->domicilioInformado->getFkSwLogradouro()->getFkSwBairroLogradouros()->first()->getFkSwBairro()->getFkSwMunicipio();
            $this->uf = $this->municipio->getFkSwUf();
        }

        $showMapper
            ->with('label.economicoConsultaCadastroEconomico.cabecalhoCadastroEconomico')
                ->add('cadastroEconomico', 'customField', $fieldOptions['cadastroEconomico'])
            ->end()
            ->with('label.economicoConsultaCadastroEconomico.cabecalhoDomicilioFiscal')
                ->add('domicilioFiscal', 'customField', $fieldOptions['domicilioFiscal'])
            ->end();

        if ($this->empresaDireito && $this->empresaDireito->getFkEconomicoSociedades()->count()) {
            $showMapper
                ->with('label.economicoConsultaCadastroEconomico.cabecalhoSociedade')
                    ->add('sociedade', 'customField', $fieldOptions['sociedade'])
                ->end()
                ->with('label.economicoConsultaCadastroEconomico.cabecalhoListaSocios')
                    ->add('listaSocios', 'customField', $fieldOptions['listaSocios'])
                ->end();
        }

        if ($this->cadastroEconomico->getFkEconomicoAtividadeCadastroEconomicos()->count()) {
            $showMapper
                ->with('label.economicoConsultaCadastroEconomico.cabecalhoListaAtividades')
                    ->add('listaAtividades', 'customField', $fieldOptions['listaAtividades'])
                ->end();
        }

        if ($this->cadastroEconomico->getFkEconomicoDiasCadastroEconomicos()->count()) {
            $showMapper
                ->with('label.economicoConsultaCadastroEconomico.cabecalhoListaDias')
                    ->add('listaDias', 'customField', $fieldOptions['listaDias'])
                ->end();
        }

        $showMapper
            ->with('label.economicoConsultaCadastroEconomico.cabecalhoAtributo')
                ->add('atributo', 'customField', $fieldOptions['atributo'])
            ->end();
    }

    /**
    * @param PersistentCollection|array|null $atributosSalvos
    * @return array
    */
    protected function getAtributos($modulo, $cadastro, $class)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $atributoModel = $em->getRepository(get_class($class))->findOneBy(
            [
                'inscricaoEconomica' => $this->cadastroEconomico->getInscricaoEconomica(),
                'codModulo' => $modulo,
                'codCadastro' => $cadastro,
            ]
        );

        if (!$atributoModel) {
            return [];
        }

        $atributos = (new AtributoDinamicoModel($em))->getAtributosDinamicosPessoal(['cod_modulo' => $modulo, 'cod_cadastro' => $cadastro]);
        $data = [];
        foreach ($atributos as $atributo) {
            $id = sprintf('%d-%d-%d', $modulo, $cadastro, $atributo->cod_atributo);
            $data[$id]['codAtributo'] = $atributo->cod_atributo;
            $data[$id]['name'] = $atributo->nom_atributo;
            $data[$id]['hash'] = md5($atributo->nom_atributo);
            $this->setParametrosAtributo($atributo, $data[$id]);
        }

        foreach ($data as &$atributo) {
            $atributoModel = $em->getRepository(get_class($class))->findOneBy(
                [
                    'inscricaoEconomica' => $this->cadastroEconomico->getInscricaoEconomica(),
                    'codAtributo' => $atributo['codAtributo'],
                    'codModulo' => $modulo,
                    'codCadastro' => $cadastro,
                ]
            );

            $atributo['value'] = '';
            if (!$atributoModel) {
                continue;
            }

            $atributo['value'] = $atributoModel->getValor();
            if (!empty($atributo['parameters']['choices']) && !empty($atributoModel->getValor())) {
                $atributo['value'] = array_flip($atributo['parameters']['choices'])[$atributoModel->getValor()];
            }
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

    /**
     * @param ShowMapper $showMapper
     */
    private function showResponsavel(ShowMapper $showMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $this->responsavelContabil = null;
        if ($this->cadastroEconomico->getFkEconomicoCadastroEconRespContabiis()->count()) {
            $this->responsavelContabil = $em->getRepository(ResponsavelTecnico::class)->findOneByNumcgm($this->cadastroEconomico->getFkEconomicoCadastroEconRespContabiis()->first()->getNumCgm());
        }

        $this->responsaveisTecnicos = [];
        foreach ($this->cadastroEconomico->getFkEconomicoCadastroEconRespTecnicos() as $responsavelTecnico) {
            $this->responsaveisTecnicos[] = $em->getRepository(ResponsavelTecnico::class)->findOneByNumcgm($responsavelTecnico->getNumCgm());
        }

        $fieldOptions['responsavelContabil'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/responsavel_show.html.twig',
        ];

        $fieldOptions['listaResponsaveisTecnicos'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/lista_responsaveis_show.html.twig',
        ];

        $showMapper
            ->with('label.economicoConsultaCadastroEconomico.cabecalhoResponsavelContabil')
                ->add('responsavelContabil', 'customField', $fieldOptions['responsavelContabil'])
            ->end();

        if ($this->responsaveisTecnicos) {
            $showMapper
                ->with('label.economicoConsultaCadastroEconomico.cabecalhoListaResponsaveisTecnicos')
                    ->add('listaResponsaveisTecnicos', 'customField', $fieldOptions['listaResponsaveisTecnicos'])
                ->end();
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    private function showAtividade(ShowMapper $showMapper)
    {
        $fieldOptions['listaAtividades'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/lista_atividades_show.html.twig',
        ];

        $fieldOptions['listaElementos'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/lista_elementos_show.html.twig',
        ];

        $fieldOptions['listaProcessos'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/lista_processos_show.html.twig',
        ];

        $showMapper
            ->tab('label.economicoConsultaCadastroEconomico.atividades')
                ->with('label.economicoConsultaCadastroEconomico.cabecalhoListaAtividades')
                    ->add('listaAtividades', 'customField', $fieldOptions['listaAtividades'])
                ->end()
            ->end()
            ->tab('label.economicoConsultaCadastroEconomico.elementos')
                ->with('label.economicoConsultaCadastroEconomico.cabecalhoListaElementos')
                    ->add('listaElementos', 'customField', $fieldOptions['listaElementos'])
                ->end()
            ->end()
            ->tab('label.economicoConsultaCadastroEconomico.historico')
                ->with('label.economicoConsultaCadastroEconomico.cabecalhoListaProcessos')
                    ->add('listaProcessos', 'customField', $fieldOptions['listaProcessos'])
                ->end()
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    private function showLicenca(ShowMapper $showMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $this->licencas = $this->getLicencas($this->cadastroEconomico);

        $fieldOptions['listaLicencas'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/lista_licencas_show.html.twig',
        ];

        $fieldOptions['listaModalidades'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/CadastroEconomico/ConsultaCadastroEconomico/lista_modalidades_show.html.twig',
        ];

        $showMapper
            ->tab('label.economicoConsultaCadastroEconomico.licencas')
                ->with('label.economicoConsultaCadastroEconomico.cabecalhoListaLicencas')
                    ->add('listaLicencas', 'customField', $fieldOptions['listaLicencas'])
                ->end()
            ->end()
            ->tab('label.economicoConsultaCadastroEconomico.modalidadesLancamento')
                ->with('label.economicoConsultaCadastroEconomico.cabecalhoListaModalidades')
                    ->add('listaModalidades', 'customField', $fieldOptions['listaModalidades'])
                ->end()
            ->end();
    }

    private function getLicencas(CadastroEconomico $cadastroEconomico)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        return $em->getRepository(Licenca::class)->getLicencasByInscricaoEconomica($cadastroEconomico->getInscricaoEconomica());
    }
}
