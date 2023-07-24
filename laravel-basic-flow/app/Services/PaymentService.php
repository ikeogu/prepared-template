<?php

namespace App\Services;

use App\Http\Clients\PaystackClient;

class PaymentService {


    public function initializeTransaction(array $data) : mixed
    {
        $url = '/transaction/initialize';
        $response = PaystackClient::hitPaystack('POST',$url,$data);
        return $response['authorization_url'];
    }

    public function verifyTransaction(string $ref) : mixed
     {

        return PaystackClient::hitPaystack('GET','/transaction/verify/'. $ref);

    }


}