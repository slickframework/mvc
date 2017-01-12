<?php

namespace spec\Slick\Mvc\Controller;

use Slick\Mvc\Controller\Context;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Mvc\Controller\ControllerContextInterface;

class ContextSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Context::class);
    }

    function its_a_controller_context()
    {
        $this->shouldBeAnInstanceOf(ControllerContextInterface::class);
    }
}
