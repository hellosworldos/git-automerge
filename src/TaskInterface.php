<?php

namespace Hellosworldos\GitTools;

interface TaskInterface
{
    const MASTER_BRANCH = 'master';

    public function run($processingBranch, $resultBranch, $masterBranch = self::MASTER_BRANCH);

    public function getName();
}
