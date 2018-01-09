<?php

namespace Urbem\PrestacaoContasBundle\Admin;

use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Urbem\PrestacaoContasBundle\Form\Builder\ArrayParser;
use Urbem\PrestacaoContasBundle\Form\Builder\FieldsFetcher;
use Urbem\PrestacaoContasBundle\Form\Builder\FormBuilder;
use Urbem\PrestacaoContasBundle\Helper\TribunaisHelper;
use Urbem\RedeSimplesBundle\Service\Protocolo\Cache\ArrayCollectionCache;
use Urbem\RedeSimplesBundle\Service\Protocolo\ParameterBag;
use Urbem\RedeSimplesBundle\Service\Protocolo\Parse\FetchProcessor;
use Urbem\RedeSimplesBundle\Service\Protocolo\Result\Fetch;

class AbstractTceAdmin extends AbstractAdmin
{
    /**
     * @var array
     */
    public $relatorio;

    /**
     * @var bool
     */
    public $hasReportTitle = false;

    protected $strategy;

    protected $reportHash;

    /**
     * @var array
     */
    protected $parametersBagCustom = [
        'uf',
        'group',
        'hash',
    ];

    public function setStrategy($strategy)
    {
        $this->strategy = $strategy;
    }

    public function getStrategy()
    {
        return $this->strategy;
    }

    /**
     * @return mixed
     */
    public function getReportHash()
    {
        return $this->reportHash;
    }

    /**
     * @param mixed $reportHash
     */
    public function setReportHash($reportHash)
    {
        $this->reportHash = $reportHash;
    }

    /**
     * @param bool $appendId
     * @return array
     */
    public function getParametersBagCustom($appendId = false)
    {
        $params = [];

        foreach($this->parametersBagCustom as $parameterName) {
            if ($value = $this->getRequest()->get($parameterName)) {
                $params[$parameterName] = $value;
            }
        }

        if (true === $appendId) {
            $params[$this->getIdParameter()] = $this->getAdminRequestId();
        }

        return $params;
    }

    /**
     * @param \Sonata\AdminBundle\Route\RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('create', '{uf}/{group}/{hash}/create');
        $collection->add('service', '{uf}/{group}/{hash}/service');
    }

    /**
     * @return mixed
     */
    public function loadStrategy()
    {
        // Detalhes do tipo de relatório
        $this->getRelatorio();

        // Strategy
        $className = array_key_exists("className", $this->relatorio) ? $this->relatorio['className'] : null;
        $this->setStrategy(
            $this->getContainer()->get('prestacao_contas.service.tce.configuracao_factory')->build($className)
        );

        return $this->getStrategy();
    }

    /**
     * @param $fields
     * @return FormBuilder
     */
    protected function createFormBuilder($fields)
    {
        return new FormBuilder(
            new FetchProcessor(),
            new FieldsFetcher(),
            new ArrayParser(),
            new ArrayCollectionCache(),
            new ParameterBag([
                'fields' => $fields
            ])
        );
    }

    /**
     * @param $action
     * @param $message
     */
    protected function addMessage($action, $message)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->add($action, $message);
    }

    /**
     * @param bool $appendId
     */
    protected function configureBreadCrumb($appendId = false)
    {
        $this->setBreadCrumb($this->getParametersBagCustom($appendId));
    }

    /**
     * @return null
     */
    public function getRelatorio()
    {
        $parameters = $this->getParametersBagCustom();

        $uf = $parameters['uf'];
        $group = $parameters['group'];
        $hash = $parameters['hash'];

        $this->setReportHash($hash);

        $tribunal = TribunaisHelper::getContentJsonReportListByUF(strtoupper($uf));
        $itemsReport = array_key_exists($group, $tribunal) ?  $tribunal[$group] : [];

        $items = $itemsReport['itens'];
        $report = ArrayHelper::searchBy("reportHash", $hash, $items);
        $title = sprintf("%s - %s", $itemsReport['title'], $report['label']);
        /*Se necessario ajustaremos para pegar o titulo de forma inteligente 100% com base no report ou json*/
        $complementTitle = $uf == 'stn' ? "STN - " : sprintf("TCE %s - ", strtoupper($uf));
        $report['titlePage'] = $complementTitle . $title;

        return $this->relatorio = $report;
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return (string) $this->relatorio['titlePage'];
    }

    /**
     * @return string
     */
    public function getUrlServiceProvider()
    {
        return $this->generateUrl('service', [], $absolute = UrlGeneratorInterface::ABSOLUTE_PATH);
    }

    /**
     * @param string $name
     * @param array $parameters
     * @param bool|int $absolute
     * @return string
     */
    public function generateUrl($name, array $parameters = array(), $absolute = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        if (true === in_array($name, ['create', 'list', 'show', 'service'])) {
            $parameters = array_merge($parameters, $this->getParametersBagCustom());
            $parameters['uniqid'] = $this->getUniqid();

            if ('show' === $name && false === array_key_exists('id', $parameters)) {
                $parameters[$this->getIdParameter()] = $this->getAdminRequestId();
            }

            return $this->routeGenerator->generate(sprintf('%s_%s', $this->baseRouteName, $name), $parameters);
        }

        return $this->routeGenerator->generateUrl($this, $name, $parameters, $absolute);
    }

    /**
     * void
     */
    protected function checkPageTitleWhenTheFormHasNoTitleBetweenTheFields()
    {
        $firstField = current($this->relatorio['parameters']);
        if ($firstField["type"] == Fetch\Field::TYPE_TITLE) {
            return;
        }

        $titleFieldType = [
            "name" => $this->relatorio["titlePage"],
            "label" => $this->relatorio["titlePage"],
            "type" => "title",
        ];

        $newFieldGroup = [
            $titleFieldType,
        ];

        foreach ($this->relatorio['parameters'] as $parameter) {
            array_push($newFieldGroup, $parameter);
        }

        $this->relatorio['parameters'] = $newFieldGroup;
        $this->hasReportTitle = true;
    }
}
