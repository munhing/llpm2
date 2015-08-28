<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkordersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('workorders', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('workorder_no')->unsigned();
			$table->string('movement');
			$table->timestamp('date');
			$table->integer('carrier_id');
			$table->integer('handler_id');
			$table->integer('vessel_schedule_id');
			$table->integer('container_location');
			$table->integer('container_status');			
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
		Schema::drop('workorders');
	}

}
