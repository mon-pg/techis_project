@extends('adminlte::page')

@section('title', 'ユーザー管理')

@section('content_header')
    <h1>ユーザー管理一覧</h1>
@stop

@section('content')

@include('user.search')


    <div class="row">
        <div class="col-12">
            <div class="card">            
                <div class="card-header d-flex">
                    <button onclick="" class="btn btn-primary">一括編集</button>   
                    <a href="/users/someEdit" class="btn btn-primary">一括編集テスト</a>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>
                                    <div class="d-inline-flex flex-row-reverse mx-auto">
                                        <input class="form-check-input select-user" type="checkbox" id="all">
                                        <label class="form-check-label mr-3 select-user" for="all">
                                            選択
                                        </label>
                                    </div>
                                </th>
                                <th>ID</th>
                                <th>名前</th>
                                <th>権限</th>
                                <th>部署</th>
                                <th>メールアドレス</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-center"><input type="checkbox" class="user-check select-user" name="user-check[]" value="{{ $user->id }}"></td>
                                
                                    <td>{{ $user->id }}</td>
                                    <td><a href="{{ url('/users/edit/'.$user->id) }}">{{ $user->name }}</a></td>
                                    <td>{{ $roles[$user->role] }}</td>
                                    <td> 
                                        @if($user->department >= 1)
                                            {{ $departments[$user->department] }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stop

@section('js')
<script src="{{ asset('js/user.js') }}"></script>
@stop

