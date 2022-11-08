<?php namespace Omnipay\OpenPIX\Message;

/*
Fluxo 1) Exemplo de Post Simples enviado pela OpenPIX (HTTP Methods: POST)

apiKey=apk_12345678-OiCWOKczTjutZazRSfTlVBDpHFxpkdzz&
transaction_id=BPV661O7AVLORCN5&
notification_id= W6QM6MORZW4KUENC0NU6ERN0AULFUIUROKEU72L6ZQQT4E6521CGT0G3V2JQKDI9&
notification_date=2017-07-25 11:21:19
source_api=https://api.openpix.com.br
 */

class NotificationRequest extends AbstractRequest
{
    protected $resourcePix = 'invoice/notification/';
    protected $requestMethod = 'POST';

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        return parent::getData();
    }

    public function getNotificationID()
    {
        return $this->getParameter('notification_id');
    }

    public function setNotificationID($value)
    {
        return $this->setParameter('notification_id', $value);
    }

    public function setNotificationDate($value)
    {
        return $this->setParameter('notification_date', $value);
    }

    public function getNotificationDate()
    {
        return $this->getParameter('notification_date');
    }

    public function getSourceApi()
    {
        return $this->getParameter('source_api');
    }

    public function setSourceApi($value)
    {
        return $this->setParameter('source_api', $value);
    }

    public function sendData($data)
    {
        $this->validate('transactionId', 'notification_id');

        if(strpos($this->getSourceApi(), "api.")>0)
            $this->setPaymentType("Boleto");
        if(strpos($this->getSourceApi(), "pix.")>0)
            $this->setPaymentType("Pix");

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
            'transaction_id' => $this->getTransactionID(),
            "notification_id" => $this->getNotificationID(),
        ];

        $httpResponse = $this->httpClient->request($method, $url, $headers, $this->toJSON($data));
        $json = $httpResponse->getBody()->getContents();
        $json = @json_decode($json, true);
        return $this->createResponse($json["status_request"]);
    }
}
