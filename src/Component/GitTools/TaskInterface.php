<?php

namespace Hellosworldos\Component\GitTools;

interface TaskInterface
{
    /**
     * @param BranchInfoInterface $branchInfo
     * @return bool
     */
    public function run(BranchInfoInterface $branchInfo);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return array
     */
    public function getExceptions();
}
