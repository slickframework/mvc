<?php

/**
 * This file is part of slick/mvc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Services\Definitions;

use Slick\Configuration\Configuration;
use Slick\Di\Definition\ObjectDefinition;
use Slick\Mvc\Http\Renderer\TemplateExtension\HtmlExtension;
use Slick\Mvc\Http\Renderer\ViewInflector;
use Slick\Mvc\Http\Renderer\ViewInflectorInterface;
use Slick\Mvc\Http\RendererMiddleware;
use Slick\Template\Template;

$services = [];
// Load default settings
Configuration::addPath(dirname(dirname(__DIR__)).'/Configuration');
$config = Configuration::get('default-settings');
Template::appendPath($config->get('source-templates'));

// HTML SERVER RENDERER MIDDLEWARE
$services['renderer.middleware'] = ObjectDefinition
    ::create(RendererMiddleware::class)
    ->with('@template.engine', '@view.inflector')
;

// VIEW INFLECTOR
$services[ViewInflectorInterface::class] = '@view.inflector';
$services['view.inflector'] = ObjectDefinition
    ::create(ViewInflector::class)
    ->with('twig')
;

// TEMPLATE DEFINITIONS
$services['template.engine'] = function () {
    $template = new Template(Template::ENGINE_TWIG);
    $template->addExtension(HtmlExtension::class);
    return $template->initialize();
};

return $services;