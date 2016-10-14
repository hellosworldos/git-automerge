<?php

namespace Hellosworldos\GitTools\Task\Type;

use Hellosworldos\GitTools\AbstractTask;
use Hellosworldos\GitTools\BranchInfoInterface;
use Hellosworldos\GitTools\GitWrapperInterface;

class Merge extends AbstractTask
{
    public function run(BranchInfoInterface $branchInfo)
    {
        foreach ($branchInfo->getProcessingBranches() as $processingBranch) {
            $this->getGitWrapper()->merge($branchInfo->getMasterBranch(), $processingBranch, [
                GitWrapperInterface::MERGE_NOFF => true,
            ]);
        }
    }
}
