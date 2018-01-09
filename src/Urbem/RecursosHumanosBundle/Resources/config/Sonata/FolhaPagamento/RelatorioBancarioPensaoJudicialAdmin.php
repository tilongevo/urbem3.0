<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\SwCgm;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;

class RelatorioBancarioPensaoJudicialAdmin extends GeneralFilterAdmin
{
    const COD_ACAO = 1736;
    
    const REPORT_FILTRO_MATRICULA = 'contrato';
    const REPORT_FILTRO_CGM_MATRICULA = 'cgm_contrato';
    const REPORT_FILTRO_LOTACAO = 'lotacao_grupo';
    const REPORT_FILTRO_LOCAL = 'local_grupo';
    const REPORT_FILTRO_TRIBUTO_SERVIDOR = 'atributo_servidor_grupo';
    const REPORT_FILTRO_GERAL = 'geral';
    
    const REPORT_CALC_COMPLEMENTAR = 0;
    const REPORT_CALC_SALARIO = 1;
    const REPORT_CALC_FERIAS = 2;
    const REPORT_CALC_DECIMO_TERCEIRO = 3;
    const REPORT_CALC_RESCISAO = 4;
    
    const REPORT_AGRUPAMENTO_AGRUPAR  = 'agrupar';
    const REPORT_AGRUPAMENTO_QUEBRAR = 'quebrar-pagina';
    
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_bancario_pensao_judicial_relatorio';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/bancario-pensao-judicial/relatorio';
    protected $layoutDefaultReport = '/bundles/report/gestaoRH/fontes/RPT/folhaPagamento/report/design/RPTBancarioPensaoJudicial.rptdesign';
    
    protected $includeJs = [
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/recursoshumanos/javascripts/folhapagamento/RelatorioPensaoJudicialFiltro.js',
        '/recursoshumanos/javascripts/folhapagamento/bancarioPensaoJudicial.js'
    ];
    
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Exportar'];
    
    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create']);
        $collection->add('relatorio', 'relatorio');
        $collection->add('agencias_por_banco', "agencias-por-banco");
        $collection->add('folhas_por_competencia', "folhas-por-competencia");
    }
    
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $em = $this->getEntityManager();
        
        $fieldOptions = array();
        
        $this->_buildFieldsCompetencia($em, $fieldOptions);
        
        $tipoFiltro = [
            'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.tipoFiltroOpcoes.matricula' => self::REPORT_FILTRO_MATRICULA,
            'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.tipoFiltroOpcoes.cgmMatricula' => self::REPORT_FILTRO_CGM_MATRICULA,
            'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.tipoFiltroOpcoes.lotacao' => self::REPORT_FILTRO_LOTACAO,
            'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.tipoFiltroOpcoes.local' => self::REPORT_FILTRO_LOCAL,
            'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.tipoFiltroOpcoes.atributoDinamicoServidor' => self::REPORT_FILTRO_TRIBUTO_SERVIDOR,
            'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.tipoFiltroOpcoes.geral' => self::REPORT_FILTRO_GERAL
        ];
        
        $fieldOptions['tipoFiltro'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.tipoFiltro',
            'mapped' => false,
            'choices' => $tipoFiltro,
            'data' => self::REPORT_FILTRO_GERAL,
            'attr' => [
                'class' => 'select2-parameters'
            ]
        ];
        
        $this->_buildFieldsFiltros($em, $fieldOptions);
        
        $agrupamento = [
            'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.agrupar' => self::REPORT_AGRUPAMENTO_AGRUPAR,
            'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.quebrarPagina' => self::REPORT_AGRUPAMENTO_QUEBRAR,
        ];
        
        $fieldOptions['agrupamento'] = [
            'mapped' => false,
            'choices' => $agrupamento,
            'expanded' => true,
            'required' => false,
            'multiple' => true,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata',
            ],
            'label' => 'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.agrupamento',
        ];
        
        $this->_buildFieldsBancos($em, $fieldOptions);
        
        $this->_buildTableAtributos($fieldOptions);
        
        $formMapper
            ->with("label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.titulo")
                ->add('ultimaCompetencia', 'hidden', $fieldOptions['ultimaCompetencia'])
                ->add('competencia', 'text', $fieldOptions['competencia'])
                ->add('tipoCalculo', 'choice', $fieldOptions['tipoCalculo'])
                ->add('folhaComplementar', 'choice', $fieldOptions['folhaComplementar'])
            ->end()
            ->with("label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.selecaoFiltro")
                ->add('tipoFiltro', 'choice', $fieldOptions['tipoFiltro'])
                ->add('matricula', 'autocomplete', $fieldOptions['matricula'])
                ->add('cgm', 'autocomplete', $fieldOptions['cgm'])
                ->add('cgmMatricula', 'choice', $fieldOptions['cgmMatricula'])
                ->add('lotacao', 'choice', $fieldOptions['lotacao'])
                ->add('local', 'entity', $fieldOptions['local'])
                ->add('incluirMatricula', 'customField', $fieldOptions['incluirMatricula'])
                ->add('incluirCgmMatricula', 'customField', $fieldOptions['incluirCgmMatricula'])
                ->add('listaMatriculas', 'customField', $fieldOptions['listaMatriculas'])
                ->add('listaCgmMatriculas', 'customField', $fieldOptions['listaCgmMatriculas'])
                ->add('atributosDinamicos', 'customField', $fieldOptions['atributosDinamicos'])
                ->add('agrupamento', 'choice', $fieldOptions['agrupamento'])
            ->end()
            ->with('label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.informacoesBancarias')
                ->add('banco', 'choice', $fieldOptions['banco'])
                ->add('agencia','choice', $fieldOptions['agencia'])
                ->add('agenciasStr', HiddenType::class, ['mapped' => false])
            ->end()
        ;
    }

    /**
     * @param mixed
     */
    public function prePersist($object)
    {
        $exercicio = $this->getExercicio();
        $fileName = $this->parseNameFile("relatorioBancarioPensaoJudicial");
        
        $form = $this->getForm();
        
        $params = [];
        
        $this->_getDefaultParams($params);
        
        $params['term_user'] = $this->getCurrentUser()->getUserName();
        $params['cod_acao'] = self::COD_ACAO;
        $params['exercicio'] = $exercicio;
        $params['inCodGestao'] = Gestao::GESTAO_RECURSOS_HUMANOS;
        $params['inCodModulo'] = Modulo::MODULO_FOLHAPAGAMENTO;
        $params['inCodRelatorio'] = Relatorio::RECURSOS_HUMANOS_FOLHAPAGAMENTO_BANCARIOPENSAOJUDICIAL;
        
        $this->_getFormCompetencia($form, $params);
        $this->_getFormFiltros($form, $params);
        $this->_getFormBancos($form, $params);
        
        $apiService = $this->getReportService();
        $apiService->setReportNameFile($fileName);
        $apiService->setLayoutDefaultReport($this->layoutDefaultReport);
        $res = $apiService->getReportContent($params);
        
        $this->parseContentToPdf(
            $res->getBody()->getContents(),
            $fileName
        );
    }
    
    /**
     * @param $EntityManager $em
     * @param array $fieldOptions
     */
    private function _buildFieldsCompetencia($em, &$fieldOptions)
    {
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        $periodoUnico = reset($periodoUnico);
        
        $fieldOptions['ultimaCompetencia'] = [
            'mapped' => false,
            'disabled' => true,
            'required' => false,
            'data' => (new \DateTime())->createFromFormat('d/m/Y', $periodoUnico->dt_final)->format('m/Y'),
        ];
        
        $fieldOptions['competencia'] = [
            'mapped' => false,
            'required' => true,
            'label' => 'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.competencia',
        ];
        
        $tipoCalculo = [
            'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.tipoCalculoOptions.complementar' => self::REPORT_CALC_COMPLEMENTAR,
            'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.tipoCalculoOptions.salario' => self::REPORT_CALC_SALARIO,
            'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.tipoCalculoOptions.ferias' => self::REPORT_CALC_FERIAS,
            'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.tipoCalculoOptions.decimoTerceiro' => self::REPORT_CALC_DECIMO_TERCEIRO,
            'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.tipoCalculoOptions.recisao' => self::REPORT_CALC_RESCISAO
        ];
        
        $fieldOptions['tipoCalculo'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.tipoCalculo',
            'mapped' => false,
            'choices' => $tipoCalculo,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters'
            ]
        ];
        
        $folhasComplementares = $periodoMovimentacao->fetchFolhaComplementar($periodoUnico->cod_periodo_movimentacao);
        
        $complementarArr = [];
        
        foreach ($folhasComplementares as $folha) {
            $complementarArr[$folha['cod_complementar']] = $folha['cod_complementar'];
        }
        
        $fieldOptions['folhaComplementar'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.folhaComplementar',
            'mapped' => false,
            'choices' => $complementarArr,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters'
            ]
        ];
    }
    
    /**
     * @param $EntityManager $em
     * @param array $fieldOptions
     */
    private function _buildFieldsFiltros($em, &$fieldOptions)
    {
        $fieldOptions['matricula'] = [
            'class' => Contrato::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
            $qb = $em->createQueryBuilder('o');
            
            $qb->join('o.fkPessoalContratoServidor', 'cs');
            $qb->join('cs.fkPessoalServidorContratoServidores', 'scs');
            $qb->join('scs.fkPessoalServidor', 's');
            $qb->join(SwCgm::class, 'cgm', 'WITH', 'cgm.numcgm = s.numcgm');
            
            $qb->andWhere('(LOWER(cgm.nomCgm) LIKE :nomCgm OR o.registro = :registro)');
            $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));
            $qb->setParameter('registro', (int) $term);
            
            $qb->orderBy('o.registro', 'ASC');
            
            return $qb;
            },
            'json_choice_label' => function (Contrato $contrato) {
            return sprintf('%d - %s', $contrato->getRegistro(), $contrato->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()->getFkPessoalContratoServidor()->getCgm());
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.matricula',
            ];
        
        $fieldOptions['cgm'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
            $qb = $em->createQueryBuilder('o');
            
            $qb->join(Servidor::class, 's', 'WITH', 's.numcgm = o.numcgm');
            $qb->join('s.fkPessoalServidorContratoServidores', 'scs');
            $qb->join('scs.fkPessoalContratoServidor', 'cs');
            
            $qb->andWhere('(LOWER(o.nomCgm) LIKE :nomCgm OR o.numcgm = :numcgm)');
            $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));
            $qb->setParameter('numcgm', (int) $term);
            
            $qb->orderBy('o.numcgm', 'ASC');
            
            return $qb;
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.cgm',
            ];
        
        $fieldOptions['cgmMatricula'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.matricula',
        ];
        
        $organogramaModel = new OrganogramaModel($em);
        /** @var OrgaoModel $orgaoModel */
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
        
        $fieldOptions['lotacao'] = [
            'mapped' => false,
            'required' => false,
            'multiple' => true,
            'choices' => $lotacaoArray,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.lotacao',
        ];
        
        $fieldOptions['local'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.local',
            'required' => false,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'class' => Local::class,
            'multiple' => true
        ];
    }
    
    /**
     * @param $EntityManager $em
     * @param array $fieldOptions
     */
    private function _buildFieldsBancos($em, &$fieldOptions)
    {
        $bancoRepo = $em->getRepository(Banco::class);
        
        $bancos = $bancoRepo->findAll();
        
        $opBancos = [];
        foreach ($bancos as $banco) {
            $opBancos[$banco->getCodBanco()] = $banco->getCodBanco()." - ".$banco->getNomBanco();
        }
        
        $fieldOptions['banco'] = array(
            'label' => 'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.banco',
            'required' => false,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom ',
            ],
            'choices' => array_flip($opBancos),
            'expanded' => false,
            'multiple' => true
        );
        
        $fieldOptions['agencia'] = array(
            'label' => 'label.recursosHumanos.relatorios.folha.BancoPensaoJudicial.agencia',
            'required' => false,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom ', 'style' => "width: 100%"
            ],
            'choices' => [],
            'expanded' => false,
            'multiple' => true
        );
        
        $fieldOptions['agenciasStr'] = ['data' => ''];
    }
    
    /**
     * @param array $fieldOptions
     */
    private function _buildTableAtributos(&$fieldOptions)
    {
        $fieldOptions['incluirMatricula'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/incluir_matricula.html.twig',
            'data' => [],
        ];
        
        $fieldOptions['listaMatriculas'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/lista_matriculas.html.twig',
            'data' => [],
        ];
        
        $fieldOptions['incluirCgmMatricula'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/incluir_cgm_matricula.html.twig',
            'data' => [],
        ];
        
        $fieldOptions['listaCgmMatriculas'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/lista_cgm_matriculas.html.twig',
            'data' => [],
        ];
        
        $fieldOptions['atributosDinamicos'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/atributos_dinamicos.html.twig',
            'data' => [],
        ];
    }
    
    /**
     * @param Form $form
     * @param array $params
     */
    private function _getFormCompetencia($form, &$params){
        $competencia = $form->get('competencia')->getData();
        
        $em = $this->getEntityManager();
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        
        $periodoUnico = $periodoMovimentacao->recuperaPeriodoMovimentacao(null, $competencia);
        
        $params['cod_periodo_movimentacao'] = $periodoUnico['cod_periodo_movimentacao'];
        
        $dataCompetencia = \DateTime::createFromFormat('m/Y', $competencia)->format('t/m/Y');
        $params['competencia'] = $dataCompetencia;
        
        $filtro = $form->get('tipoCalculo')->getData();
        $params['inCodConfiguracao'] = $filtro;
        if ($filtro == self::REPORT_CALC_COMPLEMENTAR) {
            $params['inCodComplementar'] = $form->get('folhaComplementar')->getData();
        }
        
        $params['filtro'] = $form->get('tipoFiltro')->getData();
    }
    
    /**
     * @param Form $form
     * @param array $params
     */
    private function _getFormFiltros($form, &$params){
        $params['codigos'] = '';
        $params['valor'] = '';
        $params['cod_atributo'] = '';
        
        switch ($params['filtro']) {
            case self::REPORT_FILTRO_CGM_MATRICULA:
            case self::REPORT_FILTRO_MATRICULA;
            $cgmMatriculas = $form->get('listaCgmMatriculas')->getData();
                $codigosArr = [];
                foreach ($cgmMatriculas as $codigo) {
                    $codigosArr[] = $codigo['codContrato'];
                }
                $params['codigos'] = $this->_arrayToParameter($codigosArr);
                break;
            case self::REPORT_FILTRO_LOTACAO:
                $params['codigos'] = $this->_arrayToParameter($form->get('lotacao')->getData());
                break;
            case self::REPORT_FILTRO_LOCAL:
                $localArr = [];
                foreach ($form->get('local')->getData() as $local) {
                    $localArr[] = $local;
                }
                $params['codigos'] = $this->_arrayToParameter($localArr);
                break;
            case self::REPORT_FILTRO_TRIBUTO_SERVIDOR:
                foreach ($form->get('atributosDinamicos')->getData() as $key => $attr) {
                    $val = current($attr);
                    if (!empty($val)) {
                        $params['valor'] = $val;
                        $params['cod_atributo'] = $key;
                        break;
                    }
                }
                break;
        }
        
        $agrupamento = $form->get('agrupamento')->getData();
        
        $params['agrupar'] = array_search(self::REPORT_AGRUPAMENTO_AGRUPAR, $agrupamento) !== FALSE? 'true':'false';
        $params['quebrar'] = array_search(self::REPORT_AGRUPAMENTO_QUEBRAR, $agrupamento) !== FALSE? 'true':'false';
    }
    
    /**
     * @param Form $form
     * @param array $params
     */
    private function _getFormBancos($form, &$params){
        $bancos = $form->get('banco')->getData();
        $agencias = json_decode($form->get('agenciasStr')->getData(), true);

        if (!is_null($agencias)) {
            array_walk($agencias, 'intval');
            $agencias = $this->_arrayToParameter($agencias);
        }
        
        if (is_array($bancos) && !empty($bancos)) {
            $params['bancos'] = $this->_arrayToParameter($bancos);
        } else {
            $params['bancos'] = '';
        }
        
        $params['agencias'] = $agencias;
    }
    
    /**
     * @param array $arr
     * @return string
     */
    private function _arrayToParameter(Array $arr)
    {
        return implode(",", $arr);
    }
    
    /**
     * @param array $params
     */
    private function _getDefaultParams(&$params)
    {
        $em = $this->getEntityManager();
        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($em);
        $codEntidadePrefeitura = $configuracaoModel->getConfiguracao(
            'cod_entidade_prefeitura',
            Modulo::MODULO_ORCAMENTO,
            true,
            $this->getExercicio()
        );
        
        /** @var Entidade $entidade */
        $entidade = $em->getRepository(Entidade::class)->findOneBy(
            [
                'codEntidade' => $codEntidadePrefeitura,
                'exercicio' => $this->getExercicio()
            ]
        );
        
        $params['stEntidade'] = $entidade->getFkSwCgm()->getNomCgm();
        $params['entidade'] = $codEntidadePrefeitura;
        $params['codigos'] = '';
        $params['cod_atributo'] = '';
        $params['valor'] = '';
        $params['inCodComplementar'] = 0;
    }
}
