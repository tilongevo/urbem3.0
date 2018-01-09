<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Patrimonio\Bem;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Urbem\CoreBundle\Model\Patrimonial;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractOrganogramaSonata;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Patrimonio;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\Organograma;

use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\BemModel;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;

/**
 * Class BemAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio
 * @extends Urbem\CoreBundle\Resources\config\Sonata\AbstractOrganogramaSonata
 */
class BemAdmin extends AbstractOrganogramaSonata
{
    const NIVEL_UM = 1;
    const NIVEL_DOIS = 2;
    const NIVEL_TRES = 3;

    /** @var null|Bem  */
    public $bemVirgem = null;

    protected $baseRouteName = 'urbem_patrimonial_patrimonio_bem';

    protected $baseRoutePattern = 'patrimonial/patrimonio/bem';

    protected $model = Model\Patrimonial\Patrimonio\BemModel::class;

    protected $includeJs = [
        '/administrativo/javascripts/organograma/estruturaDinamicaOrganograma.js',
        '/core/javascripts/sw-processo.js',
        '/patrimonial/javascripts/patrimonio/bem.js'
    ];

    protected $fkPatrimonioReavaliacao = [];

    /**
     * @param Bem $bem
     */
    protected function createFkPatrimonioReavaliacao(Bem $bem)
    {

        /** @var $reavaliacao Patrimonio\Reavaliacao */
        foreach ($bem->getFkPatrimonioReavaliacoes() as $reavaliacao) {
            if (null == $reavaliacao->getCodReavaliacao()) {
                $this->fkPatrimonioReavaliacao[] = clone $reavaliacao;
                $bem->removeFkPatrimonioReavaliacoes($reavaliacao);
            }
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $exercicio = $this->getExercicio();

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $OrganogramaModel = new OrganogramaModel($em);
        $organoAtivo = $OrganogramaModel->getOrganogramaVigentePorTimestamp();

        $fieldOptions['responsavel'] = [
            'label' => 'label.bem.responsavel',
            'multiple' => false,
            'mapped' => false,
            'required' => true,
            'route' => ['name' => 'carrega_sw_cgm'],
            'placeholder' => 'Selecione'
        ];
        $fieldOptions['dtInicialResponsavel'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.bem.dtInicialResponsavel',
            'mapped' => false
        ];

        // Classificação
        $fieldOptions['classificacao'] = [
            'label' => 'label.bem.classificacao',
            'mapped' => false,
            'attr' => [
                'readonly' => true,
                'disabled' => true
            ],
            'data' => '0.0.0'
        ];
        $fieldOptions['natureza'] = [
            'class' => Patrimonio\Natureza::class,
            'label' => 'label.bem.natureza',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];
        $fieldOptions['grupo'] = [
            'class' => Patrimonio\Grupo::class,
            'label' => 'label.bem.grupo',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];
        $fieldOptions['especie'] = [
            'class' => Patrimonio\Especie::class,
            'label' => 'label.bem.especie',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];

        // Infos Básicas
        $fieldOptions['codClassificacao'] = [
            'class' => Entity\SwClassificacao::class,
            'mapped' => false,
            'label' => 'label.bem.codClassificacao',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione',
        ];
        $fieldOptions['codAssunto'] = [
            'class' => Entity\SwAssunto::class,
            'mapped' => false,
            'label' => 'label.bem.codAssunto',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];
        $fieldOptions['procAdministrativo'] = [
            'class' => Entity\SwProcesso::class,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.bem.procAdministrativo',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'required' => true,
        ];

        $fieldOptions['marca'] = [
            'class' => Almoxarifado\Marca::class,
            'choice_label' => 'descricao',
            'label' => 'label.bem.marca',
            'mapped' => false,
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];
        $fieldOptions['fornecedor'] = [
            'label' => 'label.bem.fornecedor',
            'property' => 'nomCgm',
            'container_css_class' => 'select2-v4-parameters ',
            'to_string_callback' => function (Entity\SwCgm $fornecedor, $property) {
                return $fornecedor->getNumcgm() . ' - ' . $fornecedor->getNomCgm();
            },
            'placeholder' => 'Selecione'
        ];
        $fieldOptions['identificacao'] = [
            'label' => 'label.bem.identificacao',
            'required' => false
        ];
        $bemModel = new BemModel($em);

        $configuracaoModel = new Model\Administracao\ConfiguracaoModel($em);
        $info = [
            'cod_modulo' => Model\Administracao\ConfiguracaoModel::MODULO_PATRIMONAL_PATRIMONIO,
            'exercicio' => $exercicio,
            'parametro' => 'placa_alfanumerica'
        ];
        $placaAlfanumerica = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info);
        $placaAlfanumerica = $placaAlfanumerica['valor'];

        $classChamadaPlaca = 'alfa ';

        if ('false' === $placaAlfanumerica) {
            $chamadaPlaca = $bemModel->getAvailableNumPlaca();
            $classChamadaPlaca = 'numeric ';
        } else {
            $chamadaPlaca = $bemModel->getAvailableNumPlacaAlfanumerica();
        }

        $fieldOptions['numPlaca'] = [
            'label' => 'label.bem.numPlaca',
            'data' => $chamadaPlaca,
            'attr' => [
                'class' => $classChamadaPlaca
            ]
        ];

        //Atributos
        $fieldOptions['atributosDinamicos'] = [
            'mapped' => false,
            'required' => false
        ];
        $fieldOptions['codBem'] = [
            'data' => $id,
            'mapped' => false
        ];

        //Infos Financeiras
        $fieldOptions['exercicio'] = [
            'label' => 'label.bem.exercicio',
            'mapped' => false,
            'data' => $this->getExercicio(),
        ];
        $fieldOptions['entidade'] = [
            'class' => Entidade::class,
            'choice_label' => function (Entidade $entidade) {
                return $entidade->getCodEntidade() . ' - ' . $entidade->getFkSwCgm()->getNomCgm();
            },
            'label' => 'label.bem.entidade',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'query_builder' => function (EntityRepository $entityManager) use ($exercicio) {
                $qb = $entityManager->createQueryBuilder('entidade');
                $result = $qb->where('entidade.exercicio = :exercicio')
                    ->setParameter(':exercicio', $exercicio);

                return $result;
            },
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['orgaoOrg'] = [
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
            'query_builder' => function (EntityRepository $entityManager) use ($exercicio) {
                $qb = $entityManager->createQueryBuilder('orgaoOrg');
                $result = $qb->where('orgaoOrg.exercicio = :exercicio')
                    ->setParameter(':exercicio', $exercicio);

                return $result;
            },
            'placeholder' => 'label.selecione'
        ];
        $fieldOptions['unidade'] = [
            'class' => Orcamento\Unidade::class,
            'choice_label' => function (Orcamento\Unidade $unidade) {
                return $unidade;
            },
            'label' => 'label.bem.unidade',
            'mapped' => false,
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];
        $fieldOptions['numEmpenho'] = [
            'label' => 'label.bem.numEmpenho',
            'required' => false,
            'mapped' => false
        ];
        $fieldOptions['numNotaFiscal'] = [
            'label' => 'label.bem.numNotaFiscal',
            'required' => false,
            'mapped' => false
        ];
        $fieldOptions['dtNotaFiscal'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.bem.dtNotaFiscal',
            'required' => false,
            'mapped' => false
        ];
        $fileFieldOptions = [
            'data_class' => null,
            'required' => false,
            'mapped' => false,
            'label' => 'label.bem.arqNotaFiscal',
        ];

        // Depreciação Inicial
        $fieldOptions['depreAcumulada'] = [
            'label' => 'label.bem.depreAcumulada',
            'attr' => array(
                'class' => 'money ',
                'readonly' => true,
                'disabled' => true
            ),
            'required' => false,
            'mapped' => false
        ];

        // Histórico
        $fieldOptions['classificacaoOld'] = [
            'label' => 'label.bem.classificacaoOld',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'readonly' => true,
                'disabled' => true
            ]
        ];

        $fieldOptions['organogramaAtivo'] = [
            'label' => 'label.bem.organogramaAtivo',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'readonly' => true,
                'disabled' => true
            ]
        ];

        $fieldOptions['codOrganograma'] = [
            'mapped' => false,
            'required' => false,
        ];
        $fieldOptions['organogramaAtivo']['data'] =
            $organoAtivo['cod_organograma'] . ' - ' . date("d/m/Y", strtotime($organoAtivo['dt_final']));
        $fieldOptions['codOrganograma']['data'] = $organoAtivo['cod_organograma'];

        $organogramaModel = new OrganogramaModel($em);
        $orgOrgao = $organogramaModel->listarOrgaosRelacionadosDescricaoComponente(
            $organoAtivo['cod_organograma'],
            self::NIVEL_UM
        );

        $orgOgaosChoices = array();

        foreach ($orgOrgao as $org) {
            $choiceKey = $org['descricao'];
            $choiceValue = $org['cod_orgao'];

            $orgOgaosChoices[$choiceKey] = $choiceValue;
        }

        $fieldOptions['orgao'] = [
            'label' => 'label.bem.orgao',
            'mapped' => false,
            'choices' => $orgOgaosChoices,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];
        $fieldOptions['secretarias'] = [
            'attr' => [
                'class' => 'select2-parameters ',
                'disabled' => 'disabled'
            ],
            'label' => 'label.bem.secretarias',
            'mapped' => false,
            'placeholder' => 'label.selecione',
        ];
        $fieldOptions['unidades'] = [
            'attr' => [
                'class' => 'select2-parameters ',
                'disabled' => 'disabled'
            ],
            'label' => 'label.bem.unidades',
            'mapped' => false,
            'placeholder' => 'label.selecione',
        ];
        $fieldOptions['local'] = [
            'class' => Organograma\Local::class,
            'choice_label' => 'descricao',
            'label' => 'label.bem.local',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];
        $fieldOptions['situacao'] = [
            'class' => Patrimonio\SituacaoBem::class,
            'choice_label' => 'nomSituacao',
            'label' => 'label.bem.situacao',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];
        $fieldOptions['descSituacao'] = [
            'label' => 'label.bem.descSituacao',
            'required' => false,
            'mapped' => false
        ];

        // Apólice
        $fieldOptions['assegurado'] = [
            'label' => 'label.bem.assegurado',
            'mapped' => false,
            'required' => false
        ];
        $fieldOptions['apolicesCollection'] = [
            'class' => Patrimonio\Apolice::class,
            'label' => 'label.bem.apolice',
            'mapped' => false,
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];

        // Depreciação
        $fieldOptions['contaContabilAcumulada'] = [
            'label' => 'label.bem.contaContabilAcumulada',
            'route' => ['name' => 'carrega_plano_analitica'],
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'Selecione',
            'required' => false,
            'mapped' => false
        ];
        $fieldOptions['depreciavel'] = [
            'label' => 'label.bem.depreciavel',
            'required' => false
        ];
        $fieldOptions['contaContabil'] = [
            'label' => 'label.bem.contaContabil',
            'route' => ['name' => 'carrega_plano_analitica'],
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'Selecione',
            'mapped' => false
        ];
        $fieldOptions['depreciacaoAcelerada'] = [
            'label' => 'label.bem.depreciacaoAcelerada',
            'required' => false
        ];



        if ($this->id($this->getSubject())) {
            /** @var Bem $bem */
            $bem = $this->getSubject();
            // Processa Classificação
            $fieldOptions['classificacao']['data'] = $bem->getCodNatureza().'.'.
                $bem->getCodGrupo().'.'.$bem->getCodEspecie();
            $fieldOptions['natureza']['data'] = $bem->getFkPatrimonioEspecie()
                ->getFkPatrimonioGrupo()->getFkPatrimonioNatureza();
            $fieldOptions['grupo']['data'] = $bem->getFkPatrimonioEspecie()
                ->getFkPatrimonioGrupo();
            $fieldOptions['especie']['data'] = $bem->getFkPatrimonioEspecie();

            // NumPlaca
            $fieldOptions['numPlaca']['data'] = $bem->getNumPlaca();

            // Processa BemProcesso
            $bemProcesso = $bem->getFkPatrimonioBemProcesso();
            if ($bemProcesso) {
                $fieldOptions['codClassificacao']['data'] = $bemProcesso->getFkSwProcesso()
                    ->getFkSwAssunto()->getFkSwClassificacao();
                $assunto = $bemProcesso->getFkSwProcesso()->getFkSwAssunto();
                $fieldOptions['codAssunto']['choice_value'] = function (Entity\SwAssunto $assunto) {
                    return $this->getObjectKey($assunto);
                };
                $fieldOptions['codAssunto']['data'] = $bemProcesso->getFkSwProcesso()
                    ->getFkSwAssunto();
                $processo = $bemProcesso->getFkSwProcesso();
                $fieldOptions['procAdministrativo']['query_builder'] =
                    function (EntityRepository $entityManager) use ($processo) {
                        $qb = $entityManager->createQueryBuilder('processo');
                        $result = $qb
                            ->where('processo.codProcesso = :codProcesso')
                            ->andWhere('processo.anoExercicio = :anoExercicio')
                            ->setParameter(':codProcesso', $processo->getCodProcesso())
                            ->setParameter(':anoExercicio', $processo->getAnoExercicio());

                        return $result;
                    };
                $processo = $bemProcesso->getFkSwProcesso();
                $fieldOptions['procAdministrativo']['choice_value'] = function (SwProcesso $processo) {
                    return $this->getObjectKey($processo);
                };
                $fieldOptions['procAdministrativo']['data'] = $processo;
            }


            //Processa HistoricoBem
            $bemModel = new BemModel($em);
            $historicoBem = $bemModel->getHistoricoBem($bem);
            $historicoBem = end($historicoBem);
            if ($historicoBem) {
                $fieldOptions['orgao']['required'] = false;
                $fieldOptions['secretarias']['required'] = false;
                $fieldOptions['unidades']['required'] = false;
                $fieldOptions['situacao']['data'] = $historicoBem->getFkPatrimonioSituacaoBem();
                $fieldOptions['local']['data'] = $historicoBem->getFkOrganogramaLocal();
                $fieldOptions['descSituacao']['data'] = $historicoBem->getDescricao();

                $organogramaModel = new OrganogramaModel($em);
                $orgao = $organogramaModel->consultaOrgao(
                    $organoAtivo['cod_organograma'],
                    $historicoBem->getCodOrgao()
                );

                // Monta JS com base no órgão cadastrado para este usuário
                $this->executeScriptLoadData(
                    $this->getOrgaoNivelByCodOrgao($historicoBem->getCodOrgao())
                );
            }

            //Processa BemResponsavel
            $bemResponsavel = $bem->getBemResponsavel();
            if ($bemResponsavel) {
                $fieldOptions['responsavel']['data'] = $bemResponsavel->getFkSwCgm();
                $fieldOptions['dtInicialResponsavel']['data'] = $bemResponsavel->getDtInicio();
            }

            //Processa BemMarca
            $bemMarca = $bem->getFkPatrimonioBemMarca();
            if ($bemMarca) {
                $fieldOptions['marca']['data'] = $bemMarca->getFkAlmoxarifadoMarca();
            }

            //Processa BemComprado
            $bemComprado = $bem->getFkPatrimonioBemComprado();
            if ($bemComprado) {
                $fieldOptions['exercicio']['data'] = $bemComprado->getExercicio();
                $fieldOptions['exercicio']['attr'] = ['readonly' => 'readonly'];
                $fieldOptions['entidade']['data'] = $bemComprado->getFkOrcamentoEntidade();
                $fieldOptions['numEmpenho']['data'] = $bemComprado->getCodEmpenho();
                $fieldOptions['numNotaFiscal']['data'] = (trim($bemComprado->getNotaFiscal()) == '') ? 0 : $bemComprado->getNotaFiscal();
                if ($bemComprado->getFkOrcamentoUnidade()) {
                    $fieldOptions['orgaoOrg']['data'] = $bemComprado->getFkOrcamentoUnidade()->getFkOrcamentoOrgao();
                    $fieldOptions['unidade']['data'] = $bemComprado->getFkOrcamentoUnidade();
                }
                $fieldOptions['dtNotaFiscal']['data'] = $bemComprado->getDataNotaFiscal();

                $image = $bemComprado->getCaminhoNf();

                if (($image != "Caminho da foto") && ($image != null)) {
                    $container = $this->getConfigurationPool()->getContainer();
                    $servidorPath = $container->getParameter("patrimonialbundle");

                    $fullPath = $servidorPath['bemdownload'] . $image;

                    $fileFieldOptions['help'] =
                        '<a class="uploader-link-download" href="' . $fullPath . '">Arquivo Nota Fiscal Atual</a>';
                }
            }

            //Processa Apolices
            $apoliceBem = $bem->getApoliceBem();
            if ($apoliceBem) {
                $fieldOptions['assegurado']['data'] = true;
                $fieldOptions['apolicesCollection']['data'] = $apoliceBem->getFkPatrimonioApolice();
            }

            //Depreciação Acumulada

            $depreAcumulada = $bemModel->montaRecuperaSaldoBem($id);
            $fieldOptions['depreAcumulada']['data'] = (
                $depreAcumulada[0]['vl_acumulado'] ? $depreAcumulada[0]['vl_acumulado'] : '0.00'
            );

            //Processa BemPlanoDepreciacao
            $bemPlanoDepreciacao = $bem->getPlanoDepreciacao();
            if ($bemPlanoDepreciacao) {
                $fieldOptions['contaContabilAcumulada']['data'] =
                    $bemPlanoDepreciacao->getFkContabilidadePlanoAnalitica();
            }

            //Processa BemPlanoAnalitica
            $bemPlanoAnalitica = $bem->getPlanoAnalitica();
            if ($bemPlanoAnalitica) {
                $fieldOptions['contaContabil']['data'] =
                    $bemPlanoAnalitica->getFkContabilidadePlanoAnalitica();
            }
        } else {
            $fieldOptions['procAdministrativo']['choices'] = [];
            if ('POST' == $this->getRequest()->getMethod()) {
                $this->executeScriptLoadData($this->getRequest()->request->get($this->getUniqid()));
            }
        }

        $formMapper
            ->tab('label.bem.classificacao')
            ->with('')
            ->add(
                'classificacao',
                'text',
                $fieldOptions['classificacao']
            )
            ->add(
                'codNatureza',
                'entity',
                $fieldOptions['natureza']
            )
            ->add(
                'codGrupo',
                'entity',
                $fieldOptions['grupo']
            )
            ->add(
                'codEspecie',
                'entity',
                $fieldOptions['especie']
            )
            ->end()
            ->with('label.bem.infoBasica')
            ->add(
                'descricao',
                'text',
                [
                    'label' => 'label.bem.descricao',
                ]
            )
            ->add(
                'codClassificacao',
                'entity',
                $fieldOptions['codClassificacao']
            )
            ->add('codAssunto', 'entity', $fieldOptions['codAssunto'])
            ->add(
                'codProcesso',
                'entity',
                $fieldOptions['procAdministrativo']
            )
            ->add(
                'detalhamento',
                'text',
                [
                    'label' => 'label.bem.detalhamento'
                ]
            )
            ->add(
                'marca',
                'entity',
                $fieldOptions['marca']
            )
            ->add(
                'fkSwCgm',
                'sonata_type_model_autocomplete',
                $fieldOptions['fornecedor'],
                ['admin_code' => 'core.admin.filter.sw_cgm']
            )
            ->add(
                'vlBem',
                'number',
                [
                    'label' => 'label.bem.vlBem',
                    'attr' => array(
                        'class' => 'money '
                    )
                ]
            )
            ->add(
                'dtAquisicao',
                'sonata_type_date_picker',
                [
                    'label' => 'label.bem.dtAquisicao',
                    'format' => 'dd/MM/yyyy'
                ]
            )
            ->add(
                'dtGarantia',
                'sonata_type_date_picker',
                [
                    'label' => 'label.bem.dtGarantia',
                    'required' => false,
                    'format' => 'dd/MM/yyyy'
                ]
            )
            ->add(
                'identificacao',
                'checkbox',
                $fieldOptions['identificacao']
            )
            ->add(
                'numPlaca',
                'text',
                $fieldOptions['numPlaca']
            )
            ->end()
            ->with('label.bem.atributo')
                ->add(
                    'atributosDinamicos',
                    'text',
                    $fieldOptions['atributosDinamicos']
                );

        //Hiddens para Atributo Dinâmico
        if ($this->id($this->getSubject())) {
            $formMapper->add('codBem', 'hidden', $fieldOptions['codBem']);
        }

        $formMapper
            ->end()
            ->with('label.bem.infoFinanceira')
            ->add(
                'exercicio',
                'number',
                $fieldOptions['exercicio']
            )
            ->add(
                'entidade',
                'entity',
                $fieldOptions['entidade']
            )
            ->add(
                'orgaoOrg',
                'entity',
                $fieldOptions['orgaoOrg']
            )
            ->add(
                'unidade',
                'entity',
                $fieldOptions['unidade']
            )
            ->add(
                'vidaUtil',
                'number',
                [
                    'label' => 'label.bem.vidaUtil',
                    'required' => false
                ]
            )
            ->add(
                'dtIncorporacao',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'label' => 'label.bem.dtIncorporacao'
                ]
            )
            ->add(
                'numEmpenho',
                'number',
                $fieldOptions['numEmpenho']
            )
            ->add(
                'numNotaFiscal',
                'number',
                $fieldOptions['numNotaFiscal']
            )
            ->add(
                'dtNotaFiscal',
                'sonata_type_date_picker',
                $fieldOptions['dtNotaFiscal']
            )
            ->add(
                'caminhoNf',
                'file',
                $fileFieldOptions
            )
            ->end()
            ->with('label.bem.depreciacaoInicial')
            ->add(
                'vlDepreciacao',
                'number',
                [
                    'label' => 'label.bem.depreInicial',
                    'attr' => array(
                        'class' => 'money '
                    )
                ]
            )
            ->add(
                'depreAcumulada',
                'number',
                $fieldOptions['depreAcumulada']
            )
            ->end()
            ->with('label.bem.responsavel')
            ->add(
                'responsavel',
                'autocomplete',
                $fieldOptions['responsavel']
            )
            ->add(
                'dtInicialResponsavel',
                'sonata_type_date_picker',
                $fieldOptions['dtInicialResponsavel']
            )
            ->end()
            ->with('label.bem.historico');

        $this->createFormOrganograma($formMapper, $exibeOrganogramaAtivo = true);

        $formMapper
            ->add(
                'local',
                'entity',
                $fieldOptions['local']
            )
            ->add(
                'situacao',
                'entity',
                $fieldOptions['situacao']
            )
            ->add(
                'descSituacao',
                'text',
                $fieldOptions['descSituacao']
            )
            ->end()
            ->with('label.bem.apolice')
            ->add(
                'assegurado',
                'checkbox',
                $fieldOptions['assegurado']
            )
            ->add(
                'apolicesCollection',
                'entity',
                $fieldOptions['apolicesCollection']
            )
            ->end();

        if (!$this->id($this->getSubject())) {
            $formMapper
                ->with('label.bem.lote')
                ->add(
                    'cbLote',
                    'checkbox',
                    array(
                        'label' => 'label.bem.cbLote',
                        'required' => false,
                        'mapped' => false
                    )
                )
                ->add(
                    'qtdLote',
                    'number',
                    array(
                        'label' => 'label.bem.qtdLote',
                        'required' => false,
                        'mapped' => false
                    )
                )
                ->end();
        }

        $formMapper
            ->end()
            ->tab('label.bem.reavaliacao')
            ->with('')
            ->add(
                'fkPatrimonioReavaliacoes',
                'sonata_type_collection',
                array(
                    'by_reference' => false,
                    'label' => false
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                )
            )
            ->end()
            ->end()
            ->tab('label.bem.depreciacao')
            ->with('')
            ->add(
                'contaContabilAcumulada',
                'autocomplete',
                $fieldOptions['contaContabilAcumulada']
            )
            ->add(
                'depreciavel',
                'checkbox',
                $fieldOptions['depreciavel']
            )
            ->add(
                'quotaDepreciacaoAnual',
                'number',
                [
                    'label' => 'label.bem.quota',
                    'required' => false,
                    'attr' => array(
                        'class' => 'money '
                    )
                ]
            )
            ->add(
                'contaContabil',
                'autocomplete',
                $fieldOptions['contaContabil']
            )
            ->add(
                'depreciacaoAcelerada',
                'checkbox',
                $fieldOptions['depreciacaoAcelerada']
            )
            ->add(
                'quotaDepreciacaoAnualAcelerada',
                'number',
                [
                    'label' => 'label.bem.quotaAcelerada',
                    'attr' => array(
                        'class' => 'money '
                    )
                ]
            )
            ->end()
            ->end();

        $processoModel = new SwProcessoModel($em);
        $assuntoModel = new Model\SwAssuntoModel($em);
        $organogramaModel = new OrganogramaModel($em);
        $admin = $this;
        //codAssunto
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $assuntoModel) {
                $form = $event->getForm();
                $data = $event->getData();

                if (isset($data['codAssunto']) && $data['codAssunto'] != "") {
                    $assuntos = $assuntoModel->findByCodClassificacao($data['codClassificacao']);

                    $dados = array();
                    foreach ($assuntos as $assunto) {
                        $choiceKey = (string) $assunto;
                        $choiceValue = $assuntoModel->getObjectIdentifier($assunto);

                        $dados[$choiceKey] = $choiceValue;
                    }

                    $comAssunto = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codAssunto', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.bem.codAssunto',
                            'mapped' => false,
                        ]);

                    $form->add($comAssunto);
                }
            }
        );
        //codProcesso
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $processoModel) {
                $form = $event->getForm();
                $data = $event->getData();

                if (strpos($data['codAssunto'], '~')) {
                    list($codAssunto, $codClassificacao) = explode('~', $data['codAssunto']);
                } else {
                    $codAssunto = $data['codAssunto'];
                    $codClassificacao = $data['codClassificacao'];
                }

                if (isset($data['codProcesso']) && $data['codProcesso'] != "") {
                    $processos = $processoModel->getProcessoByClassificacaoAndAssunto($codClassificacao, $codAssunto);

                    $dados = array();
                    foreach ($processos as $processo) {
                        $processoCompleto = $processo->cod_processo_completo;
                        $processoAssunto = " | " . $processo->nom_assunto;

                        $choiceKey = $processoCompleto . $processoAssunto;
                        $choiceValue = $processo->cod_processo.'~'.$processo->ano_exercicio;

                        $dados[$choiceKey] = $choiceValue;
                    }

                    $comProcesso = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codProcesso', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.bem.procAdministrativo',
                            'mapped' => false,
                        ]);

                    $form->add($comProcesso);
                }
            }
        );
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $organogramaModel) {
                $form = $event->getForm();
                $data = $event->getData();

                if (isset($data['secretarias']) && $data['secretarias'] != "") {
                    $orgao = $organogramaModel->consultaOrgao($data['codOrganograma'], $data['secretarias']);
                    $secretarias = $organogramaModel->listarOrgaosRelacionadosDescricaoComponente($data['codOrganograma'], self::NIVEL_DOIS, $orgao[0]['orgao']);

                    $dados = array();
                    foreach ($secretarias as $secretaria) {
                        $choiceValue = $secretaria['cod_orgao'];
                        $choiceKey = $secretaria['descricao'];
                        $dados[$choiceKey] = $choiceValue;
                    }

                    $comSecretaria = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('secretarias', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.bem.secretarias',
                            'mapped' => false,
                        ]);
                    unset($dados);
                    $form->add($comSecretaria);
                }
            }
        );
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $organogramaModel) {
                $form = $event->getForm();
                $data = $event->getData();

                if (isset($data['unidades']) && $data['unidades'] != "" && $data['unidades'] != 0) {
                    $orgao = $organogramaModel->consultaOrgao($data['codOrganograma'], $data['secretarias']);
                    $unidades = $organogramaModel->listarOrgaosRelacionadosDescricaoComponente(
                        $data['codOrganograma'],
                        self::NIVEL_TRES,
                        $orgao[0]['orgao']
                    );
                    $dados = array();
                    foreach ($unidades as $unidade) {
                        $choiceValue = $unidade['cod_orgao'];
                        $choiceKey = $unidade['descricao'];
                        $dados[$choiceKey] = $choiceValue;
                    }

                    $comUnidades = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('unidades', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.bem.unidades',
                            'mapped' => false,
                        ]);
                    $form->add($comUnidades);
                }
            }
        );
    }

    /**
     * @param ProxyQuery|QueryBuilder $queryBuilder
     * @param string $alias
     * @param string $field
     * @param array $data
     * @return bool
     */
    public function searchFilterEspecie(ProxyQuery $queryBuilder, $alias, $field, array $data)
    {
        /** @var Patrimonio\Especie $especie */
        $especie = $data['value'];

        if (!$especie) {
            return true ;
        }

        $rootAliases = $queryBuilder->getRootAliases();
        $queryBuilder
            ->andWhere("{$rootAliases[0]}.codEspecie = :codEspecie")
            ->setParameter('codEspecie', $especie->getCodEspecie());

        return true;
    }

    /**
     * @param ProxyQuery|QueryBuilder $queryBuilder
     * @param string $alias
     * @param string $field
     * @param array $data
     * @return bool
     */
    public function searchFilterGrupo(ProxyQuery $queryBuilder, $alias, $field, array $data)
    {
        /** @var Patrimonio\Grupo $grupo */
        $grupo = $data['value'];

        if (!$data['value']) {
            return true ;
        }

        $rootAliases = $queryBuilder->getRootAliases();
        $queryBuilder
            ->andWhere("{$rootAliases[0]}.codGrupo = :codGrupo")
            ->setParameter('codGrupo', $grupo->getCodGrupo());

        return true;
    }

    /**G
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codBem', null, ['label' => 'label.bem.codigo'])
            ->add('numPlaca', null, ['label' => 'label.bem.numPlaca'])
            ->add('descricao', null, ['label' => 'label.bem.descricao'])
            ->add(
                'fkPatrimonioEspecie.fkPatrimonioGrupo.fkPatrimonioNatureza',
                null,
                [
                    'label' => 'label.bem.natureza',
                ]
            )
            ->add(
                'fkPatrimonioEspecie.fkPatrimonioGrupo',
                'doctrine_orm_callback',
                [
                    'label' => 'label.bem.grupo',
                    'callback' => [$this, 'searchFilterGrupo'],
                ],
                'entity',
                [
                    'class' => Patrimonio\Grupo::class
                ]
            )
            ->add(
                'fkPatrimonioEspecie',
                'doctrine_orm_callback',
                [
                    'label' => 'label.bem.especie',
                    'callback' => [$this, 'searchFilterEspecie'],
                ],
                'entity',
                [
                    'class' => Patrimonio\Especie::class
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
            ->add('codBem', 'number', ['label' => 'label.bem.codigo'])
            ->add('numPlaca', null, ['label' => 'label.bem.numPlaca'])
            ->add('descricao', null, ['label' => 'label.bem.descricao'])
            ->add('fkPatrimonioEspecie.fkPatrimonioGrupo.fkPatrimonioNatureza', null, ['label' => 'label.bem.natureza'])
            ->add('fkPatrimonioEspecie.fkPatrimonioGrupo', null, ['label' => 'label.bem.grupo'])
            ->add('fkPatrimonioEspecie', null, ['label' => 'label.bem.especie'])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        // Classificação
        $fieldOptions['fkPatrimonioNatureza'] = [
            'label' => 'label.bem.natureza',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['fkPatrimonioGrupo'] = [
            'label' => 'label.bem.grupo',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['fkPatrimonioEspecie'] = [
            'label' => 'label.bem.especie',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];

        // Informações Básicas
        $fieldOptions['codClassificacao'] = [
            'label' => 'label.bem.codClassificacao',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['codAssunto'] = [
            'label' => 'label.bem.codAssunto',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['codProcesso'] = [
            'label' => 'label.bem.procAdministrativo',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['bemMarca'] = [
            'label' => 'label.bem.marca',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['fornecedor'] = [
            'label' => 'label.bem.fornecedor',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];

        // Atribuitos
        $fieldOptions['atResponsavel'] = [
            'label' => 'label.bem.atResponsavel',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];

        // Informações Financeiras
        $fieldOptions['exercicio'] = [
            'label' => 'label.bem.exercicio',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['entidade'] = [
            'label' => 'label.bem.entidade',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['orgaoOrg'] = [
            'label' => 'label.bem.orgaoOrg',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['unidade'] = [
            'label' => 'label.bem.unidade',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['numEmpenho'] = [
            'label' => 'label.bem.numEmpenho',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['numNotaFiscal'] = [
            'label' => 'label.bem.numNotaFiscal',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['dtNotaFiscal'] = [
            'label' => 'label.bem.dtNotaFiscal',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['arqNotaFiscal'] = [
            'label' => 'label.bem.arqNotaFiscal',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];

        // Depreciação Inicial / Última Reavaliação
        $fieldOptions['vlDepreciacaoAcumulada'] = [
            'label' => 'label.bem.vlDepreciacaoAcumulada',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['dtDepreciacao'] = [
            'label' => 'label.bem.dtDepreciacao',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['dtUltimaReavaliacao'] = [
            'label' => 'label.bem.dtUltimaReavaliacao',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['valorUltimaReavaliacao'] = [
            'label' => 'label.bem.valorUltimaReavaliacao',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];

        // Responsável
        $fieldOptions['responsavel'] = [
            'label' => 'label.bem.responsavelAtual',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['dtInicialResponsavel'] = [
            'label' => 'label.bem.dtInicialResponsavel',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];

        // Histórico
        $fieldOptions['localizacao'] = [
            'label' => 'label.bem.localizacao',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['local'] = [
            'label' => 'label.bem.localAtual',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];

        // Apolice
        $fieldOptions['apolice'] = [
            'label' => 'label.bem.apolice',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        /** @var Bem $bem */
        $bem = $this->getSubject();

        // Classificação
        $fieldOptions['fkPatrimonioNatureza']['data'] = $bem->getFkPatrimonioEspecie()
            ->getFkPatrimonioGrupo()->getFkPatrimonioNatureza();
        $fieldOptions['fkPatrimonioGrupo']['data'] = $bem->getFkPatrimonioEspecie()
            ->getFkPatrimonioGrupo();
        $fieldOptions['fkPatrimonioEspecie']['data'] = $bem->getFkPatrimonioEspecie();

        // Informações Básicas
        $bemProcesso = $bem->getFkPatrimonioBemProcesso();

        if ($bemProcesso) {
            $fieldOptions['codClassificacao']['data'] = $bemProcesso->getFkSwProcesso()
                ->getFkSwAssunto()->getFkSwClassificacao();
            $fieldOptions['codAssunto']['data'] = $bemProcesso->getFkSwProcesso()->getFkSwAssunto();
            $fieldOptions['codProcesso']['data'] = $bemProcesso->getFkSwProcesso();
        }

        $bemMarca = $bem->getFkPatrimonioBemMarca();
        if ($bemMarca) {
            $fieldOptions['bemMarca']['data'] = $bemMarca->getFkAlmoxarifadoMarca();
        }

        $swCgm = $bem->getFkSwCgm();
        if ($swCgm) {
            $fieldOptions['fornecedor']['data'] = $swCgm;
        }

        // Atribuitos
        $bemAtributoEspecie = $bem->getAtributoEspecie();
        if ($bemAtributoEspecie) {
            $fieldOptions['atResponsavel']['data'] = $bemAtributoEspecie->getValor();
        }

        // Informações Financeiras
        $bemComprado = $bem->getFkPatrimonioBemComprado();
        if ($bemComprado) {
            $fieldOptions['exercicio']['data'] = $bemComprado->getExercicio();
            $fieldOptions['entidade']['data'] = $bemComprado->getFkOrcamentoEntidade();
            if (!empty($bemComprado->getFkOrcamentoUnidade())) {
                $fieldOptions['orgaoOrg']['data'] = $bemComprado->getFkOrcamentoUnidade()->getFkOrcamentoOrgao();
                $fieldOptions['unidade']['data'] = $bemComprado->getFkOrcamentoUnidade();
            }
            $fieldOptions['numEmpenho']['data'] = $bemComprado->getCodEmpenho();
            $fieldOptions['numNotaFiscal']['data'] = $bemComprado->getNotaFiscal();
            if ($bemComprado->getDataNotaFiscal()) {
                $fieldOptions['dtNotaFiscal']['data'] = $bemComprado->getDataNotaFiscal()->format('d/m/Y');
            }

            $image = $bemComprado->getCaminhoNf();
            if (($image != "Caminho da foto") && ($image != null) && (trim($image) != '')) {
                $container = $this->getConfigurationPool()->getContainer();
                $servidorPath = $container->getParameter("patrimonialbundle");

                if (isset($servidorPath['bemDownload'])) {
                    $fullPath = $servidorPath['bemDownload'] . $image;

                    $fieldOptions['arqNotaFiscal']['data'] =
                        '<a class="uploader-link-download" href="' . $fullPath . '">Arquivo Nota Fiscal Atual</a>';
                } else {
                    $fieldOptions['arqNotaFiscal']['data'] = '-';
                }
            } else {
                $fieldOptions['arqNotaFiscal']['data'] = '-';
            }
        }

        //Depreciação Inicial / Última Reavaliação
        $Reavaliacao = $bem->getFkPatrimonioReavaliacoes()->last();
        if ($Reavaliacao) {
            $fieldOptions['vlDepreciacaoAcumulada']['data'] = '0,00';
            $fieldOptions['dtDepreciacao']['data'] = '';
            $fieldOptions['dtUltimaReavaliacao']['data'] = $Reavaliacao->getDtReavaliacao()->format('d/m/Y');
            $fieldOptions['valorUltimaReavaliacao']['data'] = $Reavaliacao->getVlReavaliacao();
        }

        //Responsável
        $BemResponsavel = $bem->getBemResponsavel();
        if ($BemResponsavel) {
            $fieldOptions['responsavel']['data'] = $BemResponsavel->getFkSwCgm();
            $fieldOptions['dtInicialResponsavel']['data'] = $BemResponsavel->getDtInicio()->format('d/m/Y');
        }

        // Histórico
        $bemModel = new BemModel($em);
        $HistoricoBem = $bemModel->getHistoricoBem($bem);
        $HistoricoBem = end($HistoricoBem);
        if ($HistoricoBem) {
            $fieldOptions['localizacao']['data'] = '';
            $fieldOptions['local']['data'] = $HistoricoBem->getFkOrganogramaLocal();
        }

        // Apolice
        $HistoricoBem = $bem->getApoliceBem();
        if ($HistoricoBem) {
            $fieldOptions['apolice']['data'] = $HistoricoBem->getFkPatrimonioApolice();
        }

        $showMapper
            ->with('label.bem.dadosbem')
            ->add(
                'codBem',
                'number',
                [
                    'label' => 'label.bem.codigo'
                ]
            )
            ->end()
            ->with('label.bem.classificacao')
            ->add(
                'fkPatrimonioNatureza',
                'text',
                $fieldOptions['fkPatrimonioNatureza']
            )
            ->add(
                'fkPatrimonioGrupo',
                'text',
                $fieldOptions['fkPatrimonioGrupo']
            )
            ->add(
                'fkPatrimonioEspecie',
                'text',
                $fieldOptions['fkPatrimonioEspecie']
            )
            ->end()
            ->with('label.bem.infoBasica')
            ->add(
                'descricao',
                'text',
                [
                    'label' => 'label.bem.descricao'
                ]
            )
            ->add(
                'codClassificacao',
                'text',
                $fieldOptions['codClassificacao']
            )
            ->add(
                'codAssunto',
                'text',
                $fieldOptions['codAssunto']
            )
            ->add(
                'codProcesso',
                'text',
                $fieldOptions['codProcesso']
            )
            ->add(
                'detalhamento',
                'text',
                [
                    'label' => 'label.bem.detalhamento'
                ]
            )
            ->add(
                'bemMarca',
                'text',
                $fieldOptions['bemMarca']
            )
            ->add(
                'fornecedor',
                'text',
                $fieldOptions['fornecedor']
            )
            ->add(
                'vlBem',
                'number',
                [
                    'label' => 'label.bem.vlBem',
                ]
            )
            ->add(
                'dtAquisicao',
                'date',
                [
                    'label' => 'label.bem.dtAquisicao',
                ]
            )
            ->add(
                'dtGarantia',
                'date',
                [
                    'label' => 'label.bem.dtGarantia',
                ]
            )
            ->add(
                'identificacao',
                'boolean',
                [
                    'label' => 'label.bem.identificacao'
                ]
            )
            ->add(
                'numPlaca',
                'text',
                [
                    'label' => 'label.bem.numPlaca'
                ]
            )
            ->end()
            ->with('label.bem.atributo')
            ->add(
                'atResponsavel',
                'text',
                $fieldOptions['atResponsavel']
            )
            ->end()
            ->with('label.bem.infoFinanceira')
            ->add(
                'exercicio',
                'number',
                $fieldOptions['exercicio']
            )
            ->add(
                'entidade',
                'text',
                $fieldOptions['entidade']
            )
            ->add(
                'orgaoOrg',
                'text',
                $fieldOptions['orgaoOrg']
            )
            ->add(
                'unidade',
                'text',
                $fieldOptions['unidade']
            )
            ->add(
                'vidaUtil',
                'number',
                [
                    'label' => 'label.bem.vidaUtil'
                ]
            )
            ->add(
                'dtIncorporacao',
                'date',
                [
                    'label' => 'label.bem.dtIncorporacao'
                ]
            )
            ->add(
                'numEmpenho',
                'date',
                $fieldOptions['numEmpenho']
            )
            ->add(
                'numNotaFiscal',
                'date',
                $fieldOptions['numNotaFiscal']
            )
            ->add(
                'dtNotaFiscal',
                'date',
                $fieldOptions['dtNotaFiscal']
            )
            ->add(
                'arqNotaFiscal',
                'text',
                $fieldOptions['arqNotaFiscal']
            )
            ->end()
            ->with('label.bem.depreciacaoReavaliacao')
            ->add(
                'vlDepreciacao',
                'number',
                [
                    'label' => 'label.bem.depreInicial',
                ]
            )
            ->add(
                'vlDepreciacaoAcumulada',
                'number',
                $fieldOptions['vlDepreciacaoAcumulada']
            )
            ->add(
                'dtDepreciacao',
                'date',
                $fieldOptions['dtDepreciacao']
            )
            ->add(
                'dtUltimaReavaliacao',
                'date',
                $fieldOptions['dtUltimaReavaliacao']
            )
            ->add(
                'valorUltimaReavaliacao',
                'number',
                $fieldOptions['valorUltimaReavaliacao']
            )
            ->end()
            ->with('label.bem.responsavel')
            ->add(
                'responsavel',
                'text',
                $fieldOptions['responsavel']
            )
            ->add(
                'dtInicialResponsavel',
                'date',
                $fieldOptions['dtInicialResponsavel']
            )
            ->end()
            ->with('label.bem.historico')
            ->add(
                'localizacao',
                'text',
                $fieldOptions['localizacao']
            )
            ->add(
                'local',
                'text',
                $fieldOptions['local']
            )
            ->end()
            ->with('label.bem.apolice')
            ->add(
                'apolice',
                'text',
                $fieldOptions['apolice']
            )
            ->end()
            ->end();
    }
    

    /**
     * @param ErrorElement $errorElement
     * @param Bem $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager('CoreBundle:Empenho\Empenho');
        if (!empty($this->getForm()->get('exercicio')->getData())
            && !empty($this->getForm()->get('entidade')->getData())
            && !empty($this->getForm()->get('numEmpenho')->getData())) {
            $empenhoModel = new Model\Empenho\EmpenhoModel($em);

            $empenho = $empenhoModel
                ->getEmpenho(
                    [
                        'codEmpenho'    => $this->getForm()->get('numEmpenho')->getData(),
                        'exercicio'     => $this->getForm()->get('exercicio')->getData(),
                        'codEntidade'   => $this->getForm()->get('entidade')->getData()->getCodEntidade()
                    ]
                );

            if (empty($empenho)) {
                $message = $this->trans('manutencao.errors.empenho', [], 'validators');

                $errorElement->with('numEmpenho')->addViolation($message)->end();
                $errorElement->with('exercicio')->addViolation($message)->end();
                $errorElement->with('entidade')->addViolation($message)->end();
            }
        }

        if (!empty($this->getForm()->get('identificacao')->getData())
            && !empty($this->getForm()->get('numPlaca')->getData())) {
            $uow = $em->getUnitOfWork();
            $originalEntityData = $uow->getOriginalEntityData($object);
            $placaBefore = (isset($originalEntityData['numPlaca']) ? $originalEntityData['numPlaca'] : '');
            $placaAfter = $object->getNumPlaca();
            if ($placaAfter != $placaBefore) {
                $bemModel = new BemModel($em);
                if (!$bemModel->checkNumPlacaIsAvailable($this->getForm()->get('numPlaca')->getData())) {
                    $message = $this->trans('bem.errors.numPlacaNotAvailable', [], 'validators');

                    $errorElement->with('numPlaca')->addViolation($message)->end();
                }
            }
        }

        if (true === $this->getForm()->get('assegurado')->getData()) {
            if (null === $this->getForm()->get('apolicesCollection')->getData()) {
                $message = $this->trans('bem.errors.apoliceRequired', [], 'validators');
                $errorElement->with('apolicesCollection')->addViolation($message)->end();
            }
        }
    }

    /**
     * @param Bem $bem
     * @param Form $form
     * @param Request $request
     */
    public function saveRelationships($bem, $form, $request)
    {
        $exercicio = $this->getExercicio();
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $bemModel = new BemModel($em);

        // Salva Reavaliacao
        $bemModel->saveReavaliacao($bem, $this->fkPatrimonioReavaliacao);

        // Salva ApoliceBem
        $bemModel->saveApoliceBem($bem, $form);

        // Salva BemProcesso
        $bemModel->saveBemProcesso($bem, $form);

        // Salva BemPlanoDepreciacao
        $bemModel->saveBemPlanoDepreciacao($bem, $form, $exercicio);

        // Salva BemPlanoAnalitica
        $bemModel->saveBemPlanoAnalitica($bem, $form, $exercicio);

        // Salva HistoricoBem
        $orgaoNivel = $this->getOrgaoSelected();
        $bemModel->saveHistoricoBem($bem, $form, $orgaoNivel);

        // Salva BemResponsavel
        $bemModel->saveBemResponsavel($bem, $form);

        // Salva BemMarca
        $bemModel->saveBemMarca($bem, $form);

        // Salva BemAtributoEspecie
        $atributosDinamicos = $request->request->get('atributoDinamico');
        $bemModel->saveBemAtributoEspecie($bem, $atributosDinamicos);

        //Salva BemComprado (File Upload)
        $container = $this->getConfigurationPool()->getContainer();
        $bemModel->saveBemComprado($bem, $form, $container);

        $bemModel->save($bem);
    }

    /**
     * @param Bem $bem
     */
    public function prePersist($bem)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $especie = $em->getRepository(Patrimonio\Especie::class)->findOneBy([
            'codEspecie' => $formData['codEspecie'],
            'codGrupo' => $formData['codGrupo'],
            'codNatureza' => $formData['codNatureza']
        ]);

        $this->checkSelectedDeleteInListCollecion(
            $bem,
            'fkPatrimonioReavaliacoes',
            'setFkPatrimonioBem'
        );
        /** @var Patrimonio\Reavaliacao $reavaliacoe */
        foreach ($bem->getFkPatrimonioReavaliacoes() as $reavaliacoe) {
            $reavaliacoe->setFkPatrimonioBem($bem);
        }

        $bem->setFkPatrimonioEspecie($especie);
        $this->bemVirgem = clone($bem);
        $this->createFkPatrimonioReavaliacao($bem);
    }

    /**
     * @param Bem $bem
     */
    public function postPersist($bem)
    {
        //TODO: Validar novamente
        $container = $this->getConfigurationPool()->getContainer();

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $bemModel = new BemModel($em);
        $form = $this->getForm();
        $request = $this->request;

        try {
            if ($this->getForm()->get('cbLote')->getData()) {
                $this->saveRelationships($bem, $form, $request);
                for ($i = 1; $i < ($this->getForm()->get('qtdLote')->getData()); $i++) {
                    $objClonado = clone $this->bemVirgem;

                    $objClonado->setNumPlaca((int) $objClonado->getNumPlaca() + $i);
                    $objClonado->setCodBem($objClonado->getCodBem() + $i);

                    $bemModel->save($bem);

                    $this->saveRelationships($objClonado, $form, $request);
                }
                $this->getFlashBag()->add(
                    'success',
                    $this->trans(
                        'label.bem.loteCriado',
                        [
                            '%cod_ben%' => $bem->getCodBem(),
                            '%acod_ben%' => $bem->getCodBem() + $i,
                        ]
                    )
                );
            } else {
                $this->saveRelationships($bem, $form, $request);
            }
        } catch (\Exception $e) {
            if (empty($this->getForm()->get('qtdLote')->getData())) {
                $em->remove($bem);
                $em->flush();
            }
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/patrimonial/patrimonio/bem/create");
        }
    }

    /**
     * @param Bem $bem
     * @throws \Exception
     */
    public function preUpdate($bem)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $form = $this->getForm();
        $request = $this->request;
        try {
            $bem->setFkPatrimonioEspecie($this->getForm()->get('codEspecie')->getData());

            $id = $this->getAdminRequestId();
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            $this->checkSelectedDeleteInListCollecion(
                $bem,
                'fkPatrimonioReavaliacoes',
                'setFkPatrimonioBem'
            );
            /** @var Patrimonio\Reavaliacao $reavaliacoe */
            foreach ($bem->getFkPatrimonioReavaliacoes() as $reavaliacoe) {
                $reavaliacoe->setFkPatrimonioBem($bem);
            }

            $especie = $em->getRepository(Patrimonio\Especie::class)->findOneBy([
                'codEspecie' => $this->getForm()->get('codEspecie')->getData()->getCodEspecie(),
                'codGrupo' => $this->getForm()->get('codGrupo')->getData()->getCodGrupo(),
                'codNatureza' => $this->getForm()->get('codNatureza')->getData()->getCodNatureza()
            ]);
            if (!empty($especie)) {
                $bem->setFkPatrimonioEspecie($especie);
            } else {
                $formData = $this->getRequest()->request->get($this->getUniqid());
                $especie = $em->getRepository(Patrimonio\Especie::class)->findOneBy([
                    'codEspecie' => $formData['codEspecie'],
                    'codGrupo' => $formData['codGrupo'],
                    'codNatureza' => $formData['codNatureza']
                ]);
                $bem->setFkPatrimonioEspecie($especie);
            }

            //Remove Apolices
            $em->getRepository($this->getClass())->removeApoliceBem($id);

            // Remove BemMarca
            if (!empty($bem->getFkPatrimonioBemMarca())) {
                $em->remove($bem->getFkPatrimonioBemMarca());
            }

            // Remove BemComprado
            if (!empty($bem->getFkPatrimonioBemComprado()) && !empty($bem->getFkPatrimonioBemCompradoEmpenho())) {
                $em->remove($bem->getFkPatrimonioBemCompradoEmpenho());
                $em->remove($bem->getFkPatrimonioBemComprado());
            }

            // Remove BemProcesso
            if (!empty($bem->getFkPatrimonioBemProcesso())) {
                $em->remove($bem->getFkPatrimonioBemProcesso());
            }

            $this->createFkPatrimonioReavaliacao($bem);

            $em->flush();

            $this->saveRelationships($bem, $form, $request);
        } catch (\Exception $e) {
            throw $e;
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_EDIT_DATA);
            $this->forceRedirect("/patrimonial/patrimonio/bem/{$this->getObjectKey($bem)}/edit");
        }
    }
}
