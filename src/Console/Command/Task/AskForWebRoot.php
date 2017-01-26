<?php

/**
 * This file is part of slick/mvc package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mvc\Console\Command\Task;

use Slick\Mvc\Console\Command\TaskInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Ask For Web Root
 *
 * @package Slick\Mvc\Console\Command\Task
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class AskForWebRoot implements TaskInterface
{
    /**
     * @var Command
     */
    private $command;

    /**
     * Creates an Ask For Web Root task
     *
     * @param Command $command
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
    }


    /**
     * Executes the current task.
     *
     * This method can return the task execution result. For example if this
     * task is asking for user input it should return its input.
     *
     * @param InputInterface $input An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return mixed
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var QuestionHelper $helper */
        $helper = $this->command->getHelper('question');
        return $helper->ask($input, $output, new Question("What's the application document root? [webroot] ", 'webroot'));
    }
}