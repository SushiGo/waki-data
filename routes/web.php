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

Auth::routes();

// url -> waki-data.com/
// if admin, go to /dashboard
// if not admin, go to /data
// if not authenticated go to /login
Route::get('/', function () {
    if(Auth::check())
    {
    	if(Auth::user()->roles->first()->slug == 'admin')
    	{
    		return redirect()->route('dashboard');
    	}
    	else
    	{
    		return redirect()->route('data');
    	}
    }
    else
    {
    	return redirect()->route('login');
    }
});

//-- DASHBOARD --//
Route::get('/dashboard', 'DashboardController@index')
	->name('dashboard')
	->middleware('can:dashboard');

//-- MASTER DATA --//
Route::group(['prefix' => 'data'], function () {
    //Browser
    Route::get('/', 'DataController@index')
    	->name('data')
    	->middleware('auth');
    //Add Data Undangan
    Route::post('/adddataundangan', 'DataController@storeDataUndangan')
        ->name('store_dataundangan')
        ->middleware('can:add-data-undangan');
    //Add Data Outsite
    Route::post('/adddataoutsite', 'DataController@storeDataOutsite')
        ->name('store_dataoutsite')
        ->middleware('can:add-data-outsite');
        //Add Data Therapy
    Route::post('/adddatatherapy', 'DataController@storeDataTherapy')
        ->name('store_datatherapy')
        ->middleware('can:add-data-therapy');
        //Add Data MPC
    Route::post('/addmpc', 'DataController@storeMpc')
        ->name('store_mpc')
        ->middleware('can:add-mpc');
});

//-- MASTER DATA TYPE --//
Route::group(['prefix' => 'datatype'], function () {
	//Browse
	Route::get('/', 'TypeCustController@index')
		->name('type_cust')
		->middleware('can:browse-type-cust,add-type-cust');
	//Add
	Route::post('/', 'TypeCustController@store')
		->name('store_type_cust')
		->middleware('can:add-type-cust');
	//Edit
	Route::post('/edit/', 'TypeCustController@update')
        ->name('update_type_cust')
        ->middleware('can:edit-branch');
    //Delete
	Route::post('/{typecust}', 'TypeCustController@delete')
		->name('delete_type_cust')
		->middleware('can:delete-type-cust,typecust');
});

//-- MASTER BRANCH --//
Route::group(['prefix' => 'branch'], function () {
	//Browse
	Route::get('/', 'BranchController@index')
		->name('branch')
		->middleware('can:browse-branch,add-branch');
	//Add
	Route::post('/', 'BranchController@store')
		->name('store_branch')
		->middleware('can:add-branch');
	//Edit
	Route::post('/edit/', 'BranchController@update')
        ->name('update_branch')
        ->middleware('can:edit-branch');
    //Delete
	Route::post('/{branch}', 'BranchController@delete')
		->name('delete_branch')
		->middleware('can:delete-branch,branch');
});

//-- MASTER CSO --//
Route::group(['prefix' => 'cso'], function () {
	//Browse
	Route::get('/', 'CsoController@index')
		->name('cso')
		->middleware('can:browse-cso,add-cso');
	//Add
	Route::post('/', 'CsoController@store')
		->name('store_cso')
		->middleware('can:add-cso');
	//Edit
	Route::post('/edit/', 'CsoController@update')
        ->name('update_cso')
        ->middleware('can:edit-cso');
    //Delete
	Route::post('/{cso}', 'CsoController@delete')
		->name('delete_cso')
		->middleware('can:delete-cso,cso');
});

//-- MASTER USER --//
Route::group(['prefix' => 'user'], function () {
	//Browse
	Route::get('/', 'UserController@index')
		->name('user')
		->middleware('can:browse-user,add-user');
	//Add
	Route::post('/', 'UserController@store')
		->name('store_user')
		->middleware('can:add-user');
	//Edit
	Route::post('/edit/', 'UserController@update')
        ->name('update_user')
        ->middleware('can:edit-user');
    //Delete
	Route::post('/{user}', 'UserController@delete')
		->name('delete_user')
		->middleware('can:delete-user,user');
});

//-- PASSWORD --//
Route::post('/changePassword','AjaxController@changePassword')->name('changePassword');

//-- AJAX --//
Route::post('/selectCountry', 'AjaxController@selectCountry')
    ->name('select-country');

Route::post('/selectBranch', 'AjaxController@selectBranch')
    ->name('select-branch');

Route::post('/checkBranchCode', 'AjaxController@checkBranchCode')
    ->name('check-branch-code');

Route::post('/checkChangePassword', 'AjaxController@checkChangePassword')
    ->name('check-change-password');

// Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/', 'MemberController@index')->middleware('auth');

// Route::get('/', function () {
//     return view('welcome');
// });
