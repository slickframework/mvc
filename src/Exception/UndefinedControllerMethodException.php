<?php

/**
 * This file is part of slick/mvc package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Exception;

use InvalidArgumentException;
use Slick\Mvc\Exception;

/**
 * Undefined Controller Method Exception
 *
 * @package Slick\Mvc\Exception
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class UndefinedControllerMethodException extends InvalidArgumentException implements
    Exception
{

}
