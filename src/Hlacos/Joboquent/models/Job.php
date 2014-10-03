<?php

namespace Hlacos\Joboquent;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;

abstract class Job extends Eloquent {
    public $name = "Job";

    abstract public function work();

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'jobs';

    protected $data;

    // OOP methods
    public function __construct(array $attributes = array()) {
        $this->setRawAttributes(array('name' => $this->name), true);
        parent::__construct($attributes);
    }

    // Relations
    public function status() {
        return $this->belongsTo('Hlacos\Joboquent\JobStatus', 'status_id', 'id');
    }

    public function jobable() {
        return $this->morphTo();
    }

    // Job methods
    public function setPercent($percent) {
        $this->percent = $percent;
        $this->save();
    }

    public function start() {
        $this->status_id = JobStatus::STARTED;
        $this->start_at = date('Y-m-d H:i:s', time());
        $this->run_cycle++;
        $this->save();
    }

    public function pause() {
        $this->status_id = JobStatus::PAUSED;
        $this->save();
    }

    public function cancel() {
        $this->status_id = JobStatus::CANCELED;
        $this->end_at = date('Y-m-d H:i:s', time());
        $this->save();
    }

    public function error($message = '') {
        $this->status_id = JobStatus::EXITED;
        $this->status_message = $message;
        $this->end_at = date('Y-m-d H:i:s', time());
        $this->save();
    }

    public function end() {
        $this->status_id = JobStatus::ENDED;
        $this->percent = 100;
        $this->end_at = date('Y-m-d H:i:s', time());
        $this->save();
    }

    // Queue methods
    public function fire($job, $data) {
        try {
            DB::connection()->disableQueryLog();

            $this->data = $data;

            if (method_exists($this, 'beforeStart')) {
                $this->beforeStart();
            }
            $this->start();

            $this->work();

            if (method_exists($this, 'beforeEnd')) {
                $this->beforeEnd();
            }
            $this->end();

            $job->delete();
        } catch (Exception $e) {
            DB::connection()->enableQueryLog();
            $this->error($e->getMessage());
            //throw $e;
            $job->delete();
        }
        DB::connection()->enableQueryLog();
    }
}
