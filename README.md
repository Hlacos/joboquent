Joboquent
=========

Eloquent based Jobs for Laravel

It's under development, not recommended for production use!

# Install steps
1. composer install
2. php artisan migrate --bench="hlacos/joboquent"
3. php artisan db:seed --class="Hlacos\Joboquent\JobStatusTableSeeder"

# TODO

## Separate Job and worker

Reasons:
1. If something goes wrong when job fires, many job row creates in jobs table.
2. The pending state is missing.
