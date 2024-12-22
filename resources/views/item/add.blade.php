@extends('adminlte::page')

@section('title', 'StockShelf')

@section('content_header')
<div class="text-center">
    <div class="row">
        <div class="col col-sm-auto">
            <a href="{{ url('/items') }}" class="btn-back">戻る</a>
        </div>
        <h1 class="col-md-auto">商品登録</h1>
    </div>
</div>
@stop

@section('content')
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
                            <div class="form-title"><label class="form-label" for="title">タイトル</label><p class="validation-mark align-self-start">*</p></div>
                            <input type="text" class="form-control form-text" id="title" name="title" placeholder="タイトルを入力" value="{{ old('title') }}">
                        </div>

                        <div class="form-group-row ">
                            <div class="form-title"><label class="form-label" for="">ジャンル</label><p class="validation-mark align-self-start">*</p></div>
                            <select class="form-select" id="type" name="type">
                                <option disabled {{ old('type') === null ? 'selected' : '' }}>ジャンルを選択</option>
                                <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>RPG</option>
                                <option value="2" {{ old('type') == 2 ? 'selected' : '' }}>対戦</option>
                                <option value="3" {{ old('type') == 3 ? 'selected' : '' }}>育成</option>
                                <option value="4" {{ old('type') == 4 ? 'selected' : '' }}>パーティ</option>
                                <option value="5" {{ old('type') == 5 ? 'selected' : '' }}>その他</option>
                            </select>
                        </div>
                        <div class="form-group-row ">
                            <div class="form-title"><label class="form-label" for="">販売状況</label><p class="validation-mark align-self-start">*</p></div>
                            <select class="form-select" id="salesStatus" name="salesStatus">
                                <option disabled {{ old('salesStatus') === null ? 'selected' : '' }}>販売状況を選択</option>
                                <option value="3" {{ old('salesStatus') == 3 ? 'selected' : '' }}>発売予定</option>
                                <option value="1" {{ old('salesStatus') == 1 ? 'selected' : '' }}>販売中</option>
                                <option value="2" {{ old('salesStatus') == 2 ? 'selected' : '' }}>生産終了</option>                                
                            </select>
                        </div>
                        <div class="form-group-row">
                            <div class="form-title"><label class="form-label" for="">発売日</label><p class="validation-mark align-self-start">*</p></div>
                            <input type="date" class="form-control form-date" id="salesDate" name="salesDate" value="{{ old('salesDate') }}">
                        </div>

                        <div class="form-group-clm">
                            <div class="form-title"><label class="form-label" for="detail">商品紹介</label></div>
                            <textarea class="form-control form-text" name="detail" id="detail" placeholder="商品紹介文を入力">{{ old('detail') }}</textarea>
                        
                        </div>

                        
                        <div class="stock-form">
                            <div class="form-group-row">
                                <div class="stock-title"><label class="form-label" for="detail">在庫数</label><p class="validation-mark align-self-start">*</p></div>
                                <input type="text" class="form-control stock-num" id="stock" name="stock" placeholder="0" value="{{ old('stock') }}">
                                <p class="stock-unit">個</p>
                            </div>

                            @if($auth_user->role === 1)
                            <div class="form-group-row d-inline-flex">
                                <div class="stock-title"><label class="form-label" for="detail">基準在庫数</label><p class="validation-mark align-self-start">*</p></div>
                                <input type="text" class="form-control stock-num" id="sdStock" name="sdStock" value="{{ old('sdStock', 5) ?: 0 }}">
                                <p class="stock-unit">個</p>
                            </div>
                            @else
                            <div class="form-group-row d-flex">
                                <div class="stock-title"><label class="form-label" for="detail">基準在庫数</label></div>
                                <input type="text" class="form-control" value="5" readonly>
                                <input type="hidden" class="form-control stock-num" id="sdStock" name="sdStock" value="5">
                                <p class="stock-unit">個</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
@stop

@section('js')
@stop
