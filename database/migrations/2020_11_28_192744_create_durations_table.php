<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('durations')) {
        Schema::create('durations', function (Blueprint $table) {
            $table->bigIncrements('id');
			 $table->string('shift')->nullable();
			$table->time('s_start', 0);	
			$table->time('s_end', 0);	
			$table->integer('is_active')->default(1);
			$table->integer('is_lock')->default(0);
			$table->integer('is_delete')->default(0);
			 $table->integer('last_modifiedby')->default(0);
		      $table->timestamps();
        });
		$data = [
				['shift'=>'Morning',
				's_start'=>'09:00:00',
				's_end'=>'12:00:00',
				'is_lock'=>1
				],
				['shift'=>'Afternoon',
				's_start'=>'12:00:00',
				's_end'=>'17:00:00',
				'is_lock'=>1
				],
				['shift'=>'Evening',
				's_start'=>'17:00:00',
				's_end'=>'21:00:00',
				'is_lock'=>1
				]
				
				
                
              ];
            DB::table('durations')->insert($data);
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
   //     Schema::dropIfExists('durations');
    }
}
