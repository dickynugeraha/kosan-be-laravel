<?php

namespace App\Services\CreateSnapTokenService;

use App\Services\Midtrans\Midtrans;
use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
  protected $order;

  public function __construct($order)
  {
    parent::__construct();

    $this->order = $order;
  }

  public function getSnapToken()
  {
    $params = [
      "transaction_details" => [
        "order_id" => $this->order->id,
        "gross_amount" => $this->order->total_price,
      ],
      "customer_details" => [
        "id" => $this->order->user->id,
        "name" => $this->order->user->name,
        "email" => $this->order->user->email,
        "phone" => $this->order->user->phone,
      ]
    ];

    $snapToken = Snap::getSnapToken($params);

    return $snapToken;
  }
}
