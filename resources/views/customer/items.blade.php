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
                    <h1>商品一覧</h1>
                    @if(isset($searchError))
                        <p class="error-msg-search container">{{ $searchError }}</p>
                    @endif
                    @include('customer.search')
            </div>
            <div class="container">
            @if(empty($findNoItem))
                <div class="card-area d-flex flex-wrap gap-5">
                @foreach($items as $item)
               
                    <a class="card items-card" href="{{ url('/view/items/detail/'.$item->id) }}">
                        @if(empty($item->image))
                            <img src="{{asset('img/noImage.jpg')}}" class="card-img-top" alt="商品画像">
                        @else
                            <img src="{{ json_decode($item->image, true)[0]['url'] }}" class="card-img-top" alt="商品画像">
                        @endif
                        <div class="card-body items-card-body">
                            <h5 class="card-title items-card-title">{{ $item->title }}</h5>
                            <p class="card-text items-card-text">{{ $item->detail }}</p>
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
                <div class="page-footer">
                {{ $items->links('vendor.pagination.StockShelf') }}                
                </div>
            @else
                <h3 class="container">{{ $findNoItem }}</h3>
            @endif
            </div>
            
        @else
            <p class="text-center">coming soon...</p>
        @endif
        </main>
    </div>
    
</body>
</html>

