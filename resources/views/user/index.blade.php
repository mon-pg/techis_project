@extends('adminlte::page')

@section('title', 'Stock Shelf')

@section('content_header')
    @if (session('alertMessage'))
        <div class="alert alert-danger text-center mx-auto">
            {{ session('alertMessage') }}
        </div> 
    @endif
    <h1>ユーザー管理一覧</h1>
@stop

@section('content')

    @if(session('selectError'))
        <p class="error-msg-search">{{ session('selectError') }}</p>
    @endif
    @include('user.search')

    @if(isset($users) && count($users) > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                <form action="{{ url('/users/someEdit/view') }}" method="post">
                    @csrf
                    <div class="card-header d-flex">
                        @if($auth_user->role == 1||$auth_user->role == 2)
                            <button type="submit" class="btn btn-primary">一括編集</button>
                            @if(isset($selectError))
                            <p>{{ $selectError }}</p>
                            @endif                        
                        @endif
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    @if($auth_user->role == 1 || $auth_user->role == 2)
                                    <th>
                                        <div class="d-inline-flex flex-row-reverse mx-auto">
                                            <input class="form-check-input select-user" type="checkbox" id="all">
                                            <label class="form-check-label mr-3 select-user" for="all">
                                                選択
                                            </label>
                                        </div>
                                    </th>
                                    @endif
                                    <th class="sort-link">@sortablelink('id', 'ID')</th>
                                    <th>氏名</th>
                                    <th class="sort-link">@sortablelink('role', '権限')</th>
                                    <th class="sort-link">@sortablelink('department', '部署')</th>
                                    <th class="sort-link">@sortablelink('email', 'メールアドレス')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        
                                        @if($auth_user->role == 1||$auth_user->role == 2)
                                        <td><input type="checkbox" class="user-check select-user" name="user-check[]" value="{{ $user->id }}"></td>         
                                        @endif
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            @if($auth_user->role == 1||$auth_user->role == 2 ||$auth_user->id == $user->id)
                                                <a href="{{ url('/users/edit/'.$user->id) }}">{{ $user->name }}</a>
                                            @else
                                                <p>{{ $user->name }}</p>
                                            @endif
                                        </td>
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
                    <div class="card-footer">
                    {{ $users->appends(request()->query())->links('vendor.pagination.StockShelf') }}  
                    
                    </div>
                    
                    
                </form>
                </div>
            </div>
        </div>
    @endif
    @if(isset($noUser))                    
            <h4 class="ms-2">{{$noUser}}</h4>
    @endif
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
@stop

@section('js')
<script src="{{ asset('js/user.js') }}"></script>
@stop

