<?php

namespace Hlacos\Joboquent;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Queue;

class JobModel extends Eloquent {

    public $name = "Job";

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'jobs';

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

    public function run($className) {
        Queue::push($className, $this);
    }

    public function start() {
        $this->status_id = JobStatus::STARTED;
        $this->start_at = date('Y-m-d H:i:s', time());
        $this->run_cycle++;
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
}
