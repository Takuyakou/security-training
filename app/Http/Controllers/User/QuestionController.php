<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth; // 追加
use Illuminate\Support\Facades\DB; // 追加
use Carbon\Carbon; // 追加

class QuestionController extends Controller
{


    /**
     * 問題を開始する
     */
    public function questionStart(Request $request)
    {
        // 出題問題数を取得
        $questionNum = $request->questionNum;

        // フラグが(required_flg)がonのものだけランダム取得
        $flgOnQuestions = \App\Models\Question::inRandomOrder()->where('required_flg', 1)->whereNull('deleted_at')->get();

        // フラグが(required_flg)がoffの問題で必要な数を計算する
        $flgOffCount = $questionNum - count($flgOnQuestions);

        // フラグが(required_flg)がoffのものを必要な数ランダム取得
        $flgOffQuestions = \App\Models\Question::inRandomOrder()->take($flgOffCount)->where('required_flg', 0)->whereNull('deleted_at')->get();

        //　取得した問題をまとめる
        $questions = $flgOnQuestions->concat($flgOffQuestions);

        foreach ($questions as $q) {
            $answers = \App\Models\Answer::where('question_id', $q->id)->get();
            $q->answers = $answers;
        }

        return view('user.question.answer_form', ['questions' => $questions, 'questionNum' => $questionNum]);
    }


    /**
     * 提出された問題の答えを判定
     */
    public function questionAnswer(Request $request)
    {

        $id = DB::transaction(function () use ($request) {
            // 解答ヘッダテーブルに情報を入れる
            // ログイン中のユーザーID取得
            $user_id = Auth::id();
            $user_answer_headers = new \App\Models\UserAnswerHeader;
            $user_answer_headers->user_id = $user_id;
            $user_answer_headers->examination_at = Carbon::now();
            $user_answer_headers->pass_flg = false;
            $user_answer_headers->save();


            // 解答明細テーブルに情報を入れる
            // 問題数の数だけ回す
            foreach ($request->question_id as $i => $q) {
                $user_answer_details = new \App\Models\UserAnswerDetail;
                // ヘッダーIDを入れる
                $user_answer_details->header_id = $user_answer_headers->id;
                // 問題IDを入れる
                $user_answer_details->question_id = $q;
                // クエスチョンNO入れる
                $user_answer_details->question_number = $i + 1;

                // 問題の答え数を取得
                $answerNum = \App\Models\Answer::where('question_id', $q)->count();

                $correct_cnt = 0;
                // 答えの数だけ回す
                for ($n = 0; $n < $answerNum; $n++) {
                    // チェックしたものだけ


                    if (isset($request->answer_flg[$i][$n])) {
                        // 答えIDが既にテーブルに存在する場合、結合して入れる
                        if (\App\Models\UserAnswerDetail::where('question_id', $q)->where('header_id', $user_answer_headers->id)->value('answer_id')) {
                            $question_record = \App\Models\UserAnswerDetail::where('question_id', $q)->where('header_id', $user_answer_headers->id)->value('answer_id');

                            $user_answer_details->answer_id = $question_record . "," . strval($request->answer_id[$i][$n]);
                        } else {
                            // 答えidを入れる
                            $user_answer_details->answer_id = $request->answer_id[$i][$n];
                        }

                        // 問題の正解の数を数える
                        $question_collect = \App\Models\Answer::where('answer', 1)->where('question_id', $q)->count();


                        // チェックした答えのレコードを抽出する
                        $answers = \App\Models\Answer::where('id', $request->answer_id[$i][$n])->value('answer');

                        // 解答の正誤判定を行う
                        if (\App\Models\Question::where('id', $q)->whereNull('deleted_at')->value('question_section') == "1") {
                            // 単一解答問題
                            if ($answers == true) {
                                $user_answer_details->judgment = true;
                                $user_answer_details->save();
                            } else {
                                $user_answer_details->judgment = false;
                                $user_answer_details->save();
                            }
                        } else {
                            // 複数解答問題
                            if ($answers == true) {
                                $correct_cnt++;
                                if ($question_collect == $correct_cnt) {
                                    $user_answer_details->judgment = true;
                                    $user_answer_details->save();
                                } else {
                                    $user_answer_details->judgment = false;
                                    $user_answer_details->save();
                                }
                            } else {
                                $user_answer_details->judgment = false;
                                $user_answer_details->save();
                            }
                        }
                    }
                }
            }
            return $user_answer_headers->id;
        });


        $userAnswerDetails = \App\Models\UserAnswerDetail::where('header_id', $id)->join('questions', 'questions.id', '=', 'user_answer_details.question_id')->get();

        foreach ($userAnswerDetails as $uad) {
            // ユーザーの答えたものを取得
            $answerText = '';
            foreach (preg_split('/\,/', $uad->answer_id) as $answer_id) {
                $ans = \App\Models\Answer::find($answer_id);
                if ($ans) {
                    if ($answerText === '') {
                        $answerText = $ans->answer_text;
                    } else {
                        $answerText .= '、 ' . ' '  . $ans->answer_text;
                    }
                }
            }
            $uad->answer_text = $answerText;

            $answers = \App\Models\Answer::where('question_id', $uad->question_id)->where('answer', true)->get();
            $uad->answers = $answers;
        }

        // 問題数
        $question_cnt = count($userAnswerDetails);
        // 問題の正解数を取得
        $user_collect_num = \App\Models\UserAnswerDetail::where('judgment', true)->where('header_id', $id)->count();

        $judg = ($user_collect_num / $question_cnt) * 100;

        // ヘッダー取得
        $UserAnswerheader = \App\Models\UserAnswerHeader::find($id);

        // 問題の合格、不合格を判定(9割以上で合格)
        if (round($judg) < 90) {

            $pass_flag = false;
        } else {
            $UserAnswerheader->pass_flg = true;
            $UserAnswerheader->save();
            $pass_flag = true;
        }


        session()->flash('status', '解答の送信が完了しました');
        return view('user.question.result', ['user_collect_num' => $user_collect_num, 'userAnswerDetails' => $userAnswerDetails, 'pass_flag' => $pass_flag]);
    }
}
