<?php

namespace Hellosworldos\GitTools\Task\Type;

use Hellosworldos\GitTools\AbstractTask;
use Hellosworldos\GitTools\BranchInfoInterface;

class Rebase extends AbstractTask
{
    public function run(BranchInfoInterface $branchInfo)
    {
        foreach ($branchInfo->getProcessingBranches() as $processingBranch) {
            $tmpBranch = $this->generateTmpBranch();

            $this->getGitWrapper()
                ->checkout($branchInfo->getMasterBranch())
                ->checkout($processingBranch)
                ->copyBranch($tmpBranch)
                ->checkout($tmpBranch)
                ->rebase($branchInfo->getMasterBranch())
                ->copyBranch($branchInfo->getResultBranch())
                ->checkout($branchInfo->getResultBranch())
                ->removeBranch($tmpBranch);
        }

        return true;
    }
}
