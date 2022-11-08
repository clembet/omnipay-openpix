<?php namespace Omnipay\OpenPIX\Message;

use Omnipay\Common\Message\AbstractResponse;

class Response extends AbstractResponse
{
    public function isSuccessful()
    {
        if((((int)@$this->data['http_code']*1)==201) && (strcmp(strtolower(@$this->data["result"]), "success")==0))
            return true;

        return false;
    }

    /**
     * Get the transaction reference.
     *
     * @return string|null
     */
    public function getTransactionID()
    {
        if(isset($this->data['transaction_id']))
            return @$this->data['transaction_id'];

        return NULL;
    }

    public function getTransactionAuthorizationCode()
    {
        if(isset($this->data['transaction_id']))
            return @$this->data['transaction_id'];

        return NULL;
    }

    public function getStatus()
    {
        $status = null;
        if(isset($this->data['status']))
            $status = @$this->data['status'];

        return $status;
    }

    public function isPaid()
    {
        $status = strtolower($this->getStatus());
        return (strcmp("paid", $status)==0);
    }

    public function isAuthorized()
    {
        return false;
    }

    public function isPending()
    {
        $status = strtolower($this->getStatus());
        return (strcmp("pending", $status)==0);
    }

    public function isVoided()
    {
        $status = strtolower($this->getStatus());
        return ((strcmp("canceled", $status)==0) || (strcmp("refunded", $status)==0));
    }

    /**
     * Get the error message from the response.
     *
     * Returns null if the request was successful.
     *
     * @return string|null
     */
    public function getMessage()
    {
        return @$this->data['http_code']." - ".@$this->data['response_message'];
    }

    public function getPix()
    {
        $data = $this->getData();
        $pix = array();
        $pix['pix_qrcodebase64image'] = "data:image/png;base64,".@$data['pix_code']['qrcode_base64'];
        $pix['pix_qrcodestring'] = @$data['pix_code']['emv'];
        $pix['pix_valor'] = ((double)@$data['value_cents']*1.0)/100.0;
        $pix['pix_transaction_id'] = @$data['transaction_id'];

        return $pix;
    }
}

?>
