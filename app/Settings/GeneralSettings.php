<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;

    public string $admin_email;

    public static function group(): string
    {
        return 'general';
    }
}
