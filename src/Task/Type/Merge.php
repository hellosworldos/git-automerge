<?php

namespace Hellosworldos\GitTools\Task\Type;

use Hellosworldos\GitTools\AbstractTask;
use Hellosworldos\GitTools\BranchInfoFactoryInterface;
use Hellosworldos\GitTools\BranchInfoInterface;
use Hellosworldos\GitTools\GitWrapperInterface;

class Merge extends AbstractTask
{
    const NAME = 'merge';

    private $branchInfoFactory;

    /**
     * @param BranchInfoInterface $branchInfo
     * @return bool
     * @TODO implement fault tolerance
     */
    public function run(BranchInfoInterface $branchInfo)
    {
        $tmpBranch = $this->generateTmpBranch();

        $this->getGitWrapper()
            ->checkout($branchInfo->getMasterBranch())
            ->copyBranch($tmpBranch);

        foreach ($branchInfo->getProcessingBranches() as $processingBranch) {
            $this->getGitWrapper()
                ->checkout($processingBranch)
                ->checkout($tmpBranch)
                ->merge($processingBranch, [GitWrapperInterface::MERGE_NOFF => true]);
        }

        $this->getGitWrapper()
            ->copyBranch($branchInfo->getResultBranch())
            ->checkout($branchInfo->getResultBranch())
            ->removeBranch($tmpBranch);

        return true;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }
}
