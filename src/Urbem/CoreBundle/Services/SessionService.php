<?php

namespace Urbem\CoreBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SessionService
 */
class SessionService
{
    /** @var ContainerInterface */
    protected $container;
    
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    /**
     * Adiciona na sessão o parametro exercicio
     * @param string $exercicio
     */
    public function setExercicio($exercicio)
    {
        $this->container->get('session')->set('exercicio', $exercicio);
    }
    
    /**
     * Retorna o parametro exercicio
     * @return string
     */
    public function getExercicio()
    {
        return $this->container->get('session')->get('exercicio');
    }

    /**
     * @param $logoTipo
     */
    public function setLogoTipo($logoTipo)
    {
        $this->container->get('session')->set('logoTipo', $logoTipo);
    }

    /**
     * * Retorna o parametro logoTipo
     * @return mixed
     */
    public function getLogoTipo()
    {
        return $this->container->get('session')->get('logoTipo');
    }
}
