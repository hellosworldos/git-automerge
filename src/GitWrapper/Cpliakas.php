<?php

namespace Hellosworldos\GitTools\GitWrapper;

use GitWrapper\GitWrapper;
use GitWrapper\GitWorkingCopy;
use Hellosworldos\GitTools\GitWorkspaceInterface;
use Hellosworldos\GitTools\GitWrapperInterface;

class Cpliakas implements GitWrapperInterface
{
    private $workingCopy;
    private $workspace;

    /**
     * @param GitWorkingCopy $workingCopy
     * @param GitWorkspaceInterface $workspace
     */
    public function __construct(GitWorkingCopy $workingCopy, GitWorkspaceInterface $workspace)
    {
        $this->workingCopy = $workingCopy;
        $this->workspace   = $workspace;
    }

    /**
     * @return GitWorkingCopy
     */
    protected function getWorkingCopy()
    {
        return $this->workingCopy;
    }

    public function merge($toBranch, $fromBranch, array $options)
    {
        return $this;
    }

    public function checkout($branch)
    {
        $this->getWorkingCopy()->checkout($branch);

        return $this;
    }
}
