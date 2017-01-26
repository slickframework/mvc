<?php

namespace spec\Slick\Mvc\Console\Command;

use Slick\Mvc\Console\Command\BuildWebApp;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Command\Command;

class BuildWebAppSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(BuildWebApp::class);
    }

    function its_a_symfony_console_command()
    {
        $this->shouldBeAnInstanceOf(Command::class);
    }
}
