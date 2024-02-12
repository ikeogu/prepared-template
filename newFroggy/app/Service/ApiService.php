<?php

namespace App\Service;

use App\DataTransferObject\CallLogDto;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;


class ApiService
{
    public function fetchEncrytedUserCode(string $phoneNumber) : string
    {


        $client = new Client();
        // Define the data to be sent
        $data = [
            'source' => $phoneNumber, // Assuming $phoneNumber contains the phone number
        ];

        // Send the request with form parameters
        $response = $client->post('https://billing.froggytalk.com/billing/froggy_api/billing_encryption/encrypt_value.php', [
            'form_params' => $data,
        ]);

        return  json_decode($response->getBody(), true)['value'];
    }


    public function fetchUserCallLogs(string $cust_id) : array
    {
        $client = new Client();

        $data = [
            'cust_id' => $cust_id
        ];

        $response = $client->post('https://billing.froggytalk.com/billing/froggy_api/billing_cdr/user_cdr.php',[
            'form_params' => $data,
        ]);

        return  json_decode($response->getBody(), true)['msg'];
    }
}
