<?php

/**
 * This file is part of slick/mvc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Http\Dispatcher;

use Slick\Mvc\ControllerInterface;

/**
 * Controller Invoker Interface
 *
 * @package Slick\Mvc\Http\Dispatcher
 * @author  Filipe Silva <filipe.silva@sata.pt>
 */
interface ControllerInvokerInterface
{

    /**
     * Invokes the controller action returning view data
     *
     * @param ControllerInterface $controller
     * @param ControllerDispatch  $dispatch
     *
     * @return array
     */
    public function invoke(
        ControllerInterface $controller,
        ControllerDispatch $dispatch
    );
}
