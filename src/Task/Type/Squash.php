<?php

namespace Hellosworldos\GitTools\Task\Type;

use Hellosworldos\GitTools\AbstractTask;
use Hellosworldos\GitTools\BranchInfoInterface;
use Symfony\Component\Filesystem\Filesystem;

class Squash extends AbstractTask
{
    const NAME = 'squash';

    public function run(BranchInfoInterface $branchInfo)
    {
        foreach ($branchInfo->getProcessingBranches() as $processingBranch) {
            $patchFileName = $this->getPatchTmpFileName();

            $this->getGitWrapper()
                ->checkout($branchInfo->getMasterBranch())
                ->checkout($processingBranch)
                ->diff($branchInfo->getMasterBranch(), $processingBranch, $patchFileName)
                ->checkout($branchInfo->getResultBranch())
                ->apply($patchFileName)
                // @TODO add branch message generator
                ->commit($processingBranch);
        }

        return true;
    }

    /**
     * @return string
     */
    protected function getPatchTmpFileName()
    {
        return '/tmp/'.md5(uniqid(mt_rand())).'.patch';
    }

    /**
     * @param Filesystem $filesystem
     * @return $this
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * @return Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }
}
