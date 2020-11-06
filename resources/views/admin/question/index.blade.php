@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    問題一覧
                    <div class='table-responsive'>
                                    <table class="table table-striped table-bordered table-hover table-condensed">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-nowrap col-xs-1" scope="col">問題文</th>
                                                <th class="text-nowrap col-xs-2" scope="col">問題解説文</th>
                                                <th class="text-nowrap col-xs-1" scope="col">登録日時</th>
                                                <th class="text-nowrap col-xs-2" scope="col">更新日時</th>
                                                <th class="text-nowrap col-xs-1" scope="col"></th>
                                                <th class="text-nowrap col-xs-1" scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($questions as $i => $question)
                                        <tbody>
                                            <tr>
                                                <td ~~~>{{optional($question)->question_text}}
                                                </td>
                                                <td ~~~>{{optional($question)->commentary_text}}
                                                </td>
                                                <td ~~~>{{optional($question)->created_at}}
                                                </td>
                                                <td ~~~>{{optional($question)->updated_at}}
                                                </td>
                                                <td ~~~>
                                                    <div class="form-group mx-sm-1 mb-1">
                                                        <a href="{{ route('admin.question.update.show',['question_id'=>$question->id]) }}"><button type="submit" class="btn btn-outline-secondary">編集</button></a>
                                                    </div>
                                                </td>
                                                <td ~~~>
                                                    <form method="POST" action="{{ route('admin.question.delete') }}">
                                                    <div class="form-group mx-sm-1 mb-1">

                                                        <input type="hidden" value="{{optional($question)->id}}" name="question_id">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger">削除</button>
                                                    </form>
                                                </td>


                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.question.create.show') }}">問題追加</a>
                </div>


            </div>
        </div>
    </div>
</div>

@endsection
