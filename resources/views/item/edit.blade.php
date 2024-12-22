@extends('adminlte::page')

@section('title', 'StockShelf')

@section('content_header')
<div class="text-center">
    <div class="row">
        <div class="col col-sm-auto"><!-- TODO:バリデーションかかったときどうする？homeから飛んだ時どうする？ -->
            <a href="#" class="btn-back" onclick="history.back()">戻る</a>
        </div>
        <h1 class="col-md-auto">商品編集</h1>
    </div>
</div>
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
        <div class="col col-sm-auto"></div>
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
                        <div class="form-group-clm">
                            <div class="form-title"><label class="form-label" for="name">タイトル</label><p class="validation-mark align-self-start">*</p></div>
                            <input type="text" class="form-control form-text" id="name" name="name" placeholder="タイトルを入力" value="{{ old('name', $item->name) }}">
                        </div>

                        <div class="form-group-row ">
                            <div class="form-title"><label class="form-label" for="">ジャンル</label><p class="validation-mark align-self-start">*</p></div>
                            <select class="form-select" id="type" name="type">
                                <option value="{{ old('type', $item->type) }}" selected>{{$types[$item->type]}}</option>
                                <option value="1">RPG</option>
                                <option value="2">対戦</option>
                                <option value="3">育成</option>
                                <option value="4">パーティ</option>
                                <option value="5">その他</option>
                            </select>
                        </div>
                        <div class="form-group-row ">
                            <div class="form-title"><label class="form-label" for="">販売状況</label><p class="validation-mark align-self-start">*</p></div>
                            <select class="form-select" id="salesStatus" name="salesStatus">
                                <option value="{{ old('salesStatus', $item->salesStatus) }}" selected>{{$sales[$item->salesStatus]}}</option>
                                <option value="3">発売予定</option>
                                <option value="1">販売中</option>
                                <option value="2">生産終了</option>                                
                            </select>
                        </div>
                        <div class="form-group-row">
                            <div class="form-title"><label class="form-label" for="">発売日</label><p class="validation-mark align-self-start">*</p></div>
                            <input type="date" class="form-control form-date" id="salesDate" name="salesDate" value="{{ old('salesDate', $item->salesDate ? $item->salesDate->format('Y-m-d') : '') }}">
                        </div>

                        <div class="form-group-clm">
                            <div class="form-title"><label class="form-label" for="detail">商品紹介</label></div>
                            <textarea class="form-control form-text" name="detail" id="detail" placeholder="商品紹介文を入力">{{ old('detail', $item->detail) }}</textarea>
                        </div>

                        
                        <div class="stock-form">
                            <div class="form-group-row">
                                <div class="stock-title"><label class="form-label" for="detail">在庫数</label><p class="validation-mark align-self-start">*</p></div>
                                <input type="text" class="form-control stock-num" id="stock" name="stock" placeholder="{{$item->stock}}" value="{{ old('stock', $item->stock) }}">
                                <p class="stock-unit">個</p>
                            </div>

                            @if($auth_user->role == 1)
                            <div class="form-group-row">
                                <div class="stock-title"><label class="form-label" for="detail">基準在庫数</label><p class="validation-mark align-self-start">*</p></div>
                                <input type="text" class="form-control stock-num" id="sdStock" name="sdStock" value="{{ old('sdStock', $item->sdStock) }}">
                                <p class="stock-unit">個</p>
                            </div>
                            @else
                            <div class="form-group-row">
                                <div class="stock-title"><label class="form-label" for="detail">基準在庫数</label></div>
                                <input type="text" class="form-control stock-num" value="{{ $item->sdStock }}" readonly>
                                <input type="hidden" class="form-control" id="sdStock" name="sdStock" value="{{ $item->sdStock }}" >
                                <p class="stock-unit">個</p>
                            </div>
                            @endif
                        </div>
                        
                    </div>

                    <div class="card-footer d-flex flex-column-reverse">
                        <div class="form-group-row form-memo">
                            <label class="form-label" for="memo">メモ</label>
                            <input type="text" name="memo" id="memo" class="form-control" placeholder="特記事項があれば入力" value="{{ old('memo') }}">
                        </div>
                        <div class="btns">
                            <button type="submit" class="btn btn-primary">更新</button>
                            @if($auth_user->role == 1)
                            <a href="#" class="btn btn-danger btn-delete-confirm" data-toggle="modal" data-target="#deleteModal" data-url="{{ url('/items/delete/'.$item->id) }}" data-id="{{ $item->id }}" > 削除 </a>
                            @endif
                        </div>
                        
                    </div>
                </form>
            </div>

            <h2>更新ログ</h2>
            <div class="container">
                @if(isset($logs) && count($logs)>0)
                <div class="d-flex flex-column">
                    @foreach($logs as $log)
                    <div class="d-flex flex-wrap gap-2 log-area">
                        <div class="align-self-start">{{ $log->created_at->format('Y/m/d') }}</div>
                        <div class="flex-grow-1">
                            <p>
                                {{ $logUsers[$log->id][$log->user_id] }}さんが、
                                {{ implode('・', $log->action) }}
                                を変更しました。
                            </p>
                            @if(isset($log->memo))
                            <p>メモ：{{ $log->memo }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p>ログがありません。</p>
                @endif
            </div>
            
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
@stop

@section('js')
<script src="{{ asset('js/edit.js') }}"></script>
@stop
