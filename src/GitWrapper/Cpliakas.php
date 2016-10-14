<?php

namespace Hellosworldos\GitTools\GitWrapper;

use GitWrapper\GitWrapper;

class Cpliakas
{
    private $wrapper;

    public function __construct(GitWrapper $wrapper)
    {
        $this->wrapper = $wrapper;
    }

    public function merge($toBranch, $fromBranch, array $options)
    {
        return $this;
    }

    public function checkout($argument1)
    {
        // TODO: write logic here
    }
}
