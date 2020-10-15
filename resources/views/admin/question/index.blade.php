@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    {{-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif --}}

                    問題一覧

                    <table class="table table-hover">
                        <thead class="thead-light">
                            <th>問題文</th>
                            <th>問題解説文</th>
                            <th>登録日時</th>
                            <th>更新日時</th>
                            <th></th>


                        </thead>
                        @foreach ($questions as $question)
                        <tbody>
                            <tr>
                                <td>{{optional($question)->question_text}}
                                </td>
                                <td>{{optional($question)->commentary_text}}
                                </td>
                                <td>{{optional($question)->created_at}}
                                </td>
                                <td>{{optional($question)->updated_at}}
                                </td>



                                <td>
                                    <div class="form-group row mb-0 ml-1">
                                        <a href="{{ route('admin.question.update.show',['question_id'=>$question->id]) }}"><button type="submit" class="btn btn-outline-secondary">編集</button></a>
                                    </div>
                                </td>


                            </tr>
                        </tbody>
                        @endforeach
                    </table>
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
