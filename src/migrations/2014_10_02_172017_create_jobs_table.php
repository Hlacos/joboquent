<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration {

	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up() {
		Schema::create('jobs', function($table) {
			$table->increments('id');
			$table->string('name');
			$table->string('jobable_type')->nullable();
			$table->integer('jobable_id')->nullable();
			$table->integer('percent')->default(0);
			$table->text('status_message')->nullable();
			$table->integer('status_id')->default(Hlacos\Joboquent\JobStatus::PENDING);
			$table->timestamp('start_at')->nullable();
			$table->timestamp('end_at')->nullable();
			$table->text('data')->nullable();
			$table->integer('run_cycle')->default(0);

			$table->timestamp('created_at')->nullable();
			$table->timestamp('updated_at')->nullable();
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down() {
		Schema::drop('jobs');
	}

}
