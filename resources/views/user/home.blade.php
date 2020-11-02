@extends('layouts.user.app')

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
                    ユーザー用
                    You are logged in!
                </div>



                <form method="GET" action="{{ route('user.question.start',['pageId'=> 0]) }}">
                @csrf

                <div class="card-body">
                    {{-- <div class="row">
                        <div class="col-md">
                            <p>出題問題数（テスト用）</p>
                            <select class="form-control custom-select col-md-3" name="questionNum"">
                                <option value="3" selected >3</option>
                                @for ($i = 4; $i < 16; $i++)
                                    <option value={{$i}}>{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div> --}}

                    <div class="form-group row justify-content-center">
                        <input type="hidden" value="{{ config('app.NUMBER_OF_QUESTIONS') }}" name="questionNum">
                        <button type="submit" class="btn btn-outline-primary training-end-btn w-50">問題開始</button>
                    </div>
                </div>



                {{-- <div class="card-body">
                    <div class="row">
                        <div class="col-md">
                            <button type="submit" class="btn btn-outline-primary training-end-btn w-25">問題開始</button>
                        </div>
                    </div>
                </div> --}}

                </form>

            </div>

        </div>
    </div>

</div>
@endsection
