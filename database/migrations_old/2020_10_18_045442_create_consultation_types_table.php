<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultation_types', function (Blueprint $table) {
            $table->bigIncrements('ctype_id');
			$table->string('ctype_name');
			$table->string('ctype_icon')->nullable();
			$table->string('ctype_descrption')->nullable();
			$table->integer('is_deleted')->default(0);
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
        Schema::dropIfExists('consultation_types');
    }
}
