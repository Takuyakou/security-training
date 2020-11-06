@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">ユーザー一覧</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        {{ session()->forget('status') }}
                    @endif

                    {{-- @if ($flash_messages)
                        <div class="alert alert-success" role="alert">
                        {{ $flash_messages }}<br>
                        </div>
                    @endif --}}

                    <div class='table-responsive'>
                                    <table class="table table-striped table-bordered table-hover table-condensed">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-nowrap col-xs-1" scope="col">名前</th>
                                                <th class="text-nowrap col-xs-2" scope="col">メールアドレス</th>
                                                <th class="text-nowrap col-xs-1" scope="col">管理者</th>
                                                {{-- <th class="text-nowrap col-xs-1" scope="col">更新日時</th> --}}
                                                <th class="text-nowrap col-xs-1" scope="col"></th>
                                                <th class="text-nowrap col-xs-1" scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($users as $i => $user)
                                        <tbody>
                                            <tr>
                                                <td ~~~>{{optional($user)->name}}
                                                </td>
                                                <td ~~~>{{optional($user)->email}}
                                                </td>
                                                <td ~~~>
                                                  @if ($user->admin_flg == true)
                                                  <div class="form-group mx-sm-1 mb-1">
                                                  ○
                                                  </div>
                                                  @endif
                                                </td>
                                                {{-- <td ~~~>{{optional($user)->updated_at}}
                                                </td> --}}
                                                <td ~~~>
                                                    <div class="form-group mx-sm-1 mb-1 ml-2">
                                                      <a href="{{ route('admin.user.update.show',['user_id'=>$user->id]) }}">
                                                      <button type="submit" class="btn btn-outline-secondary">編集</button></a>
                                                    </div>
                                                </td>
                                                <td ~~~>
                                                    <form method="POST" action="{{ route('admin.user.delete') }}">
                                                    <div class="form-group mx-sm-1 mb-1">
                                                        <input type="hidden" value="{{optional($user)->id}}" name="user_id">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger">削除</button>
                                                    </form>
                                                </td>


                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>

                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="{{ route('admin.user.create.show') }}">ユーザー追加</a>
                                        </div>
                                    </div>
                                </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
