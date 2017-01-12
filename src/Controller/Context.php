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
     * @return Context|ControllerContextInterface
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
    public function getPost($name = null, $default = null)
    {
        $parameters = $this->request->getServerParams();
        return $this->getDataFrom($parameters, $name, $default);
    }

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
    public function getQuery($name = null, $default = null)
    {
        $parameters = $this->request->getQueryParams();
        return $this->getDataFrom($parameters, $name, $default);
    }

    /**
     * Sets a redirection header in the HTTP response
     *
     * @param string $location
     *
     * @return void
     */
    public function redirect($location)
    {
        $response = $this->response
            ->withStatus(302)
            ->withHeader('location', $location)
        ;
        $this->setResponse($response);
    }

    /**
     * Disables response rendering
     *
     * @return Context|ControllerContextInterface
     */
    public function disableRendering()
    {
        $this->request = $this->request->withAttribute('rendering', false);
        return $this;
    }

    /**
     * Sets a new response
     *
     * @param ResponseInterface $response
     *
     * @return Context|ControllerContextInterface
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
        return $this;
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

    /**
     * Gets the parameters with provided name from parameters
     *
     * @param array       $parameters
     * @param string|null $name
     * @param mixed       $default
     *
     * @return array|string|mixed
     */
    private function getDataFrom(
        array $parameters,
        $name = null,
        $default = null
    ) {
        if ($name === null) {
            return $parameters;
        }

        $value = array_key_exists($name, $parameters)
            ? $parameters[$name]
            : $default;

        return $value;
    }
}