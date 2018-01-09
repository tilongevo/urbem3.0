<?php

namespace Urbem\CoreBundle\Tests\Unit\Form;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\PreloadedExtension;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;

class AutoCompleteFormTypeTest extends WebTestCase
{
    protected function getQueryMock()
    {
        $query = $this->getMockBuilder(AbstractQuery::class)
            ->setMethods(array('getResult'))
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $query->method('getResult')->willReturn([
            new MockEntity(1, 2, 'Entity 01'),
            new MockEntity(3, 4, 'Entity 02'),
            new MockEntity(5, 6, 'Entity 03'),
        ]);

        return $query;
    }

    protected function getQueryBuilderMock(EntityManager $em)
    {
        $qb = $this->getMockBuilder(QueryBuilder::class)
            ->setMethods(['getQuery'])
            ->setConstructorArgs([$em])
            ->getMock();

        $qb->method('getQuery')->willReturn($this->getQueryMock());

        return $qb;
    }

    protected function getRepositoryMock(EntityManager $em)
    {
        $repository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['createQueryBuilder', 'find'])
            ->getMock();

        $repository->method('find')->willReturn(new MockEntity(1, 2, 'Entity 01'));
        $repository->method('createQueryBuilder')->willReturn($this->getQueryBuilderMock($em));

        return $repository;
    }

    protected function getClassMetadataMock()
    {
        $repository = $this
            ->getMockBuilder(ClassMetadataInfo::class)
            ->disableOriginalConstructor()
            ->setMethods(['getIdentifierValues', 'getIdentifierFieldNames'])
            ->getMock();

        $repository->method('getIdentifierValues')->will($this->onConsecutiveCalls(
            [0, 0],
            [1, 2],
            [3, 4],
            [5, 6]
        ));
        $repository->method('getIdentifierFieldNames')->willReturn(['columnOne', 'columnTwo']);


        return $repository;
    }

    protected function getEntityManagerMock($full = false)
    {
        $em = $this->getMockBuilder(EntityManager::class);

        if ($full) {
            $em->setMethods(['getRepository', 'getClassMetadata', 'find']);
        }

        $em->disableOriginalConstructor();
        $em = $em->getMock();

        if ($full) {
            $em
                ->expects($this->any())
                ->method('getRepository')
                ->willReturn($this->getRepositoryMock($em));

            $em
                ->expects($this->any())
                ->method('getClassMetadata')
                ->willReturn($this->getClassMetadataMock());
        }

        return $em;
    }

    public function testShouldCreateViewWithoutEntity()
    {
        $factory = Forms::createFormFactoryBuilder()->addExtensions([
            new PreloadedExtension(
                [
                new AutoCompleteType($this->getEntityManagerMock()),
                ],
                []
            )])->getFormFactory();

        $form = $factory->createBuilder(FormType::class, ['field' => 'Test'])->add('field', AutoCompleteType::class, [
            'route' => ['name' => 'test'],
        ])->getForm();

        // before submit (with preset data)
        $this->assertEquals([
            0 => 'Test',
            '_labels' => [
                0 => 'Test',
            ]
        ], $form->get('field')->getViewData());

        $this->assertEquals('Test', $form->get('field')->getData());

        // submit
        $form->submit(['field' => 'Test Submitted']);

        // after submit
        $this->assertEquals([
            0 => 'Test Submitted',
            '_labels' => [
                0 => 'Test Submitted'
            ]
        ], $form->get('field')->getViewData());

        $this->assertEquals('Test Submitted', $form->get('field')->getData());
    }

    public function testShouldCreateViewMultipleWithoutEntity()
    {
        $factory = Forms::createFormFactoryBuilder()->addExtensions([
            new PreloadedExtension(
                [
                new AutoCompleteType($this->getEntityManagerMock()),
                ],
                []
            )])->getFormFactory();

        $form = $factory->createBuilder(FormType::class, ['field' => ['Test 1', 'Test 2']])->add('field', AutoCompleteType::class, [
            'route' => ['name' => 'test'],
            'multiple' => true,
        ])->getForm();

        // before submit (with preset data)
        $this->assertEquals([
            0 => 'Test 1',
            1 => 'Test 2',
            '_labels' => [
                0 => 'Test 1',
                1 => 'Test 2',
            ]
        ], $form->get('field')->getViewData());

        $this->assertEquals('Test 1', $form->get('field')->getData()[0]);
        $this->assertEquals('Test 2', $form->get('field')->getData()[1]);

        // submit
        $form->submit(['field' => ['Test 1 Submitted', 'Test 2 Submitted']]);

        // after submit
        $this->assertEquals([
            0 => 'Test 1 Submitted',
            1 => 'Test 2 Submitted',
            '_labels' => [
                0 => 'Test 1 Submitted',
                1 => 'Test 2 Submitted'
            ]
        ], $form->get('field')->getViewData());

        $this->assertEquals('Test 1 Submitted', $form->get('field')->getData()['Test 1 Submitted']);
        $this->assertEquals('Test 2 Submitted', $form->get('field')->getData()['Test 2 Submitted']);
    }

    public function testShouldCreateViewWithEntity()
    {
        $factory = Forms::createFormFactoryBuilder()->addExtensions([
            new PreloadedExtension(
                [
                new AutoCompleteType($this->getEntityManagerMock(true)),
                ],
                []
            )])->getFormFactory();

        $form = $factory->createBuilder(FormType::class, ['field' => new MockEntity(0, 0, 'Entity 0')])->add('field', AutoCompleteType::class, [
            'route' => ['name' => 'test'],
            'class' => 'MockClass',
            'multiple' => false,
        ])->getForm();

        // before submit (with preset data)
        $this->assertEquals([
            0 => '0~0',
            '_labels' => [
                0 => 'Entity 0',
            ]
        ], $form->get('field')->getViewData());

        $class = $form->get('field')->getData();
        $this->assertEquals('0-0-Entity 0', sprintf('%s-%s-%s', $class->columnOne, $class->columnTwo, $class->name));

        // submit form
        $form->submit(['field' => ['1~2']]);

        // after submit
        $this->assertEquals([
            0 => '1~2',
            '_labels' => [
                0 => 'Entity 01',
            ]
        ], $form->get('field')->getViewData());

        $class = $form->get('field')->getData();
        $this->assertEquals('1-2-Entity 01', sprintf('%s-%s-%s', $class->columnOne, $class->columnTwo, $class->name));
    }

    public function testShouldCreateViewWithMultipleEntity()
    {
        $factory = Forms::createFormFactoryBuilder()->addExtensions([
            new PreloadedExtension(
                [
                new AutoCompleteType($this->getEntityManagerMock(true)),
                ],
                []
            )])->getFormFactory();

        $form = $factory->createBuilder(FormType::class, ['field' => [new MockEntity(0, 0, 'Entity 0')]])->add('field', AutoCompleteType::class, [
            'route' => ['name' => 'test'],
            'class' => 'MockClass',
            'multiple' => true,
        ])->getForm();

        // before submit (with preset data)
        $this->assertEquals([
            0 => '0~0',
            '_labels' => [
                0 => 'Entity 0',
            ]
        ], $form->get('field')->getViewData());

        $this->assertCount(1, $form->get('field')->getData());

        $class = $form->get('field')->getData()[0];
        $this->assertEquals('0-0-Entity 0', sprintf('%s-%s-%s', $class->columnOne, $class->columnTwo, $class->name));

        // submit form
        $form->submit(['field' => ['1~2', '1~2', '1~2']]);

        // after submit
        $this->assertEquals([
            0 => '1~2',
            1 => '3~4',
            2 => '5~6',
            '_labels' => [
                0 => 'Entity 01',
                1 => 'Entity 02',
                2 => 'Entity 03'
            ]
        ], $form->get('field')->getViewData());

        $this->assertCount(3, $form->get('field')->getData());

        $class = $form->get('field')->getData()[0];
        $this->assertEquals('1-2-Entity 01', sprintf('%s-%s-%s', $class->columnOne, $class->columnTwo, $class->name));

        $class = $form->get('field')->getData()[1];
        $this->assertEquals('3-4-Entity 02', sprintf('%s-%s-%s', $class->columnOne, $class->columnTwo, $class->name));

        $class = $form->get('field')->getData()[2];
        $this->assertEquals('5-6-Entity 03', sprintf('%s-%s-%s', $class->columnOne, $class->columnTwo, $class->name));
    }

    public function testShouldUseCustomToString()
    {
        $factory = Forms::createFormFactoryBuilder()->addExtensions([
            new PreloadedExtension(
                [
                new AutoCompleteType($this->getEntityManagerMock(true)),
                ],
                []
            )])->getFormFactory();

        $form = $factory->createBuilder(FormType::class, ['field' => [new MockEntity(0, 0, 'Entity 0')]])->add('field', AutoCompleteType::class, [
            'route' => ['name' => 'test'],
            'class' => 'MockClass',
            'multiple' => true,
            'json_choice_label' => function ($entity) {
                return 'Custom - ' . (string) $entity;
            }
        ])->getForm();

        // before submit (with preset data)
        $this->assertEquals([
            0 => '0~0',
            '_labels' => [
                0 => 'Custom - Entity 0',
            ]
        ], $form->get('field')->getViewData());

        $this->assertCount(1, $form->get('field')->getData());

        $class = $form->get('field')->getData()[0];
        $this->assertEquals('0-0-Entity 0', sprintf('%s-%s-%s', $class->columnOne, $class->columnTwo, $class->name));

        // submit form
        $form->submit(['field' => ['1~2', '1~2', '1~2']]);

        // after submit
        $this->assertEquals([
            0 => '1~2',
            1 => '3~4',
            2 => '5~6',
            '_labels' => [
                0 => 'Custom - Entity 01',
                1 => 'Custom - Entity 02',
                2 => 'Custom - Entity 03'
            ]
        ], $form->get('field')->getViewData());

        $this->assertCount(3, $form->get('field')->getData());

        $class = $form->get('field')->getData()[0];
        $this->assertEquals('1-2-Entity 01', sprintf('%s-%s-%s', $class->columnOne, $class->columnTwo, $class->name));

        $class = $form->get('field')->getData()[1];
        $this->assertEquals('3-4-Entity 02', sprintf('%s-%s-%s', $class->columnOne, $class->columnTwo, $class->name));

        $class = $form->get('field')->getData()[2];
        $this->assertEquals('5-6-Entity 03', sprintf('%s-%s-%s', $class->columnOne, $class->columnTwo, $class->name));
    }
}
