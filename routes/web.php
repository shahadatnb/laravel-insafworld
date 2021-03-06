<?php

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


Route::get('/ac_config', function()
    {
        \Artisan::call('view:clear');
        \Artisan::call('config:cache');
        return 'OK';
    });

//Route::get('/', 'FrontController@index')->name('/');


Auth::routes();

Route::group(['middleware' => 'auth'], function(){
		Route::get('/pending', 'HomeController@pending')->name('pending');
		//Route::get('/getpremium', 'HomeController@getpremium')->name('getpremium');
	});

Route::group(['middleware' => ['auth']], function(){
	Route::get('/', 'HomeController@index')->name('/');
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/vipMembers', 'HomeController@vipMembers')->name('vipMembers');
	Route::get('/vipInfoList', 'HomeController@vipList')->name('vipInfoList');

	Route::get('/rank', 'HomeController@rank')->name('rank');
	Route::get('/rankList', 'HomeController@rankList')->name('rankList');
	Route::get('/matchinList', 'HomeController@matchinList')->name('matchinList');
	//Route::get('/404', 'PageController@notFind')->name('/404');

	Route::get('/myWallet/{wallet}', 'HomeController@myWallet')->name('myWallet');
	Route::get('/withdrawals/{type}/{type2}', 'HomeController@withdrawals');	
	Route::get('/withdrawWallet', 'HomeController@withdrawWallet')->name('withdrawWallet');
	Route::get('/dailyToWW', 'HomeController@dailyToWW')->name('dailyToWW');
	
	Route::get('/volume/{no}', 'HomeController@volume');
	Route::get('/volume/id/{id}', 'HomeController@volumeID')->name('volume');

	Route::get('/memberList', 'HomeController@memberList')->name('memberList');
	Route::get('/member/id/{id}', 'HomeController@memberListId')->name('memberListId');
	Route::get('/levelTree', 'HomeController@levelTree')->name('levelTree');
	Route::get('/levelTree/id/{id}', 'HomeController@levelTreeId')->name('levelTreeId');
	Route::get('/level', 'HomeController@level')->name('level');
	Route::get('/mySponsor', 'HomeController@mySponsor')->name('mySponsor');
	Route::get('/matchingBonus', 'HomeController@matchingBonus')->name('matchingBonus');

	Route::get('/sendMoneyAc', 'HomeController@sendMoneyAc');
	Route::post('/sendMoneyAc', 'HomeController@sendMoneyAcPost')->name('sendMoneyAc');
	Route::post('/withdrawBalance', 'HomeController@withdrawBalance')->name('withdrawBalance');
	Route::post('/sendMoneyWw', 'HomeController@sendMoneyWw')->name('sendMoneyWw');

	Route::get('/youtubeClick', 'PtcController@youtubeClick')->name('youtubeClick');
	Route::get('/youtubeClick/{id}', 'PtcController@youtubeClickPost');

	Route::get('/profile', 'ProfileController@index')->name('profile');
	Route::get('/editProfile', 'ProfileController@editProfile')->name('editProfile');
	Route::post('/updateProfile', 'ProfileController@updateProfile')->name('updateProfile');
	Route::get('/changePass', 'ProfileController@changePass')->name('changePass');
	Route::post('/changePass', 'ProfileController@changePassSave')->name('changePass');
	Route::put('/changePhoto', 'ProfileController@changePhoto')->name('changePhoto');

	Route::get('/newMember', 'ProfileController@newMember')->name('newMember');
	Route::post('/newMember', 'ProfileController@newMemberPost')->name('newMember');

/*
	Route::get('/addOutsourcingBalance', 'earnController@addOutBalance')->name('addOutBalance');
	Route::get('/Outsourcing', 'earnController@outsourcing')->name('outsourcing');
	Route::get('/ptcs/click', 'PtcController@pctClick')->name('ptc.click');

	Route::get('/order/myOrder', 'OrderController@myOrder')->name('myOrder');
	Route::get('/order/buyPack/{id}', 'OrderController@buyPack')->name('buyPack');
	Route::post('/order/buyPackSubmit', 'OrderController@buyPackSubmit')->name('buyPackSubmit');*/

});

/*Route::group(['middleware' => ['auth','premium']], function(){
	Route::get('/myWallet', 'HomeController@myWallet')->name('myWallet');
	Route::get('/earnWallet', 'HomeController@earnWallet')->name('earnWallet');
});*/

Route::group(['middleware' => ['auth','admin']], function(){
	Route::get('/admin-panel', 'AdminController@index')->name('admin.panel');
	Route::get('/allMemberList', 'ProfileController@allMemberList')->name('allMemberList');
	Route::get('/profileView/{id}', 'ProfileController@profileView')->name('profileView');

	//Route::get('/pin', 'AdminController@pin')->name('pin');
	//Route::get('/pingenarate', 'AdminController@pingenarate')->name('pingenarate');

	Route::put('/saveSetting/{id}', 'AdminController@saveSetting')->name('saveSetting');
	Route::get('/withdrawWetting', 'AdminController@withdrawWetting')->name('withdrawWetting');
	Route::get('/withdrawConfirm/{id}', 'AdminController@withdrawConfirm')->name('withdrawConfirm');
	Route::get('/withdrawCancel/{id}', 'AdminController@withdrawCancel')->name('withdrawCancel');
	
	Route::get('/sendMoney', 'AdminController@sendMoney')->name('sendMoney');
	Route::post('/sendMoney', 'AdminController@postSendMoney')->name('sendMoney');
	Route::post('/paymentMoney', 'AdminController@paymentMoney')->name('paymentMoney');

	Route::post('/changePassAdmin', 'ProfileController@changePassAdmin')->name('changePassAdmin');

	Route::resource('youtubeLinks','PtcController');

	Route::resource('products','ProductController');
	Route::resource('packs','PacController');
	Route::get('/dailyBonusDist', 'PacController@bonusDist');

	Route::get('/productHide/{id}', 'ProductController@productHide')->name('productHide');

	Route::get('/productDelevery', 'ProductController@productDelevery')->name('productDelevery');
	Route::get('/productDeleveryConfirm/{id}', 'ProductController@productDeleveryConfirm')->name('productDeleveryConfirm');

});


