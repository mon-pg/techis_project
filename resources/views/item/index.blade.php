@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1 class="container">商品管理一覧</h1>
@stop

@section('content')

@include('item.modal')

@include('item.search')  



@if(isset($items) && count($items) > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">            
                <div class="card-header d-flex justify-content-between">
                    @if($auth_user->role == 1)
                        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" > 一括削除 </a>                    
                        <p class="flex-grow-1"></p>
                        <a href="{{ url('items/add') }}" class="btn btn-primary">商品登録</a>
                    @else
                        <p class="flex-grow-1"></p>
                        <p class="flex-grow-1"></p>
                        <a href="{{ url('items/add') }}" class="btn btn-primary">商品登録</a>
                    @endif    
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                @if($auth_user->role == 1)
                                <th>
                                    <div class="d-inline-flex flex-row-reverse">
                                        <input class="form-check-input select-item" type="checkbox" id="all">
                                        <label class="form-check-label mr-3 select-item" for="all">
                                            選択
                                        </label>
                                    </div>
                                </th>
                                @endif
                                <th>ID</th>
                                <th>タイトル</th>
                                <th>ジャンル</th>
                                <th>販売状況</th>
                                <th>在庫状況</th>
                                <th>発売日</th>
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    @if($auth_user->role == 1)
                                    <td class="text-center"><input type="checkbox" class="delete-check select-item" name="delete-check[]" value="{{ $item->id }}"></td>
                                    @endif
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        @if($auth_user->role == 1||$auth_user->role == 2)
                                        <a href="{{ url('/items/'.$item->id) }}">{{ $item->name }}</a>
                                        @elseif($auth_user->role == 3)
                                        <a href="{{ url('/items/detail/'.$item->id) }}">{{ $item->name }}</a>
                                        @endif
                                    </td>
                                    <td>{{ $types[$item->type] }}</td>
                                    <td>{{ $sales[$item->salesStatus] }}</td>
                                    <td>
                                        @if( $item->stock >= $item->sdStock)
                                            在庫あり〇
                                        @elseif( $item->stock === 0 )
                                            在庫なし✕
                                        @else
                                            在庫不足△
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($item->salesDate))
                                            {{ $item->salesDate->format('Y/m/d') }}
                                        @else
                                            <p>未定</p>
                                        @endif
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>                       
                    </table>
                </div>
                <div class="card-footer">
                {{ $items->links('vendor.pagination.StockShelf') }}  
                </div>
            </div>
        </div>
    </div>
    
@else
    @if(isset($noItem))
        <p>{{ $noItem }}</p>
    @else
        <p>表示できる商品がありません。</p>
        <p>商品登録は<a href="{{ url('items/add') }}">こちら</a>から。</p>
    @endif
@endif
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
@stop

@section('js')
<script src="{{ asset('js/item.js') }}"></script>
@stop

