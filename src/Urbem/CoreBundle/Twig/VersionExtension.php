<?php

namespace Urbem\CoreBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Urbem\CoreBundle\Helper;

class VersionExtension extends \Twig_Extension
{
    /**
     * @var SymfonyComponentDependencyInjectionContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array('versionUrbem' => new \Twig_Function_Method($this, 'getCurrentVersion'));
    }

    public function getCurrentVersion()
    {
        $version = $this->container->getParameter('version');
        $session = $this->container->get('session');
        $versionCommit = $session->get("version-urbem");
        $fileVersionCommit = $this->container->get('kernel')->getRootDir() . "/../var/version";

        if (file_exists($fileVersionCommit) && !$versionCommit) {
            $versionCommit = sprintf("@commit: %s", file_get_contents($fileVersionCommit));
            $session->set("version-urbem", $versionCommit);
        }

        return $version . $versionCommit;
    }

    public function getName()
    {
        return 'versionUrbem_extension';
    }
}
