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
            $tmpBranch = $this->generateTmpBranch();
            $this->getGitWrapper()
                ->checkout($processingBranch)
                ->checkout($branchInfo->getMasterBranch())
                ->copyBranch($tmpBranch)
                ->checkout($tmpBranch)
                ->merge($processingBranch, [GitWrapperInterface::MERGE_NOFF => true]);
        }
    }
}
