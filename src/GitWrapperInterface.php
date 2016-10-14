<?php

namespace Hellosworldos\GitTools;

interface GitWrapperInterface
{
    const MERGE_NOFF = 'no-ff';

    public function merge($toBranch, $fromBranch, array $options);
}
