<?php

namespace Omnipay\OpenPIX\Message;

class PurchaseRequest extends AbstractRequest
{
    protected $resource = 'charge';
    protected $requestMethod = 'POST';

    public function getItemData()
    {
        $data = [];
        $items = $this->getItems();

        if ($items) {
            foreach ($items as $n => $item) {

                $item_array = [];
                $item_array['title'] = $item->getName();
                $item_array['description'] = $item->getDescription();
//                $item_array['category_id'] = $item->getCategoryId();
                $item_array['quantity'] = (int)$item->getQuantity();
                $item_array['currency_id'] = $this->getCurrency();
                $item_array['unit_price'] = (double)($this->formatCurrency($item->getPrice()));

                array_push($data, $item_array);
            }
        }

        return $data;
    }

    public function getData()
    {
        $this->validate("items", "customer", "order_id", "amount", "due_days", "shipping_price", "currency");
        $items = $this->getItemData();
        $customer = $this->getCustomer();
        $items_data = $this->getItems();

        $itemsArr = array();
        if($items_data && (count($items_data) > 0))foreach($items_data as $item)
        {
            $itemsArr[] = array('description'=>$item->getName(),
                'quantity'=>$item->getQuantity(),
                'price_cents'=>(int)round(((double)$item->getPrice()*100.0), 0),
                'item_id' => '1');//utilizar o código 1, caso não queira usar o sku do produto
        }

        $data = [
            'correlationID' => $this->getOrderId(), // código interno do lojista para identificar a transacao.
            'value' => (int)(($this->getAmount()+$this->getShippingPrice())*100.0), // em centavos
            'comment'=> '',
            'customer' => [
                "name"=> $customer->getName(), // nome completo ou razao social
                "email"=> $customer->getEmail(),
                "phone"=> $customer->getPhone(), // fixou ou móvel
                "taxID"=> $customer->getDocumentNumber(), // cpf ou cnpj
            ]
        ];

        return $data;
    }
}

?>
