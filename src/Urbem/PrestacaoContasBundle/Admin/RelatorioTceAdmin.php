<?php

namespace Urbem\PrestacaoContasBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Model\PrestacaoContas\FilaRelatorioModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

class RelatorioTceAdmin extends AbstractTceAdmin implements TceInterface
{
    protected $baseRouteName = 'prestacao_contas_relatorio_tce';

    protected $baseRoutePattern = 'prestacao-contas/relatorio/tce';

    protected $exibirBotaoEditar = false;

    protected $exibirBotaoExcluir = false;

    /**
     * @return $this
     */
    public function objectAdmin()
    {
        return $this;
    }

    /**
     * @var array
     */
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'id',
    );

    /**
     * @param \Sonata\AdminBundle\Route\RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept([]);
        $collection->add('create', '{uf}/{group}/{hash}/create');
        $collection->add('list', '{uf}/{group}/{hash}/list');
        $collection->add('show', '{uf}/{group}/{hash}/{id}/show');
        $collection->add('service', '{uf}/{group}/{hash}/service');
    }

    /**
     * @return null
     */
    public function getRelatorio()
    {
        parent::getRelatorio();
        $parameters = $this->getParametersBagCustom();

        $uf = $parameters['uf'];
        $title = sprintf("TCE %s - %s", strtoupper($uf), $this->relatorio['titlePage']);
        $this->relatorio['titlePage'] = $title;
    }

    /**
     * @param mixed $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function prePersist($object)
    {
        // Form
        $this->strategy->setContentForm($this->getForm());

        // Recupera tudo com base no seu tipo
        $parameters = $this->strategy->processParameters();

        (new FilaRelatorioModel($this->getEntityManager()))
            ->create(
                $this->relatorio['reportHash'],
                $this->relatorio['job_nome'],
                $parameters['data'],
                $parameters['value'],
                $this->relatorio['classe_processamento'],
                $this->getCurrentUser(),
                $this->getContainer()->get('zechim_queue.default_command_producer')
            );

        return $this->redirectByRoute('prestacao_contas_relatorio_tce_list', $this->getParametersBagCustom());
    }

    /**
     * @param FormMapper $formMapper
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $parameters = $this->getParametersBagCustom();

        if (false === (new FilaRelatorioModel($this->getEntityManager()))->userCanCreate($parameters['hash'], $this->getCurrentUser())) {
            $this->addMessage('error', 'Já existe uma solicitação para este relatório que está em processamento.');

            return $this->redirectByRoute('prestacao_contas_relatorio_tce_list', $parameters);
        }

        // Parametros usados para URL
        $uf = $parameters['uf'];
        $group = $parameters['group'];
        $hash = $parameters['hash'];
        $parametersUrl = ['uf' => $uf, 'group' => $group, 'hash' => $hash];

        // Rotas
        $this->setBreadCrumb($parametersUrl);
        $this->goBackURL = $this->getContainer()->get('router')->generate('configuracao_homepage');

        // Detalhes do tipo de relatório
        $this->getRelatorio();

        // Strategy
        $this->strategy = $this->loadStrategy();

        // Request para Formulário
        $formContent = $this->getRequest()->getMethod() == 'POST' ? $this->getFormPost() : null;
        $this->relatorio['parameters'] = $this->strategy->preBuildForm($this->relatorio['parameters'], $formContent);

        // Set JS
        $this->includeJs = $this->strategy->includeJs();

        // Botão salvar
        $this->legendButtonSave = ['icon' => 'input', 'text' => 'Enviar'];

        // Formulário dinâmico
        $formMapper->with($this->relatorio['titlePage']);

        $this->createFormBuilder(array_key_exists('parameters', $this->relatorio) ? $this->relatorio['parameters'] : [])->build($formMapper);

        $formMapper->end();

        // view dinâmica
        $this->strategy->view($formMapper, $this);

        if (true === method_exists($this->strategy, 'load')) {
            $this->strategy->load($formMapper);
        }

        // Set Dymanic Block JS
        $this->setScriptDynamicBlock(
            $this->strategy->dynamicBlockJs()
        );
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add(
            'status',
            'doctrine_orm_string',
            ['label' => 'fila_relatorio.status'],
            'choice',
            ['choices' => (new FilaRelatorioModel($this->getEntityManager()))->getAvailableStatus()]
        );
    }

    protected function configureListFields(ListMapper $list)
    {
        $this->configureBreadCrumb();
        $this->getRelatorio();
        $this->customHeader = 'PrestacaoContasBundle:Tce:cabecalho.html.twig';

        // Check items
        $this->getContainer()->get("prestacao_contas.report.listener")->checkReportList($this->getReportHash());

        $list->add('id');
        $list->add('status');
        $list->add('dataCriacao', 'datetime', ['date_format' => 'd/m/Y H:i']);
        $list->add('dataResposta', 'datetime', ['label' => 'fila_relatorio.dataResposta', 'date_format' => 'd/m/Y H:i']);
        $list->add('fkAdministracaoUsuario', null, ['label' => 'fila_relatorio.fkAdministracaoUsuario', 'admin_code' => 'administrativo.admin.usuario']);
        $list->add('_action', 'actions', [
            'actions' => [
                'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                'download' => ['template' => 'PrestacaoContasBundle:Sonata/RelatorioTce/CRUD:list__action_download.html.twig']
            ]
        ]);
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $this->configureBreadCrumb(true);
        $this->getRelatorio();

        $this->getContainer()->get("prestacao_contas.report.listener")->checkFilaRelatorio(
            $this->getSubject(),
            new FilaRelatorioModel($this->getEntityManager())
        );

        $show->with($this->relatorio['titlePage']);
        $show->add('id');
        $show->add('status', 'customField', [
            'template' => 'PrestacaoContasBundle:Tce:info-status-report.html.twig',
            'data' => $this->getSubject()->getStatus()
        ]);
        $show->add('dataCriacao', 'datetime', ['format' => 'd/m/Y H:i']);
        $show->add('dataResposta', 'datetime', ['label' => 'fila_relatorio.dataResposta']);
        $show->add('fkAdministracaoUsuario', null, ['label' => 'fila_relatorio.fkAdministracaoUsuario', 'admin_code' => 'administrativo.admin.usuario']);

        $show->add('parametros', 'customField', [
            'label' => 'fila_relatorio.parametros',
            'template' => 'PrestacaoContasBundle:Sonata/RelatorioTce/CRUD:custom_show_parametros.html.twig',
            'data' => $this->getSubject()->getParametros()
        ]);

        $show->add('relatorioLog', 'customField', [
            'label' => 'fila_relatorio.relatorioLog',
            'template' => 'PrestacaoContasBundle:Sonata/RelatorioTce/CRUD:custom_show_relatorio_log.html.twig',
            'data' => $this->getSubject()->getRelatorioLog()
        ]);
        $show->end();
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $query->andWhere('o.relatorio = :relatorio');
        $query->setParameters(['relatorio' => $this->getParametersBagCustom()['hash']]);

        return $query;
    }
}
