<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class PaymentService
{
    private $merchantControl;
    private $groupId;
    private $login;

    public function __construct()
    {
        $this->login   = 'Allsumou_Pay369';
        $this->groupId = 13716; // Group ID
        $this->merchantControl = '3788A200-D7F7-11EF-9E47-C6274A34CF9E'; //Merchant Control Key
    }

    /**
     * Send HTTP Request using Laravel's HTTP client
     *
     * @param string $url
     * @param array $requestFields
     * @return array
     * @throws RuntimeException
     */
    public function sendRequest(string $url, array $requestFields): array
    {
        $response = Http::asForm()->withHeaders([
            'User-Agent' => 'Pay369-Client/1.0',
        ])->post($url, $requestFields);

        if ($response->failed()) {
            throw new RuntimeException(
                'Error occurred: HTTP Code ' . $response->status(),
                $response->status()
            );
        }

        $responseBody = $response->body();

        if (empty($responseBody)) {
            throw new RuntimeException('Host response is empty');
        }

        parse_str($responseBody, $responseFields);

        return $responseFields;
    }

    /**
     * Generate SHA1 hash for signing
     *
     * @param string $string
     * @return string
     */
    private function signString(string $string): string
    {
        return sha1($string . $this->merchantControl);
    }

    /**
     * Sign payment request
     *
     * @param array $requestFields
     * @return string
     */
    public function signPaymentRequest(array $requestFields): string
    {
        $base = $this->groupId;
        $base .= $requestFields['client_orderid'];
        $base .= $requestFields['amount'] * 100;
        $base .= $requestFields['email'];

        return $this->signString($base);
    }

    /**
     * Sign account verification request
     *
     * @param array $requestFields
     * @return string
     */
    public function signAccountVerificationRequest(array $requestFields): string
    {
        $base = $this->groupId;
        $base .= $requestFields['client_orderid'];
        $base .= $requestFields['email'];

        return $this->signString($base);
    }

    /**
     * Signs status request.
     *
     * @param array $requestFields
     * @return string
     */
    public function signStatusRequest(array $requestFields): string
    {
        $base = '';
        $base .= $this->login;
        $base .= $requestFields['client_orderid'];
        $base .= $requestFields['orderid'];

        return $this->signString($base);
    }
    
   /**
     * Fetch completed url
     *
     * @return string
     */
    public function getUrl()
    {
        return "https://gate.pay369.tech/paynet/api/v2/sale/group/$this->groupId";
    }

      /**
     * Fetch completed url
     *
     * @return string
     */
    public function getStatusUrl()
    {
        return "https://gate.pay369.tech/paynet/api/v2/status/group/$this->groupId";
    }
}
