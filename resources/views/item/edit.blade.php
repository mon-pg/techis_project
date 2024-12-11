@extends('adminlte::page')

@section('title', '商品編集')

@section('content_header')
    <h1>商品編集</h1>
@stop

@section('content')
<!-- modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <form role="form" class="form-inline" method="post" action="">
    @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">削除確認</h4>
                </div>
                <div class="modal-body">
                    <p class="delete-message">本当に削除しますか？</p>
                    <p class="none-message"></p>

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
                        <input type="hidden" name="user_id" id="user_id" value="{{ $auth_user->id }}" >
                        <div class="form-group">
                            <div class="d-inline-flex"><label for="name">タイトル</label><p class="validation-mark align-self-start">*</p></div>
                            <input type="text" class="form-control" id="name" name="name" placeholder="タイトル" value="{{ old('name', $item->name) }}">
                        </div>

                        <div class="form-group d-flex">
                            <div class="d-inline-flex"><label for="">ジャンル</label><p class="validation-mark align-self-start">*</p></div>
                            <select class="form-select" id="type" name="type">
                                <option value="{{ old('type', $item->type) }}" selected>{{$types[$item->type]}}</option>
                                <option value="1">RPG</option>
                                <option value="2">対戦</option>
                                <option value="3">育成</option>
                                <option value="4">パーティ</option>
                                <option value="5">その他</option>
                            </select>
                        </div>
                        <div class="form-group d-flex">
                            <div class="d-inline-flex"><label for="">販売状況</label><p class="validation-mark align-self-start">*</p></div>
                            <select class="form-select" id="salesStatus" name="salesStatus">
                                <option value="{{ old('salesStatus', $item->salesStatus) }}" selected>{{$sales[$item->salesStatus]}}</option>
                                <option value="3">発売予定</option>
                                <option value="1">販売中</option>
                                <option value="2">生産終了</option>                                
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="d-inline-flex"><label for="">発売日</label><p class="validation-mark align-self-start">*</p></div>
                            <input type="date" class="form-control" id="salesDate" name="salesDate" value="{{ old('salesDate', $item->salesDate ? $item->salesDate->format('Y-m-d') : '') }}">
                        </div>

                        <div class="form-group">
                            <label for="detail">商品紹介</label>
                            <input type="text" class="form-control" id="detail" name="detail" placeholder="商品紹介" value="{{ old('detail', $item->detail) }}">
                        </div>

                        
                        <div class="d-flex gap-1">
                            <div class="form-group d-flex">
                                <div class="d-inline-flex"><label for="detail">在庫数</label><p class="validation-mark align-self-start">*</p></div>
                                <input type="text" class="form-control" id="stock" name="stock" placeholder="{{$item->stock}}" value="{{ old('stock', $item->stock) }}">
                                <p>個</p>
                            </div>

                            @if($auth_user->role == 1)
                            <div class="form-group d-inline-flex">
                                <div class="d-inline-flex"><label for="detail">基準在庫数</label><p class="validation-mark align-self-start">*</p></div>
                                <input type="text" class="form-control" id="sdStock" name="sdStock" value="{{ old('sdStock', $item->sdStock) }}">
                                <p>個</p>
                            </div>
                            @else
                            <div class="form-group d-flex">
                                <label for="detail">基準在庫数</label>
                                <input type="text" class="form-control" value="{{ $item->sdStock }}" readonly>
                                <input type="hidden" class="form-control" id="sdStock" name="sdStock" value="{{ $item->sdStock }}" >
                                <p>個</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">更新</button>
                        @if($auth_user->role == 1)
                        <a href="#" class="btn btn-danger btn-delete-confirm" data-toggle="modal" data-target="#deleteModal" data-url="{{ url('/items/delete/'.$item->id) }}" data-id="{{ $item->id }}" > 削除 </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stop

@section('js')
<script src="{{ asset('js/edit.js') }}"></script>
@stop
