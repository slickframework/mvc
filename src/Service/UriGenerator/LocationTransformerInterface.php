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
 * Location Transformer Interface
 *
 * @package Slick\Mvc\Service\UriGenerator
 * @author  Filipe Silva <filipe.silva@sata.pt>
 */
interface LocationTransformerInterface
{

    /**
     * Tries to transform the provided location data into a server URI
     *
     * @param string $location Location name, path or identifier
     * @param array  $options  Filter options
     *
     * @return UriInterface|null
     */
    public function transform($location, array $options = []);
}
