<?php

namespace Hellosworldos\GitTools\GitWrapper;

use GitWrapper\GitWrapper;
use GitWrapper\GitWorkingCopy;
use Hellosworldos\GitTools\EventSubscriber\StreamableInterface;
use Hellosworldos\GitTools\GitWorkspaceInterface;
use Hellosworldos\GitTools\GitWrapperInterface;
use Hellosworldos\GitTools\StreamFactoryInterface;

class Cpliakas implements GitWrapperInterface
{
    private $workingCopy;
    private $workspace;
    private $streamFactory;
    private $gitWrapper;
    private $streamableEventSubscriber;

    /**
     * @param GitWorkingCopy $workingCopy
     * @param GitWorkspaceInterface $workspace
     * @param StreamFactoryInterface $streamFactory
     * @param StreamableInterface $streamableEventSubscriber
     */
    public function __construct(
        GitWorkingCopy $workingCopy,
        GitWorkspaceInterface $workspace,
        StreamFactoryInterface $streamFactory,
        StreamableInterface $streamableEventSubscriber
    )
    {
        $this->workingCopy               = $workingCopy;
        $this->workspace                 = $workspace;
        $this->streamFactory             = $streamFactory;
        $this->gitWrapper                = $workingCopy->getWrapper();
        $this->streamableEventSubscriber = $streamableEventSubscriber;

        $workingCopy->isCloned();
    }

    /**
     * @return GitWorkingCopy
     */
    protected function getWorkingCopy()
    {
        return $this->workingCopy;
    }

    /**
     * @return StreamableInterface
     */
    protected function getStreamableEventSubscriber()
    {
        return $this->streamableEventSubscriber;
    }

    /**
     * @return GitWrapper
     */
    protected function getGitWrapper()
    {
        return $this->gitWrapper;
    }

    /**
     * @param string $withBranch
     * @param array $options
     * @return $this
     */
    public function merge($withBranch, array $options)
    {
        try {
            $this->getWorkingCopy()->merge($withBranch, $options);
        }
        catch (\Exception $e) {
            $gitException = new Exception('merge: '.$withBranch);
            $gitException->setNextException($e);

            throw $gitException;
        }

        return $this;
    }

    /**
     * @param string $branch
     * @return $this
     */
    public function checkout($branch)
    {
        $this->getWorkingCopy()->checkout($branch);

        return $this;
    }

    /**
     * @param string $newBranch
     * @return $this
     */
    public function copyBranch($newBranch)
    {
        $this->getWorkingCopy()->branch($newBranch, [
            static::BRANCH_FORCE => true,
        ]);

        return $this;
    }

    /**
     * @param string $branch
     * @return $this
     */
    public function removeBranch($branch)
    {
        $this->getWorkingCopy()->branch($branch, [
            static::BRANCH_FORCE  => true,
            static::BRANCH_DELETE => true,
        ]);

        return $this;
    }

    /**
     * @param string $fromBranch
     * @return $this
     */
    public function rebase($fromBranch)
    {
        $this->getWorkingCopy()->rebase($fromBranch);

        return $this;
    }

    /**
     * @param string $fromBranch
     * @param string $toBranch
     * @param string $outputFilePath
     * @return string
     */
    public function diff($fromBranch, $toBranch, $outputFilePath)
    {
        // Put diff contents to output stream
        $this->getGitWrapper()->streamOutput(true);

        // Create file to write to
        $stream = $this->getStreamFactory()->makeWritableFile($outputFilePath);

        // Hook event subscriber to write to stream
        $this->getStreamableEventSubscriber()->setStream($stream);

        // Produce diff content
        $this->getWorkingCopy()->diff($fromBranch, $toBranch);

        // Detach stream from event subscriber
        $this->getStreamableEventSubscriber()->unsetStream();

        // Disable content output streaming
        $this->getGitWrapper()->streamOutput(false);

        // Close written file
        $stream->close();

        return $this;
    }

    /**
     * @return StreamFactoryInterface
     */
    protected function getStreamFactory()
    {
        return $this->streamFactory;
    }

    /**
     * @param string $patchPath
     * @return $this
     */
    public function apply($patchPath)
    {
        $this->getWorkingCopy()->apply($patchPath);

        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function commit($message)
    {
        $this->getWorkingCopy()->commit($message);

        return $this;
    }

    public function mergeAbort()
    {
        $this->getWorkingCopy()->merge([
            static::MERGE_ABORT => true,
        ]);

        return $this;
    }

    /**
     * @return $this
     */
    public function clean()
    {
        $this->getWorkingCopy()->clean();

        return $this;
    }

    public function stash()
    {
        $this->getWorkingCopy()->run([static::STASH]);

        return $this;
    }

    /**
     * @return $this
     */
    public function rebaseAbort()
    {
        $this->getWorkingCopy()->rebase([
            static::REBASE_ABORT => true,
        ]);

        return $this;
    }
}
