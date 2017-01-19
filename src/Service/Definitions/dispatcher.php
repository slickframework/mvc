<?php

/**
 * This file is part of slick/mvc package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Services\Definitions;

use Slick\Di\Definition\ObjectDefinition;
use Slick\Mvc\Http\Dispatcher\ControllerDispatchInflector;
use Slick\Mvc\Http\Dispatcher\ControllerInvoker;
use Slick\Mvc\Http\DispatcherMiddleware;

$services = [];


$services['dispatcher.middleware'] = ObjectDefinition
    ::create(DispatcherMiddleware::class)
    ->with('@controller.inflector', '@controller.invoker', '@container');

$services['controller.inflector'] = ObjectDefinition
    ::create(ControllerDispatchInflector::class);
$services['controller.invoker'] = ObjectDefinition
    ::create(ControllerInvoker::class);

return $services;