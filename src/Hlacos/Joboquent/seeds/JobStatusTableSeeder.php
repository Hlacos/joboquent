<?php

namespace Hlacos\Joboquent;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobStatusTableSeeder extends Seeder {

    public function run() {
        DB::table('job_statuses')->truncate();

        $jobStatus = new JobStatus;
        $jobStatus->id = JobStatus::PENDING;
        $jobStatus->name = "pending";
        $jobStatus->save();

        $jobStatus = new JobStatus;
        $jobStatus->id = JobStatus::STARTED;
        $jobStatus->name = "started";
        $jobStatus->save();

        $jobStatus = new JobStatus;
        $jobStatus->id = JobStatus::EXITED;
        $jobStatus->name = "exited";
        $jobStatus->save();

        $jobStatus = new JobStatus;
        $jobStatus->id = JobStatus::ENDED;
        $jobStatus->name = "ended";
        $jobStatus->save();
    }

}
