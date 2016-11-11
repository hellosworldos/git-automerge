<?php

namespace spec\Hellosworldos\Component\GitTools\GitWrapper;

use Hellosworldos\Component\GitTools\GitWrapper\Exception;
use Hellosworldos\Component\GitTools\GitWrapper\ExceptionDecoratorInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Exception::class);
        $this->shouldImplement(\Exception::class);
        $this->shouldImplement(ExceptionDecoratorInterface::class);
    }

    function it_should_have_next_exception(Exception $exception)
    {
        $this->setNextException($exception)->shouldReturn($this);
        $this->shouldThrow()->during('setNextException', ['not exception']);
        $this->shouldThrow()->during('setNextException', [new \stdClass()]);

        $this->getNextException()->shouldReturn($exception);
    }
}
