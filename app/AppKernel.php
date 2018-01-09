<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new Urbem\CoreBundle\CoreBundle(),
            new Urbem\RecursosHumanosBundle\RecursosHumanosBundle(),
            new Urbem\AdministrativoBundle\AdministrativoBundle(),
            new Urbem\PatrimonialBundle\PatrimonialBundle(),
            new Urbem\FinanceiroBundle\FinanceiroBundle(),
            new Urbem\TributarioBundle\TributarioBundle(),
            new WhiteOctober\BreadcrumbsBundle\WhiteOctoberBreadcrumbsBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Sonata\IntlBundle\SonataIntlBundle(),
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
            new CodeItNow\BarcodeBundle\CodeItNowBarcodeBundle(),
            new MBence\OpenTBSBundle\OpenTBSBundle(),
            new Urbem\ReportBundle\ReportBundle(),
            new Urbem\RedeSimplesBundle\RedeSimplesBundle(),
            new Urbem\ConfiguracaoBundle\ConfiguracaoBundle(),
            new Urbem\PrestacaoContasBundle\PrestacaoContasBundle(),
            new Urbem\PortalServicosBundle\PortalServicosBundle(),
            new Urbem\PortalGestorBundle\PortalGestorBundle(),
            new Zechim\QueueBundle\ZechimQueueBundle(),
            new Urbem\ComprasGovernamentaisBundle\ComprasGovernamentaisBundle()
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__) . '/var/cache/' . $this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__) . '/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/' . $this->getEnvironment() . '/config.yml');
    }
}
