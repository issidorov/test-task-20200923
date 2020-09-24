<?php


namespace common\plot;


class PlotService
{
    /**
     * @param array $numbers
     * @return PlotEntity[]
     */
    public function findAll(array $numbers): array
    {
        $remoteRequest = new RemoteRequest();
        $finder = new Finder($remoteRequest);
        return $finder->run($numbers);
    }
}