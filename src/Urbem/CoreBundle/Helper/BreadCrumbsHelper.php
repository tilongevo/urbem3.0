<?php

namespace Urbem\CoreBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;
use \WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class BreadCrumbsHelper
 *
 * @package Urbem\CoreBundle\Helper
 */
class BreadCrumbsHelper
{
    const FILE_ROUTE_CUSTOMIZED = "route_db.php";

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function generate(array $params = [])
    {
        self::getBreadCrumb(
            $this->container->get('white_october_breadcrumbs'),
            $this->container->get('router'),
            $this->container->get('request_stack')->getCurrentRequest()->attributes->get('_route'),
            $this->container->get('doctrine')->getManager(),
            $params
        );
    }

    private static function exceptionsGenerateRoutes()
    {
        return [
            'urbem_administrativo_administracao_configuracao_list',
            'urbem_financeiro_empenho_empenho_convenio_criar_vinculo'
        ];
    }

    private static function getRouter($router, $entityManager)
    {
        $routers = (new \Urbem\CoreBundle\Model\Administracao\RotaModel($entityManager))
        ->getRouteByRouter($router);

        if (is_null($router)) {
            return [];
        }

        return $routers[$router];
    }

    public static function getBreadCrumb(
        Breadcrumbs $breadcrumbs,
        Router $router,
        $keyRouter,
        $entityManager,
        $param = []
    ) {
        $itens = self::getRouter($keyRouter, $entityManager);
        $exceptions = self::exceptionsGenerateRoutes();

        if (count($itens) == 0) {
            $breadcrumbs->addItem(
                "Início",
                "/"
            );

            return $breadcrumbs;
        }

        $len = count($itens);
        $positionRoute = 0;

        foreach ($itens as $nameRoute => $titleRoute) {
            $isNotSetUrl = false;
            if (in_array($nameRoute, $exceptions)) {
                $isNotSetUrl = true;
            }

            $breadcrumbs->addItem(
                $titleRoute,
                $isNotSetUrl ? "#" : $router->generate($nameRoute, $param)
            );
            $positionRoute++;
        }

        return $breadcrumbs;
    }
}
