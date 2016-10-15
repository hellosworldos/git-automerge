<?php

namespace Hellosworldos\GitTools;

interface GitWrapperInterface
{
    const MERGE_NOFF   = 'no-ff';
    const BRANCH_FORCE = 'force';

    /**
     * @param string $withBranch
     * @param array $options
     * @return $this
     */
    public function merge($withBranch, array $options);

    /**
     * @param string $branch
     * @return $this
     */
    public function checkout($branch);

    /**
     * @param string $newBranch
     * @return $this
     */
    public function copyBranch($newBranch);
}
