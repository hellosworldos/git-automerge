<?php

namespace Hellosworldos\Component\GitTools\Task\Type;

use Hellosworldos\Component\GitTools\AbstractTask;
use Hellosworldos\Component\GitTools\BranchInfoInterface;
use Hellosworldos\Component\GitTools\GitWrapperInterface;
use Symfony\Component\Filesystem\Filesystem;

class Squash extends AbstractTask
{
    const NAME = 'squash';

    private $filesystem;

    public function __construct(GitWrapperInterface $gitWrapper, Filesystem $filesystem)
    {
        parent::__construct($gitWrapper);

        $this->filesystem = $filesystem;
    }

    public function run(BranchInfoInterface $branchInfo)
    {
        foreach ($branchInfo->getProcessingBranches() as $processingBranch) {
            $patchFileName = $this->getPatchTmpFileName();

            $this->getGitWrapper()
                ->checkout($branchInfo->getMasterBranch())
                ->copyBranch($branchInfo->getResultBranch())
                ->checkout($branchInfo->getResultBranch())
                ->diff($branchInfo->getMasterBranch(), $processingBranch, $patchFileName)
                ->apply($patchFileName)
                // @TODO add branch message generator
                ->commit($processingBranch);

            $this->getFilesystem()->remove($patchFileName);
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
     * @return Filesystem
     */
    protected function getFilesystem()
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
