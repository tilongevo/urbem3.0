<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Imobiliario\Condominio;
use Urbem\CoreBundle\Entity\Imobiliario\CondominioProcesso;
use Urbem\CoreBundle\Entity\Imobiliario\Construcao;
use Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoOutros;
use Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoProcesso;
use Urbem\CoreBundle\Entity\Imobiliario\Corretagem;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelProcesso;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso;
use Urbem\CoreBundle\Entity\SwBairro;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwLogradouro;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Imobiliario\CondominioModel;
use Urbem\CoreBundle\Model\Imobiliario\ConstrucaoModel;
use Urbem\CoreBundle\Model\Imobiliario\ImovelModel;
use Urbem\CoreBundle\Model\Imobiliario\LoteModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ConsultaCadastroImobiliarioAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_consultas_cadastro_imobiliario';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/consultas/cadastro-imobiliario';
    protected $exibirBotaoIncluir = false;
    protected $includeJs = array(
        '/tributario/javascripts/imobiliario/consulta-cadastro-imobiliario.js',
    );

    const NAO_INFORMADO = 0;
    const COD_PAIS = 1;

    const ORD_INSCRICAO_MUNICIPAL = 'inscricao_municipal';
    const ORD_LOCALIZACAO = 'localizacao';
    const ORD_ENDERECO = 'endereco';

    /**
     * @param Imovel $imovel
     * @return string
     */
    public function consultaSituacao(Imovel $imovel)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return ((new ImovelModel($em))->verificaBaixa($imovel))
            ? $this->getTranslator()->trans('label.imobiliarioConsulta.baixado')
            : $this->getTranslator()->trans('label.imobiliarioConsulta.ativo');
    }

    /**
     * @param Construcao $construcao
     * @return string
     */
    public function consultaSituacaoConstrucao(Construcao $construcao)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return ((new ConstrucaoModel($em))->verificaBaixa($construcao))
            ? $this->getTranslator()->trans('label.imobiliarioConsulta.baixado')
            : $this->getTranslator()->trans('label.imobiliarioConsulta.ativo');
    }

    /**
     * @param Lote $lote
     * @return array
     */
    public function consultaAtributosLote(Lote $lote)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new LoteModel($em))->getNomAtributoValorByLote($lote);
    }

    /**
     * @param Imovel $imovel
     * @return array
     */
    public function consultaAtributosImovel(Imovel $imovel)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new ImovelModel($em))->getNomAtributoValorByImovel($imovel);
    }

    /**
     * @param Lote $lote
     * @return array
     */
    public function consultaProcessosLote(Lote $lote)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $loteModel = new LoteModel($em);
        $listaProcessos = array();
        /** @var LoteProcesso $loteProcesso */
        foreach ($lote->getFkImobiliarioLoteProcessos() as $loteProcesso) {
            $listaProcessos[] = array(
                'processo' => $loteProcesso,
                'atributoDinamico' => $loteModel->getNomAtributoValorByLote($lote, $loteProcesso->getTimestamp())
            );
        }
        return $listaProcessos;
    }

    /**
     * @param Construcao $construcao
     * @return array
     */
    public function consultaProcessosConstrucao(Construcao $construcao)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $construcaoModel = new ConstrucaoModel($em);
        $listaProcessos = array();
        /** @var ConstrucaoProcesso $construcaoProcesso */
        foreach ($construcao->getFkImobiliarioConstrucaoProcessos() as $construcaoProcesso) {
            $listaProcessos[] = array(
                'processo' => $construcaoProcesso,
                'atributoDinamico' => ($construcao->getFkImobiliarioConstrucaoOutros())
                    ? $construcaoModel->getNomAtributoValorByConstrucaoOutros($construcao->getFkImobiliarioConstrucaoOutros(), $construcaoProcesso->getTimestamp())
                    : $construcaoModel->getNomAtributoValorByConstrucao($construcao, $construcaoProcesso->getTimestamp())
            );
        }
        return $listaProcessos;
    }

    /**
     * @return string
     */
    public function getPictureUploadDir()
    {
        $foldersBundle = $this->getContainer()->getParameter('tributariobundle');
        return $foldersBundle['imovelFoto'];
    }

    /**
     * @return string
     */
    public function getPictureShowDir()
    {
        $foldersBundle = $this->getContainer()->getParameter('tributariobundle');
        return $foldersBundle['imovelFotoShow'];
    }

    /**
     * @return string
     */
    public function getPictureDownloadDir()
    {
        $foldersBundle = $this->getContainer()->getParameter('tributariobundle');
        return $foldersBundle['imovelFotoDownload'];
    }

    /**
     * @param Imovel $imovel
     * @return mixed
     */
    public function consultaAreaImovel(Imovel $imovel)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new ImovelModel($em))->consultaAreaImovel($imovel->getInscricaoMunicipal());
    }

    /**
     * @param Imovel $imovel
     * @return mixed
     */
    public function consultaAreaImovelLote(Imovel $imovel)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new ImovelModel($em))->consultaAreaImovelLote($imovel->getInscricaoMunicipal());
    }

    /**
     * @param Imovel $imovel
     * @return mixed
     */
    public function consultaFracaoIdeal(Imovel $imovel)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new ImovelModel($em))->consultaFracaoIdeal($imovel->getInscricaoMunicipal());
    }

    /**
     * @param Imovel $imovel
     * @return array
     */
    public function consultaProcessosImovel(Imovel $imovel)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $imovelModel = new ImovelModel($em);
        $listaProcessos = array();
        /** @var ImovelProcesso $imovelProcesso */
        foreach ($imovel->getFkImobiliarioImovelProcessos() as $imovelProcesso) {
            $listaProcessos[] = array(
                'processo' => $imovelProcesso,
                'atributoDinamico' => $imovelModel->getNomAtributoValorByImovel($imovel, $imovelProcesso->getTimestamp())
            );
        }
        return $listaProcessos;
    }

    /**
     * @param Condominio $condominio
     * @return array
     */
    public function consultaProcessosCondominio(Condominio $condominio)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $condominioModel = new CondominioModel($em);
        $listaProcessos = array();
        /** @var CondominioProcesso $condominioProcesso */
        foreach ($condominio->getFkImobiliarioCondominioProcessos() as $condominioProcesso) {
            $listaProcessos[] = array(
                'processo' => $condominioProcesso,
                'atributoDinamico' => $condominioModel->getNomAtributoValorByCondominio($condominio, $condominioProcesso->getTimestamp())
            );
        }
        return $listaProcessos;
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'tipo' => $this->getRequest()->get('tipo'),
        );
    }

    /**
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($this->getPersistentParameter('tipo')) {
            default:
            case 'lote':
                $template = 'TributarioBundle:Sonata/Imobiliario/Consulta/CRUD:show__lote.html.twig';
                break;
            case 'imovel':
                $template = 'TributarioBundle:Sonata/Imobiliario/Consulta/CRUD:show__imovel.html.twig';
                break;
            case 'proprietario':
                $template = 'TributarioBundle:Sonata/Imobiliario/Consulta/CRUD:show__proprietario.html.twig';
                break;
            case 'condominio':
                $template = 'TributarioBundle:Sonata/Imobiliario/Consulta/CRUD:show__condominio.html.twig';
                break;
            case 'transferencia':
                $template = 'TributarioBundle:Sonata/Imobiliario/Consulta/CRUD:show__transferencia.html.twig';
                break;
        }

        switch ($name) {
            case 'show':
                return $template;
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'show']);
        $collection->add('autocomplete_lote', 'autocomplete-lote');
        $collection->add('autocomplete_imovel', 'autocomplete-imovel');
        $collection->add('autocomplete_sw_bairro', 'autocomplete-sw-bairro');
        $collection->add('autocomplete_sw_logradouro', 'autocomplete-sw-logradouro');
        $collection->add('autocomplete_sw_cgm', 'autocomplete-sw-cgm');
        $collection->add('autocomplete_condominio', 'autocomplete-condominio');
        $collection->add('autocomplete_corretagem', 'autocomplete-corretagem');
        $collection->add('consultar_municipio', 'consultar-municipio');
        $collection->add('relatorio', $this->getRouterIdParameter() . '/relatorio');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codLocalizacao',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioConsulta.localizacao',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'autocomplete',
                [
                    'class' => Localizacao::class,
                    'route' => [
                        'name' => 'urbem_tributario_imobiliario_localizacao_autocomplete_localizacao'
                    ]
                ]
            )
            ->add(
                'codLote',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioConsulta.lote',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'autocomplete',
                [
                    'class' => Lote::class,
                    'route' => [
                        'name' => 'urbem_tributario_imobiliario_consultas_cadastro_imobiliario_autocomplete_lote'
                    ],
                    'req_params' => [
                        'codLocalizacao' => 'varJsCodLocalizacao'
                    ]
                ]
            )
            ->add(
                'inscricaoMunicipal',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioConsulta.inscricaoImobiliaria',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'autocomplete',
                [
                    'class' => Imovel::class,
                    'route' => [
                        'name' => 'urbem_tributario_imobiliario_consultas_cadastro_imobiliario_autocomplete_imovel'
                    ],
                    'req_params' => [
                        'codLocalizacao' => 'varJsCodLocalizacao',
                        'codLote' => 'varJsCodLote'
                    ]
                ]
            )
            ->add(
                'codUf',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioConsulta.estado',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'entity',
                [
                    'class' => SwUf::class,
                    'choice_value' => 'codUf',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('o')
                            ->where('o.codUf != :codUf')
                            ->andWhere('o.codPais = :codPais')
                            ->setParameters([
                                'codUf' => self::NAO_INFORMADO,
                                'codPais' => self::COD_PAIS
                            ])
                            ->orderBy('o.nomUf');
                    }
                ]
            )
            ->add(
                'codMunicipio',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioConsulta.municipio',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'choice',
                [
                    'choices' => array()
                ]
            )
            ->add(
                'codBairro',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioConsulta.bairro',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'autocomplete',
                [
                    'class' => SwBairro::class,
                    'route' => [
                        'name' => 'urbem_tributario_imobiliario_consultas_cadastro_imobiliario_autocomplete_sw_bairro'
                    ],
                    'req_params' => [
                        'codUf' => 'varJsCodUf',
                        'codMunicipio' => 'varJsCodMunicipio'
                    ]
                ]
            )
            ->add(
                'codLogradouro',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioConsulta.logradouro',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'autocomplete',
                [
                    'class' => SwLogradouro::class,
                    'route' => [
                        'name' => 'urbem_tributario_imobiliario_consultas_cadastro_imobiliario_autocomplete_sw_logradouro'
                    ],
                    'req_params' => [
                        'codUf' => 'varJsCodUf',
                        'codMunicipio' => 'varJsCodMunicipio',
                        'codBairro' => 'varJsCodBairro'
                    ]
                ]
            )
            ->add(
                'numero',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioConsulta.numero',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'number'
            )
            ->add(
                'complemento',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioConsulta.complemento',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'text'
            )
            ->add(
                'codCondominio',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioConsulta.condominio',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'autocomplete',
                [
                    'class' => Condominio::class,
                    'route' => [
                        'name' => 'urbem_tributario_imobiliario_consultas_cadastro_imobiliario_autocomplete_condominio'
                    ]
                ]
            )
            ->add(
                'numcgm',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioConsulta.proprietario',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'autocomplete',
                [
                    'class' => SwCgm::class,
                    'route' => [
                        'name' => 'urbem_tributario_imobiliario_consultas_cadastro_imobiliario_autocomplete_sw_cgm'
                    ]
                ]
            )
            ->add(
                'corretagem',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioConsulta.creci',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'autocomplete',
                [
                    'class' => Corretagem::class,
                    'route' => [
                        'name' => 'urbem_tributario_imobiliario_consultas_cadastro_imobiliario_autocomplete_corretagem'
                    ]
                ]
            )
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        $filter = $this->getDataGrid()->getValues();

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $imovelModel = new ImovelModel($em);
        $retorno = $imovelModel->consultar($filter);
        $values = implode(',', array_column($retorno, 'inscricao_municipal'));

        if ($values) {
            $queryBuilder->add('where', $queryBuilder->expr()->in('o.inscricaoMunicipal', $values));
        } else {
            $queryBuilder->where('1 = 0');
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('inscricaoMunicipal', 'text', ['label' => 'label.imobiliarioConsulta.inscricaoImobiliaria'])
            ->add('logradouro', 'text', ['label' => 'label.imobiliarioConsulta.endereco'])
            ->add('localizacao', 'text', ['label' => 'label.imobiliarioConsulta.localizacao'])
            ->add('lote', 'text', ['label' => 'label.imobiliarioConsulta.lote'])
            ->add(
                'situacao',
                'customField',
                [
                    'label' => 'label.imobiliarioConsulta.situacao',
                    'mapped' => false,
                    'template' => 'TributarioBundle:Sonata/Imobiliario/Consulta/CRUD:list__situacao.html.twig',
                ]
            )
            ->add('_action', 'actions', [
                'actions' => [
                    'lote' => ['template' => 'TributarioBundle:Sonata/Imobiliario/Consulta/CRUD:list__action_lote.html.twig'],
                    'imovel' => ['template' => 'TributarioBundle:Sonata/Imobiliario/Consulta/CRUD:list__action_imovel.html.twig'],
                    'proprietario' => ['template' => 'TributarioBundle:Sonata/Imobiliario/Consulta/CRUD:list__action_proprietario.html.twig'],
                    'condominio' => ['template' => 'TributarioBundle:Sonata/Imobiliario/Consulta/CRUD:list__action_condominio.html.twig'],
                    'tranferencia' => ['template' => 'TributarioBundle:Sonata/Imobiliario/Consulta/CRUD:list__action_transferencia.html.twig'],
                    'relatorio' => ['template' => 'TributarioBundle:Sonata/Imobiliario/Consulta/CRUD:list__action_relatorio.html.twig']
                ],
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('inscricaoMunicipal')
        ;
    }
}
