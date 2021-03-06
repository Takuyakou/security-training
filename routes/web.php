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

//************
// ユーザー
//************
Route::namespace('User')->name('user.')->group(function () {

    // ログイン認証関連
    Auth::routes([
        'register' => false,
        'reset'    => false,
        'verify'   => false
    ]);

    // ログイン認証後
    Route::middleware('auth:user')->group(function () {
        Route::get('/', 'HomeController@index')->name('home');
        // 問題を開始する
        Route::get('/question/{pageId}', 'QuestionController@questionStart')->name('question.start');
        // 問題の解答を提出する
        Route::post('/question', 'QuestionController@questionAnswer')->name('question.answer');
    });
});

//************
// 管理者
//************
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {

    // ログイン認証関連
    Auth::routes([
        'register' => false,
        'reset'    => false,
        'verify'   => false
    ]);

    // ログイン認証後
    Route::middleware('auth:admin')->group(function () {
        Route::get('/', 'HomeController@index')->name('home');
        /**
         * 問題管理機能
         */
        // 出題問題数を変更
        Route::post('/question', 'QuestionController@questionNumberChange')->name('question.number.change');

        // 問題一覧ページに遷移
        Route::get('/question', 'QuestionController@index')->name('question.list.show');
        // 問題追加ページに遷移
        Route::get('/question/edit', 'QuestionController@showCreatePage')->name('question.create.show');
        // 問題を作成
        Route::post('/question/edit', 'QuestionController@create')->name('question.create');
        // 問題を削除
        Route::post('/question/edit/delete', 'QuestionController@delete')->name('question.delete');
        // 問題編集ページに遷移
        Route::get('/question/edit/{question_id}', 'QuestionController@showUpdatePage')->name('question.update.show');
        // 問題を更新
        Route::post('/question/edit/{question_id}', 'QuestionController@update')->name('question.update');


        /**
         * ユーザー管理機能
         */
        // ユーザー一覧ページに遷移
        Route::get('/user', 'UserController@index')->name('user.list.show');
        // ユーザー作成ページに遷移
        Route::get('/user/edit', 'UserController@showCreatePage')->name('user.create.show');
        // ユーザーを作成
        Route::post('/user/edit', 'UserController@create')->name('user.create');
        // ユーザー削除機能
        Route::post('/user/edit/delete', 'UserController@destroy')->name('user.delete');
        // ユーザー編集ページに遷移
        Route::get('/user/edit/{user_id}', 'UserController@showUpdatePage')->name('user.update.show');
        // ユーザーを更新
        Route::post('/user/edit/{user_id}', 'UserController@update')->name('user.update');

        /**
         * 受験結果管理機能
         */
        // 受験結果一覧ページに遷移
        Route::get('/result', 'ResultController@index')->name('result.list.show');
    });
});
