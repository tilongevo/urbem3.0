<?php
namespace Urbem\CoreBundle\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\UnitOfWork;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Urbem\CoreBundle\Entity\Administracao\Auditoria;
use Urbem\CoreBundle\Helper\StringHelper;

class AuditListener implements EventSubscriber
{
    /**
     * @var array
     */
    protected $audits = [];

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var bool
     */
    protected $enabled;

    const TYPE_UPDATE = 'UPDATE';
    const TYPE_INSERT = 'INSERT';
    const TYPE_DELETE = 'DELETE';

    public function getSubscribedEvents()
    {
        return [
            Events::onFlush,
            Events::postFlush,
        ];
    }

    /**
     * AuditListener constructor.
     * @param ContainerInterface $container
     * @param bool $enabled
     */
    public function __construct(ContainerInterface $container, $enabled = true)
    {
        $this->container = $container;
        $this->enabled = $enabled;
    }

    public function postFlush(PostFlushEventArgs $args)
    {
        if (0 === count($this->audits) || false === $this->enabled) {
            return;
        }

        $audits = $this->audits;
        $this->audits = [];

        foreach ($audits as $audit) {
            $args->getEntityManager()->persist($audit);
            $args->getEntityManager()->flush($audit);
        }
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        if (false === $this->enabled) {
            return;
        }

        $em = $args->getEntityManager();
        $uom = $em->getUnitOfWork();

        $delete = $this->getCreateDeleteData($uom->getScheduledCollectionDeletions());
        $delete = array_merge($delete, $this->getCreateDeleteData($uom->getScheduledEntityDeletions()));

        $insert = $this->createInsertData($uom, $uom->getScheduledEntityInsertions());

        /** @todo check getScheduledCollectionUpdates */
        $update = $this->createUpdateData($uom, $uom->getScheduledEntityUpdates());

        $data = ['DELETE' => $delete, 'INSERT' => $insert, 'UPDATE' => $update];

        if (0 === count($data['DELETE']) && 0 === count($data['INSERT']) && 0 === count($data['UPDATE'])) {
            return;
        }

        $userData = $this->getUserData();
        $moduleData = $this->getModuleData();

        foreach ($data as $type => $changeSets) {
            foreach ($changeSets as $changeSet) {
                $audit = new Auditoria();
                $audit->setNumcgm($userData['id']);
                $audit->setNomcgm($userData['username']);
                $audit->setIp($ip = php_sapi_name() == 'cli' ? gethostname() : $_SERVER['REMOTE_ADDR']);
                $audit->setModulo($moduleData['module']);
                $audit->setSubmodulo($moduleData['submodule']);
                $audit->setRota($moduleData['route']);
                $audit->setEntidade($changeSet['entity']);
                $audit->setConteudo(json_encode($changeSet['value']));
                $audit->setTipo($type);
                $audit->setCreatedAt(new \DateTime());

                $this->audits[] = $audit;
            }
        }
    }

    /**
     * @param array $entities
     * @return array
     */
    protected function getCreateDeleteData(array $entities)
    {
        $delete = [];

        foreach ($entities as $entity) {
            if (true === $entity instanceof Auditoria) {
                continue;
            }

            $delete[] = [
                'entity' => ClassUtils::getClass($entity),
                'value' => $this->getValue($entity)
            ];
        }

        return $delete;
    }

    /**
     * @param UnitOfWork $uow
     * @param array $entities
     * @return array
     */
    protected function createUpdateData(UnitOfWork $uow, array $entities)
    {
        $update = [];

        foreach ($entities as $entity) {
            if (true === $entity instanceof Auditoria) {
                continue;
            }

            $fromData = [];
            $toData = [];

            foreach ($uow->getEntityChangeSet($entity) as $column => $changeSet) {
                $fromDataValue = $this->getValue($changeSet[0]);
                $toDataValue = $this->getValue($changeSet[1]);

                if ($fromDataValue === $toDataValue) {
                    continue;
                }

                $fromData[$column] = $fromDataValue;
                $toData[$column] = $toDataValue;
            }

            $update[] = [
                'entity' => ClassUtils::getClass($entity),
                'value' => [
                    'from' => $fromData,
                    'to' => $toData
                ],
            ];
        }

        return $update;
    }

    /**
     * @param UnitOfWork $uow
     * @param array $entities
     * @return array
     */
    protected function createInsertData(UnitOfWork $uow, array $entities)
    {
        $insert = [];

        foreach ($entities as $entity) {
            if (true === $entity instanceof Auditoria) {
                continue;
            }

            $new = [];

            foreach ($uow->getEntityChangeSet($entity) as $column => $changeSet) {
                $new[$column] = $this->getValue($changeSet[1]);
            }

            $insert[] = [
                'entity' => ClassUtils::getClass($entity),
                'value' => $new,
            ];
        }

        return $insert;
    }

    /**
     * @return array [route, module, submodule]
     */
    protected function getModuleData()
    {
        $pathInfo = '';
        $module = '';
        $submodule = '';
        
        try {
            $pathInfo = $this->container
                ->get('router')
                ->getContext()
                ->getPathInfo();

            $pathInfoArray = array_filter(explode('/', $pathInfo), 'strlen');

            $module = StringHelper::ucname(array_shift($pathInfoArray), ' ');
            $submodule = StringHelper::ucname(array_shift($pathInfoArray), ' ');
        } catch (\Exception $e) {
        }

        return ['route' => $pathInfo, 'module' => $module, 'submodule' => $submodule];
    }

    /**
     * @return array [id, username]
     */
    protected function getUserData()
    {
        try {
            $token = $this->container->get('security.token_storage')->getToken();

            if (null === $token) {
                throw new \Exception();
            }

            $user = $token->getUser();

            $userData = ['id' => $user->getId(), 'username' => $user->getUsername()];
        } catch (\Exception $exception) {
            $userData = ['id' => null, 'username' => null];
        }

        return $userData;
    }

    /**
     * @param $item
     * @return array [type, value]
     */
    protected function getValue($item)
    {
        if ($item instanceof \DateTime) {
            $type = get_class($item);
            if (true === method_exists($item, '__toString')) {
                $value = (string) $item;
            } else {
                $value = $item->format(DATE_ATOM);
            }
        } elseif (is_object($item)) {
            return $this->getIdentifier($item);
        } else {
            $type = gettype($item);
            $value = $item;
        }

        return ['type' => $type, 'value' => $value];
    }

    /**
     * @param $entity
     * @return array [type, value]
     */
    protected function getIdentifier($entity)
    {
        /** @var ClassMetadataInfo $cm */
        $cm = $this->container->get('doctrine.orm.entity_manager')->getClassMetadata($class = ClassUtils::getClass($entity));

        return [
            'type' => $class,
            'value' => array_combine($cm->getIdentifierColumnNames(), $cm->getIdentifierValues($entity))
        ];
    }
}
