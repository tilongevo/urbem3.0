<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Ima;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Entity\Pessoal\Regime;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Model\Ima\ExportarDirfModel;
use Urbem\CoreBundle\Repository\RecursosHumanos\Ima\ExportarDirfRepository;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf;
use Urbem\CoreBundle\Helper\StringHelper;
use Doctrine\ORM\EntityManager;

class ExportarArquivoDirfAdmin extends AbstractAdmin
{
 
    const REPORT_TIPO_CGMCONTRATO = 'cgm_contrato_todos';
    const REPORT_TIPO_LOTACAO = 'lotacao';
    const REPORT_TIPO_LOCAL = 'local';
    const REPORT_TIPO_ATTRSERVIDOR = 'atributo_servidor';
    const REPORT_TIPO_ATTRPENSIONISTA = 'atributo_pensionista';
    const REPORT_TIPO_REGSUBFUNESP = 'reg_sub_fun_esp';
    const REPORT_TIPO_GERAL = 'geral';
    
    const DECLARACAO_TIPO_NORMAL = 0;
    const DECLARACAO_TIPO_RETIFICADORA = 1;
    
    protected $baseRouteName = 'urbem_recursos_humanos_informacoes_configuracao_dirf';
    protected $baseRoutePattern = 'recursos-humanos/informacoes/configuracao/dirf';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar'];
    protected $includeJs = [
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/recursoshumanos/javascripts/pessoal/gerar-dirf.js'
    ];
    
    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create']);
        $collection->add('subdivisao_por_regime', 'subdivisao-por-regime');
        $collection->add('cargos_por_subdivisao', 'cargos-por-subdivisao');
        $collection->add('especialidade_por_cargo', 'especialidade-por-cargo');
        $collection->add('detalhes', 'detalhes');
        $collection->add('download', 'download');
    }
    
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        
        $fieldOptions = [];
        
        $tipoRelatorio = [
            'label.exportarDirf.tipoFiltroOpcoes.geral' => self::REPORT_TIPO_GERAL,
            'label.exportarDirf.tipoFiltroOpcoes.cgmMatricula' => self::REPORT_TIPO_CGMCONTRATO,
            'label.exportarDirf.tipoFiltroOpcoes.lotacao' => self::REPORT_TIPO_LOTACAO,
            'label.exportarDirf.tipoFiltroOpcoes.local' => self::REPORT_TIPO_LOCAL,
            'label.exportarDirf.tipoFiltroOpcoes.attrDinamicoServidor' => self::REPORT_TIPO_ATTRSERVIDOR,
            'label.exportarDirf.tipoFiltroOpcoes.attrDinamicoPensionista' => self::REPORT_TIPO_ATTRPENSIONISTA,
            'label.exportarDirf.tipoFiltroOpcoes.regSubFunEsp' => self::REPORT_TIPO_REGSUBFUNESP
        ];
        
        $fieldOptions['tipo'] = [
            'mapped' => false,
            'required' => true,
            'data' => 'label.selecione',
            'choices' => $tipoRelatorio,
            'label' => 'label.exportarDirf.tipoFiltro',
            'attr' => [
                'class' => 'select2-parameters '
            ],
        ];
        
        $em = $this->getEntityManager();
        
        $this->_buildFieldsFiltro($em, $fieldOptions);
        
        $anoAtual = intval(date('Y'));
        $anos = [];
        
        for ($anoAux = 1970; $anoAux <= $anoAtual; $anoAux++) {
            $anos[$anoAux] = $anoAux;
        }
        
        $fieldOptions['ano'] = [
            'mapped' => false,
            'required' => true,
            'data' => $anoAtual-1,
            'choices' => $anos,
            'label' => 'label.exportarDirf.tipoFiltro',
            'attr' => [
                'class' => 'select2-parameters '
            ],
        ];
        
        $tiposDeclaracao = [
            'label.exportarDirf.declaracaoOpcoes.normal' => self::DECLARACAO_TIPO_NORMAL,
            'label.exportarDirf.declaracaoOpcoes.retificadora' => self::DECLARACAO_TIPO_RETIFICADORA,
        ];
        
        $fieldOptions['declaracao'] = [
            'mapped' => false,
            'required' => true,
            'choices' => $tiposDeclaracao,
            'data' => self::DECLARACAO_TIPO_NORMAL,
            'label' => 'label.exportarDirf.tipoDeclaracao',
            'expanded'   => true,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr'       => ['class' => 'checkbox-sonata']
        ];
        
        $fieldOptions['adcPrestadorServico'] = [
            "label" => "label.exportarDirf.adcPrestadorServico",
            'mapped' => false,
            'required' => false,
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr'       => ['class' => 'checkbox-sonata ']
        ];
        
        $fieldOptions['infoTodos'] = [
            "label" => "label.exportarDirf.infoTodos",
            'mapped' => false,
            'required' => false,
            'attr' => ['disabled' => true]
        ];
        $fieldOptions['regSubCarEspStr'] = [
            "data" => "",
            "mapped" => false
        ];
        
        $formMapper
            ->with('label.exportarDirf.titulo')
                ->add('tipoRelatorio', 'choice', $fieldOptions['tipo'])
                ->add('ano', 'choice', $fieldOptions['ano'])
                ->add('tipoDeclaracao', 'choice', $fieldOptions['declaracao'])
                ->add('adcPrestadorServico', 'checkbox', $fieldOptions['adcPrestadorServico'])
                ->add('infoTodos', CheckboxType::class, $fieldOptions['infoTodos'])
                ->add('cgmMatricula', 'autocomplete', $fieldOptions['cgmMatricula'])
                ->add('lotacao', 'choice', $fieldOptions['lotacao'])
                ->add('local', 'entity', $fieldOptions['local'])
                ->add('atributoDinamicoServidor', 'customField', $fieldOptions['atributoDinamicoServidor'])
                ->add('atributoDinamicoPensionista', 'customField', $fieldOptions['atributoDinamicoPensionista'])
                ->add('atributosDinamicos', 'customField', $fieldOptions['atributosDinamicos'])
                ->add('regime', 'choice', $fieldOptions['regime'])
                ->add('subDivisao', 'choice', $fieldOptions['subDivisao'])
                ->add('cargo', 'choice', $fieldOptions['cargo'])
                ->add('especialidade', 'choice', $fieldOptions['especialidade'])
                ->add('regSubCarEspStr', 'hidden', $fieldOptions['regSubCarEspStr'])
            ->end()
        ;
    }
    
    public function prePersist($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        
        $form = $this->getForm();
        
        $params = [
            'tipoRelatorio' => $this->_getFromField($form, 'tipoRelatorio'),
            'ano' => intval($this->_getFromField($form, 'ano')),
            'tipoDeclaracao' => $this->_getFromField($form, 'tipoDeclaracao'),
            'adcPrestadorServico' => $this->_getFromField($form, 'adcPrestadorServico'),
            'infoTodos' => $this->_getFromField($form, 'infoTodos')
        ];
        
        $this->_getFiltros($form, $params);
        
        $anoExercicio = $params['ano'];
        
        $entidade = $this->getEntidade();
        $entidadeStr = "";
        $codEntidade = $entidade->getCodEntidade();
        $exportarDirf = new ExportarDirfModel($em);
        
        $configWhere = ["exercicio = :exercicio"];
        $configParam = [":exercicio" => $params['ano']];
        
        $dirfConfig = $exportarDirf->getRelacionamento($configWhere, $configParam);
        
        if (empty($dirfConfig)) {
            $this->redirectByRoute('urbem_recursos_humanos_informacoes_configuracao_dirf_detalhes', ['errConfigDirf' => $params['ano']]);
            die();
        }
            
        if ($dirfConfig['pagamento_mes_competencia']) {
            $result = $exportarDirf->exportarDirfPagamento(
                $entidadeStr,
                $params['ano'],
                ($params['ano']-1),
                $params['tipoRelatorio'],
                $params['codigos']
                );
        } else {
            $result = $exportarDirf->exportarDirf(
                $entidadeStr,
                $params['ano'],
                $params['tipoRelatorio'],
                $params['codigos']
                );
        }
        
        if ($params['adcPrestadorServico']) {
            if ($dirfConfig['pagamento_mes_competencia']) {
                if ($params['infoTodos']) {
                    $funcao = ExportarDirfRepository::BD_FUNCTION_DIRF_PRESTADORES_REDUZIDA_PAGAMENTOS;
                } else {
                    $funcao = ExportarDirfRepository::BD_FUNCTION_DIRF_PRESTADORES_REDUZIDA;
                }
                $result2 = $exportarDirf->exportarPorFuncao($funcao, $entidadeStr, $codEntidade, $anoExercicio);
            } else {
                $result2 = $exportarDirf->exportarDirfPrestadores($entidadeStr, $codEntidade, $params['ano'], ($params['ano']-1));
            }
        } else {
            $result2 = [];
        }
        
        $header = $this->_montarHeader($em, $entidade, $params['ano'], $dirfConfig['cod_natureza']);
        
        $filename = $this->_montarDirf($entidadeStr, $params, $header, $result, $result2);
        
        $hash = base64_encode($filename);
        $this->forceRedirect('detalhes?fs='.$hash);
    }
    
    /**
     * @param EntityManager $em
     * @param Array $fieldOptions
     */
    private function _buildFieldsFiltro($em, &$fieldOptions)
    {
        $fieldOptions['cgmMatricula'] = array(
            'label' => 'label.cgmmatricula',
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato_nao_rescindido'
            ],
            'multiple' => true,
            'required' => false,
            'json_choice_label' => function ($contrato) use ($em) {
            if (!is_null($contrato->getFkPessoalContratoServidor())) {
                $nomcgm = $contrato->getFkPessoalContratoServidor()
                ->getFkPessoalServidorContratoServidores()->last()
                ->getFkPessoalServidor()
                ->getFkSwCgmPessoaFisica()
                ->getFkSwCgm()
                ->getNomcgm();
            } else {
                $nomcgm = "Não localizado";
            }
            return $nomcgm;
            },
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom'
            ],
            'mapped' => false
            );
        
        $organogramaModel = new OrganogramaModel($em);
        $orgaoModel = new OrgaoModel($em);
        
        $resOrganograma = $organogramaModel->getOrganogramaVigentePorTimestamp();
        $codOrganograma = $resOrganograma['cod_organograma'];
        $dataFinal = $resOrganograma['dt_final'];
        $lotacoes = $orgaoModel->montaRecuperaOrgaos($dataFinal, $codOrganograma);
        
        $lotacaoArray = [];
        foreach ($lotacoes as $lotacao) {
            $key = $lotacao->cod_orgao;
            $value = $lotacao->cod_estrutural . " - " . $lotacao->descricao;
            $lotacaoArray[$value] = $key;
        }
        
        $fieldOptions['lotacao'] = array(
            'label' => 'label.exportarDirf.tipoFiltroOpcoes.lotacao',
            'required' => false,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom',
            ],
            'choices' => $lotacaoArray,
            'expanded' => false,
            'multiple' => true
        );
        
        $fieldOptions['local'] = array(
            'class' => Local::class,
            'label' => 'label.exportarDirf.tipoFiltroOpcoes.local',
            'required' => false,
            'mapped' => false,
            'data' => array_flip($lotacaoArray),
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom'
            ],
            'expanded' => false,
            'multiple' => true
        );
        
        $regimes = $em->getRepository(Regime::class)->findAll();
        $regimesArray = [];
        foreach ($regimes as $regime) {
            $regimesArray[$regime->getCodRegime() . " - " . $regime->getDescricao()] = $regime->getCodRegime();
        }
        
        $fieldOptions['regime'] = array(
            'choices' => $regimesArray,
            'label' => 'label.exportarDirf.regime',
            'expanded' => false,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom'
            ],
            'mapped' => false,
            'required' => false,
            'multiple' => true,
        );
        
        $fieldOptions['atributoDinamicoServidor'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/atributos_dinamicos.html.twig',
            'data' => [],
        ];
        
        $fieldOptions['atributoDinamicoPensionista'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/atributos_dinamicos.html.twig',
            'data' => [],
        ];
        
        $fieldOptions['atributosDinamicos'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/atributos_dinamicos.html.twig',
            'data' => [],
        ];
        
        $fieldOptions['subDivisao'] = array(
            'choices' => [],
            'label' => 'label.exportarDirf.subdivisao',
            'expanded' => false,
            'required' => false,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom', 'style' => "width: 100%"],
            'mapped' => false,
            'multiple' => true,
        );
        
        $fieldOptions['cargo'] = array(
            'choices' => [],
            'label' => 'label.exportarDirf.funcao',
            'expanded' => false,
            'required' => false,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom', 'style' => "width: 100%"],
            'mapped' => false,
            'multiple' => true,
        );
        
        $fieldOptions['especialidade'] = array(
            'choices' => [],
            'label' => 'label.exportarDirf.especialidade',
            'expanded' => false,
            'required' => false,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom', 'style' => "width: 100%"],
            'mapped' => false,
            'multiple' => true,
        );
    }
    
    /**
     * @param FormMapper $form
     * @param Array $params
     */
    private function _getFiltros($form, &$params)
    {
        switch ($params['tipoRelatorio']) {
            case 'cgm_contrato_todos':
                $params['cgmMatricula'] = $this->_getFromField($form, 'cgmMatricula');
                if (is_array($params['cgmMatricula'])) {
                    $params['codigos'] = implode(",", $params['cgmMatricula']);
                } else {
                    $params['codigos'] = "";
                }
                break;
            case 'lotacao':
                $params['lotacao'] = $this->_getFromField($form, 'lotacao');
                if (is_array($params['lotacao'])) {
                    $aux = [];
                    foreach ($params['lotacao'] as $lotacao) {
                        $aux[] = $lotacao;
                    }
                    $params['codigos'] = implode(",", $aux);
                } else {
                    $params['codigos'] = "";
                }
                break;
            case 'local':
                $params['local'] = $this->_getFromField($form, 'local');
                if (is_array($params['local'])) {
                    $aux = [];
                    foreach ($params['local'] as $local) {
                        $aux[] = $local->getCodLocal();
                    }
                    $params['codigos'] = implode(",", $aux);
                } else {
                    $params['codigos'] = "";
                }
                break;
            case 'atributo_servidor':
            case 'atributo_pensionista':
                $valor = "";
                $codAtributo = 0;
                foreach ($form->get('atributosDinamicos')->getData() as $key => $attr) {
                    $val = current($attr);
                    if (!empty($val)) {
                        $valor = $val;
                        $codAtributo = $key;
                        break;
                    }
                }
                $isArray = is_array($valor);
                if ($isArray) {
                    $attrValorStr = implode(",", $valor);
                } else {
                    $attrValorStr = pg_escape_string($valor);
                }
                $params['codigos'] = $isArray."#".$codAtributo."#".$attrValorStr;
                break;
            case 'reg_sub_fun_esp':
                $codigoStr = $this->_getFromField($form, 'regSubCarEspStr');
                if (is_null($codigoStr)) {
                    $codigoStr = "";
                }
                $params['codigos'] = $codigoStr;
                break;
            default:
                $params['codigos'] = '';
                break;
        }
    }
    
    /**
     * @param string $entidade
     * @param array $params
     * @param array $header
     * @param array $body1
     * @param array $body2
     * @return string
     */
    private function _montarDirf($entidade, $params, $header, $body1, $body2)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $exportarDirf = new ExportarDirfModel($em);
        
        $dirfPags = $exportarDirf->getTodosPlanos(['exercicio = :exercicio'], [':exercicio' => $params['ano']]);
        
        $hasPlano = !empty($dirfPags)?'S':'N';
        $isRetificadora = $params['tipoDeclaracao'] == self::DECLARACAO_TIPO_RETIFICADORA?'S':'N';
        
        $filename = 'DIRF.txt';
        
        $file = fopen('/tmp/' . $filename, 'w');
        
        $auxLinha = 'Dirf|2016|'.$header['ano_calendario'].'|'.$isRetificadora.'|'.$header['numero_recibo'].'|L35QJS2|'."\n";
        fputs($file, $auxLinha);
        
        $stNomeResponsavel = StringHelper::removeSpecialCharacter($header['nome_responsavel'], TRUE, FALSE);
        $auxLinha = 'RESPO|'.str_pad($header['cpf_responsavel'], 11, 0, STR_PAD_LEFT).'|'.$stNomeResponsavel.'|'.
            str_pad($header['ddd_responsavel'],0,0,STR_PAD_LEFT).'|'.str_pad($header['fone_responsavel'], 8, 0, STR_PAD_LEFT).'|'.
            $header['ramal_responsavel'].'|'.str_pad($header['fax_responsavel'], 8, 0, STR_PAD_LEFT).'|'.
            $header['email_responsavel']."|\n";
        fputs($file, $auxLinha);
        
        $auxLinha = 'DECPJ|'.str_pad($header['cnpj_declarante'], 14, 0, STR_PAD_LEFT).'|'.$header['nome_empresarial'].'|2|'.
            str_pad($header['cpf_responsavel_prefeitura'], 11, 0, STR_PAD_LEFT)."|N|N|N|N|".$hasPlano."|N|N|N||\n";
        fputs($file, $auxLinha);
        
        
        $cpfs = [];
        
        $this->_writeBody($file, $body1, $cpfs, $params);
        
        $this->_writeBodyAdc($file, $body2, $params);
        
        $this->_writeAdcPlanosSaude($file, $exportarDirf, $cpfs, $params, $entidade);
        
        
        fputs($file, 'FIMDirf|');
        fclose($file);
        
        return $filename;
    }
    
    /**
     * @param EntityManager $em
     * @param string $entidade
     * @param int $anoCompetencia
     * @param int $codNatureza
     * @return array
     */
    private function _montarHeader($em, $entidade, $anoCompetencia, $codNatureza)
    {
        $configDirfRepo = $em->getRepository(ConfiguracaoDirf::class);
        
        $configDirf = $configDirfRepo->findOneBy(['responsavelEntrega' => $entidade->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNumcgm()]);
        
        return [
            "sequencia" => 1,
            "tipo" => "1",
            "cnpj_declarante" => $entidade->getFkSwCgm()->getFkSwCgmPessoaJuridica()->getCnpj(),
            "nome_arquivo" => "Dirf",
            "ano_calendario" => $anoCompetencia,
            "or" => 'indicador',
            "situacao_declaracao" => "1",
            "tipo_declarante" => "2",
            "natureza_declarante" => $configDirf->getCodNatureza(),
            "tipo_rendimento" => "0",
            "ano_referencia" => "2010",
            "indicador_declarante" => "0",
            "filer1" => ($anoCompetencia >= 2007 and $anoCompetencia <= 2010)?'0':'',
            "nome_empresarial" => $entidade->getFkSwCgm()->getNomCgm(),
            "cpf_responsavel_prefeitura" => $configDirf->getFkSwCgm()->getFkSwCgmPessoaFisica()->getCpf(),
            "data_evento" => "",
            "tipo_evento" => "",
            "filer2" => "",
            "numero_recibo" => '',
            "filer3" => "",
            "cpf_responsavel" => $entidade->getFkSwCgmPessoaFisica()->getCpf(),
            "nome_responsavel" => $entidade->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomCgm(),
            "ddd_responsavel" => substr($configDirf->getTelefone(), 0, 2),
            "fone_responsavel" => substr($configDirf->getTelefone(), 2),
            "ramal_responsavel" => $configDirf->getRamal(),
            "fax_responsavel" => $configDirf->getFax(),
            "email_responsavel" => $configDirf->getEmail(),
            "uso_srf" => "",
            "uso_declarante" => "",
            "uso_declarante2" => "9"
        ];
    }
    
    /**
     * @param resource $file
     * @param array $body
     * @param array $cpfs
     * @param array $params
     */
    private function _writeBody(&$file, &$body, &$cpfs, $params)
    {
        if (count($body)) {
            usort($body, function($x, $y){
                return $x['beneficiario'] < $y['beneficiario']?-1:1;
            });
                $auxLinha = "IDREC|0561|\n";
                fputs($file, $auxLinha);
                $beneficiario = '';
        }
        
        foreach ($body as $row) {
            $cpfs[] = $row['beneficiario'];
            
            if ($beneficiario != $row['beneficiario']) {
                $auxLinha = 'BPFDEC|'.str_pad($row['beneficiario'], 11, 0, STR_PAD_LEFT).'|'.rtrim(str_replace('.','',$row['nome_beneficiario']))."||\n";
                fputs($file, $auxLinha);
            }
            
            $beneficiario = $row['beneficiario'];
            
            if ($row['ident_especializacao'] == 0) {
                $linhaRTRT = 'RTRT|'.substr($row['jan'], 0, 13).'|'.substr($row['fev'], 0, 13).'|'.
                    substr($row['mar'], 0, 13).'|'.substr($row['abr'], 0, 13).'|'.
                    substr($row['mai'], 0, 13).'|'.substr($row['jun'], 0, 13).'|'.
                    substr($row['jul'], 0, 13).'|'.substr($row['ago'], 0, 13).'|'.
                    substr($row['set'], 0, 13).'|'.substr($row['out'], 0, 13).'|'.
                    substr($row['nov'], 0, 13).'|'.substr($row['dez'], 0, 13).'|'.
                    substr($row['dec'], 0, 13)."|\n";
                    if( $this->_doWrite($linhaRTRT) ) fputs($file, $linhaRTRT);
                    
                    $linhaRTIRF = 'RTIRF|'.substr($row['jan'], 26, 13).'|'.substr($row['fev'], 26, 13).'|'.
                        substr($row['mar'], 26, 13).'|'.substr($row['abr'], 26, 13).'|'.
                        substr($row['mai'], 26, 13).'|'.substr($row['jun'], 26, 13).'|'.
                        substr($row['jul'], 26, 13).'|'.substr($row['ago'], 26, 13).'|'.
                        substr($row['set'], 26, 13).'|'.substr($row['out'], 26, 13).'|'.
                        substr($row['nov'], 26, 13).'|'.substr($row['dez'], 26, 13).'|'.
                        substr($row['dec'], 26, 13)."|\n";
                        if( $this->_doWrite($linhaRTIRF) ) fputs($file, $linhaRTIRF);
                        
            } elseif ($row['ident_especializacao'] == 1) {
                $linhaRTPO = 'RTPO|'.substr($row['jan'], 0, 13).'|'.substr($row['fev'], 0, 13).'|'.
                    substr($row['mar'], 0, 13).'|'.substr($row['abr'], 0, 13).'|'.
                    substr($row['mai'], 0, 13).'|'.substr($row['jun'], 0, 13).'|'.
                    substr($row['jul'], 0, 13).'|'.substr($row['ago'], 0, 13).'|'.
                    substr($row['set'], 0, 13).'|'.substr($row['out'], 0, 13).'|'.
                    substr($row['nov'], 0, 13).'|'.substr($row['dez'], 0, 13).'|'.
                    substr($row['dec'], 0, 13)."|\n";
                    if( $this->_doWrite($linhaRTPO) ) fputs($file, $linhaRTPO);
                    
                $linhaRTDP = 'RTDP|'.substr($row['jan'], 13, 13).'|'.substr($row['fev'], 13, 13).'|'.
                    substr($row['mar'], 13, 13).'|'.substr($row['abr'], 13, 13).'|'.
                    substr($row['mai'], 13, 13).'|'.substr($row['jun'], 13, 13).'|'.
                    substr($row['jul'], 13, 13).'|'.substr($row['ago'], 13, 13).'|'.
                    substr($row['set'], 13, 13).'|'.substr($row['out'], 13, 13).'|'.
                    substr($row['nov'], 13, 13).'|'.substr($row['dez'], 13, 13).'|'.
                    substr($row['dec'], 13, 13)."|\n";
                if( $this->_doWrite($linhaRTDP) ) fputs($file, $linhaRTDP);
                    
                $linhaRTPA = 'RTPA|'.substr($row['jan'], 26, 13).'|'.substr($row['fev'], 26, 13).'|'.
                    substr($row['mar'], 26, 13).'|'.substr($row['abr'], 26, 13).'|'.
                    substr($row['mai'], 26, 13).'|'.substr($row['jun'], 26, 13).'|'.
                    substr($row['jul'], 26, 13).'|'.substr($row['ago'], 26, 13).'|'.
                    substr($row['set'], 26, 13).'|'.substr($row['out'], 26, 13).'|'.
                    substr($row['nov'], 26, 13).'|'.substr($row['dez'], 26, 13).'|'.
                    substr($row['dec'], 26, 13)."|\n";
                if( $this->_doWrite($linhaRTPA) ) fputs($file, $linhaRTPA);
            }
            
        }
    }
    
    /**
     * @param resource $file
     * @param array $body
     * @param array $params
     */
    private function _writeBodyAdc(&$file, &$body, $params)
    {
        if ($params['adcPrestadorServico']) {
            $retencao = null;
            $beneficiario = '0';
            usort($body, function($x, $y){
                return $x['beneficiario'] < $y['beneficiario']?-1:1;
            });
                
            foreach ($body as $row) {
                if ( $beneficiario != $row['beneficiario'] ) {
                    if ( $row['ident_especie_beneficiario'] == '1' ) {
                        $beneficiario = str_pad(ltrim($row['beneficiario'], 0), 11, 0, STR_PAD_LEFT);
                        $tag = 'BPFDEC';
                    } elseif ( $row['ident_especie_beneficiario'] == '2') {
                        $beneficiario = str_pad($row['beneficiario'], 14, 0, STR_PAD_LEFT);
                        $tag = 'BPJDEC';
                    }
                    if ($row['codigo_retencao'] == '1708' ) {
                        
                        $linha = $tag.'|'.$beneficiario.'|'.rtrim(str_replace('.','',$row['nome_beneficiario']))."|\n";
                    } else {
                        $linha = $tag.'|'.$beneficiario.'|'.rtrim(str_replace('.','',$row['nome_beneficiario']))."||\n";
                    }
                    
                    fputs($file, $linha);
                }
                
                if ( $retencao != $row['codigo_retencao'] ) {
                    $linha = 'IDREC|'.str_pad($row['codigo_retencao'], 4, 0, STR_PAD_LEFT)."|\n";
                    fputs($file, $linha);
                }
                
                $beneficiario = $row['beneficiario'];
                $retencao = $row['codigo_retencao'];
                
                if ( $row['ident_especializacao'] == 0 ) {
                    $linhaRTRT = 'RTRT|'.substr($row['jan'], 0, 13).'|'.substr($row['fev'], 0, 13).'|'.
                        substr($row['mar'], 0, 13).'|'.substr($row['abr'], 0, 13).'|'.
                        substr($row['mai'], 0, 13).'|'.substr($row['jun'], 0, 13).'|'.
                        substr($row['jul'], 0, 13).'|'.substr($row['ago'], 0, 13).'|'.
                        substr($row['set'], 0, 13).'|'.substr($row['out'], 0, 13).'|'.
                        substr($row['nov'], 0, 13).'|'.substr($row['dez'], 0, 13).'|';
                    if ( $row['codigo_retencao'] == '1708' ) {
                        $linhaRTRT .= "|\n";
                    } else {
                        $linhaRTRT .= substr($row['dec'], 0, 13)."|\n";
                    }
                    if( $this->_doWrite($linhaRTRT) ) fputs($file, $linhaRTRT);
                    
                    if ( $row['codigo_retencao'] != '1708' ) {
                        $linhaRTPO = 'RTPO|'.substr($row['jan'], 13, 13).'|'.substr($row['fev'], 13, 13).'|'.
                            substr($row['mar'], 13, 13).'|'.substr($row['abr'], 13, 13).'|'.
                            substr($row['mai'], 13, 13).'|'.substr($row['jun'], 13, 13).'|'.
                            substr($row['jul'], 13, 13).'|'.substr($row['ago'], 13, 13).'|'.
                            substr($row['set'], 13, 13).'|'.substr($row['out'], 13, 13).'|'.
                            substr($row['nov'], 13, 13).'|'.substr($row['dez'], 13, 13).'|'.
                            substr($row['dec'], 13, 13)."|\n";
                        if( $this->_doWrite($linhaRTPO) ) fputs($file, $linhaRTPO);
                    }
                    
                    $linhaRTIRF = 'RTIRF|'.substr($row['jan'], 26, 13).'|'.substr($row['fev'], 26, 13).'|'.
                        substr($row['mar'], 26, 13).'|'.substr($row['abr'], 26, 13).'|'.
                        substr($row['mai'], 26, 13).'|'.substr($row['jun'], 26, 13).'|'.
                        substr($row['jul'], 26, 13).'|'.substr($row['ago'], 26, 13).'|'.
                        substr($row['set'], 26, 13).'|'.substr($row['out'], 26, 13).'|'.
                        substr($row['nov'], 26, 13).'|'.substr($row['dez'], 26, 13).'|';
                    if ( $row['codigo_retencao'] == '1708' ) {
                        $linhaRTIRF.= "|\n";
                    } else {
                        $linhaRTIRF .= substr($row['dec'], 26, 13)."|\n";
                    }
                    
                    if( $this->_doWrite($linhaRTIRF) ) fputs($file, $linhaRTIRF);
                            
                } elseif ( $row['ident_especializacao'] == 1 ) {
                    $linhaRTDP = 'RTDP|'.substr($row['jan'], 13, 13).'|'.substr($row['fev'], 13, 13).'|'.
                        substr($row['mar'], 13, 13).'|'.substr($row['abr'], 13, 13).'|'.
                        substr($row['mai'], 13, 13).'|'.substr($row['jun'], 13, 13).'|'.
                        substr($row['jul'], 13, 13).'|'.substr($row['ago'], 13, 13).'|'.
                        substr($row['set'], 13, 13).'|'.substr($row['out'], 13, 13).'|'.
                        substr($row['nov'], 13, 13).'|'.substr($row['dez'], 13, 13).'|'.
                        substr($row['dec'], 13, 13)."|\n";
                    if( $this->_doWrite($linhaRTDP) ) fputs($file, $linhaRTDP);
                    
                    $linhaRTPA = 'RTPA|'.substr($row['jan'], 26, 13).'|'.substr($row['fev'], 26, 13).'|'.
                        substr($row['mar'], 26, 13).'|'.substr($row['abr'], 26, 13).'|'.
                        substr($row['mai'], 26, 13).'|'.substr($row['jun'], 26, 13).'|'.
                        substr($row['jul'], 26, 13).'|'.substr($row['ago'], 26, 13).'|'.
                        substr($row['set'], 26, 13).'|'.substr($row['out'], 26, 13).'|'.
                        substr($row['nov'], 26, 13).'|'.substr($row['dez'], 26, 13).'|'.
                        substr($row['dec'], 26, 13)."|\n";
                    if( $this->_doWrite($linhaRTPA) ) fputs($file, $linhaRTPA);
                }
            }
        }
    }
    
    /**
     * @param resource $file
     * @param ExportarDirfRepository $exportarDirf
     * @param array $cpfs
     * @param array $params
     * @param string $entidade
     */
    private function _writeAdcPlanosSaude(&$file, $exportarDirf, $cpfs, $params, $entidade)
    {
        $confDirfPlanos = $exportarDirf->getRelacionamentoPlanos(['configuracao_dirf_plano.exercicio = :exercicio'], [':exercicio' => $params['ano']]);
        
        if (!empty($confDirfPlanos)) {
            fputs($file, "PSE|\n");
            
            $where = ['cpf IN ('.implode(', ', $cpfs).')', 'valor > 0'];
            
            foreach ($confDirfPlanos as $planoConfig) {
                $auxLinha = 'OPSE|'.str_pad($planoConfig['cnpj'], 14, 0, STR_PAD_LEFT).'|'.
                    trim($planoConfig['nom_cgm']).'|'.str_pad($planoConfig['registro_ans'], 6, 0, STR_PAD_LEFT)."|\n";
                    fputs($file, $auxLinha);
                if ($planoConfig['pagamento_mes_competencia']) {
                    $planos = $exportarDirf->getPlanoSaudeDirfPlano(
                        $entidade,
                        $params['tipoRelatorio'],
                        $params['codigos'],
                        $params['ano'],
                        $planoConfig['cod_evento'],
                        $params['ano']-1,
                        $where
                        );
                } else {
                    $planos = $exportarDirf->getPlanoSaudeDirfPlano(
                        $entidade,
                        $params['tipoRelatorio'],
                        $params['codigos'],
                        $params['ano'],
                        $planoConfig['cod_evento'],
                        NULL,
                        $where
                        );
                }
                usort($planos, function($x, $y){
                    return $x['cpf'] < $y['cpf']?-1:1;
                });
                    
                foreach ($planos as $plano) {
                    $auxLinha = 'TPSE|'.str_pad($plano['cpf'], 11, 0, STR_PAD_LEFT).'|'.trim(str_replace('.','',$planos['nom_cgm'])).
                    '|'.str_pad(str_replace('.','',$planos['valor']), 13, 0, STR_PAD_LEFT)."|\n";
                    fputs($file, $auxLinha);
                }
            }
        }
    }
    
    /**
     * @param FormMapper $form
     * @param string $field
     * @return mixed|NULL
     */
    private function _getFromField($form, $field){
        $field = $form->get($field);
        if (!is_null($field)) {
            return $field->getData();
        }
        return null;
    }
    
    /**
     * @param string $stLinha
     * @return boolean
     */
    private function _doWrite($stLinha)
    {
        $inCount = 0;
        $arLinha = explode('|', $stLinha);
        $total = 0;
        foreach ($arLinha as $valor) {
            if ($inCount > 0) {
                $total += (int) $valor;
            }
            $inCount++;
        }
        if ( (int) $total > 0 ) {
            return true;
        } else {
            return false;
        }
    }
}
