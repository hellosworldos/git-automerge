<?php

namespace Hellosworldos\Component\GitTools;

class BranchInfoFactory implements BranchInfoFactoryInterface
{
    /**
     * @param string $masterBranch
     * @param string $resultBranch
     * @param array $processingBranches
     * @return BranchInfo
     */
    public function build($masterBranch, $resultBranch, array $processingBranches)
    {
        return new BranchInfo($masterBranch, $resultBranch, $processingBranches);
    }
}
