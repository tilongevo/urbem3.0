<?php

namespace Urbem\CoreBundle;

use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM;
use Doctrine\ORM\PersistentCollection;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;

/**
 * Class AbstractModel
 * @package Urbem\CoreBundle
 */
class AbstractModel
{
    const FIELD_EXERCICIO = 'exercicio';

    /** @var  ORM\EntityManager */
    protected $entityManager;

    public function save($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @deprecated
     * @param $entity
     */
    public function update($entity)
    {
        $this->save($entity);
    }

    /**
     * @param      $entity
     * @param bool $flush
     */
    public function remove($entity, $flush = true)
    {
        $this->entityManager->remove($entity);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

    /**
     * @param $object
     * @return string
     * @throws \Exception
     */
    public function getObjectIdentifier($object)
    {
        return implode(
            ModelManager::ID_SEPARATOR,
            $this->entityManager->getClassMetadata(ClassUtils::getClass($object))->getIdentifierValues($object)
        );
    }

    /**
     * @param object $object
     * @param array  $ignoreAssociations
     *
     * @return boolean
     */
    public function canRemoveWithAssociation($object, $ignoreAssociations = [])
    {
        $metadata = $this->entityManager->getClassMetadata(get_class($object));
        $associationMappings = $metadata->getAssociationNames();

        /** @var string $associationMapping */
        foreach ($associationMappings as $associationMapping) {
            $getterMethod = sprintf('get%s', ucfirst($associationMapping));

            /** @var PersistentCollection|object $resGetterMethod */
            $resGetterMethod = in_array($associationMapping, $ignoreAssociations) ? null : $object->{$getterMethod}();

            /**
             * Verifica se a variavel `$resGetterMethod` é uma instancia de PersistentCollection e
             *  se este collection NÃO esta vazio, ou, caso não seja uma PersistentCollection verifica se NÃO está nula,
             *  caso as condições sejam atendidas, significa que há dados linkados com essa entidade e a mesma não
             *  poderá ser removida.
             */
            if (!is_null($resGetterMethod)
                && (($resGetterMethod instanceof PersistentCollection) && !$resGetterMethod->isEmpty())) {
                return false;
            }
        }

        return true;
    }
}
