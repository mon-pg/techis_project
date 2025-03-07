@extends('adminlte::page')

@section('title', 'Stock Shelf')

@section('content_header')
<div class="text-center">
    <div class="row">
        <div class="col col-sm-auto">
            <a href="{{ url('/users') }}" class="btn-back">戻る</a>
        </div>
        <h1 class="col-md-auto">一括編集</h1>
    </div>
</div>
@stop

@section('content')

    <div class="row">
        <div class="col-sm-auto"></div>
        <div class="col-md-10">
        <form action="{{ url('/users/someEdit') }}" method="post">
        @csrf
            <div class="card">            
                <div class="card-header d-flex">
                    <input type="submit" class="btn btn-primary" value="一括保存">
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>氏名</th>
                                <th>権限</th>
                                <th>部署</th>
                                <th>メールアドレス</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                <input type="hidden" name="user_id[]" value="{{ $auth_user->id }}">
                                <input type="hidden" name="target_id[]" value="{{ $user->id }}">
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td> 
                                        @if( $auth_user->role == 1 && $auth_user->id !== $user->id)
                                            <select name="role[]">
                                                <option value="{{ $user->role }}" selected>{{ $roles[$user->role] }}</option>
                                                <option value="1">管理者</option>
                                                <option value="2">編集者</option>
                                                <option value="3">閲覧者</option>
                                            </select>
                                        @else
                                            {{$roles[$user->role]}}
                                            <input type="hidden" name="role[]" value="{{ $user->role }}" >
                                        @endif
                                    </td>
                                    <td>
                                        @if($auth_user->role == 1||$auth_user->role == 2)
                                            <select name="department[]">
                                                @if(!empty($user->department))
                                                    <option value="{{ $user->department }}" selected>{{ $departments[$user->department] }}</option>                                                    
                                                @else
                                                    <option selected>部署を選択</option>
                                                @endif
                                                <option value="1">商品管理部</option>
                                                <option value="2">営業部</option>
                                                <option value="3">商品開発部</option>
                                                <option value="4">その他</option>
                                            </select>
                                        @else
                                            {{ $departments[$user->department] }}
                                        @endif
                                        
                                    </td>
                                    <td> {{$user->email}} </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
        </div>
    </div>
    
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
@stop

@section('js')
<script src="{{ asset('js/user.js') }}"></script>
@stop

