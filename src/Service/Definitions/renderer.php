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
use Slick\Template\Template;

$services = [];
// Load default settings
Configuration::addPath(dirname(dirname(__DIR__)).'/Configuration');
$config = Configuration::get('default-settings');
Template::appendPath($config->get('source-templates'));

// TEMPLATE DEFINITIONS
$services['template.engine'] = ObjectDefinition::create(Template::class)
    ->call('addExtension')->with('@html.extension');

$services['html.extension'] = ObjectDefinition::create(HtmlExtension::class)
    ->with('@uri.generator');

return $services;