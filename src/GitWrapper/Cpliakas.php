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

        $workingCopy->isCloned();
    }

    /**
     * @return GitWorkingCopy
     */
    protected function getWorkingCopy()
    {
        return $this->workingCopy;
    }

    /**
     * @param string $withBranch
     * @param array $options
     * @return $this
     */
    public function merge($withBranch, array $options)
    {
        $this->getWorkingCopy()->merge($withBranch, $options);

        return $this;
    }

    /**
     * @param string $branch
     * @return $this
     */
    public function checkout($branch)
    {
        $this->getWorkingCopy()->checkout($branch);

        return $this;
    }

    /**
     * @param string $newBranch
     * @return $this
     */
    public function copyBranch($newBranch)
    {
        $this->getWorkingCopy()->branch($newBranch, [
            static::BRANCH_FORCE => true,
        ]);

        return $this;
    }

    /**
     * @param string $branch
     * @return $this
     */
    public function removeBranch($branch)
    {
        $this->getWorkingCopy()->branch($branch, [
            static::BRANCH_FORCE  => true,
            static::BRANCH_DELETE => true,
        ]);

        return $this;
    }

    /**
     * @param string $fromBranch
     * @return $this
     */
    public function rebase($fromBranch)
    {
        $this->getWorkingCopy()->rebase($fromBranch);

        return $this;
    }

    /**
     * @param string $fromBranch
     * @param string $toBranch
     * @param string $outputFilePath
     * @return string
     */
    public function diff($fromBranch, $toBranch, $outputFilePath)
    {
        $this->getWorkingCopy()->diff($fromBranch, $toBranch);

        return $this;
    }

    /**
     * @param string $patchPath
     * @return $this
     */
    public function apply($patchPath)
    {

    }
}
