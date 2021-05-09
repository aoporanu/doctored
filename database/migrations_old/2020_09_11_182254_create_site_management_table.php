<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_management', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sitename');
            $table->string('favicon')->nullable();
            $table->string('logo_big')->nullable();
            $table->string('logo_small')->nullable();
            $table->string('banner')->nullable()	;
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_author')->nullable()	;
            $table->string('meta_viewport')->nullable();
            $table->string('coopyright')->nullable();
            $table->string('footerdescription')->nullable();
            $table->string('footer_social')->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('site_management');
    }
}
