@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    管理者用<br>
                    You are logged in!

                    <li><a href="{{ route('admin.question.list.show') }}">問題一覧</a></li>
                    <li><a href="{{ route('admin.question.create.show') }}">問題追加</a></li>

                    <form method="POST" action="{{ route('admin.question.number.change') }}">
                    @csrf
                        <div class="mt-2">
                            <p>出題問題数</p>
                            <select class="form-control custom-select col-md-2" name="questionNum"">
                                <option value="{{ config('app.NUMBER_OF_QUESTIONS') }}" selected >{{ config('app.NUMBER_OF_QUESTIONS') }}</option>
                                @for ($i = $flgOnQuestions; $i < 26; $i++)
                                    <option value={{$i}}>{{$i}}</option>
                                @endfor
                            </select>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-outline-primary">問題数変更</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
