<?php namespace Omnipay\OpenPIX\Message;

/**
 *
 * <code>
 *   // Do a refund transaction on the gateway
 *   $transaction = $gateway->void(array(
 *       'transactionId'     => $transactionCode,
 *       'paymentType'       => "Pix"
 *   ));
 *
 *   $response = $transaction->send();
 *   if ($response->isSuccessful()) {
 *   }
 * </code>
 */

class VoidRequest extends AbstractRequest
{
    protected $resourcePix = 'invoice/cancel/';
    protected $requestMethod = 'POST';

    public function getData()
    {
        $this->validate("transactionId");
        return parent::getData();
    }

    public function sendData($data)
    {
        $this->validate('transactionId', "paymentType");

        $url = $this->getEndpoint();
        $method = $this->requestMethod;

        $headers = [
            'Accept' => 'application/json',
            'Accept-Charset' => 'UTF-8',
            'Accept-Encoding' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $data = [
            'clientID' => $this->getClientID(),
            'appID' => $this->getAppID(),
            "status" => "canceled",
            'transaction_id' => $this->getTransactionID()
        ];

        $httpResponse = $this->httpClient->request($method, $url, $headers, $this->toJSON($data));
        $json = $httpResponse->getBody()->getContents();
        $json = @json_decode($json, true);
        return $this->createResponse($json["cancellation_request"]);
    }
}
