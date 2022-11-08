<?php

namespace Omnipay\OpenPIX;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()//TODO: refazer
    {
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $item = new Item();
        $item->setName("PurchaseTest");
        $item->setCategoryId("tickets");
        $item->setQuantity(1);
        $item->setCurrencyId("BRL");
        $item->setPrice(10.0);
        $this->items = array("items" => [$item]);
    }

    public function testPurchase()//TODO: refazer
    {
        $response = $this->gateway->purchase($this->items)->send();
        $data = $response->getData();
        $this->assertInstanceOf('\Omnipay\OpenPIX\Message\PurchaseResponse', $response);
        $this->assertTrue($data['init_point'] != null);
    }
}

?>
