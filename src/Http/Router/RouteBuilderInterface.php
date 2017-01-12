<?php

/**
 * This file is part of slick/mvc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Http\Router;

use Aura\Router\Map;
use Aura\Router\RouterContainer;

/**
 * Router Builder Interface
 *
 * @package Slick\Mvc\Http\Router
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface RouteBuilderInterface
{

    /**
     * Map builder handler
     *
     * @see http://auraphp.com/packages/3.x/Router/custom-maps.html#1-4-5
     *
     * @param Map $map
     *
     * @return self|RouteBuilderInterface
     */
    public function build(Map $map);

    /**
     * Registers the callback for map creations
     *
     * @param RouterContainer $container
     * @return self|RouteBuilderInterface
     */
    public function register(RouterContainer $container);
}