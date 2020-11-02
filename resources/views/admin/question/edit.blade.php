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
                    @endif

                    @if($create_flag == true)
                    <div class="card-header">
                        問題追加画面
                    </div>
                    @endif
                    @if($create_flag == false)
                    <div class="card-header">
                        問題編集画面
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- 問題編集画面--}}




    {{-- 問題編集画面ここまで --}}

    {{-- 問題追加画面 --}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if($create_flag == true)
                    <form method="POST" action="{{ route('admin.question.create') }}">
                    @endif
                    @if($create_flag == false)
                    <form method="POST" action="{{ route('admin.question.update', $question) }}">
                    @endif
                        @csrf
                        <input type="hidden" value="{{ old('question_id',$question->id) }}" name="question_id">
                        <div class="mb-3">
                        問題文
                        </div>
                        <div class="form-group row">
                            <table class="table_form">
				                <tbody>
                                    <tr>
                                        <th class="col-form-label col-d-2"></th>
                                        <td>
                                            <textarea name="question_text" id="question_text" class="form-control" rows="9" cols="60" required>{{ old('question_text',$question->question_text) }}</textarea>
                                        </td>
                                    </tr>

                                </tbody>
			                </table>
                        </div>


                        <div class="form-group row">
                            <label for="password" class="col-form-label text-md-right ml-3">解答選択肢</label>


                                <table class="table">
                                    <thead>
                                        <tr>
                                        <th scope="col"></th>
                                        <th scope="col">答え文</th>
                                        <th scope="col">答え</th>
                                        </tr>
                                    </thead>


                                    @foreach ($answers as $i => $answer)
                                    <input type="hidden" value="{{ old('answer_id.'.$i,$answer->id) }}" name="answer_id[{{$i}}]">

                                    <tbody>
                                        <tr>
                                        <td>
                                            {{$i + 1}}
                                        </td>


                                        <td>

                                            <textarea name="answer_text[{{$i}}]"  class="form-control @error('answer_text.'.$i) is-invalid @enderror" rows="2" cols="14">{{ old('answer_text.'.$i,$answer->answer_text) }}</textarea>
                                        </td>
                                        <td>
                                            <select class="form-control custom-select col-md-6 @error('answer.'.$i) is-invalid @enderror" name="answer[{{$i}}]">
                                            <option value="" @if(old('answer.'.$i,$answer->answer)=='') selected  @endif></option>
                                            <option value="1" @if(old('answer.'.$i,$answer->answer)=='1') selected  @endif>正解</option>
                                            <option value="0" @if(old('answer.'.$i,$answer->answer)=='0') selected  @endif>不正解</option>
                                            </select>

                                        </td>
                                        </tr>
                                        <tr>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>



                        </div>






                        <div class="mb-3">
                        問題解説文
                        </div>
                        <div class="form-group row">
                            <table class="table_form">
				                <tbody>
                                    <tr>
                                        <th class="col-form-label col-d-2"></th>
                                        <td>
                                            <textarea name="commentary_text" id="commentary_text" class="form-control" rows="9" cols="60" required>{{ old('commentary_text', $question->commentary_text) }}</textarea>
                                        </td>
                                    </tr>

                                </tbody>
			                </table>
                        </div>



                        <div class="form-group row">
                            <label for="password" class="col-form-label text-md-right ml-3">問題区分</label>

                            <div class="col-md-6">
                                <select class="form-control custom-select" id="question_section" name="question_section">
                                <option value="1" @if(old('question_section',$question->question_section)=='1') selected  @endif >1: 単一解答問題</option>
                                <option value="2" @if(old('question_section',$question->question_section)=='2') selected  @endif>2: 複数解答問題</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="password" class=" col-form-label text-md-right ml-3">出題必須フラグ</label>


                            <div class="ml-3 form-check">
                                <input class="form-check-input" type="checkbox" id="check1a" value='1' name="required_flg" @if(old('required_flg',$question->required_flg)=='1') checked  @endif>
                                <label class=" form-check-label" name="required_flg" for="check1a">必須</label>

                            </div>
                        </div>


                        @if($create_flag == true)
                            <div class="form-group row mb-0 ml-1">
                                    <button type="submit" class="btn btn-outline-primary">追加</button>
                            </div>
                        @endif
                        @if($create_flag == false)
                            <div class="form-group row mb-0 ml-1">
                                    <button type="submit" class="btn btn-outline-success">更新</button>
                            </div>
                        @endif
                    </form>






                </div>

            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.question.list.show') }}">問題一覧</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- 問題追加画面ここまで --}}



</div>
@endsection
