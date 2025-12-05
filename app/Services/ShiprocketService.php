<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ShiprocketService
{
    protected $client;
    protected $base = 'https://apiv2.shiprocket.in/v1/external/';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->base,
            'timeout'  => 20,
        ]);
    }

    /**
     * Get Shiprocket Token (cached for 55 minutes)
     */
    public function getToken()
    {
        $cacheKey = 'shiprocket_token';

        // Return cached token if exists
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = $this->client->post('auth/login', [
                'json' => [
                    'email'    => config('services.shiprocket.email'),
                    'password' => config('services.shiprocket.password'),
                ],
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            if (!empty($result['token'])) {
                Cache::put($cacheKey, $result['token'], now()->addMinutes(55));
                return $result['token'];
            }

            Log::error("Shiprocket token missing", ['response' => $result]);
        } catch (\Throwable $e) {
            Log::error("Shiprocket login failed", [
                'message' => $e->getMessage(),
            ]);
        }

        return null;
    }

    /**
     * Create Adhoc Order
     */
    public function createAdhocOrder(array $payload)
    {
        $token = $this->getToken();

        if (!$token) {
            throw new \Exception('Unable to obtain Shiprocket token');
        }
       
        try {
            $response = $this->client->post('orders/create/adhoc', [
                'headers' => [
                    'Authorization' => "Bearer {$token}",
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                ],
                'json' => $payload,
            ]);
           

            return json_decode($response->getBody(), true);

        } catch (\GuzzleHttp\Exception\ClientException $ce) {
            $body = $ce->getResponse() ? $ce->getResponse()->getBody()->getContents() : null;

            Log::error("Shiprocket Client Error", [
                'body' => $body
            ]);

            throw $ce;

        } catch (\Throwable $e) {
            Log::error("Shiprocket Order Error", [
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
