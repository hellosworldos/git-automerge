<?php

namespace Hellosworldos\Component\GitTools;

use Hellosworldos\Component\GitTools\Job\Result;
use Hellosworldos\Component\GitTools\Task\RegistryInterface;

class Job
{
    private $tasks = [];

    public function run(BranchInfoInterface $branchInfo)
    {
        $result = new Result();

        /* @var $task TaskInterface */
        foreach ($this->getTasks() as $task) {

        }

        return $result;
    }

    public function addTask(TaskInterface $task)
    {
        $this->tasks[$task->getName()] = $task;

        return $this;
    }

    public function getTask($name)
    {
        return $this->tasks[$name];
    }

    public function getTasks()
    {
        return $this->tasks;
    }
}
