<?php

namespace Hlacos\Joboquent;

use Illuminate\Database\Eloquent\Model as Eloquent;

class JobStatus extends Eloquent {

    const PENDING   = "1";
    const STARTED   = "2";
    const EXITED    = "3";
    const ENDED     = "4";

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
