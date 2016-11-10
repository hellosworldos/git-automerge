<?php

namespace Hellosworldos\Component\GitTools;

interface BranchInfoFactoryInterface
{
    /**
     * @param string $masterBranch
     * @param string $resultBranch
     * @param array $processingBranches
     * @return BranchInfoInterface
     */
    public function build($masterBranch, $resultBranch, array $processingBranches);
}
