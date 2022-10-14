<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockinDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockin_details', function (Blueprint $table) {
            $table->id();
            $table->string('quantity');
            $table->text('observation');
            $table->date('date');
            $table->string('bon_no');
            $table->string('unit_price');
            $table->string('total_value');
            $table->string('invoice_no')->nullable(true);
            $table->string('supplier')->nullable(true);
            $table->string('commande_no')->nullable(true);
            //bordereau d'expedition
            $table->string('waybill')->nullable(true);
            $table->string('created_by');
            //remettant
            $table->string('handingover');
            $table->string('origin')->nullable(true); 
            $table->string('country')->nullable(true); 
            $table->bigInteger('article_id')->unsigned();
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
        Schema::dropIfExists('stockin_details');
    }
}
