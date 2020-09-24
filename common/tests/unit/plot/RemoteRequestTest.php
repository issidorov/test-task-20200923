<?php

namespace common\tests\unit\plot;


use common\plot\RemoteRequest;

class RemoteRequestTest extends \Codeception\Test\Unit
{
    use HelperTrait;

    public function test()
    {
        $mockedRequest = $this->createRemoteRequestMock();
        $realRequest = new RemoteRequest();

        $expected = $mockedRequest->run(['69:27:0000022:1306']);
        $actual = $realRequest->run(['69:27:0000022:1306']);

        $this->assertEquals($expected, $actual);
    }
}
