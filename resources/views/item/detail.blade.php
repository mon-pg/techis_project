@extends('adminlte::page')

@section('title', 'StockShelf')

@section('content_header')
<div class="text-center">
    <div class="row">
        <div class="col col-sm-auto"><!-- TODO:バリデーションかかったときどうする？homeから飛んだ時どうする？ -->
            <a href="#" class="btn-back" onclick="history.back()">戻る</a>
        </div>
        <h1 class="col-md-auto">商品詳細</h1>
    </div>
</div>
@stop

@section('content')

    <div class="row">
        <div class="col-md-10">

            <div class="card card-primary">
                
                    <div class="card-body">
                        
                        <div class="form-group">
                            <div class="d-inline-flex">
                                <label>タイトル：</label>
                                <p>{{ $item->title }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="d-inline-flex">
                                <label>ジャンル：</label>
                                <p>{{$types[$item->type]}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-inline-flex">
                                <label>販売状況：</label>
                                <p>{{$sales[$item->salesStatus]}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-inline-flex">
                                <label>発売日：</label>
                                <p>{{$item->salesDate ? $item->salesDate->format('Y/m/d') : '未定'}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <label>商品紹介：</label>
                                <textarea readonly>{{$item->detail}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-inline-flex">
                                <label>在庫数：</label>
                                <p>{{$item->stock}}個</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-inline-flex">
                                <label>基準在庫数：</label>
                                <p>{{$item->sdStock}}個</p>
                            </div>
                        </div>
                        
                    </div>
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
