<?php

namespace spec\Slick\Mvc\Http;

use Aura\Router\Route;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slick\Di\ContainerInterface;
use Slick\Http\Server\MiddlewareInterface;
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
        TestController $controller
    )
    {
        $this->beConstructedWith(
            $controllerDispatchInflector,
            $container
        );

        $dispatch = new ControllerDispatch('controllerClass', 'index', [123]);
        $request->getAttribute('route', false)->willReturn($route);
        $controllerDispatchInflector->inflect($route)->willReturn($dispatch);
        $container->make('controllerClass')->willReturn($controller);

        $this->handle($request, $response)->shouldBe($response);
        $controller->index(123)->shouldHaveBeenCalled();
        $controller->setContext(Argument::type(ControllerContextInterface::class))
            ->shouldHaveBeenCalled();
    }
}

class TestController implements ControllerInterface
{

    public function setContext(ControllerContextInterface $context)
    {
        // do nothing
    }

    public function set($name, $value)
    {
        // do nothing
    }

    public function index($test)
    {

    }
}
