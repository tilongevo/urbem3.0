<?php

namespace Urbem\PortalServicosBundle\Resources\config\Sonata;

use stdClass;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Urbem\CoreBundle\Entity\Economico\AtributoCadEconAutonomoValor;
use Urbem\CoreBundle\Entity\Economico\AtributoEmpresaDireitoValor;
use Urbem\CoreBundle\Entity\Economico\AtributoEmpresaFatoValor;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\TributarioBundle\Resources\config\Sonata\Economico\CadastroEconomicoAutonomoAdmin;
use Urbem\TributarioBundle\Resources\config\Sonata\Economico\CadastroEconomicoEmpresaDireitoAdmin;
use Urbem\TributarioBundle\Resources\config\Sonata\Economico\CadastroEconomicoEmpresaFatoAdmin;

class ConsultaCadastroEconomicoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_portalservicos_cadastro_economico_consulta';
    protected $baseRoutePattern = 'portal-cidadao/cadastro-economico/consulta';
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoSalvar = false;

    /**
    * @param string $action
    * @param null|CadastroEconomico $object
    * @return void
    */
    public function checkAccess($action, $object = null)
    {
        if (in_array($action, ['list', 'export'])) {
            return;
        }

        $cgm = $this->getCgm($object);
        if ($this->getCurrentUser()->getNumcgm() == $cgm->getNumcgm()) {
            return;
        }

        throw new AccessDeniedHttpException();
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);

        $qb->leftJoin(sprintf('%s.fkEconomicoCadastroEconomicoAutonomo', $qb->getRootAlias()), 'cea');
        $qb->leftJoin(sprintf('%s.fkEconomicoCadastroEconomicoEmpresaFato', $qb->getRootAlias()), 'ceef');
        $qb->leftJoin(sprintf('%s.fkEconomicoCadastroEconomicoEmpresaDireito', $qb->getRootAlias()), 'ceed');

        $qb->join(SwCgm::class, 'cgm', 'WITH', 'cgm.numcgm = COALESCE(cea.numcgm, ceef.numcgm, ceed.numcgm)');

        $qb->andWhere('cgm.numcgm = :numcgm');
        $qb->setParameter('numcgm', $this->getCurrentUser()->getNumcgm());

        return $qb;
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->clearExcept(
            [
                'list',
                'show',
                'export',
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
                        'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
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
    * @param CadastroEconomico $cadastroEconomico
    * @return Urbem\CoreBundle\Entity\SwCgm
    */
    protected function getCgm(CadastroEconomico $cadastroEconomico = null)
    {
        if (!$cadastroEconomico) {
            return;
        }

        if ($empresaFato = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaFato()) {
            return $empresaFato->getFkSwCgmPessoaFisica()->getFkSwCgm();
        }

        if ($autonomo = $cadastroEconomico->getFkEconomicoCadastroEconomicoAutonomo()) {
            return $autonomo->getFkSwCgmPessoaFisica()->getFkSwCgm();
        }

        if ($empresaDireito = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaDireito()) {
            return $empresaDireito->getFkSwCgmPessoaJuridica()->getFkSwCgm();
        }
    }
}
