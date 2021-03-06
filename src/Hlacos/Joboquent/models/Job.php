<?php

namespace Hlacos\Joboquent;

use Illuminate\Support\Facades\DB;

abstract class Job {

    abstract public function work();

    protected $data;
    protected $jobModel;

    public $jobModelClass = 'Hlacos\Joboquent\JobModel';

    // Queue methods
    public function fire($job, $data) {
        try {
            DB::connection()->disableQueryLog();

            $class = $this->jobModelClass;
            $this->jobModel = $class::find($data['id']);

            if (method_exists($this, 'beforeStart')) {
                $this->beforeStart();
            }
            $this->jobModel->start();

            $this->work();

            if (method_exists($this, 'beforeEnd')) {
                $this->beforeEnd();
            }
            $this->jobModel->end();

            $job->delete();
        } catch (\Exception $e) {
            DB::connection()->enableQueryLog();
            $this->jobModel->error($e->getMessage());
            $job->delete();
        }
        DB::connection()->enableQueryLog();
    }
}
