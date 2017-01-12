<?php

/**
 * This file is part of slick/mvc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc;


use Slick\Mvc\Controller\ControllerContextInterface;

interface ControllerInterface
{

    public function setContext(ControllerContextInterface $context);

    public function set($name, $value);
}