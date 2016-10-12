<?php

namespace Hellosworldos\GitTools;

class BranchInfo implements BranchInfoInterface
{
    private $masterBranch;
    private $resultBranch;
    private $processingBranches = [];

    public function __construct($masterBranch, $resultBranch, array $processingBranches)
    {
        $this->masterBranch       = $masterBranch;
        $this->resultBranch       = $resultBranch;
        $this->processingBranches = $processingBranches;
    }

    /**
     * @return string
     */
    public function getMasterBranch()
    {
        return $this->masterBranch;
    }

    /**
     * @return string
     */
    public function getResultBranch()
    {
        return $this->resultBranch;
    }

    /**
     * @return array
     */
    public function getProcessingBranches()
    {
        return $this->processingBranches;
    }
}
