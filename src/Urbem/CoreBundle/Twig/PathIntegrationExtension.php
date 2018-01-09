<?php

namespace Urbem\CoreBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Urbem\CoreBundle\Helper;

class PathIntegrationExtension extends \Twig_Extension
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

    public function getFilters()
    {
        return array(
            'pathIntegration' => new \Twig_Filter_Method($this, 'generatePathIntegration')
        );
    }

    public function generatePathIntegration($module)
    {
    }

    public function getName()
    {
        return 'pathIntegration_extension';
    }
}
