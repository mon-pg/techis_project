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
            <div class="card h-100 w-100" style="max-width: 800px;">
                <div class="row g-0 h-100">
                    <div class="col-md-3">
                        <img src="{{ empty($item->image) ? asset('img/noImage.jpg') : $item->image }}" 
                            class="img-fluid rounded-start h-100" 
                            alt="商品紹介画像" style="object-fit: cover;">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body d-flex flex-column h-100">
                            <h3 class="card-title detail-title">{{ $item->name }}</h3>
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
            </div>
        </main>
    </div>
    
</body>
</html>
