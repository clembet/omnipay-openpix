<?php

namespace Omnipay\OpenPIX;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\ItemBag;

/**
 * https://developers.openpix.com.br/
 * https://developers.openpix.com.br/api
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface acceptNotification(array $options = array())
 */

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'OpenPIX';
    }

    // pixKey, pixKeyType

    public function setClientID($value)
    {
        return $this->setParameter('clientID', $value);
    }

    public function getClientID()
    {
        return $this->getParameter('clientID');
    }

    public function setAppID($value)
    {
        return $this->setParameter('appID', $value);
    }

    public function getAppID()
    {
        return $this->getParameter('appID');
    }

    public function setExternalReference($value)
    {
        return $this->setParameter('external_reference', $value);
    }

    public function getExternalReference()
    {
        return $this->getParameter('external_reference');
    }

    public function parseResponse($data)
    {
        $request = $this->createRequest('\Omnipay\OpenPIX\Message\PurchaseRequest', []);
        return new \Omnipay\OpenPIX\Message\Response($request, (array)$data);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\OpenPIX\Message\PurchaseRequest', $parameters);
    }

    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\OpenPIX\Message\VoidRequest', $parameters);
    }

    public function fetchTransaction(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\OpenPIX\Message\FetchTransactionRequest', $parameters);
    }
    /*/public function acceptNotification(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\OpenPIX\Message\NotificationRequest', $parameters);
    }*/
}

?>
