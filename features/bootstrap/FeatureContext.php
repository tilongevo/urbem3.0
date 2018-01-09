<?php

namespace Context;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Mink\Driver\BrowserKitDriver;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements KernelAwareContext
{
    protected $session;
    protected $container;
    private $kernel;
    const FILE_ERROR_BEHAT = __DIR__;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct($session, $container)
    {
        $this->container = $container;
        $this->session = $session;
    }

    /**
     * @AfterStep
     * @param \Behat\Behat\Hook\Scope\AfterStepScope $scope
     */
    public function afterStep(\Behat\Behat\Hook\Scope\AfterStepScope $scope)
    {
        $fileError = self::FILE_ERROR_BEHAT . "/../../var/falha-teste-behat.log";
        if (!$scope->getTestResult()->isPassed()) {
            file_put_contents($fileError, $this->getSession()->getPage()->getHtml());

            echo "VERIFIQUE O ARQUIVO LOCALIZADO EM => " . $fileError;
        }
    }

    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    protected function getContainer()
    {
        return $this->kernel->getContainer();
    }

    /**
     * @Given /^I wait for (\d+) seconds$/
     */
    public function iWaitForSeconds($seconds)
    {
        $this->getSession()->wait($seconds * 1000);
    }

    /**
     * Fills in form field with specified id|name|label|value
     * Using regex
     *
     * @Then /I fill field with uniqueId as "([^"]*)" with "([^"]*)" when field is "([^"]*)"$/
     * @Then /I fill field with uniqueId as "([^"]*)" with "([^"]*)"$/
     */
    public function fillFieldWithUniqueId($fieldSearch, $value, $fieldType = 'input')
    {
        $field = $this->getNameFieldUsingRegex($fieldSearch);
        $field = $this->fixStepArgument($field);
        $value = $this->fixStepArgument($value);
        switch ($fieldType) {
            case 'inputByName':
                $field = $this->getNameFieldUsingRegex($fieldSearch, "name");
                $this->getSession()->getPage()->find('css', 'input[name="'.$field.'"]')->setValue($value);
                break;
            case 'input':
                $this->getSession()->getPage()->fillField($field, $value);
                break;
            case 'select':
                $this->getSession()->getPage()->selectFieldOption($field, $value);
                break;
            case 'radio':
            case 'checkbox':
                $this->getSession()->getPage()->$value($field);
                break;
            default:
                throw new NotFoundResourceException(sprintf('Field type "%s" not found.', $fieldType));
                break;
        }
    }

    /**
     * @Given /^I am authenticated as "([^"]*)" with "([^"]*)"$/
     */
    public function iAmAuthenticatedAs($username, $password)
    {
        $this->visit("/login");
        $this->fillField("username", $username);
        $this->fillField("password", $password);
        $this->pressButton("_submit");
    }

    protected function getNameFieldUsingRegex($field, $searchFieldBy = "id")
    {
        // Pesquisa feita pelo nome ou id
        $regex = ($searchFieldBy == 'name')
            ? sprintf("(\w+\[%s\])", $field)
            : "/(s[\w]{13}+_%s)/"
        ;

        $fieldRegex = sprintf($regex, $field);
        $pageContent = $this->getSession()->getPage()->getHtml();

        preg_match_all($fieldRegex, $pageContent, $matches);
        if (empty($matches)) {
            return $field;
        }

        $response = array_shift($matches);

        if (is_array($response)) {
            $response = array_shift($response);
        }

        if (is_null($response)){
            throw new NotFoundResourceException(sprintf('Field type "%s" not found.', $field));
        }

        return $response;
    }

    /**
     * @Given /^I Follow to url "([^"]*)"$/
     * @param $action
     */
    public function iFollowTo($action)
    {
        $action = $this->fixStepArgument($action);
        $this->visit($this->getUrl($action));
    }

    /**
     * @Given /^I search by "([^"]*)" in "([^"]*)" and follow to "([^"]*)"$/
     * @param $fielValue, $fieldName, $action
     */
    public function iSearchByAndFollow($fielValue, $fieldName, $action)
    {
        $this->fillField($fieldName, $fielValue);
        $this->pressButton("search");
        $this->iFollowTo($action);
    }

    private function getUrl($action)
    {
        $action = $this->fixStepArgument($action);
        $links = $this
                    ->getSession()
                    ->getPage()
                    ->find('css', 'table tbody tr td:last-child')
                    ->getHtml()
        ;

        if (empty($links)) {
            throw new NotFoundResourceException('Celula não encontrada');
        }

        preg_match_all('/href=["\']?([^"\'>]+)["\']?/', $links, $maches);

        if (!count($maches)) {
            throw new NotFoundResourceException('URL\'s não encontradas');
        }

        if (!array_key_exists(1, $maches)) {
            throw new NotFoundResourceException('URL\'s absolutas não encontradas');
        }

        foreach ($maches[1] as $value) {
            if (strpos($value, $action) !== false) {
                return $value;
            }
        }

        throw new NotFoundResourceException(sprintf('Action %s não encontrada.', $action));
    }
}
