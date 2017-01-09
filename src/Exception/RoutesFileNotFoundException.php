<?php

/**
 * This file is part of slick/mvc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Exception;

use InvalidArgumentException;
use Slick\Mvc\Exception;

/**
 * Routes File Not Found Exception
 *
 * @package Slick\Mvc\Exception
 * @author  Filipe Silva <filipe.silva@sata.pt>
 */
class RoutesFileNotFoundException extends InvalidArgumentException implements
    Exception
{

}
