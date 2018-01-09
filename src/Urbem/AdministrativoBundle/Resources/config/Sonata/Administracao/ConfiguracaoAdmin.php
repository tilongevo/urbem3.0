<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoConta;
use Urbem\CoreBundle\Entity\Monetario\Convenio;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Entity\Orcamento\ContaReceita;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\PosicaoDespesa;
use Urbem\CoreBundle\Entity\Orcamento\PosicaoReceita;
use Urbem\CoreBundle\Entity\Orcamento\TipoContaReceita;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\Tesouraria\Assinatura;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Helper\MascaraHelper;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Model;
use Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento\ContaReceitaAdmin;
use Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento\ContaReceitaDedutoraAdmin;

class ConfiguracaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_administracao_configuracao';

    protected $baseRoutePattern = 'administrativo/administracao/configuracao';

    protected $exibirBotaoIncluir = false;

    protected $urlReferer = false;

    protected $customBodyTemplate = '';

    protected $includeJs = [
        '/financeiro/javascripts/contabilidade/configuracao/configuracao.js',
        '/financeiro/javascripts/tesouraria/configuracao/configuracao.js'
    ];

    protected $dataCustom;

    const ARRECADACAO_CONFIGURACAO_TIPO = 'credito';

    /**
     * @return mixed
     */
    public function getDataCustom()
    {
        return $this->dataCustom;
    }

    /**
     * @param mixed $dataCustom
     */
    public function setDataCustom($dataCustom)
    {
        $this->dataCustom = $dataCustom;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('adiciona', '/{id}/create', array('_controller' => 'RecursosHumanosBundle:Pessoal/Servidor:perfil'), array('id' => $this->getRouterIdParameter()));
        $collection->remove('edit');
        $collection->remove('show');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('parametro')
            ->add('valor');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('exercicio')
            ->add('parametro')
            ->add('valor');
        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();

        if ($this->getRequest()->isMethod('GET')) {
            $id = $this->getRequest()->get('id', false);

            if (!is_numeric($id)) {
                $container->get('session')->getFlashBag()->add('error', 'Não existe configuração cadastrada para o modulo passado');
                $this->forceRedirect('/erro-configuracao');
                return false;
            }
        } else {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $id = $formData['cod_modulo'];
        }

        $this->setUrlReferer($this->request->headers->get('referer'));

        $info = array(
            'cod_modulo' => $id,
            'exercicio' => $this->getExercicio(),
        );


        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Configuracao');
        $configuracaoModel = new ConfiguracaoModel($em);
        $atributos = $configuracaoModel->getAtributosDinamicosPorModuloeExercicio($info);

        if (count($atributos) == 0) {
            $container->get('session')->getFlashBag()->add('error', 'Não existe configuração cadastrada');
            $this->forceRedirect('/erro-configuracao');
            return false;
        }

        $this->montaHtml($id, $atributos, $formMapper);
    }

    /**
     * @param $cod_modulo
     * @param $atributos
     * @param $formMapper
     * @return mixed|string
     */
    public function montaHtml($cod_modulo, $atributos, $formMapper)
    {
        $html = "";
        switch ($cod_modulo) {
            case 2:
                $html = $this->montaHtmlAdministracaoSistema($cod_modulo, $formMapper);
                break;
            case ConfiguracaoModel::MODULO_PROTOCOLO:
                $html = $this->montaHtmlAdministrativoConfiguracaoProtocolo($cod_modulo, $formMapper, $atributos);
                break;
            case ConfiguracaoModel::MODULO_PATRIMONAL_PATRIMONIO:
                $html = $this->montaHtmlPatrimonialConfiguracaoPatrimonio($cod_modulo, $formMapper, $atributos);
                break;
            case 8:
                $html = $this->montaHtmlFinanceiroOrcamentoConfiguracao($cod_modulo, $formMapper);
                break;
            case 9:
                $html = $this->montaHtmlFinanceiroContabilidadeConfiguracao($cod_modulo, $formMapper);
                break;
            case ConfiguracaoModel::MODULO_FINANCEIRO_EMPENHO:
                $html = $this->montaHtmlFinanceiroEmpenhoConfiguracao($cod_modulo, $formMapper);
                break;
            case ConfiguracaoModel::MODULO_TRIBUTARIO_ECONOMICO:
                $html = $this->montaHtmlTributarioEconomicoConfiguracao($cod_modulo, $formMapper);
                break;
            case ConfiguracaoModel::MODULO_RH_PESSOAL:
                $html = $this->montaHtmlRHConfiguracaoPessoal($cod_modulo, $formMapper, $atributos);
                break;
            case ConfiguracaoModel::MODULO_TRIBUTARIO_ARRECADACAO:
                $formData = $this->getRequest()->request->get($this->getUniqid());
                $tipo = $formData['tipo_arrecadacao_configuracao'];
                if ($this->getRequest()->query->get('tipo') == self::ARRECADACAO_CONFIGURACAO_TIPO || $tipo == self::ARRECADACAO_CONFIGURACAO_TIPO) {
                    $html = $this->montaHtmlTributarioArrecadacaoConfiguracaoGrupoCreditos($cod_modulo, $formMapper);
                } else {
                    $html = $this->montaHtmlTributarioArrecadacaoConfiguracao($cod_modulo, $formMapper);
                }
                break;
            case ConfiguracaoModel::MODULO_TRIBUTARIO_DIVIDA_ATIVA:
                $tipo = $this->getRequest()->query->get('tipo');
                if (empty($tipo)) {
                    $formData = $this->getRequest()->request->get($this->getUniqid());
                    $tipo = $formData['tipo'];
                }
                switch ($tipo) {
                    case ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_LIVRO:
                        $html = $this->montaHtmlDividaAtivaConfigurarLivro($cod_modulo, $formMapper);
                        break;
                    case ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO:
                        $html = $this->montaHtmlDividaAtivaConfigurarInscricao($cod_modulo, $formMapper);
                        break;
                    case ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA:
                        $html = $this->montaHtmlDividaAtivaConfigurarRemissaoAutomatica($cod_modulo, $formMapper);
                        break;
                    case ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS:
                        $html = $this->montaHtmlDividaAtivaConfigurarDocumentos($cod_modulo, $formMapper);
                        break;
                }
                break;
            case 29:
                $html = $this->montaHtmlPatrimonialConfiguracaoAlmoxarifado($cod_modulo, $formMapper, $atributos);
                break;
            case 30:
                $html = $this->montaHtmlFinanceiroTesourariaConfiguracao($cod_modulo, $formMapper);
                break;
            case ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS:
                $html = $this->montaHtmlPatrimonialConfiguracaoCompras($cod_modulo, $formMapper, $atributos);
                break;
            case 43:
                $html = $this->montaHtmlFinanceiroPpaConfiguracao($cod_modulo, $formMapper);
                break;
            default:
        }

        return $html;
    }


    public function montaHtmlPatrimonialConfiguracaoCompras($cod_modulo, $formMapper, $atributos)
    {
        $this->setBreadCrumb($cod_modulo ? ['id' => $cod_modulo] : [], 'urbem_patrimonial_compras_configuracao');
        $formMapper->with('Parâmetros do Módulo Patrimônio');
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Configuracao');
        $configuracaoModel = new ConfiguracaoModel($em);
        $exercicio = $this->getExercicio();
        $entidades = $configuracaoModel->getEntidades($exercicio);

        $atributosNegados = ['data_fixa', 'data_fixa_empenho', 'data_fixa_liquidacao'];

        foreach ($atributos as $key => $atributo) {
            if ($atributo['parametro'] == 'homologacao_automatica') {
                $formMapper->add(
                    "atributo_" . $atributo['parametro'],
                    'text',
                    [
                        'label' => 'Efetuar Homologação de Solicitação Automática',
                        'mapped' => false,
                        'data' => ($atributo['valor'] == true) ? 'Sim' : 'Não',
                        'required' => false,
                        'attr' => [
                            'readonly' => true,
                        ]
                    ]
                );
            } elseif ($atributo['parametro'] == 'dotacao_obrigatoria_solicitacao') {
                $formMapper->add(
                    "atributo_" . $atributo['parametro'],
                    'text',
                    [
                        'label' => 'Exige Dotação na Solicitação/Mapa',
                        'mapped' => false,
                        'data' => ($atributo['valor'] == true) ? 'Sim' : 'Não',
                        'required' => false,
                        'attr' => [
                            'readonly' => true,
                        ]
                    ]
                );
            } elseif ($atributo['parametro'] == 'numeracao_licitacao') {
                $aSolicitacao = array();
                if ($atributo['valor']) {
                    $aSolicitacao[0] = (strpos($atributo['valor'], 'entidade') !== false) ? 'entidade' : '';
                    $aSolicitacao[1] = (strpos($atributo['valor'], 'modalidade') !== false) ? 'modalidade' : '';
                }

                $formMapper->add(
                    "atributo_" . $atributo['parametro'],
                    'choice',
                    [
                        'choices' => [
                            'Por Entidade' => 'entidade',
                            'Por Modalidade' => 'modalidade'
                        ],
                        'expanded' => true,
                        'multiple' => true,
                        'label' => 'Numeração da Licitação',
                        'mapped' => false,
                        'required' => true,
                        'data' => $aSolicitacao,
                        'label_attr' => [
                            'class' => 'checkbox-sonata'
                        ],
                        'attr' => [
                            'class' => 'checkbox-sonata'
                        ]
                    ]
                );
            } elseif ($atributo['parametro'] == 'atributo_tipo_valor_referencia') {
                $formMapper->add(
                    "atributo_" . $atributo['parametro'],
                    'choice',
                    [
                        'choices' => [
                            'Por Entidade' => 'entidade',
                            'Por Modalidade' => 'modalidade'
                        ],
                        'expanded' => true,
                        'multiple' => true,
                        'label' => 'label.administracao.atributo_' . $atributo['parametro'],
                        'mapped' => false,
                        'required' => true,
                        'data' => $atributo['valor'],
                        'label_attr' => [
                            'class' => 'checkbox-sonata'
                        ],
                        'attr' => [
                            'class' => 'checkbox-sonata'
                        ]
                    ]
                );
            } elseif (!in_array($atributo['parametro'], $atributosNegados)) {
                $formMapper->add(
                    "atributo_" . $atributo['parametro'],
                    'choice',
                    [
                        'choices' => [
                            'label.administracao.sim' => 'true',
                            'label.administracao.nao' => 'false'
                        ],
                        'expanded' => true,
                        'multiple' => false,
                        'label' => 'label.administracao.atributo_' . $atributo['parametro'],
                        'mapped' => false,
                        'required' => true,
                        'data' => $atributo['valor'],
                        'label_attr' => [
                            'class' => 'checkbox-sonata'
                        ],
                        'attr' => [
                            'class' => 'checkbox-sonata'
                        ]
                    ]
                )
                    ->add(
                        "cod_modulo",
                        'hidden',
                        [
                            'mapped' => false,
                            'data' => $cod_modulo,
                        ]
                    );
            }
        }
        $formMapper->end();


        foreach ($entidades as $entidade) {
            $formMapper
                ->with($entidade['nom_cgm'])
                ->add(
                    "entidade__" . $entidade['cod_entidade'],
                    'text',
                    [
                        'label' => 'Entidade',
                        'mapped' => false,
                        'data' => $entidade['cod_entidade'] . ' - ' . $entidade['nom_cgm'],
                        'required' => false,
                        'attr' => [
                            'readonly' => true,
                        ]
                    ]
                );

            $info['exercicio'] = $exercicio;
            $info['cod_modulo'] = $cod_modulo;
            $info['campo'] = 'data_fixa_solicitacao_compra';
            $info['cod_entidade'] = $entidade['cod_entidade'];
            $entidadeValor = $configuracaoModel->selectAtributosDinamicosEntidade($info);

            $data = ($entidadeValor['valor']) ? explode("/", $entidadeValor['valor']) : '';
            $dataValor = ($entidadeValor['valor']) ? new \DateTime($data[2] . "-" . $data[1] . "-" . $data[0]) : new \DateTime();

            $formMapper->add(
                "entidade_data_fixa_solicitacao__" . $entidade['cod_entidade'],
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'Data Fixa para Solicitação',
                    'mapped' => false,
                    'required' => false,
                    'data' => $dataValor,
                ]
            );

            $infoc['exercicio'] = $exercicio;
            $infoc['cod_modulo'] = $cod_modulo;
            $infoc['campo'] = 'data_fixa_compra';
            $infoc['cod_entidade'] = $entidade['cod_entidade'];
            $entidadeValor = $configuracaoModel->selectAtributosDinamicosEntidade($infoc);

            $data = ($entidadeValor['valor']) ? explode("/", $entidadeValor['valor']) : '';
            $dataValor = ($entidadeValor['valor']) ? new \DateTime($data[2] . "-" . $data[1] . "-" . $data[0]) : new \DateTime();

            $formMapper->add(
                "entidade_data_fixa_compra__" . $entidade['cod_entidade'],
                'sonata_type_date_picker',
                [
                    'label' => 'Data Fixa para Compra Direta',
                    'mapped' => false,
                    'required' => false,
                    'data' => $dataValor,
                ]
            )->end();
        }


        return $formMapper;
    }

    public function montaHtmlPatrimonialConfiguracaoPatrimonio($cod_modulo, $formMapper, $atributos)
    {
        $this->urlReferer = '/patrimonial';
        $this->setBreadCrumb($cod_modulo ? ['id' => $cod_modulo] : [], 'urbem_patrimonial_patrimonio_configuracao');

        $info['padrao'] = [
            'cod_modulo' => $cod_modulo,
            'exercicio' => $this->getExercicio(),
        ];
        $info['alterar_bens_exercicio_anterior'] = $info['padrao'];
        $info['alterar_bens_exercicio_anterior']['parametro'] = 'alterar_bens_exercicio_anterior';

        $info['grupo_contas_permanente'] = $info['padrao'];
        $info['grupo_contas_permanente']['parametro'] = 'grupo_contas_permanente';

        $info['placa_alfanumerica'] = $info['padrao'];
        $info['placa_alfanumerica']['parametro'] = 'placa_alfanumerica';

        $info['texto_ficha_transferencia'] = $info['padrao'];
        $info['texto_ficha_transferencia']['parametro'] = 'texto_ficha_transferencia';

        $info['coletora_digitos_local'] = $info['padrao'];
        $info['coletora_digitos_local']['parametro'] = 'coletora_digitos_local';

        $info['coletora_digitos_placa'] = $info['padrao'];
        $info['coletora_digitos_placa']['parametro'] = 'coletora_digitos_placa';

        $info['coletora_separador'] = $info['padrao'];
        $info['coletora_separador']['parametro'] = 'coletora_separador';

        $info['valor_minimo_depreciacao'] = $info['padrao'];
        $info['valor_minimo_depreciacao']['parametro'] = 'valor_minimo_depreciacao';

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Configuracao');
        $configuracaoModel = new ConfiguracaoModel($em);

        $alterarBensExercicioAnterior = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['alterar_bens_exercicio_anterior']);
        $grupoContasPermanente = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['grupo_contas_permanente']);
        $placaAlfanumerica = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['placa_alfanumerica']);
        $textoFichaTransferencia = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['texto_ficha_transferencia']);
        $coletoraDigitosPlaca = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['coletora_digitos_placa']);
        $coletoraDigitosLocal = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['coletora_digitos_local']);
        $coletoraSeparador = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['coletora_separador']);
        $valorMinimoDepreciacao = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['valor_minimo_depreciacao']);

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Contabilidade\PlanoConta');

        $planoContas = $em->getRepository(PlanoConta::class)->findOneBy(
            [
                'codEstrutural' => $grupoContasPermanente
            ]
        );

        $fieldOptions['contaContabilAcumulada'] = [
            'label' => 'label.administracao.conta_ativo_imobilizado',
            'class' => PlanoConta::class,
            'route' => ['name' => 'monta_recupera_plano_analitica_sintetica'],
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'Selecione',
            'mapped' => false,
            'data' => $planoContas
        ];

        $fieldOptions['texto_ficha_transferencia'] = [
            'label' => 'label.administracao.texto_ficha_transferencia',
            'mapped' => false,
            'data' => $textoFichaTransferencia['valor']
        ];

        $fieldOptions['coletora_digitos_placa'] = [
            'label' => 'label.administracao.coletora_digitos_placa',
            'mapped' => false,
            'data' => $coletoraDigitosPlaca['valor']
        ];

        $fieldOptions['coletora_digitos_local'] = [
            'label' => 'label.administracao.coletora_digitos_local',
            'mapped' => false,
            'data' => $coletoraDigitosLocal['valor']
        ];

        $fieldOptions['coletora_separador'] = [
            'label' => 'label.administracao.coletora_separador',
            'mapped' => false,
            'data' => $coletoraSeparador['valor']
        ];
        $fieldOptions['valor_minimo_depreciacao'] = [
            'label' => 'label.administracao.valor_minimo_depreciacao',
            'mapped' => false,
            'data' => str_replace(".", ",", $valorMinimoDepreciacao['valor']),
            'attr' => [
                'class' => 'money ',
                'maxlength' => 11
            ]
        ];

        $formMapper->with('Parâmetros do Módulo Patrimônio');
        $formMapper->add("texto_ficha_transferencia", 'textarea', $fieldOptions['texto_ficha_transferencia']);
        $formMapper->add('alterar_bens_exercicio_anterior', 'choice', [
            'choices' => [
                'label.administracao.sim' => 'true',
                'label.administracao.nao' => 'false'
            ],
            'expanded' => true,
            'multiple' => false,
            'label' => 'label.administracao.alterar_bens_exercicio_anterior',
            'mapped' => false,
            'required' => true,
            'data' => $alterarBensExercicioAnterior['valor'],
            'attr' => [
                'class' => 'checkbox-sonata '
            ],
            'label_attr' => [
                'class' => 'checkbox-sonata '
            ]
        ]);
        $formMapper->add('placa_alfanumerica', 'choice', [
            'choices' => [
                'label.administracao.sim' => 'true',
                'label.administracao.nao' => 'false'
            ],
            'expanded' => true,
            'multiple' => false,
            'label' => 'label.administracao.placa_alfanumerica',
            'mapped' => false,
            'required' => true,
            'data' => $placaAlfanumerica['valor'],
            'attr' => [
                'class' => 'checkbox-sonata '
            ],
            'label_attr' => [
                'class' => 'checkbox-sonata '
            ]
        ]);
        $formMapper->add("grupo_contas_permanente", 'autocomplete', $fieldOptions['contaContabilAcumulada']);
        $formMapper->add("valor_minimo_depreciacao", 'text', $fieldOptions['valor_minimo_depreciacao']);
        $formMapper->end();
        $formMapper->with('Configuração da Coletora de Dados');
        $formMapper->add("coletora_digitos_placa", 'text', $fieldOptions['coletora_digitos_placa']);
        $formMapper->add("coletora_digitos_local", 'text', $fieldOptions['coletora_digitos_local']);
        $formMapper->add("coletora_separador", 'text', $fieldOptions['coletora_separador']);
        $formMapper->add("cod_modulo", "hidden", ['mapped' => false, 'data' => $cod_modulo]);
        $formMapper->end();
        return $formMapper;
    }

    public function montaHtmlRHConfiguracaoPessoal($cod_modulo, $formMapper, $atributos)
    {
        $this->setBreadCrumb($cod_modulo ? ['id' => $cod_modulo] : [], 'urbem_rh_pessoal_configuracao');
        // Ordena dados de acordo com formulário antigo
        $orderElements = ["mascara_registro", "geracao_registro", "mascara_cbo", "dtContagemInicial"];
        $atributos = $this->orderByElementsDynamicFields($atributos, $orderElements, 'parametro', true);

        $formMapper->with('Pessoal - Configuração - Alterar Configuração');
        foreach ($atributos as $key => $atributo) {
            if ($atributo['parametro'] == 'dtContagemInicial') {
                $formMapper->add(
                    "atributo_" . $atributo['parametro'],
                    'choice',
                    [
                        'choices' => [
                            'label.administracao.dataposse' => 'dtPosse',
                            'label.administracao.datanomeacao' => 'dtNomeacao',
                            'label.administracao.dataadmissao' => 'dtAdmissao'
                        ],
                        'expanded' => false,
                        'multiple' => false,
                        'label' => 'label.administracao.dtContagemInicia',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                        'mapped' => false,
                        'required' => true,
                        'data' => $atributo['valor']
                    ]
                );
            } elseif ($atributo['parametro'] == 'geracao_registro') {
                $formMapper->add(
                    "atributo_" . $atributo['parametro'],
                    'choice',
                    [
                        'choices' => [
                            'label.administracao.automatica' => 'A',
                            'label.administracao.manual' => 'M'
                        ],
                        'expanded' => false,
                        'multiple' => false,
                        'label' => 'label.administracao.geracao_registro',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                        'mapped' => false,
                        'required' => true,
                        'data' => $atributo['valor']
                    ]
                );
            } elseif ($atributo['parametro'] == 'mascara_registro') {
                $formMapper->add(
                    "atributo_" . $atributo['parametro'],
                    'text',
                    [
                        'mapped' => false,
                        'label' => 'label.administracao.' . $atributo['parametro'],
                        'data' => isset($atributo['valor']) ? $atributo['valor'] : null,
                        'required' => true,
                        'attr' => [
                            'class' => 'numeric ',
                        ],
                    ]
                );
            } elseif ($atributo['parametro'] == 'mascara_cbo') {
                $formMapper->add(
                    "atributo_" . $atributo['parametro'],
                    'text',
                    [
                        'mapped' => false,
                        'label' => 'label.administracao.' . $atributo['parametro'],
                        'data' => isset($atributo['valor']) ? $atributo['valor'] : null,
                        'required' => true,
                        'attr' => [
                            'class' => 'numeric ',
                        ],
                    ]
                );
            }
        }
        // Módulo
        $formMapper->add(
            "cod_modulo",
            'hidden',
            array(
                'mapped' => false,
                'data' => $cod_modulo,
            )
        );

        $formMapper->end();
        return $formMapper;
    }

    public function montaHtmlPatrimonialConfiguracaoAlmoxarifado($cod_modulo, $formMapper, $atributos)
    {
        $this->setBreadCrumb($cod_modulo ? ['id' => $cod_modulo] : [], 'urbem_patrimonial_almoxarifado_configuracao');
        $choices = array(
            'demonstrar_saldo_estoque' => array(
                'Sim' => 'true',
                'Não' => 'false',
            ),
            'anular_saldo_pendente' => array(
                'Sim' => 'true',
                'Não' => 'false',
            ),
            'homologacao_automatica_requisicao' => array(
                'Sim' => 'true',
                'Não' => 'false',
            ),
            'numeracao_lancamento_estoque' => array(
                'Geral' => 'G',
                'Por Natureza' => 'N',
            ),
        );

        $formMapper->with('Dados de Configuração');
        foreach ($atributos as $key => $atributo) {
            if (!in_array($atributo['parametro'], array('CGMEntrada', 'CGMSaida'))) {
                $formMapper->add(
                    "atributo_" . $atributo['parametro'],
                    'choice',
                    array(
                        'choices' => $choices[$atributo['parametro']],
                        'expanded' => true,
                        'multiple' => false,
                        'label' => 'label.administracao.' . $atributo['parametro'],
                        'mapped' => false,
                        'required' => true,
                        'data' => $atributo['valor']
                    )
                );
            }
        }
        $formMapper->add(
            "cod_modulo",
            'hidden',
            array(
                'mapped' => false,
                'data' => $cod_modulo,
            )
        );
        $formMapper->end();
        return $formMapper;
    }


    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('exercicio')
            ->add('parametro')
            ->add('valor');
    }

    public function salvaCaixaEntidade($caixaEntidades)
    {
        if (is_null($caixaEntidades)) {
            return;
        }

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade');

        $modulo = $em->getRepository('CoreBundle:Administracao\Modulo')
            ->findOneBy(['codModulo' => ConfiguracaoModel::MODULO_FINANCEIRO_EMPENHO]);

        foreach ($caixaEntidades as $caixaEntidade) {
            $valor = explode('_', $caixaEntidade);
            list($entidade, $conta) = $valor;

            if (!isset($entidade) || !isset($conta)) {
                continue;
            }

            $entidadeObject = $em->getRepository('CoreBundle:Orcamento\Entidade')
                ->findOneBy([
                    'codEntidade' => $entidade,
                    'exercicio' => $this->getExercicio()
                ]);

            $configuracaoEntidade = $em->getRepository('CoreBundle:Administracao\ConfiguracaoEntidade')
                ->findOneBy([
                    'exercicio' => $entidadeObject->getExercicio(),
                    'codEntidade' => $entidadeObject->getCodEntidade(),
                    'codModulo' => ConfiguracaoModel::MODULO_FINANCEIRO_EMPENHO,
                ]);

            if (!$configuracaoEntidade) {
                $configuracaoEntidade = new ConfiguracaoEntidade();
            }

            $configuracaoEntidade->setParametro('conta_caixa');
            $configuracaoEntidade->setValor($conta);
            $configuracaoEntidade->setFkOrcamentoEntidade($entidadeObject);
            $configuracaoEntidade->setFkAdministracaoModulo($modulo);

            $em->persist($configuracaoEntidade);
            $em->flush();
        }
    }

    private function removeCaixaEntidades($cod_modulo)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade');

        $configuracoes = $em->getRepository('CoreBundle:Administracao\ConfiguracaoEntidade')
            ->findBy(['exercicio' => $this->getExercicio(), 'codModulo' => $cod_modulo, 'parametro' => 'conta_caixa']);

        foreach ($configuracoes as $configuracao) {
            $em->remove($configuracao);
        }
        $em->flush();
    }

    private function salvaDataFixaEntidadeEmpenho()
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade');
        $modulo = $em->getRepository('CoreBundle:Administracao\Modulo')
            ->findOneBy(['codModulo' => ConfiguracaoModel::MODULO_FINANCEIRO_EMPENHO]);

        $emSwCgm = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwCgm');
        $swCgmModel = new Model\SwCgmModel($emSwCgm);
        $entidades = $swCgmModel->getEntidadesConfiguracaoEmpenhoList(ConfiguracaoModel::MODULO_FINANCEIRO_EMPENHO, $this->getExercicio());
        foreach ($entidades as $entidade) {
            $info = array();

            $entidadeObject = $em->getRepository('CoreBundle:Orcamento\Entidade')
                ->findOneBy(['codEntidade' => $entidade['cod_entidade']]);

            $info['exercicio'] = $this->getExercicio();
            $info['entidade'] = $entidadeObject->getCodEntidade();
            $info['modulo'] = $modulo;

            $info['valor'] = $this->request->request->get('data_fixa_autorizacao_' . $entidade['cod_entidade']);
            $info['parametro'] = 'data_fixa_autorizacao';

            $configuracaoEntidade = $em->getRepository('CoreBundle:Administracao\ConfiguracaoEntidade')
                ->findOneBy([
                    'exercicio' => $this->getExercicio(),
                    'codEntidade' => $info['entidade'],
                    'codModulo' => ConfiguracaoModel::MODULO_FINANCEIRO_EMPENHO,
                    'parametro' => $info['parametro'],
                ]);

            $configuracaoEntidadeModel = new Model\Administracao\ConfiguracaoEntidadeModel($em);
            if ($configuracaoEntidade) {
                $configuracaoEntidade->setValor($info['valor']);
            } else {
                $configuracaoEntidade = $configuracaoEntidadeModel->saveEntidade($info);
            }
            $configuracaoEntidadeModel->save($configuracaoEntidade);

            $info['valor'] = $this->request->request->get('data_fixa_empenho_' . $entidade['cod_entidade']);
            $info['parametro'] = 'data_fixa_empenho';

            $configuracaoEntidade = $em->getRepository('CoreBundle:Administracao\ConfiguracaoEntidade')
                ->findOneBy([
                    'exercicio' => $this->getExercicio(),
                    'codEntidade' => $info['entidade'],
                    'codModulo' => ConfiguracaoModel::MODULO_FINANCEIRO_EMPENHO,
                    'parametro' => $info['parametro'],
                ]);

            if ($configuracaoEntidade) {
                $configuracaoEntidade->setValor($info['valor']);
            } else {
                $configuracaoEntidade = $configuracaoEntidadeModel->saveEntidade($info);
            }
            $configuracaoEntidadeModel->save($configuracaoEntidade);

            $info['valor'] = $this->request->request->get('data_fixa_liquidacao_' . $entidade['cod_entidade']);
            $info['parametro'] = 'data_fixa_liquidacao';

            $configuracaoEntidade = $em->getRepository('CoreBundle:Administracao\ConfiguracaoEntidade')
                ->findOneBy([
                    'codModulo' => ConfiguracaoModel::MODULO_FINANCEIRO_EMPENHO,
                    'exercicio' => $this->getExercicio(),
                    'parametro' => $info['parametro'],
                    'codEntidade' => $info['entidade']
                ]);

            if ($configuracaoEntidade) {
                $configuracaoEntidade->setValor($info['valor']);
            } else {
                $configuracaoEntidade = $configuracaoEntidadeModel->saveEntidade($info);
            }
            $configuracaoEntidadeModel->save($configuracaoEntidade);
        }
    }

    public function salvaAssinaturaTesouraria($assinaturas)
    {
        $container = $this->getConfigurationPool()->getContainer();

        if (is_null($assinaturas)) {
            return;
        }

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Tesouraria\Assinatura');

        foreach ($assinaturas as $assinatura) {
            $valor = explode('__', $assinatura);

            list($entidade, $cgm, $cargo, $situacao) = $valor;

            if (!isset($entidade) || !isset($cgm) || !isset($cargo) || !isset($situacao)) {
                continue;
            }

            if (is_null($entidade) || is_null($cgm) || is_null($cargo) || is_null($situacao)) {
                continue;
            }

            $assinaturaObject = $em->getRepository('CoreBundle:Tesouraria\Assinatura')
                ->findOneBy([
                    'codEntidade' => $entidade,
                    'exercicio' => $this->getExercicio(),
                    'tipo' => 'BO',
                    'numcgm' => $cgm
                ]);

            if ($assinaturaObject) {
                $container->get('session')->getFlashBag()->add('error', sprintf('Cgm %d já cadastrado para este exercício', $cgm));
                continue;
            }

            $entidadeObject = $em->getRepository('CoreBundle:Orcamento\Entidade')
                ->findOneBy(['codEntidade' => $entidade, 'exercicio' => $this->getExercicio()]);

            $cgmObject = $em->getRepository('CoreBundle:SwCgm')
                ->findOneBy(['numcgm' => $cgm]);


            $assinatura = new Assinatura();
            $assinatura->setFkOrcamentoEntidade($entidadeObject);
            $assinatura->setFkSwCgm($cgmObject);
            $assinatura->setSituacao((boolean) $situacao);
            $assinatura->setExercicio($this->getExercicio());
            $assinatura->setCargo($cargo);
            $assinatura->setTipo('BO');
            $assinatura->setNumMatricula('');

            $em->persist($assinatura);
            $em->flush();
        }
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Configuracao');
        $configuracaoModel = new ConfiguracaoModel($em);
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $childrens = $this->getForm()->all();
            $cod_modulo = (isset($childrens['cod_modulo'])) ? $childrens['cod_modulo']->getViewData() : '';
            $tipo = (isset($childrens['tipo_arrecadacao_configuracao'])) ? $childrens['tipo_arrecadacao_configuracao']->getViewData() : '';

            // Financeiro > Empenho
            $caixaEntidades = $this->getRequest()->request->get('conta');

            if ($cod_modulo == ConfiguracaoModel::MODULO_FINANCEIRO_EMPENHO) {
                $this->removeCaixaEntidades($cod_modulo);

                if (!is_null($caixaEntidades)) {
                    $this->salvaCaixaEntidade($caixaEntidades);
                }
                $this->salvaDataFixaEntidadeEmpenho();
            }

            // Financeiro > Tesouraria
            $assinaturaTesouraria = $this->request->get('assinaturaTesouraria');

            if ($cod_modulo == '30') {
                if (!is_null($assinaturaTesouraria)) {
                    $this->salvaAssinaturaTesouraria($assinaturaTesouraria);
                }
            }

            foreach ($childrens as $key => $children) {
                if ($key != 'cod_modulo' && $key != 'tipo_arrecadacao_configuracao') {
                    $info = explode('_', $key);

                    if ($cod_modulo == '22') {
                        $cod_atributo = $info[1] != 'dtContagemInicial' ? $info[1] . "_" . $info[2] : $info[1];
                    } else {
                        $cod_atributo = str_replace('atributo_', '', $key);
                    }
                    if ($cod_modulo == '35' && $cod_atributo == 'numeracao_licitacao') {
                        if (is_array(($children->getViewData()))) {
                            $valor = implode('', $children->getViewData());
                        }
                    } elseif (ConfiguracaoModel::MODULO_PATRIMONAL_PATRIMONIO && $cod_atributo == 'grupo_contas_permanente') {
                        $valor = $children->getNormData()->getCodEstrutural();
                    } else {
                        $valor = $children->getViewData();
                    }

                    // Tributário > Inscrição Econômica
                    if ($cod_modulo == ConfiguracaoModel::MODULO_TRIBUTARIO_ECONOMICO) {
                        if ($cod_atributo == 'diretor_tributos') {
                            $valor = $children->getNormData()->getNumcgm();
                        }
                    }

                    if ($cod_modulo == ConfiguracaoModel::MODULO_TRIBUTARIO_ARRECADACAO) {
                        if ($cod_atributo == 'fundamentacao_legal') {
                            $valor = $children->getNormData() . '/' . $this->getExercicio();
                            list($codNorma) = explode('-', $valor);
                            if ($codNorma) {
                                $valor = $codNorma;
                            }
                        }

                        if ($tipo == self::ARRECADACAO_CONFIGURACAO_TIPO) {
                            if ($cod_atributo == 'super_simples') {
                                $valores = $children->getNormData();

                                $string = '{{';
                                foreach ($valores as $valor) {
                                    $string .= sprintf('%s, "%s"},{', $valor->getCodGrupo(), $valor->getAnoExercicio());
                                }
                                $string = substr($string, 0, -2);
                                $string .= '}';
                                $valor = $string;
                            } else {
                                if ($children->getNormData() instanceof GrupoCredito) {
                                    $valor = sprintf('%s/%s', $children->getNormData()->getCodGrupo(), $children->getNormData()->getAnoExercicio());
                                }
                            }
                        }
                    }

                    $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Configuracao');
                    $configuracaoModel = new ConfiguracaoModel($em);

                    $data = new \DateTime();

                    $info = array(
                        'cod_modulo' => $cod_modulo,
                        'parametro' => $cod_atributo,
                        'valor' => $valor,
                        'exercicio' => $this->getExercicio()
                    );

                    if ($cod_atributo == $configuracaoModel::PARAM_CLASSIFICACAO_RECEITA_DEDUTORA) {
                        list($tipoContaReceita, $posicaoReceitas) = $this->getPosicaoReceita(ContaReceitaDedutoraAdmin::TIPO_RECEITA);
                        $info = $this->regraPosicaoReceita($posicaoReceitas, $tipoContaReceita, $info, 'label.classificacaoReceita.message.existeClassificacoesReceitaDedutora');
                    }

                    if ($cod_atributo == $configuracaoModel::PARAM_CLASSIFICACAO_RECEITA) {
                        list($tipoContaReceita, $posicaoReceitas) = $this->getPosicaoReceita(ContaReceitaAdmin::TIPO_RECEITA);
                        $info = $this->regraPosicaoReceita($posicaoReceitas, $tipoContaReceita, $info, 'label.classificacaoReceita.message.existeClassificacoesReceita');
                    }

                    if ($cod_atributo == $configuracaoModel::PARAM_CLASS_DEFESA) {
                        $this->regraPosicaoDespesa($info);
                    }

                    $u = $configuracaoModel->updateAtributosDinamicos($info);

                    if ($cod_modulo == '35') {
                        $entity = explode("__", $key);
                        if (array_key_exists(1, $entity)) {
                            $arrayEntidade[$entity[1]][] = $valor;
                        }
                    }
                }
            }

            if ($cod_modulo == '35') {
                $infos = array();
                $infoc = array();
                foreach ($arrayEntidade as $key => $entidade) {
                    $infos[$key]['cod_modulo'] = $cod_modulo;
                    $infos[$key]['cod_entidade'] = $key;
                    $infos[$key]['valor'] = $entidade[1];
                    $infos[$key]['exercicio'] = date('Y');

                    $infoc[$key]['cod_modulo'] = $cod_modulo;
                    $infoc[$key]['cod_entidade'] = $key;
                    $infoc[$key]['valor'] = $entidade[2];
                    $infoc[$key]['exercicio'] = date('Y');

                    $configuracaoModel->selectInsertUpdateAtributosDinamicosSolicitacao($infos[$key]);
                    $configuracaoModel->selectInsertUpdateAtributosDinamicosCompras($infoc[$key]);
                }
            }

            if ($cod_modulo == ConfiguracaoModel::MODULO_TRIBUTARIO_DIVIDA_ATIVA) {
                try {
                    $configuracaoModel->prePersistConfiguracao($childrens, $this->getExercicio());
                    $this->getDoctrine()->clear();
                    $this->redirectByRoute('urbem_administrativo_administracao_configuracao_create', ['id' => ConfiguracaoModel::MODULO_TRIBUTARIO_DIVIDA_ATIVA, 'tipo' => $childrens['tipo']->getViewData()]);
                } catch (\Exception $e) {
                    throw new \Exception($e);
                }
            }

            if (ConfiguracaoModel::MODULO_TRIBUTARIO_ARRECADACAO && $tipo == self::ARRECADACAO_CONFIGURACAO_TIPO) {
                (new RedirectResponse($this->generateUrl('create', array('id' => $info['cod_modulo'], 'tipo' => self::ARRECADACAO_CONFIGURACAO_TIPO))))->send();
            }

            if ($cod_modulo == "2") {
                $container->get('session')->getFlashBag()->add('success', 'Alteração da mensagem concluída com sucesso!');
            } else {
                $container->get('session')->getFlashBag()->add('success', 'Configuração alterada com sucesso!');
            }

            (new RedirectResponse($this->generateUrl('create', array('id' => $info['cod_modulo']))))->send();
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }
    }

    /**
     * @param $cod_modulo
     * @param $formMapper
     * @return mixed
     */
    public function montaHtmlAdministracaoSistema($cod_modulo, $formMapper)
    {
        $this->setBreadCrumb($cod_modulo ? ['id' => $cod_modulo] : [], 'urbem_administrativo_sistema_configuracao');
        $data = new \DateTime();

        $info = array(
            'cod_modulo' => $cod_modulo,
            'exercicio' => $data->format('Y'),
            'parametro' => 'mensagem'
        );

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Configuracao');
        $configuracaoModel = new ConfiguracaoModel($em);
        $atributo = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info);

        $this->setBreadCrumb([], 'urbem_administrativo_administracao_mensagem');
        $formMapper->with('label.dadosMensagem');
        $formMapper->add(
            'mensagem',
            'textarea',
            [
                'label' => 'Mensagem',
                'mapped' => false,
                'data' => $atributo['valor'],
                'required' => true,
                'attr' => [
                    'class' => 'mensagem-inicial ',
                    'placeholder' => 'Digite aquí a mensagem inicial do sistema.'
                ]
            ]
        );
        $formMapper->add(
            "cod_modulo",
            'hidden',
            array(
                'mapped' => false,
                'data' => $atributo['cod_modulo'],
            )
        );
        $formMapper->add(
            "back_link",
            'hidden',
            array(
                'mapped' => false,
                'data' => '/administrativo/administracao/sistema/gestao',
            )
        );
        $formMapper->end();
        return $formMapper;
    }

    public function montaHtmlAdministrativoConfiguracaoProtocolo($cod_modulo, $formMapper, $atributos)
    {
        $this->setBreadCrumb($cod_modulo ? ['id' => $cod_modulo] : [], 'urbem_administrativo_protocolo_configuracao');

        $data = [
            'caminho_recibo_processo' => '',
            'mensagem_recibo_processo' => '',
            'copias_recibo_processo' => '',
            'carta_arquivamento_temporario' => '',
            'carta_arquivamento_definitivo' => '',
            'tipo_numeracao_processo' => '',
            'mascara_processo' => '',
            'tipo_numeracao_classificacao_assunto' => '',
            'mascara_assunto' => '',
            'centro_custo' => '',
        ];

        foreach ($atributos as $atributo) {
            $data[$atributo['parametro']] = $atributo['valor'];
        }

        $formMapper->with('label.configuracaoProtocolo.dadosRecibosProtocolo');

        $formMapper->add('caminho_recibo_processo', 'text', [
            'label' => 'label.configuracaoProtocolo.nome',
            'mapped' => false,
            'data' => $data['caminho_recibo_processo'],
            'required' => true
        ]);

        $formMapper->add('mensagem_recibo_processo', 'textarea', [
            'label' => 'label.configuracaoProtocolo.mensagem',
            'mapped' => false,
            'data' => $data['mensagem_recibo_processo'],
            'required' => true
        ]);

        $formMapper->add('copias_recibo_processo', 'number', [
            'label' => 'label.configuracaoProtocolo.numCopias',
            'mapped' => false,
            'data' => $data['copias_recibo_processo'],
            'required' => true
        ]);

        $formMapper->end();

        $formMapper->with('label.configuracaoProtocolo.dadosCartasArquivamento');

        $formMapper->add('carta_arquivamento_temporario', 'textarea', [
            'label' => 'label.configuracaoProtocolo.cartaTemporaria',
            'mapped' => false,
            'data' => $data['carta_arquivamento_temporario'],
            'required' => true
        ]);

        $formMapper->add('carta_arquivamento_definitivo', 'textarea', [
            'label' => 'label.configuracaoProtocolo.cartaDefinitiva',
            'mapped' => false,
            'data' => $data['carta_arquivamento_definitivo'],
            'required' => true
        ]);

        $formMapper->end();

        $formMapper->with('label.configuracaoProtocolo.dadosProcesso');

        $formMapper->add('tipo_numeracao_processo', 'choice', [
            'label' => 'label.configuracaoProtocolo.geracaoCodigo',
            'choices' => [
                "label.selecione" => "",
                "Automática" => "1",
                "Manual" => "2"
            ],
            'mapped' => false,
            'data' => $data['tipo_numeracao_processo'],
            'attr' => ['class' => 'select2-parameters '],
            'required' => true
        ]);

        $formMapper->add('mascara_processo', 'text', [
            'label' => 'label.configuracaoProtocolo.mascaraProcesso',
            'mapped' => false,
            'data' => $data['mascara_processo'],
            'required' => true
        ]);

        $formMapper->end();

        $formMapper->with('label.configuracaoProtocolo.dadosClassificacaoAssunto');

        $formMapper->add('tipo_numeracao_classificacao_assunto', 'choice', [
            'label' => 'label.configuracaoProtocolo.geracaoCodigo',
            'choices' => [
                "label.selecione" => "",
                "Automática" => "automatico",
                "Manual" => "manual"
            ],
            'mapped' => false,
            'data' => $data['tipo_numeracao_classificacao_assunto'],
            'attr' => ['class' => 'select2-parameters '],
            'required' => true
        ]);

        $formMapper->add('mascara_assunto', 'text', [
            'label' => 'label.configuracaoProtocolo.mascaraProcesso',
            'mapped' => false,
            'data' => $data['mascara_assunto'],
            'required' => true
        ]);

        $formMapper->end();

        $formMapper->with('label.configuracaoProtocolo.dadosCentroCusto');

        $formMapper->add('centro_custo', 'choice', [
            'label' => 'label.configuracaoProtocolo.centroCustoObrigatorio',
            'choices' => ['label_type_yes' => "true", 'label_type_no' => "false"],
            'mapped' => false,
            'expanded' => true,
            'data' => $data['centro_custo'],
            'required' => true,
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            )
        ]);

        $formMapper->add(
            "cod_modulo",
            'hidden',
            array(
                'mapped' => false,
                'data' => $cod_modulo,
            )
        );

        $formMapper->end();

        return $formMapper;
    }

    /**
     * Financeiro > Orçamento > Configuração
     *
     * @param $codModulo
     * @param $formMapper
     * @return mixed
     */
    public function montaHtmlFinanceiroOrcamentoConfiguracao($codModulo, $formMapper)
    {
        $this->setBreadCrumb($codModulo ? ['id' => $codModulo] : [], 'urbem_financeiro_orcamento_configuracao');

        $data = new \DateTime();
        $exercicio = $this->getExercicio();

        $em = $this->modelManager->getEntityManager($this->getClass());
        $configuracaoModel = new ConfiguracaoModel($em);

        // Entidade Prefeitura
        $info['cod_entidade_prefeitura'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'cod_entidade_prefeitura'
        ];
        $entidadePrefeitura = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['cod_entidade_prefeitura']);

        // Entidades para o select
        $entidades = $configuracaoModel->getEntidades($exercicio);

        $orcamentoEntidades = [];
        foreach ($entidades as $entidade) {
            $orcamentoEntidades[$entidade['nom_cgm']] = $entidade['cod_entidade'];
        }

        $fieldOptions['cod_entidade_prefeitura'] = [
            'choices' => $orcamentoEntidades,
            'label' => 'label.entidadePrefeitura',
            'mapped' => false,
            'required' => true,
            'data' => $entidadePrefeitura['valor'],
            'attr' => ['class' => 'select2-parameters']
        ];

        if (!is_null($entidadePrefeitura)) {
            $fieldOptions['numcgm']['attr']['disabled'] = 'disabled';
            $fieldOptions['cod_entidade_prefeitura']['attr'] = [
                'class' => 'select2-parameters'
            ];
        }

        // Entidade Câmara
        $info['cod_entidade_camara'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'cod_entidade_camara'
        ];
        $entidadeCamara = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['cod_entidade_camara']);

        $fieldOptions['cod_entidade_camara'] = [
            'choices' => $orcamentoEntidades,
            'label' => 'label.entidadeCamara',
            'mapped' => false,
            'required' => true,
            'data' => $entidadeCamara['valor'],
            'attr' => ['class' => 'select2-parameters']
        ];
        if (!is_null($entidadeCamara)) {
            $fieldOptions['numcgm']['attr']['disabled'] = 'disabled';
            $fieldOptions['cod_entidade_camara']['attr'] = [
                'class' => 'select2-parameters'
            ];
        }

        // Entidade RPPS
        $info['cod_entidade_rpps'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'cod_entidade_rpps'
        ];
        $entidadeRPPS = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['cod_entidade_rpps']);

        $fieldOptions['cod_entidade_rpps'] = [
            'choices' => $orcamentoEntidades,
            'label' => 'label.entidadeRPPS',
            'mapped' => false,
            'required' => true,
            'data' => $entidadeRPPS['valor'],
            'attr' => ['class' => 'select2-parameters']
        ];

        if (!is_null($entidadeRPPS)) {
            $fieldOptions['numcgm']['attr']['disabled'] = 'disabled';
            $fieldOptions['cod_entidade_rpps']['attr'] = [
                'class' => 'select2-parameters'
            ];
        }

        // Entidade Consórcio
        $info['cod_entidade_consorcio'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'cod_entidade_consorcio'
        ];

        $entidadeConsorcio = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['cod_entidade_consorcio']);

        $fieldOptions['cod_entidade_consorcio'] = [
            'choices' => $orcamentoEntidades,
            'label' => 'label.entidadeConsorcio',
            'mapped' => false,
            'required' => false,
            'data' => $entidadeConsorcio['valor'],
            'attr' => ['class' => 'select2-parameters']
        ];
        if (!is_null($entidadeConsorcio)) {
            $fieldOptions['numcgm']['attr']['disabled'] = 'disabled';
            $fieldOptions['cod_entidade_consorcio']['attr'] = [
                'class' => 'select2-parameters'
            ];
        }

        // Forma de Execução do Orçamento
        $info['forma_execucao_orcamento'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'forma_execucao_orcamento'
        ];
        $formaExecucaoOrcamento = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['forma_execucao_orcamento']);
        if (!is_null($formaExecucaoOrcamento)) {
            $formaExecucaoOrcamentoTexto = '';
            if ($formaExecucaoOrcamento['valor'] == 0) {
                $formaExecucaoOrcamentoTexto = '2 - Detalhado no Orçamento';
            } elseif ($formaExecucaoOrcamento['valor'] == 1) {
                $formaExecucaoOrcamentoTexto = '1 - Detalhado na Execução';
            } else {
                $formaExecucaoOrcamentoTexto = $formaExecucaoOrcamento['valor'] ;
            }

            $fieldOptions['forma_execucao_orcamento'] = [
                'label' => 'label.formaExecucaoOrcamento',
                'mapped' => false,
                'data' => $formaExecucaoOrcamentoTexto
            ];
        } else {
            $fieldOptions['forma_execucao_orcamento'] = [
                'choices' => [
                    'Detalhado no Orçamento' => 0,
                    'Detalhado na Execução' => 1,
                ],
                'label' => 'label.entidadeRPPS',
                'mapped' => false,
                'required' => true,
                'attr' => ['class' => 'select2-parameters']
            ];
        }

        // Período de Apuração das Metas Receita
        $info['unidade_medida_metas_receita'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $data->format('Y'),
            'parametro' => 'unidade_medida_metas_receita'
        ];
        $periodoApuracaoMetas = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['unidade_medida_metas_receita']);

        $fieldOptions['unidade_medida_metas_receita'] = [
            'choices' => [
                'Mensal' => 1,
                'Bimestral' => 2,
                'Trimestral' => 3,
                'Quadrimestral' => 4,
                'Semestral' => 6, // Urbem antigo está com id 6 e não o 5
            ],
            'label' => 'label.periodoApuracaoMetasReceita',
            'mapped' => false,
            'required' => true,
            'data' => $periodoApuracaoMetas['valor'],
            'attr' => ['class' => 'select2-parameters']
        ];

        // Período de Apuração das Metas Despesa
        $info['unidade_medida_metas_despesa'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'unidade_medida_metas_despesa'
        ];
        $periodoApuracaoMetasDespesa = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['unidade_medida_metas_despesa']);

        $fieldOptions['unidade_medida_metas_despesa'] = [
            'choices' => [
                'Mensal' => 1,
                'Bimestral' => 2,
                'Trimestral' => 3,
                'Quadrimestral' => 4,
                'Semestral' => 6, // Urbem antigo está com id 6 e não o 5
            ],
            'label' => 'label.periodoPeriodoApuracaoMetasDespesa',
            'mapped' => false,
            'required' => true,
            'data' => $periodoApuracaoMetasDespesa['valor'],
            'attr' => ['class' => 'select2-parameters']
        ];

        // Máscara de Classificação da Receita
        $tipoContaReceita = $em->getRepository('CoreBundle:Orcamento\TipoContaReceita')->findOneByCodTipo(0);

        $posicaoReceitaRepository = $em->getRepository('CoreBundle:Orcamento\PosicaoReceita');
        $posicaoReceitas = $posicaoReceitaRepository->findBy(array('exercicio' => $exercicio, 'codTipo' => $tipoContaReceita), array('codPosicao' => 'ASC'));

        $mascaraClassificacaoReceita = '';
        foreach ($posicaoReceitas as $posicaoReceita) {
            $mascaraClassificacaoReceita .= $posicaoReceita->getMascara() . '.';
        }
        $mascaraClassificacaoReceita = substr($mascaraClassificacaoReceita, 0, -1);
        if (!$mascaraClassificacaoReceita) {
            $info['mascara_classificacao_receita'] = [
                'cod_modulo' => $codModulo,
                'exercicio' => $exercicio,
                'parametro' => 'mascara_classificacao_receita'
            ];
            $mascaraClassificacaoReceitaValor = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['mascara_classificacao_receita']);
            if (!empty($mascaraClassificacaoReceitaValor)) {
                $mascaraClassificacaoReceita = $mascaraClassificacaoReceitaValor['valor'];
            }
        }
        $fieldOptions['mascara_classificacao_receita'] = [
            'label' => 'label.mascaraClassificacaoReceita',
            'mapped' => false,
            'required' => true,
            'data' => $mascaraClassificacaoReceita
        ];

        // Máscara de Classificação da Receita Dedutora
        $tipoContaReceita = $em->getRepository('CoreBundle:Orcamento\TipoContaReceita')->findOneByCodTipo(1);

        $posicaoReceitaRepository = $em->getRepository('CoreBundle:Orcamento\PosicaoReceita');
        $posicaoReceitas = $posicaoReceitaRepository->findBy(array('exercicio' => $exercicio, 'codTipo' => $tipoContaReceita), array('codPosicao' => 'ASC'));

        $mascaraClassificacaoReceita = '';
        foreach ($posicaoReceitas as $posicaoReceita) {
            $mascaraClassificacaoReceita .= $posicaoReceita->getMascara() . '.';
        }
        $mascaraClassificacaoReceita = substr($mascaraClassificacaoReceita, 0, -1);

        if (!$mascaraClassificacaoReceita) {
            $info['mascara_classificacao_receita_dedutora'] = [
                'cod_modulo' => $codModulo,
                'exercicio' => $exercicio,
                'parametro' => 'mascara_classificacao_receita_dedutora'
            ];
            $mascaraClassificacaoReceitaValor = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['mascara_classificacao_receita_dedutora']);
            if (!empty($mascaraClassificacaoReceitaValor)) {
                $mascaraClassificacaoReceita = $mascaraClassificacaoReceitaValor['valor'];
            }
        }

        $fieldOptions['mascara_classificacao_receita_dedutora'] = [
            'label' => 'label.mascaraClassificacaoReceitaDedutora',
            'mapped' => false,
            'required' => true,
            'data' => $mascaraClassificacaoReceita,
            'attr' => ['class' => 'mask-classifacao ']
        ];

        // Máscara da Despesa
        $info['masc_class_despesa'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'masc_class_despesa'
        ];
        $mascaraDespesa = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['masc_class_despesa']);

        $fieldOptions['masc_class_despesa'] = [
            'label' => 'label.mascaraDespesa',
            'mapped' => false,
            'required' => true,
            'data' => $mascaraDespesa['valor'],
            'attr' => ['class' => 'mask-classifacao ']
        ];

        $info['masc_despesa'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'masc_despesa'
        ];
        $mascDespesa = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['masc_despesa']);

        $fieldOptions['masc_despesa'] = [
            'label' => 'label.mascaraDespesa',
            'mapped' => false,
            'required' => true,
            'data' => $mascDespesa['valor'],
            'attr' => ['class' => 'mask-classifacao ']
        ];

        // Máscara do Recursos
        $info['masc_recurso'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'masc_recurso'
        ];
        $mascRecurso = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['masc_recurso']);

        $fieldOptions['masc_recurso'] = [
            'label' => 'label.mascaraRecurso',
            'mapped' => false,
            'required' => true,
            'data' => $mascRecurso['valor'],
            'attr' => ['class' => 'mask-classifacao ']
        ];

        // Limite Suplementação Decreto
        $info['limite_suplementacao_decreto'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'limite_suplementacao_decreto'
        ];
        $limiteSuplementacaoDecreto = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['limite_suplementacao_decreto']);

        $fieldOptions['limite_suplementacao_decreto'] = [
            'label' => 'label.limiteSuplementacaoDecreto',
            'mapped' => false,
            'required' => true,
            'data' => $limiteSuplementacaoDecreto['valor'],
        ];

        // Dígitos de Identificação de Não Orçamentários
        $info['pao_digitos_id_oper_especiais'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'pao_digitos_id_oper_especiais'
        ];
        $digitosIdentificacaoOperacaoEspecial = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['pao_digitos_id_oper_especiais']);

        $fieldOptions['pao_digitos_id_oper_especiais'] = [
            'label' => 'label.digitosIdentificacaoOperacaoEspecial',
            'mapped' => false,
            'required' => true,
            'data' => $digitosIdentificacaoOperacaoEspecial['valor'],
        ];

        // Profissão Contador
        $info['cod_contador'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'cod_contador'
        ];
        $codContador = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['cod_contador']);
        $contadorObject = null;
        if (!empty($codContador['valor'])) {
            $contadorObject = $em->getRepository('CoreBundle:Cse\\Profissao')
                ->findOneBy(['codProfissao' => $codContador['valor']]);
        }

        $fieldOptions['cod_contador'] = [
            'class' => 'CoreBundle:Cse\Profissao',
            'choice_label' => 'nomProfissao',
            'label' => 'label.profissaoContador',
            'mapped' => false,
            'required' => true,
            'data' => $contadorObject,
            'attr' => ['class' => 'select2-parameters'],
        ];

        // Profissão Técnico Contábil
        $info['cod_tec_contabil'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'cod_tec_contabil'
        ];
        $codContadorContabil = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['cod_tec_contabil']);

        $contadorContabilObject = $em->getRepository('CoreBundle:Cse\\Profissao')
            ->findOneBy(['codProfissao' => $codContadorContabil['valor']]);

        $fieldOptions['cod_tec_contabil'] = [
            'class' => 'CoreBundle:Cse\Profissao',
            'choice_label' => 'nomProfissao',
            'label' => 'label.profissaoTecnicoContabil',
            'mapped' => false,
            'required' => true,
            'data' => $contadorContabilObject,
            'attr' => ['class' => 'select2-parameters'],
        ];

        // Campos do formulario
        $formMapper->with('label.dadosConfiguracao');
        $formMapper->add(
            "cod_modulo",
            'hidden',
            array(
                'mapped' => false,
                'data' => $codModulo,
            )
        );

        $formMapper->add(
            'cod_entidade_prefeitura',
            'choice',
            $fieldOptions['cod_entidade_prefeitura']
        );

        $formMapper->add(
            'cod_entidade_camara',
            'choice',
            $fieldOptions['cod_entidade_camara']
        );

        $formMapper->add(
            'cod_entidade_rpps',
            'choice',
            $fieldOptions['cod_entidade_rpps']
        );

        $formMapper->add(
            'cod_entidade_rpps',
            'choice',
            $fieldOptions['cod_entidade_rpps']
        );

        $formMapper->add(
            'cod_entidade_consorcio',
            'choice',
            $fieldOptions['cod_entidade_consorcio']
        );

        if (!is_null($formaExecucaoOrcamento)) {
            $formMapper->add(
                'forma_execucao_orcamento',
                'text',
                $fieldOptions['forma_execucao_orcamento']
            );
        } else {
            $formMapper->add(
                'forma_execucao_orcamento',
                'choice',
                $fieldOptions['forma_execucao_orcamento']
            );
        }

        $formMapper->add(
            'unidade_medida_metas_receita',
            'choice',
            $fieldOptions['unidade_medida_metas_receita']
        );

        $formMapper->add(
            'unidade_medida_metas_despesa',
            'choice',
            $fieldOptions['unidade_medida_metas_despesa']
        );

        $formMapper->add(
            'mascara_classificacao_receita',
            'text',
            $fieldOptions['mascara_classificacao_receita']
        );

        $formMapper->add(
            'mascara_classificacao_receita_dedutora',
            'text',
            $fieldOptions['mascara_classificacao_receita_dedutora']
        );

        $formMapper->add(
            'masc_class_despesa',
            'text',
            $fieldOptions['masc_class_despesa']
        );

        $formMapper->add(
            'masc_despesa',
            'text',
            $fieldOptions['masc_despesa']
        );

        $formMapper->add(
            'masc_recurso',
            'text',
            $fieldOptions['masc_recurso']
        );

        $formMapper->add(
            'limite_suplementacao_decreto',
            'text',
            $fieldOptions['limite_suplementacao_decreto']
        );

        $formMapper->end();

        $formMapper->with('label.responsavelContabil');

        $formMapper->add(
            'cod_contador',
            'entity',
            $fieldOptions['cod_contador']
        );

        $formMapper->add(
            'cod_tec_contabil',
            'entity',
            $fieldOptions['cod_tec_contabil']
        );
        $formMapper->end();

        return $formMapper;
    }

    /**
     * @param $arrayFrom
     * @param $orderBy
     * @param $fieldSearch
     * @param bool $valida
     * @return array
     */
    protected function orderByElementsDynamicFields($arrayFrom, $orderBy, $fieldSearch, $valida = false)
    {
        $newOrder = [];
        foreach ($arrayFrom as $atributo) {
            $key = array_search($atributo[$fieldSearch], $orderBy);
            if ($valida) {
                if (false !== $key) {
                    $newOrder[$key] = $atributo;
                }
            } else {
                $newOrder[$key] = $atributo;
            }
        }
        ksort($newOrder);
        return $newOrder;
    }


    /**
     * Financeiro > Contabilidade > Configuração
     *
     * @param $cod_modulo
     * @param $formMapper
     * @return mixed
     */
    public function montaHtmlFinanceiroContabilidadeConfiguracao($cod_modulo, $formMapper)
    {
        $this->setBreadCrumb($cod_modulo ? ['id' => $cod_modulo] : [], 'urbem_financeiro_contabilidade_configuracao');
        $exercicio = $this->getExercicio();

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Configuracao');
        $configuracaoModel = new ConfiguracaoModel($em);

        // Data de Implantação
        $info = array(
            'cod_modulo' => $cod_modulo,
            'exercicio' => $exercicio,
            'parametro' => 'data_implantacao'
        );

        $dtImplantacao = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info);


        // Mês de Processamento
        $info = array(
            'cod_modulo' => $cod_modulo,
            'exercicio' => $exercicio,
            'parametro' => 'mes_processamento'
        );

        $mesProcessamento = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info);

        // Máscara de Classificação do Plano de Contas
        $info = array(
            'cod_modulo' => $cod_modulo,
            'exercicio' => $exercicio,
            'parametro' => 'masc_plano_contas'
        );

        $mascaraClassificacaoPlanoContas = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info);

        // Utilizar Encerramento de Mês
        $info = array(
            'cod_modulo' => $cod_modulo,
            'exercicio' => $exercicio,
            'parametro' => 'utilizar_encerramento_mes'
        );

        $utilizarEncerramentoMes = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info);

        $formMapper->with('label.dadosConfiguracao');

        $formMapper->add(
            'data_implantacao',
            'text',
            [
                'label' => 'label.organograma.implantacao',
                'mapped' => false,
                'data' => $dtImplantacao['valor'],
                'required' => true
            ]
        );
        $formMapper->add(
            'mes_processamento',
            'choice',
            [
                'choices' => [
                    'Janeiro' => '1',
                    'Fevereiro' => '2',
                    'Março' => '3',
                    'Abril' => '4',
                    'Maio' => '5',
                    'Junho' => '6',
                    'Julho' => '7',
                    'Agosto' => '8',
                    'Setembro' => '9',
                    'Outubro' => '10',
                    'Novembro' => '11',
                    'Dezembro' => '12'
                ],
                'attr' => ['class' => 'select2-parameters '],
                'label' => 'label.mesProcessamento',
                'mapped' => false,
                'data' => $mesProcessamento['valor'],
                'required' => true
            ]
        );
        $formMapper->add(
            'masc_plano_contas',
            'text',
            [
                'label' => 'label.mascaraClassificacaoPlanoContas',
                'mapped' => false,
                'data' => $mascaraClassificacaoPlanoContas['valor'],
                'required' => true
            ]
        );
        $formMapper->add(
            'utilizar_encerramento_mes',
            'choice',
            [
                'choices' => [
                    'sim' => true,
                    'nao' => false
                ],
                'attr' => ['class' => 'select2-parameters '],
                'label' => 'label.utilizarEncerramentoMes',
                'mapped' => false,
                'required' => true,
                'data' => $utilizarEncerramentoMes['valor'],
            ]
        );
        $formMapper->add(
            "cod_modulo",
            'hidden',
            array(
                'mapped' => false,
                'data' => $mesProcessamento['cod_modulo'],
            )
        );
        $formMapper->end();
        return $formMapper;
    }

    /**
     * Módulo Financeiro > Empenho > Configuração
     *
     * @param $cod_modulo
     * @param $formMapper
     * @return mixed
     */
    public function montaHtmlFinanceiroEmpenhoConfiguracao($cod_modulo, $formMapper)
    {
        $this->setBreadCrumb($cod_modulo ? ['id' => $cod_modulo] : [], 'urbem_financeiro_empenho_configuracao');

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade');

        $configuracaoModel = new ConfiguracaoModel($em);

        $configuracoes = $em->getRepository('CoreBundle:Administracao\ConfiguracaoEntidade')
            ->findBy([
                'exercicio' => $this->getExercicio(),
                'codModulo' => $cod_modulo,
                'parametro' => 'conta_caixa'
            ]);

        $configuracoesData = [];
        foreach ($configuracoes as $configuracao) {
            $infoConta['codEntidade'] = $configuracao->getFkOrcamentoEntidade()->getCodEntidade();

            $codPlano = (integer) $configuracao->getValor();

            $params = [
                'exercicio' => $this->getExercicio(),
                'codPlano' => $codPlano
            ];

            $planoConta = $configuracaoModel->getContaCaixaEntidade($params);
            if ($planoConta) {
                $infoConta['codContaCaixa'] = $planoConta['cod_conta'];
                $infoConta['nomeConta'] = $planoConta['nom_conta'];

                array_push($configuracoesData, $infoConta);
            }
        }

        $dataCustom = array();
        $dataCustom['configuracoes'] = $configuracoesData;

        $exercicio = $this->getExercicio();

        $formMapper->with('label.dadosConfiguracao');

        // Tipo de Numeração
        $info = array(
            'cod_modulo' => $cod_modulo,
            'exercicio' => $exercicio,
            'parametro' => 'numero_empenho'
        );

        $tipoNumeracao = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info);

        $formMapper->add(
            'numero_empenho',
            'choice',
            [
                'choices' => [
                    'label.porEntidade' => 'P',
                    'label.global' => 'G',
                ],
                'attr' => ['class' => 'select2-parameters '],
                'label' => 'label.tipoNumeracao',
                'mapped' => false,
                'data' => $tipoNumeracao['valor'],
                'required' => true
            ]
        );

        // Setar Data de Vencimento da Liquidação
        $info = array(
            'cod_modulo' => $cod_modulo,
            'exercicio' => $exercicio,
            'parametro' => 'anular_autorizacao_automatica'
        );

        $setarDataVencimentoLiquidacao = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info);

        $formMapper->add(
            'anular_autorizacao_automatica',
            'choice',
            [
                'choices' => [
                    'sim' => 1,
                    'nao' => 0,
                ],
                'attr' => ['class' => 'select2-parameters '],
                'label' => 'label.setarDataVencimentoLiquidacao',
                'mapped' => false,
                'data' => $setarDataVencimentoLiquidacao['valor'],
                'required' => true
            ]
        );

        // Setar Liquidação Automática
        $info = array(
            'cod_modulo' => $cod_modulo,
            'exercicio' => $exercicio,
            'parametro' => 'liquidacao_automatica'
        );

        $setarLiquidacaoAutomatica = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info);

        $formMapper->add(
            'liquidacao_automatica',
            'choice',
            [
                'choices' => [
                    'sim' => 1,
                    'nao' => 0,
                ],
                'attr' => ['class' => 'select2-parameters '],
                'label' => 'label.setarLiquidacaoAutomatica',
                'mapped' => false,
                'data' => $setarLiquidacaoAutomatica['valor'],
                'required' => true
            ]
        );

        // Setar OP Automática
        $info = array(
            'cod_modulo' => $cod_modulo,
            'exercicio' => $exercicio,
            'parametro' => 'op_automatica'
        );

        $setarOpAutomatica = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info);

        $formMapper->add(
            'op_automatica',
            'choice',
            [
                'choices' => [
                    'sim' => 1,
                    'nao' => 0,
                ],
                'attr' => ['class' => 'select2-parameters '],
                'label' => 'label.setarOpAutomatica',
                'mapped' => false,
                'data' => $setarOpAutomatica['valor'],
                'required' => true
            ]
        );

        // Emitir carnê na OP
        $info = array(
            'cod_modulo' => $cod_modulo,
            'exercicio' => $exercicio,
            'parametro' => 'emitir_carne_op'
        );

        $emitirCarneOp = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info);

        $formMapper->add(
            'emitir_carne_op',
            'choice',
            [
                'choices' => [
                    'sim' => 1,
                    'nao' => 0,
                ],
                'attr' => ['class' => 'select2-parameters '],
                'label' => 'label.emitirCarneOp',
                'mapped' => false,
                'data' => $emitirCarneOp['valor'],
                'required' => true
            ]
        );

        $formMapper->end();

        $formMapper->add(
            "cod_modulo",
            'hidden',
            array(
                'mapped' => false,
                'data' => ConfiguracaoModel::MODULO_FINANCEIRO_EMPENHO,
            )
        );

        $emSwCgm = $this->modelManager->getEntityManager(SwCgm::class);
        $swCgmModel = new Model\SwCgmModel($emSwCgm);
        $entidades = $swCgmModel->getEntidadesConfiguracaoEmpenhoList($cod_modulo, $this->getExercicio());

        $dataCustom['listaEntidades'] = $entidades;

        $emEntidade = $this->modelManager->getEntityManager(Entidade::class);
        $entidadeList = $emEntidade->getRepository(Entidade::class)
            ->findBy(['exercicio' => $this->getExercicio()]);

        $entidadeSelect = array();
        foreach ($entidadeList as $entidade) {
            $label = $entidade->getFkSwCgm()->getNomCgm();
            $value = $entidade->getCodEntidade();
            $entidadeSelect[$value] = $label;
        }

        $dataCustom['entidades'] = $entidadeSelect;
        $dataCustom['exercicio'] = $this->getExercicio();
        $this->setDataCustom($dataCustom);

        $this->customBodyTemplate = 'FinanceiroBundle::Contabilidade/Configuracao/contaCaixaCustom.html.twig';
        return $formMapper;
    }

    /**
     * Módulo Financeiro > Tesouraria > Configuração
     *
     * @param $cod_modulo
     * @param $formMapper
     * @return mixed
     */
    public function montaHtmlFinanceiroTesourariaConfiguracao($cod_modulo, $formMapper)
    {
        $this->setBreadCrumb($cod_modulo ? ['id' => $cod_modulo] : [], 'urbem_financeiro_tesouraria_configuracao');
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Configuracao');
        $configuracaoModel = new ConfiguracaoModel($em);

        $exercicio = $this->getExercicio();

        // Forma de Comprovação
        $info = array(
            'cod_modulo' => $cod_modulo,
            'exercicio' => $exercicio,
            'parametro' => 'forma_comprovacao'
        );

        $formaComprovacao = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info);

        $formMapper->add(
            'forma_comprovacao',
            'choice',
            [
                'choices' => [
                    'label.nenhum' => 0,
                    'label.comprovante' => 1,
                    'label.autenticacao' => 2,
                ],
                'attr' => ['class' => 'select2-parameters '],
                'label' => 'label.formaComprovacao',
                'mapped' => false,
                'data' => $formaComprovacao['valor'],
                'required' => true
            ]
        );

        // Numeração de Comprovação
        $info = array(
            'cod_modulo' => $cod_modulo,
            'exercicio' => $exercicio,
            'parametro' => 'numeracao_comprovacao'
        );

        $numeracaoComprovacao = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info);

        $formMapper->add(
            'numeracao_comprovacao',
            'choice',
            [
                'choices' => [
                    'label.diaria' => 1,
                    'label.anual' => 2,
                ],
                'attr' => ['class' => 'select2-parameters '],
                'label' => 'label.numeracaoComprovacao',
                'mapped' => false,
                'data' => $numeracaoComprovacao['valor'],
                'required' => true
            ]
        );

        // Numeração de Comprovação
        $info = array(
            'cod_modulo' => $cod_modulo,
            'exercicio' => $exercicio,
            'parametro' => 'numero_vias_comprovacao'
        );

        $numeroViasComprovacao = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info);

        $formMapper->add(
            'numero_vias_comprovacao',
            'text',
            [
                'label' => 'label.nrViasComprovacao',
                'mapped' => false,
                'data' => $numeroViasComprovacao['valor'],
                'required' => true
            ]
        );

        // Dígitos de Autenticação
        $info = array(
            'cod_modulo' => $cod_modulo,
            'exercicio' => $exercicio,
            'parametro' => 'digitos_autenticacao'
        );

        $digitosAutenticacao = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info);

        $formMapper->add(
            'digitos_autenticacao',
            'text',
            [
                'label' => 'label.digitosAutenticacao',
                'mapped' => false,
                'data' => $digitosAutenticacao['valor'],
                'required' => true
            ]
        );

        // Ocultar Movimentações Conciliadas
        $info = array(
            'cod_modulo' => $cod_modulo,
            'exercicio' => $exercicio,
            'parametro' => 'ocultar_mov_conciliacao'
        );

        $digitosAutenticacao = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info);

        $formMapper->add(
            'ocultar_mov_conciliacao',
            'choice',
            [
                'choices' => [
                    'nao' => 0,
                    'sim' => 1
                ],
                'attr' => ['class' => 'select2-parameters '],
                'label' => 'label.ocultarMovimentacoesConciliadas',
                'mapped' => false,
                'data' => $digitosAutenticacao['valor'],
                'required' => true
            ]
        );

        $formMapper->add(
            "cod_modulo",
            'hidden',
            array(
                'mapped' => false,
                'data' => 30,
            )
        );

        // Entidades
        $emEntidade = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Orcamento\Entidade');
        $entidadeList = $emEntidade->getRepository('CoreBundle:Orcamento\Entidade')
            ->findBy(['exercicio' => $this->getExercicio()]);

        $entidadeSelect = array();
        foreach ($entidadeList as $entidade) {
            $label = $entidade->getFkSwCgm()->getNomCgm();
            $value = $entidade->getCodEntidade();
            $entidadeSelect[$value] = $label;
        }

        // Cgms
        $emSwCgm = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwCgm');
        $cgmList = $emSwCgm->getRepository('CoreBundle:SwCgm')
            ->getSwCgmFiltro();


        $cgms = ArrayHelper::parseArrayToChoice($cgmList, 'numcgm', 'nom_cgm');

        $dataCustom['entidades'] = $entidadeSelect;
        $dataCustom['exercicio'] = $this->getExercicio();
        $dataCustom['cgms'] = $cgms;
        $this->setDataCustom($dataCustom);

        $this->customBodyTemplate = 'FinanceiroBundle::Tesouraria/Configuracao/assinaturaCustom.html.twig';

        return $formMapper;
    }

    /**
     * @param $codModulo
     * @param $formMapper
     * @return mixed
     */
    public function montaHtmlFinanceiroPpaConfiguracao($codModulo, $formMapper)
    {
        $this->setBreadCrumb($codModulo ? ['id' => $codModulo] : [], 'urbem_financeiro_ppa_configuracao');
        $em = $this->modelManager->getEntityManager(Configuracao::class);
        $configuracaoModel = new ConfiguracaoModel($em);

        $exercicio = $this->getExercicio();

        $formMapper->with('label.projetoAtividadeOperacaoEspecial');

        // Posição do Dígito de Identificação
        $info['pao_posicao_digito_id'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'pao_posicao_digito_id'
        ];
        $posicaoDigitoIdentificacao = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['pao_posicao_digito_id']);

        $fieldOptions['pao_posicao_digito_id'] = [
            'label' => 'label.posicaoDigitoIdentificacao',
            'mapped' => false,
            'required' => true,
            'data' => $posicaoDigitoIdentificacao['valor'],
            'attr' => [
                'readonly' => true,
            ]
        ];

        // Dígitos de Identificação do Projeto
        $info['pao_digitos_id_projeto'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'pao_digitos_id_projeto'
        ];
        $digitosIdentificacaoProjeto = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['pao_digitos_id_projeto']);

        $fieldOptions['pao_digitos_id_projeto'] = [
            'label' => 'label.digitoIdentificacaoProjeto',
            'mapped' => false,
            'required' => true,
            'data' => $digitosIdentificacaoProjeto['valor'],
        ];

        // Dígitos de Identificação da Atividade
        $info['pao_digitos_id_atividade'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'pao_digitos_id_atividade'
        ];
        $digitosIdentificacaoAtividade = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['pao_digitos_id_atividade']);

        $fieldOptions['pao_digitos_id_atividade'] = [
            'label' => 'label.digitosIdentificacaoAtividade',
            'mapped' => false,
            'required' => true,
            'data' => $digitosIdentificacaoAtividade['valor'],
        ];

        // Dígitos de Identificação da Operação Especial
        $info['pao_digitos_id_oper_especiais'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'pao_digitos_id_oper_especiais'
        ];
        $digitosIdentificacaoOperacaoEspecial = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['pao_digitos_id_oper_especiais']);

        $fieldOptions['pao_digitos_id_oper_especiais'] = [
            'label' => 'label.digitosIdentificacaoOperacaoEspecial',
            'mapped' => false,
            'required' => true,
            'data' => $digitosIdentificacaoOperacaoEspecial['valor'],
        ];

        // Dígitos de Identificação de Não Orçamentários
        $info['pao_digitos_id_nao_orcamentarios'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $exercicio,
            'parametro' => 'pao_digitos_id_nao_orcamentarios'
        ];
        $digitosIdentificacaoNaoOrcamentario = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['pao_digitos_id_nao_orcamentarios']);

        $fieldOptions['pao_digitos_id_nao_orcamentarios'] = [
            'label' => 'label.digitosIdentificacaoNaoOrcamentarios',
            'mapped' => false,
            'required' => true,
            'data' => $digitosIdentificacaoNaoOrcamentario['valor'],
        ];


        $formMapper->add(
            'pao_posicao_digito_id',
            'number',
            $fieldOptions['pao_posicao_digito_id']
        );

        $formMapper->add(
            'pao_digitos_id_projeto',
            'text',
            $fieldOptions['pao_digitos_id_projeto']
        );

        $formMapper->add(
            'pao_digitos_id_atividade',
            'text',
            $fieldOptions['pao_digitos_id_atividade']
        );

        $formMapper->add(
            'pao_digitos_id_oper_especiais',
            'text',
            $fieldOptions['pao_digitos_id_oper_especiais']
        );

        $formMapper->add(
            'pao_digitos_id_nao_orcamentarios',
            'text',
            $fieldOptions['pao_digitos_id_nao_orcamentarios']
        );

        $formMapper->add(
            "cod_modulo",
            'hidden',
            array(
                'mapped' => false,
                'data' => 43,
            )
        );

        $formMapper->end();

        return $formMapper;
    }

    /**
     * @param $codModulo
     * @param $formMapper
     * @return mixed
     */
    public function montaHtmlTributarioEconomicoConfiguracao($codModulo, $formMapper)
    {
        $this->setBreadCrumb($codModulo ? ['id' => $codModulo] : [], 'tributario_economico_configuracao_alterar');
        $em = $this->modelManager->getEntityManager(Configuracao::class);
        $configuracaoModel = new ConfiguracaoModel($em);

        $formMapper->with('label.configuracaoEconomico.dados');

        // Número Licença
        $info['numero_licenca'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'numero_licenca'
        ];

        $numeroLicenca = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['numero_licenca']);

        $fieldOptions['numero_licenca'] = [
            'label' => 'label.configuracaoEconomico.numeroLicenca',
            'mapped' => false,
            'required' => true,
            'data' => $numeroLicenca['valor'],
            'choices' => [
                'label.configuracaoEconomico.automatico' => 'Automatico',
                'label.configuracaoEconomico.automaticoPorExercicio' => 'Exercicio',
                'label.configuracaoEconomico.manual' => 'Manual',
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];

        // Número Alvará Licença
        $info['nro_alvara_licenca'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'nro_alvara_licenca'
        ];

        $numeroLicenca = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['nro_alvara_licenca']);

        $fieldOptions['nro_alvara_licenca'] = [
            'label' => 'label.configuracaoEconomico.numeroAlvaraLicenca',
            'mapped' => false,
            'required' => true,
            'data' => $numeroLicenca['valor'],
            'choices' => [
                'label.exercicio' => 'Exercicio',
                'label.configuracaoEconomico.documento' => 'Documento'
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];

        // Máscara Licença
        $info['mascara_licenca'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'mascara_licenca'
        ];

        $mascaraLicenca = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['mascara_licenca']);

        $fieldOptions['mascara_licenca'] = [
            'label' => 'label.configuracaoEconomico.mascaraLicenca',
            'mapped' => false,
            'required' => true,
            'data' => $mascaraLicenca['valor'],
        ];

        // Inscrição Econômica
        $info['numero_inscricao_economica'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'numero_inscricao_economica'
        ];

        $numeroInscricaoEconomica = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['numero_inscricao_economica']);

        $fieldOptions['numero_inscricao_economica'] = [
            'label' => 'label.configuracaoEconomico.inscricaoEconomica',
            'mapped' => false,
            'required' => true,
            'data' => $numeroInscricaoEconomica['valor'],
            'choices' => [
                'label.configuracaoEconomico.automatico' => 'Automatico',
                'label.configuracaoEconomico.manual' => 'Manual',
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];

        // Máscara Inscrição Econômica
        $info['mascara_inscricao_economica'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'mascara_inscricao_economica'
        ];

        $mascaraInscricaoEconomica = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['mascara_inscricao_economica']);

        $fieldOptions['mascara_inscricao_economica'] = [
            'label' => 'label.configuracaoEconomico.inscricaoEconomica',
            'mapped' => false,
            'required' => true,
            'data' => $mascaraInscricaoEconomica['valor'],
        ];

        // CNAE Fiscal
        $info['cnae_fiscal'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'cnae_fiscal'
        ];

        $cnaeFiscal = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['cnae_fiscal']);

        $fieldOptions['cnae_fiscal'] = [
            'label' => 'label.configuracaoEconomico.cnaeFiscal',
            'mapped' => false,
            'required' => true,
            'data' => $cnaeFiscal['valor'],
            'choices' => [
                'label.configuracaoEconomico.vincular' => 'Vincular',
                'label.configuracaoEconomico.naoVincular' => 'NaoVincular'
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];

        // Diretor de Tributos
        $info['diretor_tributos'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'diretor_tributos'
        ];

        $diretorTributos = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['diretor_tributos']);

        $em = $this->modelManager->getEntityManager(SwCgm::class);
        $swCgm = $em->getRepository(SwCgm::class)->findOneBy(['numcgm' => $diretorTributos['valor']]);

        $fieldOptions['diretor_tributos'] = [
            'class' => SwCgm::class,
            'label' => 'label.configuracaoEconomico.diretorTributos',
            'data' => $swCgm,
            'required' => false,
            'mapped' => false,
            'route' => ['name' => 'carrega_sw_cgm']
        ];

        // Vig. Sanitária Secretaria
        $info['sanit_secretaria'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'sanit_secretaria'
        ];

        $vigSanitariaSecretaria = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['sanit_secretaria']);

        $fieldOptions['sanit_secretaria'] = [
            'label' => 'label.configuracaoEconomico.vigSanitariaSecretaria',
            'mapped' => false,
            'required' => true,
            'data' => $vigSanitariaSecretaria['valor']
        ];

        // Vig. Sanitária Departamento
        $info['sanit_departamento'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'sanit_departamento'
        ];

        $vigSanitariaDepartamento = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['sanit_departamento']);

        $fieldOptions['sanit_departamento'] = [
            'label' => 'label.configuracaoEconomico.vigSanitariaDepartamento',
            'mapped' => false,
            'required' => true,
            'data' => $vigSanitariaDepartamento['valor']
        ];

        // Certidão de Baixa
        $info['certidao_baixa'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'certidao_baixa'
        ];

        $certidaoBaixa = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['certidao_baixa']);

        $fieldOptions['certidao_baixa'] = [
            'label' => 'label.configuracaoEconomico.certidaoBaixa',
            'mapped' => false,
            'required' => true,
            'data' => $certidaoBaixa['valor'],
            'choices' => [
                'label.configuracaoEconomico.emitir' => 'sim',
                'label.configuracaoEconomico.naoEmitir' => 'nao'
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];

        $formMapper->add(
            'numero_licenca',
            'choice',
            $fieldOptions['numero_licenca']
        );

        $formMapper->add(
            'nro_alvara_licenca',
            'choice',
            $fieldOptions['nro_alvara_licenca']
        );

        $formMapper->add(
            'mascara_licenca',
            'text',
            $fieldOptions['mascara_licenca']
        );

        $formMapper->add(
            'numero_inscricao_economica',
            'choice',
            $fieldOptions['numero_inscricao_economica']
        );

        $formMapper->add(
            'mascara_inscricao_economica',
            'text',
            $fieldOptions['mascara_inscricao_economica']
        );

        $formMapper->add(
            'cnae_fiscal',
            'choice',
            $fieldOptions['cnae_fiscal']
        );

        $formMapper->add(
            'diretor_tributos',
            'autocomplete',
            $fieldOptions['diretor_tributos']
        );

        $formMapper->add(
            'sanit_secretaria',
            'text',
            $fieldOptions['sanit_secretaria']
        );

        $formMapper->add(
            'sanit_departamento',
            'text',
            $fieldOptions['sanit_departamento']
        );

        $formMapper->add(
            'certidao_baixa',
            'choice',
            $fieldOptions['certidao_baixa']
        );

        $formMapper->add(
            "cod_modulo",
            'hidden',
            array(
                'mapped' => false,
                'data' => ConfiguracaoModel::MODULO_TRIBUTARIO_ECONOMICO,
            )
        );

        $formMapper->end();

        return $formMapper;
    }

    /**
     * @param $codModulo
     * @param $formMapper
     * @return mixed
     */
    public function montaHtmlTributarioArrecadacaoConfiguracao($codModulo, $formMapper)
    {
        $this->setBreadCrumb($codModulo ? ['id' => $codModulo] : [], 'tributario_arrecadacao_configuracao_alterar');
        $em = $this->modelManager->getEntityManager(Configuracao::class);
        $configuracaoModel = new ConfiguracaoModel($em);

        $formMapper->with('label.configuracaoArrecadacao.dados');

        // Baixa Manual
        $info['baixa_manual'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'baixa_manual'
        ];

        $baixaManual = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['baixa_manual']);

        $fieldOptions['baixa_manual'] = [
            'label' => 'label.configuracaoArrecadacao.diferencaBaixaManual',
            'mapped' => false,
            'required' => true,
            'data' => $baixaManual['valor'],
            'choices' => [
                'label.configuracaoArrecadacao.aceita' => 'aceita',
                'label.configuracaoArrecadacao.bloqueia' => 'bloqueia',
                'label.configuracaoArrecadacao.confirma' => 'confirma',
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];

        // Baixa Manual Única
        $info['baixa_manual_unica'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'baixa_manual_unica'
        ];

        $baixaManualUnica = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['baixa_manual_unica']);

        $fieldOptions['baixa_manual_unica'] = [
            'label' => 'label.configuracaoArrecadacao.baixaManualUnica',
            'mapped' => false,
            'required' => true,
            'data' => $baixaManualUnica['valor'],
            'choices' => [
                'label.configuracaoArrecadacao.aceita' => 'sim',
                'label.configuracaoArrecadacao.nao' => 'nao',
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];

        // Baixa Manual D.A. Vencida
        $info['baixa_manual_divida_vencida'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'baixa_manual_divida_vencida'
        ];

        $baixaManualVencida = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['baixa_manual_divida_vencida']);

        $fieldOptions['baixa_manual_divida_vencida'] = [
            'label' => 'label.configuracaoArrecadacao.baixaManualDAVencida',
            'mapped' => false,
            'required' => true,
            'data' => $baixaManualVencida['valor'],
        ];

        // Valor Máximo
        $info['valor_maximo'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'valor_maximo'
        ];

        $valorMaximo = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['valor_maximo']);

        $fieldOptions['valor_maximo'] = [
            'label' => 'label.configuracaoArrecadacao.valorMaximo',
            'mapped' => false,
            'required' => true,
            'data' => $valorMaximo['valor'],
        ];

        // Valor Mínimo para Lançamentos Automáticos
        $info['minimo_lancamento_automatico'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'minimo_lancamento_automatico'
        ];

        $valorMinimo = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['minimo_lancamento_automatico']);

        $fieldOptions['minimo_lancamento_automatico'] = [
            'label' => 'label.configuracaoArrecadacao.valorMinimoLancamentosAutomaticos',
            'mapped' => false,
            'required' => true,
            'data' => $valorMinimo['valor'],
        ];

        // Código FEBRABAN
        $info['FEBRABAN'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'FEBRABAN'
        ];

        $codigoFebraban = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['FEBRABAN']);

        $fieldOptions['FEBRABAN'] = [
            'label' => 'label.configuracaoArrecadacao.codigoFebraban',
            'mapped' => false,
            'required' => true,
            'data' => $codigoFebraban['valor'],
        ];

        // Forma de Verificação do Valor
        $info['tipo_avaliacao'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'tipo_avaliacao'
        ];

        $verificacaoValor = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['tipo_avaliacao']);

        $fieldOptions['tipo_avaliacao'] = [
            'label' => 'label.configuracaoArrecadacao.formaVerificacaoValor',
            'mapped' => false,
            'required' => true,
            'data' => $verificacaoValor['valor'],
            'choices' => [
                'label.configuracaoArrecadacao.percentual' => 'percentual',
                'label.configuracaoArrecadacao.absoluto' => 'absoluto',
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];

        // Convênio para Parcelamentos
        $info['convenio_parcelamento'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'convenio_parcelamento'
        ];

        $convenioParcelamento = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['convenio_parcelamento']);

        $convenio = null;
        if ($convenioParcelamento['valor']) {
            $em = $this->modelManager->getEntityManager(Convenio::class);
            $convenio = $em->getRepository(Convenio::class)->findOneBy([
                'codConvenio' => $convenioParcelamento['valor']
            ]);
        }

        $fieldOptions['convenio_parcelamento'] = [
            'class' => Convenio::class,
            'label' => 'label.configuracaoArrecadacao.convenioParcelamentos',
            'mapped' => false,
            'required' => true,
            'data' => !is_null($convenio) ? $convenio : '',
            'attr' => ['class' => 'select2-parameters '],
        ];

        // Ativar Suspensão para Valores Abaixo do Mínimo
        $info['ativar_suspensao'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'ativar_suspensao'
        ];

        $ativarSuspensao = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['ativar_suspensao']);

        $fieldOptions['ativar_suspensao'] = [
            'label' => 'label.configuracaoArrecadacao.ativarSuspensaoValoresAbaixoMinimo',
            'mapped' => false,
            'required' => true,
            'data' => $ativarSuspensao['valor'],
            'choices' => [
                'sim' => 'sim',
                'nao' => 'nao',
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];

        // Ativar Suspensão para Valores Abaixo do Mínimo
        $info['emissao_cpf'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'emissao_cpf'
        ];

        $emissaoCarnesCPF = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['emissao_cpf']);

        $fieldOptions['emissao_cpf'] = [
            'label' => 'label.configuracaoArrecadacao.emissaoCarnesCPF',
            'mapped' => false,
            'required' => true,
            'data' => $emissaoCarnesCPF['valor'],
            'choices' => [
                'label.configuracaoArrecadacao.emitir' => 'emitir',
                'label.configuracaoArrecadacao.naoEmitir' => 'naoemitir',
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];

        // Ativar Suspensão para Valores Abaixo do Mínimo
        $info['emitir_carne_isento'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'emitir_carne_isento'
        ];

        $emitirCarneIsento = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['emitir_carne_isento']);

        $fieldOptions['emitir_carne_isento'] = [
            'label' => 'label.configuracaoArrecadacao.emissaoCarneContribuinteIsento',
            'mapped' => false,
            'required' => true,
            'data' => $emitirCarneIsento['valor'],
            'choices' => [
                'sim' => 'sim',
                'nao' => 'nao',
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];

        // Fundamentação Legal
        $info['fundamentacao_legal'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'fundamentacao_legal'
        ];

        $fundamentacaoLegal = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['fundamentacao_legal']);

        $norma = null;
        if ($fundamentacaoLegal['valor']) {
            list($codNorma, $exercicio) = explode('/', $fundamentacaoLegal['valor']);
            $em = $this->modelManager->getEntityManager(Norma::class);
            $norma = $em->getRepository(Norma::class)->findOneBy([
                'codNorma' => $codNorma,
                'exercicio' => $exercicio
            ]);
        }

        $fieldOptions['fundamentacao_legal'] = [
            'label' => 'label.configuracaoArrecadacao.fundamentacaoLegal',
            'route' => array(
                'name' => 'api-search-norma-nome-codigo',
            ),
            'mapped' => false,
            'data' => !is_null($norma) ? $norma : '',
        ];

        // Carnê Secretaria
        $info['carne_secretaria'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'carne_secretaria'
        ];

        $carneSecretaria = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['carne_secretaria']);

        $fieldOptions['carne_secretaria'] = [
            'label' => 'label.configuracaoArrecadacao.carneSecretaria',
            'mapped' => false,
            'required' => true,
            'data' => $carneSecretaria['valor']
        ];

        // Carnê Departamento
        $info['carne_departamento'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'carne_departamento'
        ];

        $carneDepartamento = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['carne_departamento']);

        $fieldOptions['carne_departamento'] = [
            'label' => 'label.configuracaoArrecadacao.carneDepartamento',
            'mapped' => false,
            'required' => true,
            'data' => $carneDepartamento['valor']
        ];

        // Carnê Dam
        $info['carne_dam'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'carne_dam'
        ];

        $carneDam = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['carne_dam']);

        $fieldOptions['carne_dam'] = [
            'label' => 'label.configuracaoArrecadacao.carneDam',
            'mapped' => false,
            'required' => true,
            'data' => $carneDam['valor']
        ];

        // Cobrar Nota Avulsa
        $info['nota_avulsa'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'nota_avulsa'
        ];

        $notaAvulsa = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['nota_avulsa']);

        $fieldOptions['nota_avulsa'] = [
            'label' => 'label.configuracaoArrecadacao.cobrarNotaAvulsa',
            'mapped' => false,
            'required' => true,
            'data' => $notaAvulsa['valor'],
            'choices' => [
                'sim' => 'sim',
                'nao' => 'nao',
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];

        // Nº de Vias da Nota Avulsa
        $info['vias_nota_avulsa'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'vias_nota_avulsa'
        ];

        $notaAvulsa = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['vias_nota_avulsa']);

        $fieldOptions['vias_nota_avulsa'] = [
            'label' => 'label.configuracaoArrecadacao.numViasNotaAvulsa',
            'mapped' => false,
            'required' => true,
            'data' => $notaAvulsa['valor'],
            'choices' => [
                '2' => '2',
                '4' => '4',
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];

        $formMapper->add(
            'baixa_manual',
            'choice',
            $fieldOptions['baixa_manual']
        );

        $formMapper->add(
            'baixa_manual_unica',
            'choice',
            $fieldOptions['baixa_manual_unica']
        );

        $formMapper->add(
            'baixa_manual_divida_vencida',
            'text',
            $fieldOptions['baixa_manual_divida_vencida']
        );

        $formMapper->add(
            'baixa_manual_divida_vencida',
            'text',
            $fieldOptions['baixa_manual_divida_vencida']
        );

        $formMapper->add(
            'valor_maximo',
            'text',
            $fieldOptions['valor_maximo']
        );

        $formMapper->add(
            'minimo_lancamento_automatico',
            'text',
            $fieldOptions['minimo_lancamento_automatico']
        );

        $formMapper->add(
            'FEBRABAN',
            'text',
            $fieldOptions['FEBRABAN']
        );

        $formMapper->add(
            'tipo_avaliacao',
            'choice',
            $fieldOptions['tipo_avaliacao']
        );

        $formMapper->add(
            'convenio_parcelamento',
            'entity',
            $fieldOptions['convenio_parcelamento']
        );

        $formMapper->add(
            'ativar_suspensao',
            'choice',
            $fieldOptions['ativar_suspensao']
        );

        $formMapper->add(
            'emissao_cpf',
            'choice',
            $fieldOptions['emissao_cpf']
        );

        $formMapper->add(
            'emitir_carne_isento',
            'choice',
            $fieldOptions['emitir_carne_isento']
        );

        $formMapper->add(
            'fundamentacao_legal',
            'autocomplete',
            $fieldOptions['fundamentacao_legal']
        );

        $formMapper->add(
            'carne_secretaria',
            'text',
            $fieldOptions['carne_secretaria']
        );

        $formMapper->add(
            'carne_departamento',
            'text',
            $fieldOptions['carne_departamento']
        );

        $formMapper->add(
            'carne_dam',
            'text',
            $fieldOptions['carne_dam']
        );

        $formMapper->add(
            'nota_avulsa',
            'choice',
            $fieldOptions['nota_avulsa']
        );

        $formMapper->add(
            'vias_nota_avulsa',
            'choice',
            $fieldOptions['vias_nota_avulsa']
        );

        $formMapper->add(
            "tipo_arrecadacao_configuracao",
            'hidden',
            array(
                'mapped' => false,
                'data' => '',
            )
        );

        $formMapper->add(
            "cod_modulo",
            'hidden',
            array(
                'mapped' => false,
                'data' => ConfiguracaoModel::MODULO_TRIBUTARIO_ARRECADACAO,
            )
        );

        $formMapper->end();

        return $formMapper;
    }

    /**
     * @param $codModulo
     * @param $formMapper
     * @return mixed
     */
    public function montaHtmlTributarioArrecadacaoConfiguracaoGrupoCreditos($codModulo, $formMapper)
    {
        $this->setBreadCrumb($codModulo ? ['id' => $codModulo] : [], 'tributario_economico_configuracao_grupo_creditos_alterar');
        $em = $this->modelManager->getEntityManager(Configuracao::class);
        $configuracaoModel = new ConfiguracaoModel($em);

        $formMapper->with('label.configuracaoGrupoCreditos.dados');

        // Transferência de Imóveis
        $info['grupo_credito_itbi'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'grupo_credito_itbi'
        ];

        $transferenciaImoveis = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['grupo_credito_itbi']);

        $grupoCreditos = null;
        if (!empty($transferenciaImoveis['valor'])) {
            list($codigo, $ano) = explode('/', $transferenciaImoveis['valor']);
            $grupoCreditos = $em->getRepository(GrupoCredito::class)
                ->findOneBy(['codGrupo' => $codigo, 'anoExercicio' => $ano]);
        }

        $fieldOptions['grupo_credito_itbi'] = [
            'class' => GrupoCredito::class,
            'choice_label' => 'descricao',
            'label' => 'label.configuracaoGrupoCreditos.transferenciaImoveis',
            'mapped' => false,
            'required' => true,
            'data' => $grupoCreditos,
            'attr' => ['class' => 'select2-parameters'],
            'query_builder' => function ($grupoCredito) {
                return $grupoCredito->createQueryBuilder('g')
                    ->where('g.anoExercicio = :exercicio')
                    ->setParameter('exercicio', $this->getExercicio())
                    ->orderBy('g.descricao', 'ASC');
            }
        ];

        // IPTU
        $info['grupo_credito_iptu'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'grupo_credito_iptu'
        ];

        $iptu = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['grupo_credito_iptu']);

        $grupoCreditos = null;
        if (!empty($iptu['valor'])) {
            list($codigo, $ano) = explode('/', $iptu['valor']);
            $grupoCreditos = $em->getRepository(GrupoCredito::class)
                ->findOneBy(['codGrupo' => $codigo, 'anoExercicio' => $ano]);
        }

        $fieldOptions['grupo_credito_iptu'] = [
            'class' => GrupoCredito::class,
            'choice_label' => 'descricao',
            'label' => 'label.configuracaoGrupoCreditos.iptu',
            'mapped' => false,
            'required' => true,
            'data' => $grupoCreditos,
            'attr' => ['class' => 'select2-parameters'],
            'query_builder' => function ($grupoCredito) {
                return $grupoCredito->createQueryBuilder('g')
                    ->where('g.anoExercicio = :exercicio')
                    ->setParameter('exercicio', $this->getExercicio())
                    ->orderBy('g.descricao', 'ASC');
            }
        ];

        // Escrituração de Receitas
        $info['escrituracao_receita'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'escrituracao_receita'
        ];

        $escrituracaoReceitas = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['escrituracao_receita']);

        $grupoCreditos = null;
        if (!empty($escrituracaoReceitas['valor'])) {
            list($codigo, $ano) = explode('/', $escrituracaoReceitas['valor']);
            $grupoCreditos = $em->getRepository(GrupoCredito::class)
                ->findOneBy(['codGrupo' => $codigo, 'anoExercicio' => $ano]);
        }

        $fieldOptions['escrituracao_receita'] = [
            'class' => GrupoCredito::class,
            'choice_label' => 'descricao',
            'label' => 'label.configuracaoGrupoCreditos.escrituracaoReceitas',
            'mapped' => false,
            'required' => true,
            'data' => $grupoCreditos,
            'attr' => ['class' => 'select2-parameters'],
            'query_builder' => function ($grupoCredito) {
                return $grupoCredito->createQueryBuilder('g')
                    ->where('g.anoExercicio = :exercicio')
                    ->setParameter('exercicio', $this->getExercicio())
                    ->orderBy('g.descricao', 'ASC');
            }
        ];

        // Nota Avulsa
        $info['grupo_nota_avulsa'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'grupo_nota_avulsa'
        ];

        $escrituracaoReceitas = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['grupo_nota_avulsa']);

        $grupoCreditos = null;
        if (!empty($escrituracaoReceitas['valor'])) {
            list($codigo, $ano) = explode('/', $escrituracaoReceitas['valor']);
            $grupoCreditos = $em->getRepository(GrupoCredito::class)
                ->findOneBy(['codGrupo' => $codigo, 'anoExercicio' => $ano]);
        }

        $fieldOptions['grupo_nota_avulsa'] = [
            'class' => GrupoCredito::class,
            'choice_label' => 'descricao',
            'label' => 'label.configuracaoGrupoCreditos.notaAvulsa',
            'mapped' => false,
            'required' => true,
            'data' => $grupoCreditos,
            'attr' => ['class' => 'select2-parameters'],
            'query_builder' => function ($grupoCredito) {
                return $grupoCredito->createQueryBuilder('g')
                    ->where('g.anoExercicio = :exercicio')
                    ->setParameter('exercicio', $this->getExercicio())
                    ->orderBy('g.descricao', 'ASC');
            }
        ];

        // Lançamento Automático Geral
        $info['grupo_diferenca_geral'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'grupo_diferenca_geral'
        ];

        $lancamentoAutomaticoGeral = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['grupo_diferenca_geral']);

        $grupoCreditos = null;
        if (!empty($lancamentoAutomaticoGeral['valor'])) {
            list($codigo, $ano) = explode('/', $lancamentoAutomaticoGeral['valor']);
            $grupoCreditos = $em->getRepository(GrupoCredito::class)
                ->findOneBy(['codGrupo' => $codigo, 'anoExercicio' => $ano]);
        }

        $fieldOptions['grupo_diferenca_geral'] = [
            'class' => GrupoCredito::class,
            'choice_label' => 'descricao',
            'label' => 'label.configuracaoGrupoCreditos.lancamentoAutomaticoGeral',
            'mapped' => false,
            'required' => true,
            'data' => $grupoCreditos,
            'attr' => ['class' => 'select2-parameters'],
            'query_builder' => function ($grupoCredito) {
                return $grupoCredito->createQueryBuilder('g')
                    ->where('g.anoExercicio = :exercicio')
                    ->setParameter('exercicio', $this->getExercicio())
                    ->orderBy('g.descricao', 'ASC');
            }
        ];

        // Lançamento Automático Imobiliário
        $info['grupo_diferenca_imob'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'grupo_diferenca_imob'
        ];

        $lancamentoAutomaticoImobiliario = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['grupo_diferenca_imob']);

        $grupoCreditos = null;
        if (!empty($lancamentoAutomaticoImobiliario['valor'])) {
            list($codigo, $ano) = explode('/', $lancamentoAutomaticoImobiliario['valor']);
            $grupoCreditos = $em->getRepository(GrupoCredito::class)
                ->findOneBy(['codGrupo' => $codigo, 'anoExercicio' => $ano]);
        }

        $fieldOptions['grupo_diferenca_imob'] = [
            'class' => GrupoCredito::class,
            'choice_label' => 'descricao',
            'label' => 'label.configuracaoGrupoCreditos.lancamentoAutomaticoImobiliario',
            'mapped' => false,
            'required' => true,
            'data' => $grupoCreditos,
            'attr' => ['class' => 'select2-parameters'],
            'query_builder' => function ($grupoCredito) {
                return $grupoCredito->createQueryBuilder('g')
                    ->where('g.anoExercicio = :exercicio')
                    ->setParameter('exercicio', $this->getExercicio())
                    ->orderBy('g.descricao', 'ASC');
            }
        ];

        // Lançamento Automático Econômico
        $info['grupo_diferenca_econ'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'grupo_diferenca_econ'
        ];

        $lancamentoAutomaticoEconomico = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['grupo_diferenca_econ']);

        $grupoCreditos = null;
        if (!empty($lancamentoAutomaticoEconomico['valor'])) {
            list($codigo, $ano) = explode('/', $lancamentoAutomaticoEconomico['valor']);
            $grupoCreditos = $em->getRepository(GrupoCredito::class)
                ->findOneBy(['codGrupo' => $codigo, 'anoExercicio' => $ano]);
        }

        $fieldOptions['grupo_diferenca_econ'] = [
            'class' => GrupoCredito::class,
            'choice_label' => 'descricao',
            'label' => 'label.configuracaoGrupoCreditos.lancamentoAutomaticoEconomico',
            'mapped' => false,
            'required' => true,
            'data' => $grupoCreditos,
            'attr' => ['class' => 'select2-parameters'],
            'query_builder' => function ($grupoCredito) {
                return $grupoCredito->createQueryBuilder('g')
                    ->where('g.anoExercicio = :exercicio')
                    ->setParameter('exercicio', $this->getExercicio())
                    ->orderBy('g.descricao', 'ASC');
            }
        ];

        // Lançamento Automático Acréscimos Geral
        $info['grupo_diferenca_acrescimo_geral'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'grupo_diferenca_acrescimo_geral'
        ];

        $lancamentoAutomaticoAcrescimosGeral = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['grupo_diferenca_acrescimo_geral']);

        $grupoCreditos = null;
        if (!empty($lancamentoAutomaticoAcrescimosGeral['valor'])) {
            list($codigo, $ano) = explode('/', $lancamentoAutomaticoAcrescimosGeral['valor']);
            $grupoCreditos = $em->getRepository(GrupoCredito::class)
                ->findOneBy(['codGrupo' => $codigo, 'anoExercicio' => $ano]);
        }

        $fieldOptions['grupo_diferenca_acrescimo_geral'] = [
            'class' => GrupoCredito::class,
            'choice_label' => 'descricao',
            'label' => 'label.configuracaoGrupoCreditos.lancamentoAutomaticoAcrescimosGeral',
            'mapped' => false,
            'required' => true,
            'data' => $grupoCreditos,
            'attr' => ['class' => 'select2-parameters'],
            'query_builder' => function ($grupoCredito) {
                return $grupoCredito->createQueryBuilder('g')
                    ->where('g.anoExercicio = :exercicio')
                    ->setParameter('exercicio', $this->getExercicio())
                    ->orderBy('g.descricao', 'ASC');
            }
        ];

        // Lançamento Automático Acréscimos Imobiliário
        $info['grupo_diferenca_acrescimo_imob'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'grupo_diferenca_acrescimo_imob'
        ];

        $lancamentoAutomaticoAcrescimosImobiliario = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['grupo_diferenca_acrescimo_imob']);

        $grupoCreditos = null;
        if (!empty($lancamentoAutomaticoAcrescimosImobiliario['valor'])) {
            list($codigo, $ano) = explode('/', $lancamentoAutomaticoAcrescimosImobiliario['valor']);
            $grupoCreditos = $em->getRepository(GrupoCredito::class)
                ->findOneBy(['codGrupo' => $codigo, 'anoExercicio' => $ano]);
        }

        $fieldOptions['grupo_diferenca_acrescimo_imob'] = [
            'class' => GrupoCredito::class,
            'choice_label' => 'descricao',
            'label' => 'label.configuracaoGrupoCreditos.lancamentoAutomaticoAcrescimosImobiliario',
            'mapped' => false,
            'required' => true,
            'data' => $grupoCreditos,
            'attr' => ['class' => 'select2-parameters'],
            'query_builder' => function ($grupoCredito) {
                return $grupoCredito->createQueryBuilder('g')
                    ->where('g.anoExercicio = :exercicio')
                    ->setParameter('exercicio', $this->getExercicio())
                    ->orderBy('g.descricao', 'ASC');
            }
        ];

        // Lançamento Automático Acréscimos Economico
        $info['grupo_diferenca_acrescimo_econ'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'grupo_diferenca_acrescimo_econ'
        ];

        $lancamentoAutomaticoAcrescimosEconomico = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['grupo_diferenca_acrescimo_econ']);

        $grupoCreditos = null;
        if (!empty($lancamentoAutomaticoAcrescimosEconomico['valor'])) {
            list($codigo, $ano) = explode('/', $lancamentoAutomaticoAcrescimosEconomico['valor']);
            $grupoCreditos = $em->getRepository(GrupoCredito::class)
                ->findOneBy(['codGrupo' => $codigo, 'anoExercicio' => $ano]);
        }

        $fieldOptions['grupo_diferenca_acrescimo_econ'] = [
            'class' => GrupoCredito::class,
            'choice_label' => 'descricao',
            'label' => 'label.configuracaoGrupoCreditos.lancamentoAutomaticoAcrescimosEconomico',
            'mapped' => false,
            'required' => true,
            'data' => $grupoCreditos,
            'attr' => ['class' => 'select2-parameters'],
            'query_builder' => function ($grupoCredito) {
                return $grupoCredito->createQueryBuilder('g')
                    ->where('g.anoExercicio = :exercicio')
                    ->setParameter('exercicio', $this->getExercicio())
                    ->orderBy('g.descricao', 'ASC');
            }
        ];

        // Parcelamento de mais de um exercício
        $info['super_simples'] = [
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
            'parametro' => 'super_simples'
        ];

        $parcelamentoMaisUmExercicio = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($info['super_simples']);

        $parcelamentoMaisUmExercicio = str_replace('}}', '', $parcelamentoMaisUmExercicio['valor']);
        $parcelamentoMaisUmExercicio = str_replace('{{', '', $parcelamentoMaisUmExercicio);
        $parcelamentoMaisUmExercicio = str_replace(' ', '', $parcelamentoMaisUmExercicio);
        $parcelamentoMaisUmExercicio = str_replace('"', '', $parcelamentoMaisUmExercicio);

        $gruposList = explode('},{', $parcelamentoMaisUmExercicio);

        $grupos = [];
        foreach ($gruposList as $valor) {
            list($cod, $exercicio) = explode(',', $valor);
            if (empty($cod) || empty($exercicio)) {
                continue;
            }
            $grupoCreditoObj = $em->getRepository(GrupoCredito::class)
                ->findOneBy(['codGrupo' => $cod, 'anoExercicio' => $exercicio]);

            $grupos[] = $grupoCreditoObj;
        }

        $fieldOptions['super_simples'] = [
            'class' => GrupoCredito::class,
            'choice_label' => 'descricao',
            'label' => 'label.configuracaoGrupoCreditos.parcelamentoMaisDeUmExercicio',
            'mapped' => false,
            'required' => true,
            'multiple' => true,
            'data' => $grupos,
            'attr' => ['class' => 'select2-parameters'],
            'query_builder' => function ($grupoCredito) {
                return $grupoCredito->createQueryBuilder('g')
                    ->where('g.anoExercicio = :exercicio')
                    ->setParameter('exercicio', $this->getExercicio())
                    ->orderBy('g.descricao', 'ASC');
            }
        ];

        $formMapper->add(
            'grupo_credito_itbi',
            'entity',
            $fieldOptions['grupo_credito_itbi']
        );

        $formMapper->add(
            'grupo_credito_iptu',
            'entity',
            $fieldOptions['grupo_credito_iptu']
        );

        $formMapper->add(
            'escrituracao_receita',
            'entity',
            $fieldOptions['escrituracao_receita']
        );

        $formMapper->add(
            'grupo_nota_avulsa',
            'entity',
            $fieldOptions['grupo_nota_avulsa']
        );

        $formMapper->add(
            'grupo_diferenca_geral',
            'entity',
            $fieldOptions['grupo_diferenca_geral']
        );

        $formMapper->add(
            'grupo_diferenca_imob',
            'entity',
            $fieldOptions['grupo_diferenca_imob']
        );

        $formMapper->add(
            'grupo_diferenca_econ',
            'entity',
            $fieldOptions['grupo_diferenca_econ']
        );

        $formMapper->add(
            'grupo_diferenca_acrescimo_geral',
            'entity',
            $fieldOptions['grupo_diferenca_acrescimo_geral']
        );

        $formMapper->add(
            'grupo_diferenca_acrescimo_imob',
            'entity',
            $fieldOptions['grupo_diferenca_acrescimo_imob']
        );

        $formMapper->add(
            'grupo_diferenca_acrescimo_econ',
            'entity',
            $fieldOptions['grupo_diferenca_acrescimo_econ']
        );

        $formMapper->add(
            'super_simples',
            'entity',
            $fieldOptions['super_simples']
        );

        $formMapper->add(
            "tipo_arrecadacao_configuracao",
            'hidden',
            array(
                'mapped' => false,
                'data' => self::ARRECADACAO_CONFIGURACAO_TIPO,
            )
        );

        $formMapper->add(
            "cod_modulo",
            'hidden',
            array(
                'mapped' => false,
                'data' => ConfiguracaoModel::MODULO_TRIBUTARIO_ARRECADACAO,
            )
        );

        $formMapper->end();

        return $formMapper;
    }

    /**
     * @param $codModulo
     * @param $formMapper
     * @return mixed
     */
    public function montaHtmlDividaAtivaConfigurarLivro($codModulo, $formMapper)
    {
        $this->setBreadCrumb($codModulo ? ['id' => $codModulo] : [], 'tributario_divida_ativa_configuracao_configurar_livro_create');
        $em = $this->modelManager->getEntityManager(Configuracao::class);
        $configuracaoModel = new ConfiguracaoModel($em);

        list($entityLivroFolha) = $configuracaoModel->getConfiguracaoLivroFolha(ConfiguracaoModel::MODULO_TRIBUTARIO_DIVIDA_ATIVA, ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_LIVRO_FOLHA, $this->getExercicio());
        $formMapper->with('label.configuracaoDividaAtiva.livro.dados');

        $formMapper
            ->add(
                'numeroInicial',
                'text',
                [
                    'mapped' => false,
                    'required' => true,
                    'label' => 'label.configuracaoDividaAtiva.livro.numeroInicialParaLivro',
                    'data' => $entityLivroFolha->numeroInicial
                ]
            )
            ->add(
                'sequenciaLivro',
                'choice',
                [
                    'label' => 'label.configuracaoDividaAtiva.livro.sequenciaLivro',
                    'choices' => ['label.configuracaoDividaAtiva.sequencial' => 'sequencial', 'label.configuracaoDividaAtiva.sequencialPorExercicio' => 'exercicio'],
                    'required' => true,
                    'mapped' => false,
                    'data' => $entityLivroFolha->sequenciaLivro,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'numeroFolhasLivro',
                'text',
                [
                    'mapped' => false,
                    'required' => true,
                    'label' => 'label.configuracaoDividaAtiva.livro.numeroFolhasLivro',
                    'data' => $entityLivroFolha->numeroFolhasLivro
                ]
            )
            ->add(
                'numeracaoFolha',
                'choice',
                [
                    'label' => 'label.configuracaoDividaAtiva.livro.numeracaoFolha',
                    'choices' => ['label.configuracaoDividaAtiva.sequencial' => 'sequencial', 'label.configuracaoDividaAtiva.livro.sequencialPorLivro' => 'exercicio'],
                    'required' => true,
                    'mapped' => false,
                    'data' => $entityLivroFolha->numeracaoFolha,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->add(
                "cod_modulo",
                'hidden',
                array(
                     'mapped' => false,
                     'data' => ConfiguracaoModel::MODULO_TRIBUTARIO_DIVIDA_ATIVA,
                 )
            )
            ->add(
                "tipo",
                'hidden',
                array(
                     'mapped' => false,
                     'data' => ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_LIVRO,
                 )
            )

        ;
        $formMapper->end();

        return $formMapper;
    }

    /**
     * @param $codModulo
     * @param $formMapper
     * @return mixed
     */
    public function montaHtmlDividaAtivaConfigurarInscricao($codModulo, $formMapper)
    {
        $this->includeJs[] = '/tributario/javascripts/dividaAtiva/configuracao/conf-inscricao.js';

        $this->setBreadCrumb($codModulo ? ['id' => $codModulo] : [], 'tributario_divida_ativa_configuracao_configurar_inscricao_create');
        $em = $this->modelManager->getEntityManager(Configuracao::class);
        $configuracaoModel = new ConfiguracaoModel($em);
        $formMapper->with('label.configuracaoDividaAtiva.inscricao.dados');

        $init = $configuracaoModel->getValoresConfigurarInscricao(ConfiguracaoModel::MODULO_TRIBUTARIO_DIVIDA_ATIVA, $this->getExercicio());
        $moedas = $configuracaoModel->findAllMoedas();
        $indicadores = $configuracaoModel->findIndicadorEconomico();

        $formMapper
            ->add(
                'utilizarValorReferencia',
                'choice',
                [
                    'label' => 'label.configuracaoDividaAtiva.inscricao.utilizarValorReferencia',
                    'choices' => ['sim' => 'Sim', 'nao' => 'Não'],
                    'required' => true,
                    'mapped' => false,
                    'data' => $init->get(ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_UTILIZAR_VALOR_REF),
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'numeroInscricao',
                'choice',
                [
                    'label' => 'label.configuracaoDividaAtiva.inscricao.numeracaoInscricao',
                    'choices' => ['label.configuracaoDividaAtiva.sequencial' => 'sequencial', 'label.configuracaoDividaAtiva.sequencialPorExercicio' => 'exercicio'],
                    'required' => true,
                    'mapped' => false,
                    'data' => $init->get(ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_NUM_INSCRICAO),
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'tipoValorReferencia',
                'choice',
                [
                    'label' => 'label.configuracaoDividaAtiva.inscricao.tipoValorReferencia',
                    'choices' => ['label.configuracaoDividaAtiva.inscricao.moeda' => 'moeda', 'label.configuracaoDividaAtiva.inscricao.indicadorEconomico' => 'indicador'],
                    'required' => true,
                    'mapped' => false,
                    'placeholder' => 'Selecione',
                    'data' => $init->get(ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_TIPO_VALOR_REF),
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'moeda',
                'choice',
                [
                    'label' => 'label.configuracaoDividaAtiva.inscricao.moedas',
                    'choices' => $moedas,
                    'mapped' => false,
                    'placeholder' => 'Selecione',
                    'data' => $init->get(ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_MOEDA_VALOR_REF),
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'indicador',
                'choice',
                [
                    'label' => 'label.configuracaoDividaAtiva.inscricao.indicadorEconomico',
                    'choices' => $indicadores,
                    'mapped' => false,
                    'placeholder' => 'Selecione',
                    'data' => $init->get(ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_INDICADOR_VALOR_REF),
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                "cod_modulo",
                'hidden',
                array(
                    'mapped' => false,
                    'data' => ConfiguracaoModel::MODULO_TRIBUTARIO_DIVIDA_ATIVA,
                )
            )
            ->add(
                "tipo",
                'hidden',
                array(
                    'mapped' => false,
                    'data' => ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO,
                )
            )
            ->end()
        ;
        $formMapper
            ->with('label.configuracaoDividaAtiva.inscricao.valorReferencia')
                ->add(
                    'valorReferencia.minMax',
                    'choice',
                    [
                        'label' => 'label.configuracaoDividaAtiva.inscricao.minMax',
                        'choices' => [
                            'label.configuracaoDividaAtiva.inscricao.minimo' => 'Mínimo',
                            'label.configuracaoDividaAtiva.inscricao.maximo' => 'Máximo'
                        ],
                        'required' => true,
                        'mapped' => false,
                        'placeholder' => 'Selecione',
                        'data' => $init->get(ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_LIMITE_VALOR_REF),
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
                ->add(
                    'valorReferencia.valorMoeda',
                    'text',
                    [
                        'mapped' => false,
                        'required' => true,
                        'label' => 'label.configuracaoDividaAtiva.inscricao.valor',
                        'data' => $init->get(ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_VALOR_REF),
                        'attr' => [
                            'class' => 'money '
                        ]
                    ]
                )
            ->end();

        return $formMapper;
    }

    /**
     * @param $codModulo
     * @param $formMapper
     */
    public function montaHtmlDividaAtivaConfigurarRemissaoAutomatica($codModulo, $formMapper)
    {
        $this->setBreadCrumb($codModulo ? ['id' => $codModulo] : [], 'tributario_divida_ativa_configuracao_configurar_remissao_automatica_create');
        $em = $this->modelManager->getEntityManager(Configuracao::class);
        $configuracaoModel = new ConfiguracaoModel($em);
        $init = $configuracaoModel->getValoresConfigurarRemissaoAutomatica(ConfiguracaoModel::MODULO_TRIBUTARIO_DIVIDA_ATIVA, $this->getExercicio());
        $formMapper->with('label.configuracaoDividaAtiva.remissaoAutomatica.dados');

        $formMapper
            ->add(
                'lancamentosAtivos',
                'choice',
                [
                    'label' => 'label.configuracaoDividaAtiva.remissaoAutomatica.lancamentosAtivos',
                    'choices' => [
                        'label.configuracaoDividaAtiva.remissaoAutomatica.verificar' => 'verificar',
                        'label.configuracaoDividaAtiva.remissaoAutomatica.desconsiderar' => 'desconsiderar'
                    ],
                    'required' => true,
                    'mapped' => false,
                    'data' => $init->get(ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_LANCAMENTO_ATIVO),
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'inscricaoAutomatica',
                'choice',
                [
                    'label' => 'label.configuracaoDividaAtiva.remissaoAutomatica.inscricaoAutomatica',
                    'choices' => [
                        'label.configuracaoDividaAtiva.remissaoAutomatica.inscreverDa' => 'sim',
                        'label.configuracaoDividaAtiva.remissaoAutomatica.naoInscreverDa' => 'nao'
                    ],
                    'required' => true,
                    'mapped' => false,
                    'data' => $init->get(ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_INSCRICAO_AUTOMATICA),
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'formaValidacaoRemissao',
                'choice',
                [
                    'label' => 'label.configuracaoDividaAtiva.remissaoAutomatica.formaValidacaoRemissao',
                    'choices' => [
                        'label.configuracaoDividaAtiva.remissaoAutomatica.todosLancamentos' => 'todos',
                        'label.configuracaoDividaAtiva.remissaoAutomatica.lancamentosValidos' => 'validos'
                    ],
                    'required' => true,
                    'mapped' => false,
                    'data' => $init->get(ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_VALIDACAO),
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'valoresLimites',
                'choice',
                [
                    'label' => 'label.configuracaoDividaAtiva.remissaoAutomatica.valoresLimites',
                    'choices' => $configuracaoModel->cmbValoresLimites($this->getContainer()->get('translator')),
                    'required' => true,
                    'mapped' => false,
                    'data' => $init->get(ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_LIMITES),
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'modalidade',
                'choice',
                [
                    'label' => 'label.configuracaoDividaAtiva.remissaoAutomatica.modalidade',
                    'choices' => $configuracaoModel->getModalidade(),
                    'required' => true,
                    'mapped' => false,
                    'placeholder' => 'Selecione',
                    'data' => $init->get(ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_MOD_INSCRICAO_AUTOMATICA),
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                "cod_modulo",
                'hidden',
                array(
                    'mapped' => false,
                    'data' => ConfiguracaoModel::MODULO_TRIBUTARIO_DIVIDA_ATIVA,
                )
            )
            ->add(
                "tipo",
                'hidden',
                array(
                    'mapped' => false,
                    'data' => ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA,
                )
            )
            ->end()
        ;
    }

    /**
     * @param $codModulo
     * @param $formMapper
     */
    public function montaHtmlDividaAtivaConfigurarDocumentos($codModulo, $formMapper)
    {
        $this->includeJs[] = '/tributario/javascripts/dividaAtiva/configuracao/conf-documentos.js';
        $this->setBreadCrumb($codModulo ? ['id' => $codModulo] : [], 'tributario_divida_ativa_configuracao_configurar_documentos_create');
        $em = $this->modelManager->getEntityManager(Configuracao::class);
        $configuracaoModel = new ConfiguracaoModel($em);

        $formMapper->with('label.configuracaoDividaAtiva.documentos.dados');
        $formMapper
            ->add(
                'documentos',
                'choice',
                [
                    'label' => 'label.configuracaoDividaAtiva.documentos.documentos',
                    'choices' => $configuracaoModel->stDocumento($this->getContainer()->get('translator')),
                    'required' => true,
                    'mapped' => false,
                    'placeholder' => 'Selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'secretaria',
                'text',
                [
                    'mapped' => false,
                    'required' => true,
                    'label' => 'label.configuracaoDividaAtiva.documentos.secretaria'
                ]
            )
            ->add(
                'setorArrecadacao',
                'text',
                [
                    'mapped' => false,
                    'required' => true,
                    'label' => 'label.configuracaoDividaAtiva.documentos.setorArrecadacao'
                ]
            )
            ->add(
                'coordenador',
                'textarea',
                [
                    'mapped' => false,
                    'required' => true,
                    'label' => $this->getContainer()->get('translator')->transChoice('label.configuracaoDividaAtiva.documentos.responsavel', 0, ['numero' => 1], 'messages')
                ]
            )
            ->add(
                'chefeDepartamento',
                'textarea',
                [
                    'mapped' => false,
                    'label' => $this->getContainer()->get('translator')->transChoice('label.configuracaoDividaAtiva.documentos.responsavel', 0, ['numero' => 2], 'messages')
                ]
            )
            ->add(
                'mensagem',
                'textarea',
                [
                    'mapped' => false,
                    'label' => 'label.configuracaoDividaAtiva.documentos.mensagem'
                ]
            )
            ->add(
                "cod_modulo",
                'hidden',
                array(
                    'mapped' => false,
                    'data' => ConfiguracaoModel::MODULO_TRIBUTARIO_DIVIDA_ATIVA,
                )
            )
            ->add(
                "tipo",
                'hidden',
                array(
                    'mapped' => false,
                    'data' => ConfiguracaoModel::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS,
                )
            )
            ->add(
                'metodologiaCalculo',
                'textarea',
                [
                    'mapped' => false,
                    'label' => 'label.configuracaoDividaAtiva.documentos.metodologiaCalculo',
                    'attr' => [
                        'class' => 'campo-extra ce-1 '
                    ]
                ]
            )
            ->add(
                'leiMunicipalCertidaoDA',
                'text',
                [
                    'mapped' => false,
                    'label' => 'label.configuracaoDividaAtiva.documentos.leiMunicipalCertidaoDA',
                    'attr' => [
                        'class' => 'campo-extra ce-2 '
                    ]
                ]
            )
            ->add(
                'incidenciaSobreValorDebitoDA',
                'choice',
                [
                    'label' => 'label.configuracaoDividaAtiva.documentos.incidenciaSobreValorDebitoDA',
                    'choices' => ['sim'=> '1', 'nao' => '0'],
                    'mapped' => false,
                    'attr' => [
                        'class' => 'select2-parameters campo-extra ce-3 '
                    ]
                ]
            )
            ->end()
        ;
    }

    /**
     * @param $codTipoReceita
     * @return array
     */
    protected function getPosicaoReceita($codTipoReceita)
    {
        $tipoContaReceita = $this->getDoctrine()->getRepository(TipoContaReceita::class)->findOneByDescricao($codTipoReceita);

        $posicaoReceitaRepository = $this->getDoctrine()->getRepository(PosicaoReceita::class);
        $posicaoReceitas = $posicaoReceitaRepository->findBy(
            array('exercicio' => $this->getExercicio(), 'codTipo' => $tipoContaReceita),
            array('codPosicao' => 'ASC')
        );
        return array($tipoContaReceita, $posicaoReceitas);
    }

    /**
     * @param $info
     */
    protected function regraPosicaoDespesa($info)
    {
        $posicaoDespesa = $this->getDoctrine()->getRepository(PosicaoDespesa::class)->findByExercicio($this->getExercicio());
        $configuracaoModel = new ConfiguracaoModel($this->getEntityManager());
        if (empty($posicaoDespesa)) {
            if (!empty($info['valor'])) {
                $configuracaoModel->savePosicaoDespesa($info['valor'], $this->getExercicio());
            }
        } else {
            $mascara = MascaraHelper::parseMascara($posicaoDespesa);
            if ($mascara != $info['valor']) {
                $classificaocaoDespesa = $this->getDoctrine()->getRepository(ContaDespesa::class)->getClassificacaoDespesa($this->getExercicio());
                $aux = true;
                if (!empty($classificaocaoDespesa)) {
                    foreach ($classificaocaoDespesa as $contaDespesa) {
                        $string = preg_replace('/[0-9]/', '9', $contaDespesa['mascara_classificacao']);
                        if ($string === $mascara) {
                            $this->getContainer()->get('session')->getFlashBag()->add('error', sprintf('%s %s', $this->getContainer()->get('translator')->transChoice('label.classificacaoDespesa.message.existeClassificacoesDespesa', 0, [], 'messages'), $mascara));
                            $info['valor'] = '';
                            $aux = false;
                            break;
                        }
                    }
                }
                if ($aux) {
                    foreach ($posicaoDespesa as $posicao) {
                        $configuracaoModel->remove($posicao, true);
                    }
                    $configuracaoModel->savePosicaoDespesa($info['valor'], $this->getExercicio());
                }
            }
        }
    }

    /**
     * @param $posicaoReceitas
     * @param $tipoContaReceita
     * @param $info
     * @return array
     */
    protected function regraPosicaoReceita($posicaoReceitas, $tipoContaReceita, $info, $message)
    {
        $configuracaoModel = new ConfiguracaoModel($this->getEntityManager());
        if (empty($posicaoReceitas)) {
            if (!empty($info['valor'])) {
                $configuracaoModel->savePosicaoReceita($info['valor'], $tipoContaReceita, $this->getExercicio());
            }
        } else {
            $mascara = MascaraHelper::parseMascara($posicaoReceitas);
            if ($mascara != $info['valor']) {
                $contasReceita = $this->getDoctrine()->getRepository(ContaReceita::class)->findAllReceita($this->getExercicio(), '9', true);
                $aux = true;
                if (!empty($contasReceita)) {
                    foreach ($contasReceita as $contaReceita) {
                        $string = preg_replace('/[0-9]/', '9', $contaReceita->getcodEstrutural());
                        if ($string === $mascara) {
                            $this->getContainer()->get('session')->getFlashBag()->add('error', sprintf('%s %s', $this->getContainer()->get('translator')->transChoice($message, 0, [], 'messages'), $mascara));
                            $info['valor'] = '';
                            $aux = false;
                            break;
                        }
                    }
                }
                if ($aux) {
                    foreach ($posicaoReceitas as $posicaoReceita) {
                        $configuracaoModel->remove($posicaoReceita, true);
                    }
                    $configuracaoModel->savePosicaoReceita($info['valor'], $tipoContaReceita, $this->getExercicio());
                }
            }
        }
        return $info;
    }
}
