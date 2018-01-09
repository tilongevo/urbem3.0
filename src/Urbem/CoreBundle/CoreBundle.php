<?php

namespace Urbem\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Console\Application;
use Urbem\CoreBundle\Command\Doctrine\MigrationsGenerateCommand;

class CoreBundle extends Bundle
{
    public function registerCommands(Application $application)
    {
        if ($application->has('doctrine:migrations:generate')) {
            $application->add(new MigrationsGenerateCommand());
        }

        parent::registerCommands($application);
    }
}
