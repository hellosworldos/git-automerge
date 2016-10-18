<?php

namespace Hellosworldos\GitTools;

abstract class AbstractTask implements TaskInterface
{
    private $gitWrapper;

    /**
     * @param string $name
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
}
