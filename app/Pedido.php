<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'order-id',
        'order-item-id',
        'purchase-date',
        'payments-date',
        'reporting-date',
        'promise-date',
        'days-past-promise',
        'buyer-email	buyer-name',
        'buyer-phone-number',
        'sku',
        'product-name',
        'quantity-purchased',
        'quantity-shipped',
        'quantity-to-ship',
        'ship-service-level',
        'recipient-name',
        'ship-address-1',
        'ship-address-2',
        'ship-address-3',
        'ship-city',
        'ship-state',
        'ship-postal-code',
        'ship-country',
        'sales-channel',
        'is-business-order',
        'purchase-order-number',
        'price-designation',
        'is-sold-by-ab',
    ];

    protected $table = 'pedido';
}
