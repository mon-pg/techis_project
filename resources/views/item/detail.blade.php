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
        <div class="col col-sm-auto"></div>
        <div class="col-md-10">
            <div class="card card-primary">
                    <div class="card-body">
                        <div class="form-group-row">
                            <div class="form-title"><label class="form-label" for="title">タイトル：</label></div>
                            <p>{{ $item->title }}</p>
                        </div>

                        <div class="form-group-row ">
                            <div class="form-title"><label class="form-label" for="">ジャンル：</label></div>
                            <p>{{$types[$item->type]}}</p>
                        </div>
                        <div class="form-group-row ">
                            <div class="form-title"><label class="form-label" for="">販売状況：</label></div>
                            <p>{{$sales[$item->salesStatus]}}</p>
                        </div>
                        <div class="form-group-row">
                            <div class="form-title"><label class="form-label" for="">発売日：</label></div>
                            <p>{{ $item->salesDate ? $item->salesDate->format('Y/m/d') : '' }}</p>
                        </div>

                        <div class="form-group-clm">
                            <div class="form-title"><label class="form-label" for="detail">商品紹介：</label></div>
                            <div class="detail-textarea"><p>{{ $item->detail }}</p></div>
                        </div>

                        
                        <div class="stock-form mt-3">
                            <div class="form-group-row">
                                <div class="stock-title"><label class="form-label" for="detail">在庫数：</label></div>
                                <p>{{ $item->stock }} 個</p>
                            </div>

                            <div class="form-group-row">
                                <div class="stock-title"><label class="form-label" for="detail">基準在庫数：</label></div>                                
                                <p>{{ $item->sdStock }} 個</p>
                            </div>
                        </div>
                        
                        @if($item->image != null)    
                            <div class="form-group-clm">
                                <div class="stock-title"><label class="form-label" for="detail">商品画像：</label></div>
                                <div class="slick-images">
                                    @foreach(json_decode($item->image, true) as $image)
                                    <div class="image-check">
                                        <img src="{{ $image['url'] }}" alt="商品画像" class="item-image">
                                    </div>
                                    @endforeach
                                </div>
                            </div>  
                        @else
                            <div class="form-group-row">
                                <div class="stock-title"><label class="form-label" for="detail">商品画像：</label></div>                             
                                <p>商品画像がアップロードされていません。</p>
                            </div>
                        @endif 
                    </div>                
            </div>

            <h2>更新ログ</h2>
            <div class="container">
                @if(isset($logs) && count($logs)>0)
                <div class="logs-area d-flex flex-column">
                    @foreach($logs as $log)
                    <div class="d-flex flex-wrap gap-2 log-area">
                        <div class="align-self-start">{{ $log->created_at->format('Y/m/d') }}</div>
                        <div class="flex-grow-1">
                            <p>
                                {{ $logUsers[$log->id] }}さんが、
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
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>
@stop

@section('js')
<script src="{{ asset('js/edit.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
<!-- Slick用に初期化 -->
<script>
$(document).ready(function(){
    $('.slick-images').slick({
        dots: true,               // 下部にドットを表示
        infinite: false,           // 無限ループ
        speed: 300,               // アニメーション速度
        slidesToShow: 3,          // 表示するスライド数
        slidesToScroll: 3,        // スクロールするスライド数
        autoplay: false,           // 自動再生
        autoplaySpeed: 2000,      // 自動再生の間隔 (ms)
        arrows: true,             // 前後ボタンの表示
        variableWidth: true, 
    });
});
</script>
@stop
