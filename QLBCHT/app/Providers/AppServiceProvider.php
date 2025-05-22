<?php

namespace App\Providers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Models\EmailSetting;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        if (Schema::hasTable('email_settings')) {
            $setting = EmailSetting::first();
            if ($setting) {
                Config::set('mail.mailers.smtp.username', $setting->username);
                Config::set('mail.mailers.smtp.password', $setting->password);
                Config::set('mail.from.address', $setting->from_address);
                Config::set('mail.from.name', $setting->from_name);
            }
        }
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    }
}
