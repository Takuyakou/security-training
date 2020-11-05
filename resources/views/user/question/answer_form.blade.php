@extends('layouts.user.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">問題</div>
                <form method="POST" action="{{ route('user.question.answer') }}" id="answer_form">
                    @csrf
                    @foreach ($questions as $i => $q)
                        <div id="question-{{$i+1}}" style="display:none">
                            <div>Q{{$i+1}}/ {{$questionNum}}</div>
                            <div>{{$q->question_text}}
                                @if($q->question_section == 2)
                                (複数回答問題)
                                @endif
                            </div>

                            <div>
                                    @foreach ($q->answers as $n => $ans)
                                        <div class="form-check mr-1 mt-2 bg-secondary text-white">
                                            @if($q->question_section == 1)
                                            <label for="check-answer-{{$i+1}}-{{$n}}">
                                            @else
                                            <label for="check-answered-{{$i+1}}-{{$n}}">
                                            @endif
                                            <input class="form-check-input single-question-{{$i+1}}" type="checkbox" value='1' name="answer_flg[{{$i}}][{{$n}}]"
                                            @if($q->question_section == 1) id="check-answer-{{$i+1}}-{{$n}}" @else id="check-answered-{{$i+1}}-{{$n}}"
                                            @endif>

                                            {{$ans->answer_text}}</label>
                                            {{-- 答えid送信用 --}}
                                            <input type="hidden" value="{{ old('answer_id.'.$n,$ans->id) }}" name="answer_id[{{$i}}][{{$n}}]">
                                        </div>
                                    @endforeach
                                    {{-- 問題id送信用 --}}
                                    <input type="hidden" value="{{ old('question_id.'.$i,$q->id) }}" name="question_id[{{$i}}]">

                                    <div class="mt-2">
                                        <button class="btn btn-primary mr-1 answer-btn" type="button">解答する</button>
                                    </div>


                            </div>
                        </div>
                    @endforeach

                </form>

            </div>
        </div>
    </div>
</div>

<script>
var questionCnt = 1;
// 選択した問題数
var questionNum = {{$questionNum}};


$(function(){
    $('#question-' + questionCnt).show();
});


// 単一問題の時、一つしかチェックされないようにする
$('input[id^=check-answer-]').on("change", function(){
        $('.single-question-' + questionCnt).prop('checked', false);  // チェックを外す
        $(this).prop('checked', true);  //  押したやつだけチェックつける
});


// ボタンを押した時の処理
$('.answer-btn').on('click', function () {

    var check_count = $('#question-' + questionCnt).find(".form-check :checked").length;
    if (check_count == 0){
        alert('チェックされていません');
        return false;
    }

    // 最後だったら
    if (questionCnt == questionNum) {
        // 溜め込んだ問題と答えをサーバへ
        $('#answer_form').submit();
    }

    $('#question-' + questionCnt).hide();
    questionCnt++;
    $('#question-' + questionCnt).show();

});

</script>

@endsection
