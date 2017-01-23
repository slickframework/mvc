<?php

namespace spec\Slick\Mvc\Http;

use Aura\Router\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slick\Http\Server\MiddlewareInterface;
use Slick\Http\Stream;
use Slick\Mvc\Http\Renderer\ViewInflectorInterface;
use Slick\Mvc\Http\RendererMiddleware;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Template\Template;
use Slick\Template\TemplateEngineInterface;

/**
 * RendererMiddlewareSpec
 *
 * @package spec\Slick\Mvc\Http
 * @author  Filipe Silva <filipe.silva@sata.pt>
 */
class RendererMiddlewareSpec extends ObjectBehavior
{

    function let(
        TemplateEngineInterface $templateEngine,
        ViewInflectorInterface $inflector
    ) {
        $this->beConstructedWith($templateEngine, $inflector);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RendererMiddleware::class);
    }

    function its_a_http_server_middleware()
    {
        $this->shouldBeAnInstanceOf(MiddlewareInterface::class);
    }

    function it_uses_inflector_to_determine_the_template_file_name(
        ServerRequestInterface $request,
        ResponseInterface $response,
        TemplateEngineInterface $templateEngine,
        ViewInflectorInterface $inflector,
        Route $route
    ) {
        $request->getAttribute('viewData', [])
            ->shouldBeCalled()
            ->willReturn([]);
        $request->getAttribute('route')
            ->shouldBeCalled()
            ->willReturn($route);
        $inflector->inflect($route)
            ->shouldBeCalled()
            ->willReturn('test/file.twig');
        $templateEngine->parse('test/file.twig')
            ->shouldBeCalled()
            ->willReturn($templateEngine);
        $templateEngine->process([])
            ->shouldBeCalled()
            ->willReturn('Hello world!');
        $response->withBody(
            Argument::that(function (Stream $argument) {
                $argument->rewind();
                return $argument->getContents() === 'Hello world!';
            })
        )
            ->shouldBeCalled()
            ->willReturn($response);

        $this->handle($request, $response)->shouldBe($response);
    }
}
