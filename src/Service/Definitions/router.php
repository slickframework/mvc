<?php

/**
 * This file is part of slick/mvc package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Services\Definitions;

use Aura\Router\RouterContainer;
use Slick\Configuration\Configuration;
use Slick\Di\Definition\ObjectDefinition;
use Slick\Mvc\Http\Router\Builder\RouteFactory;
use Slick\Mvc\Http\Router\RouteBuilder;
use Slick\Mvc\Http\RouterMiddleware;
use Symfony\Component\Yaml\Parser;

Configuration::addPath(dirname(dirname(__DIR__)).'/Configuration');
$config = Configuration::get('default-settings');

$services = [];

$services['router.middleware'] = ObjectDefinition::create(RouterMiddleware::class)
    ->with('@router.container');
$services['route.builder'] = ObjectDefinition::create(RouteBuilder::class)
    ->with(
        $config->get('routes', __DIR__.'/routes.yml'),
        '@routes.yml.parser',
        '@route.factory'
    )
    ->call('register')->with('@router.container')
;
$services['router.container'] = ObjectDefinition::create(RouterContainer::class);
$services['routes.yml.parser']= ObjectDefinition::create(Parser::class);
$services['route.factory'] = ObjectDefinition::create(RouteFactory::class);

return $services;