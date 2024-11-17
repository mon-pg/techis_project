@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品一覧</h1>
@stop

@section('content')

@include('item.modal')

    <div class="row">
        <div class="col-12">
            <div class="card">            
                <div class="card-header d-flex justify-content-between">
                    <a href="{{ url('items/add') }}" class="btn btn-primary">商品登録</a>
                    <p class="flex-grow-1"></p>
                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-url="{{ url('items/some_delete') }}" > 一括削除 </a>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>名前</th>
                                <th>種別</th>
                                <th>詳細</th>
                                <th>選択<input type="checkbox" name="all-check" id="all-check"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->detail }}</td>
                                    <td><input type="checkbox" class="delete-check" name="delete-check[]" data-title="{{ $item->name }}" value="{{ $item->id }}"></td>
                                
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
<script src="{{ asset('js/modal.js') }}"></script>
@stop

