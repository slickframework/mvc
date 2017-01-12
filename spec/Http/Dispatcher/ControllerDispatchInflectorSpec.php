<?php

namespace spec\Slick\Mvc\Http\Dispatcher;

use Aura\Router\Route;
use Slick\Mvc\Http\Dispatcher\ControllerDispatch;
use Slick\Mvc\Http\Dispatcher\ControllerDispatchInflector;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Mvc\Http\Dispatcher\ControllerDispatchInflectorInterface;

class ControllerDispatchInflectorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ControllerDispatchInflector::class);
    }

    function its_a_controller_class_inflector()
    {
        $this->shouldBeAnInstanceOf(ControllerDispatchInflectorInterface::class);
    }

    function it_inflects_controller_dispatch_form_route_attributes()
    {
        $route = new Route();
        $route->attributes([
            'namespace' => 'Controller',
            'controller' => 'pages',
            'action' => 'index',
            'args' => [123, 'test']
        ]);
        $this->inflect($route)->shouldBeAnInstanceOf(ControllerDispatch::class);
    }
}
