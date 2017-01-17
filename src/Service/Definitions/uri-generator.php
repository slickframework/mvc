<?php

/**
 * This file is part of slick/mvc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Services\Definitions;

use Slick\Di\Definition\ObjectDefinition;
use Slick\Mvc\Service\UriGenerator;
use Slick\Mvc\Service\UriGenerator\Transformer\BasePathTransformer;
use Slick\Mvc\Service\UriGenerator\Transformer\RouterPathTransformer;
use Slick\Mvc\Service\UriGeneratorInterface;

$services = [];

$services[UriGeneratorInterface::class] = '@uri.generator';
$services['uri.generator'] = ObjectDefinition::create(UriGenerator::class)
    ->call('addTransformer')->with('@router.location.trans')
    ->call('addTransformer')->with('@base-path.location.trans');

// *************************
//   LOCATION TRANSFORMERS
// *************************
$services['router.location.trans'] = ObjectDefinition::
    create(RouterPathTransformer::class)
    ->with('@router.container');

$services['base-path.location.trans'] = ObjectDefinition::
    create(BasePathTransformer::class);

return $services;