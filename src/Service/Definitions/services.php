<?php

/**
 * This file is part of slick/mvc package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Service\Definitions;

use Slick\Configuration\Configuration;
use Slick\Di\Definition\ObjectDefinition;
use Slick\Http\PhpEnvironment\Request;
use Slick\Http\PhpEnvironment\Response;
use Slick\Http\Server;
use Slick\Http\Session;
use Slick\Mvc\Http\SessionMiddleware;

// Load default settings
Configuration::addPath(dirname(dirname(__DIR__)).'/Configuration');
$config = Configuration::get('default-settings');

$services = [];

// SESSION DRIVER
$services['session.driver'] = function () use ($config) {
    $session = new Session(
        $config->get(
            'session',
            ['driver' => Session::DRIVER_NULL]
        )
    );
    return $session->initialize();
};

// REQUEST/RESPONSE objects
$services['server.request']  = function () {return new Request(); };
$services['server.response'] = function () {return new Response(); };

// MIDDLEWARE
$services['session.middleware'] = ObjectDefinition::create(SessionMiddleware::class)
    ->with('@session.driver');

$services['middleware.server'] = ObjectDefinition::create(Server::class)
    ->with('@server.request', '@server.response')

    ->call('add')->with('@session.middleware')
    ->call('add')->with('@router.middleware')
    ->call('add')->with('@dispatcher.middleware')
    ->call('add')->with('@renderer.middleware')
;

return $services;