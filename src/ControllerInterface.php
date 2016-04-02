<?php

/**
 * This file is part of slick/mvc package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * MVC Controller Interface
 *
 * @package Slick\Mvc
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface ControllerInterface
{

    /**
     * Request attribute name where view related data will be stored
     */
    CONST REQUEST_ATTR_VIEW_DATA = 'view-data';


    /**
     * Registers the current HTTP request and response
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return ControllerInterface
     */
    public function register(
        ServerRequestInterface $request, ResponseInterface $response
    );

    /**
     * Gets updated HTTP response
     *
     * @return ResponseInterface
     */
    public function getResponse();

    /**
     * Gets updated HTTP request
     *
     * @return ServerRequestInterface
     */
    public function getRequest();

    /**
     * Sets a value to be used by render
     *
     * The key argument can be an associative array with values to be set
     * or a string naming the passed value. If an array is given then the
     * value will be ignored.
     *
     * Those values must be set in the request attributes so they can be used
     * latter by any other middle ware in the stack.
     *
     * @param string|array $key
     * @param mixed        $value
     *
     * @return ControllerInterface
     */
    public function set($key, $value = null);
}