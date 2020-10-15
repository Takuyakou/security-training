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

                <div class="card-body">
                    <li><a href="{{ route('admin.question.list.show') }}">問題一覧</a></li>
                    <li><a href="{{ route('admin.question.create.show') }}">問題追加</a></li>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
