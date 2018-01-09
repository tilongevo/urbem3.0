<?php

namespace Urbem\CoreBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Administracao\ModuloModel;

class ModuleExtension extends \Twig_Extension
{
    /**
     * @var SymfonyComponentDependencyInjectionContainerInterface
     */
    private $container;

    protected static $configuracaoModel;

    /**
     * @param ContainerInterface $container
     */
    public function __construct($container)
    {
        $this->container = $container;
        self::$configuracaoModel = new ConfiguracaoModel($container->get('doctrine.orm.entity_manager'));
    }

    public function getFilters()
    {
        return array(
            'moduleIsEnable' => new \Twig_Filter_Method($this, 'moduleIsEnable')
        );
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('listMenuModulesEnabled', [$this, 'getMenuModulesEnabled'], [
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
        );
    }

    /**
     * @param \Twig_Environment $environment
     * @return mixed|string
     */
    public function getMenuModulesEnabled(\Twig_Environment $environment)
    {
        $modulos = Modulo::getListModulesAvailable();

        foreach ($modulos as $key => $module) {
            if (!self::moduleIsEnable($module['name'])) {
                unset($modulos[$key]);
            }
        }

        // Portal do Cidadão
        $container = $this->container;
        /** @var Usuario $user */
        $user = $container->get('security.token_storage')->getToken()->getUser();
        if (in_array("ROLE_MUNICIPE", $user->getRoles())) {
            $modulos = array_merge($modulos, Modulo::getListModulesMunicipe());
        }

        return $environment->render('CoreBundle:Menu:list.html.twig', ['menuModules' => $modulos]);
    }

    /**
     * @param $module
     * @return bool
     */
    public function moduleIsEnable($module)
    {
        $paramName = sprintf("menu_%s", $module);
        $config = self::$configuracaoModel->findOneByParams(['parametro' => $paramName, 'exercicio' => '9999']);

        return empty($config) ? false : $config->getValor() === 'true';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'module_extension';
    }
}
