<?php


namespace common\components\plot;


use Error;
use yii\httpclient\Client;

class RemoteRequest
{
    public function run(array $numbers): array
    {
        $response = (new Client())->createRequest()
            ->setUrl('http://pkk.bigland.ru/api/test/plots')
            ->setFormat(Client::FORMAT_JSON)
            ->setData([
                'collection' => [
                    'plots' => $numbers
                ]
            ])
            ->send();

        if ($response->isOk) {
            return json_decode($response->content);
        } else {
            throw new Error('Invalid http request Plot data');
        }
    }
}