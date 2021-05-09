<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('pages')) {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->string('title');
             $table->string('slug');
            $table->longText('description')->nullable();
            $table->string('banner')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_author')->nullable();
            $table->string('meta_viewport')->nullable();
           	//common
			$table->integer('is_active')->default(1);
           $table->integer('is_delete')->default(0);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });
		}
		if (!Schema::hasTable('page_elements')) {
		 Schema::create('page_elements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('page_id');
            $table->string('element_type')->nullable();
            $table->string('element_key')->nullable()	;
            $table->string('element_name')->nullable();
            $table->string('element_value')->nullable()	;
			$table->integer('is_active')->default(1);
			$table->integer('is_delete')->default(0);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();

            $table->foreign('page_id')->references('id')->on('pages');

        });
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
		Schema::dropIfExists('page_elements');
    }
}
