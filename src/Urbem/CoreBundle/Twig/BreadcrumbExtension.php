<?php

namespace Urbem\CoreBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Urbem\CoreBundle\Helper;

class BreadcrumbExtension extends \Twig_Extension
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
        return array('breadcrumb' => new \Twig_Function_Method($this, 'breadcrumbFilter'));
    }

    public function breadcrumbFilter()
    {
        $breadcrumb = $this->container->get("white_october_breadcrumbs");
        $router = $this->container->get("router");
        $routeName = $this->container->get('request_stack')->getCurrentRequest()->attributes;
        $entityManager = $this->container->get('doctrine')->getManager();
        
        Helper\BreadCrumbsHelper::getBreadCrumb(
            $breadcrumb,
            $router,
            $routeName->get('_route'),
            $entityManager,
            ! is_null($routeName->get('id')) ? ['id' => $routeName->get('id')] : []
        );
    }

    public function getName()
    {
        return 'breadcrumb_extension';
    }
}
