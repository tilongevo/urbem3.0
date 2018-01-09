<?php

namespace Urbem\CoreBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Urbem\CoreBundle\Helper\MemcacheHelper;

class CreateRouterJsonCommand extends DoctrineCommand
{
    protected function configure()
    {
        $this
            ->setName('create:router:json')
            ->setDescription('Load all Routes and turning it into JSON')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');

        $grupos = (new \Urbem\CoreBundle\Model\Administracao\RotaModel($em, $container))
        ->getAllRoutes();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($grupos, 'json');

        $memcachehelper = new MemcacheHelper($this->getContainer()->get('memcache.default'));
        $memcachehelper->set('routes_db', $jsonContent);
    }
}
