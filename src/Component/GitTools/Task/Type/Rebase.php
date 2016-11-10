<?php

namespace Hellosworldos\Component\GitTools\Task\Type;

use Hellosworldos\Component\GitTools\AbstractTask;
use Hellosworldos\Component\GitTools\BranchInfoInterface;
use Hellosworldos\Component\GitTools\GitWrapper\Exception as GitWrapperException;

/**
 * Class Rebase
 *
 * Rebase multiple branches into one
 *
 * @package Hellosworldos\GitTools\Task\Type
 */
class Rebase extends AbstractTask
{
    const NAME = 'rebase';

    public function run(BranchInfoInterface $branchInfo)
    {
        $tmpBranch = $this->generateTmpBranch();

        $this->prepare($branchInfo, $tmpBranch);

        foreach ($branchInfo->getProcessingBranches() as $processingBranch) {
            try {
                $this->rebaseBranch($processingBranch, $branchInfo->getMasterBranch(), $tmpBranch);
            }
            catch (GitWrapperException $e) {
                $this->addException($e);
                $this->rollback($e);
            }
        }

        $this->copyResults($branchInfo, $tmpBranch);

        return !$this->hasExceptions();
    }

    protected function prepare(BranchInfoInterface $branchInfo, $tmpBranch)
    {
        $this->getGitWrapper()
            ->stash()
            ->clean()
            ->checkout($branchInfo->getMasterBranch())
            ->copyBranch($tmpBranch);
    }

    protected function rollback(GitWrapperException $exception) {
        $this->getGitWrapper()->rebaseAbort();

        return $this;
    }

    protected function rebaseBranch($processingBranch, $masterBranch, $tmpBranch)
    {
        $this->getGitWrapper()
            ->checkout($processingBranch)
            ->rebase($masterBranch)
            ->rebase($tmpBranch)
            ->copyBranch($tmpBranch);
    }

    protected function copyResults(BranchInfoInterface $branchInfo, $tmpBranch)
    {
        $this->getGitWrapper()
            ->copyBranch($branchInfo->getResultBranch())
            ->checkout($branchInfo->getResultBranch())
            ->removeBranch($tmpBranch);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }
}
