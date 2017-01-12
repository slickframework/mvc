<?php

/**
 * This file is part of slick/mvc package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slick\Di\ContainerInterface;
use Slick\Http\Server\AbstractMiddleware;
use Slick\Http\Server\MiddlewareInterface;
use Slick\Mvc\Controller\Context;
use Slick\Mvc\Controller\ControllerContextInterface;
use Slick\Mvc\ControllerInterface;
use Slick\Mvc\Http\Dispatcher\ControllerDispatch;
use Slick\Mvc\Http\Dispatcher\ControllerDispatchInflectorInterface;

/**
 * Dispatcher Middleware
 *
 * @package Slick\Mvc\Http
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class DispatcherMiddleware extends AbstractMiddleware implements MiddlewareInterface
{
    /**
     * @var ControllerDispatchInflectorInterface
     */
    private $controllerDispatchInflector;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(
        ControllerDispatchInflectorInterface $controllerDispatchInflector,
        ContainerInterface $container
    )
    {
        $this->controllerDispatchInflector = $controllerDispatchInflector;
        $this->container = $container;
    }

    /**
     * Handles a Request and updated the response
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function handle(
        ServerRequestInterface $request, ResponseInterface $response
    )
    {
        $dispatch = $this->getControllerDispatch($request);

        $controller = $this->createController($dispatch);
        $context = $this->setControllerContext($controller, $request, $response);

        $this->invokeControllerAction($controller, $dispatch);

        return $this->executeNext($context->getRequest(), $context->getResponse());
    }

    /**
     * Get controller dispatch from provided route
     *
     * @param ServerRequestInterface $request
     *
     * @return Dispatcher\ControllerDispatch
     */
    private function getControllerDispatch(ServerRequestInterface $request)
    {
        $route = $request->getAttribute('route', false);
        $dispatch = $this->controllerDispatchInflector
            ->inflect($route)
        ;
        return $dispatch;
    }

    /**
     * Creates the controller object
     *
     * @param ControllerDispatch $dispatch
     *
     * @return ControllerInterface
     */
    private function createController(ControllerDispatch $dispatch)
    {
        $controller = $this->container
            ->make($dispatch->getControllerClassName())
        ;
        return $controller;
    }

    /**
     * Sets controller context
     *
     * @param ControllerInterface    $controller
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return Context|ControllerContextInterface
     */
    private function setControllerContext(
        ControllerInterface $controller,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $context = (new Context())->register($request, $response);
        $controller->setContext($context);
        return $context;
    }

    /**
     * Invokes the controller handler method
     *
     * @param ControllerInterface $controller
     * @param ControllerDispatch  $dispatch
     */
    private function invokeControllerAction(
        ControllerInterface $controller,
        ControllerDispatch $dispatch
    ) {
        $controllerReflection = new \ReflectionClass($controller);
        $reflectionMethod = $controllerReflection->getMethod($dispatch->getMethod());
        $reflectionMethod->invokeArgs($controller, $dispatch->getArguments());
    }
}