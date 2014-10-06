Joboquent
=========

Eloquent based Jobs for Laravel

It's under development, not recommended for production use!

# Install steps
1. composer install
2. php artisan migrate --bench="hlacos/joboquent"
3. php artisan db:seed --class="Hlacos\Joboquent\JobStatusTableSeeder"

# Usage

## Create new job and run it

Tipically it creates in the controller.

<pre>
$job = new JobModel;
$job->name = 'Export customers';
$job->save();

$job->run('MyJob');
</pre>

The string parameter of the run method is the class name of the Worker in the next step.

## Create worker
Extend Job to make your own working code
<pre>
use Hlacos\Joboquent\Job;

class MyJob extends Job {
    // Callbacks
    public function beforeStart() {}

    public function beforeEnd() {}

    // The working code
    public function work() {}
}
</pre>

### Callbacks

1. beforeStart: runs before the work method. You can initialize data or clean up database...
2. beforeEnd:   runs before the queue job deleted. You can touch related models timestamps or move created files to their public folder...

### Set the current percent

Tipically used in the work method in a cycle.

<pre>
$this->jobModel->setPercent($percent);
</pre>

## Related models

You can set polimorphic relation to the JobModel.

<pre>
public function jobs() {
    return $this->morphMany('Hlacos\Joboquent\JobModel', 'jobable');
}
</pre>

<pre>
public function job() {
    return $this->morphOne('Hlacos\Joboquent\JobModel', 'jobable');
}
</pre>

Don't forget to save related model to the jobModel before it runs.

# TODO

1. Refactoring / code cleaning.
2. JobModel pause and cancel methods is in development state.
