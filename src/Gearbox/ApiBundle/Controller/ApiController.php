<?php


namespace Gearbox\ApiBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Gearbox\ApiBundle\Model\InitializableInterface;

abstract class ApiController extends FOSRestController implements ClassResourceInterface, InitializableInterface
{

} 