@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品管理一覧</h1>
@stop

@section('content')

@include('item.modal')

@include('item.search')

@if(!empty($items[0]))
    <div class="row">
        <div class="col-12">
            <div class="card">            
                <div class="card-header d-flex justify-content-between">
                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" > 一括削除 </a>
                    <p class="flex-grow-1"></p>
                    <a href="{{ url('items/add') }}" class="btn btn-primary">商品登録</a>    
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>
                                    <div class="d-inline-flex flex-row-reverse">
                                        <input class="form-check-input select-item" type="checkbox" id="all">
                                        <label class="form-check-label mr-3 select-item" for="all">
                                            選択
                                        </label>
                                    </div>
                                </th>
                                <th>ID</th>
                                <th>タイトル</th>
                                <th>ジャンル</th>
                                <th>販売状況</th>
                                <th>在庫状況</th>
                                <th>最終更新日</th>
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td class="text-center"><input type="checkbox" class="delete-check select-item" name="delete-check[]" value="{{ $item->id }}"></td>
                                
                                    <td>{{ $item->id }}</td>
                                    <td><a href="{{ url('/items/'.$item->id) }}">{{ $item->name }}</a></td>
                                    <td>{{ $types[$item->type] }}</td>
                                    <td>{{ $sales[$item->salesStatus] }}</td>
                                    <td>
                                        @if( $item->stock >= $item->sdStock)
                                            在庫あり〇
                                        @elseif( $item->stock === 0 )
                                            在庫なし×
                                        @else
                                            在庫不足△
                                        @endif
                                    </td>
                                    <td>{{ $item->updated_at->format('Y/m/d') }}</td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@else
    <p>表示できる商品がありません。</p>
    <p>商品登録は<a href="{{ url('items/add') }}">こちら</a>から。</p>
@endif
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stop

@section('js')
<script src="{{ asset('js/item.js') }}"></script>
@stop

