<?php

namespace common\tests\unit\plot;


use common\plot\PlotEntity;
use common\plot\DbRecord;


class FinderTest extends \Codeception\Test\Unit
{
    use HelperTrait;

    public function _after()
    {
        DbRecord::deleteAll();
    }

    public function testOneItem()
    {
        $finder = $this->createFinder();

        $plots = $finder->run(['69:27:0000022:1306']);
        $this->assertCount(1, $plots);

        $plot = $plots['69:27:0000022:1306'];

        $this->assertInstanceOf(PlotEntity::class, $plot);
        $this->assertEquals('69:27:0000022:1306', $plot->number);
        $this->assertIsString($plot->address);
        $this->assertIsFloat($plot->price);
        $this->assertIsFloat($plot->area);
    }

    public function testTwoItems()
    {
        $finder = $this->createFinder();
        $plots = $finder->run(['69:27:0000022:1306', '69:27:0000022:1307']);

        $this->assertCount(2, $plots);
        $this->assertArrayHasKey('69:27:0000022:1306', $plots);
        $this->assertArrayHasKey('69:27:0000022:1307', $plots);
    }

    public function testWithDbRecord()
    {
        $this->haveDbRecord('69:27:0000022:1306');

        $finder = $this->createFinder();
        $plots = $finder->run(['69:27:0000022:1306', '69:27:0000022:1307']);

        $this->assertEquals(['69:27:0000022:1307'], $this->remoteRequestedNumbers);

        $this->assertCount(2, $plots);
        $this->assertArrayHasKey('69:27:0000022:1306', $plots);
        $this->assertArrayHasKey('69:27:0000022:1307', $plots);
    }

    public function testUpdateDbRecords()
    {
        $this->seeDbRecordsCount(0);

        $finder = $this->createFinder();
        $finder->run(['69:27:0000022:1306', '69:27:0000022:1307']);

        $this->seeDbRecordsCount(2);
        $this->seeDbRecord('69:27:0000022:1306');
        $this->seeDbRecord('69:27:0000022:1307');
    }
}
