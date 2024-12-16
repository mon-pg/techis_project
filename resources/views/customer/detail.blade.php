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
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

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

        <main class="py-4 w-100">
        <div class="row">
        <div class="container-sm col col-sm-auto"><!-- TODO:バリデーションかかったときどうする？homeから飛んだ時どうする？ -->
            <a href="#" class="btn-back" onclick="history.back()">戻る</a>
        </div>
        <div class="col-md-10">
        <h1>商品詳細</h1>
            <div class="card card-primary">
                
                    <div class="card-body">
                        
                        <div class="form-group">
                            <h2>{{ $item->name }}</h2>
                        </div>

                        <div class="form-group">
                            <div class="d-inline-flex">
                                <label for="name">ジャンル：</label>
                                <p>{{$types[$item->type]}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-inline-flex">
                                <label for="name">販売状況：</label>
                                <p>{{$sales[$item->salesStatus]}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-inline-flex">
                                <label for="name">発売日：</label>
                                <p>{{$item->salesDate ? $item->salesDate->format('Y/m/d') : '未定'}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <label for="name">商品紹介：</label>
                                <p>{{$item->detail}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-inline-flex">
                                <label for="name">在庫状況：</label>
                                @if($item->stock > $item->sdStock)
                                    <p>在庫あり〇</p>
                                @elseif($item->stock === 0)
                                    <p>在庫なし✕</p>
                                @else
                                    <p>残りわずか△</p>
                                @endif
                            </div>
                        </div>
                            
                            
                    </div>
                </div>
            </div>
        </div>
        </main>
    </div>
    
</body>
</html>
