<?php

namespace spec\Slick\Mvc\Console\Command\Task;

use PhpSpec\Exception\Example\FailureException;
use Slick\Mvc\Console\Command\Task\AskForWebRoot;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Mvc\Console\Command\TaskInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class AskForWebRootSpec extends ObjectBehavior
{

    function let(Command $command)
    {
        $this->beConstructedWith($command);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AskForWebRoot::class);
    }

    function its_a_command_task()
    {
        $this->shouldBeAnInstanceOf(TaskInterface::class);
    }

    function it_asks_for_http_server_document_root_path(
        Command $command,
        QuestionHelper $helper,
        InputInterface $input,
        OutputInterface $output
    ) {

        $expected = 'public';
        $this->setUp($expected, $command, $helper, $input, $output);
        $this->execute($input, $output)->shouldBe($expected);
    }

    private function validateQuestion(Question $question)
    {
        $message = "What's the application document root? (webroot): ";
        if ($question->getQuestion() !== $message) {
            throw new FailureException(
                "Expected \"{$message}\" question, " .
                "but got \"{$question->getQuestion()}\""
            );

        };
        return true;
    }

    private function setUp(
        $result,
        Command $command,
        QuestionHelper $helper,
        InputInterface $input,
        OutputInterface $output
    )
    {
        $closure = function (Question $object) {return $this->validateQuestion($object);};
        $command->getHelper('question')
            ->shouldBeCalled()
            ->willReturn($helper);
        $helper->ask(
            $input,
            $output,
            Argument::that($closure)
        )
            ->shouldBeCalled()
            ->willReturn($result);
        $this->beConstructedWith($command);
    }
}