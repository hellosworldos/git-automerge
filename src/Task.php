<?php

namespace Hellosworldos\GitTools;

abstract class Task implements TaskInterface
{
    /**
     * @var BranchInfoInterface
     */
    private $branchInfo;

    public function __construct(BranchInfoInterface $branchInfo)
    {
        $this->branchInfo = $branchInfo;
    }

    /**
     * @return BranchInfoInterface
     */
    public function getBranchInfo()
    {
        return $this->branchInfo;
    }

    /**
     * @return mixed
     */
    abstract public function run();
}
