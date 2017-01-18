<?php

/**
 * This file is part of slick/mvc package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Service\UriGenerator\Transformer;

use Aura\Router\RouterContainer;
use Psr\Http\Message\UriInterface;
use Slick\Http\Uri;
use Slick\Mvc\Service\UriGenerator\LocationTransformerInterface;

/**
 * RouterPathTransformer
 *
 * @package Slick\Mvc\Service\UriGenerator\Transformer
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class RouterPathTransformer extends AbstractLocationTransformer implements
    LocationTransformerInterface
{

    /**
     * @var RouterContainer
     */
    private $router;

    /**
     * Router Path Transformer
     *
     * @param RouterContainer $router
     */
    public function __construct(RouterContainer $router)
    {
        $this->router = $router;
    }

    /**
     * Tries to transform the provided location data into a server URI
     *
     * @param string $location Location name, path or identifier
     * @param array $options Filter options
     *
     * @return UriInterface|null
     */
    public function transform($location, array $options = [])
    {
        $path = $this->router
            ->getGenerator()
            ->generate($location, $this->getRouteArguments($options));

        if (!$path) {
            return null;
        }

        $uri = (new Uri())->withPath($path);
        $uri = $this->updateOptions($uri);
        return $uri;
    }

    /**
     * Get the route arguments from provided options
     *
     * For options that match the default options those will
     * override the default value.
     *
     * @param array $options
     *
     * @return array
     */
    private function getRouteArguments(array $options = [])
    {
        $routeArguments = [];
        foreach ($options as $key => $value) {
            if (array_key_exists($key, $this->options)) {
                $this->options[$key] = $value;
                continue;
            }
            $routeArguments[$key] = $value;
        }
        return $routeArguments;
    }
}