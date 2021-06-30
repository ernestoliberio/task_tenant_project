<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Tenant as BaseTenant;
use Illuminate\Support\Str;

class MultTenant extends BaseTenant
{
    use HasFactory;
    protected $guarded = [];

    public static function boot()
    {
        /* dd(Tenant::class); */
        static::creating(fn (MultTenant $tenant) => $tenant->createDatabase($tenant));
        static::created(fn (MultTenant $tenant) => $tenant->runMigrationsSeeders($tenant));
    }

    public function createDatabase($tenant)
    {
        $database_name = parse_url(config('app.url'), PHP_URL_HOST).'_'.Str::random(4);
        $database = Str::of($database_name)->replace('.', '_')->lower()->__toString();

        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?";
        $db = DB::select($query, [$database]);
        if (empty($db)) {
            DB::connection('tenant')->statement("CREATE DATABASE {$database};");
            $tenant->database = $database;
        }
        return $database;
    }
    public function runMigrationsSeeders($tenant)
    {
        $tenant->refresh();
        Artisan::call('tenants:artisan', [
            'artisanCommand' => 'migrate --database=tenant --seed --force',
            '--tenant' => "{$tenant->id}",
        ]);
    }
}

