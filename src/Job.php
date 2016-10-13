<?php

namespace Hellosworldos\GitTools;

use Hellosworldos\GitTools\Job\Result;
use Hellosworldos\GitTools\Task\RegistryInterface;

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
