<form action="{{ url('/items/search') }}" method="get" class="container form-wrapper">
            @csrf
        @if(!empty($searchError))
            <p>{{ $searchError }}</p>
        @endif
        <div class="d-flex flex-wrap gap-2 mb-3">
            <div class="search-area flex-grow-3">
                <input class="form-control mb-3 keyword" type="search" name="sKeywords" placeholder="キーワード　検索"
                    value="{{ request('sKeywords') }}">
            <div class="search-content">
                <p class="mini-title">ジャンル：</p>
                <div class="checkbox me-3">
                    <input type="checkbox" name="type[]" id="type1" value="1" {{ isset($sType) && in_array("1", $sType) ? 'checked' : '' }}>
                    <label for="type1">RPG</label>
                </div>
                <div class="checkbox me-3">
                    <input type="checkbox" name="type[]" id="type2" value="2" {{ isset($sType) && in_array("2", $sType) ? 'checked' : '' }}>
                    <label for="type2">対戦</label>
                </div>
                <div class="checkbox me-3">
                    <input type="checkbox" name="type[]" id="type3" value="3" {{ isset($sType) && in_array("3", $sType) ? 'checked' : '' }}>
                    <label for="type3">育成</label>
                </div>
                <div class="checkbox me-3">
                    <input type="checkbox" name="type[]" id="type4" value="4" {{ isset($sType) && in_array("4", $sType) ? 'checked' : '' }}>
                    <label for="type4">パーティ</label>
                </div>
                <div class="checkbox me-3">
                    <input type="checkbox" name="type[]" id="type5" value="5" {{ isset($sType) && in_array("5", $sType) ? 'checked' : '' }}>
                    <label for="type5">その他</label>
                </div>
            </div>
                <div class="search-content">
                    <p class="mini-title">絞り込み：</p>
                    <select class="form-select me-2 w-auto" name="sSalesStatus">
                        @if(!empty(request('sSalesStatus')))
                        <option value="{{ request('sSalesStatus') }}" selected>{{ $sales[request('sSalesStatus')]}}</option>                            
                        @endif
                        <option value="" >販売状況を選択</option>
                        <option value="1">販売中</option>
                        <option value="2">生産終了</option>
                        <option value="3">発売予定</option>
                        <option value="4">未定</option>
                    </select>
                    <select class="form-select w-auto" name="sStockStatus">
                        @if(!empty(request('sStockStatus')))
                        <option value="{{ request('sStockStatus') }}" selected>{{ $stockStatuses[request('sStockStatus')]}}</option>                            
                        @endif
                        <option value="">在庫状況を選択</option>
                        <option value="1">在庫あり〇</option>
                        <option value="2">在庫不足△</option>
                        <option value="3">在庫なし✕</option>
                    </select>
                </div>
                <div class="search-content">
                    <p class="mini-title">発売期間：</p>
                    <input type="date" class="form-control me-1 w-auto" name="start" value="{{ isset($start) ? $start : '' }}">
                    <p class="me-1">～</p>
                    <input type="date" class="form-control w-auto" name="end" value="{{ isset($end) ? $end : '' }}">
                </div>
                
            </div>
            <button class="btn btn-secondary align-self-start" type="submit">検索</button>
        </div>
</form>