<?php

namespace Urbem\CoreBundle\Twig;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;

class AnalyticsTrackingExtension extends \Twig_Extension
{
    const PARAMETER_ANALITICS_TRANKING = 'analitics-traking';

    /**
     * @var SymfonyComponentDependencyInjectionContainerInterface
     */
    private $container;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Session
     */
    private $session;

    /**
     * @param ContainerInterface $container
     */
    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();
        $this->session = $this->container->get('session');
    }

    public function getFilters()
    {
        return array(
            'analiticsUID' => new \Twig_Filter_Method($this, 'getAnaliticsUID')
        );
    }

    public function getAnaliticsUID()
    {
        $analitics = $this->session->get('analitics-traking');
        if (empty($analitics)) {
            $modulo = $this->em->getRepository('CoreBundle:Administracao\Modulo')->findOneByCodModulo(Modulo::MODULO_ADMINISTRATIVO);

            $configuracao = new Configuracao();
            $configuracao->setExercicio('9999');
            $configuracao->setFkAdministracaoModulo($modulo);
            $configuracao->setParametro(self::PARAMETER_ANALITICS_TRANKING);
            $configuracao->setValor('');

            $configuracaoModel = new ConfiguracaoModel($this->em);
            $analitics = $configuracaoModel->getAnaliticsTraking($configuracao);
            $this->session->set('analitics-traking', $analitics);
        }

        return isset($analitics) && !empty($analitics->getValor()) ? $analitics->getValor() : null;
    }

    public function getName()
    {
        return 'pathIntegration_extension';
    }
}
