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
 * File Not Found Exception
 *
 * @package Slick\Mvc\Exception
 * @author  Filipe Silva <silva.filipe@gmail.com>
 */
class FileNotFoundException extends InvalidArgumentException implements
    Exception
{

}