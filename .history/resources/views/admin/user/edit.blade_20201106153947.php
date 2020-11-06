@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        {{ session()->forget('status') }}
                    @endif

                    @if($create_flag == true)
                    <div class="card-header">
                        ユーザー作成画面
                    </div>
                    @endif
                    @if($create_flag == false)
                    <div class="card-header">
                        ユーザー編集画面
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>


    {{-- ユーザー追加・編集画面 --}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if($create_flag == true)
                    <form method="POST" action="{{ route('admin.user.create') }}">
                    @endif
                    @if($create_flag == false)
                    <form method="POST" action="{{ route('admin.user.update' , $user) }}">
                    @endif
                        @csrf
                        <input type="hidden" value="{{ old('user_id',$user->id) }}" name="user_id">

                        <div class="form-group row">
                            <label for="fullname" class="col-md-4 col-form-label text-md-right">氏名</label>

                            <div class="col-md-6">
                                <input id="fullname" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required >

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">管理者フラグ</label>


                            <div class="col-md-6 ml-4 mt-1">
                                <input class="form-check-input" type="checkbox" id="check1a" value='1' name="admin_flg" @if(old('admin_flg',$user->admin_flg)=='1') checked  @endif>
                                <label class=" form-check-label" name="admin_flg" for="check1a">管理者</label>

                            </div>
                        </div>



                        @if($create_flag == true)
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">作成</button>
                            </div>
                        </div>
                        @endif
                        @if($create_flag == false)
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-outline-success">更新</button>
                            </div>
                        </div>
                        @endif
                    </form>

                </div>

            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.user.list.show') }}">ユーザー一覧</a>
                    </div>
                </div>
            </div>
        </div>

    </div>



</div>
@endsection
