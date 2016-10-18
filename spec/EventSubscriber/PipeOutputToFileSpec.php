<?php

namespace spec\Hellosworldos\GitTools\EventSubscriber;

use GitWrapper\Event\GitEvents;
use GitWrapper\Event\GitOutputEvent;
use GuzzleHttp\Stream\StreamInterface;
use Hellosworldos\GitTools\EventSubscriber\PipeOutputToFile;
use Hellosworldos\GitTools\EventSubscriber\StreamableInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Process\Process;

class PipeOutputToFileSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PipeOutputToFile::class);
        $this->shouldImplement(EventSubscriberInterface::class);
        $this->shouldImplement(StreamableInterface::class);
    }

    function let()
    {

    }

    function it_should_set_stream(StreamInterface $stream)
    {
        $this->shouldThrow()->during('setStream', ['string']);
        $this->shouldThrow()->during('setStream', []);
        $this->shouldNotThrow()->during('setStream', [$stream]);
        $this->setStream($stream)->shouldReturn($this);
    }

    function it_should_get_stream(StreamInterface $stream)
    {
        $this->setStream($stream);
        $this->getStream()->shouldBe($stream);
    }

    function it_unsets_stream(StreamInterface $stream)
    {
        $this->setStream($stream);
        $this->unsetStream()->shouldReturn($this);
        $this->getStream()->shouldBe(null);
    }

    function it_checks_has_stream(StreamInterface $stream)
    {
        // No stream
        $this->hasStream()->shouldBe(false);

        // Attach steram
        $this->setStream($stream);
        $this->hasStream()->shouldBe(true);
    }

    function it_gets_subscribed_events()
    {
        $this->getSubscribedEvents()->shouldBe([GitEvents::GIT_OUTPUT => 'onGitOutput']);
    }

    function it_expects_event_object_param_on_git_output(GitOutputEvent $event)
    {
        $this->shouldThrow()->during('onGitOutput', ['string']);
        $this->shouldThrow()->during('onGitOutput', []);
        $this->onGitOutput($event);
    }

    function it_processes_on_git_output_if_has_output_stream(GitOutputEvent $event, StreamInterface $stream)
    {
        $this->setStream($stream);
        $outputBuffer = 'output';
        $event->getType()->willReturn(Process::OUT)->shouldBeCalled();
        $event->getBuffer()->willReturn($outputBuffer)->shouldBeCalled();
        $stream->write($outputBuffer)->willReturn(sizeof($outputBuffer));
        $this->onGitOutput($event);
    }

    function it_processes_on_git_output_if_has_err_stream(GitOutputEvent $event, StreamInterface $stream)
    {
        $this->setStream($stream);
        $outputBuffer = 'error';
        $event->getType()->willReturn(Process::ERR)->shouldBeCalled();
        $event->getBuffer()->shouldNotBeCalled();
        $stream->write($outputBuffer)->shouldNotBeCalled();
        $this->onGitOutput($event);
    }

    function it_processes_on_git_output_if_no_stream(GitOutputEvent $event, StreamInterface $stream)
    {
        $outputBuffer = 'output';
        $event->getType()->shouldNotBeCalled();
        $event->getBuffer()->shouldNotBeCalled();
        $stream->write($outputBuffer)->shouldNotBeCalled();
        $this->onGitOutput($event);
    }
}
