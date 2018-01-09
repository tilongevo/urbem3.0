<?php

namespace Urbem\RedeSimplesBundle\Tests\Service\Protocolo\Parse\Implementation\JSON;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Form\Extension\Core\CoreExtension;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\Validator\ConstraintViolationList;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherResult;
use Urbem\RedeSimplesBundle\Service\Protocolo\Parse\FetchProcessor;
use Urbem\RedeSimplesBundle\Service\Protocolo\Parse\Implementation\JSON\JsonParser;
use Urbem\RedeSimplesBundle\Service\Protocolo\Result\Fetch\FieldInterface;

class FetchProcessorTest extends WebTestCase
{
    public function testShouldParseJson()
    {
        $form = ['form' => []];
        $form['form']['fields'] = [];
        $form['form']['fields'][] = [
            'name' => 'text_field',
            'type' => 'text',
            'required' => true,
            'label' => 'Text Field',
        ];

        $form['form']['fields'][] = [
            'name' => 'textarea_field',
            'type' => 'textarea',
            'label' => 'Text Area Field',
        ];

        $form['form']['fields'][] = [
            'name' => 'select_field',
            'type' => 'select',
            'label' => 'Select Field',
            'choices' => [
                ['value' => 1, 'label' => 'my select label 1'],
                ['value' => 2, 'label' => 'my select label 2'],
            ]
        ];

        $form['form']['fields'][] = [
            'name' => 'checkbox_field',
            'type' => 'checkbox',
            'label' => 'Checkbox Field',
            'choices' => [
                ['value' => 1, 'label' => 'my checkbox label 1'],
                ['value' => 2, 'label' => 'my checkbox label 2'],
            ]
        ];

        $form['form']['fields'][] = [
            'name' => 'radio_field',
            'type' => 'radio',
            'label' => 'Radio Field',
            'choices' => [
                ['value' => 1, 'label' => 'my radio label 1'],
                ['value' => 2, 'label' => 'my radio label 2'],
            ]
        ];

        $form['form']['fields'][] = [
            'name' => 'multiple_field',
            'type' => 'multiple',
            'label' => 'Multiple Field',
            'choices' => [
                ['value' => 1, 'label' => 'my multiple label 1'],
                ['value' => 2, 'label' => 'my multiple label 2'],
            ]
        ];

        $form = json_encode($form);

        $processor = new FetchProcessor();
        $fieldCollection = $processor->process(new FetcherResult($form), new JsonParser());

        $this->assertCount(6, $fieldCollection);
        $this->assertFalse($fieldCollection->offsetExists(6));
        $this->assertInstanceOf(FieldInterface::class, $fieldCollection->offsetGet(0));
        $this->assertInstanceOf(FieldInterface::class, $fieldCollection->offsetGet(1));
        $this->assertInstanceOf(FieldInterface::class, $fieldCollection->offsetGet(2));
        $this->assertInstanceOf(FieldInterface::class, $fieldCollection->offsetGet(3));
        $this->assertInstanceOf(FieldInterface::class, $fieldCollection->offsetGet(4));
        $this->assertInstanceOf(FieldInterface::class, $fieldCollection->offsetGet(5));

        $validator = $this->getMock('\Symfony\Component\Validator\Validator\ValidatorInterface');
        $validator->method('validate')->will($this->returnValue(new ConstraintViolationList()));

        $factory = Forms::createFormFactoryBuilder()
            ->addExtension(new CoreExtension())
            ->addTypeExtension(new FormTypeValidatorExtension($validator))
            ->getFormFactory();

        $builder = $factory->createBuilder();

        foreach ($fieldCollection as $field) {
            $builder->add($field->getName(), $field->getType(), $field->getOptions());
        }

        $this->assertEquals('Text Field', $builder->getForm()->get('text_field')->getConfig()->getOption('label'));
        $this->assertFalse($builder->getForm()->get('text_field')->getConfig()->getOption('mapped'));
        $this->assertCount(1, $builder->getForm()->get('text_field')->getConfig()->getOption('constraints'));

        $this->assertEquals('Text Area Field', $builder->getForm()->get('textarea_field')->getConfig()->getOption('label'));
        $this->assertFalse($builder->getForm()->get('textarea_field')->getConfig()->getOption('mapped'));
        $this->assertCount(0, $builder->getForm()->get('textarea_field')->getConfig()->getOption('constraints'));

        $this->assertEquals('Select Field', $builder->getForm()->get('select_field')->getConfig()->getOption('label'));
        $this->assertFalse($builder->getForm()->get('select_field')->getConfig()->getOption('mapped'));
        $this->assertCount(2, $builder->getForm()->get('select_field')->getConfig()->getOption('choices'));

        $this->assertEquals('Checkbox Field', $builder->getForm()->get('checkbox_field')->getConfig()->getOption('label'));
        $this->assertFalse($builder->getForm()->get('checkbox_field')->getConfig()->getOption('mapped'));
        $this->assertCount(2, $builder->getForm()->get('checkbox_field')->getConfig()->getOption('choices'));

        $this->assertEquals('Radio Field', $builder->getForm()->get('radio_field')->getConfig()->getOption('label'));
        $this->assertFalse($builder->getForm()->get('radio_field')->getConfig()->getOption('mapped'));
        $this->assertCount(2, $builder->getForm()->get('radio_field')->getConfig()->getOption('choices'));

        $this->assertEquals('Multiple Field', $builder->getForm()->get('multiple_field')->getConfig()->getOption('label'));
        $this->assertFalse($builder->getForm()->get('multiple_field')->getConfig()->getOption('mapped'));
        $this->assertCount(2, $builder->getForm()->get('multiple_field')->getConfig()->getOption('choices'));
    }
}
