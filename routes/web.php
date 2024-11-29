<?php

use App\Http\Controllers\CsvController;
use App\Livewire\CrudPapeleta;
use App\Livewire\Estadisticas;
use App\Livewire\EstadisticasGrafico;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', [CsvController::class, 'index'])->name('index');
// Route::post('/import', [CsvController::class, 'import'])->name('import');
// Route::get('/export', [CsvController::class, 'export'])->name('export');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/estadisticas', Estadisticas::class)->name('estadisticas');

});

//'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');

//     Route::get('/monitoring', CrudMonitoring::class)->name('monitorings');
//     Route::get('/teacher', CrudTeacher::class)->name('teachers');
//     Route::get('/graduate', CrudGraduate::class)->name('graduates');
//     Route::get('/postulations',CrudPostulation::class)->name('postulations');
//     Route::get('/graduatet',CrudGraduatet::class)->name('graduatet');
//     Route::get('/monitoringdetail',CrudMonitoringdetail::class)->name('monitoringdetail');
//     Route::get('/joboffers',JobofferLivewire::class)->name('joboffers');
//     Route::get('/joboffersc',CrudJoboffer::class)->name('joboffersc');
// })->name('index');
// Route::get('joboffer/{joboffer}',[JobofferController::class, 'show'])->name('joboffers.show');
// Route::get('category/{category}',[JobofferController::class,'search'])->name('joboffers.search');


