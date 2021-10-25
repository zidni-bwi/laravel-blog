<?php

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

Auth::routes();

# Set Index dengan memanggil fungsi home dari controller BlogCOntroller
Route::match(['get', 'post'], '/', 'HomeController@index')->name('home');
Route::get('/posts/{id}', 'HomeController@posts')->name('posts');
Route::post('/orderby', 'HomeController@orderby');

Route::get('/author/{id}', 'HomeController@author')->name('author');
Route::get('/like/{id}', 'HomeController@like');
Route::get('/unlike/{id}', 'HomeController@unlike');
Route::post('/comment/{id}', 'HomeController@comment');
Route::get('/uncomment/{id}', 'HomeController@uncomment');
Route::post('/edit_comment/{id}', 'HomeController@edit_comment');

# Route General
Route::get('/dashboard', 'MenuController@dashboard')->name('dashboard');
Route::get('/posts', 'MenuController@posts')->name('m_posts');
Route::get('/members', 'MenuController@members')->name('members');

Route::get('/accounts', 'MenuController@accounts')->name('accounts');
Route::get('/edit_accounts', 'MenuController@edit_accounts')->name('edit_accounts');
Route::post('/edit_accounts_process', 'MenuController@edit_accounts_process');

# Route Members
Route::get('/add_posts', 'MenuController@add_posts')->name('add_posts');
Route::post('/add_posts_process', 'MenuController@add_posts_process');
Route::get('/edit_posts/{id}', 'MenuController@edit_posts')->name('edit_posts');
Route::post('/edit_posts_process', 'MenuController@edit_posts_process');
Route::get('/delete_posts/{id}', 'MenuController@delete_posts');

# Route Admin
Route::get('/edit_members/{id}', 'MenuController@edit_members');
Route::post('/edit_members_process', 'MenuController@edit_members_process');
Route::get('/delete_members/{id}', 'MenuController@delete_members');
Route::get('/members/{id}', 'MenuController@detail_members');
