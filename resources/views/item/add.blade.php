@extends('adminlte::page')

@section('title', '商品登録')

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
                        <div class="form-group">
                            <label for="name">タイトル</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="タイトル" value="{{ old('name') }}">
                        </div>

                        <div class="form-group d-flex">
                            <label for="type">ジャンル</label>
                            <select class="form-select" id="type" name="type">
                                <option disabled {{ old('type') === null ? 'selected' : '' }}>ジャンルを選択</option>
                                <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>RPG</option>
                                <option value="2" {{ old('type') == 2 ? 'selected' : '' }}>対戦</option>
                                <option value="3" {{ old('type') == 3 ? 'selected' : '' }}>育成</option>
                                <option value="4" {{ old('type') == 4 ? 'selected' : '' }}>パーティ</option>
                                <option value="5" {{ old('type') == 5 ? 'selected' : '' }}>その他</option>
                            </select>
                        </div>
                        <div class="form-group d-flex">
                            <label for="salesStatus">販売状況</label>
                            <select class="form-select" id="salesStatus" name="salesStatus">
                                <option disabled {{ old('salesStatus') === null ? 'selected' : '' }}>販売状況を選択</option>
                                <option value="3" {{ old('salesStatus') == 3 ? 'selected' : '' }}>発売予定</option>
                                <option value="1" {{ old('salesStatus') == 1 ? 'selected' : '' }}>販売中</option>
                                <option value="2" {{ old('salesStatus') == 2 ? 'selected' : '' }}>生産終了</option>                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="salesDate">発売日</label>
                            <input type="date" class="form-control" id="salesDate" name="salesDate" value="{{ old('salesDate') }}">
                        </div>

                        <div class="form-group">
                            <label for="detail">商品紹介</label>
                            <input type="text" class="form-control" id="detail" name="detail" placeholder="商品紹介" value="{{ old('detail') }}">
                        </div>

                        
                        <div class="d-flex gap-1">
                            <div class="form-group d-flex">
                                <label for="stock">在庫数</label>
                                <input type="text" class="form-control" id="stock" name="stock" placeholder="0" value="{{ old('stock') }}">
                                <p>個</p>
                            </div>

                            @if($auth_user->role === 1)
                            <div class="form-group d-inline-flex">
                                <label for="sdStock">基準在庫数</label>
                                <input type="text" class="form-control" id="sdStock" name="sdStock" value="{{ old('sdStock', 5) ?: 0 }}">
                                <p>個</p>
                            </div>
                            @else
                            <div class="form-group d-flex">
                                <label for="sdStock">基準在庫数</label>
                                <input type="text" class="form-control" value="5" readonly>
                                <input type="hidden" class="form-control" id="sdStock" name="sdStock" value="5">
                                <p>個</p>
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
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
@stop

@section('js')
@stop
