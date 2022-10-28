<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            //specification is not required
            $table->string('specification')->nullable(true);
            $table->string('quantity');
            //unit price is not required
            $table->string('unit_price')->nullable(true);
            //threshold quantity is not required
            $table->string('threshold_quantity')->nullable(true);
            $table->string('expiration_date')->nullable(true);
            $table->string('status');
            $table->string('created_by');
            $table->string('image');
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
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
        Schema::dropIfExists('articles');
    }
}
