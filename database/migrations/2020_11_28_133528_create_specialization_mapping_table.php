<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecializationMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          if (!Schema::hasTable('specialization_mapping')) {
            Schema::create('specialization_mapping', function (Blueprint $table) {
                $table->bigIncrements('specialization_mapping_id');
    //            $table->integer('mapping_id');
                $table->string('mapping_type');
                $table->integer('mapping_type_id');
                $table->integer('specialization_id');
				$table->integer('is_active')->default(1);
                $table->integer('created_by')->default(0);
                $table->integer('updated_by')->default(0);
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
       // Schema::dropIfExists('specialization_mapping');
    }
}
