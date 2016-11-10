<?php

namespace Hellosworldos\Component\GitTools;

class BranchInfo implements BranchInfoInterface
{
    private $masterBranch;
    private $resultBranch;
    private $processingBranches = [];
    private $origin;

    public function __construct($masterBranch, $resultBranch, array $processingBranches)
    {
        $this->masterBranch       = $masterBranch;
        $this->resultBranch       = $resultBranch;
        $this->processingBranches = $processingBranches;
    }

    /**
     * @return string
     */
    public function getMasterBranch()
    {
        return $this->masterBranch;
    }

    /**
     * @return string
     */
    public function getResultBranch()
    {
        return $this->resultBranch;
    }

    /**
     * @return array
     */
    public function getProcessingBranches()
    {
        return $this->processingBranches;
    }

    public function getOrigin()
    {
        if (!is_null($this->origin)) {
            return $this->origin;
        }

        return static::ORIGIN;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setOrigin($value)
    {
        $this->origin = $value;

        return $this;
    }
}
