<?php

/**
 * This file is part of slick/mvc package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Configuration;

use Slick\Http\Session;

$settings = [];

// Uses null session as default session driver
$settings['session'] = [
    'driver' => Session::DRIVER_NULL,
    'options' => []
];

return $settings;