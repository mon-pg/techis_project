<form action="{{ url('/items/search') }}" method="get">
            @csrf
        @if(!empty($searchError))
            <p>{{ $searchError }}</p>
        @endif
        <div class="d-inline-flex mb-3">
            <div class="d-flex flex-column">
                <input class="form-control" type="search" name="sKeywords" placeholder="キーワード　検索"
                    value="{{ isset($sKeywords) ? $sKeywords : '' }}">
            <div class="d-flex">
                <p class="mini-title">ジャンル：</p>
                <div class="checkbox mr-2">
                    <input type="checkbox" name="type[]" id="type1" value="1" {{ isset($sType) && in_array("1", $sType) ? 'checked' : '' }}>
                    <label for="type1">RPG</label>
                </div>
                <div class="checkbox mr-2">
                    <input type="checkbox" name="type[]" id="type2" value="2" {{ isset($sType) && in_array("2", $sType) ? 'checked' : '' }}>
                    <label for="type2">対戦</label>
                </div>
                <div class="checkbox mr-2">
                    <input type="checkbox" name="type[]" id="type3" value="3" {{ isset($sType) && in_array("3", $sType) ? 'checked' : '' }}>
                    <label for="type3">育成</label>
                </div>
                <div class="checkbox mr-2">
                    <input type="checkbox" name="type[]" id="type4" value="4" {{ isset($sType) && in_array("4", $sType) ? 'checked' : '' }}>
                    <label for="type4">パーティ</label>
                </div>
                <div class="checkbox mr-2">
                    <input type="checkbox" name="type[]" id="type5" value="5" {{ isset($sType) && in_array("5", $sType) ? 'checked' : '' }}>
                    <label for="type5">その他</label>
                </div>
            </div>
                <div class="search-content d-flex">
                    <p class="mini-title">絞り込み：</p>
                    <div class="form-floating">
                        <select class="form-select" name="sSalesStatus">
                            @if(isset($sSalesStatus))
                            <option value="{{ $sSalesStatus }}" selected>{{ $sales[$sSalesStatus] }}</option>
                            <option value="">販売状況を選択</option>
                            @else
                            <option value="" selected>販売状況を選択</option>
                            @endif
                            <option value="1">販売中</option>
                            <option value="2">生産終了</option>
                            <option value="3">発売予定</option>
                            <option value="4">未定</option>
                        </select>
                    </div>
                    <div class="form-floating">
                        <select class="form-select" name="sStockStatus">
                            @if(isset($sStockStatus))
                            <option value="{{ $sStockStatus }}" selected>{{ $stockStatuses[$sStockStatus] }}</option>
                            <option value="">在庫状況を選択</option>
                            @else
                            <option value="" selected>在庫状況を選択</option>
                            @endif
                            <option value="1">在庫あり〇</option>
                            <option value="2">在庫不足△</option>
                            <option value="3">在庫なし✕</option>
                        </select>
                    </div>
                </div>
                <div class="search-content d-flex">
                    <p class="mini-title">発売期間：</p>
                    <input type="date" name="start" value="{{ isset($start) ? $start : '' }}">
                    <p>～</p>
                    <input type="date" name="end" value="{{ isset($end) ? $end : '' }}">
                </div>
                
            </div>
            <button class="btn btn-secondary align-self-start" type="submit">検索</button>
        </div>
</form>