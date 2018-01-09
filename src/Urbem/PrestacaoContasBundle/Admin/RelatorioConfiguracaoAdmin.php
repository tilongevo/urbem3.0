<?php

namespace Urbem\PrestacaoContasBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoFactory;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

class RelatorioConfiguracaoAdmin extends AbstractTceAdmin implements TceInterface
{
    protected $customHeader = 'PrestacaoContasBundle:Configuracao:header.html.twig';

    protected $baseRouteName = 'prestacao_contas_relatorio_configuracao';

    protected $baseRoutePattern = 'prestacao-contas/conf';

    protected $exibirBotaoEditar = false;

    protected $exibirBotaoExcluir = false;

    /**
     * @var ConfiguracaoFactory
     */
    protected $strategy;

    /**
     * @return $this
     */
    public function objectAdmin()
    {
        return $this;
    }

    /**
     * @param \Sonata\CoreBundle\Validator\ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        // Form
        $this->strategy->setContentForm($this->getForm());
        $this->strategy->validate($errorElement);
    }

    /**
     * @param mixed $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function prePersist($object)
    {
        // Tudo que for enviado por POST é disponibilizado para Strategy
        $this->strategy->setContentForm($this->getForm());
        $this->strategy->setFormSonata($this->getFormPost($formSonata = false));

        // Salva o que for necessário
        if ($this->strategy->save()) {
            // Redirect
            $this->getRequest()->getSession()->getFlashBag()->add("success", "Informações salvas com sucesso!");
        } else {
            $this->getRequest()->getSession()->getFlashBag()->add("error", sprintf("Ocorreu um erro ao salvar os dados. %s", $this->strategy->getErrorMessage()));
        }

        $this->forceRedirect($this->generateUrl('create', $this->getParametersBagCustom()));
        $this->forceTerminate();
    }

    private function forceTerminate()
    {
        exit;
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
        $this->urlReferer = $this->getContainer()->get('router')->generate('prestacao_contas_tce_configuracao', $parameters);

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
        $this->legendButtonSave = ['icon' => 'input', 'text' => 'Ok'];

        // Analisa se formulário tem título entre os campos
        $this->checkPageTitleWhenTheFormHasNoTitleBetweenTheFields();

        // Formulário dinâmico
        $this->createFormBuilder(array_key_exists('parameters', $this->relatorio) ? $this->relatorio['parameters'] : [])->build($formMapper);

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
}
