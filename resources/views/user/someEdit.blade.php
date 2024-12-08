@extends('adminlte::page')

@section('title', '権限一括編集')

@section('content_header')
    <h1>権限一括編集</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">            
                <div class="card-header d-flex">
                    <button onclick="" class="btn btn-primary">一括編集</button>   
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
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
                                    <td>{{ $user->id }}</td>
                                    <td><a href="{{ url('/users/'.$user->id) }}">{{ $user->name }}</a></td>
                                    <td> <select name="role" id="role">
                                            <option selected>権限</option>
                                            <option value="1">管理者</option>
                                            <option value="2">編集者</option>
                                            <option value="3">閲覧者</option>
                                    </select> </td>
                                    <td> $user->department </td>
                                    <td> $user->mail </td>
                                    
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

