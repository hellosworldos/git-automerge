<?php

namespace Hellosworldos\Component\GitTools;

use GuzzleHttp\Stream\Stream;

class StreamFactory implements StreamFactoryInterface
{
    /**
     * @param string $filename
     * @return Stream
     */
    public function makeWritableFile($filename)
    {
        $stream = Stream::factory($filename, [
            'metadata' => [
                'mode' => 'w',
            ],
        ]);

        return $stream;
    }
}
