<?php

namespace Urbem\CoreBundle\Doctrine\TypeConverter\Type;

use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Urbem\CoreBundle\Helper\StringHelper;

abstract class AbstractType
{
    /**
     * @var $em \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    const COMMAND_DROP_DEFAULT = 0;
    const COMMAND_DROP_CONSTRAINT = 2;
    const COMMAND_CREATE_CONSTRAINT = 3;
    const COMMAND_UPDATE_COLUMN_TYPE = 4;
    const COMMAND_UPDATE_COLUMN_VALUE = 5;
    const COMMAND_COMMENT = 6;

    /**
     * @var array
     */
    protected $updateList = [
        self::COMMAND_DROP_DEFAULT => [],
        self::COMMAND_DROP_CONSTRAINT => [],
        self::COMMAND_CREATE_CONSTRAINT => [],
        self::COMMAND_UPDATE_COLUMN_TYPE => [],
        self::COMMAND_UPDATE_COLUMN_VALUE => [],
        self::COMMAND_COMMENT => [],
    ];

    /**
     * @var array containing table.column for preventing an infinite looping
     */
    protected $preventInfiniteLoopingList = [];

    /**
     * @var \Doctrine\DBAL\Types\Type
     */
    protected $doctrineType;

    /**
     * AbstractType constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $table
     * @param $column
     */
    protected function commandDropDefault($table, $column)
    {
        $this->updateList[self::COMMAND_DROP_DEFAULT][] = sprintf('ALTER TABLE %s ALTER COLUMN "%s" DROP DEFAULT;', str_replace('"', '', $table), $column);
    }

    /**
     * @param $table
     * @param $constraint
     * @param $targetTable
     * @param array $sourceColumns
     * @param array $targetColumns
     */
    protected function commandConstraint($table, $constraint, $targetTable, array $sourceColumns, array $targetColumns)
    {
        $this->updateList[self::COMMAND_DROP_CONSTRAINT][] = sprintf('ALTER TABLE %s DROP CONSTRAINT "%s";', $table, $constraint);
        $this->updateList[self::COMMAND_CREATE_CONSTRAINT][] = sprintf('ALTER TABLE %s ADD CONSTRAINT "%s" FOREIGN KEY ("%s") REFERENCES %s ("%s");', $table, $constraint, implode('", "', $sourceColumns), $targetTable, implode('", "', $targetColumns));
    }

    /**
     * @param $table
     * @param $column
     */
    protected function commandUpdateColumn($table, $column)
    {
        $comment = $this->commandComment($table, $column);

        $this->updateList[self::COMMAND_COMMENT][$comment] = $comment;
        $this->updateList[self::COMMAND_UPDATE_COLUMN_TYPE][$table] = $this->createCommandUpdateColumnType($table, $column);

        if (true === array_key_exists($table, $this->updateList[self::COMMAND_UPDATE_COLUMN_VALUE])) {
            return;
        }

        $this->updateList[self::COMMAND_UPDATE_COLUMN_VALUE][$table] = $this->createCommandUpdateColumnValue($table, $column);
    }

    /**
     * @param $table
     * @param $column
     * @return null|string
     */
    protected function commandComment($table, $column)
    {
        $type = $this->getDoctrineType();

        if (false === in_array($type->getName(), Type::getTypesMap())) {
            return sprintf("COMMENT ON COLUMN %s.%s IS '%s'", $table, $column, $this->em->getConnection()->getDatabasePlatform()->getDoctrineTypeComment($type));
        }

        return null;
    }

    /**
     * @return \Doctrine\DBAL\Types\Type
     */
    protected function getDoctrineType()
    {
        if (null !== $this->doctrineType) {
            return $this->doctrineType;
        }

        $type = trim($this->getDoctrineTypeClassName(), ' \\');

        if (0 === strlen($type)) {
            throw new InvalidArgumentException(sprintf("Invalid return for getDoctrineTypeClassName on %s", static::class));
        }

        return $this->doctrineType = (new \ReflectionClass($type))->newInstanceWithoutConstructor();
    }

    /**
     * @param ClassMetadata $classMetadata
     * @param $column
     * @return bool if doctrine type match mapping information
     */
    protected function checkDoctrineType(ClassMetadata $classMetadata, $column)
    {
        $fieldName = $classMetadata->getFieldName($column);
        $type = $classMetadata->getTypeOfField($fieldName);

        if (true === in_array($this->getDoctrineType()->getName(), Type::getTypesMap())) {
            return true;
        }

        if ($type !== $this->getDoctrineType()->getName()) {
            throw new \OutOfBoundsException(
                sprintf(
                    'Type "%s" expected on "%s" (%s) mapping file. But "%s" was given.',
                    $this->getDoctrineType()->getName(),
                    $classMetadata->getName(),
                    $column,
                    $type
                )
            );
        }

        return true;
    }

    /**
     * @param $table
     * @param $column
     * @return string
     */
    abstract protected function createCommandUpdateColumnType($table, $column);

    /**
     * @param $table
     * @param $column
     * @return string
     */
    abstract protected function createCommandUpdateColumnValue($table, $column);

    /**
     * @return string
     */
    abstract protected function getDoctrineTypeClassName();

    /**
     * @param $className
     * @param $column
     *
     * @return array with SQL commands in the following order:
     * DROP DEFAULT
     * DROP CONSTRAINT (FK)
     * CREATE TMP DATA COLUMN (FOR FK DATA)
     * SET TMP DATA COLUMN
     * UPDATE COLUMN TYPE
     * UPDATE COLUMN DATA
     * RECREATE CONSTRAINT (FK)
     * DROP TMP DATA COLUN
     * COMMENT
     */
    public function getUpdateList($className, $column)
    {
        $this->generateUpdateList($className, $column);

        $return = array_filter(array_merge(
            array_values($this->updateList[self::COMMAND_DROP_DEFAULT]),
            array_values($this->updateList[self::COMMAND_DROP_CONSTRAINT]),
            array_values($this->updateList[self::COMMAND_UPDATE_COLUMN_TYPE]),
            array_values($this->updateList[self::COMMAND_UPDATE_COLUMN_VALUE]),
            array_values($this->updateList[self::COMMAND_CREATE_CONSTRAINT]),
            array_values($this->updateList[self::COMMAND_COMMENT])
        ));

        // awaiting usage feedback (ConverterFactory cache AbstractType instance)
        $this->updateList = array_map(function () {
            return [];
        }, $this->updateList);

        // awaiting usage feedback (ConverterFactory cache AbstractType instance)
        //$this->preventInfiniteLoopingList = [];

        return $return;
    }

    /**
     * @param array $oneToOne
     * @param $sourceColumn
     */
    protected function searchReferenced(array $oneToOne, $sourceColumn)
    {
        foreach ($oneToOne as $fk) {
            $classMetadata = $this->em->getClassMetadata($fk['targetEntity']);

            foreach ($classMetadata->getAssociationMapping($fk['mappedBy'])['sourceToTargetKeyColumns'] as $targetColumn => $referencedColumn) {
                if ($sourceColumn !== $referencedColumn) {
                    continue;
                }

                $this->generateUpdateList($classMetadata->getName(), $targetColumn);
            }
        }
    }

    /**
     * @param $sourceClassName
     * @param $sourceColumn
     */
    protected function generateUpdateList($sourceClassName, $sourceColumn)
    {
        $classMetadata = $this->em->getClassMetadata($sourceClassName);

        $this->searchReferenced(array_filter($classMetadata->getAssociationMappings(), function ($fk) {
            return false === $fk['isOwningSide'] && true === in_array($fk['type'], [ClassMetadata::ONE_TO_ONE, ClassMetadata::MANY_TO_ONE, ClassMetadata::ONE_TO_MANY]);
        }), $sourceColumn);

        if (true === array_key_exists($sourceClassName.$sourceColumn, $this->preventInfiniteLoopingList)) {
            return;
        }

        $this->preventInfiniteLoopingList[$sourceClassName . $sourceColumn] = true;

        $sourceTable = $classMetadata->getTableName();

        if (null !== $classMetadata->getSchemaName()) {
            $sourceTable = $classMetadata->getSchemaName() . '.' . $sourceTable;
        }

        $this->checkDoctrineType($classMetadata, $sourceColumn);

        $this->commandDropDefault($sourceTable, $sourceColumn);
        $this->commandUpdateColumn($sourceTable, $sourceColumn);

        /** @var $foreignKey \Doctrine\DBAL\Schema\ForeignKeyConstraint */
        foreach ($this->em->getConnection()->getSchemaManager()->listTableForeignKeys($sourceTable) as $foreignKey) {
            $sourceColumns = $foreignKey->getUnquotedLocalColumns();

            if (false === in_array($sourceColumn, $sourceColumns)) {
                continue;
            }

            $targetColumns = $foreignKey->getUnquotedForeignColumns();
            $targetTable = $foreignKey->getForeignTableName();
            $targetColumn = $this->getTargetColumn($sourceColumn, $sourceColumns, $targetColumns);

            $this->commandConstraint($sourceTable, $foreignKey->getName(), $foreignKey->getForeignTableName(), $sourceColumns, $targetColumns);

            $targetClassName = explode('.', $targetTable);

            if (1 === count($targetClassName)) {
                $targetClassName[1] = $targetClassName[0];
                $targetClassName[0] = 'public';
            }

            $targetClassName[0] = 'public' === $targetClassName[0] || true === empty($targetClassName[0]) ? null : StringHelper::camelize($targetClassName[0]);
            $targetClassName[1] = StringHelper::camelize($targetClassName[1]);

            $targetClassName = array_filter($targetClassName);
            $targetClassName = sprintf('Urbem\CoreBundle\Entity\%s', implode('\\', $targetClassName));

            $this->generateUpdateList($targetClassName, $targetColumn);
        }
    }

    /**
     * @param $sourceColumn
     * @param array $sourceColumns
     * @param array $targetColumn
     * @return string
     */
    protected function getTargetColumn($sourceColumn, array $sourceColumns, array $targetColumn)
    {
        return $targetColumn[array_search($sourceColumn, $sourceColumns)];
    }
}
