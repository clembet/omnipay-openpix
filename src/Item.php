<?php

namespace Omnipay\OpenPIX;

use Omnipay\Common\Item as BaseItem;

class Item extends BaseItem
{
    public function getCategoryId()
    {
        return $this->getParameter('category_id');
    }

    public function setCategoryId($value)
    {
        return $this->setParameter('category_id', $value);
    }

    public function getCurrencyId()
    {
        return $this->getParameter('currency_id');
    }

    public function setCurrencyId($value)
    {
        return $this->setParameter('currency_id', $value);
    }
}

?>
