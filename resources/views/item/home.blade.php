@extends('adminlte::page')

@section('title', 'StockShelf')

@section('content_header')
@stop

@section('content')
    <p class="h2 pt-3">商品検索</p>
    @include('item.search')
    <p class="h2">在庫状況</p>
        @if(isset($items) && count($items) > 0)
            <p>下記の商品在庫が不足しています。</p>
            <div class="row">
                <div class="col-12">
                    <div class="card">            
                        <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>タイトル</th>
                                            <th>ジャンル</th>
                                            <th>在庫状況</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr>                                                  
                                                <td>{{ $item->id }}</td>
                                                
                                                <td>
                                                    @if($auth_user->role == 1||$auth_user->role == 2)
                                                    <a href="{{ url('/items/'.$item->id) }}">{{ $item->title }}</a>
                                                    @elseif($auth_user->role == 3)
                                                    <a href="{{ url('/items/detail/'.$item->id) }}">{{ $item->title }}</a>
                                                    @endif
                                                </td>
                                                <td>{{ $types[$item->type] }}</td>
                                                <td>
                                                    @if( $item->stock == 0 )
                                                        在庫なし✕
                                                    @else
                                                        在庫不足△
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
        @else
            <p>現在、在庫が不足している商品はありません。</p>
        @endif
    <p class="h2">更新ログ</p>
        <div class="">
            @if(!empty($logs) && count($logs)>0)
            <div class="d-flex flex-column">
                @foreach($logs as $log)
                <div class="d-flex flex-wrap gap-2 log-area">
                    <div class="align-self-start">{{ $log->created_at->format('Y/m/d') }}</div>
                    <div class="flex-grow-1">
                        <p>
                            {{ $logUsers[$log->id][$log->user_id] }}さんが、
                            <a href="{{ url('/items/'.$log->target_id) }}">『{{ $logItems[$log->id][$log->target_id] }}』</a>
                            の
                            {{ implode('・', $log->action) }}
                            を変更しました。
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p>ログがありません。</p>
            @endif
        </div>
        


@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
