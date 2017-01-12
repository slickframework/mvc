<?php

namespace spec\Slick\Mvc\Http;

use Aura\Router\Route;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slick\Di\ContainerInterface;
use Slick\Http\Server\MiddlewareInterface;
use Slick\Mvc\Controller\Context;
use Slick\Mvc\Controller\ControllerContextInterface;
use Slick\Mvc\ControllerInterface;
use Slick\Mvc\Http\Dispatcher\ControllerDispatch;
use Slick\Mvc\Http\Dispatcher\ControllerDispatchInflectorInterface;
use Slick\Mvc\Http\DispatcherMiddleware;

class DispatcherMiddlewareSpec extends ObjectBehavior
{

    function let(
        ControllerDispatchInflectorInterface $controllerDispatchInflector,
        ContainerInterface $container
    ) {
        $this->beConstructedWith(
            $controllerDispatchInflector,
            $container
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DispatcherMiddleware::class);
    }

    function its_an_http_middleware()
    {
        $this->shouldBeAnInstanceOf(MiddlewareInterface::class);
    }

    function it_infers_controller_class_from_route(
        ServerRequestInterface $request,
        ResponseInterface $response,
        ControllerDispatchInflectorInterface $controllerDispatchInflector,
        Route $route,
        ControllerDispatchInflectorInterface $controllerDispatchInflector,
        ContainerInterface $container,
        TestController $controller,
        ControllerContextInterface $context
    )
    {
        $this->beConstructedWith(
            $controllerDispatchInflector,
            $container
        );

        $dispatch = new ControllerDispatch('controllerClass', 'index', [123]);
        $request->getAttribute('route', false)->willReturn($route);
        $controllerDispatchInflector->inflect($route)->willReturn($dispatch);

        $container->has('controller.context.class')->willReturn(true);
        $container->get('controller.context.class')->willReturn(Context::class);
        $container->make('controllerClass')->willReturn($controller);
        $container->make(Context::class)->willReturn($context);

        $context->getResponse()->willReturn($response);
        $context->getRequest()->willReturn($request);
        $context->register($request, $response)->shouldBeCalled();

        $this->handle($request, $response)->shouldBe($response);

        $controller->index(123)->shouldHaveBeenCalled();
        $controller->setContext($context)
            ->shouldHaveBeenCalled();

    }
}

class TestController implements ControllerInterface
{

    public function setContext(ControllerContextInterface $context)
    {
        // do nothing
        return $this;
    }

    public function set($name, $value = null)
    {
        // do nothing
        return $this;
    }

    public function index($test)
    {
        // Do controller stuff
    }

    /**
     * A view data model used by renderer
     *
     * @return array
     */
    public function getViewData()
    {
        // do nothing
        return [];
    }
}
