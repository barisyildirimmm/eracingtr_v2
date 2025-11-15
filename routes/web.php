<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\f1\leagueController as f1LeagueController;

use App\Http\Controllers\adminPanel\authController as APauthController;
use App\Http\Controllers\adminPanel\dashboardController as APdashboardController;
use App\Http\Controllers\adminPanel\driverController as APdriverController;

use App\Http\Controllers\adminPanel\leagues\leagueController as APleagueController;
use App\Http\Controllers\adminPanel\leagues\raceResultsController as APraceResultsController;

use App\Http\Controllers\adminPanel\teamController as APteamController;
use App\Http\Controllers\adminPanel\trackController as APtrackController;
use App\Http\Controllers\adminPanel\adminController as APadminController;
use App\Http\Controllers\adminPanel\configController as APconfigController;

use App\Http\Controllers\adminPanel\postContentTemplatesController as APpostContentTemplatesController;

use App\Http\Controllers\driverPanel\authController as DPauthController;
use App\Http\Controllers\driverPanel\dashboardController as DPdashboardController;
use App\Http\Controllers\driverPanel\refDecisionController as DPrefDecisionController;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DriverMiddleware;

use Illuminate\Support\Facades\Route;

Route::get('/', [dashboardController::class, 'index'])->name('home');

Route::get('kural-kitapcigi', [dashboardController::class, 'ruleBook'])->name('roolBook');

Route::post('giris', [DPauthController::class, 'loginPost'])->name('DloginPost');
Route::post('register', [DPauthController::class, 'registerPost'])->name('DregisterPost');
Route::get('verify-email/{token}', [DPauthController::class, 'verifyMailGet'])->name('DverifyMailGet');

Route::get('admin-giris', [APauthController::class, 'loginGet'])->name('AloginGet');
Route::post('loginPostA', [APauthController::class, 'loginPost'])->name('AloginPost');

Route::get('puan-tablosu-{leagueLink}', [f1LeagueController::class, 'pointTable'])->name('f1Leagues.pointTable');
Route::get('yaris-sonuclari-{leagueLink}/{trackId?}', [f1LeagueController::class, 'results'])->name('f1Leagues.results');
Route::get('hakem-kararlari-{leagueLink}', [f1LeagueController::class, 'refDecisions'])->name('f1Leagues.refDecisions');
Route::get('canli-yayinlar-{leagueLink}', [f1LeagueController::class, 'liveBroadcasts'])->name('f1Leagues.liveBroadcasts');
Route::get('fikstur-{leagueLink}', [f1LeagueController::class, 'schedule'])->name('f1Leagues.schedule');



Route::middleware([DriverMiddleware::class])->prefix('pilot')->group(function () {
    Route::get('/logout', [DPauthController::class, 'logout'])->name('Dlogout');
    Route::get('/', [DPdashboardController::class, 'index'])->name('Dhome');

    Route::get('/sikayetlerim', [DPrefDecisionController::class, 'showComplaints'])->name('referee.decisions.complaints');
    Route::post('/sikayet-gonder', [DPrefDecisionController::class, 'postComplaint'])->name('driver.complaints.submit');
    Route::delete('/sikayet-sil/{id}', [App\Http\Controllers\driverPanel\refDecisionController::class, 'deleteComplaint'])->name('driver.complaints.delete');

    Route::get('/savunmalarim', [DPrefDecisionController::class, 'showDefenses'])->name('referee.decisions.defenses');
    Route::post('/savunma-gonder', [DPrefDecisionController::class, 'postDefense'])->name('driver.defenses.submit');

    Route::get('/itirazlarim', [DPrefDecisionController::class, 'showAppeals'])->name('referee.decisions.appeals');
    Route::post('/itiraz-gonder', [DPrefDecisionController::class, 'postAppeal'])->name('driver.appeals.submit');
});

Route::middleware([AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/', [APdashboardController::class, 'index'])->name('Ahome');
    Route::get('/logout', [APauthController::class, 'logout'])->name('Alogout');

    Route::get('pilot-listesi', [APdriverController::class, 'listDrivers'])->name('admin.drivers.list');
    Route::post('pilot-olustur', [APdriverController::class, 'createDriver'])->name('admin.drivers.create');
    Route::put('pilot-duzenle/{id}', [APdriverController::class, 'editDriver'])->name('admin.drivers.edit');

    Route::get('lig-listesi', [APleagueController::class, 'listLeagues'])->name('admin.leagues.list');
    Route::post('lig-olustur', [APleagueController::class, 'createLeague'])->name('admin.leagues.create');
    Route::put('lig-duzenle/{id}', [APleagueController::class, 'editLeague'])->name('admin.leagues.edit');

    Route::get('ligler-yaris-sonuclari/{league_id}/{track_id?}', [APraceResultsController::class, 'listRaceResult'])->name('admin.leagues.raceResults');
    Route::post('ligler-yaris-sonuc-guncelle', [APraceResultsController::class, 'updateRaceResults'])->name('admin.leagues.updateRaceResults');

    Route::get('takim-listesi', [APteamController::class, 'listTeams'])->name('admin.teams.list');
    Route::post('takim-olustur', [APteamController::class, 'createTeam'])->name('admin.teams.create');
    Route::put('takim-duzenle/{id}', [APteamController::class, 'editTeam'])->name('admin.teams.edit');

    Route::get('pist-listesi', [APtrackController::class, 'listTracks'])->name('admin.tracks.list');
    Route::post('pist-olustur', [APtrackController::class, 'createTrack'])->name('admin.tracks.create');
    Route::put('pist-duzenle/{id}', [APtrackController::class, 'editTrack'])->name('admin.tracks.edit');

    Route::get('admin-listesi', [APadminController::class, 'listAdmins'])->name('admin.admins.list');
    Route::post('admin-olustur', [APadminController::class, 'createAdmin'])->name('admin.admins.create');
    Route::put('admin-duzenle/{id}', [APadminController::class, 'editAdmin'])->name('admin.admins.edit');

    Route::get('hazir-paylasimlar', [APpostContentTemplatesController::class, 'listPostContents'])->name('admin.postContents.list');
    Route::get('hazir-paylasimlar/img-proxy', [APpostContentTemplatesController::class, 'imgProxy'])->name('admin.postContents.imgProxy');
    Route::get('hazir-paylasimlar/pole-gorseli', [APpostContentTemplatesController::class, 'poleGorseli'])->name('admin.postContents.pole');
    Route::get('hazir-paylasimlar/podium-gorseli', [APpostContentTemplatesController::class, 'podiumGorseli'])->name('admin.postContents.podium');
    Route::get('hazir-paylasimlar/kazanan-gorseli', [APpostContentTemplatesController::class, 'kazananGorseli'])->name('admin.postContents.winner');
    Route::get('hazir-paylasimlar/puan-tablosu-gorseli', [APpostContentTemplatesController::class, 'puanTablosuGorseli'])->name('admin.postContents.standings');

    Route::get('sosyal-medya-post-update', [APconfigController::class, 'socialMediaPostUpdate'])->name('admin.config.socialMediaPostUpdate');
});
