<?php


namespace Gearbox\ApiBundle\Listener;

use Gearbox\ApiBundle\Model\InitializableInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * A listener to check for the Gearbox\ApiBundle\Model\InitializableInterface
 * If found on object, fires object::init method
 */
class InitializableListener
{
    /**
     * All controller events will be parsed through this handler if registered
     * in the requesting bundle to listen.
     *
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        if (!is_array($controller)) {
            return;
        }

        $controllerObject = $controller[0];
        if ($controllerObject instanceof InitializableInterface) {
            $controllerObject->init();
        }
    }
}