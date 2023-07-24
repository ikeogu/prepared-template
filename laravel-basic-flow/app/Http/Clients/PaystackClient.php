<?php

namespace App\Http\Clients;

use GuzzleHttp\Client;


class PaystackClient {

    public static function hitPaystack(string $method, string $url, mixed $data = ''): mixed
    {
        try {

            $client = new Client();

            $options = [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('payment.paystack_secret'),
                    'Content-Type' => 'application/json'
                ],
                'json' => $data
            ];

            $url = config('payment.paystack_url') . $url;


            //code...
            $response = $client->request($method, $url, $options);
            $result = $response->getBody()->getContents();
            $formatedData = json_decode($result, true);

            if ($formatedData['status'] == true) {
                return $formatedData['data'];
            }else{
                return false;
            }
        } catch (\Throwable $th) {

            return false;
        }
    }
}