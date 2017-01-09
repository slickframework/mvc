<?php

namespace spec\Slick\Mvc\Http;

use Aura\Router\Matcher;
use Aura\Router\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slick\Http\Server\MiddlewareInterface;
use Slick\Mvc\Http\RouterMiddleware;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RouterMiddlewareSpec extends ObjectBehavior
{
    function let(Matcher $matcher)
    {
        $this->beConstructedWith($matcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RouterMiddleware::class);
    }

    function its_an_http_middleware()
    {
        $this->shouldBeAnInstanceOf(MiddlewareInterface::class);
    }

    function it_matches_the_request_to_its_routes_container(
        ServerRequestInterface $request,
        ResponseInterface $response,
        Matcher $matcher,
        Route $route
    )
    {
        $matcher->match($request)->willReturn($route);
        $request->withAttribute('route', $route)->willReturn($request);
        $this->beConstructedWith($matcher);
        $matcher->match($request)->shouldBeCalled();
        $this->handle($request, $response)->shouldBe($response);
        $request->withAttribute('route', $route)->shouldHaveBeenCalled();
    }
}
