<?php

namespace Urbem\CoreBundle\Twig;
use Urbem\CoreBundle\Helper\ArrayHelper;

/**
 * Class FormElementsExtension
 * @package Urbem\CoreBundle\Twig
 */
class FormElementsExtension extends \Twig_Extension
{
    const CSS_SELECT2_MULTIPLE_OPTIONS_CUSTOM = "select2-multiple-options-custom";

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('countElementsTypeMultipleOptions', array($this, 'countElementsTypeMultipleOptions')),
            new \Twig_SimpleFilter('collectionDynamicFormToJson', array($this, 'getCollectionDynamicFormToJson')),
        );
    }

    /**
     * @param $elements
     * @return int
     */
    public function countElementsTypeMultipleOptions($elements)
    {
        $elementsMultipleOptions = 0;
        foreach($elements as $element) {
            $this->parseElementSearchClassByItem($element, self::CSS_SELECT2_MULTIPLE_OPTIONS_CUSTOM, $elementsMultipleOptions);
        }

        return $elementsMultipleOptions;
    }

    /**
     * @param $element
     * @param $classSearch
     * @param $elementsCount
     * @return bool|void
     */
    private function parseElementSearchClassByItem($element, $classSearch, &$elementsCount)
    {
        if (!property_exists($element, 'options')) {
            return;
        }

        $options = $element->getOptions();
        if (!array_key_exists("field_options", $options)) {
            return;
        }

        $fieldOptions = $options['field_options'];
        if (!array_key_exists("attr", $fieldOptions)) {
            return;
        }

        $attr = $fieldOptions['attr'];
        if (!array_key_exists("class", $attr)) {
            return;
        }

        /*Conta elementos com base em pesquisa pré-definida*/
        strpos($attr["class"], $classSearch) !== false ? $elementsCount++ : null;

        return true;
    }

    /**
     * @param $collection
     * @return string
     */
    public function getCollectionDynamicFormToJson($collection)
    {
        $jsonData = [];
        foreach($collection->children as $key => $formView) {
            foreach($formView->children as $nomeCampo => $dados) {
                $jsonField = [];
                $jsonField["name"] = $dados->vars["name"];
                $jsonField["full_name"] = $dados->vars["full_name"];
                $jsonField["label"] = $dados->vars["label"];
                $jsonField["data"] = $dados->vars["data"];

                $jsonData[$key][] = $jsonField;
            }
        }

        return json_encode($jsonData);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'form_elements_extension';
    }
}
