<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('commande_no');
            $table->string('name');
            $table->bigInteger('article_id')->unsigned();
            $table->string('status')->default('1');
            $table->string('mode_paiement')->nullable(true);
            $table->string('date_expiration')->nullable(true);
            $table->string('email')->nullable(true);
            $table->string('code_pin')->nullable(true);
            $table->string('telephone')->nullable(true);
            $table->string('numero_compte')->nullable(true);
            $table->string('code_transaction')->nullable(true);
            $table->foreign('article_id')
                    ->references('id')
                    ->on('articles')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}
