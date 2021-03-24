<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Setting;

trait SiteApi {

    protected static function getRemote($url, $data = array()) {
        $base = env('APP_URL', 'http://127.0.0.1:8000');

        $client = new Client([
            'verify' => false,
            'base_uri' => $base
        ]);

        $headers['headers'] = array(
            'Accept' => 'application/json',
            'Referer' => url('/'),
            'marimasak' => Setting::getSetting('version')
        );

        $data['http_errors'] = false;

        $data = array_merge($data, $headers);

        try {
            $result = $client->get($url, $data);
        } catch (RequestException $e) {
            \Log::error($e->getMessage());
            $result = $e;
        }

        return $result;
    }

}
