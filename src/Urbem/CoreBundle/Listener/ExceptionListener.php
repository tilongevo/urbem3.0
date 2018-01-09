<?php

namespace Urbem\CoreBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelInterface;

class ExceptionListener
{
    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(EngineInterface $templating, KernelInterface $kernel, ContainerInterface $container)
    {
        $this->templating = $templating;
        $this->kernel = $kernel;
        $this->container = $container;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $message = $event->getException()->getMessage();
        $previous = $event->getException()->getPrevious();

        $this->container->get('logger')->error('Ocorreu um Erro: ', ['message' => $message, 'previous' => $previous]);

        $request = $event->getRequest();

        $param = $request->attributes->get('_route_params');
        $param['_sonata_admin'] = null;
        $param['_sonata_name'] = null;

        unset($param['_sonata_admin'], $param['_sonata_name']);

        $this->container->get('breadcrumb.helper')->generate($param);

        if (true === $event->getException() instanceof AccessDeniedHttpException) {
            return (new RedirectResponse('/acesso-negado'))->send();
        }

        // provide the better way to display a enhanced error page only in prod environment, if you want
        if ('prod' == $this->kernel->getEnvironment()) {
            $response = new Response();

            if ($event->getException() instanceof NotFoundHttpException) {
                $response->setContent($this->templating->render('CoreBundle:Exception:exception_route_notfound.html.twig'));
                $response->setStatusCode(404);
                $event->setResponse($response);

                return $event;
            }

            // Log in external service
            $error = [];
            $error['message'] = $event->getException()->getMessage();
            $error['trace'] = $event->getException()->getTraceAsString();

            $this->container->get("urbem.service.thundera.logger")->send($error, 'Falha no processamento');

            $response->setContent($this->templating->render('CoreBundle:Exception:exception.html.twig', ['exception' => $event->getException()]));
            $response->setStatusCode(500);
            $event->setResponse($response);

            return $event;
        }
    }
}
