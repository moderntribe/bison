<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'Bison');
        $this->migrator->add('general.admin_email', 'vendors@tri.be');
    }
};
