<?php

namespace Hellosworldos\GitTools;

interface BranchInfoInterface
{
    /**
     * @return string
     */
    public function getMasterBranch();

    /**
     * @return string
     */
    public function getResultBranch();

    /**
     * @return array
     */
    public function getProcessingBranches();
}
