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

    public function getPost($name, $default = null);

    public function getQuery($name, $default = null);

    public function redirect($location);

    public function disableRendering();

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