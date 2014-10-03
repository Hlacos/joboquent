<?php

namespace Hlacos\Joboquent;

use Illuminate\Database\Eloquent\Model as Eloquent;

class JobStatus extends Eloquent {

    const PENDING   = "1";
    const STARTED   = "2";
    const PAUSED    = "3";
    const CANCELED  = "4";
    const EXITED    = "5";
    const ENDED     = "6";

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_statuses';

    public $timestamps = false;

    public function jobs() {
        return $this->hasMany('Job', 'status_id', 'id');
    }
}
