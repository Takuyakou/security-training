<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class QuestionController extends Controller
{

    /**
     * 問題一覧ページに遷移
     */
    public function index(Request $request)
    {
        $questions = \App\Models\Question::get();
        return view('admin.question.index', ['questions' => $questions]);
    }

    /**
     * 問題作成処理
     */
    public function create(Request $request)
    {

        // バリデーション
        $rules = [
            'question_text' => 'required',
            'commentary_text' => 'required',
            'answer_text.*' => 'required_with:answer.*',
            'answer.*' => 'required_with:answer_text.*',
        ];
        $this->validate($request, $rules);
        $cnt = 0;
        $correctCnt = 0;
        foreach ($request->answer as $answer) {
            if ($answer != "" && $answer != null) {
                $cnt++;
                if ($answer === '1') {
                    $correctCnt++;
                }
            }
        }

        $errors = [];
        if ($cnt < 2) {
            $errors = array_merge($errors, array('questionNum' => '問題数が足りません'));
        }
        if ($correctCnt < 1) {
            $errors = array_merge($errors, array('correctNum' => '正解数は必ず一つ必要です',));
        }


        // 単一解答問題の時、正解数は一つ
        if ($request->question_section == '1' && $correctCnt > 1) {
            $errors = array_merge($errors, array('requiredTrueNum' => '単一解答問題の時、正解数は一つです'));
        }
        // 複数解答問題の時、正解数は二つ以上
        if ($request->question_section == '2' && $correctCnt < 2) {
            $errors = array_merge($errors, array('requiredFalseNum' => '複数解答問題の時、正解数は二つ以上です'));
        }
        if (count($errors) > 0) {
            throw \Illuminate\Validation\ValidationException::withMessages(
                $errors
            );
        }

        DB::transaction(function () use ($request) {
            //問題
            $question = new \App\Models\Question;
            $question->question_text = $request->question_text;
            $question->commentary_text = $request->commentary_text;
            $question->question_section = $request->question_section;
            if ($request->required_flg) {
                $question->required_flg = true;
                // チェックボックスのnull(未チェック)を0にしてDBに保存
            } else {
                $question->required_flg = false;
            }
            $question->save();

            // 両方空白と両方入力の場合DBに入れる
            foreach ($request->answer_text as $i => $answerText) {
                if (!$answerText) {
                    continue;
                }
                $answer = new \App\Models\Answer;

                // テーブル間の関連する値(question_id)
                $answer->question_id = $question->id;
                $answer->answer_text = $answerText;
                $answer->answer = $request->answer[$i];
                $answer->save();
            }
        });

        $questions = \App\Models\Question::get();
        session()->flash('status', '問題の追加が完了しました');
        return view('admin.question.index', ['questions' => $questions]);
    }

    /**
     * 問題作成ページに遷移処理
     */
    public function showCreatePage(Request $request)
    {
        $question = new \App\Models\Question;
        $answers = [];
        for ($i = 0; $i < 5; $i++) {
            $answer = new \App\Models\Answer;
            array_push($answers, $answer);
        }

        return view('admin.question.edit', ['question' => $question, 'answers' => $answers, 'create_flag' => true]);
    }



    /**
     * 更新ページに遷移処理
     */
    public function showUpdatePage(Request $request)
    {
        // idがとれる
        $question_id = $request->question_id;

        $question = \App\Models\Question::find($question_id);
        $answers = \App\Models\Answer::where('question_id', $question_id)->get();

        return view('admin.question.edit', ['question' => $question, 'answers' => $answers, 'create_flag' => false]);
    }



    /**
     * 問題更新処理
     */
    public function update(Request $request)
    {
        // バリデーション
        $rules = [
            'question_text' => 'required',
            'commentary_text' => 'required',
            'answer_text.*' => 'required_with:answer.*',
            'answer.*' => 'required_with:answer_text.*',
        ];
        $this->validate($request, $rules);

        $cnt = 0;
        $correctCnt = 0;
        foreach ($request->answer as $answer) {
            if ($answer != "" && $answer != null) {
                $cnt++;
                if ($answer === '1') {
                    $correctCnt++;
                }
            }
        }
        $errors = [];
        if ($cnt < 2) {
            $errors = array_merge($errors, array('questionNum' => '問題数が足りません'));
        }
        if ($correctCnt < 1) {
            $errors = array_merge($errors, array('correctNum' => '正解数は必ず一つ必要です',));
        }


        // 単一解答問題の時、正解数は一つ
        if ($request->question_section == '1' && $correctCnt > 1) {
            $errors = array_merge($errors, array('requiredTrueNum' => '単一解答問題の時、正解数は一つです'));
        }
        // 複数解答問題の時、正解数は二つ以上
        if ($request->question_section == '2' && $correctCnt < 2) {
            $errors = array_merge($errors, array('requiredFalseNum' => '複数解答問題の時、正解数は二つ以上です'));
        }
        if (count($errors) > 0) {
            throw \Illuminate\Validation\ValidationException::withMessages(
                $errors
            );
        }
        // バリデーションここまで


        DB::transaction(function () use ($request) {
            //問題

            $question_id = $request->question_id;
            $question = \App\Models\Question::find($question_id);


            $question->question_text = $request->question_text;
            $question->commentary_text = $request->commentary_text;
            $question->question_section = $request->question_section;
            if ($request->required_flg) {
                $question->required_flg = true;
                // チェックボックスのnull(未チェック)を0にしてDBに保存
            } else {
                $question->required_flg = false;
            }
            $question->save();

            // 解答
            foreach ($request->answer_id as $i => $answer_id) {
                if (!$answer_id) {
                    continue;
                }
                // 対象のデータを取得
                $answer = \App\Models\Answer::find($answer_id);
                $answer->answer_text = $request->answer_text[$i];
                $answer->answer = $request->answer[$i];
                $answer->save();
            }
        });


        $question_id = $request->question_id;
        $question = \App\Models\Question::find($question_id);
        $answers = \App\Models\Answer::where('question_id', $question_id)->get();
        session()->flash('status', '問題の編集が完了しました');
        return view('admin.question.edit', ['question' => $question, 'answers' => $answers, 'create_flag' => false]);
    }
}
