<?php

/**
 * This file is part of slick/mvc package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Http\Dispatcher;

use Slick\Mvc\ControllerInterface;
use Slick\Mvc\Exception\UndefinedControllerMethodException;

/**
 * Controller Invoker
 *
 * @package Slick\Mvc\Http\Dispatcher
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class ControllerInvoker implements ControllerInvokerInterface
{
    /**
     * Invokes the controller action returning view data
     *
     * @param ControllerInterface $controller
     * @param ControllerDispatch $dispatch
     *
     * @return array
     */
    public function invoke(
        ControllerInterface $controller,
        ControllerDispatch $dispatch
    )
    {
        $reflection = new \ReflectionClass($controller);

        if (!$reflection->hasMethod($dispatch->getMethod())) {
            throw new UndefinedControllerMethodException(
                "The controller '{$dispatch->getControllerClassName()}' does ".
                "not have a method called '{$dispatch->getMethod()}'."
            );
        }

        $method = $reflection->getMethod($dispatch->getMethod());
        $method->invokeArgs($controller, $dispatch->getArguments());

        return $controller->getViewData();
    }
}