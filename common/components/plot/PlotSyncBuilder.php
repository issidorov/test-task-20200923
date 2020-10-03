<?php


namespace common\components\plot;


use common\models\Plot;

class PlotSyncBuilder
{
    public function build()
    {
        return new PlotSync($this->getModelClass(), $this->createRemoteRequest());
    }

    private function createRemoteRequest()
    {
        return new RemoteRequest();
    }

    private function getModelClass()
    {
        return Plot::class;
    }
}