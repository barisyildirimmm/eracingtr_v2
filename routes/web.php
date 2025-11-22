<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\f1\leagueController as f1LeagueController;
use App\Http\Controllers\driverController as driverController;

use App\Http\Controllers\adminPanel\authController as APauthController;
use App\Http\Controllers\adminPanel\dashboardController as APdashboardController;
use App\Http\Controllers\adminPanel\nextRaceStatsController as APnextRaceStatsController;
use App\Http\Controllers\adminPanel\driverController as APdriverController;

use App\Http\Controllers\adminPanel\leagues\leagueController as APleagueController;
use App\Http\Controllers\adminPanel\leagues\leagueTracksController as APleagueTracksController;
use App\Http\Controllers\adminPanel\leagues\leagueDriversController as APleagueDriversController;
use App\Http\Controllers\adminPanel\leagues\raceResultsController as APraceResultsController;
use App\Http\Controllers\adminPanel\leagues\refDecisionController as APrefDecisionController;

use App\Http\Controllers\adminPanel\teamController as APteamController;
use App\Http\Controllers\adminPanel\trackController as APtrackController;
use App\Http\Controllers\adminPanel\adminController as APadminController;
use App\Http\Controllers\adminPanel\configController as APconfigController;
use App\Http\Controllers\adminPanel\heroSliderController as APheroSliderController;
use App\Http\Controllers\adminPanel\socialMediaController as APsocialMediaController;

use App\Http\Controllers\adminPanel\postContentTemplatesController as APpostContentTemplatesController;

use App\Http\Controllers\driverPanel\authController as DPauthController;
use App\Http\Controllers\driverPanel\dashboardController as DPdashboardController;
use App\Http\Controllers\driverPanel\refDecisionController as DPrefDecisionController;
use App\Http\Controllers\driverPanel\profileController as DPprofileController;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DriverMiddleware;

use Illuminate\Support\Facades\Route;

// Dil değiştirme route'u
Route::post('change-locale', function (\Illuminate\Http\Request $request) {
    $locale = $request->input('locale');
    $supportedLocales = ['tr', 'en', 'de', 'fr', 'it', 'pt', 'es', 'az'];
    
    if (in_array($locale, $supportedLocales)) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
        
        return response()->json([
            'success' => true,
            'locale' => $locale,
            'message' => 'Language changed successfully'
        ]);
    }
    
    return response()->json([
        'success' => false,
        'message' => 'Invalid locale'
    ], 400);
})->name('change.locale');

Route::get('/', [dashboardController::class, 'index'])->name('home');

Route::get('istatistikler', [dashboardController::class, 'statistics'])->name('statistics');
Route::get('istatistikler/{trackId}', [dashboardController::class, 'statistics'])->name('statistics.track');

Route::get('kural-kitapcigi', [dashboardController::class, 'ruleBook'])->name('roolBook');
Route::get('takvim', [dashboardController::class, 'calendar'])->name('calendar');

Route::post('giris', [DPauthController::class, 'loginPost'])->name('DloginPost');
Route::post('register', [DPauthController::class, 'registerPost'])->name('DregisterPost');
Route::get('verify-email/{token}', [DPauthController::class, 'verifyMailGet'])->name('DverifyMailGet');
Route::post('sifremi-unuttum', [DPauthController::class, 'forgotPasswordPost'])->name('DforgotPasswordPost');
Route::post('sifre-sifirla', [DPauthController::class, 'resetPasswordPost'])->name('DresetPasswordPost');

Route::get('admin-giris', [APauthController::class, 'loginGet'])->name('AloginGet');
Route::post('loginPostA', [APauthController::class, 'loginPost'])->name('AloginPost');

Route::get('puan-tablosu-{leagueLink}', [f1LeagueController::class, 'pointTable'])->name('f1Leagues.pointTable');
Route::get('yaris-sonuclari-{leagueLink}/{trackId?}', [f1LeagueController::class, 'results'])->name('f1Leagues.results');
Route::get('hakem-kararlari-{leagueLink}/{trackId?}', [f1LeagueController::class, 'refDecisions'])->name('f1Leagues.refDecisions');
Route::get('canli-yayinlar-{leagueLink}', [f1LeagueController::class, 'liveBroadcasts'])->name('f1Leagues.liveBroadcasts');
Route::get('fikstur-{leagueLink}', [f1LeagueController::class, 'schedule'])->name('f1Leagues.schedule');
Route::get('gecmis-sezonlar', [f1LeagueController::class, 'pastSeasons'])->name('f1Leagues.pastSeasons');

Route::get('pilot-d/{driverSlug}', [driverController::class, 'show'])->name('driver.show');

Route::middleware([DriverMiddleware::class])->prefix('pilot')->group(function () {
    Route::post('/logout', [DPauthController::class, 'logout'])->name('Dlogout');
    Route::get('/', [DPdashboardController::class, 'index'])->name('Dhome');

    Route::get('/profil', [DPprofileController::class, 'index'])->name('driver.profile');
    Route::post('/profil-guncelle', [DPprofileController::class, 'update'])->name('driver.profile.update');
    Route::post('/email-dogrulama-gonder', [DPprofileController::class, 'resendVerificationEmail'])->name('driver.profile.resendVerification');

    Route::get('/sikayetlerim', [DPrefDecisionController::class, 'showComplaints'])->name('referee.decisions.complaints');
    Route::post('/sikayet-gonder', [DPrefDecisionController::class, 'postComplaint'])->name('driver.complaints.submit');
    Route::delete('/sikayet-sil/{id}', [DPrefDecisionController::class, 'deleteComplaint'])->name('driver.complaints.delete');

    Route::get('/savunmalarim', [DPrefDecisionController::class, 'showDefenses'])->name('referee.decisions.defenses');
    Route::post('/savunma-gonder', [DPrefDecisionController::class, 'postDefense'])->name('driver.defenses.submit');

    Route::get('/itirazlarim', [DPrefDecisionController::class, 'showAppeals'])->name('referee.decisions.appeals');
    Route::post('/itiraz-gonder', [DPrefDecisionController::class, 'postAppeal'])->name('driver.appeals.submit');
});

Route::middleware([AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/', [APdashboardController::class, 'index'])->name('Ahome');
    Route::get('/logout', [APauthController::class, 'logout'])->name('Alogout');
    Route::get('/gelecek-yaris-istatistikleri', [APnextRaceStatsController::class, 'index'])->name('admin.nextRaceStats');

    Route::get('pilot-listesi', [APdriverController::class, 'listDrivers'])->name('admin.drivers.list');
    Route::post('pilot-olustur', [APdriverController::class, 'createDriver'])->name('admin.drivers.create');
    Route::put('pilot-duzenle/{id}', [APdriverController::class, 'editDriver'])->name('admin.drivers.edit');
    Route::post('pilot-email-onayla/{id}', [APdriverController::class, 'verifyEmail'])->name('admin.drivers.verifyEmail');
    Route::post('pilot-telefon-onayla/{id}', [APdriverController::class, 'verifyPhone'])->name('admin.drivers.verifyPhone');

    Route::get('lig-listesi', [APleagueController::class, 'listLeagues'])->name('admin.leagues.list');
    Route::post('lig-olustur', [APleagueController::class, 'createLeague'])->name('admin.leagues.create');
    Route::put('lig-duzenle/{id}', [APleagueController::class, 'editLeague'])->name('admin.leagues.edit');

    Route::get('lig-pistleri/{league_id}', [APleagueTracksController::class, 'listLeaguesTracks'])->name('admin.leagues.leaguesTracks');
    Route::post('lig-pist-ekle', [APleagueTracksController::class, 'createLeagueTrack'])->name('admin.leagues.createLeagueTrack');
    Route::post('lig-pist-duzenle', [APleagueTracksController::class, 'editLeagueTrack'])->name('admin.leagues.editLeagueTrack');
    Route::post('lig-pist-sil', [APleagueTracksController::class, 'deleteLeagueTrack'])->name('admin.leagues.deleteLeagueTrack');
    
    Route::get('lig-yaris-videolari/{league_id}', [APleagueTracksController::class, 'listRaceVideos'])->name('admin.leagues.raceVideos');
    Route::post('lig-yaris-video-guncelle', [APleagueTracksController::class, 'updateRaceVideo'])->name('admin.leagues.updateRaceVideo');

    Route::get('lig-pilotlari/{league_id}', [APleagueDriversController::class, 'listLeagueDrivers'])->name('admin.leagues.leagueDrivers');
    Route::post('lig-pilot-ekle', [APleagueDriversController::class, 'addDriversToLeague'])->name('admin.leagues.addDriversToLeague');
    Route::post('lig-pilot-cikar', [APleagueDriversController::class, 'removeDriversFromLeague'])->name('admin.leagues.removeDriversFromLeague');
    Route::post('lig-pilot-takim-guncelle', [APleagueDriversController::class, 'updateDriverTeam'])->name('admin.leagues.updateDriverTeam');

    Route::get('lig-secmeleri/{league_id}', [APleagueController::class, 'listTryouts'])->name('admin.leagues.tryouts');
    Route::post('lig-secme-sonucu-kaydet', [APleagueController::class, 'saveTryoutResult'])->name('admin.leagues.saveTryoutResult');
    Route::post('lig-secme-sonucu-guncelle', [APleagueController::class, 'updateTryoutResult'])->name('admin.leagues.updateTryoutResult');

    Route::get('lig-hakem-kararlari/{league_id}', [APrefDecisionController::class, 'listRefDecisions'])->name('admin.leagues.refDecisions');
    Route::get('lig-hakem-kararlari/{league_id}/yaris/{track_id}', [APrefDecisionController::class, 'showTrackDecisions'])->name('admin.leagues.refDecisions.track');
    Route::post('lig-hakem-karar-detay-guncelle', [APrefDecisionController::class, 'updateDecisionDetail'])->name('admin.leagues.updateDecisionDetail');
    
    Route::get('cezalar', [APrefDecisionController::class, 'listPenalties'])->name('admin.penalties.list');
    Route::post('ceza-olustur', [APrefDecisionController::class, 'createPenalty'])->name('admin.penalties.create');
    Route::put('ceza-duzenle/{id}', [APrefDecisionController::class, 'updatePenalty'])->name('admin.penalties.update');
    Route::delete('ceza-sil/{id}', [APrefDecisionController::class, 'deletePenalty'])->name('admin.penalties.delete');
    
    Route::get('ceza-aciklamalari', [APrefDecisionController::class, 'listPenaltyDescs'])->name('admin.penaltyDescs.list');
    Route::post('ceza-aciklamasi-olustur', [APrefDecisionController::class, 'createPenaltyDesc'])->name('admin.penaltyDescs.create');
    Route::put('ceza-aciklamasi-duzenle/{id}', [APrefDecisionController::class, 'updatePenaltyDesc'])->name('admin.penaltyDescs.update');
    Route::delete('ceza-aciklamasi-sil/{id}', [APrefDecisionController::class, 'deletePenaltyDesc'])->name('admin.penaltyDescs.delete');

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
    
    Route::get('hero-slider', [APheroSliderController::class, 'index'])->name('admin.heroSlider.index');
    Route::post('hero-slider', [APheroSliderController::class, 'store'])->name('admin.heroSlider.store');
    Route::delete('hero-slider/{id}', [APheroSliderController::class, 'destroy'])->name('admin.heroSlider.destroy');
    Route::post('hero-slider/update-order', [APheroSliderController::class, 'updateOrder'])->name('admin.heroSlider.updateOrder');
    
    Route::get('sosyal-medya', [APsocialMediaController::class, 'index'])->name('admin.socialMedia.index');
    Route::get('sosyal-medya/olustur', [APsocialMediaController::class, 'create'])->name('admin.socialMedia.create');
    Route::post('sosyal-medya', [APsocialMediaController::class, 'store'])->name('admin.socialMedia.store');
    Route::get('sosyal-medya/duzenle/{id}', [APsocialMediaController::class, 'edit'])->name('admin.socialMedia.edit');
    Route::put('sosyal-medya/{id}', [APsocialMediaController::class, 'update'])->name('admin.socialMedia.update');
    Route::delete('sosyal-medya/{id}', [APsocialMediaController::class, 'destroy'])->name('admin.socialMedia.destroy');
    Route::post('sosyal-medya/paylas/{id}', [APsocialMediaController::class, 'publishNow'])->name('admin.socialMedia.publishNow');
});
