@extends('adminlte::page')

@section('title', '商品編集')

@section('content_header')
    <h1>商品編集</h1>
@stop

@section('content')
<!-- modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-pledby="basicModal" aria-hidden="true" >
    <form role="form" class="form-inline" method="post" action="">
    @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalp">削除確認</h4>
                </div>
                <div class="modal-body">
                    <p class="delete-message">本当に削除しますか？</p>
                    <p class="none-message">※削除をすると、更新ログの名前も表示されなくなりますので、ご留意ください。</p>

                </div>
                <div class="modal-footer">                    
                    <button type="submit" class="btn btn-danger btn-delete-confirm">削除</button>
                    <a class="btn btn-light" data-dismiss="modal">閉じる</a>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- body -->
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                       @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                       @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <form method="POST">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="form-group">
                            <p>名前：{{ $user->name }}</p>
                            <input type="hidden" class="form-control" id="name" name="name" value="{{ $user->name }}">
                        </div>
                    
                        <div class="form-group">
                            <p>権限：</p>
                            @if($auth_user->role == 1 && $auth_user->id !== $user->id)
                                <select class="form-select" id="role" name="role">
                                    <option value="{{ old('role',$user->role) }}" selected>{{ $roles[$user->role] }}</option>
                                    <option value="1">管理者</option>
                                    <option value="2">編集者</option>
                                    <option value="3">閲覧者</option>
                                </select>
                            @else
                                <p>{{ $roles[$user->role] }}</p>
                                <input type="hidden" name="role" value="{{ $user->role }}">
                            @endif
                        </div>

                        <div class="form-group">
                            <p>部署：</p>
                            <select class="form-select" id="department" name="department">
                                @if(!empty($user->department))
                                    <option value="{{ old('department', $user->department) }}" selected>{{ $departments[$user->department] }}</option>
                                @else
                                    <option selected>部署を選択</option>
                                @endif
                                <option value="1">商品管理部</option>
                                <option value="2">営業部</option>
                                <option value="3">商品開発部</option>
                                <option value="4">その他</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <p>メールアドレス：{{ $user->email }}</p>
                            <input type="hidden" class="form-control" id="email" name="email" value="{{ $user->email }}">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">更新</button>
                        <a href="#" class="btn btn-danger btn-delete-confirm" data-toggle="modal" data-target="#deleteModal" data-url="{{ url('/users/delete/'.$user->id) }}" data-id="{{ $user->id }}" > 削除 </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
<script src="{{ asset('js/edit.js') }}"></script>
@stop
