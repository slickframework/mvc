<?php

/**
 * This file is part of slick/mvc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Console\Exception;

use RuntimeException;
use Slick\Mvc\Console\ConsoleException;

/**
 * Composer File Not Found Exception
 *
 * @package Slick\Mvc\Console\Exception
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class ComposerFileNotFoundException extends RuntimeException implements
    ConsoleException
{

}
