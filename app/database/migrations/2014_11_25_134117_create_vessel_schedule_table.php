<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVesselScheduleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vessel_schedule', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('vessel_id');
			$table->integer('portuser_id');
			$table->string('voyage_no_arrival');
			$table->string('voyage_no_departure');
			$table->timestamp('eta');
			$table->timestamp('etd');
			$table->double('mt_arrival');
			$table->double('mt_departure');
			$table->double('m3_arrival');
			$table->double('m3_departure');
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
		Schema::drop('vessel_schedule');
	}

}
