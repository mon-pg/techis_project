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
<!--     @if (!empty($passwords[0]))
    <p>あるよ</p>
    @foreach($passwords as $password)
        <p>{{ $password }}</p>
    @endforeach
    @else
    <p>ないよ</p>
    @endif -->
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
        @if(!empty($items[0]))
        <div class="main-area container">
                <p>商品検索</p>
                @include('item.search')

                <div class="row">
                    <div class="col-12">
                        <div class="card">            
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>タイトル</th>
                                            <th>ジャンル</th>
                                            <th>発売日</th>
                                            <th>商品紹介</th>
                                            <th>在庫状況</th>
                                            
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr>
                                                <td><a href="{{ url('/view/items/'.$item->id) }}">{{ $item->name }}</a></td>
                                                <td>{{ $types[$item->type] }}</td>
                                                <td>
                                                    @if(!empty($item->salesDate))
                                                        {{ $item->salesDate->format('Y/m/d') }}
                                                    @else
                                                        <p>未定</p>
                                                    @endif
                                                </td>
                                                <td class="detail-area">{{ $item->detail }}</td>
                                                <td>
                                                    @if( $item->stock >= $item->sdStock)
                                                        〇
                                                    @elseif( $item->stock === 0 )
                                                        ✕
                                                    @else
                                                        △
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <p class="text-center">coming soon...</p>
        @endif
        </main>
    </div>
    
</body>
</html>

