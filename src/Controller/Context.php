<?php

/**
 * This file is part of slick/mvc package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Context
 *
 * @package Slick\Mvc\Controller
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class Context implements ControllerContextInterface
{
    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * Registers the HTTP request and response to this context
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return self|ControllerContextInterface
     */
    public function register(
        ServerRequestInterface $request,
        ResponseInterface $response
    )
    {
        $this->request = $request;
        $this->setResponse($response);
        return $this;
    }

    public function getPost($name, $default = null)
    {
        // TODO: Implement getPost() method.
    }

    public function getQuery($name, $default = null)
    {
        // TODO: Implement getQuery() method.
    }

    public function redirect($location)
    {
        // TODO: Implement redirect() method.
    }

    public function disableRendering()
    {
        // TODO: Implement disableRendering() method.
    }

    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Get current HTTP response
     *
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get current HTTP request
     *
     * @return ServerRequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }
}