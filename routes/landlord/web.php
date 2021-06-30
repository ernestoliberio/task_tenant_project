<?php

use App\Models\MultTenant;
/* use Spatie\Multitenancy\Models\Tenant; */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/* use App\Http\Controllers\TenantController; */

Route::get('/clearall', function () {
    Artisan::call('cache:clear');
    echo '<script>alert("cache clear Success")</script>';
    Artisan::call('config:cache');
    echo '<script>alert("config cache Success")</script>';
    Artisan::call('view:clear');
    echo '<script>alert("view clear Success")</script>';
    Artisan::call('route:cache');
    echo '<script>alert("route clear Success")</script>';
});

Route::view('/', 'landlord.register')->name('landlord.register');
/* Route::post('/', function(Request $request){
    $tenant1 = Tenant::create(['name' => $request->name]);
    $tenant1->domains()->create(['domain' => $request->domain]);
}); */

Route::post('/', function(Request $request){
    /* $tenant=new MultTenant(); */
    dd(new MultTenant());
  //  \App\Models\Tenant::create($request->only(['name','domain']));
})->name('lr');
/* Route::post('/newtenant', [TenantController::class, "store"])->name('newtenant'); */