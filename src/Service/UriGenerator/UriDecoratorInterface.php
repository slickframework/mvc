<?php

/**
 * This file is part of slick/mvc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Service\UriGenerator;

use Psr\Http\Message\UriInterface;

/**
 * URI Decorator Interface
 *
 * @package Slick\Mvc\Service\UriGenerator
 * @author  Filipe Silva <filipe.silva@sata.pt>
 */
interface UriDecoratorInterface
{

    /**
     * Decorates provided URI
     *
     * @param UriInterface $uri The URI to decorate
     *
     * @return UriInterface
     */
    public function decorate(UriInterface $uri);
}