<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- 企業名 -->
    <title>HorseGames</title>   

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/view/items') }}">
                    HorseGames
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container d-flex flex-column align-items-center gap-2 mt-5">
            <a href="#" class="btn-back align-self-start" onclick="history.back()">戻る</a>
            <div class="card detail-card h-100 w-100" style="max-width: 800px;">
                <div class="row">
                        @if(empty($item->image))
                            <div class="slick-images">
                                <img src="{{ asset('img/noImage.jpg') }}" class="item-image" alt="商品紹介画像">
                            </div>                        
                        @else
                            <div class="slick-images">
                                @foreach(json_decode($item->image, true) as $image)
                                <img src="{{ $image['url'] }}" alt="商品画像" class="item-image">
                                @endforeach
                            </div>
                        @endif
                    </div>
                <div class="row g-1 h-100">
                    <div class="card-body d-flex flex-column h-100 detail-card-body">
                        <h3 class="card-title detail-title">{{ $item->title }}</h3>
                        <div class="item-info flex-grow-1 d-flex flex-column justify-content-between">
                            <p class="card-text ">{{ $item->detail }}</p>
                            <p class="card-text d-flex justify-content-between">
                                <small class="text-body-secondary">{{ $item->salesDate->format('Y/m/d') }}発売</small>
                                <small class="text-body-secondary">{{ $types[$item->type] }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
<!-- Slick用に初期化 -->
<script>
$(document).ready(function(){
    $('.slick-images').slick({
        dots: true,               // 下部にドットを表示
        infinite: true,           // 無限ループ
        speed: 500,               // アニメーション速度
        slidesToShow: 1,          // 表示するスライド数
        slidesToScroll: 1,        // スクロールするスライド数
        autoplay: true,           // 自動再生
        autoplaySpeed: 4000,      // 自動再生の間隔 (ms)
        arrows: true,             // 前後ボタンの表示
        centerMode: true,
        variableWidth: true,  
    });
});
</script>
</body>
</html>
