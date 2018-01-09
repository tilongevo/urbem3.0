<?php

namespace Urbem\CoreBundle\Composer;

use Sensio\Bundle\DistributionBundle\Composer\ScriptHandler as CoreScriptHandler;
use Composer\Script\Event;

/**
 * Class ScriptHandler
 * @package Urbem\CoreBundle\Composer
 * @TODO Esta solução deve ser temporária, pois existem uma diferença entre o Doctrine ORM/Master e Sonata
 */
class ScriptHandler extends CoreScriptHandler
{
    /**
     * Sets up deployment target specific features.
     * Could be custom web server configs, boot command files etc.
     *
     * @param $event CommandEvent An instance
     */
    public static function fixDoctrineLoadCollection(Event $event)
    {
        $filesCustomized = [
            'src/Urbem/CoreBundle/Customize/Doctrine/UnitOfWork.php' => 'vendor/doctrine/orm/lib/Doctrine/ORM/UnitOfWork.php',
            'src/Urbem/CoreBundle/Customize/Doctrine/BasicEntityPersister.php' => 'vendor/doctrine/orm/lib/Doctrine/ORM/Persisters/Entity/BasicEntityPersister.php',
            'src/Urbem/CoreBundle/Customize/Doctrine/Table.php' => 'vendor/doctrine/dbal/lib/Doctrine/DBAL/Schema/Table.php',
            'src/Urbem/CoreBundle/Customize/Doctrine/SchemaValidator.php' => 'vendor/doctrine/orm/lib/Doctrine/ORM/Tools/SchemaValidator.php',
            'src/Urbem/CoreBundle/Customize/Sonata/Form/Type/ModelAutocompleteType.php' => 'vendor/sonata-project/admin-bundle/Form/Type/ModelAutocompleteType.php',
            'src/Urbem/CoreBundle/Customize/sonata-project/doctrine-orm-admin-bundle/Datagrid/Pager.php' => 'vendor/sonata-project/doctrine-orm-admin-bundle/Datagrid/Pager.php'
        ];

        $rootPath = self::getRootPath();
        foreach ($filesCustomized as $from => $to) {
            file_put_contents($rootPath . $to, file_get_contents($rootPath . $from));
        }
    }

    /**
     * @param Event $event
     */
    public static function fixSonataListAction(Event $event)
    {
        $filesCustomized = [
            'src/Urbem/CoreBundle/Resources/views/Sonata/CRUD/list__action.html.twig' => 'vendor/sonata-project/admin-bundle/Resources/views/CRUD/list__action.html.twig'
        ];

        $rootPath = self::getRootPath();
        foreach ($filesCustomized as $from => $to) {
            file_put_contents($rootPath . $to, file_get_contents($rootPath . $from));
        }
    }

    protected static function getRootPath()
    {
        $dir = explode("Urbem" . DIRECTORY_SEPARATOR . "CoreBundle", __DIR__);
        return $dir[0]. "../";
    }
}
