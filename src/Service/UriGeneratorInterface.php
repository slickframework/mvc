<?php

/**
 * This file is part of slick/mvc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Service;

use Psr\Http\Message\UriInterface;
use Slick\Mvc\Service\UriGenerator\LocationTransformerInterface;
use Slick\Mvc\Service\UriGenerator\UriDecoratorInterface;

/**
 * URI Generator Interface
 *
 * @package Slick\Mvc\Service
 * @author  Filipe Silva <filipe.silva@sata.pt>
 */
interface UriGeneratorInterface
{

    /**
     * Generates an URL location from provided data
     *
     * @param string $location Location name, path or identifier
     * @param array  $options  Filter options
     *
     * @return UriInterface|null
     */
    public function generate($location, array $options = []);

    /**
     * Adds a location transformer to the transformers stack
     *
     * @param LocationTransformerInterface $transformer
     *
     * @return self|UriGeneratorInterface
     */
    public function addTransformer(LocationTransformerInterface $transformer);

    /**
     * Adds an URI decorator to the decorators list
     *
     * @param UriDecoratorInterface $decorator
     * @return mixed
     */
    public function addDecorator(UriDecoratorInterface $decorator);
}
