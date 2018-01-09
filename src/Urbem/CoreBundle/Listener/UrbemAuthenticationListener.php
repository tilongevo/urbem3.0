<?php

namespace Urbem\CoreBundle\Listener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UrbemAuthenticationListener implements ListenerInterface
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /** @var AuthenticationManagerInterface */
    private $authenticationManager;

    /** @var string Uniquely identifies the secured area */
    private $providerKey;
    
    /** @var ContainerInterface */
    protected $container;
    
    /**
     * @param ContainerInterface $container [description]
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    /**
     * @param  GetResponseEvent $event
     */
    public function handle(GetResponseEvent $event)
    {
    }
    
    /**
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractivelogin(InteractiveLoginEvent $event)
    {
        $request = $event->getRequest();

        $this->container->get('urbem.session.service')->setExercicio(date("Y"));
    }
}
