<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_elements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('page_id')->unsigned();
            $table->string('element_type')->nullable();
            $table->string('element_key')->nullable()	;
            $table->string('element_name')->nullable();
            $table->string('element_value')->nullable()	;
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
            $table->foreign('page_id')->references('id')->on('pages');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_elements');
    }
}
