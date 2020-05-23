<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PedidoPendiente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('estado');
            $table->string('order-id');
            $table->string('order-item-id');
            $table->date('purchase-date');
            $table->date('payments-date');
            $table->date('reporting-date');
            $table->date('promise-date');
            $table->string('days-past-promise');
            $table->string('buyer-email');
            $table->string('buyer-name');
            $table->string('buyer-phone-number');
            $table->string('sku');
            $table->string('product-name');
            $table->string('quantity-purchased');
            $table->string('quantity-shipped');
            $table->string('quantity-to-ship');
            $table->string('ship-service-level');
            $table->string('recipient-name');
            $table->string('ship-address-1');
            $table->string('ship-address-2');
            $table->string('ship-address-3');
            $table->string('ship-city');
            $table->string('ship-state');
            $table->string('ship-postal-code');
            $table->string('ship-country');
            $table->string('sales-channel');
            $table->string('is-business-order');
            $table->string('purchase-order-number');
            $table->string('price-designation');
            $table->string('is-sold-by-ab');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedido');
    }
}
