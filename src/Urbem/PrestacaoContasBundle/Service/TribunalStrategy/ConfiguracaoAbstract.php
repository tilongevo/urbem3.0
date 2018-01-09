<?php

namespace Urbem\PrestacaoContasBundle\Service\TribunalStrategy;

use Doctrine\ORM\Mapping\ClassMetadata;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Urbem\CoreBundle\Exception\Error;
use Urbem\PrestacaoContasBundle\Admin\RelatorioConfiguracaoAdmin;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\PrestacaoContasBundle\Enum\FieldsAndData;
use Urbem\PrestacaoContasBundle\Service\Form\FormExplorer;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataView;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ConfiguracaoAbstract
 * @package Urbem\PrestacaoContasBundle\Service\TribunalStrategy
 */
abstract class ConfiguracaoAbstract
{
    const ID_SEPARATOR = ModelManager::ID_SEPARATOR;

    const DATA_KEY = 'data';
    const VALUE_KEY = 'value';

    const PROCESS_ST_CNPJ_SETOR = 'StCnpjSetor';
    const PROCESS_ENTIDADE = 'Entidade';
    const PROCESS_TWO_MONTHS = 'TwoMonths';
    const PROCESS_QUARTER = 'Quarter';
    const PROCESS_FOUR_MONTH_PERIOD = 'FourMonthPeriod';
    const PROCESS_DATE_TIME_FORMAT = 'DateTimeFormat';
    const PROCESS_REPORT_TYPE = 'ReportType';
    const PROCESS_FILES = 'Files';
    const PROCESS_MONTH = 'Month';
    const FIEL_COLLECTION_DATA = "formDynamicCollection";

    const NAMESPACE_PROCESS_CLASS = "Urbem\\PrestacaoContasBundle\\Service\\TribunalStrategy\\DataProcessing\\%s";

    protected $errorMessage;

    /**
     * @var \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoFactory
     */
    protected $factory;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected static $entityManager;

    /**
     * @var RelatorioConfiguracaoAdmin
     */
    protected $relatorioConfiguracao;

    /**
     * @var \Symfony\Component\Form\Form $form
     */
    private $form;

    private $request;

    private $formSonata;


    /**
     * ConfiguracaoAbstract constructor.
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoFactory $factory
     */
    public function __construct(ConfiguracaoFactory $factory)
    {
        $this->factory = $factory;
        self::$entityManager = $this->factory->getEntityManager();
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepository($class)
    {
        return $this->factory
            ->getEntityManager()
            ->getRepository($class);
    }

    /**
     * @return ClassMetadata
     */
    protected function getClassMetadata($class)
    {
        return $this->factory
            ->getEntityManager()
            ->getClassMetadata($class);
    }

    /**
     * @return object|FormFactory
     */
    protected function getFormFactory()
    {
        return $this->relatorioConfiguracao
            ->getConfigurationPool()
            ->getContainer()
            ->get('form.factory');
    }

    /**
     * @param FormInterface $form
     * @return string
     */
    protected function getFormErrorAsMessage(FormInterface $form)
    {
        /** @var FormExplorer $formExplorer */
        $formExplorer = $this->relatorioConfiguracao
            ->getConfigurationPool()
            ->getContainer()
            ->get('prestacao_contas.form.explorer');

        $message = [];

        foreach ($formExplorer->errorToArray($form) as $error) {
            $message[] = sprintf('[%s] (%s)', $error['label'], $error['message']);
        }

        return implode("<br />", $message);
    }

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param mixed $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @param $className
     * @return string
     */
    private function getClassDataProcessing($className)
    {
        return sprintf(
            self::NAMESPACE_PROCESS_CLASS,
            $className
        );
    }

    /**
     * @return array
     */
    public function includeJs()
    {
        return [];
    }

    /**
     * @return bool
     */
    public function save()
    {

    }

    /**
     * @return array
     * @deprecated use method load
     * @see src/Urbem/PrestacaoContasBundle/Admin/RelatorioTceAdmin.php
     * @see src/Urbem/PrestacaoContasBundle/Admin/RelatorioConfiguracaoAdmin.php
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        return ['response' => true];
    }

    /**
     * @param TwigEngine|null $templating
     * @return array
     */
    protected function doAction(TwigEngine $templating = null)
    {
        $action = (string) $this->getRequest()->get('action');
        $action = sprintf('action%s', ucfirst($action));

        if (false === method_exists($this, $action)) {
            return [
                'response' => false,
                'message' => sprintf('action %s not found', $action)
            ];
        }

        try {
            return [
                'response' => true,
            // action* methods must always return an array
            ] + call_user_func_array([$this, $action], [$templating]);

        } catch (\Exception $e) {
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param \Symfony\Component\Form\Form|null $form
     */
    public function setContentForm(Form $form = null)
    {
        $this->form = $form;
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return mixed
     */
    public function getFormSonata()
    {
        return $this->formSonata;
    }

    /**
     * @param mixed $formSonata
     */
    public function setFormSonata($formSonata)
    {
        $this->formSonata = $formSonata;
    }

    /**
     * @param array $parameters
     * @param array|null $form
     * @return array
     */
    public function preBuildForm(array $parameters, array $form = null)
    {
        return $parameters;
    }

    /**
     * @return string
     */
    public function dynamicBlockJs()
    {
        return sprintf("var UrlServiceProviderTCE = '%s';", $this->relatorioConfiguracao->getUrlServiceProvider());
    }

    /**
     * @return array
     */
    public function processParameters()
    {
        $value = [];
        /** @var \Symfony\Component\Form\Form $field */
        foreach ($this->getForm() as $field) {
            $value[$field->getName()] = $field->getData();
        }

        return $value;
    }

    /**
     * @return \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection
     */
    public function processParametersCollection()
    {
        $dataCollection = new DataCollection();

        /** @var Form $field */
        foreach ($this->getForm() as $field) {
            $dataView = new DataView();
            $dataView->setName($field->getName());
            $dataView->setValue($field->getData());
            $dataView->setLabel($field->getConfig()->getOption('label'));
            $dataView->setText($field->getData());

            $dataCollection->add($dataView);
        }

        return $dataCollection;
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     * @return \Sonata\AdminBundle\Form\FormMapper
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        // Possível reaproveitamento
        $this->relatorioConfiguracao = $objectAdmin;
        return $formMapper;
    }

    /**
     * @return ConfiguracaoModel
     */
    protected function getConfiguracaoRepository()
    {
        return new ConfiguracaoModel($this->factory->getEntityManager());
    }

    /**
     * @return \Urbem\CoreBundle\Repository\Orcamento\EntidadeRepository
     */
    protected function getEntidadeRepository()
    {
        return $this->factory->getEntityManager()->getRepository(Entidade::class);
    }

    /**
     * @param $fieldName
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function getDataCollectionFromField($fieldName)
    {
        return $this->getForm()->get($fieldName)->get('dynamic_collection');
    }

    /**
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection $params
     * @return mixed|null
     */
    protected function getStCnpjSetor(DataCollection $params)
    {
        if ($setorGoverno = $params->findObjectByName(FieldsAndData::ST_CNPJ_SETOR_NAME)) {
            list( , $codEntidade) = explode("~", $this->getValueWhenArray($setorGoverno->getValue()));
            $entidade = $this->getEntidadeRepository();

            return $entidade->getCnpjByCodEntidade($codEntidade, $this->factory->getSession()->getExercicio());
        }

        return null;
    }

    // HotFix
    private function getValueWhenArray($value) {
        if (is_array($value)) {
            return key($value);
        }

        return $value;
    }

    /**
     * @param string $value
     * @return string
     */
    protected function getCodEntidade($value)
    {
        if ($value) {
            list($exercicio, $codEntidade) = explode("~", $value);

            return $codEntidade;
        }

        return $value;
    }

    /**
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection $dataCollection
     * @param $classProcess
     * @return mixed
     * @throws \Exception
     */
    protected function processInformationByData(DataCollection $dataCollection, $classProcess)
    {
        if (empty($classProcess)) {
            throw new \Exception(Error::CLASS_NOT_FOUND);
        }

        try {
            $class = $this->getClassDataProcessing($classProcess);
            $class = new $class($this->factory, $dataCollection);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $class->process();
    }

    /**
     * @param \Sonata\CoreBundle\Validator\ErrorElement $errorElement
     */
    public function validate(ErrorElement $errorElement)
    {
        /*Customize de acordo com a necessidade*/
    }

    public function load(FormMapper $formMapper)
    {

    }

    public function setAdmin(AbstractAdmin $admin)
    {
        $this->relatorioConfiguracao = $admin;
    }
}
