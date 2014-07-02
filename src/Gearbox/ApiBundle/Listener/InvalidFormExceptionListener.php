<?php


namespace Gearbox\ApiBundle\Listener;


use Gearbox\ApiBundle\Exception\InvalidFormException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class InvalidFormExceptionListener
{
    /**
     * Method that gets called if the kernel throws an exception
     *
     * @param GetResponseForExceptionEvent $event
     */

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($exception instanceof InvalidFormException) {
//            $event->
//            $event->getRequest()->get('_format');
//            $response = new Response($exception->getForm()->createView(), 412);
//            $event->setResponse($response);
        }
    }
} 