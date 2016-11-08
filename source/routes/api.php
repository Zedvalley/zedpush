<?php

use Illuminate\Http\Request;

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





/******************************Operation over offers*******************************/
// Gallery operations are specified on gallery controller

Route::group(['prefix'=>'v1/offers'],function()
{
    Route::post('/create',['uses'=>'Offers@createOffer']);
    Route::post('/update',['uses'=>'Offers@updateOffer']);
    Route::post('/view_update',['uses'=>'Offers@updateView']);
    Route::post('/delete',['uses'=>'Offers@deleteOffer']);
    Route::post('/total',['uses'=>'Offers@totalOffers']);
    Route::post('/details',['uses'=>'Offers@getOfferDetails']);
    Route::post('/all',['uses'=>'Offers@getAllOfferByUser']);
    Route::post('/all-by-limit',['uses'=>'Offers@getAllOfferByUsersByLimit']);
    Route::post('/campaign-status',['uses'=>'Offers@campaignStat']);
    Route::post('/add-gallery',['uses'=>'Offers@addGalleryId']);

});
/******************************Operation over sales**********************************/

Route::group(['prefix'=>'v1/category'],function()
{

    Route::post('/create',['uses'=>'Sales@createCategory']);
    Route::post('/update',['uses'=>'Sales@updateCategory']);
    Route::post('/delete',['uses'=>'Sales@deleteCategory']);
    Route::post('/deep-delete',['uses'=>'Sales@deepCatDelete']);
    Route::post('/list',['uses'=>'Sales@listBaseCategory']);
    Route::post('/next-list',['uses'=>'Sales@nextPage']);
    Route::post('/total',['uses'=>'Sales@totalCategories']);


});


Route::group(['prefix'=>'v1/sales'],function()
{
    Route::post('/create',['uses'=>'Sales@createSales']);
    Route::post('/update',['uses'=>'Sales@updateSales']);
    Route::post('/view_update',['uses'=>'Sales@updateView']);
    Route::post('/delete',['uses'=>'Sales@deleteSales']);
    Route::post('/total',['uses'=>'Sales@totalProducts']);
    Route::post('/details',['uses'=>'Sales@getSalesDetails']);
    Route::post('/all-by-limit',['uses'=>'Sales@getAllSalesByUsersByLimit']);
    Route::post('/campaign-status',['uses'=>'Sales@campaignStat']);
    Route::post('/add-gallery',['uses'=>'Sales@addGalleryId']);
    Route::post('/status-update',['uses'=>'Sales@changeShowStatus']);

});


Route::group(['prefix'=>'v1/jobs'],function()
{
    Route::post('/create',['uses'=>'Job@createJob']);
    Route::post('/update',['uses'=>'Job@updateJob']);
    Route::post('/view_update',['uses'=>'Job@updateView']);
    Route::post('/delete',['uses'=>'Job@deleteJob']);
    Route::post('/total',['uses'=>'Job@totalJob']);
    Route::post('/details',['uses'=>'Job@getJobDetails']);
    Route::post('/all-by-limit',['uses'=>'Job@getAllJobByUsersByLimit']);
    Route::post('/campaign-status',['uses'=>'Job@campaignStat']);
    Route::post('/add-gallery',['uses'=>'Job@updateGalleryId']);
    Route::post('/all',['uses'=>'Job@getAllJobByUser']);
});


Route::group(['prefix'=>'v1/testimonials'],function()
{
    Route::post('/create',['uses'=>'TestimonialsController@createTestimonial']);
    Route::post('/update',['uses'=>'TestimonialsController@updateTestimonial']);
    Route::post('/update-image',['uses'=>'TestimonialsController@updateImage']);
    Route::post('/delete',['uses'=>'TestimonialsController@deleteTestimonial']);
    Route::post('/details',['uses'=>'TestimonialsController@viewTestimonial']);
    Route::post('/list',['uses'=>'TestimonialsController@listTestimonials']);
    Route::post('/recent',['uses'=>'TestimonialsController@viewRecentTestimonials']);

});

Route::group(['prefix'=>'v1/gallery'],function()
{

    Route::post('/create',['uses'=>'Commons@createGallery']);
    Route::post('/update',['uses'=>'Commons@updateGallery']);
    Route::post('/delete',['uses'=>'Commons@deleteGallery']);

});

Route::group(['prefix'=>'v1/contact-us'],function()
{
    Route::post('/create',['uses'=>'ContactUsController@createContactRequest']);
    Route::post('/view',['uses'=>'ContactUsController@viewContactRequest']);
    Route::post('/list',['uses'=>'ContactUsController@listContactRequest']);
    Route::post('/all-by-limit',['uses'=>'ContactUsController@listContactRequestByOffset']);
    Route::post('/delete',['uses'=>'ContactUsController@deleteContactRequest']);

});
Route::group(['prefix'=>'v1/home'],function() {

    Route::post('/logo-title',['uses'=>'HomeController@setLogoTitle']);
    Route::post('/gallery',['uses'=>'HomeController@setGallery']);
    Route::post('/tag',['uses'=>'HomeController@updateTag']);
    Route::post('/about-us',['uses'=>'HomeController@updateAboutUs']);
    Route::post('/email',['uses'=>'HomeController@updateEmail']);
    Route::post('/address',['uses'=>'HomeController@updateAddress']);
    Route::post('/contact',['uses'=>'HomeController@updateContact']);
    Route::post('/details',['uses'=>'HomeController@getHomeDetails']);


});
Route::group(['prefix'=>'v1/users'],function() {

    Route::post('/create',['uses'=>'UserController@create']);
    Route::post('/shop-update',['uses'=>'UserController@updateShopDetails']);
    Route::post('/info-update',['uses'=>'UserController@updatePersonalInfo']);
    Route::post('/username-update',['uses'=>'UserController@updateUsername']);
    Route::post('/password-update',['uses'=>'UserController@updatePassword']);
    Route::post('/login',['uses'=>'UserController@login']);
    Route::post('/check-username',['uses'=>'UserController@checkUsernameExist']);
    Route::post('/check-email',['uses'=>'UserController@checkEmailExist']);
    Route::post('/countries',['uses'=>'UserController@getCountriesList']);
    Route::post('/details',['uses'=>'UserController@getUserDetails']);



});

