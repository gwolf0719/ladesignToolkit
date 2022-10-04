<?php

namespace App\Models;

use CodeIgniter\Model;

class ModCart extends Model
{

    function itemList()
    {
        // 從 session 中取得購物車資料
        if (isset($_SESSION['cart'])) {
            return $_SESSION['cart'];
        } else {
            return false;
        }
    }
    // 取得完整購物清單內容
    function getCart()
    {
        $cart = $this->itemList();
        if ($cart) {
            // 重設每個商品的小計
            foreach ($cart['items'] as $key => $item) {
                $cart['items'][$key]['subtotal'] = $item['product_price'] * $item['product_qty'];
            }
            // 重設總金額
            $cart['total'] = 0;
            foreach ($cart['items'] as $item) {
                $cart['total'] += $item['subtotal'];
            }
            return $cart;
        } else {
            return false;
        }
    }

    function chkItemInCart($product_id, $product_spec_id)
    {
        $cart = $this->itemList();
        foreach ($cart['items'] as $key => $item) {
            if ($item['product_id'] == $product_id && $item['product_spec_id'] == $product_spec_id) {
                return $key;
            }
        }
        return false;
    }

    // 設定購物車商品數量
    // $data = [
    //     'product_id' => 1,
    //     'product_spec_id' => 1,
    //     'product_qty' => 1
    // ];
    function setItem($data)
    {
        if (!isset($data['product_spec_id'])) {
            $data['product_spec_id'] = "";
        }
        $cart = $this->itemList();

        // 如果購物車不存在就直接添加 $data
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart']['items'][] = $data;
        }

        // 如果購物車中有相同商品就更新數量
        if ($this->chkItemInCart($data['product_id'], $data['product_spec_id']) !== false) {
            $key = $this->chkItemInCart($data['product_id'], $data['product_spec_id']);
            $cart['items'][$key] = $data;
            // 如果 product_qty 為 0 就刪除該商品
            if ($data['product_qty'] == 0) {
                unset($cart['items'][$key]);
            }
            $_SESSION['cart'] = $cart;
        } else {
            $key = uniqid();
            $cart['items'][$key] = $data;
        }
        return $this->itemList();
    }
}
