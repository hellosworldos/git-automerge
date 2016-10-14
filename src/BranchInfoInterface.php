<?php

namespace Hellosworldos\GitTools;

interface BranchInfoInterface
{
    const ORIGIN = 'origin';

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

    /**
     * @return string
     */
    public function getOrigin();
}
