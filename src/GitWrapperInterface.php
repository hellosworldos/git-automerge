<?php

namespace Hellosworldos\GitTools;

interface GitWrapperInterface
{
    const MERGE_NOFF    = 'no-ff';
    const BRANCH_FORCE  = 'force';
    const BRANCH_DELETE = 'delete';

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

    /**
     * @param string $branch
     * @return $this
     */
    public function removeBranch($branch);

    /**
     * @param string $fromBranch
     * @return $this
     */
    public function rebase($fromBranch);

    /**
     * @param string $fromBranch
     * @param string $toBranch
     * @return string
     */
    public function diff($fromBranch, $toBranch);

    /**
     * @param string $patchPath
     * @return $this
     */
    public function apply($patchPath);
}
