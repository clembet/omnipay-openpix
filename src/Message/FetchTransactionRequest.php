<?php namespace Omnipay\OpenPIX\Message;

class FetchTransactionRequest extends AbstractRequest
{
    protected $resourcePix = 'charge';//transaction
    protected $requestMethod = 'GET';

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
            'Content-Type' => 'application/json',
            'Authorization' => $this->getAppID()
        ];

        $httpResponse = $this->httpClient->request($method, $url, $headers);
        $json = $httpResponse->getBody()->getContents();
        $json = @json_decode($json, true);
        return $this->createResponse(@$json["charge"]);
    }

    protected function getEndpoint()
    {
        return parent::getEndpoint().'/'.$this->getTransactionID();
    }
}
