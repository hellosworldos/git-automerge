<?php

namespace Hellosworldos\GitTools;

abstract class AbstractTask implements TaskInterface
{
    private $gitWrapper;
    private $name;

    public function __construct($name, GitWrapperInterface $gitWrapper)
    {
        $this->gitWrapper = $gitWrapper;
        $this->name       = $name;
    }

    /**
     * @return GitWraooerInterface
     */
    protected function getGitWrapper()
    {
        return $this->gitWrapper;
    }

    public function getName()
    {
        return $this->name;
    }
}
