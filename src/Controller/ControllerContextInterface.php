<?php

/**
 * This file is part of slick/mvc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Controller Context Interface
 *
 * @package Slick\Mvc\Controller
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface ControllerContextInterface
{

    /**
     * Registers the HTTP request and response to this context
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return self|ControllerContextInterface
     */
    public function register(
        ServerRequestInterface $request,
        ResponseInterface $response
    );

    /**
     * Gets the post parameter that was submitted with provided name
     *
     * If its not submitted the default value will be returned.
     * If no arguments are passed the full server parameters from request will
     * be returned. In this case the default value is ignored.
     *
     * @param null|string $name
     * @param mixed       $default
     *
     * @return array|string
     */
    public function getPost($name = null, $default = null);

    /**
     * Gets the URL query parameter with provided name
     *
     * If its not submitted the default value will be returned.
     * If no arguments are passed the full URL query parameters from request will
     * be returned. In this case the default value is ignored.
     *
     * @param null|string $name
     * @param mixed       $default
     *
     * @return array|string
     */
    public function getQuery($name = null, $default = null);

    /**
     * Sets a redirection header in the HTTP response
     *
     * @param string $location
     *
     * @return void
     */
    public function redirect($location);

    /**
     * Disables response rendering
     *
     * @return self|ControllerContextInterface
     */
    public function disableRendering();

    /**
     * Sets a new response
     *
     * @param ResponseInterface $response
     *
     * @return self|ControllerContextInterface
     */
    public function setResponse(ResponseInterface $response);

    /**
     * Get current HTTP response
     *
     * @return ResponseInterface
     */
    public function getResponse();

    /**
     * Get current HTTP request
     *
     * @return ServerRequestInterface
     */
    public function getRequest();
}