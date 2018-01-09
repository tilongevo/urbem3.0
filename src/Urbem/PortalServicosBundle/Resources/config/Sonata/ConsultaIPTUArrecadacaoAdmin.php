<?php

namespace Urbem\PortalServicosBundle\Resources\config\Sonata;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoCalculo;
use Urbem\CoreBundle\Entity\Arrecadacao\ImovelCalculo;
use Urbem\CoreBundle\Entity\Arrecadacao\Lancamento;
use Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConsultaIPTUArrecadacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_portalservicos_arrecadacao_consulta_iptu';
    protected $baseRoutePattern = 'portal-cidadao/arrecadacao/consulta/iptu';
    protected $includeJs = array(
        '/portalservicos/javascripts/consulta-arrecadacao.js',
    );
    protected $exibirMensagemFiltro = true;
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoExcluir = false;
    protected $endereco = null;
    protected $tipoInscricao = 'Outros';

    /**
    * @param string $action
    * @param null|Lancamento $object
    * @return void
    */
    public function checkAccess($action, $object = null)
    {
        if ($action == 'list') {
            return;
        }

        $em = $this->modelManager->getEntityManager($this->getClass());
        $cgm = $em->getRepository(Lancamento::class)->getCgm($object);

        if (!$cgm) {
            throw new AccessDeniedHttpException();
        }

        $numcgm = reset($cgm);
        if ($numcgm['buscacgmlancamento'] == $this->getCurrentUser()->getNumcgm()) {
            return;
        }

        throw new AccessDeniedHttpException();
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('get_detalhe_parcela', 'detalhe-parcela', array(), array(), array(), '', array(), array('GET'));
        $collection->add('get_detalhamento_por_credito', 'detalhamento-por-credito', array(), array(), array(), '', array(), array('GET'));
        $collection->add('relatorio_create', $this->getRouterIdParameter() . '/pdf');
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);
        $qb->join(sprintf('%s.fkArrecadacaoLancamentoCalculos', $qb->getRootAlias()), 'lc');
        $qb->join('lc.fkArrecadacaoCalculo', 'c');

        $em = $this->getModelManager()->getEntityManager($this->getClass());

        $filter = $this->getRequest()->query->get('filter');

        $filter['cgm']['value'] = $this->getCurrentUser()->getNumcgm();

        $lancamento = new LancamentoModel($em);
        $qb = $lancamento->getArrecadacao($qb, $filter);

        $qb->join('c.fkArrecadacaoCalculoGrupoCredito', 'cgc');
        $qb->join('cgc.fkArrecadacaoGrupoCredito', 'gc');

        $qb->andWhere('LOWER(gc.descricao) LIKE :descricao');
        $qb->setParameter('descricao', sprintf('%%%s%%', 'iptu'));

        $qb->orderBy('c.exercicio', 'ASC')
            ->orderBy('o.codLancamento', 'ASC');

        return $qb;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkArrecadacaoLancamentoCalculos.fkArrecadacaoCalculo.fkArrecadacaoImovelCalculo.inscricaoMunicipal',
                null,
                [
                    'label' => 'label.arrecadacaoConsulta.inscricaoImobiliaria',
                ]
            )
            ->add(
                'fkArrecadacaoLancamentoCalculos.fkArrecadacaoCalculo.fkArrecadacaoPagamentoCalculos.numeracao',
                null,
                [
                    'label' => 'label.arrecadacaoConsulta.numeracao'
                ]
            )
            ->add(
                'fkArrecadacaoLancamentoCalculos.fkArrecadacaoCalculo.exercicio',
                null,
                [
                    'label' => 'label.exercicio'
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
            ->add(
                'contribuinte',
                'customField',
                [
                    'label' => 'label.arrecadacaoConsulta.contribuinte',
                    'mapped' => false,
                    'template' => 'TributarioBundle:Arrecadacao\Consultas\ConsultaArrecadacao:contribuinte.html.twig',
                ]
            )
            ->add(
                'cobranca',
                'customField',
                [
                    'label' => 'label.arrecadacaoConsulta.origemCobranca',
                    'mapped' => false,
                    'template' => 'TributarioBundle:Arrecadacao\Consultas\ConsultaArrecadacao:cobranca.html.twig',
                ]
            )
            ->add(
                'inscricao',
                'customField',
                [
                    'label' => 'label.arrecadacaoConsulta.inscricao',
                    'mapped' => false,
                    'template' => 'TributarioBundle:Arrecadacao\Consultas\ConsultaArrecadacao:inscricao.html.twig',
                ]
            )
            ->add(
                'complemento',
                'customField',
                [
                    'label' => 'label.arrecadacaoConsulta.dadosComplementares',
                    'mapped' => false,
                    'template' => 'TributarioBundle:Arrecadacao\Consultas\ConsultaArrecadacao:complemento.html.twig',
                ]
            )
            ->add(
                'situacao',
                'customField',
                [
                    'label' => 'label.arrecadacaoConsulta.situacao',
                    'mapped' => false,
                    'template' => 'TributarioBundle:Arrecadacao\Consultas\ConsultaArrecadacao:situacao.html.twig',
                ]
            )
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    ],
                    'header_style' => 'width: 20%'
                ]
            )
        ;
    }

    /**
     *  @param  $inscricao
     *  @return string
     */
    public function getArrecadacaoByInscricao($inscricao)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $arrecadacao = (new \Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel($entityManager))
            ->getArrecadacaoByInscricao($inscricao);

        return end($arrecadacao);
    }

    /**
     *  @param  $lancamento
     *  @return string
     */
    public function getInscricao($lancamento)
    {
        if (!$lancamento) {
            return;
        }

        $codCalculo = $lancamento->getFkArrecadacaoLancamentoCalculos()->last()->getCodCalculo();

        $em = $this->modelManager->getEntityManager($this->getClass());

        $imovelCalculo = $em->getRepository(ImovelCalculo::class)->findOneByCodCalculo($codCalculo);
        if ($imovelCalculo) {
            $this->endereco = $this->getEndereco($imovelCalculo->getInscricaoMunicipal(), 'Municipal');
            $this->tipoInscricao = $this->getTranslator()->trans('label.arrecadacaoConsulta.inscricaoImobiliaria');
            return $imovelCalculo->getInscricaoMunicipal();
        }

        $cadastroEconomico = $em->getRepository(CadastroEconomicoCalculo::class)->findOneByCodCalculo($codCalculo);
        if ($cadastroEconomico) {
            $this->endereco = $this->getEndereco($cadastroEconomico->getInscricaoEconomica(), 'Economica');
            $this->tipoInscricao = $this->getTranslator()->trans('label.arrecadacaoConsulta.inscricaoEconomica');
            return $cadastroEconomico->getInscricaoEconomica();
        }

        return;
    }

    /**
     *  @return string
     */
    public function getTipoInscricao()
    {
        return $this->tipoInscricao;
    }

    /**
     *  @param  $inscricaoMunicipal
     *  @param  $lancamento
     *  @return string
     */
    public function getUltimoVenal($inscricaoMunicipal, $lancamento)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $ultimoVenal = (new \Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel($entityManager))
            ->getUltimoVenal($inscricaoMunicipal, $lancamento->getCodLancamento());

        $ultimoVenal = array_shift($ultimoVenal);

        return $ultimoVenal['valor'];
    }

    /**
     *  @param $lancamentpo
     *  @return bool
     */
    public function getTipoCalculo($lancamento)
    {
        return ($lancamento->getFkArrecadacaoLancamentoCalculos()->last()->getFkArrecadacaoCalculo()->getCalculado()) ? : '';
    }

    /**
     * @return string
     */
    public function getEnderecoValue()
    {
        return $this->endereco;
    }

    /**
     * @param   $lancamento
     * @return  array
     */
    public function getListaCreditos($lancamento)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $listaCreditos = (new \Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel($entityManager))
            ->getListaCreditos($lancamento);

        return $listaCreditos;
    }

    /**
     * @param   $inscricaoMunicipal
     * @return  string
     */
    public function getSituacaoImovel($inscricaoMunicipal)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $situacao = (new \Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel($entityManager))
            ->getSituacaoImovel($inscricaoMunicipal, date("Y-m-d"));

        $situacao = array_shift($situacao);

        return $situacao['valor'];
    }

    /**
     * @param   $inscricao
     * @param   $type
     * @return  string
     */
    protected function getEndereco($inscricao, $type)
    {
        if (!$inscricao || !$type) {
            return;
        }

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $endereco = (new \Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel($entityManager))
            ->getEndereco($inscricao, $type);

        return $endereco;
    }

    /**
     * @param  $lancamento
     * @return  string
     */
    public function getContribuinte($lancamento)
    {
        if (!$lancamento) {
            return;
        }

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $contribuinte = (new \Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel($entityManager))
            ->getContribuinte($lancamento);

        return $contribuinte;
    }

    /**
     * @param  $lancamento
     * @return  string
     */
    public function getSituacao($lancamento)
    {
        if (!$lancamento) {
            return;
        }

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $situacao = (new \Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel($entityManager))
            ->getSituacao($lancamento);

        return $situacao;
    }

    /**
     *  @param  $lancamento
     *  @return string
     */
    public function getOrigemCobranca($lancamento)
    {
        if (!$lancamento) {
            return;
        }

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $cobranca = (new \Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel($entityManager))
            ->getOrigemCobranca($lancamento);

        $split = explode('§', $cobranca);

        if ($split[3] == '') {
            return explode('<br>', $split[2]);
        }

        return $split[2] . '/' . $split[3];
    }

    /**
     *  @param  $lancamento
     *  @return Array
     */
    public function getOrigemFormated($lancamento)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $origemFormated = (new \Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel($entityManager))
            ->getOrigemFormated($lancamento->getCodLancamento());

        return (array_shift($origemFormated));
    }

    /**
     *  @param  $lancamento
     *  @return Array
     */
    public function getListaParcelas($lancamento)
    {
        if (!$lancamento) {
            return;
        }

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $listaParcelas = (new \Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel($entityManager))
            ->getListaParcelas($lancamento);

        return $listaParcelas;
    }

    /**
     *  @param  $lancamento
     *  @return Array
     */
    public function getDetalheParcela($object, $numeracao, $ocorrenciaPagamento, $codParcela)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $detalhesParcela = (new \Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel($entityManager))
            ->getDetalheParcela($object->getCodLancamento(), $numeracao, $ocorrenciaPagamento, $codParcela);

        return array_shift($detalhesParcela);
    }

    /**
     *  @param  $inscricaoEconomica
     *  @return string
     */
    public function getCompetencia($inscricaoEconomica)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $lancamento = (new \Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel($entityManager))
            ->getLancamentoByInscricaoEconomica($inscricaoEconomica);

        $competencia = (array_shift($lancamento));

        return $competencia['competencia'];
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('codCalculo')
            ->add('codCredito')
            ->add('codNatureza')
            ->add('codGenero')
            ->add('codEspecie')
            ->add('exercicio')
            ->add('valor')
            ->add('nroParcelas')
            ->add('ativo')
            ->add('timestamp')
            ->add('calculado')
            ->add('iLancto')
            ->add('iImovel')
            ->add('simulado')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $data = [];

        $this->exibirBotaoEditar = false;

        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        $showMapper
            ->add(
                'dadosEmissao',
                'customField',
                [
                    'template' => 'TributarioBundle::Arrecadacao/Consultas/ConsultaArrecadacao/custom_show.html.twig',
                    'data' => $data
                ]
            )
        ;
    }

    /**
     * @return bool
     */
    public function isShow()
    {
        $rota = explode('_', $this->request->get('_route'));
        return ('show' == end($rota));
    }
}
