<?php

use App\Http\Controllers\AccountabilitiesController;
use App\Http\Controllers\CusRRController;
use App\Http\Controllers\custodianFEAController;
use App\Http\Controllers\custodianRRController;
use App\Http\Controllers\FeaController;
use App\Http\Controllers\InventoriesController;
use App\Http\Controllers\Inventory;
use App\Http\Controllers\propertyFeaController;
use App\Http\Controllers\propertyQRController;
use App\Http\Controllers\Receivingreports;
use App\Http\Controllers\ReceivingreportsLogs;
use App\Http\Controllers\Records;
use App\Http\Controllers\RrController;
use App\Http\Controllers\ItemDisposalController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\ReceivingreportController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TransferFurnitureController;
use App\Http\Controllers\warehouseRRController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/records/logs');
    } else {
        return view('welcome');
    }
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    //Setting
    Route::get('/setting', function () {
        return view('profile.setting');
    });


    //RECORDS
    Route::get('/records/{id}', [Records::class, 'show']);

    //PDF
    Route::get('/generate-fea/{id}', [FeaController::class, 'pdf'])->name('p.createpdffea');
    Route::get('/export-itemdisposal/{id}', [ItemDisposalController::class, 'pdf'])->name('p.pdfsid');
    Route::get('/export-rtf/{id}', [TransferFurnitureController::class, 'pdf'])->name('p.pdfsrtf');
    Route::get('/export-inv/{id}', [InventoriesController::class, 'pdf'])->name('p.pdfinv');
    Route::get('/export-report/{id}', [ReportsController::class, 'pdf'])->name('p.pdfreport');


    //Property
    Route::group(['middleware' => 'role:Property'], function () {

        //Accountabilities
        Route::get('/accountabilities', [AccountabilitiesController::class, 'property'])->name('p.acc');
        Route::get('/accountabilities/{id}', [AccountabilitiesController::class, 'property_data'])->name('p.acc_data');

        //FEA 
        Route::get('/fea/{id}', [FeaController::class, 'status'])->name('p.statusfea');
        Route::get('/fea/sign/{id}', [FeaController::class, 'transaction'])->name('p.signfea');
        Route::get('/create/fea/{id}', [FeaController::class, 'create'])->name('p.createfea');

        //QR
        Route::get('/generatefeaqr/{id}', [QrController::class, 'fea'])->name('p.qrfea');
        Route::get('/generate/qrretagging/{id}', [QrController::class, 'transaction'])->name('p.qrgen');
        Route::get('/qrretagging/{id}', [QrController::class, 'logs'])->name('p.qrlogs');
        Route::get('/qrretagging/printing/{id}', [QrController::class, 'printing'])->name('p.qrprint');
        Route::get('/downloadRequest/{id}', [QrController::class, 'QRpdf'])->name('p.qrred');

        //Item Disposal
        Route::get('/p/itemdisposal/sign/{id}', [ItemDisposalController::class, 'sign_p'])->name('p.signid');
        Route::get('/p/itemdisposal/post/{id}', [ItemDisposalController::class, 'post'])->name('p.postid');
        Route::get('/p/itemdisposal/{id}', [ItemDisposalController::class, 'status_p'])->name('p.statusid');

        //Inventories
        Route::get('/create/inventories', [InventoriesController::class, 'create'])->name('p.invcreate');
        Route::get('/inventories/{id}', [InventoriesController::class, 'logs'])->name('p.invlogs');
        Route::get('/inventories/monitor/{id}', [InventoriesController::class, 'monitor'])->name('p.monitor');


        //rtf
        Route::get('/rtf/sign/{id}', [TransferFurnitureController::class, 'sign_p'])->name('p.signrtf');
        Route::get('/rtf/{id}', [TransferFurnitureController::class, 'status_p'])->name('p.statusrtf');
        Route::get('/rtf/post/{id}', [TransferFurnitureController::class, 'post'])->name('p.postrtf');


        //Reports
        Route::get('/generate/reports', [ReportsController::class, 'generate'])->name('p.genreports');
        Route::get('/reports/{id}', [ReportsController::class, 'logs'])->name('p.reportslog');
    });


    //Custodian
    Route::group(['middleware' => 'role:Custodian'], function () {

        //Accountabilities
        Route::get('/myaccountabilities', [AccountabilitiesController::class, 'custodian'])->name('c.acc');
        Route::get('/myaccountabilities/{id}', [AccountabilitiesController::class, 'custodian_data'])->name('c.acc_data');

        //RR
        Route::get('/c/receivingreport/sign/{id}', [ReceivingreportController::class, 'sign_c'])->name('c.signrr');
        Route::get('/c/receivingreport/{rrnum}', [ReceivingreportController::class, 'status_c'])->name('c.statusrr');
        Route::get('/c/export-receivingreport/{rrnum}', [ReceivingreportController::class, 'pdf'])->name('c.exportpdf');


        //FEA
        Route::get('/c/fea/{id}', [FeaController::class, 'status_c'])->name('c.statusfea');
        Route::get('/c/fea/sign/{id}', [FeaController::class, 'transaction_c'])->name('c.signfea');


        //QR
        Route::get('/create/qrretagging', [QrController::class, 'create'])->name('c.qrcreate');
        Route::get('/c/qrretagging/{id}', [QrController::class, 'status_c'])->name('c.qr_status');


        //Item Disposal
        Route::get('/c/itemdisposal/{id}', [ItemDisposalController::class, 'status_c'])->name('c.statusid');
        Route::get('/create/itemdisposal', [ItemDisposalController::class, 'create'])->name('c.createid');

        //RFT
        Route::get('/create/rtf', [TransferFurnitureController::class, 'create'])->name('c.creatertf');
        Route::get('/c/rtf/sign/{id}', [TransferFurnitureController::class, 'sign_c'])->name('c.signrtf');
        Route::get('/c/rtf/{id}', [TransferFurnitureController::class, 'status_c'])->name('c.statusrtf');
        Route::get('/rtf/received/{id}', [TransferFurnitureController::class, 'received'])->name('c.receivedrtf');

        //Inventory
        Route::get('/c/inventories/{id}', [InventoriesController::class, 'custodian'])->name('c.invlogs');
    });


    //FINANCE
    Route::group(['middleware' => 'role:Finance'], function () {
        //Item Disposal
        Route::get('/f/itemdisposal/sign/{id}', [ItemDisposalController::class, 'sign_f'])->name('f.signid');
        Route::get('/f/itemdisposal/{id}', [ItemDisposalController::class, 'status_f'])->name('f.statusid');

        //RFT
        Route::get('/f/rtf/sign/{id}', [TransferFurnitureController::class, 'sign_f'])->name('f.signrtf');
        Route::get('/f/rtf/{id}', [TransferFurnitureController::class, 'status_f'])->name('f.statusrtf');
    });

    //Warehouse
    Route::group(['middleware' => 'role:Warehouse'], function () {
        //RR
        Route::get('/receivingreport/sign/{id}', [ReceivingreportController::class, 'transaction'])->name('w.signrr');
        Route::get('/receivingreport/{rrnum}', [ReceivingreportController::class, 'status'])->name('w.statusrr');
        Route::get('/create/receivingreport', [ReceivingreportController::class, 'create'])->name('w.createrr');
        Route::get('/export-receivingreport/{rrnum}', [ReceivingreportController::class, 'pdf'])->name('w.exportpdf');

        //Item Disposal
        Route::get('/itemdisposal/sign/{id}', [ItemDisposalController::class, 'sign_w'])->name('w.signid');
        Route::get('/itemdisposal/{id}', [ItemDisposalController::class, 'status_w'])->name('w.statusid');
    }); //end of W


});//end
