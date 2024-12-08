@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
    <p class="h2">商品検索</p>
@include('item.search')
    <p class="h2">在庫状況</p><!-- TODO:表示する商品がないとき（在庫不足の商品がないときの挙動を追加する） -->
        @if(!empty($items[0]))
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
                                                @if( $item->stock >= $item->sdStock)
                                                    <td>現在、在庫が不足している商品はありません。</td>
                                                @else                                                    
                                                <td>{{ $item->id }}</td>
                                                <td><a href="{{ url('/view/items/'.$item->id) }}">{{ $item->name }}</a></td>
                                                <td>{{ $types[$item->type] }}</td>
                                                <td>
                                                    @if( $item->stock === 0 )
                                                        在庫なし×
                                                    @else
                                                        在庫不足△
                                                    @endif
                                                </td>
                                                @endif
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
        @if(!empty($logs[0]))
            <table>
                @foreach($logs as $log)
                <tr>
                    <td>{{ $log->created_at }}</td>
                    <td><p>{{ $log->user_id }}が{{ $log->target_id }}を変更しました。</p></td>
                </tr>
                @endforeach
            </table>
        @else
            <p>現在、表示するログはありません。</p>
        @endif


@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
