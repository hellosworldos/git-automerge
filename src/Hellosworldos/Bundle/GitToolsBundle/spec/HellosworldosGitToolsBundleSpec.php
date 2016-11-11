<?php

namespace spec\Hellosworldos\Bundle\GitToolsBundle;

use Hellosworldos\Bundle\GitToolsBundle\HellosworldosGitToolsBundle;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HellosworldosGitToolsBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(HellosworldosGitToolsBundle::class);
        $this->shouldBeAnInstanceOf(Bundle::class);
    }
}
