<?php

namespace spec\Slick\Mvc\Service\UriGenerator\Transformer;

use PhpSpec\Exception\Example\FailureException;
use Psr\Http\Message\UriInterface;
use Slick\Mvc\Service\UriGenerator\LocationTransformerInterface;
use Slick\Mvc\Service\UriGenerator\Transformer\FullUrlTransformer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FullUrlTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FullUrlTransformer::class);
    }

    function its_a_location_transformer()
    {
        $this->shouldBeAnInstanceOf(LocationTransformerInterface::class);
    }

    function it_returns_the_passed_location_when_its_a_full_URL()
    {
        $this->transform('http://test.com/path')
            ->shouldBeAnUriLike('http://test.com/path');
    }

    public function getMatchers()
    {
        return [
            'beAnUriLike' => function ($uri, $path)
            {
                if (!$uri instanceof UriInterface) {
                    $class = UriInterface::class;
                    $type = gettype($uri);
                    throw new FailureException(
                        "Expected {$class} instance, but got '{$type}'"
                    );
                }

                if ($uri->__toString() !== $path) {
                    throw new FailureException(
                        "Expected URI with path '{$path}', but got '{$uri}'"
                    );
                }
                return true;
            }
        ];
    }
}