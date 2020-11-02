<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 出題必須の問題数を取得
        $flgOnQuestions = \App\Models\Question::whereNull('deleted_at')->where('required_flg', 1)->count();
        return view('admin.home', ['flgOnQuestions' => $flgOnQuestions]);
    }
}
