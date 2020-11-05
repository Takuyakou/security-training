@extends('layouts.user.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    {{-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif --}}

                    {{-- <label class="col-form-label text-md-right ml-3">試験結果テスト用</label> --}}
                    <p class="lead">試験結果</p>
                    <p class="text-center"><b><font size="4" color="red">{{$user_collect_num}}点</font></b> / {{count($userAnswerDetails)}}点</p>

                    @if ($pass_flag == true)
                    <p class="text-center lead">合格！...お見事です。</p>
                    @else
                    <p class="text-center lead">もう一歩...再度挑戦しましょう。</p>
                    @endif
                                <div class='table-responsive'>
                                    <table id='ghibuli-table' class='table table-bordered table-striped table-hover' style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-nowrap col-xs-1" scope="col" style="width:75px;"></th>
                                                <th class="text-nowrap col-xs-3" scope="col"></th>
                                                <th class="text-nowrap col-xs-2" scope="col">答え</th>
                                                <th class="text-nowrap col-xs-2" scope="col">選んだ答え</th>
                                            </tr>
                                        </thead>
                                        @foreach ($userAnswerDetails as $i => $uad)
                                        <tbody>
                                            <tr onclick="show_hide_row('hidden_row-{{$i+1}}');" @if ($uad->judgment == true) class="table-success result-box" @else class="table-danger result-box" @endif>
                                                <td ~~~>
                                                問{{$i+1}}
                                                @if ($uad->judgment == true)
                                                ○
                                                @else
                                                ×
                                                @endif
                                                </td>
                                                <td ~~~ class="col-xs-2">
                                                    {{$uad->question_text}}
                                                </td>

                                                <td ~~~ height="100" class="col-xs-2">
                                                    @foreach ($uad->answers as $ans)
                                                        @if (!$loop->first)
                                                        、
                                                        @endif
                                                        {{$ans->answer_text}}
                                                    @endforeach
                                                </td>
                                                <td ~~~ class="col-xs-2">
                                                    {{$uad->answer_text}}
                                                </td>

                                            </tr>

                                            <tr class="hidden_row hidden_row-{{$i+1}}">
                                                <td colspan="5">
                                                    <table style="width:100%;font-size:13px;">
                                                        <tr>
                                                            <td>{{$uad->commentary_text}}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>


                                @if ($pass_flag == true)
                                    <div class="form-group row justify-content-center">
                                        <button type="submit" class="btn btn-outline-primary training-end-btn w-25">研修完了</button>
                                    </div>
                                @else
                                    <div class="form-group row justify-content-center">
                                        <button type="submit" class="btn btn-outline-danger w-25">再試験</button>
                                    </div>
                                @endif


                </div>
                <p class="text-center lead training-end-text">研修終了...お疲れ様でした。</p>

            </div>
        </div>
    </div>
</div>

<script>

// デフォルトで非表示にする
$(function(){
    $('.hidden_row').hide();
    $('.training-end-text').hide();
});

function show_hide_row(row) {
  $("." + row).toggle();
}


$('.training-end-btn').on('click', function () {
    $('.card-body').hide();
    $('.training-end-text').show();

});


</script>
@endsection
