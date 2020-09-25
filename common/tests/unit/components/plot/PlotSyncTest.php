<?php

namespace common\tests\unit\components\plot;

class PlotSyncTest extends BaseTestCase
{
    public function testWithoutRecords()
    {
        $this->seePlotRecordCount(0);

        $this->createPlotSync()->run(['69:27:0000022:1306', '69:27:0000022:1307']);

        $this->seePlotRecordCount(2);
        $this->seePlotRecord('69:27:0000022:1306');
        $this->seePlotRecord('69:27:0000022:1307');

        $this->seeRemoteRequestCount(2);
        $this->seeRemoteRequest('69:27:0000022:1306');
        $this->seeRemoteRequest('69:27:0000022:1307');
    }

    public function testWithRecord()
    {
        $this->havePlotRecord('69:27:0000022:1306');

        $this->createPlotSync()->run(['69:27:0000022:1306', '69:27:0000022:1307']);

        $this->seePlotRecordCount(2);
        $this->seePlotRecord('69:27:0000022:1306');
        $this->seePlotRecord('69:27:0000022:1307');

        $this->seeRemoteRequestCount(1);
        $this->seeRemoteRequest('69:27:0000022:1307');
    }
}
