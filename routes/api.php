<?php

use Illuminate\Http\Request;
use App\NursingProfile;
use App\HospitalProfile;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::Ma('/user', function (Request $request) {
//     $user = $request->user();
//    return $request;
// })->middleware('auth:api');

Route::middleware('auth:api')->get('/user','UserController@checkuser');
Route::middleware('auth:api')->get('/getprofile/{proid}/{type}','UserController@checkprofile');

Route::prefix('auth')->group(function () {
    Route::post('register', 'registerController@store');
    Route::get('getCities','registerController@getCities');
    Route::get('township','registerController@getTownship');
    Route::get('getTypes','registerController@getTypes');
    Route::post('login', 'AuthController@login');
    Route::post('admin_login', 'AuthController@admin_login');
    Route::get('refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
        Route::post('admin_logout', 'AuthController@logout');
    });
});

Route::group(['middleware' => ['auth']], function() {

});

$middleware = ['api'];
if (\Request::header('Authorization')){
    $middleware = array_merge(['auth:api']);
}   

// login route api start
Route::group(['middleware' => ['auth:api']], function() {

    Route::group(['prefix' => 'profile'], function () {
        Route::get('approve/{id}','registerController@approve');
    });

    // Category
    Route::group(['prefix' => 'category'], function () {
        Route::get('categorylist', 'PostsCategoryController@index');
        Route::post('add', 'PostsCategoryController@addCategory');
        Route::get('edit/{id}', 'PostsCategoryController@editCategory');
        Route::post('update/{id}', 'PostsCategoryController@updateCategory');
        Route::delete('delete/{id}', 'PostsCategoryController@destroyCategory');
    });
    // End Category

    // News category

    Route::group(['prefix' => 'news'], function () {
        Route::post('add', 'NewsByCatController@add');
        Route::get('edit/{id}', 'NewsByCatController@edit');
        Route::get('news', 'NewsByCatController@index');
        Route::post('update/{id}', 'NewsByCatController@update');
        Route::delete('delete/{id}','NewsByCatController@destroy');
        Route::post('search', 'NewsByCatController@search');

    });
    // End Advertisement

    // Station
    Route::group(['prefix' => 'station'], function () {
        Route::get('stations', 'StationController@index');
        Route::post('add', 'StationController@add');
        Route::get('edit/{id}', 'StationController@edit');
        Route::post('update/{id}', 'StationController@update');
        Route::delete('delete/{id}', 'StationController@destroy');
        Route::post('search','StationController@search');
    });
    // End Station

    // Type
    Route::group(['prefix' => 'types'], function () {
        Route::get('typelist', 'TypeController@TypeList');
        Route::get('type', 'TypeController@index');
        Route::post('add', 'TypeController@store');
        Route::get('edit/{id}', 'TypeController@edit');
        Route::post('update/{id}', 'TypeController@update');
        Route::delete('delete/{id}', 'TypeController@destroy');
        Route::post('search', 'TypeController@search');
    });

       // occupation
       Route::group(['prefix' => 'occupation'], function () {
        Route::get('occupationList', 'OccupationsController@typeList');
        Route::get('type', 'OccupationsController@index');
        Route::post('add', 'OccupationsController@store');
        Route::get('edit/{id}', 'OccupationsController@edit');
        Route::post('update/{id}', 'OccupationsController@update');
        Route::delete('delete/{id}', 'OccupationsController@destroy');
        Route::post('search', 'OccupationsController@search');
    });


    // End Type

    //Subject
    Route::group(['prefix' => 'subjects'], function () {
        Route::get('subjectlist', 'SubjectController@SubjectList');
        Route::get('subject', 'SubjectController@index');
        Route::post('add', 'SubjectController@store');
        Route::get('edit/{id}', 'SubjectController@edit');
        Route::post('update/{id}', 'SubjectController@update');
        Route::delete('delete/{id}', 'SubjectController@destroy');
        Route::post('search', 'SubjectController@search');
    });
    //End Subject

    // Job
    Route::group(['prefix' => 'job'], function () {
        Route::get('confirm/{id}','JobController@confirm');
        Route::post('add', 'JobController@store');
        Route::get('index/{type}/{proid}', 'JobController@index');
        Route::get('edit/{id}', 'JobController@edit');
        Route::get('occupationlist', 'JobController@getOccupationList');
        Route::post('update/{id}', 'JobController@update');
        Route::delete('delete/{id}/{type}/{pro_id}', 'JobController@destroy');
        Route::post('search', 'JobController@search');
        Route::get('customerList/{type}', 'JobController@getCustomerList');
        Route::post('profileList/{cId}', 'JobController@getProfileList');
        Route::post('profileName/{id}','JobController@getProfileName');
    });
    // End Job

    // Facility
    Route::group(['prefix' => 'facility'], function () {
        Route::post('add', 'FacilityController@add');
        Route::get('facilities', 'FacilityController@index');
        Route::get('edit/{id}', 'FacilityController@edit');
        Route::post('update/{id}', 'FacilityController@update');
        Route::delete('delete/{id}', 'FacilityController@destroy');
    });
    // End Facility

    // Customer
    Route::group(['prefix' => 'customer'], function () {
        Route::post('add', 'CustomerController@add');
        Route::post('uploadvideo', 'CustomerController@uploadvideo');
        Route::post('deletevideo', 'CustomerController@deletevideo');
        Route::get('edit/{id}', 'CustomerController@edit');
        Route::post('update/{id}','CustomerController@update');
        Route::post('account_update','CustomerController@accountStatusUpdate');
        Route::delete('delete/{id}/{type}','CustomerController@destroy');
    });
    // End Customer

    // News
    Route::post('news_list/search', 'PostController@search');
    Route::get('news_list', 'PostController@index');
    Route::group(['prefix' => 'new'], function () {
        Route::post('add', 'PostController@add');
        Route::get('editPost/{id}', 'PostController@edit');
        Route::post('update/{id}', 'PostController@update');
        Route::delete('delete/{id}', 'PostController@delete');
        // Route::post('getPostsByCatId', 'PostController@getPostById');
        Route::post('getPostsByCatId', 'PostController@getPostById');
    });
    // End News

    // Medical
    Route::group(['prefix' => 'medical'], function () {
        Route::post('add', 'MedicalController@add');
        Route::get('medicalacceptance', 'MedicalController@index');
        Route::delete('delete/{id}', 'MedicalController@destroy');
        Route::get('edit/{id}', 'MedicalController@edit');
        Route::post('update/{id}', 'MedicalController@update');
    });
    // End Medical

    // Advertisement
    Route::group(['prefix' => 'advertisement'], function () {
        Route::post('add', 'AdvertisementController@store');
        Route::get('edit/{id}', 'AdvertisementController@edit');
        Route::get('ads', 'AdvertisementController@index');
        Route::post('update/{id}', 'AdvertisementController@update');
        Route::delete('delete/{id}','AdvertisementController@destroy');
        Route::get('activate/{id}','AdvertisementController@activate');

    });
    // End Advertisement

    


    //SpecialFeature
    Route::group(['prefix' => 'feature'], function () {
        Route::post('add', 'SpecialFeatureController@store');
        Route::get('edit/{id}', 'SpecialFeatureController@edit');
        Route::get('featurelist/{type}', 'SpecialFeatureController@index');
        Route::get('nursing-feature/{type}', 'SpecialFeatureController@getFeaturebyProfileType');
        Route::post('update/{id}', 'SpecialFeatureController@update');
        Route::delete('delete/{id}/{type}','SpecialFeatureController@destroy');
        Route::post('search/{type}','SpecialFeatureController@search');
    });
    //End SpecialFeature

    Route::group(['prefix' => 'main_admin'], function () {
        Route::get('admin_list','UserController@getAdminList');
        Route::post('add','UserController@storeAdmin');
        Route::get('edit/{id}','UserController@editAdmin');
        Route::post('update','UserController@updateAdmin');
        Route::delete('delete/{id}','UserController@deleteAdmin');
    });

});
// login route api end

// public route api start
Route::group(['middleware' => $middleware], function() {
    Route::get('gethospitalsearch/{searchword}','SearchMapController@getHospitalSearch');
    Route::get('getnursingsearch/{searchword}','SearchMapController@getNursingSearch');
    Route::get('getmap','SearchMapController@getMap');
    Route::get('cities','SearchMapController@getCities');
    Route::get('getjobsearch/{searchword}','SearchMapController@getJobSearch');
    Route::get('getCity','SearchMapController@getCity');
    Route::get('profile_view/{proid}/{type}','ProfilePublishController@getCustomerLatLng');
    Route::get('townshipJson/{township_name}','SearchMapController@townshipJson');
    /*added by maythirihtet to display linked news*/
    Route::get('getLinkedNews/{show_type}','SearchMapController@getLinkedNews');
    /** **/

    Route::group(['prefix' => 'profile'], function () {
        Route::get('nursing/{cusid}','ProfilePublishController@nursingProfile');
        Route::get('hospital/{cusid}','ProfilePublishController@hospitalProfile');
        Route::get('specialfeature/{type}/{proid}','ProfilePublishController@getSpecialfeature');
        Route::get('comment/{cusid}/{type}','ProfilePublishController@getComment');
        Route::get('customer/{proid}/{type}','ProfilePublishController@getCustomer');
        Route::get('schedule/{cusid}','ProfilePublishController@getSchedule');
        // Route::get('hosfacility','ProfilePublishController@getHosfacilities');
        Route::get('subject/{cusid}','ProfilePublishController@getSubject');
    });
    
    Route::group(['prefix' => 'job'], function () {
        // Route::get('getjob/{id}', 'JobController@getJob');
        // Route::post('search', 'JobController@search');
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('category_list','PostsCategoryController@list');
        Route::post('search', 'PostsCategoryController@search');
    });

    Route::group(['prefix' => 'advertisement'], function () {
        Route::post('search', 'AdvertisementController@search');
        Route::get('adslide', 'AdvertisementController@slider');
    });

    Route::group(['prefix' => 'facility'], function () {
        Route::post('search', 'FacilityController@search');
    });

    Route::group(['prefix' => 'customer'], function () {
        Route::post('search', 'CustomerController@search');
    });

    Route::get('getReset','registerController@getReset');
    Route::get('getStatus/{token}','registerController@getStatus');
    Route::post('reset','registerController@reset');
    Route::post('resetpassword','registerController@resetpassword');
    Route::post('register','registerController@store');
    // Route::get('getskill', 'JobApplyController@getSkills');
    Route::get('getjobtitle/{jobs_id}', 'JobApplyController@getJobTitle');
    Route::get('skill', 'JobController@getSkill');
    Route::get('customers/{type}','CustomerController@index');
    Route::get('custedit','CustomerController@edit');
    Route::get('confirm/{id}','CustomerController@confirm');
    Route::get('facilities', 'FacilityController@index');
    Route::get('facility_types', 'FacTypesController@index');
    // Route::get('job_details', 'JobDetailController@index');
    Route::get('featurelist', 'SpecialFeatureController@index');

    Route::get('feature/{type}/{id}','SpecialFeatureController@getFeaturebyProfileType');
    // Route::post('sfeature/update/{id}','SpecialFeaturesJunctionsController@update');
    // Route::post('subject_junctions/update/{id}','SubjectJunctionsController@update');
    Route::post('station_junctions/update/{id}','StationJunctionsController@update');

    Route::get('facility/{type}/{id}','FacilityController@getFacilitybyProfileType');
    Route::get('clinical-subject/{id}','SubjectController@getHospitalClinicalSubject');
    Route::get('station/{id}','StationController@getStationbyCustomerId');

    Route::get('pgallery/{id}/{type}','GalleryController@getPhotobyCustomerId');
    Route::get('vgallery/{id}/{type}','GalleryController@getVideobyCustomerId');
    Route::post('delete-pgallery','GalleryController@deleteGallery');

    Route::get('nursing-panorrama-gallery/{id}','GalleryController@getPanoramabyCustomerId');
    Route::post('nursing/movephoto','NursingProfileController@movePhoto');
    Route::post('nursing/movelogo','NursingProfileController@moveLogo');
    Route::post('nursing/movepanorama','NursingProfileController@movePanorama');
    Route::post('nursing/movelatlng/{id}','ProfileController@movelatlng');
    Route::post('hospital/movephoto','HospitalProfileController@movePhoto');
    Route::post('user/movephoto','UserController@movePhoto');
    Route::post('user/password-change','UserController@changePassword');
    Route::post('user/email-change','UserController@changeEmail');
    // Route::get('user/userinfo','UserController@getUserInfo');

    Route::get('nursing-cooperate/{id}','CooperateMedicalController@getCooperateByCustomerId');
    Route::get('nursing-payment/{id}','PaymentMethodController@getPaymentByCustomerId');

    Route::get('customerinfo/{id}','CustomerController@edit');
    Route::get('nursinginfo/{id}','NursingProfileController@edit');
    Route::get('nurscities/{township_id}','NursingProfileController@getCities');
    Route::get('townshiplist/{city_id}','NursingProfileController@getTownships');
    Route::get('hospitalinfo/{id}','HospitalProfileController@edit');
    Route::get('staffinfo/{id}', 'ProfilePublishController@getStaffbyCustomerId');

    // Route::post('nursing/galleryupdate/{id}', 'NursingProfileController@galleryupdate');
    Route::post('hospital/galleryupdate/{id}', 'HospitalProfileController@galleryupdate');
    Route::get('account_nursing/{id}','CustomerController@nusaccount');
    Route::get('account_hospital/{id}','CustomerController@hosaccount');
    Route::get('changeActivate/{id}/{type}','CustomerController@changeActivate');
    Route::get('changeRecordstatus/{id}','PostController@changeRecordstatus');
    Route::get('changeSmartStatus/{id}','PostController@changeSmartStatus');
    // Route::get('changeActivateHos/{id}','CustomerController@changeActivateHos');
    Route::delete('profileDelete/{id}/{type}','CustomerController@profileDelete');
    // Route::delete('profileDeleteHos/{id}','CustomerController@profileDeleteHos');

    // Route::post('nursing/cooperate/{id}', 'NursingProfileController@cooperateupdate');
    // Route::post('nursing/paymentmethod/{id}', 'NursingProfileController@paymentupdate');

    Route::post('nursing/profile/{id}', 'NursingProfileController@profileupdate');
    Route::post('hospital/profile/{id}', 'HospitalProfileController@profileupdate');

    // Route::post('schedule/update/{id}', 'ScheduleController@update');
    Route::get('schedule/{id}', 'ScheduleController@getSchedulebyCustomerId');

    // Route::post('customer/profile/{id}', 'NursingProfileController@Customerprofileupdate');
    // Route::post('staff/profile/{id}', 'NursingProfileController@Staffprofileupdate');
    // Route::post('acceptance/transactions/{id}', 'NursingProfileController@AcceptanceTransactions');

    Route::get('medical/acceptancewithtransactions/{id}', 'MedicalController@getAcceptanceWithTransactions');

    // Home Page
    Route::get('home', 'HomeController@index');
    Route::post('posts', 'HomeController@getPosts');
    Route::post('get_latest_post', 'HomeController@getLatestPost');
    Route::get('get_latest_post_all_cat', 'HomeController@getLatestPostFromAllCat');
    Route::post('search', 'HomeController@search');
    Route::get('get_latest_posts_by_catId/{searchword}', 'HomeController@getLatestPostsByAllCatId');
    Route::get('get_latest_posts_by_catId_mobile/{searchword}', 'HomeController@getLatestPostsByAllCatIdForMobile');
    Route::get('get_news_by_catId/{searchword}/{id}', 'HomeController@get_news_by_catId');
    Route::get('get_cat_random', 'HomeController@getCategoryRandom');


    Route::get('newdetails/{id}', 'PostController@show');
    Route::get('newscategory/{id}', 'PostController@getNewsByCategory');
    Route::get('newscategorymobile/{id}', 'PostController@getNewsByCategoryForMobile');
    Route::get('relatednews/{id}', 'PostController@show_related');
    // Route::get('newsdetailsrelated/{id}','PostController@relatednews');


    Route::post('jobapply','JobApplyController@store');
    // Route::get('jobapplylist/{jobs_id}','JobApplyController@getJobapplies');
    // Route::post('jobapplylist/search','JobApplyController@search');
    // Route::get('job_details', 'JobDetailController@index');
    Route::get('job_details/{id}', 'JobDetailController@show');

    // Guest Hospital History
    Route::post('hospital_history/{local_sto}', 'CustomerProfileContoller@getHospitalHistory');
    Route::post('favHospital/{local_sto}', 'HospitalProfileController@getFavouriteHospital');

    // Guest Nursing History
    // Route::post('nursing_history/{local_sto}', 'CustomerProfileContoller@getHospitalHistory');
    Route::post('nursing_history/{local_sto}', 'CustomerProfileContoller@getNursingHistory');
    Route::post('nursing_fav/{local_sto}', 'HospitalProfileController@getFavouriteNursing');

    // Route::post('news/search/{searchword}', 'PostController@searchPost');

    Route::group(['prefix' => 'hospital'], function () {
        Route::post('postList/{postal}', 'HospitalProfileController@getPostalList');
        Route::get('citiesList', 'HospitalProfileController@getCitiesName');
        Route::get('townshipList', 'HospitalProfileController@getTownshipName');
        Route::get('favourite_list', 'HospitalProfileController@index');
        Route::delete('delete/{id}', 'HospitalProfileController@destroy');
    });

    Route::group(['prefix' => 'comments'], function () {
        Route::post('add', 'CommentController@store');
        Route::get('edit/{id}', 'CommentController@edit');
        Route::get('comment/{type}', 'CommentController@index');
        Route::get('getCustomComment/{type}/{profileid}', 'CommentController@getCustomComment');
        Route::get('confirm/{id}/{type}/{pro_id}','CommentController@confirm');
        Route::post('update/{id}', 'CommentController@update');
        Route::delete('delete/{id}/{type}/{pro_id}','CommentController@destroy');
        Route::post('search','CommentController@search');
        //Route::get('getcommentlist/{cusid}','CommentController@getCommentList');
        Route::get('comment_list','CommentController@list');
    });

    Route::group(['prefix' => 'nurse'], function () {
        Route::post('add', 'NursingMailController@mail');
        Route::get('edit/{id}', 'NursingMailController@edit');
        Route::get('comment', 'NursingMailController@index');
        Route::get('comfirm/{id}','NursingMailController@confirm');
        Route::post('update/{id}', 'NursingMailController@update');
        Route::delete('delete/{id}','NursingMailController@destroy');
    });

    // Route::group(['prefix' => 'new'], function () {
    //     Route::post('getPostsByCatId/{id}', 'PostController@getPostById');
    // });

    Route::get('cost','ProfilePublishController@getCost');
    Route::get('hospital','ProfilePublishController@hospital');
    Route::get('jobapplicantlist/{type}/{page}/{search_id}','JobApplyController@jobapplicantlist');
    Route::delete('jobApplicantDelete/{id}','JobApplyController@jobApplicantDelete');
    Route::post('jobapplicant/search','JobApplyController@search');

    Route::get('feed/smartnews.xml','SmartFeedController@index');

});
// public route api end