<?php

namespace Urbem\PrestacaoContasBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

class RelatorioStnAdmin extends AbstractTceAdmin
{
    protected $baseRouteName = 'prestacao_contas_relatorio_stn';

    protected $baseRoutePattern = 'prestacao-contas/relatorio';

    protected $exibirBotaoEditar = false;

    protected $exibirBotaoExcluir = false;

    /**
     * @var \Urbem\PrestacaoContasBundle\Service\Tribunal\STN\StnStrategy\StnInterface
     */
    protected $strategy;

    /**
     * @param mixed $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function prePersist($object)
    {
        $fileName = $this->getForm()->get("reportName")->getData();

        // Form
        $this->strategy->setContentForm($this->getForm());

        // Recupera tudo com base no seu tipo
        $parameters = $this->strategy->processParameters();

        $apiService = $this->getReportService();
        $apiService->setReportNameFile($fileName);
        $apiService->setLayoutDefaultReport($this->getForm()->get("layoutReport")->getData());
        $res = $apiService->getReportContent($parameters);

        $this->parseContentToPdf(
            $res->getBody()->getContents(),
            $fileName
        );

        return $this->redirectByRoute('prestacao_contas_relatorio_stn_create', $this->getParametersBagCustom());
    }

    /**
     * @param FormMapper $formMapper
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $parameters = $this->getParametersBagCustom();

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
        $className = array_key_exists("className", $this->relatorio) ? $this->relatorio['className'] : null;
        $this->setStrategy(
            $this->getContainer()->get('prestacao_contas.service.stn.stn_factory')->build($className)
        );

        $this->strategy = $this->getStrategy();

        // Request para Formulário
        $formContent = $this->getRequest()->getMethod() == 'POST' ? $this->getFormPost() : null;
        $this->relatorio['parameters'] = $this->strategy->preBuildForm($this->relatorio['parameters'], $formContent);

        // Set JS
        $this->includeJs = $this->strategy->includeJs();

        // Botão salvar
        $this->legendButtonSave = ['icon' => 'input', 'text' => 'Ok'];

        // Formulário dinâmico
        $formMapper->with($this->relatorio['titlePage']);

        $this->createFormBuilder(array_key_exists('parameters', $this->relatorio) ? $this->relatorio['parameters'] : [])->build($formMapper);

        $formMapper->end();

        if (true === method_exists($this->strategy, 'load')) {
            $this->strategy->load($formMapper);
        }

        // Set Dymanic Block JS
        $this->setScriptDynamicBlock(
            $this->strategy->dynamicBlockJs()
        );
    }
}
