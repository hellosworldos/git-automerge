<?php

namespace Hellosworldos\GitTools;

class Task
{
    /**
     * @var BranchInfoInterface
     */
    private $branchInfo;

    /**
     * @param BranchInfoInterface $branchInfo
     * @return $this
     */
    public function setBranchInfo(BranchInfoInterface $branchInfo)
    {
        $this->branchInfo = $branchInfo;

        return $this;
    }

    /**
     * @return BranchInfoInterface
     */
    public function getBranchInfo()
    {
        return $this->branchInfo;
    }

    public function addSubtask()
    {
        // TODO: write logic here
    }
}
