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

        <main class="py-4 w-100">
        @if(empty($noItem))
        <div class="main-area container">
                <h1>商品検索</h1>
                @include('customer.search')
        </div>
            <div class="container">
            @if(empty($findNoItem))
                <div class="card-area d-flex flex-wrap gap-5">
                @foreach($items as $item)
               
                    <a class="card" href="{{ url('/view/items/detail/'.$item->id) }}">
                        
                        <img src="{{ empty($item->image) ? asset('img/noImage.jpg') : $item->image }}" class="card-img-top" alt="商品画像">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text">{{ $item->detail }}</p>
                        </div>
                        <ul class="list-group list-group-flush">                            
                            <li class="list-group-item">発売日：{{ $item->salesDate->format('Y/m/d') }}</li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <p>ジャンル：{{ $types[$item->type] }}</p>
                                    @if($item->stock >= $item->sdStock)
                                        <p>在庫〇</p>
                                    @elseif($item->stock === 0)
                                        <p>在庫✕</p>
                                    @else
                                        <p>在庫△</p>
                                    @endif
                                </div>
                                
                            </li>
                        </ul>
                    </a>
                
                @endforeach
                </div>
                <div class="card-footer">
                {{ $items->links('vendor.pagination.StockShelf') }}                
                </div>
            @else
                <p>{{ $findNoItem }}</p>
            @endif
            </div>
            
        @else
            <p class="text-center">coming soon...</p>
        @endif
        </main>
    </div>
    
</body>
</html>

