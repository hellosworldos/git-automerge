<?php

namespace Hellosworldos\GitTools\Task\Type;

use Hellosworldos\GitTools\AbstractTask;
use Hellosworldos\GitTools\GitWrapper\Exception as GitWrapperException;
use Hellosworldos\GitTools\BranchInfoInterface;
use Hellosworldos\GitTools\GitWrapperInterface;

class Merge extends AbstractTask
{
    const NAME = 'merge';

    /**
     * @param BranchInfoInterface $branchInfo
     * @return bool
     */
    public function run(BranchInfoInterface $branchInfo)
    {
        $tmpBranch = $this->generateTmpBranch();

        $this->prepare($branchInfo->getMasterBranch(), $tmpBranch);

        foreach ($branchInfo->getProcessingBranches() as $processingBranch) {
            try {
                $this->mergeBranch($processingBranch, $tmpBranch);
            }
            catch (GitWrapperException $e) {
                $this->addException($e);
                $this->rollback($e);
            }
        }

        $this->copyResults($branchInfo->getResultBranch(), $tmpBranch);

        return !$this->hasExceptions();
    }

    protected function rollback(GitWrapperException $exception) {
        $this->getGitWrapper()->mergeAbort();

        return $this;
    }

    protected function prepare($masterBranch, $tmpBranch)
    {
        $this->getGitWrapper()
            ->checkout($masterBranch)
            ->copyBranch($tmpBranch);

        return $this;
    }

    protected function mergeBranch($processingBranch, $tmpBranch)
    {
        $this->getGitWrapper()
            ->checkout($processingBranch)
            ->checkout($tmpBranch)
            ->merge($processingBranch, [GitWrapperInterface::MERGE_NOFF => true]);

        return $this;
    }

    protected function copyResults($resultBranch, $tmpBranch)
    {
        $this->getGitWrapper()
            ->copyBranch($resultBranch)
            ->checkout($resultBranch)
            ->removeBranch($tmpBranch);

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }
}
