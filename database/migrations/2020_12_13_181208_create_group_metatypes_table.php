<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupMetatypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		 if (!Schema::hasTable('group_metatypes')) {
			Schema::create('group_metatypes', function (Blueprint $table) {
            $table->bigIncrements('gmeta_id');
			$table->string('gmetaname');
			$table->string('gmetakey');
			$table->string('gmeta_lang_code')->nullable();
			$table->string('gmeta_icon')->nullable();
			$table->integer('is_active')->default(0);
           	$table->integer('is_delete')->default(0)->nullable();
            $table->timestamps();
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
     //   Schema::dropIfExists('group_metatypes');
    }
}
