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
use Slick\Mvc\Http\Dispatcher\ControllerInvokerInterface;

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
     * Default context class
     */
    const CONTEXT_CLASS = Context::class;
    /**
     * @var ControllerInvokerInterface
     */
    private $invoker;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Creates an HTTP request dispatcher middleware
     *
     * @param ControllerDispatchInflectorInterface $controllerDispatchInflector
     * @param ControllerInvokerInterface           $invoker
     * @param ContainerInterface                   $container
     */
    public function __construct(
        ControllerDispatchInflectorInterface $controllerDispatchInflector,
        ControllerInvokerInterface $invoker,
        ContainerInterface $container
    )
    {
        $this->controllerDispatchInflector = $controllerDispatchInflector;
        $this->invoker = $invoker;
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
        $controllerDispatch = $this->getControllerDispatch($request);
        $controller = $this->createController($controllerDispatch);
        $this->setControllerContext($controller, $request, $response);
        $dataView = $this->invoker->invoke($controller, $controllerDispatch);
        $request = $request->withAttribute('viewData', $dataView);
        return $this->executeNext($request, $response);
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
        $contextClass = $this->getContextClass();
        /** @var ControllerContextInterface $context */
        $context = $this->container->make($contextClass);
        $context->register($request, $response);
        $controller->setContext($context);
        return $context;
    }

    /**
     * Gets the context class from container
     *
     * @return string
     */
    private function getContextClass()
    {
        $class = self::CONTEXT_CLASS;
        if ($this->container->has('controller.context.class')) {
            $class = $this->container->get('controller.context.class');
        }
        return $class;
    }
}