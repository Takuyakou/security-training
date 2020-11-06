@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">受験結果一覧</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        {{ session()->forget('status') }}
                    @endif

                    <div class='table-responsive'>
                                    <table class="table table-striped table-bordered table-hover table-condensed">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-nowrap col-xs-1" scope="col">名前</th>
                                                <th class="text-nowrap col-xs-2" scope="col">合否判定</th>
                                                <th class="text-nowrap col-xs-1" scope="col">受験日</th>
                                                <th class="text-nowrap col-xs-1" scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($useranswerresults as $i => $UserAnswerResult)
                                        <tbody>
                                            <tr>
                                                <td ~~~>{{optional($UserAnswerResult)->name}}
                                                </td>
                                                <td ~~~>
                                                  @if ($UserAnswerResult->pass_flg == true)
                                                  <div class="form-group mx-sm-1 mb-1">
                                                  ○
                                                  </div>
                                                  @else
                                                  <div class="form-group mx-sm-1 mb-1">
                                                  ×
                                                  </div>

                                                  @endif
                                                </td>
                                                <td ~~~>
                                                  {{optional($UserAnswerResult)->examination_at}}
                                                </td>
                                                <td ~~~>
                                                    <div class="form-group mx-sm-1 mb-1 ml-2">
                                                      <button type="submit" class="btn btn-outline-secondary">編集</button></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>

                                <div class="col-md-12">
                                    {{-- <div class="card">
                                        <div class="card-header">
                                            <a href="{{ route('admin.user.create.show') }}">ユーザー追加</a>
                                        </div>
                                    </div> --}}
                                </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
