Joboquent
=========

Eloquent based Jobs for Laravel

It's under development, not recommended for production use!

# Install steps
1. composer install
2. php artisan migrate --bench="hlacos/joboquent"
3. php artisan db:seed --class="Hlacos\Joboquent\JobStatusTableSeeder"
