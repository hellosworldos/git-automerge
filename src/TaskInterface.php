<?php

namespace Hellosworldos\GitTools;

interface TaskInterface
{
    public function run(BranchInfoInterface $branchInfo);

    public function getName();
}
