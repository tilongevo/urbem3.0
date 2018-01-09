<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Result\Fetch;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\NotNull;

class Field extends AbstractType implements FieldInterface
{
    const TYPE_TITLE = "title";

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $subtype;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var mixed
     */
    protected $style;

    /**
     * @var array
     */
    protected $extra = [];

    /**
     * @var bool
     */
    protected $required;

    /**
     * @var array
     */
    protected $choices;

    /**
     * @var bool
     */
    protected $multiple;

    /**
     * Field constructor.
     * @param array $props
     */
    public function __construct(array $props)
    {
        $types = [
            'text' => TextType::class,
            'entity' => EntityType::class,
            'date' => DateType::class,
            'time' => TextType::class,
            'datetime' => TextType::class,
            'numeric' => NumberType::class,
            'decimal' => TextType::class,
            'textarea' => TextareaType::class,
            'select' => ChoiceType::class,
            'checkbox' => ChoiceType::class,
            'radio' => ChoiceType::class,
            'multiple' => ChoiceType::class,
        ];

        $this->name = (string) $props['name'];
        $this->subtype = (string) $props['type'];
        $this->style = !empty($props['style']) ? (string) $props['style'] : null;
        $this->extra['return_object_key'] = true === array_key_exists('return_object_key', $props) ? $props['return_object_key'] : null;
        $this->extra['field_not_in'] = true === array_key_exists('field_not_in', $props) ? $props['field_not_in'] : null;
        $this->type = true === array_key_exists($this->subtype, $types) ? $types[$this->subtype] : $this->subtype;
        $this->label = (string) $props['label'];
        $this->data = $props['data'];
        $this->required = (boolean) $props['required'];
        $this->multiple = true === array_key_exists('multiple', $props) ? $props['multiple'] : null;

        if ($props['auto_populate'] === true) {
            foreach ($props['choices'] as $choice) {
                $this->data[] = $choice['value'];
            }
        }

        foreach ($props['choices'] as $choice) {
            $this->choices[$choice['label']] = $choice['value'];
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed|string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return [
            'data' => $this->data,
            'label' => $this->label,
            'mapped' => false,
            'required' => $this->required,
        ] +
            $this->getMultiple() +
            $this->getConstraints() +
            $this->getChoices() +
            $this->getTypeDate() +
            $this->getTypeNumeric() +
            $this->getExtra();
    }

    /**
     * @return array
     */
    protected function getTypeNumeric()
    {
        $class = [];

        if (true === in_array($this->subtype, ['numeric', 'decimal'])) {
            $class['attr'] = ['class' => "protocolo-{$this->subtype} "];
        }

        return $class;
    }

    /**
     * @return array
     */
    protected function getTypeDate()
    {
        $class = [];

        if (true === in_array($this->subtype, ['date'])) {
            $class['attr'] = [
                'data-provide' => 'datepicker',
                'class' => 'datepicker ',
                'maxlength' => '10'
            ];
            $class['format'] = 'MM/dd/yyyy';
            $class['widget'] = 'single_text';
            $class['html5'] = false;
        }

        return $class;
    }

    /**
     * @return array
     */
    protected function getMultiple()
    {
        $multiple = [];

        if (false === is_null($this->multiple)) {
            $multiple['multiple'] = $this->multiple;
        }

        return $multiple;
    }

    /**
     * @return array
     */
    protected function getChoices()
    {
        /* http://symfony.com/doc/current/reference/forms/types/choice.html */
        $options = [
            'select'    => ['expanded' => false,    'multiple' => false],
            'multiple'  => ['expanded' => false,    'multiple' => true],
            'radio'     => ['expanded' => true,     'multiple' => false],
            'checkbox'  => ['expanded' => true,     'multiple' => true],
        ];

        $choices = [];

        if (true === in_array($this->subtype, ['select', 'checkbox', 'radio', 'multiple',])) {
            $style = $this->getStyle();
            $choices['attr'] = ['class' => empty($style) ? "select2-parameters " : $style];
            $choices['choices'] = $this->choices;
            $choices = array_merge($choices, $options[$this->subtype]);
        }

        return $choices;
    }

    /**
     * @return array
     */
    protected function getConstraints()
    {
        $constraints = ['constraints' => []];

        if (true === $this->required) {
            $constraints['constraints'][] = new NotNull();
        }

        return 0 < count($constraints['constraints']) ? $constraints : [];
    }

    /**
     * @return array
     */
    protected function getExtra()
    {
        $value = [];

        if (false === is_null($this->extra['return_object_key'])) {
            $value['return_object_key'] = $this->extra['return_object_key'];
        }

        if (false === is_null($this->extra['field_not_in'])) {
            $value['field_not_in'] = $this->extra['field_not_in'];
        }

        return $value;
    }
}
