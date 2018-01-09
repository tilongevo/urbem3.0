<?php
namespace Urbem\CoreBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Urbem\CoreBundle\Controller\BaseController;

class BeforeControllerListener
{
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        /*
         * $controller passed can be either a class or a Closure. This is not usual in Symfony2 but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof BaseController) {
            $controller[0]->before();
        }
    }
}
