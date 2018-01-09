<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenhoHistorico;
use Urbem\CoreBundle\Entity\Orcamento\Despesa;
use Urbem\CoreBundle\Entity\Orcamento\Pao;
use Urbem\CoreBundle\Entity\Orcamento\Programa;
use Urbem\CoreBundle\Entity\Orcamento\ProgramaPpaPrograma;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Administracao\CadastroModel;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Orcamento\PaoModel;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConfiguracaoAutorizacaoEmpenhoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_configuracao_autorizacao_empenho';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/configuracao/autorizacao-empenho';

    /** @var array $includeJs */
    protected $includeJs = [
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/recursoshumanos/javascripts/folhapagamento/configuracao/configuracaoautorizacaoempenho.js'
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codConfiguracaoAutorizacao')
            ->add('exercicio')
            ->add('complementar')
            ->add('descricaoItem')
            ->add('vigencia');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codConfiguracaoAutorizacao')
            ->add('exercicio')
            ->add('complementar')
            ->add('descricaoItem')
            ->add('vigencia');

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions['numcgm'] = [
            'required' => true,
            'label' => 'CGM',
            'attr' => [
                'class' => 'comissao-collection '
            ],
            'property' => 'nomCgm',
            'to_string_callback' => function (SwCgm $fornecedor, $property) {
                return $fornecedor->getNumcgm() . ' - ' . $fornecedor->getNomCgm();
            },
        ];

        $fieldOptions['vigencia'] = [
            'format' => 'dd/MM/yyyy',
            'dp_default_date' => date('d/m/Y'),
            'dp_min_date' => date('d/m/Y'),
        ];

        $fieldOptions['historico'] = [
            'class' => ConfiguracaoAutorizacaoEmpenhoHistorico::class,
            'label' => 'label.recursosHumanos.configuracao.historico',
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['descricaoItem'] = [
            'label' => 'label.configuracaoEmpenho.descricaoItemAutorizacao',
            'required' => false
        ];

        $fieldOptions['complementoItem'] = [
            'label' => 'label.configuracaoEmpenho.complemento',
            'required' => false,
            'mapped' => false
        ];

        $fieldOptions['descricao'] = [
            'label' => 'label.configuracaoEmpenho.descricaoAutorizacao',
            'required' => false,
            'mapped' => false
        ];

        $fieldOptions['autorizacao_lista'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'RecursosHumanosBundle::FolhaPagamento/Configuracao/autorizacaoLista.html.twig',
            'attr' => array(
                'style' => 'display:none;'
            ),
            'data' => array(
                'autorizacoes' => array()
            )
        );

        $exercicio = $this->getExercicio();

        $stCondicao = "WHERE pao.exercicio ='". $exercicio."'";
        $stGroupBy = ' GROUP BY dotacao, pao.exercicio, pao.num_pao, acao.num_acao, acao_dados.titulo';
        $stOrdem = ' ORDER BY acao.num_acao, dotacao';

        /** @var PaoModel $paoModel */
        $paoModel = new PaoModel($em);
        $dotacoes = $paoModel->recuperaPorNumPAODotacao($stCondicao, $stGroupBy, $stOrdem);
        $pao = [];
        foreach ($dotacoes as $dotacao) {
            $pao[$dotacao['dotacao']. " - ". $dotacao['titulo']] = $dotacao['num_pao'];
        }

        $fieldOptions['pao'] = [
            'choices' => $pao,
            'mapped' => false,
        ];

        /** @var OrganogramaModel $organogramaModel */
        $organogramaModel = new OrganogramaModel($em);
        /** @var Orgao $orgaoModel */
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
            'label' => 'label.recursosHumanos.folhas.grid.lotacao',
            'required' => true,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'choices' => $lotacaoArray,
            'expanded' => false,
            'multiple' => false,
            'placeholder' => ''
        ];

        $fieldOptions['local'] = [
            'label' => 'label.recursosHumanos.folhas.grid.local',
            'required' => true,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'class' => Local::class,
            'expanded' => false,
            'multiple' => false,
            'placeholder' => ''
        ];

        $fieldOptions['tipo'] = [
            'label' => 'label.recursosHumanos.configuracao.opcoes',
            'required' => true,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'choices' => [
                'Selecione' => '',
                'Lotação' => 'lotacao',
                'Local' => 'local',
                'Atributo' => 'atributo',
            ],
            'expanded' => false,
            'multiple' => false
        ];

        $modulo = ConfiguracaoModel::MODULO_RH_PESSOAL;
        $cadastro = CadastroModel::CADASTRO_ELEMENTOS;
        $atributos = (new AtributoDinamicoModel($em))->getAtributosDinamicosPessoal(['cod_modulo' => $modulo, 'cod_cadastro' => $cadastro]);
        foreach ($atributos as $atributo) {
            $key = $atributo->cod_cadastro.'~'.$atributo->cod_atributo;
            $value = $atributo->cod_atributo." - ".$atributo->nom_atributo;
            $atributosArray[$value] = $key;
        }

        $fieldOptions['atributosArray'] = [
            'label' => 'label.recursosHumanos.configuracao.atributoDinamico',
            'required' => true,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'placeholder' => '',
            'choices' => $atributosArray,
            'expanded' => false,
            'multiple' => false
        ];

        $fieldOptions['lotacao_lista'] = [
            'label' => false,
            'mapped' => false,
            'template' => 'RecursosHumanosBundle::FolhaPagamento/Configuracao/lotacaoLista.html.twig',
            'attr' => array(
                'style' => 'display:none;'
            ),
            'data' => array(
                'lotacoes' => array()
            )
        ];

        $fieldOptions['codCadastro'] = [
            'mapped' => false,
            'data' => $cadastro,
        ];

        $fieldOptions['codModulo'] = [
            'mapped' => false,
            'data' => $modulo,
        ];

        //ABA DADOS DA AUTORIZACAO
        $formMapper->tab('label.recursosHumanos.configuracao.dadosAutorizacao');
        $formMapper
            ->with('label.recursosHumanos.configuracao.vigenciaConfiguracao')
            ->add('vigencia', 'sonata_type_date_picker', $fieldOptions['vigencia'])
            ->end()
            ->with('label.recursosHumanos.configuracao.configuracaoAutorizacaoEmpenho')
            ->add('fkSwCgm', 'sonata_type_model_autocomplete', $fieldOptions['numcgm'], ['admin_code' => 'core.admin.filter.sw_cgm'])
            ->add('descricao', 'textarea', $fieldOptions['descricao'])
            ->add('fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico', null, $fieldOptions['historico'])
            ->end()
            ->with('label.recursosHumanos.configuracao.itemAutorizacao')
            ->add('descricaoItem', 'textarea', $fieldOptions['descricaoItem'])
            ->add('complementoItem', 'textarea', $fieldOptions['complementoItem'])
            ->add('autorizacao_lista', 'customField', $fieldOptions['autorizacao_lista'])
            ->end();
        $formMapper->end();

        //ABA LOTAÇÃO/LOCAL/ATRIBUTO
        $formMapper->tab('label.recursosHumanos.configuracao.lotacaoLocalAtributo');
        $formMapper->with('label.recursosHumanos.configuracao.configuracao');
        $formMapper->add('codCadastro', 'hidden', $fieldOptions['codCadastro']);
        $formMapper->add('codModulo', 'hidden', $fieldOptions['codModulo']);
        $formMapper->add('tipo', 'choice', $fieldOptions['tipo']);
        $formMapper->add('lotacao', 'choice', $fieldOptions['lotacao']);
        $formMapper->add('local', 'entity', $fieldOptions['local']);
        $formMapper->add('atributo', 'choice', $fieldOptions['atributosArray']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioLote.atributos', array('class' => 'atributoDinamicoWith'));
        $formMapper->add('atributosDinamicos', 'text', ['mapped' => false, 'required' => false]);
        $formMapper->end();
        $formMapper->with('label.recursosHumanos.configuracao.configuracaoAutorizacaoEmpenho');
        $formMapper->add('pao', 'choice', $fieldOptions['pao']);
        $formMapper->add('lotacao_lista', 'customField', $fieldOptions['lotacao_lista']);
        $formMapper->end();
        $formMapper->end();

        //ABA EVENTOS
        $formMapper->tab('label.recursosHumanos.configuracao.eventos');
        $formMapper->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codConfiguracaoAutorizacao')
            ->add('exercicio')
            ->add('complementar')
            ->add('descricaoItem')
            ->add('vigencia');
    }

    /**
     * @param ConfiguracaoAutorizacaoEmpenho $configuracaoAutorizacaoEmpenho
     */
    public function prePersist($configuracaoAutorizacaoEmpenho)
    {
        $request = $this->request->request;
        $autorizacao = $request->get('autorizacao');
        $ev = array_shift($autorizacao);
        $form = $this->getForm();
        $container = $this->getContainer();
//        dump($autorizacao);
        foreach ($autorizacao as $aut) {
            $autorizacaoArray[] = explode(";", $aut);
        }
//        dump($autorizacaoArray);
//        die();
    }
}
