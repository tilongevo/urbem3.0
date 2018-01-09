<?php

namespace Urbem\CoreBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Urbem\CoreBundle\Helper\MemcacheHelper;

class CreateRouterDropdownCommand extends Command
{
    protected $route_list = array();

    protected function configure()
    {
        $this
            ->setName('create:router:dropdown')
            ->setDescription('Get router from memcache and create recursive dropdown to use')
            ->setHelp('');
    }

    protected function recursive($currentRoute, $rota = array())
    {
        $container = $this->getApplication()->getKernel()->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');

        $routes = (new \Urbem\CoreBundle\Model\Administracao\RotaModel($em, $container))
        ->getChildren($currentRoute->getDescricaoRota());

        if ($routes) {
            foreach ($routes as $routeKey => $routeValue) {
                $rota[$routeValue->getTraducaoRota()] = $this->recursive($routeValue);
            }
        } else {
            $rota = array($currentRoute->getTraducaoRota() => $currentRoute->getDescricaoRota()) + $rota;
        }

        return $rota;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getApplication()->getKernel()->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');

        $routes = (new \Urbem\CoreBundle\Model\Administracao\RotaModel($em, $container))
        ->getChildren();

        foreach ($routes as $routeKey => $routeValue) {
            $this->route_list[$routeValue->getTraducaoRota()] = $this->recursive($routeValue);
        }
        
        $memcachehelper = new MemcacheHelper($container->get('memcache.default'));
        $memcachehelper->set('routes_db', $this->route_list);
    }
}
