<?php

namespace Hellosworldos\GitTools;

abstract class AbstractTask implements TaskInterface
{
    /**
     * @var BranchInfoInterface
     */
    private $branchInfo;
    private $name;

    public function __construct($name, BranchInfoInterface $branchInfo)
    {
        $this->branchInfo = $branchInfo;
        $this->name       = $name;
    }

    /**
     * @return BranchInfoInterface
     */
    public function getBranchInfo()
    {
        return $this->branchInfo;
    }

    public function getName()
    {
        return $this->name;
    }
}
