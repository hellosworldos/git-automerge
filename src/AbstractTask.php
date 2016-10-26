<?php

namespace Hellosworldos\GitTools;

abstract class AbstractTask implements TaskInterface
{
    private $gitWrapper;
    private $exceptions;

    /**
     * @param GitWrapperInterface $gitWrapper
     */
    public function __construct(GitWrapperInterface $gitWrapper)
    {
        $this->gitWrapper = $gitWrapper;
    }

    /**
     * @return GitWrapperInterface
     */
    protected function getGitWrapper()
    {
        return $this->gitWrapper;
    }

    /**
     * @return string
     */
    protected function generateTmpBranch()
    {
        return 'tmp/'.md5(uniqid(mt_rand())).'_'.time();
    }

    /**
     * @param \Exception $e
     * @return $this
     */
    protected function addException(\Exception $e)
    {
        $this->exceptions[] = $e;
    }

    /**
     * @return bool
     */
    protected function hasExceptions()
    {
        return (bool)count($this->exceptions);
    }

    /**
     * @return mixed
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }
}
