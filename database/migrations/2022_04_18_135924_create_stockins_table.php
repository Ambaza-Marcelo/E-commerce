<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockins', function (Blueprint $table) {
            $table->id();
            $table->text('observation');
            $table->date('date');
            $table->string('bon_no');
            $table->string('invoice_no')->nullable(true);
            $table->string('commande_no')->nullable(true);
            $table->string('supplier')->nullable(true);
            $table->string('reception_no')->nullable(true);
            $table->string('waybill')->nullable(true);
            $table->string('created_by');
            //remettant
            $table->string('handingover');
            $table->string('origin')->nullable(true);
            $table->string('country')->nullable(true);  
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
        Schema::dropIfExists('stockins');
    }
}
